<!-- IT Infrastructure & Systems Integration Unique View -->
<section class="py-24 relative overflow-hidden bg-slate-900 text-white">
    <!-- Server Room / Infrastructure Style Background -->
    <div class="absolute inset-0 bg-gradient-to-b from-blue-950 via-slate-900 to-slate-950 z-0"></div>
    <!-- Grid overlay pattern -->
    <div class="absolute inset-0 z-0 opacity-20" style="background-image: linear-gradient(#334155 1px, transparent 1px), linear-gradient(90deg, #334155 1px, transparent 1px); background-size: 30px 30px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center gap-12 pt-10">
        <div class="md:w-1/2 space-y-6" data-aos="fade-right">
            <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-blue-400 uppercase tracking-widest hover:text-white transition-colors mb-4 bg-white/5 px-4 py-2 rounded-lg border border-white/10"><i class="fa-solid fa-arrow-left-long"></i> Capabilities Catalogue</a>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight">
                IT Infrastructure <br><span class="text-blue-400 font-light">& Systems Integration</span>
            </h1>
            <p class="text-slate-300 font-light text-lg leading-relaxed border-l-2 border-blue-500 pl-4">
                <?= nl2br(e($service['description'])) ?>
            </p>
        </div>
        <div class="md:w-1/2" data-aos="fade-left">
            <div class="relative bg-slate-800 p-4 rounded-2xl border border-slate-700 shadow-2xl">
                <!-- Code/Terminal aesthetic for infrastructure -->
                <div class="flex gap-2 mb-4">
                    <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                </div>
                <div class="text-xs font-mono text-blue-300 space-y-2 opacity-80">
                    <p>> INITIATING SYSTEM DIAGNOSTIC...</p>
                    <p>> MAPPING CLOUD TOPOLOGY...</p>
                    <p>> ESTABLISHING SECURE GATEWAYS...</p>
                    <p class="text-emerald-400">> ALL SYSTEMS ONLINE AND OPTIMISED.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Sections with Unique Layout -->
<section class="py-24 bg-slate-50 dark:bg-slate-950 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        
        <!-- Architecture / Methodology -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-10 border border-slate-200 dark:border-slate-800 shadow-sm" data-aos="fade-up">
            <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-8 flex items-center gap-4">
                <i class="fa-solid fa-network-wired text-blue-500"></i> Infrastructure Methodology
            </h2>
            <div class="prose prose-slate dark:prose-invert max-w-none font-light leading-relaxed">
                <p><?= nl2br(e($service['methodology'])) ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Features (Left side) -->
            <div class="space-y-8" data-aos="fade-right">
                <h3 class="text-2xl font-bold text-primary dark:text-white">Core Competencies</h3>
                <div class="space-y-4">
                    <?php 
                    $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                    foreach ($features as $index => $feature):
                        $feature = ltrim($feature, '•- ');
                    ?>
                        <div class="flex items-center gap-4 p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:border-blue-500 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-sm shrink-0">
                                <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm"><?= e($feature) ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Benefits & Deliverables (Right side) -->
            <div class="space-y-8" data-aos="fade-left">
                <!-- Measurable Benefits Card -->
                <div class="bg-blue-600 text-white p-8 rounded-3xl shadow-xl">
                    <h3 class="text-xl font-bold mb-6">Performance Gains</h3>
                    <ul class="space-y-4">
                        <?php 
                        $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                        foreach ($benefits as $benefit):
                            $benefit = ltrim($benefit, '•- ');
                        ?>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check-double text-blue-300 mt-1"></i>
                                <span class="text-sm font-light text-blue-50"><?= e($benefit) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Deliverables & Tech -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800">
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4">Architecture Deliverables</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-light mb-8">
                        <?= nl2br(e($service['deliverables'])) ?>
                    </p>
                    
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4">Tech Stack & Partnerships</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded text-xs font-mono border border-slate-200 dark:border-slate-700">
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
<section class="py-20 bg-blue-900 border-t border-blue-950 text-center text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('<?= url('/assets/images/industry.png') ?>')] opacity-10 object-cover z-0 mix-blend-overlay"></div>
    <div class="max-w-4xl mx-auto px-4 space-y-6 relative z-10" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold">Ready to Upgrade Your Network?</h2>
        <p class="text-blue-200 font-light text-sm max-w-xl mx-auto">
            Get an enterprise infrastructure audit from our senior systems engineers to identify integration points and scalability gaps.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-white text-blue-900 hover:bg-slate-100 font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition-all">
            Schedule Systems Audit <i class="fa-solid fa-server"></i>
        </a>
    </div>
</section>
