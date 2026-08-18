<!-- Financial & Public Sector Technology Unique View -->
<section class="py-24 relative overflow-hidden bg-slate-900 text-slate-100">
    <!-- Institutional/Gov Theme Background -->
    <div class="absolute inset-0 bg-gradient-to-b from-sky-950 via-slate-900 to-slate-950 z-0"></div>
    <div class="absolute inset-0 z-0 opacity-20 bg-[url('<?= url('/assets/images/industry.png') ?>')] mix-blend-luminosity"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center gap-12 pt-10">
        <div class="w-full text-center space-y-6" data-aos="zoom-in">
            <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-sky-400 uppercase tracking-widest hover:text-white transition-colors mb-4 bg-sky-900/30 px-5 py-2.5 rounded-full border border-sky-500/20"><i class="fa-solid fa-arrow-left-long"></i> Capabilities Catalogue</a>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight max-w-4xl mx-auto">
                Financial & Public-Sector <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-emerald-400">Technology Solutions</span>
            </h1>
            <p class="text-slate-300 font-light text-lg leading-relaxed max-w-3xl mx-auto border-t border-sky-900 pt-6 mt-6">
                <?= nl2br(e($service['description'])) ?>
            </p>
        </div>
    </div>
</section>

<!-- Content Sections with Unique Layout -->
<section class="py-24 bg-slate-50 dark:bg-slate-950 relative border-t-4 border-sky-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Gov/Fin Services (Left side) -->
            <div class="space-y-12" data-aos="fade-right">
                
                <!-- Specialized Framework -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-xl shadow-sky-900/5 border-l-8 border-sky-500 relative">
                    <div class="absolute -right-6 -top-6 text-sky-100 dark:text-sky-900/20 text-8xl">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6 relative z-10">Institutional Methodology</h3>
                    <div class="prose prose-slate dark:prose-invert font-light leading-relaxed relative z-10">
                        <p><?= nl2br(e($service['methodology'])) ?></p>
                    </div>
                </div>

                <div class="space-y-6">
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                        <i class="fa-solid fa-layer-group text-sky-500"></i> Core Solutions
                    </h4>
                    <div class="grid grid-cols-1 gap-4">
                        <?php 
                        $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                        foreach ($features as $feature):
                            $feature = ltrim($feature, '•- ');
                        ?>
                            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center gap-4 hover:border-sky-400 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-sky-50 dark:bg-sky-900/30 text-sky-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="font-semibold text-slate-700 dark:text-slate-300 text-sm"><?= e($feature) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <!-- Value & Compliance (Right side) -->
            <div class="space-y-8" data-aos="fade-left">
                
                <!-- Measurable Benefits Card -->
                <div class="bg-slate-900 text-white p-10 rounded-3xl shadow-2xl bg-[url('<?= url('/assets/images/service_bg.png') ?>')] bg-cover bg-blend-overlay border border-slate-700">
                    <h3 class="text-2xl font-bold mb-8 text-sky-400">Citizen & Consumer Value</h3>
                    <ul class="space-y-5">
                        <?php 
                        $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                        foreach ($benefits as $benefit):
                            $benefit = ltrim($benefit, '•- ');
                        ?>
                            <li class="flex items-start gap-4">
                                <i class="fa-solid fa-arrow-trend-up text-emerald-400 mt-1"></i>
                                <span class="text-sm font-light text-slate-200"><?= e($benefit) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Deliverables & Tech -->
                <div class="bg-sky-50 dark:bg-slate-900/50 p-8 rounded-3xl border border-sky-100 dark:border-slate-800">
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4 text-sky-700 dark:text-sky-400">Deployment Deliverables</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 font-light mb-8">
                        <?= nl2br(e($service['deliverables'])) ?>
                    </p>
                    
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4 text-sky-700 dark:text-sky-400">Compliance & Stack</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-4 py-1.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-full text-xs font-bold shadow-sm">
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
<section class="py-20 bg-sky-950 border-t border-sky-900 text-center text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('<?= url('/assets/images/industry.png') ?>')] opacity-10 object-cover z-0"></div>
    <div class="max-w-4xl mx-auto px-4 space-y-6 relative z-10" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold">Modernise Your Agency Operations</h2>
        <p class="text-sky-200 font-light text-sm max-w-xl mx-auto">
            Speak with our public-sector technology consultants to map out a secure and compliant digital transition plan.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-400 text-white font-bold px-8 py-3.5 rounded text-sm shadow-xl transition-all uppercase tracking-widest mt-4">
            Schedule Strategic Review <i class="fa-solid fa-landmark"></i>
        </a>
    </div>
</section>
