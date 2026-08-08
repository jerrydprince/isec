<!-- Training & Managed Services Unique View -->
<section class="py-24 relative overflow-hidden bg-white dark:bg-slate-950 text-slate-900 dark:text-white">
    <!-- Human/Support Theme Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-orange-50 dark:from-rose-950/30 dark:to-orange-950/30 z-0"></div>
    <div class="absolute right-0 top-0 w-full lg:w-1/2 h-full z-0 opacity-40 lg:opacity-100">
        <img src="<?= url('/assets/images/professionals.png') ?>" alt="Support Team" class="w-full h-full object-cover" style="mask-image: linear-gradient(to right, transparent, black 40%); -webkit-mask-image: linear-gradient(to right, transparent, black 40%);">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center gap-12 pt-10">
        <div class="w-full lg:w-2/3 space-y-6" data-aos="fade-right">
            <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-rose-500 uppercase tracking-widest hover:text-rose-700 transition-colors mb-4 bg-white/50 dark:bg-slate-900/50 px-4 py-2 rounded-full border border-rose-200 dark:border-rose-900/50 backdrop-blur-sm"><i class="fa-solid fa-arrow-left-long"></i> Capabilities Catalogue</a>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight leading-tight">
                Training, Managed Services <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">& Technical Support</span>
            </h1>
            <p class="text-slate-600 dark:text-slate-300 font-light text-lg leading-relaxed max-w-2xl bg-white/40 dark:bg-slate-900/40 p-4 rounded-2xl backdrop-blur-md border border-white/50 dark:border-slate-800">
                <?= nl2br(e($service['description'])) ?>
            </p>
        </div>
    </div>
</section>

<!-- Content Sections with Unique Layout -->
<section class="py-24 bg-slate-50 dark:bg-slate-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Features Grid (Left) -->
            <div class="lg:col-span-8 space-y-16">
                
                <div data-aos="fade-up">
                    <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-8 border-b-2 border-rose-200 dark:border-rose-900/50 pb-4 inline-block">Service Pillars</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php 
                        $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                        foreach ($features as $feature):
                            $feature = ltrim($feature, '•- ');
                        ?>
                            <div class="bg-white dark:bg-slate-950 p-6 rounded-2xl shadow-[0_4px_20px_rgba(244,63,94,0.05)] border border-rose-100 dark:border-slate-800 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform">
                                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-900/20 text-rose-500 flex items-center justify-center text-2xl mb-4 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm"><?= e($feature) ?></h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Strategy & Methodology -->
                <div class="bg-white dark:bg-slate-950 p-10 rounded-3xl border border-slate-200 dark:border-slate-800" data-aos="fade-up">
                    <h3 class="text-2xl font-bold text-primary dark:text-white mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-chalkboard-user text-orange-500"></i> Support & Training Methodology
                    </h3>
                    <div class="prose prose-slate dark:prose-invert max-w-none font-light leading-relaxed">
                        <p><?= nl2br(e($service['methodology'])) ?></p>
                    </div>
                </div>

            </div>

            <!-- Sidebar (Right) -->
            <div class="lg:col-span-4 space-y-8" data-aos="fade-left">
                
                <!-- Measurable Benefits Card -->
                <div class="bg-gradient-to-br from-rose-500 to-orange-500 p-8 rounded-3xl text-white shadow-xl relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-white/20 text-9xl">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-6 relative z-10">Client Benefits</h3>
                    <ul class="space-y-4 relative z-10">
                        <?php 
                        $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                        foreach ($benefits as $benefit):
                            $benefit = ltrim($benefit, '•- ');
                        ?>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-star text-orange-200 mt-1"></i>
                                <span class="text-sm font-medium text-rose-50"><?= e($benefit) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Deliverables & Tech -->
                <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-rose-100 dark:border-slate-800 shadow-sm">
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4 text-rose-500">Service Deliverables</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-light mb-8">
                        <?= nl2br(e($service['deliverables'])) ?>
                    </p>
                    
                    <h4 class="font-bold text-slate-800 dark:text-white uppercase tracking-wider text-xs mb-4 text-rose-500">Supported Technologies</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-3 py-1 bg-rose-50 dark:bg-slate-900 text-rose-700 dark:text-rose-400 rounded-lg text-xs font-bold border border-rose-100 dark:border-rose-900/50">
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
<section class="py-20 bg-rose-950 text-center text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-orange-900/40 to-rose-900/40 z-0"></div>
    <div class="max-w-4xl mx-auto px-4 space-y-6 relative z-10" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold">Ensure Continuous Operations</h2>
        <p class="text-rose-200 font-light text-sm max-w-xl mx-auto">
            Discuss your technical support, managed services or staff training requirements with our capacity building team.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-white text-rose-900 font-bold px-8 py-3.5 rounded-full text-sm shadow-xl hover:scale-105 transition-all mt-4">
            Request Service SLA <i class="fa-solid fa-file-contract"></i>
        </a>
    </div>
</section>
