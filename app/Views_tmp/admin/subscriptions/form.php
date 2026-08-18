<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="<?= url('/admin/subscriptions') ?>" class="text-slate-400 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800"><?= $subscription ? 'Edit Subscription' : 'Add Subscription' ?></h2>
    </div>

    <form method="POST" action="<?= url('/admin/subscriptions/' . ($subscription ? 'edit/' . $subscription['id'] : 'create')) ?>" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Service Name *</label>
                <input type="text" name="service_name" value="<?= e($subscription['service_name'] ?? '') ?>" required placeholder="e.g. Website Domain" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Provider / Platform</label>
                <input type="text" name="provider_platform" value="<?= e($subscription['provider_platform'] ?? '') ?>" placeholder="e.g. Namecheap, HostGator" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Assign to Client (Optional)</label>
                <select name="customer_id" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
                    <option value="">-- Internal / No Client --</option>
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($subscription['customer_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?> (<?= e($c['email']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <p class="text-[11px] text-slate-500 mt-1">If assigned, the client will receive the automated reminders.</p>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Billing Cycle</label>
                <select name="billing_cycle" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
                    <option value="Monthly" <?= ($subscription['billing_cycle'] ?? '') === 'Monthly' ? 'selected' : '' ?>>Monthly</option>
                    <option value="Quarterly" <?= ($subscription['billing_cycle'] ?? '') === 'Quarterly' ? 'selected' : '' ?>>Quarterly</option>
                    <option value="Yearly" <?= ($subscription['billing_cycle'] ?? 'Yearly') === 'Yearly' ? 'selected' : '' ?>>Yearly</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Cost</label>
                <input type="number" step="0.01" name="cost" value="<?= e($subscription['cost'] ?? '0.00') ?>" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none font-mono">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Start Date *</label>
                <input type="date" name="start_date" value="<?= e($subscription['start_date'] ?? date('Y-m-d')) ?>" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Next Due Date *</label>
                <input type="date" name="next_due_date" value="<?= e($subscription['next_due_date'] ?? date('Y-m-d', strtotime('+1 year'))) ?>" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-100 pt-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Automated Notifications</label>
                <label class="flex items-center gap-3 mb-3 cursor-pointer">
                    <input type="checkbox" name="notify_client" value="1" <?= (!isset($subscription) || $subscription['notify_client']) ? 'checked' : '' ?> class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="font-medium text-slate-800 text-sm">Notify Client</div>
                        <div class="text-xs text-slate-500">Send automated SMS/Email/WA to the client 14 days before and on the due date.</div>
                    </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="notify_office" value="1" <?= (!isset($subscription) || $subscription['notify_office']) ? 'checked' : '' ?> class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="font-medium text-slate-800 text-sm">Notify Office</div>
                        <div class="text-xs text-slate-500">Send an internal email to the office (<?= e(\App\Models\Settings::get('contact_email')) ?>).</div>
                    </div>
                </label>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Status</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none">
                    <option value="Active" <?= ($subscription['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Expired" <?= ($subscription['status'] ?? '') === 'Expired' ? 'selected' : '' ?>>Expired</option>
                    <option value="Cancelled" <?= ($subscription['status'] ?? '') === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="<?= url('/admin/subscriptions') ?>" class="px-6 py-2.5 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition font-medium text-sm">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-bold text-sm shadow-md shadow-indigo-200">
                Save Subscription
            </button>
        </div>
    </form>
</div>
