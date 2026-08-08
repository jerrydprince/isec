<!-- Premium Hero Header -->
<section class="relative bg-slate-900 text-white overflow-hidden py-16 lg:py-24 gradient-mesh">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:30px_30px]" style="mask-image: radial-gradient(white, transparent);"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="fade-up">
        <span class="bg-teal-500/10 text-accent font-bold text-xs uppercase tracking-widest px-4 py-1.5 rounded-full border border-teal-500/20">Compliance Registry</span>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mt-4">Certificate Verification System</h1>
        <p class="mt-4 text-base text-slate-300 max-w-2xl mx-auto font-light leading-relaxed">
            Verify the authenticity of professional certifications, training modules, and capacity-building credentials issued by ISEC.
        </p>
    </div>
</section>

<!-- Verification Search Console -->
<section class="py-16 bg-slate-50 dark:bg-slate-900/40">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Form Card -->
        <div class="bg-white dark:bg-slate-950 rounded-3xl border border-slate-200/60 dark:border-slate-850 p-8 shadow-md" data-aos="fade-up">
            <form action="<?= url('/verify-certificate') ?>" method="GET" class="space-y-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Enter Certificate Registration Number</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="fa-solid fa-certificate"></i></span>
                        <input type="text" name="cert_number" value="<?= e($cert_number ?? '') ?>" placeholder="e.g. ISEC-CERT-2026-0001" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-2xl pl-11 pr-4 py-4 text-sm outline-none transition-all text-slate-800 dark:bg-slate-900 dark:border-slate-800 dark:text-white" required>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-4 rounded-2xl text-sm shadow-md transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Verify Credential
                    </button>
                </div>
            </form>
        </div>

        <!-- Verification Results Display -->
        <?php if ($searched): ?>
            <div class="mt-10" data-aos="fade-up">
                <?php if ($certificate): ?>
                    <!-- Success Card (VERIFIED) -->
                    <div class="glassmorphism rounded-3xl border border-emerald-500/30 overflow-hidden shadow-xl bg-white/40 dark:bg-slate-950/40 p-8 md:p-10 relative">
                        <!-- Verification Ribbon -->
                        <div class="absolute top-6 right-6 flex items-center gap-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-widest px-4 py-1.5 rounded-full border border-emerald-500/20">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                            <i class="fa-solid fa-circle-check"></i> Verified
                        </div>

                        <div class="flex flex-col md:flex-row items-center gap-6 mb-8 mt-4 md:mt-0">
                            <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl border border-emerald-500/20 flex-shrink-0">
                                <i class="fa-solid fa-stamp"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Official Verification Record</span>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mt-0.5">ISEC Registrar Database Match</h3>
                            </div>
                        </div>

                        <hr class="border-slate-200/60 dark:border-slate-850 mb-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                            <div>
                                <span class="font-bold text-slate-400 block text-xs uppercase tracking-wider mb-1">Recipient Name</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200 text-base"><?= e($certificate['recipient_name']) ?></span>
                            </div>
                            <div>
                                <span class="font-bold text-slate-400 block text-xs uppercase tracking-wider mb-1">Certificate Number</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200 text-base font-mono"><?= e($certificate['certificate_number']) ?></span>
                            </div>
                            <div class="md:col-span-2">
                                <span class="font-bold text-slate-400 block text-xs uppercase tracking-wider mb-1">Course of Study / Training Module</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200 text-base"><?= e($certificate['course_name']) ?></span>
                            </div>
                            <div>
                                <span class="font-bold text-slate-400 block text-xs uppercase tracking-wider mb-1">Date Issued</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200"><?= date('F d, Y', strtotime($certificate['issue_date'])) ?></span>
                            </div>
                            <div>
                                <span class="font-bold text-slate-400 block text-xs uppercase tracking-wider mb-1">Status / Grade</span>
                                <span class="font-semibold text-slate-850 dark:text-slate-200">
                                    <?= e($certificate['grade_status']) ?>
                                    <?php if ($certificate['expiry_date'] && strtotime($certificate['expiry_date']) < time()): ?>
                                        <span class="text-red-500 font-bold text-xs ml-1">(Expired on <?= date('Y-m-d', strtotime($certificate['expiry_date'])) ?>)</span>
                                    <?php elseif ($certificate['expiry_date']): ?>
                                        <span class="text-emerald-500 font-bold text-xs ml-1">(Valid until <?= date('Y-m-d', strtotime($certificate['expiry_date'])) ?>)</span>
                                    <?php else: ?>
                                        <span class="text-emerald-500 font-bold text-xs ml-1">(Lifetime Validity)</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>

                        <?php if (!empty($certificate['pdf_path'])): ?>
                            <div class="mt-10 pt-8 border-t border-slate-200/60 dark:border-slate-850 flex justify-end">
                                <a href="<?= url('/' . $certificate['pdf_path']) ?>" target="_blank" class="inline-flex items-center gap-2 border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-900 font-bold text-xs text-indigo-600 dark:text-accent px-5 py-3 rounded-xl transition-all">
                                    <i class="fa-solid fa-file-pdf text-red-500"></i> Download PDF Copy
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php else: ?>
                    <!-- Failure Card (NOT FOUND) -->
                    <div class="bg-red-500/5 rounded-3xl border border-red-500/20 p-8 md:p-10 shadow-lg text-center">
                        <div class="w-16 h-16 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center text-2xl border border-red-500/20 mx-auto mb-6">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Verification Failure</h3>
                        <p class="mt-3 text-sm text-slate-550 dark:text-slate-400 font-light leading-relaxed max-w-lg mx-auto">
                            No certificate registration records match the number: <strong class="font-mono text-red-600 dark:text-red-400"><?= e($cert_number) ?></strong>.
                        </p>
                        <p class="mt-4 text-xs text-slate-400 font-light leading-relaxed max-w-md mx-auto">
                            Please verify the code capitalization or check the physical certificate scan. To report counterfeit certificates, contact our auditing registry at **info@isecltd.ng**.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
