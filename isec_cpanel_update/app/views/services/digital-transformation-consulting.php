<!-- Digital Transformation & Consulting Unique View -->
<section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <!-- Vibrant Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-primary to-slate-900 opacity-90 z-0"></div>
    <div class="absolute inset-0 z-0 right-0 w-full lg:w-1/2 ml-auto opacity-70 lg:opacity-100">
        <img src="<?= url('/assets/images/transformation.png') ?>" alt="Digital Transformation" class="w-full h-full object-cover" style="mask-image: linear-gradient(to right, transparent, black 30%); -webkit-mask-image: linear-gradient(to right, transparent, black 30%);">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6 pt-10" data-aos="fade-right">
        <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-indigo-400 uppercase tracking-widest hover:text-white transition-colors mb-4 bg-white/10 px-4 py-2 rounded-full backdrop-blur-md border border-white/10"><i class="fa-solid fa-arrow-left-long"></i> Capabilities Catalogue</a>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight max-w-4xl leading-tight">
            Digital Transformation <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">& Consulting</span>
        </h1>
        <p class="text-slate-300 font-light text-lg max-w-2xl leading-relaxed">
            <?= nl2br(e($service['description'])) ?>
        </p>
    </div>
</section>

<!-- Content Sections with Unique Grid Layout -->
<section class="py-24 bg-slate-50 dark:bg-slate-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-8 space-y-16">
                
                <!-- Strategy & Methodology -->
                <div class="bg-white dark:bg-slate-950 rounded-3xl p-10 shadow-xl shadow-slate-200/40 dark:shadow-none border border-slate-200/60 dark:border-slate-800" data-aos="fade-up">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl">
                            <i class="fa-solid fa-chess-knight"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-primary dark:text-white">Strategic Methodology</h2>
                    </div>
                    <div class="prose prose-slate dark:prose-invert max-w-none font-light leading-relaxed">
                        <p><?= nl2br(e($service['methodology'])) ?></p>
                    </div>
                </div>

                <!-- Features Grid -->
                <div data-aos="fade-up">
                    <h3 class="text-2xl font-bold text-primary dark:text-white mb-8 border-l-4 border-indigo-500 pl-4">Core Competencies</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php 
                        $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                        foreach ($features as $feature):
                            $feature = ltrim($feature, '•- ');
                        ?>
                            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:-translate-y-1 hover:shadow-md transition-all">
                                <i class="fa-solid fa-check-circle text-indigo-500 mb-4 text-xl"></i>
                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm"><?= e($feature) ?></h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Measurable Benefits Card -->
                <div class="bg-gradient-to-br from-indigo-900 to-primary p-8 rounded-3xl text-white shadow-2xl relative overflow-hidden" data-aos="fade-left">
                    <div class="absolute -top-10 -right-10 text-white/5 text-9xl">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-6 relative z-10">Measurable Value</h3>
                    <ul class="space-y-4 relative z-10">
                        <?php 
                        $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                        foreach ($benefits as $benefit):
                            $benefit = ltrim($benefit, '•- ');
                        ?>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-arrow-trend-up text-cyan-400 mt-1"></i>
                                <span class="text-sm font-light text-slate-200"><?= e($benefit) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Deliverables & Tech -->
                <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800" data-aos="fade-up">
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4">Key Deliverables</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-light mb-8">
                        <?= nl2br(e($service['deliverables'])) ?>
                    </p>
                    
                    <hr class="border-slate-100 dark:border-slate-800 mb-6">
                    
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4">Technologies & Frameworks</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-lg text-xs font-semibold">
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
<section class="py-20 bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-6" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-primary dark:text-white">Begin Your Transformation Journey</h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-sm max-w-xl mx-auto">
            Schedule an advisory session with our principal consultants to outline a strategic roadmap for your organisation.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-cyan-500 text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-xl shadow-indigo-500/20 hover:scale-105 hover:brightness-110 transition-all">
            Request Strategy Workshop <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>
