
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="<?= url('/admin/accounting') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors" title="Back to Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-slate-800">Expenses</h2>
            </div>
            <p class="text-sm text-slate-500 ml-7">Record and manage project costs and operational expenses.</p>
        </div>
        <button onclick="document.getElementById('expenseModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Record Expense
        </button>
    </div>

    <!-- Expenses Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Title / Description</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (empty($expenses)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-2xl">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <p>No expenses recorded yet.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($expenses as $exp): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-500"><?= date('M d, Y', strtotime($exp['expense_date'])) ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= e($exp['title']) ?></div>
                                    <?php if ($exp['description']): ?>
                                        <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs"><?= e($exp['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200"><?= e($exp['category']) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-slate-800">
                                    <?= $currency ?><?= number_format($exp['amount'], 2) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="<?= url('/admin/accounting/expenses/delete/' . $exp['id']) ?>" onclick="return confirm('Delete this expense?')" class="text-slate-400 hover:text-rose-500 transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($_GET['action']) && $_GET['action'] === 'record'): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('expenseModal').classList.remove('hidden');
    });
</script>
<?php endif; ?>

<!-- Add Expense Modal -->
<div id="expenseModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all scale-100 opacity-100 duration-200">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800">Record Expense</h3>
            <button type="button" onclick="document.getElementById('expenseModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form method="POST" action="<?= url('/admin/accounting/expenses/store') ?>">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required placeholder="e.g. Server Hosting" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Amount <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><?= $currency ?></span>
                            <input type="number" step="0.01" name="amount" required class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Date <span class="text-rose-500">*</span></label>
                        <input type="date" name="expense_date" value="<?= date('Y-m-d') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Category <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= e($cat) ?>"><?= e($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Description (Optional)</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('expenseModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 rounded-xl transition-all">Save Expense</button>
            </div>
        </form>
    </div>
</div>
