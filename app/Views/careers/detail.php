<!-- Job Header -->
<section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
        <a href="<?= url('/careers') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-accent uppercase tracking-widest hover:text-white transition-colors mb-4"><i class="fa-solid fa-arrow-left-long"></i> Back to Opportunities</a>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
            <span class="px-2.5 py-0.5 rounded bg-accent/20 text-accent"><?= e($job['job_type']) ?></span>
            <span>•</span>
            <span>Location: <?= e($job['location']) ?></span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight max-w-4xl"><?= e($job['title']) ?></h1>
    </div>
</section>

<!-- Job specs and application form -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Left Side Requirements -->
            <div class="lg:col-span-7 space-y-12">
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-primary dark:text-white border-b border-slate-100 dark:border-slate-850 pb-3">Role Overview</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed">
                        <?= nl2br(e($job['description'])) ?>
                    </p>
                </div>
                
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-primary dark:text-white border-b border-slate-100 dark:border-slate-850 pb-3">Requirements & Key Skills</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed">
                        <?= nl2br(e($job['requirements'])) ?>
                    </p>
                </div>
            </div>

            <!-- Right Side Form panel -->
            <div class="lg:col-span-5 relative">
                <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850 shadow-md space-y-6">
                    <h4 class="font-bold text-primary dark:text-white text-lg">Apply Online</h4>
                    <p class="text-xs font-light text-slate-400">Complete the form below and attach your corporate curriculum vitae (PDF/Doc formats, max 5MB).</p>
                    
                    <form action="<?= url('/careers/' . $job['id'] . '/apply') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <?= csrf_field() ?>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Full Name *</label>
                            <input type="text" name="name" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email Address *</label>
                                <input type="email" name="email" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Phone Number *</label>
                                <input type="text" name="phone" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Cover Letter / Executive Summary</label>
                            <textarea name="cover_letter" rows="4" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Attach Resume CV (PDF/Word) *</label>
                            <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required>
                        </div>

                        <button type="submit" class="w-full bg-accent hover:brightness-110 text-white font-bold py-4 rounded-xl text-xs shadow-md transition-all">Submit Candidate Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
