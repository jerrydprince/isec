<!-- Enterprise Software & Workflow Unique View -->
<section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <!-- Vibrant Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-900 via-slate-900 to-teal-900 opacity-90 z-0"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6 pt-10" data-aos="zoom-in">
        <div class="inline-flex items-center gap-2 text-xs font-bold text-emerald-400 uppercase tracking-widest mb-4 bg-white/10 px-4 py-2 rounded-full backdrop-blur-md border border-white/10 mx-auto">
            <i class="fa-solid fa-code text-teal-400"></i> Software Engineering
        </div>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight max-w-4xl mx-auto leading-tight">
            Enterprise Software <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">& Workflow Automation</span>
        </h1>
        <p class="text-slate-300 font-light text-lg max-w-3xl mx-auto leading-relaxed">
            <?= nl2br(e($service['description'])) ?>
        </p>
    </div>
</section>

<!-- Content Sections with Unique Layout -->
<section class="py-24 bg-white dark:bg-slate-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">
        
        <!-- Features Grid - Full Width -->
        <div data-aos="fade-up">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-4">Core Automation Capabilities</h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                foreach ($features as $feature):
                    $feature = ltrim($feature, '•- ');
                ?>
                    <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-emerald-400 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-200 text-base"><?= e($feature) ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Methodology -->
            <div class="space-y-8" data-aos="fade-right">
                <h3 class="text-3xl font-bold text-primary dark:text-white">Engineering Methodology</h3>
                <div class="prose prose-slate dark:prose-invert max-w-none font-light leading-relaxed">
                    <p><?= nl2br(e($service['methodology'])) ?></p>
                </div>
                
                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                    <h4 class="font-bold text-emerald-800 dark:text-emerald-400 mb-2">Technologies Utilised</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-3 py-1 bg-white dark:bg-slate-900 text-emerald-700 dark:text-emerald-300 rounded shadow-sm text-xs font-bold">
                                <?= e(trim($tech)) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="relative" data-aos="fade-left">
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/20 to-teal-500/20 rounded-3xl blur-2xl transform -rotate-3"></div>
                <div class="bg-white dark:bg-slate-950 p-10 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl relative z-10">
                    <h3 class="text-2xl font-bold text-primary dark:text-white mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">ROI & Measurable Value</h3>
                    <ul class="space-y-6">
                        <?php 
                        $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                        foreach ($benefits as $benefit):
                            $benefit = ltrim($benefit, '•- ');
                        ?>
                            <li class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5">
                                    <i class="fa-solid fa-arrow-trend-up text-xs"></i>
                                </div>
                                <span class="text-slate-600 dark:text-slate-300 font-light leading-relaxed"><?= e($benefit) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-emerald-950 border-t border-emerald-900 text-center text-white">
    <div class="max-w-4xl mx-auto px-4 space-y-6" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold">Ready to Build Custom Solutions?</h2>
        <p class="text-emerald-200 font-light text-sm max-w-xl mx-auto">
            Discuss your bespoke software needs or workflow automation objectives with our engineering team today.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-400 text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-xl shadow-emerald-500/20 hover:scale-105 transition-all">
            Initiate Project <i class="fa-solid fa-code-branch"></i>
        </a>
    </div>
</section>
