<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">CRM & Customers</h1>
        <p class="text-sm text-slate-500">Manage your customer database and marketing contacts.</p>
    </div>
    <div>
        <a href="<?= url('/admin/crm/campaigns') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md transition-all">
            <i class="fa-solid fa-bullhorn mr-2"></i> Marketing Campaigns
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-110 transition-transform"></div>
        <div class="relative">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="text-sm font-medium text-slate-500 mb-1">Total Customers</div>
            <div class="text-2xl font-bold text-slate-800"><?= number_format($totalCustomers) ?></div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Customer List</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">Date Added</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Customer Name</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Email</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Phone</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($customers)): ?>
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400">
                            <i class="fa-solid fa-users text-4xl mb-3 text-slate-200"></i>
                            <p>No customers recorded yet.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm text-slate-500 whitespace-nowrap"><?= date('M j, Y h:i A', strtotime($customer['created_at'])) ?></td>
                            <td class="p-4 text-sm font-medium text-slate-900"><?= e($customer['name']) ?></td>
                            <td class="p-4 text-sm text-slate-500"><?= e($customer['email']) ?></td>
                            <td class="p-4 text-sm font-mono text-slate-500"><?= e($customer['phone'] ?: 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
