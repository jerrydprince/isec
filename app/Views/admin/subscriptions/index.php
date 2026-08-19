<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Subscriptions Management</h2>
            <p class="text-sm text-slate-500">Track recurring services, domains, and third-party renewals.</p>
        </div>
        <a href="<?= url('/admin/subscriptions/create') ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Subscription
        </a>
    </div>

    <!-- Search/Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" action="<?= url('/admin/subscriptions') ?>" class="flex gap-4">
            <div class="flex-1 relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="<?= e($_GET['search'] ?? '') ?>" placeholder="Search by service name, client name or email..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all outline-none">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition font-medium text-sm shadow-md">
                Search
            </button>
            <?php if (!empty($_GET['search'])): ?>
                <a href="<?= url('/admin/subscriptions') ?>" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition font-medium text-sm flex items-center">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4">Service & Provider</th>
                        <th class="px-6 py-4">Client</th>
                        <th class="px-6 py-4">Next Due Date</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Cost</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (empty($subscriptions)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-2xl">
                                    <i class="fa-solid fa-rotate"></i>
                                </div>
                                <p>No subscriptions found.</p>
                                <?php if (empty($_GET['search'])): ?>
                                    <a href="<?= url('/admin/subscriptions/create') ?>" class="text-indigo-600 font-medium hover:underline mt-2 inline-block">Add your first subscription</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subscriptions as $sub): 
                            $daysLeft = (strtotime($sub['next_due_date']) - time()) / (60 * 60 * 24);
                            $isExpiringSoon = $daysLeft > 0 && $daysLeft <= 14 && $sub['status'] == 'Active';
                        ?>
                            <tr class="hover:bg-slate-50 transition-colors <?= $isExpiringSoon ? 'bg-amber-50/30' : '' ?>">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= e($sub['service_name']) ?></div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        <?= e($sub['provider_platform']) ?: 'Internal' ?> &middot; <?= e($sub['billing_cycle']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($sub['client_name']): ?>
                                        <div class="font-medium text-slate-800"><?= e($sub['client_name']) ?></div>
                                        <div class="text-xs text-slate-500 mt-0.5"><?= e($sub['client_email']) ?></div>
                                        <?php if ($sub['client_phone']): ?>
                                            <div class="text-[10px] text-slate-400 font-mono mt-0.5"><i class="fa-solid fa-phone mr-1"></i><?= e($sub['client_phone']) ?></div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-slate-400 italic text-xs">No Client Attached</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold <?= $sub['next_due_date'] < date('Y-m-d') ? 'text-rose-600' : 'text-slate-700' ?>">
                                        <?= date('M d, Y', strtotime($sub['next_due_date'])) ?>
                                    </div>
                                    <?php if ($isExpiringSoon): ?>
                                        <div class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mt-1"><i class="fa-solid fa-clock mr-1"></i> Due Soon</div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($sub['status'] === 'Active'): ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Active</span>
                                    <?php elseif ($sub['status'] === 'Expired'): ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200">Expired</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-slate-800">
                                    <?= \App\Models\Settings::get('currency_symbol', '₦') ?><?= number_format($sub['cost'], 2) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button onclick="openRemindModal(<?= $sub['id'] ?>, '<?= e($sub['service_name']) ?>')" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors mr-1" title="Send Manual Reminder">
                                        <i class="fa-solid fa-bell"></i>
                                    </button>
                                    <a href="<?= url('/admin/subscriptions/edit/' . $sub['id']) ?>" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors mr-1" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= url('/admin/subscriptions/delete/' . $sub['id']) ?>" onclick="return confirm('Are you sure you want to delete this subscription?');" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Delete">
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

<!-- Send Reminder Modal -->
<div id="remindModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
            <form action="<?= url('/admin/subscriptions/remind') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="subscription_id" id="remind_sub_id" value="">
                
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-slate-800">Send Manual Reminder</h3>
                        <button type="button" onclick="document.getElementById('remindModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="text-sm text-slate-500 mb-5">Select channels and templates to manually trigger a reminder for <strong id="remind_service_name" class="text-slate-700"></strong>.</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Notification Channels</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="channels[]" value="Email" checked class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-medium text-slate-700">Email</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="channels[]" value="SMS" checked class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-medium text-slate-700">SMS</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="channels[]" value="WhatsApp" checked class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-medium text-slate-700">WhatsApp</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Message Template</label>
                            <select name="template_type" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-2.5 text-sm outline-none">
                                <option value="14_days">14-Days Reminder Template</option>
                                <option value="7_days">7-Days Reminder Template</option>
                                <option value="0_days">Due-Date (URGENT) Template</option>
                                <option value="overdue">Overdue Notice Template</option>
                                <?php if (!empty($customTemplates)): ?>
                                    <optgroup label="Custom Templates">
                                        <?php foreach ($customTemplates as $tmpl): ?>
                                            <option value="<?= $tmpl['id'] ?>"><?= htmlspecialchars($tmpl['name']) ?> (<?= htmlspecialchars($tmpl['type']) ?>)</option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('remindModal').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-100 transition font-medium text-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition font-bold text-sm shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Send Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRemindModal(subId, serviceName) {
    document.getElementById('remind_sub_id').value = subId;
    document.getElementById('remind_service_name').innerText = serviceName;
    document.getElementById('remindModal').classList.remove('hidden');
}
</script>
