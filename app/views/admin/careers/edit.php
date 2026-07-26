<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Vacancy</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Modify career specifications for: <?= e($job['title']) ?></p>
        </div>
        <a href="<?= url('/admin/careers') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to listing</a>
    </div>

    <!-- Form Panel Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <form action="<?= url('/admin/careers/edit/' . $job['id']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Vacancy Title *</label>
                    <input type="text" name="title" value="<?= e($job['title']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Job Type *</label>
                    <select name="job_type" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                        <option value="full-time" <?= $job['job_type'] === 'full-time' ? 'selected' : '' ?>>Full-time Employee</option>
                        <option value="part-time" <?= $job['job_type'] === 'part-time' ? 'selected' : '' ?>>Part-time Staff</option>
                        <option value="contract" <?= $job['job_type'] === 'contract' ? 'selected' : '' ?>>Contract Consultant</option>
                        <option value="internship" <?= $job['job_type'] === 'internship' ? 'selected' : '' ?>>Graduate Trainee / Intern</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Work Location</label>
                    <input type="text" name="location" value="<?= e($job['location']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Vacancy Status</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                        <option value="open" <?= $job['status'] === 'open' ? 'selected' : '' ?>>Open (Accepting submissions)</option>
                        <option value="closed" <?= $job['status'] === 'closed' ? 'selected' : '' ?>>Closed (Archived)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Role Specifications / Overview *</label>
                <textarea name="description" rows="5" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required><?= e($job['description']) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Requirements & Required Credentials *</label>
                <textarea name="requirements" rows="5" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required><?= e($job['requirements']) ?></textarea>
            </div>

            <hr class="border-slate-100">

            <div class="flex justify-end gap-3">
                <a href="<?= url('/admin/careers') ?>" class="border border-slate-200 hover:bg-slate-50 font-bold px-6 py-3 rounded-xl text-xs text-slate-550 transition-all">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-xl text-xs shadow-md transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>
