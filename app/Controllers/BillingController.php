<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Settings;
use App\Core\App;
use App\Models\AuditLog;
use App\Helpers\Mailer;

class BillingController extends AdminController {

    public function index(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $searchVal = '%' . trim($request->get('search', '')) . '%';
        if ($request->get('search')) {
            $invoices = Invoice::query("SELECT * FROM invoices WHERE client_name LIKE :search OR invoice_number LIKE :search ORDER BY id DESC", ['search' => $searchVal]);
        } else {
            $invoices = Invoice::query("SELECT * FROM invoices ORDER BY id DESC");
        }

        return $this->render('admin/billing/index', [
            'title' => 'Invoices & Receipts - ISEC CMS',
            'invoices' => $invoices
        ]);
    }

    public function create(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        return $this->render('admin/billing/form', [
            'title' => 'Create New Invoice - ISEC CMS',
            'invoice' => null,
            'items' => []
        ]);
    }

    public function store(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();

        $clientName = trim($request->get('client_name'));
        $clientEmail = trim($request->get('client_email'));
        $clientAddress = trim($request->get('client_address'));
        $currencyCode = trim($request->get('currency_code', 'NGN'));
        $currencySymbol = trim($request->get('currency_symbol', '₦'));
        $issueDate = $request->get('issue_date');
        $dueDate = $request->get('due_date') ?: null;
        $taxRate = (float)$request->get('tax_rate', 0);
        $notes = $request->get('notes');
        
        $descriptions = $request->get('item_description') ?? [];
        $quantities = $request->get('item_quantity') ?? [];
        $unitPrices = $request->get('item_unit_price') ?? [];

        if (empty($clientName) || empty($issueDate) || empty($descriptions)) {
            $session->setFlash('error', 'Client Name, Issue Date, and at least one item are required.');
            $response->redirect('/admin/billing/create');
            return;
        }

        // Calculate Totals
        $inclusiveTotal = 0;
        $itemsToInsert = [];
        for ($i = 0; $i < count($descriptions); $i++) {
            $desc = trim($descriptions[$i]);
            $qty = (float)($quantities[$i] ?? 1);
            $price = (float)($unitPrices[$i] ?? 0);
            if ($desc) {
                $total = $qty * $price;
                $inclusiveTotal += $total;
                $itemsToInsert[] = [
                    'description' => $desc,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'total' => $total
                ];
            }
        }

        $totalAmount = $inclusiveTotal;
        $taxAmount = $totalAmount - ($totalAmount / (1 + ($taxRate / 100)));
        $subtotal = $totalAmount - $taxAmount;

        $invoiceNumber = Invoice::generateInvoiceNumber();

        $invoiceId = Invoice::create([
            'client_name' => $clientName,
            'client_email' => $clientEmail,
            'client_address' => $clientAddress,
            'project_id' => $projectId,
            'invoice_number' => $invoiceNumber,
            'currency_code' => $currencyCode,
            'currency_symbol' => $currencySymbol,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'balance_due' => $totalAmount,
            'notes' => $notes,
            'status' => 'Draft'
        ]);

        foreach ($itemsToInsert as $item) {
            Invoice::addItem($invoiceId, $item['description'], $item['quantity'], $item['unit_price'], $item['total']);
        }

        AuditLog::log(current_user()['id'], 'Create Invoice', "Created invoice $invoiceNumber for $clientName");
        $session->setFlash('success', "Invoice $invoiceNumber created successfully.");
        $response->redirect('/admin/billing');
    }

