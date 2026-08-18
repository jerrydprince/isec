<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">CRM & Customers</h1>
        <p class="text-sm text-slate-500">Manage your customer database and marketing contacts.</p>
    </div>
    <div class="flex gap-3">
        <button type="button" onclick="document.getElementById('addClientModal').classList.remove('hidden')" class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md transition-all">
            <i class="fa-solid fa-plus mr-2"></i> Add Client
        </button>
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
                    <th class="p-4 font-semibold border-b border-slate-200 text-right">Actions</th>
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
                            <td class="p-4 whitespace-nowrap text-right">
                                <a href="<?= url('/admin/crm/customer-delete/' . $customer['id']) ?>" onclick="return confirm('Are you sure you want to delete this customer?');" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Delete">
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

<!-- Add Client Modal -->
<div id="addClientModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form action="<?= url('/admin/crm/customer-store') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-slate-800">Add New Client</h3>
                        <button type="button" onclick="document.getElementById('addClientModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Client Name *</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-2.5 text-sm outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Email Address *</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-2.5 text-sm outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Phone Number</label>
                            <input type="text" name="phone" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-2.5 text-sm outline-none">
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('addClientModal').classList.add('hidden')" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-100 transition font-medium text-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition font-bold text-sm shadow-md">Add Client</button>
                </div>
            </form>
        </div>
    </div>
</div>
