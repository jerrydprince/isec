<!-- Careers Header -->
<section class="py-20 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
        <span class="text-xs font-bold text-accent uppercase tracking-widest">Join ISEC Consults</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Open Opportunities</h1>
        <p class="max-w-2xl mx-auto text-slate-300 font-light text-base">
            Build your professional advisory, software engineering, or public governance consulting career with ISEC.
        </p>
    </div>
</section>

<!-- Vacancies List -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Graduate Program intro box -->
        <div class="bg-gradient-to-tr from-slate-900 to-indigo-950 text-white p-8 lg:p-12 rounded-3xl border border-slate-800 mb-16 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-xl" data-aos="zoom-in">
            <div class="space-y-2 max-w-2xl">
                <span class="px-3 py-1 rounded bg-indigo-600/30 text-indigo-400 text-[10px] font-bold uppercase tracking-widest">Training Initiative</span>
                <h3 class="text-xl sm:text-2xl font-bold">2026 Systems Consultant Graduate Programme</h3>
                <p class="text-slate-400 font-light text-xs leading-relaxed">
                    We select top-tier graduates across public policy, accounting, and computer science fields for mentorship under senior consultants.
                </p>
            </div>
            <a href="<?= url('/contact?inquiry=Graduate+Program') ?>" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-6 py-3.5 rounded-xl transition-all shadow-md">Submit Expression of Interest</a>
        </div>

        <h3 class="text-xl font-bold text-primary dark:text-white mb-8"><i class="fa-solid fa-briefcase text-accent mr-2"></i> Current Positions</h3>

        <?php if (!empty($jobs)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php foreach ($jobs as $job): ?>
                    <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-xl hover:scale-[1.01] transition-all duration-300 flex flex-col justify-between min-h-[220px]" data-aos="fade-up">
                        <div class="space-y-4">
                            <div class="flex justify-between items-start gap-4">
                                <h4 class="font-bold text-lg text-primary dark:text-white group-hover:text-accent"><?= e($job['title']) ?></h4>
                                <span class="bg-accent/10 px-2.5 py-1 rounded text-[9px] font-bold text-accent uppercase tracking-widest flex-shrink-0"><?= e($job['job_type']) ?></span>
                            </div>
                            <div class="flex items-center gap-4 text-xs font-semibold text-slate-400">
                                <span><i class="fa-solid fa-location-dot mr-1"></i> <?= e($job['location']) ?></span>
                                <span>•</span>
                                <span>Posted: <?= date('M d, Y', strtotime($job['created_at'])) ?></span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-slate-200/50 dark:border-slate-850 flex justify-between items-center">
                            <a href="<?= url('/careers/' . $job['id']) ?>" class="text-xs font-bold tracking-widest uppercase text-accent inline-flex items-center gap-2 hover:translate-x-1 transition-all">
                                View Specs & Apply <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-3xl">
                <i class="fa-solid fa-user-slash text-4xl text-slate-350 dark:text-slate-650 mb-4 block"></i>
                <h4 class="font-bold text-slate-500">We do not have active staff vacancies open right now.</h4>
                <p class="text-xs text-slate-400 font-light mt-1">Check back later or send your CV to our email inbox.</p>
            </div>
        <?php endif; ?>

    </div>
</section>
