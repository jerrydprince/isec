<!-- Cybersecurity & Data Protection Unique View -->
<section class="py-24 relative overflow-hidden bg-slate-950 text-white border-b border-red-900/50">
    <!-- Matrix/Security Cyber Theme Background -->
    <div class="absolute inset-0 bg-gradient-to-b from-red-950 via-slate-950 to-slate-950 z-0 opacity-80"></div>
    <div class="absolute inset-0 z-0 opacity-10 bg-[url('<?= url('/assets/images/service_bg.png') ?>')] mix-blend-color-dodge"></div>
    
    <!-- Animated lock icon overlay -->
    <div class="absolute right-0 top-1/2 -translate-y-1/2 opacity-5 blur-[2px] pointer-events-none hidden lg:block">
        <i class="fa-solid fa-shield-halved text-[30rem] text-red-500"></i>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6 pt-10" data-aos="zoom-in">
        <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-red-500 uppercase tracking-widest hover:text-white transition-colors mb-4 bg-red-900/20 px-4 py-2 rounded-full border border-red-500/20"><i class="fa-solid fa-arrow-left-long"></i> Capabilities Catalogue</a>
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight max-w-4xl mx-auto leading-tight">
            Cybersecurity <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">& Data Protection</span>
        </h1>
        <p class="text-slate-300 font-light text-lg max-w-3xl mx-auto leading-relaxed border border-red-900/30 bg-red-950/20 p-6 rounded-2xl backdrop-blur-sm">
            <?= nl2br(e($service['description'])) ?>
        </p>
    </div>
</section>

<!-- Content Sections with Unique Layout -->
<section class="py-24 bg-slate-900 text-slate-300 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Defense Architecture Area -->
            <div class="lg:col-span-7 space-y-12">
                
                <div data-aos="fade-right">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-500 text-xl shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                            <i class="fa-solid fa-crosshairs"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-white">Defense Methodology</h2>
                    </div>
                    <div class="prose prose-invert max-w-none font-light leading-relaxed text-slate-400">
                        <p><?= nl2br(e($service['methodology'])) ?></p>
                    </div>
                </div>

                <!-- Features Threat Matrix -->
                <div data-aos="fade-up">
                    <h3 class="text-xl font-bold text-white mb-6 uppercase tracking-wider text-sm border-b border-slate-800 pb-2"><i class="fa-solid fa-shield-virus text-red-500 mr-2"></i> Threat Protection Matrix</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php 
                        $features = array_filter(array_map('trim', explode("\n", $service['features'])));
                        foreach ($features as $feature):
                            $feature = ltrim($feature, '•- ');
                        ?>
                            <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 hover:border-red-500/50 transition-colors flex gap-3">
                                <i class="fa-solid fa-lock text-red-500 mt-1 opacity-70"></i>
                                <h4 class="font-bold text-slate-300 text-sm"><?= e($feature) ?></h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-5 space-y-8" data-aos="fade-left">
                
                <!-- Compliance & Measurable Benefits Card -->
                <div class="bg-slate-950 p-8 rounded-3xl border border-red-900/30 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-red-500/5 group-hover:bg-red-500/10 transition-colors"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold mb-6 text-white flex items-center gap-2"><i class="fa-solid fa-file-shield text-red-500"></i> Compliance & Resilience</h3>
                        <ul class="space-y-4">
                            <?php 
                            $benefits = array_filter(array_map('trim', explode("\n", $service['benefits'])));
                            foreach ($benefits as $benefit):
                                $benefit = ltrim($benefit, '•- ');
                            ?>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-red-500 mt-1 text-xs"></i>
                                    <span class="text-sm font-light text-slate-400"><?= e($benefit) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Deliverables & Tech -->
                <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-inner">
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4 text-red-400">Security Deliverables</h4>
                    <p class="text-sm text-slate-400 font-light mb-8">
                        <?= nl2br(e($service['deliverables'])) ?>
                    </p>
                    
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4 text-red-400">Encryption & Tech Stack</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                            <span class="px-3 py-1 bg-slate-950 text-slate-300 border border-slate-800 rounded font-mono text-xs">
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
<section class="py-20 bg-black border-t border-red-900 text-center text-white relative">
    <div class="absolute inset-0 bg-gradient-to-t from-red-950/20 to-transparent z-0 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 space-y-6 relative z-10" data-aos="zoom-in">
        <div class="text-red-500 text-4xl mb-4"><i class="fa-solid fa-user-shield"></i></div>
        <h2 class="text-2xl sm:text-3xl font-extrabold">Secure Your Core Infrastructure</h2>
        <p class="text-slate-400 font-light text-sm max-w-xl mx-auto">
            Book a confidential penetration test or vulnerability assessment to identify and neutralise threats before they materialise.
        </p>
        <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-500 text-white font-bold px-8 py-3.5 rounded text-sm shadow-[0_0_20px_rgba(220,38,38,0.4)] transition-all uppercase tracking-widest mt-4">
            Request Threat Audit <i class="fa-solid fa-fingerprint"></i>
        </a>
    </div>
</section>
