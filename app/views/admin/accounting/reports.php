<div class="space-y-6 print:space-y-4">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 print:hidden">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?= url('/admin/accounting') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors" title="Back to Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-slate-800">Financial Reports</h2>
            </div>
            <p class="text-sm text-slate-500 ml-7">Generate detailed Profit & Loss and Tax statements.</p>
        </div>
        <button onclick="window.print()" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition font-bold shadow-md shadow-slate-200 flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Print Report
        </button>
    </div>

    <!-- Print Only Header -->
    <div class="hidden print:block mb-8 text-center border-b pb-4">
        <h1 class="text-3xl font-bold text-slate-800"><?= e($siteName) ?></h1>
        <h2 class="text-xl text-slate-600 mt-1">Financial Report</h2>
        <p class="text-sm text-slate-500 mt-2">Period: <?= date('F j, Y', strtotime($startDate)) ?> to <?= date('F j, Y', strtotime($endDate)) ?></p>
        <p class="text-xs text-slate-400 mt-1">Generated on <?= date('F j, Y, g:i a') ?></p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 print:hidden">
        <form method="GET" action="<?= url('/admin/accounting/reports') ?>" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="<?= e($startDate) ?>" class="px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="<?= e($endDate) ?>" class="px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-bold shadow-md shadow-indigo-200 h-[42px]">
                Filter Data
            </button>
            <div class="ml-auto text-sm text-slate-500 flex items-center">
                <i class="fa-solid fa-calendar-days mr-2"></i> Showing data for <?= date('M d, Y', strtotime($startDate)) ?> &mdash; <?= date('M d, Y', strtotime($endDate)) ?>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 print:grid-cols-1 print:gap-8">
        
        <!-- Profit and Loss Statement -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden print:shadow-none print:border-slate-300">
            <div class="p-6 border-b border-slate-100 bg-slate-50 print:bg-transparent print:border-b-2 print:border-slate-800">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-scale-balanced text-indigo-600 print:hidden"></i> Profit & Loss Statement
                </h3>
            </div>
            <div class="p-0">
                <table class="w-full text-left border-collapse">
                    <!-- Revenue Section -->
                    <thead>
                        <tr class="bg-emerald-50/50 print:bg-slate-100">
                            <th class="px-6 py-3 text-xs font-bold text-emerald-800 uppercase tracking-wider" colspan="2">Revenue (Income)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <tr>
                            <td class="px-6 py-4 text-slate-600 pl-10">Invoiced Payments Received</td>
                            <td class="px-6 py-4 text-right font-mono text-slate-800"><?= $currency ?><?= number_format($invoiceRevenue, 2) ?></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-slate-600 pl-10">Direct Online Subscriptions</td>
                            <td class="px-6 py-4 text-right font-mono text-slate-800"><?= $currency ?><?= number_format($onlineRevenue, 2) ?></td>
                        </tr>
                        <tr class="bg-slate-50 print:bg-transparent font-bold">
                            <td class="px-6 py-4 text-slate-800">Total Revenue</td>
                            <td class="px-6 py-4 text-right font-mono text-emerald-600 print:text-slate-800 text-base"><?= $currency ?><?= number_format($totalRevenue, 2) ?></td>
                        </tr>
                    </tbody>

                    <!-- Expenses Section -->
                    <thead>
                        <tr class="bg-rose-50/50 print:bg-slate-100 border-t border-slate-200">
                            <th class="px-6 py-3 text-xs font-bold text-rose-800 uppercase tracking-wider" colspan="2">Cost & Expenses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($expensesByCategory)): ?>
                            <tr><td colspan="2" class="px-6 py-4 text-center text-slate-400 italic">No expenses recorded for this period.</td></tr>
                        <?php else: ?>
                            <?php foreach ($expensesByCategory as $exp): ?>
                                <tr>
                                    <td class="px-6 py-4 text-slate-600 pl-10"><?= e($exp['category']) ?></td>
                                    <td class="px-6 py-4 text-right font-mono text-slate-800"><?= $currency ?><?= number_format($exp['total'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <tr class="bg-slate-50 print:bg-transparent font-bold">
                            <td class="px-6 py-4 text-slate-800">Total Expenses</td>
                            <td class="px-6 py-4 text-right font-mono text-rose-600 print:text-slate-800 text-base"><?= $currency ?><?= number_format($totalExpenses, 2) ?></td>
                        </tr>
                    </tbody>

                    <!-- Net Profit -->
                    <tfoot>
                        <tr class="border-t-2 border-slate-800 print:border-black bg-indigo-50/50 print:bg-transparent">
                            <td class="px-6 py-5 text-base font-bold text-slate-900 uppercase">Net Profit / (Loss)</td>
                            <td class="px-6 py-5 text-right font-mono font-bold text-xl <?= $netProfit >= 0 ? 'text-indigo-700' : 'text-rose-600' ?> print:text-black">
                                <?= $netProfit < 0 ? '(' : '' ?><?= $currency ?><?= number_format(abs($netProfit), 2) ?><?= $netProfit < 0 ? ')' : '' ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tax Report -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden print:shadow-none print:border-slate-300 self-start">
            <div class="p-6 border-b border-slate-100 bg-slate-50 print:bg-transparent print:border-b-2 print:border-slate-800">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-building-columns text-amber-500 print:hidden"></i> Tax Liability Report
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Tax Billed -->
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-bold text-slate-800">Total Tax Billed</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-xs">Total tax amount generated on all invoices issued within this period, regardless of payment status.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-mono font-bold text-slate-800"><?= $currency ?><?= number_format($taxBilled, 2) ?></div>
                    </div>
                </div>
                
                <hr class="border-slate-100 print:border-slate-200">

                <!-- Tax Collected -->
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-bold text-slate-800">Total Tax Collected</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-xs">Calculated pro-rata based on actual payments received. This represents the tax portion of money actually in the bank.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-mono font-bold text-emerald-600 print:text-black"><?= $currency ?><?= number_format($taxCollected, 2) ?></div>
                    </div>
                </div>
                
                <?php if ($taxBilled > $taxCollected): ?>
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl print:border-none print:p-0">
                        <p class="text-sm text-amber-800 font-medium">
                            <i class="fa-solid fa-circle-info mr-1"></i> You have <strong><?= $currency ?><?= number_format($taxBilled - $taxCollected, 2) ?></strong> in outstanding uncollected taxes.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
