<?php include PUBLIC_DIR . '/../app/views/layouts/admin_header.php'; ?>
<?php include PUBLIC_DIR . '/../app/views/layouts/admin_sidebar.php'; ?>

<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Blog Categories</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Manage taxonomy for insights, case studies, and whitepapers.</p>
        </div>
        <a href="<?= url('/admin/insights') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Insights</a>
    </div>

    <?php if ($flash = (new \App\Core\Session())->getFlash('success')): ?>
        <div class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm border border-emerald-100 flex items-center">
            <i class="fa-solid fa-circle-check mr-2"></i> <?= $flash ?>
        </div>
    <?php endif; ?>
    <?php if ($flash = (new \App\Core\Session())->getFlash('error')): ?>
        <div class="bg-rose-50 text-rose-600 px-4 py-3 rounded-xl text-sm border border-rose-100 flex items-center">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i> <?= $flash ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Add New Category -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4 text-sm">Add New Category</h3>
                <form action="<?= url('/admin/insights/categories/create') ?>" method="POST" class="space-y-4">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Category Name *</label>
                        <input type="text" name="name" placeholder="e.g. Cybersecurity" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                        Create Category
                    </button>
                </form>
            </div>
        </div>

        <!-- List Categories -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-3 px-6 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">ID</th>
                            <th class="py-3 px-6 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Name</th>
                            <th class="py-3 px-6 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Slug</th>
                            <th class="py-3 px-6 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-xs font-light">
                                No categories found. Create one to get started.
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $cat): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-4 px-6 text-slate-400 font-mono text-xs">#<?= $cat['id'] ?></td>
                                <td class="py-4 px-6 font-medium text-slate-800"><?= e($cat['name']) ?></td>
                                <td class="py-4 px-6 text-slate-500 font-mono text-xs"><?= e($cat['slug']) ?></td>
                                <td class="py-4 px-6 text-right">
                                    <a href="<?= url('/admin/insights/categories/delete/' . $cat['id']) ?>" class="text-slate-300 hover:text-rose-500 transition-colors" onclick="return confirm('Delete this category? This might affect existing blogs.');" title="Delete Category">
                                        <i class="fa-solid fa-trash"></i>
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
</div>

<?php include PUBLIC_DIR . '/../app/views/layouts/admin_footer.php'; ?>
