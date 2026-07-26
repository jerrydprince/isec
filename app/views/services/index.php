<!-- Services Header -->
<section class="py-20 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
        <span class="text-xs font-bold text-accent uppercase tracking-widest">Capabilities Catalogue</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Our Consultancy Services</h1>
        <p class="max-w-2xl mx-auto text-slate-300 font-light text-base">
            Engineered systems designed to optimize public workflows and corporate execution.
        </p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($services as $service): ?>
                <div class="group bg-slate-50 dark:bg-slate-950 rounded-3xl p-8 border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-2xl hover:shadow-accent/5 hover:scale-[1.02] transition-all duration-300 flex flex-col justify-between min-h-[320px]" data-aos="fade-up">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-accent/10 group-hover:bg-accent group-hover:text-white flex items-center justify-center text-accent text-xl mb-6 transition-all border border-accent/10">
                            <i class="fa-solid <?= e($service['icon']) ?>"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary dark:text-white mb-3 group-hover:text-accent transition-colors"><?= e($service['title']) ?></h3>
                        <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed mb-6">
                            <?= e(excerpt($service['description'], 20)) ?>
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-200/50 dark:border-slate-850">
                        <a href="<?= url('/services/' . $service['slug']) ?>" class="text-xs font-bold tracking-widest uppercase text-accent inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                            Explore Service Blueprint <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Interactive Consultation CTA -->
<section class="py-20 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-850">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-6" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-primary dark:text-white">Require a custom systems integration audit?</h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-sm max-w-xl mx-auto">
            Our enterprise architects can construct specialized integration frameworks tailored to your agency's statutory regulations.
        </p>
        <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-accent text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-md hover:scale-105 transition-all">
            Schedule Technical Audit <i class="fa-solid fa-calculator"></i>
        </a>
    </div>
</section>
