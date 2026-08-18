
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?= url('/admin/accounting') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors" title="Back to Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-slate-800">Client Statement of Account</h2>
            </div>
            <p class="text-sm text-slate-500 ml-7">Generate financial ledgers for specific clients.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="GET" action="<?= url('/admin/accounting/statement') ?>" class="flex gap-4 items-end max-w-xl">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Select Client</label>
                <select name="client_email" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                    <option value="">-- Choose a Client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= e($client['client_email']) ?>" <?= $email === $client['client_email'] ? 'selected' : '' ?>>
                            <?= e($client['client_name']) ?> (<?= e($client['client_email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-bold shadow-lg shadow-indigo-200">
                Generate
            </button>
        </form>
    </div>

    <?php if ($email && $clientInfo): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50 flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-1">Statement of Account</h3>
                    <div class="text-sm text-slate-600"><strong>Client:</strong> <?= e($clientInfo['name']) ?></div>
                    <div class="text-sm text-slate-600"><strong>Email:</strong> <?= e($clientInfo['email']) ?></div>
                    <div class="text-sm text-slate-600"><strong>Generated:</strong> <?= date('F j, Y') ?></div>
                </div>
                <div class="text-right space-y-1">
                    <div class="text-sm text-slate-500">Total Invoiced: <strong class="text-slate-800"><?= $currency ?><?= number_format($totals['invoiced'], 2) ?></strong></div>
                    <div class="text-sm text-slate-500">Total Paid: <strong class="text-emerald-600"><?= $currency ?><?= number_format($totals['paid'], 2) ?></strong></div>
                    <div class="text-base text-slate-500 mt-2 pt-2 border-t border-slate-200">Outstanding Balance: <strong class="text-rose-600 text-lg"><?= $currency ?><?= number_format($totals['balance'], 2) ?></strong></div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100 text-xs font-semibold text-slate-600 uppercase tracking-wider border-y border-slate-200">
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Reference / Details</th>
                            <th class="px-6 py-3 text-right">Debit (Invoiced)</th>
                            <th class="px-6 py-3 text-right">Credit (Paid)</th>
                            <th class="px-6 py-3 text-right">Running Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <?php 
                        $runningBalance = 0;
                        if (empty($statement)): ?>
                            <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No transactions found for this client.</td></tr>
                        <?php else: ?>
                            <?php foreach ($statement as $tx): 
                                $runningBalance += $tx['debit'] - $tx['credit'];
                            ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500"><?= date('d M Y', strtotime($tx['date'])) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($tx['type'] === 'Invoice'): ?>
                                            <span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200">Invoice</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Payment</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800"><?= e($tx['reference']) ?></div>
                                        <div class="text-xs text-slate-500 mt-0.5"><?= e($tx['details']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-mono <?= $tx['debit'] > 0 ? 'text-slate-800 font-medium' : 'text-slate-300' ?>">
                                        <?= $tx['debit'] > 0 ? $currency . number_format($tx['debit'], 2) : '-' ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-mono <?= $tx['credit'] > 0 ? 'text-emerald-600 font-bold' : 'text-slate-300' ?>">
                                        <?= $tx['credit'] > 0 ? $currency . number_format($tx['credit'], 2) : '-' ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-mono font-bold <?= $runningBalance > 0 ? 'text-rose-600' : 'text-slate-800' ?>">
                                        <?= $currency ?><?= number_format($runningBalance, 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-slate-50 text-center">
                <button onclick="window.print()" class="px-6 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-100 transition font-medium text-sm shadow-sm">
                    <i class="fa-solid fa-print mr-2"></i> Print Statement
                </button>
            </div>
        </div>
    <?php elseif ($email): ?>
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4 text-center">
            No active invoices or transactions found for this client.
        </div>
    <?php endif; ?>
</div>
<style>
@media print {
    body * { visibility: hidden; }
    .bg-white.rounded-2xl.shadow-sm, .bg-white.rounded-2xl.shadow-sm * { visibility: visible; }
    .bg-white.rounded-2xl.shadow-sm { position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; }
    button, form { display: none !important; }
}
</style>
