<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Payment;
use App\Models\AuditLog;
use App\Helpers\SmsHelper;
use PDO;

class CrmController extends AdminController {

    public function index(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $db = Payment::getDB();
        
        // Fetch all customers
        $stmt = $db->query("SELECT * FROM customers ORDER BY created_at DESC");
        $customers = $stmt->fetchAll();

        // Count total customers
        $totalCustomers = count($customers);

        // Fetch recent campaigns
        $campaignsStmt = $db->query("SELECT * FROM campaigns ORDER BY sent_at DESC LIMIT 5");
        $recentCampaigns = $campaignsStmt->fetchAll();

        return $this->render('admin/crm/index', [
            'title' => 'CRM & Marketing',
            'customers' => $customers,
            'totalCustomers' => $totalCustomers,
            'recentCampaigns' => $recentCampaigns
        ]);
    }

    public function campaigns(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $db = Payment::getDB();
        
        // Fetch all campaigns
        $stmt = $db->query("SELECT c.*, u.name as sender_name FROM campaigns c LEFT JOIN users u ON c.sent_by = u.id ORDER BY c.sent_at DESC");
        $campaigns = $stmt->fetchAll();

        return $this->render('admin/crm/campaigns', [
            'title' => 'Marketing Campaigns',
            'campaigns' => $campaigns
        ]);
    }

    public function sendCampaign(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        
        $type = $request->post('type');
        $subject = $request->post('subject');
        $message = $request->post('message');
        
        if (empty($type) || empty($message)) {
            $session = new \App\Core\Session();
            $session->setFlash('error', 'Campaign type and message are required.');
            $response->redirect('/admin/crm/campaigns');
            return;
        }

        $successCount = 0;
        $status = 'Failed';
        $campaignId = 0;
        
        try {
            $db = Payment::getDB();
            
            // Insert Campaign record
            $stmt = $db->prepare("INSERT INTO campaigns (type, subject, message, status, sent_by, sent_at) VALUES (?, ?, ?, 'Pending', ?, NOW())");
            $stmt->execute([$type, $subject, $message, current_user()['id']]);
            $campaignId = $db->lastInsertId();

            // Fetch all customers
            $customers = $db->query("SELECT * FROM customers")->fetchAll();
            
            if ($type === 'Email') {
                if (empty($subject)) {
                    $subject = "Update from ISEC Limited";
                }
                foreach ($customers as $customer) {
                    if (!empty($customer['email'])) {
                        $htmlContent = "<div style='font-family:sans-serif; max-width:600px; margin:0 auto;'><h2>Hello {$customer['name']},</h2><p>" . nl2br(e($message)) . "</p></div>";
                        \App\Helpers\Mailer::send('info@isecltd.ng', $customer['email'], $subject, $htmlContent, 'ISEC Limited');
                        $successCount++;
                    }
                }
                $status = 'Sent';
            } else if ($type === 'SMS') {
                foreach ($customers as $customer) {
                    if (!empty($customer['phone'])) {
                        SmsHelper::sendSms($customer['phone'], $message);
                        $successCount++;
                    }
                }
                $status = 'Sent';
            } else if ($type === 'WhatsApp') {
                foreach ($customers as $customer) {
                    if (!empty($customer['phone'])) {
                        SmsHelper::sendWhatsApp($customer['phone'], $message);
                        $successCount++;
                    }
                }
                $status = 'Sent';
            }
        } catch (\Throwable $e) {
            $session = new \App\Core\Session();
            $session->setFlash('error', 'Campaign failed: ' . $e->getMessage());
            
            // Mark campaign as failed if we have an ID
            if ($campaignId) {
                $db->prepare("UPDATE campaigns SET status = 'Failed' WHERE id = ?")->execute([$campaignId]);
            }
            $response->redirect('/admin/crm/campaigns');
            return;
        }

        // Update campaign status
        $db->prepare("UPDATE campaigns SET status = ? WHERE id = ?")->execute([$status, $campaignId]);

        $session = new \App\Core\Session();
        $session->setFlash('success', "Campaign ($type) successfully sent to $successCount customers.");
        $response->redirect('/admin/crm/campaigns');
    }
    public function customerStore(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new \App\Core\Session();
        $name = trim($request->get('name'));
        $email = trim($request->get('email'));
        $phone = trim($request->get('phone'));

        if (empty($name) || empty($email)) {
            $session->setFlash('error', 'Name and Email are required.');
            $response->redirect('/admin/crm');
            return;
        }

        $db = Payment::getDB();
        
        // Check if email already exists
        $stmt = $db->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $session->setFlash('error', 'A customer with this email already exists.');
            $response->redirect('/admin/crm');
            return;
        }

        $stmt = $db->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $phone]);

        AuditLog::log(current_user()['id'], 'Create Customer', "Added new CRM customer: $name");
        $session->setFlash('success', 'Client added successfully.');
        $response->redirect('/admin/crm');
    }

    public function customerDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $session = new \App\Core\Session();
        $id = (int)($params['id'] ?? 0);
        
        $db = Payment::getDB();
        $db->prepare("DELETE FROM customers WHERE id = ?")->execute([$id]);
        
        AuditLog::log(current_user()['id'], 'Delete Customer', "Deleted CRM customer ID: $id");
        $session->setFlash('success', 'Client deleted successfully.');
        $response->redirect('/admin/crm');
    }
}
