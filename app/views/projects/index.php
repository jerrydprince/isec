<!-- Projects Header -->
<section class="py-20 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
        <span class="text-xs font-bold text-accent uppercase tracking-widest">Client Success Records</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Our Executed Case Studies</h1>
        <p class="max-w-2xl mx-auto text-slate-300 font-light text-base">
            Review the real-world operational challenges, technical solutions, and efficiency outcomes we delivered.
        </p>
    </div>
</section>

<!-- Filter Tabs & Grid -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filters -->
        <div class="flex flex-wrap justify-center items-center gap-3 mb-16">
            <a href="<?= url('/projects') ?>" class="px-5 py-2.5 rounded-full text-xs font-bold transition-all <?= empty($selected_category) ? 'bg-accent text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 dark:bg-slate-950 dark:hover:bg-slate-850' ?>">
                All Categories
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= url('/projects?category=' . $cat['slug']) ?>" class="px-5 py-2.5 rounded-full text-xs font-bold transition-all <?= $selected_category === $cat['slug'] ? 'bg-accent text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 dark:bg-slate-950 dark:hover:bg-slate-850' ?>">
                    <?= e($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Projects Grid -->
        <?php if (!empty($projects)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <?php foreach ($projects as $project): ?>
                    <div class="group bg-slate-50 dark:bg-slate-950 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 flex flex-col justify-between" data-aos="fade-up">
                        <div class="h-60 bg-slate-800 relative overflow-hidden flex-shrink-0">
                            <!-- Banner placeholder -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-slate-950/80 to-slate-950/20 z-10"></div>
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
                            <div class="absolute bottom-6 left-6 z-20">
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-accent text-white uppercase tracking-widest mb-2 inline-block"><?= e($project['category_name']) ?></span>
                                <h3 class="text-xl font-bold text-white"><?= e($project['title']) ?></h3>
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col justify-between">
                            <div class="space-y-4">
                                <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    <span>Client: <?= e($project['client']) ?></span>
                                    <span>Location: <?= e($project['location']) ?></span>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed">
                                    <?= e(excerpt($project['challenge'], 25)) ?>
                                </p>
                            </div>
                            <div class="pt-6 mt-6 border-t border-slate-200/50 dark:border-slate-850">
                                <a href="<?= url('/projects/' . $project['slug']) ?>" class="text-xs font-bold tracking-widest uppercase text-accent inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                                    Read Outcomes & Data <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-3xl">
                <i class="fa-solid fa-folder-open text-4xl text-slate-300 dark:text-slate-650 mb-4 block"></i>
                <h4 class="font-bold text-slate-500">No project case studies found in this category.</h4>
            </div>
        <?php endif; ?>
    </div>
</section>
