<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">User & Credentials Registry</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Configure panel logins, reset passwords, update details, and assign access privileges (Roles).</p>
        </div>
        <a href="<?= url('/admin/users/create') ?>" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-3 rounded-xl text-xs shadow-md transition-all flex items-center gap-1.5 self-start">
            <i class="fa-solid fa-user-plus"></i> Create User Account
        </a>
    </div>

    <!-- Administrative Users Grid -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">User Name</th>
                        <th class="px-6 py-4">Email Credentials</th>
                        <th class="px-6 py-4">Access Level (Role)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $usr): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-black text-xs flex items-center justify-center">
                                            <?= substr($usr['name'], 0, 1) ?>
                                        </div>
                                        <span class="font-bold text-slate-900"><?= e($usr['name']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-600"><?= e($usr['email']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase tracking-wider">
                                        <?= e($usr['role_name']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold <?= $usr['status'] === 'active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200' ?> uppercase tracking-wider">
                                        <?= e($usr['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/users/edit/' . $usr['id']) ?>" class="hover:text-indigo-600 font-semibold transition-colors"><i class="fa-solid fa-user-pen mr-0.5"></i> Edit</a>
                                    
                                    <?php if ($usr['id'] !== current_user()['id']): ?>
                                        <a href="<?= url('/admin/users/delete/' . $usr['id']) ?>" onclick="return confirm('Are you sure you want to delete this user? This action is irreversible.')" class="text-red-500 hover:text-red-700 font-semibold transition-colors"><i class="fa-solid fa-user-minus mr-0.5"></i> Delete</a>
                                    <?php else: ?>
                                        <span class="text-slate-350 cursor-not-allowed" title="Self-deletion is forbidden"><i class="fa-solid fa-lock text-xs mr-0.5"></i> Locked</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
