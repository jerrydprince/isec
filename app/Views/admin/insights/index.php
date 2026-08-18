<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manage Insights & Blogs</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Author articles, case study documents, and executive whitepapers.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= url('/admin/insights/categories') ?>" class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-bold text-xs px-5 py-3 rounded-xl shadow-sm flex items-center gap-2 transition-all">
                <i class="fa-solid fa-tags"></i> Manage Categories
            </a>
            <a href="<?= url('/admin/insights/create') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Write Insight Post
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full">
            <table class="min-w-full text-left text-xs font-light text-slate-650">
                <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Published Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($blogs)): ?>
                        <?php foreach ($blogs as $blog): ?>
                            <tr>
                                <td class="px-6 py-4 font-semibold text-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 text-sm">
                                        <i class="fa-solid fa-newspaper"></i>
                                    </div>
                                    <span class="truncate max-w-[200px]"><?= e($blog['title']) ?></span>
                                </td>
                                <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-blue-50 text-blue-600"><?= e($blog['type']) ?></span></td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded text-[9px] font-bold uppercase <?= $blog['status'] === 'published' ? 'bg-emerald-500/10 text-emerald-600' : 'bg-slate-105 text-slate-500' ?>">
                                        <?= e($blog['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-450"><?= $blog['published_at'] ? date('Y-m-d', strtotime($blog['published_at'])) : 'Draft' ?></td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/insights/edit/' . $blog['id']) ?>" class="bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white px-3 py-1.5 rounded-lg font-semibold tracking-wide transition-all inline-block"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a href="<?= url('/admin/insights/delete/' . $blog['id']) ?>" onclick="return confirm('Are you sure you want to delete this post?');" class="bg-rose-50 hover:bg-rose-600 text-rose-500 hover:text-white px-3 py-1.5 rounded-lg font-semibold tracking-wide transition-all inline-block"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-450 font-medium">No publications posted yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
