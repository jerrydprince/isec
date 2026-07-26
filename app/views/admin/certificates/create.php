<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Issue Trainee Certificate</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Register a new certificate validation log for trainees and certifications.</p>
        </div>
        <a href="<?= url('/admin/certificates') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to listing</a>
    </div>

    <!-- Form Panel Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <form action="<?= url('/admin/certificates/create') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Certificate Code / Registration Number *</label>
                    <input type="text" name="certificate_number" placeholder="e.g. ISEC-CERT-2026-0004" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Recipient Trainee Full Name *</label>
                    <input type="text" name="recipient_name" placeholder="e.g. Amina Yusuf Babangida" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Course Name / Training Module *</label>
                <input type="text" name="course_name" placeholder="e.g. Enterprise Systems & E-Governance Automation" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Date Issued *</label>
                    <input type="date" name="issue_date" value="<?= date('Y-m-d') ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Date of Expiry (Optional)</label>
                    <input type="date" name="expiry_date" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Grade Status / Rating</label>
                    <input type="text" name="grade_status" value="Certified" placeholder="e.g. Certified with Distinction" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Upload Digital PDF Certificate Copy (Optional)</label>
                <input type="file" name="pdf_file" accept=".pdf" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                <span class="text-[10px] text-slate-400 mt-1 block">Accepts PDF format only. File is securely stored in database archives.</span>
            </div>

            <hr class="border-slate-100">

            <div class="flex justify-end gap-3">
                <a href="<?= url('/admin/certificates') ?>" class="border border-slate-200 hover:bg-slate-50 font-bold px-6 py-3 rounded-xl text-xs text-slate-550 transition-all">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-xl text-xs shadow-md transition-all">Register Certificate</button>
            </div>
        </form>
    </div>
</div>
