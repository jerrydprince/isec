<!-- Data Analytics & AI Unique View -->
<section class="py-24 relative overflow-hidden bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
    <!-- Geometric abstract data background -->
    <div class="absolute inset-0 bg-gradient-to-tr from-purple-100 to-fuchsia-50 dark:from-purple-950 dark:to-slate-900 z-0"></div>
    <div class="absolute right-0 top-0 w-1/2 h-full opacity-10 dark:opacity-5 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, #9333ea 1px, transparent 0); background-size: 24px 24px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center gap-12 pt-10">
        <div class="md:w-1/2 space-y-6" data-aos="fade-right">
            <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-widest hover:text-purple-800 transition-colors mb-4"><i class="fa-solid fa-arrow-left-long"></i> Capabilities Catalogue</a>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight">
                Data Analytics, AI <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-fuchsia-500">& Business Intelligence</span>
            </h1>
            <p class="text-slate-600 dark:text-slate-300 font-light text-lg leading-relaxed max-w-xl">
                <?= nl2br(e($service['description'])) ?>
            </p>
        </div>
        <div class="md:w-1/2 flex justify-center" data-aos="zoom-in">
            <!-- Abstract visualization graphic -->
            <div class="relative w-full aspect-square max-w-md">
                <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/20 to-fuchsia-500/20 rounded-full animate-pulse blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] h-[80%] border border-purple-500/30 rounded-full animate-[spin_10s_linear_infinite]"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[60%] h-[60%] border-2 border-dashed border-fuchsia-400/50 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-purple-600 dark:text-purple-400 text-6xl shadow-xl shadow-purple-500/20 bg-white dark:bg-slate-900 w-32 h-32 rounded-full flex items-center justify-center border-4 border-purple-100 dark:border-purple-900/50 z-10">
                    <i class="fa-solid fa-brain"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Sections with Unique Layout -->
<section class="py-24 bg-white dark:bg-slate-950 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Features Grid -->
            <div class="lg:col-span-2 space-y-12">
                <div data-aos="fade-up">
                    <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-8">Intelligence Capabilities</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php 
                        $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                        foreach ($features as $feature):
                            $feature = ltrim($feature, '•- ');
                        ?>
                            <div class="bg-purple-50 dark:bg-purple-900/10 p-6 rounded-3xl border border-purple-100 dark:border-purple-800/30 hover:bg-purple-600 hover:text-white transition-all group cursor-default">
                                <i class="fa-solid fa-chart-pie text-purple-500 group-hover:text-purple-200 mb-4 text-2xl transition-colors"></i>
                                <h4 class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-white text-sm"><?= e($feature) ?></h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800" data-aos="fade-up">
                    <h3 class="text-xl font-bold text-primary dark:text-white mb-4">Methodology & Modeling</h3>
                    <div class="prose prose-slate dark:prose-invert max-w-none font-light leading-relaxed">
                        <p><?= nl2br(e($service['methodology'])) ?></p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Measurable Benefits Card -->
                <div class="bg-gradient-to-br from-purple-700 to-fuchsia-600 p-8 rounded-3xl text-white shadow-2xl relative overflow-hidden" data-aos="fade-left">
                    <div class="absolute -bottom-10 -right-10 text-white/10 text-9xl">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-6 relative z-10">Business Outcomes</h3>
                    <ul class="space-y-4 relative z-10">
                        <?php 
                        $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                        foreach ($benefits as $benefit):
                            $benefit = ltrim($benefit, '•- ');
                        ?>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-bullseye text-fuchsia-300 mt-1"></i>
                                <span class="text-sm font-medium text-purple-50"><?= e($benefit) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Deliverables & Tech -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm" data-aos="fade-left" data-aos-delay="100">
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4 text-purple-600 dark:text-purple-400">Dashboards & Output</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-light mb-8">
                        <?= nl2br(e($service['deliverables'])) ?>
                    </p>
                    
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4 text-purple-600 dark:text-purple-400">Analytics Stack</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-full text-xs font-semibold shadow-inner">
                                <?= e(trim($tech)) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-purple-950 border-t border-purple-900 text-center text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-fuchsia-900/50 to-purple-900/50 z-0"></div>
    <div class="max-w-4xl mx-auto px-4 space-y-6 relative z-10" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold">Unlock the Value of Your Data</h2>
        <p class="text-purple-200 font-light text-sm max-w-xl mx-auto">
            Talk to our data scientists and BI engineers to outline a predictive analytics model that serves your operational needs.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-white text-purple-900 font-bold px-8 py-3.5 rounded-full text-sm shadow-xl hover:scale-105 transition-all mt-4">
            Request Data Audit <i class="fa-solid fa-magnifying-glass-chart"></i>
        </a>
    </div>
</section>
