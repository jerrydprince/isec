<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= e($invoice['invoice_number']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://js.paystack.co/v1/inline.js"></script>
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

    <!-- Invoice Document -->
    <div class="document-container shadow-lg print-border mb-10 bg-white relative">
        
        <!-- Header / Meta Info -->
        <div class="flex justify-between items-end border-b-2 border-indigo-100 pb-4">
            <div>
                <h2 class="text-4xl font-black text-indigo-900 uppercase tracking-widest mb-2">Invoice</h2>
            </div>
            <div class="text-right">
                <div class="text-sm font-bold text-slate-800">#<?= e($invoice['invoice_number']) ?></div>
                <div class="text-xs text-slate-600 font-semibold mt-1">Date: <?= date('F j, Y', strtotime($invoice['issue_date'])) ?></div>
                <?php if ($invoice['due_date']): ?>
                    <div class="text-xs text-slate-600 mt-0.5">Due Date: <?= date('F j, Y', strtotime($invoice['due_date'])) ?></div>
                <?php endif; ?>
                
                <?php 
                    $isPaid = ($invoice['balance_due'] <= 0 && $invoice['amount_paid'] > 0 && $invoice['amount_paid'] >= $invoice['total_amount']);
                    $isPartiallyPaid = (!$isPaid && $invoice['amount_paid'] > 0);
                ?>
                <div class="mt-3 inline-block px-3 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                    <?= $isPaid ? 'bg-emerald-100 text-emerald-700' : ($isPartiallyPaid ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') ?>">
                    <?= $isPaid ? 'PAID IN FULL' : ($isPartiallyPaid ? 'PARTIALLY PAID' : 'AMOUNT DUE') ?>
                </div>
            </div>
        </div>

        <!-- Billed To -->
        <div class="mt-6 mb-8">
            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Billed To</h3>
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
        <div class="flex justify-end border-t border-slate-200 pt-6">
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
                    <span>Total Amount</span>
                    <span class="font-mono"><?= e($invoice['currency_symbol']) ?><?= number_format($invoice['total_amount'], 2) ?></span>
                </div>
                
                <?php if ($invoice['amount_paid'] > 0): ?>
                    <div class="flex justify-between text-sm text-emerald-600 font-bold pt-2">
                        <span>Amount Paid</span>
                        <span class="font-mono">- <?= e($invoice['currency_symbol']) ?><?= number_format($invoice['amount_paid'], 2) ?></span>
                    </div>
                    <div class="flex justify-between text-lg font-black text-rose-600 border-t border-slate-200 mt-2 pt-2">
                        <span>Balance Due</span>
                        <span class="font-mono"><?= e($invoice['currency_symbol']) ?><?= number_format($invoice['balance_due'], 2) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notes & Payment Info -->
        <div class="mt-16 pt-8 border-t border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-8 print:block">
            <div class="print:mb-8">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Payment Instructions</h3>
                <div class="text-xs text-slate-600 bg-slate-50 p-4 rounded-lg space-y-3">
                    <div>
                        <strong>Bank:</strong> First City Monument Bank (FCMB)<br>
                        <strong>Account Name:</strong> Integrated Systems Efficiency Consults Ltd.<br>
                        <strong>Account Number:</strong> 2002785036
                    </div>
                    <hr class="border-slate-200">
                    <div>
                        <strong>Bank:</strong> ZENITH BANK<br>
                        <strong>Account Name:</strong> INTEGRATED SYSTEMS EFFICIENCY CONSULTS LIMITED<br>
                        <strong>Account Number:</strong> 1312730577<br>
                        <strong>Branch Code:</strong> 235<br>
                        <strong>Swift Code:</strong> ZEIBNGLA
                    </div>
                </div>
            </div>
            
            <?php if (!empty($invoice['notes'])): ?>
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Notes / Terms</h3>
                    <div class="text-xs text-slate-600 whitespace-pre-line leading-relaxed">
                        <?= e($invoice['notes']) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ($invoice['balance_due'] > 0): ?>
            <!-- Online Payment Action (Hidden on Print) -->
            <div class="mt-8 pt-8 border-t border-slate-200 text-center print:hidden">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Pay Your Invoice Securely Online</h3>
                <button type="button" onclick="openOnlinePaymentModal()" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1">
                    <i class="fa-solid fa-credit-card mr-3 text-xl"></i> Pay Online Now
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Online Payment Modal -->
    <?php if ($invoice['balance_due'] > 0): ?>
    <div id="onlinePaymentModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-95 opacity-0 duration-200" id="onlinePaymentContent">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800">Complete Your Payment</h3>
                <button type="button" onclick="closeOnlinePaymentModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-5">
                <!-- Amount Input -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Amount to Pay</label>
                    <p class="text-[10px] text-slate-500 mb-2">You can pay the full balance or make a minimum 70% deposit.</p>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold"><?= e($invoice['currency_symbol']) ?></span>
                        <input type="number" id="payAmount" value="<?= $invoice['balance_due'] ?>" max="<?= $invoice['balance_due'] ?>" min="<?= ($invoice['total_amount'] * 0.7) ?>" step="0.01" class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-mono font-bold text-lg" oninput="calculateFees()">
                    </div>
                    <?php if ($invoice['amount_paid'] == 0): ?>
                        <div class="text-[10px] text-indigo-600 font-medium mt-1">Minimum deposit required: <?= e($invoice['currency_symbol']) ?><?= number_format($invoice['total_amount'] * 0.7, 2) ?> (70%)</div>
                    <?php endif; ?>
                </div>

                <!-- Fee Breakdown -->
                <div class="bg-slate-50 rounded-xl p-4 space-y-2 border border-slate-100">
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Payment Amount:</span>
                        <span class="font-mono font-semibold" id="displayBaseAmount"><?= e($invoice['currency_symbol']) ?>0.00</span>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Processing Fee (Paystack):</span>
                        <span class="font-mono font-semibold text-rose-500" id="displayFee"><?= e($invoice['currency_symbol']) ?>0.00</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-slate-800 border-t border-slate-200 pt-2 mt-2">
                        <span>Total to Charge:</span>
                        <span class="font-mono" id="displayTotalCharge"><?= e($invoice['currency_symbol']) ?>0.00</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closeOnlinePaymentModal()" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">Cancel</button>
                <button type="button" onclick="processPaystackPayment()" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 rounded-xl transition-all flex items-center">
                    Proceed to Pay <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        const balanceDue = <?= $invoice['balance_due'] ?>;
        const totalAmount = <?= $invoice['total_amount'] ?>;
        const amountPaid = <?= $invoice['amount_paid'] ?>;
        const minDeposit = amountPaid > 0 ? 1 : (totalAmount * 0.7); // 70% min deposit for first payment
        const currencySymbol = '<?= e($invoice['currency_symbol']) ?>';
        
        let currentFee = 0;
        let totalCharge = 0;

        function calculateFees() {
            let amount = parseFloat(document.getElementById('payAmount').value) || 0;
            
            // Validate limits
            if (amount > balanceDue) {
                amount = balanceDue;
                document.getElementById('payAmount').value = amount;
            }
            
            // Paystack Fee Calculation: 1.5% + NGN 100 (if >= 2500)
            // Capped at NGN 2000
            let fee = (amount * 0.015);
            if (amount >= 2500) {
                fee += 100;
            }
            if (fee > 2000) {
                fee = 2000;
            }
            
            // Because we pass the fee to the client, the total charge is amount + fee
            // But actually paystack recalculates based on total charge. 
            // The exact formula to pass fee: Charge = (Amount + 100) / (1 - 0.015)
            if (amount > 0) {
                if (amount >= 2500) {
                    totalCharge = (amount + 100) / (1 - 0.015);
                } else {
                    totalCharge = amount / (1 - 0.015);
                }
                
                // Cap fee check
                if ((totalCharge - amount) > 2000) {
                    totalCharge = amount + 2000;
                }
                
                currentFee = totalCharge - amount;
            } else {
                currentFee = 0;
                totalCharge = 0;
            }

            document.getElementById('displayBaseAmount').innerText = currencySymbol + amount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('displayFee').innerText = currencySymbol + currentFee.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('displayTotalCharge').innerText = currencySymbol + totalCharge.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function openOnlinePaymentModal() {
            document.getElementById('onlinePaymentModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('onlinePaymentContent').classList.remove('scale-95', 'opacity-0');
                document.getElementById('onlinePaymentContent').classList.add('scale-100', 'opacity-100');
            }, 10);
            calculateFees();
        }

        function closeOnlinePaymentModal() {
            document.getElementById('onlinePaymentContent').classList.remove('scale-100', 'opacity-100');
            document.getElementById('onlinePaymentContent').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                document.getElementById('onlinePaymentModal').classList.add('hidden');
            }, 200);
        }

        function processPaystackPayment() {
            let amount = parseFloat(document.getElementById('payAmount').value) || 0;
            
            if (amount < minDeposit) {
                alert(`Minimum payment amount is ${currencySymbol}${minDeposit.toLocaleString()}`);
                return;
            }

            if (amount > balanceDue) {
                alert('You cannot pay more than the outstanding balance.');
                return;
            }

            // Convert to kobo/cents for Paystack
            const amountInKobo = Math.round(totalCharge * 100);

            let handler = PaystackPop.setup({
                key: '<?= PAYSTACK_PUBLIC_KEY ?>',
                email: '<?= e($invoice['client_email']) ?>',
                amount: amountInKobo,
                currency: 'NGN', // Should map to actual currency if multi-currency
                ref: 'INV_' + Math.floor((Math.random() * 1000000000) + 1),
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Invoice Number",
                            variable_name: "invoice_number",
                            value: "<?= e($invoice['invoice_number']) ?>"
                        }
                    ],
                    invoice_id: <?= $invoice['id'] ?>,
                    invoice_amount: amount // Pass the base amount without fees to credit exactly this
                },
                callback: function(response) {
                    // Redirect to verification URL
                    window.location.href = '<?= url('/billing/payment/verify') ?>?reference=' + response.reference + '&invoice_id=<?= $invoice['id'] ?>';
                },
                onClose: function() {
                    console.log('Payment window closed');
                }
            });

            handler.openIframe();
        }
    </script>
    <?php endif; ?>
</body>
</html>
