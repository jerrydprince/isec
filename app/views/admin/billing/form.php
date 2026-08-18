<?php
$isEdit = isset($invoice) && $invoice !== null;
$actionUrl = $isEdit ? url('/admin/billing/edit/' . $invoice['id']) : url('/admin/billing/create');
?>

<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900"><?= $isEdit ? 'Edit Invoice ' . e($invoice['invoice_number']) : 'Create New Invoice' ?></h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Fill out client and billing details below.</p>
        </div>
        <a href="<?= url('/admin/billing') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to listing</a>
    </div>

    <form action="<?= $actionUrl ?>" method="POST" class="space-y-6" id="invoiceForm">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Client Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center"><i class="fa-solid fa-user-tie text-indigo-500 w-5"></i> Client Information</h2>
                    <hr class="border-slate-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Client Name / Company *</label>
                            <input type="text" name="client_name" value="<?= $isEdit ? e($invoice['client_name']) : '' ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Client Email Address</label>
                            <input type="email" name="client_email" value="<?= $isEdit ? e($invoice['client_email']) : '' ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Billing Address</label>
                        <textarea name="client_address" rows="2" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850 resize-none"><?= $isEdit ? e($invoice['client_address']) : '' ?></textarea>
                    </div>
                </div>

                <!-- Line Items -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                    <div class="flex justify-between items-center">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center"><i class="fa-solid fa-list-check text-indigo-500 w-5"></i> Line Items *</h2>
                        <button type="button" id="addItemBtn" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-colors">
                            <i class="fa-solid fa-plus mr-1"></i> Add Item
                        </button>
                    </div>
                    <hr class="border-slate-100">

                    <div id="itemsContainer" class="space-y-3">
                        <?php if ($isEdit && !empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                                <div class="item-row flex gap-3 items-start">
                                    <div class="flex-grow">
                                        <input type="text" name="item_description[]" value="<?= e($item['description']) ?>" placeholder="Description" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all" required>
                                    </div>
                                    <div class="w-20">
                                        <input type="number" step="0.01" min="0" name="item_quantity[]" value="<?= $item['quantity'] ?>" placeholder="Qty" class="qty-input w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all text-center" required>
                                    </div>
                                    <div class="w-28">
                                        <input type="number" step="0.01" min="0" name="item_unit_price[]" value="<?= $item['unit_price'] ?>" placeholder="Price" class="price-input w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all text-right" required>
                                    </div>
                                    <div class="w-28 py-2 text-right font-mono text-xs font-bold text-slate-700 line-total">
                                        0.00
                                    </div>
                                    <button type="button" class="remove-item-btn mt-1 text-slate-300 hover:text-rose-500 p-1 transition-colors"><i class="fa-solid fa-times"></i></button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Default empty row -->
                            <div class="item-row flex gap-3 items-start">
                                <div class="flex-grow">
                                    <input type="text" name="item_description[]" placeholder="Description" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all" required>
                                </div>
                                <div class="w-20">
                                    <input type="number" step="0.01" min="0" name="item_quantity[]" value="1" placeholder="Qty" class="qty-input w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all text-center" required>
                                </div>
                                <div class="w-28">
                                    <input type="number" step="0.01" min="0" name="item_unit_price[]" placeholder="Price" class="price-input w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all text-right" required>
                                </div>
                                <div class="w-28 py-2 text-right font-mono text-xs font-bold text-slate-700 line-total">
                                    0.00
                                </div>
                                <button type="button" class="remove-item-btn mt-1 text-slate-300 hover:text-rose-500 p-1 transition-colors"><i class="fa-solid fa-times"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Summary -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center"><i class="fa-solid fa-gear text-indigo-500 w-5"></i> Invoice Settings</h2>
                    <hr class="border-slate-100">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Currency Code</label>
                            <select name="currency_code" id="currencyCode" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2.5 text-xs outline-none text-slate-700">
                                <option value="NGN" <?= ($isEdit && $invoice['currency_code'] === 'NGN') ? 'selected' : '' ?>>NGN (Naira)</option>
                                <option value="USD" <?= ($isEdit && $invoice['currency_code'] === 'USD') ? 'selected' : '' ?>>USD (Dollar)</option>
                                <option value="GBP" <?= ($isEdit && $invoice['currency_code'] === 'GBP') ? 'selected' : '' ?>>GBP (Pound)</option>
                                <option value="EUR" <?= ($isEdit && $invoice['currency_code'] === 'EUR') ? 'selected' : '' ?>>EUR (Euro)</option>
                            </select>
                            <input type="hidden" name="currency_symbol" id="currencySymbol" value="<?= $isEdit ? e($invoice['currency_symbol']) : '₦' ?>">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Tax Rate (%)</label>
                            <input type="number" step="0.01" min="0" name="tax_rate" id="taxRate" value="<?= $isEdit ? $invoice['tax_rate'] : '7.50' ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2.5 text-xs outline-none text-slate-700 text-right">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Issue Date *</label>
                            <input type="date" name="issue_date" value="<?= $isEdit ? e($invoice['issue_date']) : date('Y-m-d') ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2.5 text-xs outline-none text-slate-700" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Due Date (Opt)</label>
                            <input type="date" name="due_date" value="<?= $isEdit ? e($invoice['due_date']) : '' ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2.5 text-xs outline-none text-slate-700">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-sm p-6 text-white space-y-4">
                    <h2 class="text-sm font-bold text-slate-300">Summary</h2>
                    <div class="flex justify-between text-xs text-slate-400">
                        <span>Subtotal</span>
                        <span id="subtotalDisplay" class="font-mono">0.00</span>
                    </div>
                    <div class="flex justify-between text-xs text-slate-400">
                        <span>Tax (<span id="taxRateDisplay">7.5</span>%)</span>
                        <span id="taxDisplay" class="font-mono">0.00</span>
                    </div>
                    <hr class="border-slate-700">
                    <div class="flex justify-between text-lg font-black text-white">
                        <span>Total</span>
                        <span><span id="symbolDisplay">₦</span><span id="totalDisplay" class="font-mono">0.00</span></span>
                    </div>
                    
                    <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl text-sm transition-colors mt-4">
                        <?= $isEdit ? 'Save Invoice Changes' : 'Generate Invoice' ?>
                    </button>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 ml-2">Extra Notes (Bottom of invoice)</label>
                    <textarea name="notes" rows="4" class="w-full bg-white border border-slate-200 focus:border-indigo-500 rounded-2xl px-4 py-3 text-xs outline-none transition-all text-slate-700 resize-none"><?= $isEdit ? e($invoice['notes']) : "Payment is due within 14 days.\nThank you for your business!" ?></textarea>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('itemsContainer');
    const addItemBtn = document.getElementById('addItemBtn');
    const currencyCodeSelect = document.getElementById('currencyCode');
    const currencySymbolInput = document.getElementById('currencySymbol');
    const taxRateInput = document.getElementById('taxRate');
    
    const subtotalDisplay = document.getElementById('subtotalDisplay');
    const taxDisplay = document.getElementById('taxDisplay');
    const totalDisplay = document.getElementById('totalDisplay');
    const symbolDisplay = document.getElementById('symbolDisplay');
    const taxRateDisplay = document.getElementById('taxRateDisplay');

    const currencySymbols = {
        'NGN': '₦',
        'USD': '$',
        'GBP': '£',
        'EUR': '€'
    };

    currencyCodeSelect.addEventListener('change', function() {
        const symbol = currencySymbols[this.value] || '$';
        currencySymbolInput.value = symbol;
        symbolDisplay.textContent = symbol;
        calculateTotals();
    });

    taxRateInput.addEventListener('input', calculateTotals);

    function calculateTotals() {
        let subtotal = 0;
        const rows = itemsContainer.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const qtyStr = row.querySelector('.qty-input').value;
            const priceStr = row.querySelector('.price-input').value;
            const qty = parseFloat(qtyStr) || 0;
            const price = parseFloat(priceStr) || 0;
            const lineTotal = qty * price;
            
            row.querySelector('.line-total').textContent = lineTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            subtotal += lineTotal;
        });

        const taxRate = parseFloat(taxRateInput.value) || 0;
        const total = subtotal; // Because subtotal already includes tax
        const tax = total - (total / (1 + (taxRate / 100)));
        const baseSubtotal = total - tax;

        subtotalDisplay.textContent = baseSubtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        taxRateDisplay.textContent = taxRate;
        taxDisplay.textContent = tax.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        totalDisplay.textContent = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Bind events to existing rows
    function bindRowEvents(row) {
        row.querySelector('.qty-input').addEventListener('input', calculateTotals);
        row.querySelector('.price-input').addEventListener('input', calculateTotals);
        row.querySelector('.remove-item-btn').addEventListener('click', function() {
            if (itemsContainer.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert('You must have at least one line item.');
            }
        });
    }

    itemsContainer.querySelectorAll('.item-row').forEach(bindRowEvents);
    
    // Initial calculation
    symbolDisplay.textContent = currencySymbols[currencyCodeSelect.value] || '₦';
    calculateTotals();

    addItemBtn.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'item-row flex gap-3 items-start';
        row.innerHTML = `
            <div class="flex-grow">
                <input type="text" name="item_description[]" placeholder="Description" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all" required>
            </div>
            <div class="w-20">
                <input type="number" step="0.01" min="0" name="item_quantity[]" value="1" placeholder="Qty" class="qty-input w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all text-center" required>
            </div>
            <div class="w-28">
                <input type="number" step="0.01" min="0" name="item_unit_price[]" placeholder="Price" class="price-input w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg px-3 py-2 text-xs outline-none transition-all text-right" required>
            </div>
            <div class="w-28 py-2 text-right font-mono text-xs font-bold text-slate-700 line-total">
                0.00
            </div>
            <button type="button" class="remove-item-btn mt-1 text-slate-300 hover:text-rose-500 p-1 transition-colors"><i class="fa-solid fa-times"></i></button>
        `;
        itemsContainer.appendChild(row);
        bindRowEvents(row);
    });
});
</script>
