<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Payment;
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
            $this->session->setFlash('error', 'Campaign type and message are required.');
            $response->redirect('/admin/crm/campaigns');
            return;
        }

        $db = Payment::getDB();
        
        // Insert Campaign record
        $stmt = $db->prepare("INSERT INTO campaigns (type, subject, message, status, sent_by, sent_at) VALUES (?, ?, ?, 'Pending', ?, NOW())");
        $stmt->execute([$type, $subject, $message, current_user()['id']]);
        $campaignId = $db->lastInsertId();

        // Fetch all customers
        $customers = $db->query("SELECT * FROM customers")->fetchAll();

        $successCount = 0;
        $status = 'Failed';
        
        if ($type === 'Email') {
            if (empty($subject)) {
                $subject = "Update from ISEC Limited";
            }
            foreach ($customers as $customer) {
                if (!empty($customer['email'])) {
                    $htmlContent = "<div style='font-family:sans-serif; max-width:600px; margin:0 auto;'><h2>Hello {$customer['name']},</h2><p>" . nl2br(e($message)) . "</p></div>";
                    \App\Core\Mailer::send('info@isecltd.ng', $customer['email'], $subject, $htmlContent, 'ISEC Limited');
                    $successCount++;
                }
            }
            $status = 'Sent';
        } else if ($type === 'SMS') {
            // Stub for Termii SMS API
            foreach ($customers as $customer) {
                if (!empty($customer['phone'])) {
                    $this->sendTermiiSms($customer['phone'], $message);
                    $successCount++;
                }
            }
            $status = 'Sent';
        } else if ($type === 'WhatsApp') {
            // Stub for Termii WhatsApp API
            foreach ($customers as $customer) {
                if (!empty($customer['phone'])) {
                    $this->sendTermiiWhatsApp($customer['phone'], $message);
                    $successCount++;
                }
            }
            $status = 'Sent';
        }

        // Update campaign status
        $db->prepare("UPDATE campaigns SET status = ? WHERE id = ?")->execute([$status, $campaignId]);

        $this->session->setFlash('success', "Campaign ($type) successfully sent to $successCount customers.");
        $response->redirect('/admin/crm/campaigns');
    }
    
    private function sendTermiiSms(string $phone, string $message): bool {
        // TODO: Implement actual Termii API call for SMS
        // Example:
        // $url = "https://api.ng.termii.com/api/sms/send";
        // $data = [
        //     "to" => $phone,
        //     "from" => "ISEC",
        //     "sms" => $message,
        //     "type" => "plain",
        //     "channel" => "generic",
        //     "api_key" => "TERMII_API_KEY"
        // ];
        
        error_log("STUB: Sending Termii SMS to $phone: $message");
        return true;
    }
    
    private function sendTermiiWhatsApp(string $phone, string $message): bool {
        // TODO: Implement actual Termii API call for WhatsApp
        // Example:
        // $url = "https://api.ng.termii.com/api/sms/send";
        // $data = [
        //     "to" => $phone,
        //     "from" => "ISEC",
        //     "sms" => $message,
        //     "type" => "plain",
        //     "channel" => "whatsapp",
        //     "api_key" => "TERMII_API_KEY"
        // ];
        
        error_log("STUB: Sending Termii WhatsApp to $phone: $message");
        return true;
    }
}
