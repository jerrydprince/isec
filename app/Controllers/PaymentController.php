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
            
            // Trigger Email to Admin
            $this->sendAdminNotification($name, $customerEmail, $plan, $amountPaid, $reference);
            
            // Trigger Email to Customer
            $this->sendCustomerReceipt($name, $customerEmail, $plan, $amountPaid, $reference);
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
        $message = "A new payment has been received.\n\n"
                 . "Customer: $name\n"
                 . "Email: $email\n"
                 . "Plan: $plan\n"
                 . "Amount: NGN " . number_format($amount, 2) . "\n"
                 . "Reference: $ref\n\n"
                 . "Please check the admin dashboard for more details.";
                 
        $headers = "From: no-reply@isec.com.ng\r\n";
        @mail($adminEmail, $subject, $message, $headers);
    }
    
    private function sendCustomerReceipt($name, $email, $plan, $amount, $ref) {
        $subject = "Payment Receipt - ISEC";
        $message = "Dear $name,\n\n"
                 . "Thank you for subscribing to the $plan.\n"
                 . "We have successfully received your payment of NGN " . number_format($amount, 2) . ".\n\n"
                 . "Transaction Reference: $ref\n\n"
                 . "Our support team will be in touch shortly.\n\n"
                 . "Regards,\nISEC Team";
                 
        $headers = "From: no-reply@isec.com.ng\r\n";
        @mail($email, $subject, $message, $headers);
    }
}
