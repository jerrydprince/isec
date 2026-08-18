<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Billing & Invoices</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Manage client invoices and automatically generate receipts.</p>
        </div>
        <a href="<?= url('/admin/billing/create') ?>" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-sm shadow-indigo-200">
            <i class="fa-solid fa-plus mr-2"></i> Create Invoice
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="relative w-full sm:w-72">
                <form action="" method="GET">
                    <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="<?= e($_GET['search'] ?? '') ?>" placeholder="Search client or invoice #..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 focus:border-indigo-500 rounded-xl text-xs outline-none transition-all shadow-sm text-slate-700">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] uppercase tracking-widest text-slate-400 font-bold border-b border-slate-100">
                        <th class="px-6 py-4 whitespace-nowrap">Invoice / Client</th>
                        <th class="px-6 py-4 whitespace-nowrap">Dates</th>
                        <th class="px-6 py-4 whitespace-nowrap">Amount</th>
                        <th class="px-6 py-4 whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-slate-600 divide-y divide-slate-100">
                    <?php if (empty($invoices)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-file-invoice-dollar text-4xl mb-3 text-slate-200"></i>
                                <p>No invoices found. Create your first invoice!</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900"><?= e($invoice['invoice_number']) ?></div>
                                    <div class="text-[10px] text-slate-500 mt-0.5"><?= e($invoice['client_name']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div><span class="text-slate-400 font-medium">Issued:</span> <?= date('M d, Y', strtotime($invoice['issue_date'])) ?></div>
                                    <?php if ($invoice['due_date']): ?>
                                        <div class="text-[10px] mt-0.5"><span class="text-slate-400 font-medium">Due:</span> <?= date('M d, Y', strtotime($invoice['due_date'])) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono">
                                    <div class="font-bold text-slate-800"><?= e($invoice['currency_symbol']) ?><?= number_format($invoice['total_amount'], 2) ?></div>
                                    <?php if ($invoice['balance_due'] > 0 && $invoice['amount_paid'] > 0): ?>
                                        <div class="text-[10px] text-rose-500 font-medium">Balance: <?= e($invoice['currency_symbol']) ?><?= number_format($invoice['balance_due'], 2) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $badgeColor = 'bg-slate-100 text-slate-600'; // Draft
                                        if ($invoice['status'] === 'Sent') $badgeColor = 'bg-blue-50 text-blue-600 border border-blue-200';
                                        if ($invoice['status'] === 'Partially Paid') $badgeColor = 'bg-amber-50 text-amber-600 border border-amber-200';
                                        if ($invoice['status'] === 'Paid') $badgeColor = 'bg-emerald-50 text-emerald-600 border border-emerald-200';
                                        if ($invoice['status'] === 'Cancelled') $badgeColor = 'bg-rose-50 text-rose-600 border border-rose-200';
                                    ?>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $badgeColor ?>"><?= e($invoice['status']) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        
                                        <!-- View / Print -->
                                        <a href="<?= url('/billing/view/' . $invoice['id']) ?>" target="_blank" title="View Invoice" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 flex items-center justify-center transition-all shadow-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Send Email -->
                                        <?php if ($invoice['client_email']): ?>
                                            <a href="<?= url('/admin/billing/send-email/' . $invoice['id']) ?>" title="Email to Client" onclick="return confirm('Send this document to <?= e($invoice['client_email']) ?>?')" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 flex items-center justify-center transition-all shadow-sm">
                                                <i class="fa-regular fa-envelope"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($invoice['status'] !== 'Paid'): ?>
                                            <!-- Add Payment -->
                                            <button type="button" onclick="openPaymentModal(<?= $invoice['id'] ?>, <?= $invoice['balance_due'] ?>)" title="Add Payment" class="w-8 h-8 rounded-lg bg-teal-50 border border-teal-200 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                                <i class="fa-solid fa-money-bill-wave"></i>
                                            </button>
                                            <!-- Edit -->
                                            <a href="<?= url('/admin/billing/edit/' . $invoice['id']) ?>" title="Edit Invoice" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-amber-500 hover:border-amber-200 flex items-center justify-center transition-all shadow-sm">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        <?php else: ?>
                                            <!-- View Receipt -->
                                            <a href="<?= url('/billing/receipt/' . $invoice['id']) ?>" target="_blank" title="View Receipt" class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <!-- Delete -->
                                        <a href="<?= url('/admin/billing/delete/' . $invoice['id']) ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this invoice?')" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 flex items-center justify-center transition-all shadow-sm">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all scale-95 opacity-0 duration-200" id="paymentModalContent">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800">Record Payment</h3>
            <button type="button" onclick="closePaymentModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form id="paymentForm" method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Amount Paid <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">₦</span>
                        <input type="number" step="0.01" name="amount" id="paymentAmount" required class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-mono">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Date <span class="text-rose-500">*</span></label>
                        <input type="date" name="payment_date" value="<?= date('Y-m-d') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Method <span class="text-rose-500">*</span></label>
                        <select name="payment_method" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cash">Cash</option>
                            <option value="Online">Online / Card</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Reference (Optional)</label>
                    <input type="text" name="reference" placeholder="e.g. TXN-123456" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Notes (Optional)</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closePaymentModal()" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 rounded-xl transition-all">Save Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPaymentModal(invoiceId, balanceDue) {
    const modal = document.getElementById('paymentModal');
    const content = document.getElementById('paymentModalContent');
    const form = document.getElementById('paymentForm');
    const amountInput = document.getElementById('paymentAmount');
    
    form.action = '<?= url('/admin/billing/payment/') ?>' + invoiceId;
    amountInput.value = balanceDue;
    amountInput.max = balanceDue; // Prevent overpaying natively
    
    modal.classList.remove('hidden');
    // slight delay for animation
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    const content = document.getElementById('paymentModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}
</script>
