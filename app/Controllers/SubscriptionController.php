<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\AuditLog;
use App\Core\Database;
use App\Models\Settings;
use App\Helpers\Mailer;
use App\Helpers\SmsHelper;

class SubscriptionController extends AdminController {

    public function index(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $db = Database::getConnection();
        $searchVal = '%' . trim($request->get('search', '')) . '%';
        
        if ($request->get('search')) {
            $stmt = $db->prepare("
                SELECT s.*, c.name as client_name, c.email as client_email, c.phone as client_phone 
                FROM subscriptions s 
                LEFT JOIN customers c ON s.customer_id = c.id 
                WHERE s.service_name LIKE :search OR c.name LIKE :search OR c.email LIKE :search
                ORDER BY s.next_due_date ASC
            ");
            $stmt->execute(['search' => $searchVal]);
        } else {
            $stmt = $db->query("
                SELECT s.*, c.name as client_name, c.email as client_email, c.phone as client_phone 
                FROM subscriptions s 
                LEFT JOIN customers c ON s.customer_id = c.id 
                ORDER BY CASE WHEN s.status = 'Active' THEN 0 WHEN s.status = 'Expired' THEN 1 ELSE 2 END, s.next_due_date ASC
            ");
        }
        
        $subscriptions = $stmt->fetchAll();

        return $this->render('admin/subscriptions/index', [
            'title' => 'Subscriptions Management - ISEC CMS',
            'subscriptions' => $subscriptions
        ]);
    }

    public function create(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $db = Database::getConnection();
        $customers = $db->query("SELECT id, name, email FROM customers ORDER BY name ASC")->fetchAll();
        
        return $this->render('admin/subscriptions/form', [
            'title' => 'Add Subscription - ISEC CMS',
            'subscription' => null,
            'customers' => $customers
        ]);
    }

    public function store(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();
        $db = Database::getConnection();

        $customerId = $request->get('customer_id');
        $serviceName = trim($request->get('service_name'));
        $providerPlatform = trim($request->get('provider_platform'));
        $cost = (float)$request->get('cost', 0);
        $billingCycle = $request->get('billing_cycle', 'Yearly');
        $startDate = $request->get('start_date');
        $nextDueDate = $request->get('next_due_date');
        $status = $request->get('status', 'Active');
        $notifyClient = $request->get('notify_client') ? 1 : 0;
        $notifyOffice = $request->get('notify_office') ? 1 : 0;

        if (empty($serviceName) || empty($startDate) || empty($nextDueDate)) {
            $session->setFlash('error', 'Service Name, Start Date, and Next Due Date are required.');
            $response->redirect('/admin/subscriptions/create');
            return;
        }

        $stmt = $db->prepare("
            INSERT INTO subscriptions (customer_id, service_name, provider_platform, cost, billing_cycle, start_date, next_due_date, status, notify_client, notify_office)
            VALUES (:customer_id, :service_name, :provider_platform, :cost, :billing_cycle, :start_date, :next_due_date, :status, :notify_client, :notify_office)
        ");

        $stmt->execute([
            'customer_id' => $customerId ?: null,
            'service_name' => $serviceName,
            'provider_platform' => $providerPlatform,
            'cost' => $cost,
            'billing_cycle' => $billingCycle,
            'start_date' => $startDate,
            'next_due_date' => $nextDueDate,
            'status' => $status,
            'notify_client' => $notifyClient,
            'notify_office' => $notifyOffice
        ]);

        AuditLog::log(current_user()['id'], 'Create Subscription', 'Added subscription: ' . $serviceName);
        $session->setFlash('success', 'Subscription created successfully.');
        $response->redirect('/admin/subscriptions');
    }

    public function edit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM subscriptions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $subscription = $stmt->fetch();

        if (!$subscription) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        $customers = $db->query("SELECT id, name, email FROM customers ORDER BY name ASC")->fetchAll();

        return $this->render('admin/subscriptions/form', [
            'title' => 'Edit Subscription - ISEC CMS',
            'subscription' => $subscription,
            'customers' => $customers
        ]);
    }

    public function update(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $session = new Session();
        $db = Database::getConnection();

        $customerId = $request->get('customer_id');
        $serviceName = trim($request->get('service_name'));
        $providerPlatform = trim($request->get('provider_platform'));
        $cost = (float)$request->get('cost', 0);
        $billingCycle = $request->get('billing_cycle', 'Yearly');
        $startDate = $request->get('start_date');
        $nextDueDate = $request->get('next_due_date');
        $status = $request->get('status', 'Active');
        $notifyClient = $request->get('notify_client') ? 1 : 0;
        $notifyOffice = $request->get('notify_office') ? 1 : 0;

        if (empty($serviceName) || empty($startDate) || empty($nextDueDate)) {
            $session->setFlash('error', 'Service Name, Start Date, and Next Due Date are required.');
            $response->redirect('/admin/subscriptions/edit/' . $id);
            return;
        }

        $stmt = $db->prepare("
            UPDATE subscriptions SET 
                customer_id = :customer_id, 
                service_name = :service_name, 
                provider_platform = :provider_platform, 
                cost = :cost, 
                billing_cycle = :billing_cycle, 
                start_date = :start_date, 
                next_due_date = :next_due_date, 
                status = :status, 
                notify_client = :notify_client, 
                notify_office = :notify_office 
            WHERE id = :id
        ");

        $stmt->execute([
            'customer_id' => $customerId ?: null,
            'service_name' => $serviceName,
            'provider_platform' => $providerPlatform,
            'cost' => $cost,
            'billing_cycle' => $billingCycle,
            'start_date' => $startDate,
            'next_due_date' => $nextDueDate,
            'status' => $status,
            'notify_client' => $notifyClient,
            'notify_office' => $notifyOffice,
            'id' => $id
        ]);

        AuditLog::log(current_user()['id'], 'Update Subscription', 'Updated subscription ID: ' . $id);
        $session->setFlash('success', 'Subscription updated successfully.');
        $response->redirect('/admin/subscriptions');
    }

    public function delete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM subscriptions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        AuditLog::log(current_user()['id'], 'Delete Subscription', 'Deleted subscription ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Subscription deleted successfully.');
        $response->redirect('/admin/subscriptions');
    }

    public function sendReminder(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();
        
        $id = (int)$request->get('subscription_id');
        $templateType = $request->get('template_type'); // '14_days' or '0_days'
        $channels = $_POST['channels'] ?? []; // array

        if (!$id || empty($channels)) {
            $session->setFlash('error', 'Subscription ID and at least one channel are required.');
            $response->redirect('/admin/subscriptions');
            return;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT s.*, c.name as client_name, c.email as client_email, c.phone as client_phone 
            FROM subscriptions s 
            LEFT JOIN customers c ON s.customer_id = c.id 
            WHERE s.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $sub = $stmt->fetch();

        if (!$sub) {
            $session->setFlash('error', 'Subscription not found.');
            $response->redirect('/admin/subscriptions');
            return;
        }

        $currency = Settings::get('currency_symbol', '₦');
        $costFormatted = $currency . number_format($sub['cost'], 2);
        
        $dueDate = new \DateTime($sub['next_due_date']);
        $replacements = [
            '{client_name}' => $sub['client_name'] ?? 'Client',
            '{service_name}' => $sub['service_name'],
            '{due_date}' => $dueDate->format('M d, Y'),
            '{cost}' => $costFormatted
        ];

        $sentCount = 0;

        if (in_array('Email', $channels) && !empty($sub['client_email'])) {
            $templateKey = 'sub_email_' . $templateType;
            if ($templateType === '14_days') $defaultTpl = "Dear {client_name},\n\nThis is a 14-day reminder for your subscription: {service_name}.\nAmount Due: {cost}\nDue Date: {due_date}\n\nPlease ensure payment is made promptly.\n\nThank you.";
            elseif ($templateType === '7_days') $defaultTpl = "Dear {client_name},\n\nThis is a 7-day reminder for your subscription: {service_name}.\nAmount Due: {cost}\nDue Date: {due_date}\n\nPlease ensure payment is made promptly.\n\nThank you.";
            elseif ($templateType === '0_days') $defaultTpl = "Dear {client_name},\n\nURGENT: Your subscription {service_name} is due TODAY.\nAmount Due: {cost}\nDue Date: {due_date}\n\nPlease ensure payment is made immediately to avoid disruption.\n\nThank you.";
            else $defaultTpl = "Dear {client_name},\n\nYour subscription {service_name} is OVERDUE.\nAmount Due: {cost}\nOriginal Due Date: {due_date}\n\nPlease pay immediately.\n\nThank you.";
            
            $body = strtr(Settings::get($templateKey, $defaultTpl), $replacements);
            
            if ($templateType === '14_days') $subject = "Upcoming Renewal (14 Days): {$sub['service_name']}";
            elseif ($templateType === '7_days') $subject = "Upcoming Renewal (7 Days): {$sub['service_name']}";
            elseif ($templateType === '0_days') $subject = "URGENT Renewal (Due Today): {$sub['service_name']}";
            else $subject = "OVERDUE Subscription: {$sub['service_name']}";
            
            // Format as HTML since Mailer uses HTML content-type
            $htmlBody = "<h3>$subject</h3><p>" . nl2br($body) . "</p>";
            Mailer::send('no-reply@isecltd.ng', $sub['client_email'], $subject, $htmlBody);
            $sentCount++;
        }

        if (in_array('SMS', $channels) && !empty($sub['client_phone'])) {
            $templateKey = 'sub_sms_' . $templateType;
            if ($templateType === 'overdue') $defaultTpl = "URGENT: Your subscription {service_name} of {cost} is OVERDUE. Please pay immediately. - ISEC";
            else $defaultTpl = "Reminder: Your subscription {service_name} of {cost} is due on {due_date}. Please pay promptly. - ISEC";
            
            $body = strtr(Settings::get($templateKey, $defaultTpl), $replacements);
            SmsHelper::sendSms($sub['client_phone'], $body);
            $sentCount++;
        }

        if (in_array('WhatsApp', $channels) && !empty($sub['client_phone'])) {
            $templateKey = 'sub_wa_' . $templateType;
            if ($templateType === 'overdue') $defaultTpl = "URGENT {client_name}, your subscription {service_name} is OVERDUE. Amount Due: {cost}. Please pay immediately to avoid disruption.";
            else $defaultTpl = "Hello {client_name}, this is a reminder for your subscription {service_name}. Amount Due: {cost} on {due_date}.";
            
            $body = strtr(Settings::get($templateKey, $defaultTpl), $replacements);
            SmsHelper::sendWhatsApp($sub['client_phone'], $body);
            $sentCount++;
        }

        AuditLog::log(current_user()['id'], 'Send Manual Reminder', "Sent manual reminder for subscription: {$sub['service_name']}");
        $session->setFlash('success', "Manual reminder sent through $sentCount channel(s).");
        $response->redirect('/admin/subscriptions');
    }
}
