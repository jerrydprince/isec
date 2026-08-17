<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Trainee Certificate</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Modify training details or replace certificate document attachment logs.</p>
        </div>
        <a href="<?= url('/admin/certificates') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to listing</a>
    </div>

    <!-- Form Panel Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <form action="<?= url('/admin/certificates/edit/' . $certificate['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Certificate Registration Number (Locked)</label>
                    <input type="text" value="<?= e($certificate['certificate_number']) ?>" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-xs outline-none text-slate-500 cursor-not-allowed font-mono font-bold" readonly>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Recipient Trainee Full Name *</label>
                    <input type="text" name="recipient_name" value="<?= e($certificate['recipient_name']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Course Name / Training Module *</label>
                <input type="text" name="course_name" value="<?= e($certificate['course_name']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Date Issued *</label>
                    <input type="date" name="issue_date" value="<?= e($certificate['issue_date']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Date of Expiry (Optional)</label>
                    <input type="date" name="expiry_date" value="<?= e($certificate['expiry_date']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Grade Status / Rating</label>
                    <input type="text" name="grade_status" value="<?= e($certificate['grade_status']) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Upload Digital Certificate Copy (Replaces existing)</label>
                <input type="file" name="pdf_file" accept=".pdf,.png,.jpg,.jpeg" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                <?php if (!empty($certificate['pdf_path'])): ?>
                    <span class="text-[10px] text-slate-400 mt-2 block">
                        <i class="fa-solid fa-file text-indigo-500 mr-1"></i> Current file: 
                        <a href="<?= url('/' . $certificate['pdf_path']) ?>" target="_blank" class="text-indigo-600 hover:underline font-semibold font-mono"><?= e(basename($certificate['pdf_path'])) ?></a>
                    </span>
                <?php else: ?>
                    <span class="text-[10px] text-slate-400 mt-1 block">Accepts PDF, PNG, or JPG formats.</span>
                <?php endif; ?>
            </div>

            <hr class="border-slate-100">

            <div class="flex justify-end gap-3">
                <a href="<?= url('/admin/certificates') ?>" class="border border-slate-200 hover:bg-slate-50 font-bold px-6 py-3 rounded-xl text-xs text-slate-550 transition-all">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-xl text-xs shadow-md transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>
