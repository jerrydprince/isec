

<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Payment Transactions</h1>
        <p class="text-sm text-slate-500">View customer support plan subscriptions.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">Date</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Customer Name</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Email</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Plan</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Amount</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Reference</th>
                    <th class="p-4 font-semibold border-b border-slate-200 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">
                            <i class="fa-solid fa-credit-card text-4xl mb-3 text-slate-200"></i>
                            <p>No payments recorded yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($payments as $payment): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm text-slate-500 whitespace-nowrap"><?= date('M j, Y h:i A', strtotime($payment['created_at'])) ?></td>
                            <td class="p-4 text-sm font-medium text-slate-900"><?= e($payment['name']) ?></td>
                            <td class="p-4 text-sm text-slate-500"><?= e($payment['email']) ?></td>
                            <td class="p-4 text-sm font-bold text-teal-600"><?= e($payment['plan']) ?></td>
                            <td class="p-4 text-sm font-medium text-slate-900">₦<?= number_format($payment['amount']) ?></td>
                            <td class="p-4 text-xs font-mono text-slate-500"><?= e($payment['reference']) ?></td>
                            <td class="p-4 text-center">
                                <?php if ($payment['status'] === 'success'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        <i class="fa-solid fa-check-circle"></i> Success
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
