<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt <?= e($invoice['invoice_number']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page { size: A4; margin: 0; }
            body { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
                background: url('<?= asset('images/letterhead.png') ?>') no-repeat center center !important;
                background-size: 100% 100% !important;
                margin: 0;
                padding: 0;
            }
            .no-print { display: none !important; }
            .shadow-lg { box-shadow: none !important; }
            .print-border { border: none !important; }
            .document-container {
                padding-top: 45mm !important; /* Avoid letterhead header */
                padding-bottom: 30mm !important; /* Avoid letterhead footer */
                padding-left: 20mm !important;
                padding-right: 20mm !important;
                background: transparent !important;
            }
        }
        
        /* Screen View Adjustments */
        @media screen {
            body {
                background-color: #f1f5f9;
            }
            .document-container {
                background: url('<?= asset('images/letterhead.png') ?>') no-repeat center center;
                background-size: 100% 100%;
                min-height: 297mm; /* A4 height */
                width: 210mm; /* A4 width */
                padding-top: 45mm;
                padding-bottom: 30mm;
                padding-left: 20mm;
                padding-right: 20mm;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased py-10">

    <!-- Print Action Bar -->
    <div class="max-w-4xl mx-auto mb-6 flex justify-end gap-3 no-print px-4">
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md transition-all">
            <i class="fa-solid fa-print mr-2"></i> Print / Save PDF
        </button>
    </div>

    <!-- Receipt Document -->
    <div class="document-container shadow-lg print-border mb-10 bg-white relative">
        
        <!-- Header / Meta Info -->
        <div class="flex justify-between items-end border-b-2 border-indigo-100 pb-4">
            <div>
                <h2 class="text-4xl font-black text-indigo-900 uppercase tracking-widest mb-2">Receipt</h2>
            </div>
            <div class="text-right">
                <div class="text-sm font-bold text-slate-800">#<?= e($invoice['invoice_number']) ?></div>
                <div class="text-xs text-slate-600 font-semibold mt-1">Payment Date: <?= date('F j, Y', strtotime($invoice['payment_date'] ?? $invoice['updated_at'])) ?></div>
                
                <div class="mt-3 inline-block px-4 py-1.5 rounded text-[10px] font-black uppercase tracking-wider border-2 border-emerald-500 text-emerald-600 transform -rotate-2">
                    <i class="fa-solid fa-check-circle mr-1"></i> PAID
                </div>
            </div>
        </div>

        <!-- Billed To -->
        <div class="mt-6 mb-8">
            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Received From</h3>
            <div class="text-sm font-bold text-slate-900"><?= e($invoice['client_name']) ?></div>
            <?php if ($invoice['client_email']): ?>
                <div class="text-xs text-slate-600 mt-0.5"><?= e($invoice['client_email']) ?></div>
            <?php endif; ?>
            <?php if ($invoice['client_address']): ?>
                <div class="text-xs text-slate-600 mt-0.5 whitespace-pre-line"><?= e($invoice['client_address']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Line Items -->
        <table class="w-full text-left border-collapse mb-8">
            <thead>
                <tr class="border-b-2 border-slate-800 text-xs font-bold text-slate-800 uppercase tracking-wider">
                    <th class="py-3 pr-4">Description</th>
                    <th class="py-3 px-4 text-center">Qty</th>
                    <th class="py-3 px-4 text-right">Unit Price</th>
                    <th class="py-3 pl-4 text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                <?php foreach ($items as $item): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="py-4 pr-4 text-slate-700"><?= e($item['description']) ?></td>
                        <td class="py-4 px-4 text-center text-slate-500"><?= (float)$item['quantity'] ?></td>
                        <td class="py-4 px-4 text-right text-slate-500 font-mono"><?= number_format($item['unit_price'], 2) ?></td>
                        <td class="py-4 pl-4 text-right font-bold text-slate-800 font-mono">
                            <?= e($invoice['currency_symbol']) ?><?= number_format($item['total'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="flex justify-between items-end border-t border-slate-200 pt-6">
            <div class="w-1/2">
                <div class="text-xs text-slate-500">Payment Method: <strong class="text-slate-800"><?= e($invoice['payment_method'] ?? 'Bank Transfer') ?></strong></div>
                <div class="text-xs text-slate-500 mt-1">Thank you for your business!</div>
            </div>
            <div class="w-full sm:w-1/2 md:w-1/3 space-y-3">
                <div class="flex justify-between text-sm text-slate-500">
                    <span>Subtotal</span>
                    <span class="font-mono"><?= e($invoice['currency_symbol']) ?><?= number_format($invoice['subtotal'], 2) ?></span>
                </div>
                <?php if ($invoice['tax_rate'] > 0): ?>
                    <div class="flex justify-between text-sm text-slate-500">
                        <span>Tax (<?= (float)$invoice['tax_rate'] ?>%)</span>
                        <span class="font-mono"><?= e($invoice['currency_symbol']) ?><?= number_format($invoice['tax_amount'], 2) ?></span>
                    </div>
                <?php endif; ?>
                <div class="flex justify-between text-lg font-black text-slate-900 border-t border-slate-200 pt-3">
                    <span>Amount Paid</span>
                    <span class="font-mono"><?= e($invoice['currency_symbol']) ?><?= number_format($invoice['total_amount'], 2) ?></span>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
