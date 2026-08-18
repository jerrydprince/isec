
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Accounting Dashboard</h2>
            <p class="text-sm text-slate-500">Financial overview and recent transactions.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="<?= url('/admin/billing') ?>" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium text-sm flex items-center gap-2" title="Record a payment against an invoice"><i class="fa-solid fa-money-bill-wave"></i> Record Income</a>
            <a href="<?= url('/admin/accounting/expenses?action=record') ?>" class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition font-medium text-sm flex items-center gap-2" title="Record a new company expense"><i class="fa-solid fa-receipt"></i> Record Expense</a>
            <div class="w-px h-8 bg-slate-200 mx-1 hidden sm:block"></div>
            <a href="<?= url('/admin/accounting/reports') ?>" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium text-sm flex items-center gap-2"><i class="fa-solid fa-file-invoice"></i> Detailed Reports</a>
            <a href="<?= url('/admin/accounting/expenses') ?>" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition font-medium text-sm">Manage Expenses</a>
            <a href="<?= url('/admin/accounting/statement') ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">Client Statements</a>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Income -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
                <div class="text-sm font-medium text-slate-500 mb-1">Total Income</div>
                <div class="text-2xl font-bold text-slate-800"><?= $currency ?><?= number_format($totalIncome, 2) ?></div>
            </div>
        </div>

        <!-- Expenses -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>
                <div class="text-sm font-medium text-slate-500 mb-1">Total Expenses</div>
                <div class="text-2xl font-bold text-slate-800"><?= $currency ?><?= number_format($totalExpenses, 2) ?></div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-indigo-600 rounded-2xl p-6 shadow-md relative overflow-hidden group hover:shadow-lg transition text-white">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="text-sm font-medium text-indigo-100 mb-1">Net Profit</div>
                <div class="text-2xl font-bold"><?= $currency ?><?= number_format($netProfit, 2) ?></div>
            </div>
        </div>

        <!-- Receivables -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="text-sm font-medium text-slate-500 mb-1">Outstanding Receivables</div>
                <div class="text-2xl font-bold text-slate-800"><?= $currency ?><?= number_format($totalReceivables, 2) ?></div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Recent Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Category/Method</th>
                        <th class="px-6 py-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (empty($transactions)): ?>
                        <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">No recent transactions.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $tx): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600"><?= date('M d, Y', strtotime($tx['date'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($tx['type'] === 'Income'): ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Income</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">Expense</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-slate-600"><?= e($tx['method']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-mono font-bold <?= $tx['type'] === 'Income' ? 'text-emerald-600' : 'text-rose-600' ?>">
                                    <?= $tx['type'] === 'Income' ? '+' : '-' ?><?= $currency ?><?= number_format($tx['amount'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
