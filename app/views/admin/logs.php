<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Security Audit Trail</h1>
        <p class="text-xs text-slate-500 font-light mt-0.5">Cryptographic actions logging tracking database operations and access checks.</p>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full">
            <table class="min-w-full text-left text-xs font-light text-slate-650">
                <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Action Event</th>
                        <th class="px-6 py-4">Details</th>
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4">Logged Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="px-6 py-4 text-slate-800">
                                    <div class="flex flex-col">
                                        <span class="font-bold"><?= e($log['user_name'] ?: 'Public / Unauth') ?></span>
                                        <span class="text-[9px] text-slate-400 font-semibold"><?= e($log['user_email'] ?: 'No email') ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded text-[9px] font-bold uppercase bg-slate-100 text-slate-600 border border-slate-200">
                                        <?= e($log['action']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-[200px] truncate" title="<?= e($log['details']) ?>"><?= e($log['details']) ?></td>
                                <td class="px-6 py-4 text-slate-450 font-semibold"><?= e($log['ip_address']) ?></td>
                                <td class="px-6 py-4 text-slate-400 font-semibold"><?= date('Y-m-d H:i:s', strtotime($log['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-450 font-medium">No audit logs stored yet in database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
