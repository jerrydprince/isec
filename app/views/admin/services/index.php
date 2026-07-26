<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manage Services</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Define core business services and e-governance solutions offered by ISEC.</p>
        </div>
        <a href="<?= url('/admin/services/create') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Create Service
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full">
            <table class="min-w-full text-left text-xs font-light text-slate-650">
                <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $srv): ?>
                            <tr>
                                <td class="px-6 py-4 font-semibold text-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm">
                                        <i class="fa-solid <?= e($srv['icon']) ?>"></i>
                                    </div>
                                    <span><?= e($srv['title']) ?></span>
                                </td>
                                <td class="px-6 py-4 text-slate-500"><?= e($srv['slug']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded text-[9px] font-bold uppercase <?= $srv['status'] === 'published' ? 'bg-emerald-500/10 text-emerald-600' : 'bg-slate-105 text-slate-500' ?>">
                                        <?= e($srv['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/services/edit/' . $srv['id']) ?>" class="bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white px-3 py-1.5 rounded-lg font-semibold tracking-wide transition-all inline-block"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="<?= url('/admin/services/delete/' . $srv['id']) ?>" onclick="return confirm('Are you sure you want to delete this service?');" class="bg-rose-50 hover:bg-rose-600 text-rose-500 hover:text-white px-3 py-1.5 rounded-lg font-semibold tracking-wide transition-all inline-block"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-450 font-medium">No services registered yet. Click "Create Service" to add one.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
