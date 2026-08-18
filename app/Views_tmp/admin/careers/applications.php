<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Job Candidate Applications</h1>
        <p class="text-xs text-slate-500 font-light mt-0.5">Review CVs, cover letters, and contact channels for candidate positions.</p>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full">
            <table class="min-w-full text-left text-xs font-light text-slate-650">
                <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Applicant</th>
                        <th class="px-6 py-4">Applied Position</th>
                        <th class="px-6 py-4">Contact Phone</th>
                        <th class="px-6 py-4">Cover Letter</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    <?php if (!empty($applications)): ?>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900"><?= e($app['name']) ?></span>
                                        <span class="text-[9px] text-slate-400 font-semibold"><?= e($app['email']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><span class="bg-indigo-50 text-indigo-650 px-2 py-0.5 rounded text-[10px] font-bold uppercase"><?= e($app['job_title']) ?></span></td>
                                <td class="px-6 py-4 text-slate-500"><?= e($app['phone']) ?></td>
                                <td class="px-6 py-4 text-slate-500 max-w-[200px] truncate" title="<?= e($app['cover_letter']) ?>"><?= e($app['cover_letter'] ?: 'No letter attached') ?></td>
                                <td class="px-6 py-4 text-right">
                                    <a href="<?= url('/' . $app['cv_path']) ?>" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-bold transition-all text-xs inline-flex items-center gap-1.5 shadow-sm">
                                        <i class="fa-solid fa-cloud-arrow-down"></i> Download Resume CV
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-450 font-medium">No candidate applications submitted yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
