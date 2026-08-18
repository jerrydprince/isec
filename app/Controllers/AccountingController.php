<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Settings;
use PDO;

class AccountingController extends AdminController {

    public function dashboard(Request $request, Response $response): string {
        $this->checkPermission('manage_settings'); // Assuming accounting uses manage_settings

        $db = Invoice::getDB();

        // 1. Total Income from Invoices (Amount Paid)
        $incomeStmt = $db->query("SELECT SUM(amount_paid) as total FROM invoices WHERE status != 'Cancelled'");
        $totalIncome = (float)($incomeStmt->fetchColumn() ?: 0);

        // Add pure online payments that aren't tied to invoices (if any)
        $onlineStmt = $db->query("SELECT SUM(amount) as total FROM payments WHERE status = 'success'");
        $onlineIncome = (float)($onlineStmt->fetchColumn() ?: 0);
        
        $totalIncome += $onlineIncome;

        // 2. Total Expenses
        $expenseStmt = $db->query("SELECT SUM(amount) as total FROM expenses");
        $totalExpenses = (float)($expenseStmt->fetchColumn() ?: 0);

        // 3. Outstanding Receivables
        $receivableStmt = $db->query("SELECT SUM(balance_due) as total FROM invoices WHERE status != 'Cancelled'");
        $totalReceivables = (float)($receivableStmt->fetchColumn() ?: 0);

        $netProfit = $totalIncome - $totalExpenses;

        // Recent Transactions (Last 5 Payments & Last 5 Expenses & Last 5 Online Payments)
        $recentIncome = $db->query("
            SELECT 'Income' as type, amount, payment_date as date, payment_method as method, invoice_id as ref_id 
            FROM invoice_payments 
            ORDER BY payment_date DESC LIMIT 5
        ")->fetchAll();

        $recentOnlineIncome = $db->query("
            SELECT 'Income' as type, amount, DATE(created_at) as date, 'Online Payment' as method, id as ref_id 
            FROM payments 
            WHERE status = 'success'
            ORDER BY created_at DESC LIMIT 5
        ")->fetchAll();

        $recentExpenses = $db->query("
            SELECT 'Expense' as type, amount, expense_date as date, category as method, id as ref_id 
            FROM expenses 
            ORDER BY expense_date DESC LIMIT 5
        ")->fetchAll();

        // Legacy Invoices (where amount_paid > 0 OR status = 'Paid' but not in invoice_payments table)
        $legacyIncome = $db->query("
            SELECT 'Income' as type, CASE WHEN amount_paid > 0 THEN amount_paid ELSE total_amount END as amount, DATE(COALESCE(payment_date, updated_at)) as date, COALESCE(payment_method, 'Invoice') as method, id as ref_id 
            FROM invoices 
            WHERE (amount_paid > 0 OR status = 'Paid') AND id NOT IN (SELECT invoice_id FROM invoice_payments)
            ORDER BY date DESC LIMIT 5
        ")->fetchAll();

        $transactions = array_merge($recentIncome, $recentOnlineIncome, $recentExpenses, $legacyIncome);
        usort($transactions, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        $transactions = array_slice($transactions, 0, 8);

        return $this->render('admin/accounting/dashboard', [
            'title' => 'Accounting Dashboard - ISEC CMS',
            'currency' => Settings::get('currency_symbol', '₦'),
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'totalReceivables' => $totalReceivables,
            'transactions' => $transactions
        ]);
    }

    public function expenses(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $expenses = Expense::query("SELECT * FROM expenses ORDER BY expense_date DESC, id DESC");
        
        // Fetch or default categories
        $categoriesSetting = Settings::get('expense_categories', 'Software/Licenses,Contractor Fees,Office Supplies,Marketing,Travel,Taxes,General');
        $categories = array_map('trim', explode(',', $categoriesSetting));
        
        return $this->render('admin/accounting/expenses', [
            'title' => 'Expenses - ISEC CMS',
            'currency' => Settings::get('currency_symbol', '₦'),
            'categories' => $categories,
            'expenses' => $expenses
        ]);
    }

    public function storeExpense(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();

        $title = trim($request->get('title'));
        $amount = (float)$request->get('amount');
        $date = $request->get('expense_date');
        $category = trim($request->get('category', 'General'));
        $description = trim($request->get('description', ''));

        if (empty($title) || $amount <= 0 || empty($date)) {
            $session->setFlash('error', 'Title, Valid Amount, and Date are required.');
            $response->redirect('/admin/accounting/expenses');
            return;
        }

        Expense::create([
            'title' => $title,
            'amount' => $amount,
            'expense_date' => $date,
            'category' => $category,
            'description' => $description
        ]);

        $session->setFlash('success', 'Expense recorded successfully.');
        $response->redirect('/admin/accounting/expenses');
    }

    public function deleteExpense(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        Expense::delete($id);
        
        $session = new Session();
        $session->setFlash('success', 'Expense deleted.');
        $response->redirect('/admin/accounting/expenses');
    }

    public function statement(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $email = trim($request->get('client_email', ''));
        $statement = [];
        $clientInfo = null;
        $totals = ['invoiced' => 0, 'paid' => 0, 'balance' => 0];

        if ($email) {
            $db = Invoice::getDB();
            // Fetch Client Invoices
            $stmt = $db->prepare("SELECT * FROM invoices WHERE client_email = :email AND status != 'Cancelled' ORDER BY issue_date ASC");
            $stmt->execute(['email' => $email]);
            $invoices = $stmt->fetchAll();

            if (count($invoices) > 0) {
                $clientInfo = [
                    'name' => $invoices[0]['client_name'],
                    'email' => $invoices[0]['client_email'],
                    'address' => $invoices[0]['client_address']
                ];

                foreach ($invoices as $inv) {
                    $totals['invoiced'] += $inv['total_amount'];
                    $totals['paid'] += $inv['amount_paid'];
                    $totals['balance'] += $inv['balance_due'];

                    // Add Invoice generation to statement ledger
                    $statement[] = [
                        'date' => $inv['issue_date'],
                        'type' => 'Invoice',
                        'reference' => $inv['invoice_number'],
                        'debit' => $inv['total_amount'], // What they owe
                        'credit' => 0,
                        'details' => 'Invoice Generated'
                    ];

                    // Fetch payments for this invoice
                    $payStmt = $db->prepare("SELECT * FROM invoice_payments WHERE invoice_id = :id ORDER BY payment_date ASC");
                    $payStmt->execute(['id' => $inv['id']]);
                    $payments = $payStmt->fetchAll();

                    foreach ($payments as $pay) {
                        $statement[] = [
                            'date' => $pay['payment_date'],
                            'type' => 'Payment',
                            'reference' => $pay['reference'] ?: 'PAY-' . $pay['id'],
                            'debit' => 0,
                            'credit' => $pay['amount'], // What they paid
                            'details' => 'Payment via ' . $pay['payment_method'] . ' for ' . $inv['invoice_number']
                        ];
                    }
                }

                // Sort statement chronologically
                usort($statement, function($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });
            }
        }

        // Get list of unique client emails for the dropdown
        $db = Invoice::getDB();
        $clients = $db->query("SELECT DISTINCT client_email, client_name FROM invoices WHERE client_email IS NOT NULL AND client_email != '' ORDER BY client_name ASC")->fetchAll();

        return $this->render('admin/accounting/statement', [
            'title' => 'Client Statement of Account - ISEC CMS',
            'currency' => Settings::get('currency_symbol', '₦'),
            'email' => $email,
            'statement' => $statement,
            'clientInfo' => $clientInfo,
            'totals' => $totals,
            'clients' => $clients
        ]);
    }

    public function reports(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $db = Invoice::getDB();
        
        $startDate = $request->get('start_date', date('Y-01-01')); // Default to start of current year
        $endDate = $request->get('end_date', date('Y-12-31'));

        // 1. Revenue (From Payments)
        $revenueStmt = $db->prepare("SELECT SUM(amount) FROM invoice_payments WHERE payment_date BETWEEN :start AND :end");
        $revenueStmt->execute(['start' => $startDate, 'end' => $endDate]);
        $invoiceRevenue = (float)($revenueStmt->fetchColumn() ?: 0);

        $onlineStmt = $db->prepare("SELECT SUM(amount) FROM payments WHERE status = 'success' AND DATE(created_at) BETWEEN :start AND :end");
        $onlineStmt->execute(['start' => $startDate, 'end' => $endDate]);
        $onlineRevenue = (float)($onlineStmt->fetchColumn() ?: 0);
        
        $legacyRevStmt = $db->prepare("
            SELECT SUM(CASE WHEN amount_paid > 0 THEN amount_paid ELSE total_amount END) FROM invoices 
            WHERE (amount_paid > 0 OR status = 'Paid') AND id NOT IN (SELECT invoice_id FROM invoice_payments)
            AND DATE(COALESCE(payment_date, updated_at)) BETWEEN :start AND :end
        ");
        $legacyRevStmt->execute(['start' => $startDate, 'end' => $endDate]);
        $legacyRevenue = (float)($legacyRevStmt->fetchColumn() ?: 0);
        
        $totalRevenue = $invoiceRevenue + $onlineRevenue + $legacyRevenue;

        // 2. Expenses by Category
        $expStmt = $db->prepare("SELECT category, SUM(amount) as total FROM expenses WHERE expense_date BETWEEN :start AND :end GROUP BY category ORDER BY total DESC");
        $expStmt->execute(['start' => $startDate, 'end' => $endDate]);
        $expensesByCategory = $expStmt->fetchAll();

        $totalExpenses = 0;
        foreach ($expensesByCategory as $exp) {
            $totalExpenses += $exp['total'];
        }

        // 3. Tax Reports
        // Tax Billed: total tax on invoices issued in the period
        $taxBilledStmt = $db->prepare("SELECT SUM(tax_amount) FROM invoices WHERE status != 'Cancelled' AND issue_date BETWEEN :start AND :end");
        $taxBilledStmt->execute(['start' => $startDate, 'end' => $endDate]);
        $taxBilled = (float)($taxBilledStmt->fetchColumn() ?: 0);

        // Tax Collected: pro-rata tax based on payments
        // If an invoice is fully paid, all tax is collected. If 50% paid, 50% tax collected.
        $taxCollectedStmt = $db->prepare("
            SELECT SUM(i.tax_amount * (p.amount / i.total_amount)) as collected_tax
            FROM invoice_payments p
            JOIN invoices i ON p.invoice_id = i.id
            WHERE p.payment_date BETWEEN :start AND :end AND i.total_amount > 0
        ");
        $taxCollectedStmt->execute(['start' => $startDate, 'end' => $endDate]);
        $taxCollected = (float)($taxCollectedStmt->fetchColumn() ?: 0);

        // Calculate Net Profit
        $netProfit = $totalRevenue - $totalExpenses;

        return $this->render('admin/accounting/reports', [
            'title' => 'Financial Reports - ISEC CMS',
            'currency' => Settings::get('currency_symbol', '₦'),
            'siteName' => Settings::get('site_name', 'ISEC Limited'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue,
            'invoiceRevenue' => $invoiceRevenue,
            'onlineRevenue' => $onlineRevenue,
            'totalExpenses' => $totalExpenses,
            'expensesByCategory' => $expensesByCategory,
            'netProfit' => $netProfit,
            'taxBilled' => $taxBilled,
            'taxCollected' => $taxCollected
        ]);
    }
}
