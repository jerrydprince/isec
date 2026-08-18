<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Payment;
use App\Models\Settings;
use PDO;

class PaymentController extends Controller {

    /**
     * Verifies the Paystack transaction via reference
     */
    public function verify() {
        $reference = $_GET['reference'] ?? null;
        $plan = $_GET['plan'] ?? 'Unknown Plan';
        $name = $_GET['name'] ?? 'Unknown';
        $phone = $_GET['phone'] ?? '';

        if (!$reference) {
            $this->session->setFlash('error', 'No payment reference provided.');
            $this->redirect('/#products');
        }

        // Check if payment was already verified
        $existing = Payment::findByReference($reference);
        if ($existing && $existing['status'] === 'success') {
            $this->redirect('/payment/thank-you?reference=' . $reference);
        }

        // Call Paystack API
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . PAYSTACK_SECRET_KEY,
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $this->session->setFlash('error', 'Error verifying payment.');
            $this->redirect('/#products');
        }

        $tranx = json_decode($response);
        if (!$tranx->status || $tranx->data->status !== 'success') {
            $this->session->setFlash('error', 'Payment verification failed.');
            $this->redirect('/#products');
        }

        // Payment successful
        $amountPaid = $tranx->data->amount / 100;
        $customerEmail = $tranx->data->customer->email;

        // Save to Database
        if (!$existing) {
            $db = Payment::getDB();
            $stmt = $db->prepare("INSERT INTO payments (name, email, phone, plan, amount, reference, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'success', NOW(), NOW())");
            $stmt->execute([$name, $customerEmail, $phone, $plan, $amountPaid, $reference]);

            // Upsert Customer to CRM
            $stmtCustomer = $db->prepare("INSERT INTO customers (name, email, phone, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW()) ON DUPLICATE KEY UPDATE name = VALUES(name), phone = VALUES(phone), updated_at = NOW()");
            $stmtCustomer->execute([$name, $customerEmail, $phone]);
            
            // Auto-generate Invoice and Payment for Accounting
            $invoiceNumber = \App\Models\Invoice::generateInvoiceNumber();
            $invoiceId = \App\Models\Invoice::create([
                'invoice_number' => $invoiceNumber,
                'client_name' => $name,
                'client_email' => $customerEmail,
                'client_address' => $phone, // Fallback to phone if address isn't available
                'currency_code' => 'NGN',
                'currency_symbol' => '₦',
                'issue_date' => date('Y-m-d'),
                'due_date' => date('Y-m-d'),
                'subtotal' => $amountPaid,
                'tax_rate' => 0,
                'tax_amount' => 0,
                'total_amount' => $amountPaid,
                'amount_paid' => $amountPaid,
                'balance_due' => 0,
                'notes' => 'Online Subscription Payment for ' . $plan,
                'status' => 'Paid'
            ]);

            if ($invoiceId) {
                // Add item to invoice
                \App\Models\Invoice::addItem($invoiceId, "Subscription: " . $plan, 1, $amountPaid, $amountPaid);
                
                // We bypass addPayment method because we already set amount_paid/balance_due in create()
                // Just insert the payment record
                $stmt = $db->prepare("INSERT INTO invoice_payments (invoice_id, amount, payment_date, payment_method, reference, notes) VALUES (?, ?, ?, 'Online', ?, ?)");
                $stmt->execute([$invoiceId, $amountPaid, date('Y-m-d'), $reference, 'Paystack Online Payment']);
                
                // Trigger Email to Customer with the generated Invoice link
                $this->sendCustomerReceiptWithInvoice($name, $customerEmail, $plan, $amountPaid, $reference, $invoiceId);
            } else {
                // Fallback email
                $this->sendCustomerReceipt($name, $customerEmail, $plan, $amountPaid, $reference);
            }

            // Trigger Email to Admin
            $this->sendAdminNotification($name, $customerEmail, $plan, $amountPaid, $reference);
        }

        $this->redirect('/payment/thank-you?reference=' . $reference);
    }

    /**
     * Show the Thank You page
     */
    public function thankYou() {
        $reference = $_GET['reference'] ?? '';
        $payment = null;
        
        if ($reference) {
            $payment = Payment::findByReference($reference);
        }

        return $this->view('payment/thank_you', ['payment' => $payment]);
    }

    private function sendAdminNotification($name, $email, $plan, $amount, $ref) {
        $adminEmail = Settings::get('contact_email', 'info@isec.com.ng');
        $subject = "New Plan Subscription: $plan";
        $message = "<h3>A new payment has been received.</h3>"
                 . "<p><strong>Customer:</strong> $name<br>"
                 . "<strong>Email:</strong> $email<br>"
                 . "<strong>Plan:</strong> $plan<br>"
                 . "<strong>Amount:</strong> NGN " . number_format($amount, 2) . "<br>"
                 . "<strong>Reference:</strong> $ref</p>"
                 . "<p>Please check the admin dashboard for more details.</p>";
                 
        \App\Helpers\Mailer::send('no-reply@isec.com.ng', $adminEmail, $subject, $message);
    }
    
    private function sendCustomerReceipt($name, $email, $plan, $amount, $ref) {
        $subject = "Payment Receipt - ISEC";
        $message = "<p>Dear $name,</p>"
                 . "<p>Thank you for subscribing to the $plan.</p>"
                 . "<p>We have successfully received your payment of <strong>NGN " . number_format($amount, 2) . "</strong>.</p>"
                 . "<p><strong>Transaction Reference:</strong> $ref</p>"
                 . "<p>Our support team will be in touch shortly.</p>"
                 . "<p>Regards,<br>ISEC Team</p>";
                 
        \App\Helpers\Mailer::send('no-reply@isec.com.ng', $email, $subject, $message);
    }
    private function sendCustomerReceiptWithInvoice($name, $email, $plan, $amount, $ref, $invoiceId) {
        $subject = "Payment Receipt & Invoice - ISEC";
        $receiptUrl = url("/billing/receipt/{$invoiceId}");
        
        $message = "<p>Dear $name,</p>"
                 . "<p>Thank you for subscribing to the $plan.</p>"
                 . "<p>We have successfully received your payment of <strong>NGN " . number_format($amount, 2) . "</strong>.</p>"
                 . "<p><strong>Transaction Reference:</strong> $ref</p>"
                 . "<p>You can view and download your official receipt using the link below:</p>"
                 . "<p><a href='$receiptUrl'>$receiptUrl</a></p>"
                 . "<p>Our support team will be in touch shortly.</p>"
                 . "<p>Regards,<br>ISEC Team</p>";
                 
        \App\Helpers\Mailer::send('no-reply@isec.com.ng', $email, $subject, $message);
    }
}
