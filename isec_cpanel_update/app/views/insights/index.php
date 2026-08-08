<!-- Insights Header -->
<section class="py-20 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
        <span class="text-xs font-bold text-accent uppercase tracking-widest">Advisory Insights</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Our Knowledge Hub</h1>
        <p class="max-w-2xl mx-auto text-slate-300 font-light text-base">
            Executive whitepapers, corporate case studies, and engineering briefs compiled by our senior team.
        </p>
    </div>
</section>

<!-- Main insights grid -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Left Side Feed List -->
            <div class="lg:col-span-8 space-y-10">
                <?php if (!empty($insights)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php foreach ($insights as $post): ?>
                            <div class="group bg-slate-50 dark:bg-slate-950 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-850 hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-aos="fade-up">
                                <div class="p-8">
                                    <div class="flex items-center gap-2 text-[10px] font-bold text-accent uppercase tracking-widest mb-4">
                                        <span class="px-2 py-0.5 rounded bg-accent/10"><?= e($post['type']) ?></span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-400"><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                                    </div>
                                    <h3 class="text-xl font-bold text-primary dark:text-white mb-3 group-hover:text-accent transition-colors">
                                        <a href="<?= url('/insights/' . $post['slug']) ?>"><?= e($post['title']) ?></a>
                                    </h3>
                                    <p class="text-slate-500 dark:text-slate-400 font-light text-xs leading-relaxed mb-6">
                                        <?= e(excerpt($post['summary'], 22)) ?>
                                    </p>
                                </div>
                                <div class="px-8 pb-8">
                                    <a href="<?= url('/insights/' . $post['slug']) ?>" class="text-xs font-bold text-accent inline-flex items-center gap-1.5 hover:gap-3 transition-all">
                                        Read Publication <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-20 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-3xl">
                        <i class="fa-solid fa-file-excel text-4xl text-slate-350 dark:text-slate-650 mb-4 block"></i>
                        <h4 class="font-bold text-slate-500">No insight articles found mapping these parameters.</h4>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar filters -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Filters panel -->
                <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850 space-y-6">
                    <h4 class="font-bold text-primary dark:text-white text-base">Filter Library</h4>
                    <hr class="border-slate-200 dark:border-slate-800">
                    
                    <!-- Types -->
                    <div class="space-y-2.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Publication Type</span>
                        <div class="flex flex-col gap-2 text-xs">
                            <a href="<?= url('/insights') ?>" class="font-bold px-3 py-2 rounded-lg <?= empty($selected_type) ? 'bg-accent text-white' : 'bg-white hover:bg-slate-100 dark:bg-slate-900' ?>">All Publications</a>
                            <a href="<?= url('/insights?type=blog') ?>" class="font-bold px-3 py-2 rounded-lg <?= $selected_type === 'blog' ? 'bg-accent text-white' : 'bg-white hover:bg-slate-100 dark:bg-slate-900' ?>">Blogs & Articles</a>
                            <a href="<?= url('/insights?type=case-study') ?>" class="font-bold px-3 py-2 rounded-lg <?= $selected_type === 'case-study' ? 'bg-accent text-white' : 'bg-white hover:bg-slate-100 dark:bg-slate-900' ?>">Case Studies</a>
                            <a href="<?= url('/insights?type=whitepaper') ?>" class="font-bold px-3 py-2 rounded-lg <?= $selected_type === 'whitepaper' ? 'bg-accent text-white' : 'bg-white hover:bg-slate-100 dark:bg-slate-900' ?>">Executive Whitepapers</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
