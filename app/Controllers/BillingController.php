<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Invoice;
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
        $subtotal = 0;
        $itemsToInsert = [];
        for ($i = 0; $i < count($descriptions); $i++) {
            $desc = trim($descriptions[$i]);
            $qty = (float)($quantities[$i] ?? 1);
            $price = (float)($unitPrices[$i] ?? 0);
            if ($desc) {
                $total = $qty * $price;
                $subtotal += $total;
                $itemsToInsert[] = [
                    'description' => $desc,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'total' => $total
                ];
            }
        }

        $taxAmount = $subtotal * ($taxRate / 100);
        $totalAmount = $subtotal + $taxAmount;

        $invoiceNumber = Invoice::generateInvoiceNumber();

        $invoiceId = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'client_name' => $clientName,
            'client_email' => $clientEmail,
            'client_address' => $clientAddress,
            'currency_code' => $currencyCode,
            'currency_symbol' => $currencySymbol,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
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

        $subtotal = 0;
        $itemsToInsert = [];
        for ($i = 0; $i < count($descriptions); $i++) {
            $desc = trim($descriptions[$i]);
            $qty = (float)($quantities[$i] ?? 1);
            $price = (float)($unitPrices[$i] ?? 0);
            if ($desc) {
                $total = $qty * $price;
                $subtotal += $total;
                $itemsToInsert[] = [
                    'description' => $desc,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'total' => $total
                ];
            }
        }

        $taxAmount = $subtotal * ($taxRate / 100);
        $totalAmount = $subtotal + $taxAmount;

        Invoice::update($id, [
            'client_name' => $clientName,
            'client_email' => $clientEmail,
            'client_address' => $clientAddress,
            'currency_code' => $currencyCode,
            'currency_symbol' => $currencySymbol,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
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
}
