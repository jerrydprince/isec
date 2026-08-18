<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dynamic Pages CMS</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Manage and create custom text/image pages for your website.</p>
        </div>
        <a href="<?= url('/admin/dynamic-pages/create') ?>" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-3 rounded-xl text-xs shadow-md transition-all flex items-center gap-1.5 self-start">
            <i class="fa-solid fa-plus"></i> Create New Page
        </a>
    </div>

    <!-- Dynamic Pages Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Page Title</th>
                        <th class="px-6 py-4">URL Slug</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Created At</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $page): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    <?= e($page['title']) ?>
                                </td>
                                <td class="px-6 py-4 font-mono font-light text-slate-500">
                                    /page/<?= e($page['slug']) ?>
                                    <a href="<?= url('/page/' . $page['slug']) ?>" target="_blank" class="text-indigo-500 hover:text-indigo-700 ml-2" title="View Page"><i class="fa-solid fa-external-link"></i></a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold <?= $page['status'] === 'published' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' ?> uppercase tracking-wider">
                                        <?= e($page['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-light text-slate-500">
                                    <?= date('M d, Y', strtotime($page['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/dynamic-pages/edit/' . $page['id']) ?>" class="hover:text-indigo-600 font-semibold transition-colors"><i class="fa-solid fa-pen-to-square mr-0.5"></i> Edit</a>
                                    <a href="<?= url('/admin/dynamic-pages/delete/' . $page['id']) ?>" onclick="return confirm('Are you sure you want to delete this page? This action cannot be undone.')" class="text-red-500 hover:text-red-700 font-semibold transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-regular fa-file-lines text-3xl mb-3 block text-slate-200"></i>
                                <span>No dynamic pages found in the database.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