    public function edit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);

        if (!$invoice) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        $items = Invoice::getItems($id);

        return $this->render('admin/billing/form', [
            'title' => 'Edit Invoice - ISEC CMS',
            'invoice' => $invoice,
            'items' => $items
        ]);
    }

    public function update(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);
        $session = new Session();

        if (!$invoice) {
            $session->setFlash('error', 'Invoice not found.');
            $response->redirect('/admin/billing');
            return;
        }

        $clientName = trim($request->get('client_name'));
        $clientEmail = trim($request->get('client_email'));
        $clientAddress = trim($request->get('client_address'));
        $projectId = $request->get('project_id');
        $currencyCode = trim($request->get('currency_code', 'NGN'));
        $currencySymbol = trim($request->get('currency_symbol', '₦'));
        $issueDate = $request->get('issue_date');
        $dueDate = $request->get('due_date') ?: null;
        $taxRate = (float)$request->get('tax_rate', 0);
        $notes = $request->get('notes');
        
        $descriptions = $request->get('item_description') ?? [];
        $quantities = $request->get('item_quantity') ?? [];
        $unitPrices = $request->get('item_unit_price') ?? [];

        if (empty($clientName) || empty($issueDate) || empty($descriptions)) {
            $session->setFlash('error', 'Client Name, Issue Date, and at least one item are required.');
            $response->redirect('/admin/billing/edit/' . $id);
            return;
        }

        $inclusiveTotal = 0;
        $itemsToInsert = [];
        for ($i = 0; $i < count($descriptions); $i++) {
            $desc = trim($descriptions[$i]);
            $qty = (float)($quantities[$i] ?? 1);
            $price = (float)($unitPrices[$i] ?? 0);
            if ($desc) {
                $total = $qty * $price;
                $inclusiveTotal += $total;
                $itemsToInsert[] = [
                    'description' => $desc,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'total' => $total
                ];
            }
        }

        $totalAmount = $inclusiveTotal;
        $taxAmount = $totalAmount - ($totalAmount / (1 + ($taxRate / 100)));
        $subtotal = $totalAmount - $taxAmount;

        Invoice::update($id, [
            'client_name' => $clientName,
            'client_email' => $clientEmail,
            'client_address' => $clientAddress,
            'project_id' => $projectId,
            'currency_code' => $currencyCode,
            'currency_symbol' => $currencySymbol,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'balance_due' => max(0, $totalAmount - $invoice['amount_paid']),
            'notes' => $notes
        ]);

        Invoice::deleteItems($id);
        foreach ($itemsToInsert as $item) {
            Invoice::addItem($id, $item['description'], $item['quantity'], $item['unit_price'], $item['total']);
        }

        AuditLog::log(current_user()['id'], 'Update Invoice', "Modified invoice {$invoice['invoice_number']}");
        $session->setFlash('success', "Invoice updated successfully.");
        $response->redirect('/admin/billing');
    }

    public function delete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);
        $session = new Session();

        if ($invoice) {
            Invoice::delete($id);
            AuditLog::log(current_user()['id'], 'Delete Invoice', "Deleted invoice {$invoice['invoice_number']}");
            $session->setFlash('success', 'Invoice deleted successfully.');
        }
        $response->redirect('/admin/billing');
    }

    public function viewInvoice(Request $request, Response $response, array $params): string {
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);

        if (!$invoice) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        $items = Invoice::getItems($id);

        // We render using a clean, printable layout, not the admin dashboard
        $this->setLayout('none');
        return $this->render('admin/billing/invoice_template', [
            'invoice' => $invoice,
            'items' => $items
        ]);
    }

    public function viewReceipt(Request $request, Response $response, array $params): string {
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);

        if (!$invoice || $invoice['status'] !== 'Paid') {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        $items = Invoice::getItems($id);

        $this->setLayout('none');
        return $this->render('admin/billing/receipt_template', [
            'invoice' => $invoice,
            'items' => $items
        ]);
    }

    public function markPaid(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);
        $session = new Session();

        if ($invoice) {
            Invoice::update($id, [
                'status' => 'Paid',
                'payment_date' => date('Y-m-d H:i:s'),
                'payment_method' => 'Bank Transfer'
            ]);
            AuditLog::log(current_user()['id'], 'Invoice Paid', "Marked invoice {$invoice['invoice_number']} as Paid");
            $session->setFlash('success', 'Invoice marked as Paid. Receipt is now available.');
        }
        $response->redirect('/admin/billing');
    }

    public function sendEmail(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);
        $session = new Session();

        if (!$invoice || empty($invoice['client_email'])) {
            $session->setFlash('error', 'Invoice not found or client has no email address.');
            $response->redirect('/admin/billing');
            return;
        }

        $isReceipt = ($invoice['status'] === 'Paid');
        $docType = $isReceipt ? 'Receipt' : 'Invoice';
        $viewUrl = url("/billing/view/{$id}"); // Public route
        
        $subject = "Your {$docType} from ISEC Limited ({$invoice['invoice_number']})";
        
        $htmlContent = "
        <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; color: #333;'>
            <h2>Hello {$invoice['client_name']},</h2>
            <p>Please find the link to your <strong>{$docType}</strong> ({$invoice['invoice_number']}) attached below.</p>
            <p><strong>Total Amount:</strong> {$invoice['currency_symbol']}" . number_format($invoice['total_amount'], 2) . "</p>
            <br>
            <a href='{$viewUrl}' style='background: #4f46e5; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;'>View {$docType} Online</a>
            <br><br>
            <p>Thank you for choosing Integrated Systems Efficiency Consults Limited.</p>
        </div>";

        $sent = Mailer::send('info@isecltd.ng', $invoice['client_email'], $subject, $htmlContent, 'ISEC Limited');

        if ($sent) {
            if ($invoice['status'] === 'Draft') {
                Invoice::update($id, ['status' => 'Sent']);
            }
            $session->setFlash('success', "{$docType} emailed to {$invoice['client_email']} successfully.");
        } else {
            $session->setFlash('error', 'Failed to send email. Check your SMTP configuration.');
        }

        $response->redirect('/admin/billing');
    }

    public function addPayment(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $invoice = Invoice::find($id);
        $session = new Session();

        if (!$invoice) {
            $session->setFlash('error', 'Invoice not found.');
            $response->redirect('/admin/billing');
            return;
        }

        $amount = (float)$request->get('amount', 0);
        $date = $request->get('payment_date', date('Y-m-d'));
        $method = trim($request->get('payment_method', 'Bank Transfer'));
        $reference = trim($request->get('reference', ''));
        $notes = trim($request->get('notes', ''));

        if ($amount <= 0) {
            $session->setFlash('error', 'Payment amount must be greater than zero.');
            $response->redirect('/admin/billing');
            return;
        }

        try {
            Invoice::addPayment($id, $amount, $date, $method, $reference, $notes);
            AuditLog::log(current_user()['id'], 'Add Payment', "Added {$invoice['currency_symbol']}{$amount} payment to Invoice #{$invoice['invoice_number']}");
            $session->setFlash('success', 'Payment added successfully.');
        } catch (\Exception $e) {
            $session->setFlash('error', 'Failed to add payment: ' . $e->getMessage());
        }

        $response->redirect('/admin/billing');
    }

    public function verifyOnlinePayment(Request $request, Response $response): string {
        $logFile = App::$ROOT_DIR . '/app/logs/debug.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - verifyOnlinePayment started\n", FILE_APPEND);
        try {
            $reference = $_GET['reference'] ?? null;
            $invoiceId = (int)($_GET['invoice_id'] ?? 0);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - ref: $reference, id: $invoiceId\n", FILE_APPEND);

            if (!$reference || !$invoiceId) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Missing ref or id\n", FILE_APPEND);
                $response->setStatusCode(400);
                return $this->render('errors/404');
            }

            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Invoice not found\n", FILE_APPEND);
                $response->setStatusCode(404);
                return $this->render('errors/404');
            }

            // Call Paystack API
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer " . (defined('PAYSTACK_SECRET_KEY') ? PAYSTACK_SECRET_KEY : ''),
                    "Cache-Control: no-cache",
                ),
            ));

            $res = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Paystack returned. Err: $err, Res: $res\n", FILE_APPEND);

            if ($err) {
                $msg = "<div style='font-family:sans-serif; text-align:center; padding: 50px;'><h2>Error verifying payment!</h2><p>Please contact support.</p><p>Error: " . htmlspecialchars($err) . "</p></div>";
                echo $msg; return $msg;
            }

            $tranx = json_decode($res);
            if (!$tranx || !isset($tranx->status) || !$tranx->status || $tranx->data->status !== 'success') {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Paystack failed status\n", FILE_APPEND);
                $msg = "<div style='font-family:sans-serif; text-align:center; padding: 50px;'><h2>Payment verification failed!</h2><p>It seems your payment was not successful or the response was invalid.</p></div>";
                echo $msg; return $msg;
            }

            $metadata = $tranx->data->metadata ?? null;
            $creditedAmount = isset($metadata->invoice_amount) ? (float)$metadata->invoice_amount : ($tranx->data->amount / 100);

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Amount: $creditedAmount\n", FILE_APPEND);

            // Check if we already recorded this reference to prevent double-crediting
            $db = \App\Core\Database::getConnection();
            $stmt = $db->prepare("SELECT id FROM invoice_payments WHERE reference = ?");
            $stmt->execute([$reference]);
            if ($stmt->fetch()) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Already processed, redirecting\n", FILE_APPEND);
                $response->redirect('/billing/receipt/' . $invoiceId);
                return '';
            }

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Adding payment\n", FILE_APPEND);
            Invoice::addPayment($invoiceId, $creditedAmount, date('Y-m-d'), 'Online', $reference, "Paystack transaction: " . $reference);
            
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Redirecting to receipt\n", FILE_APPEND);
            // Redirect to the receipt or the updated invoice
            $response->redirect('/billing/receipt/' . $invoiceId);
            return '';
            
        } catch (\Throwable $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - CATCH THROWABLE: " . $e->getMessage() . "\n", FILE_APPEND);
            $msg = "<div style='font-family:sans-serif; text-align:center; padding: 50px;'><h2>System Error</h2><p>An internal error occurred: " . htmlspecialchars($e->getMessage()) . "</p></div>";
            echo $msg; return $msg;
        }
    }
}
