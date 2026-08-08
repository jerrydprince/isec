<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Message Inbox</h1>
        <p class="text-xs text-slate-500 font-light mt-0.5">Read public RFP submissions, quotation requests, and consultancy inquiries.</p>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full">
            <table class="min-w-full text-left text-xs font-light text-slate-650">
                <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Sender</th>
                        <th class="px-6 py-4">Service Field</th>
                        <th class="px-6 py-4">Country</th>
                        <th class="px-6 py-4">Submitted</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $msg): ?>
                            <tr class="<?= $msg['is_read'] === 0 ? 'bg-indigo-50/20 font-semibold' : '' ?>">
                                <td class="px-6 py-4 text-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm <?= $msg['is_read'] === 0 ? 'bg-indigo-100 text-indigo-600 font-bold' : 'bg-slate-100 text-slate-450' ?>">
                                        <i class="fa-solid <?= $msg['is_read'] === 0 ? 'fa-envelope' : 'fa-envelope-open' ?>"></i>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span><?= e($msg['name']) ?></span>
                                        <span class="text-[9px] text-slate-400 truncate max-w-[150px] font-medium"><?= e($msg['company'] ?: 'Personal Inquiry') ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500"><?= e($msg['service_interested'] ?: 'General Consults') ?></td>
                                <td class="px-6 py-4 text-slate-450"><?= e($msg['country'] ?: 'Nigeria') ?></td>
                                <td class="px-6 py-4 text-slate-400 font-medium"><?= date('M d, Y H:i', strtotime($msg['created_at'])) ?></td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/messages/view/' . $msg['id']) ?>" class="bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white px-3 py-1.5 rounded-lg font-semibold tracking-wide transition-all inline-block"><i class="fa-solid fa-folder-open"></i> Read</a>
                                    <a href="<?= url('/admin/messages/delete/' . $msg['id']) ?>" onclick="return confirm('Are you sure you want to delete this message?');" class="bg-rose-50 hover:bg-rose-600 text-rose-500 hover:text-white px-3 py-1.5 rounded-lg font-semibold tracking-wide transition-all inline-block"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-450 font-medium">Your message inbox is currently empty.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
