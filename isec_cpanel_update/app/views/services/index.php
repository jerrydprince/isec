<!-- Services Header -->
<section class="py-24 lg:py-32 bg-slate-950 relative overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-transparent z-10"></div>
    <div class="absolute inset-0 z-0 right-0 w-full lg:w-1/2 ml-auto opacity-70 lg:opacity-100">
        <img src="<?= url('/assets/images/professionals.png') ?>" alt="ISEC Professionals" class="w-full h-full object-cover" style="mask-image: linear-gradient(to right, transparent, black 30%); -webkit-mask-image: linear-gradient(to right, transparent, black 30%);">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
        <div class="max-w-2xl space-y-6" data-aos="fade-right">
            <span class="text-xs font-bold text-accent uppercase tracking-widest border border-accent/20 bg-accent/10 px-4 py-1.5 rounded-full inline-block">Capabilities Catalogue</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Our Consultancy <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-secondary">Practice Areas</span>
            </h1>
            <p class="text-slate-300 font-light text-lg leading-relaxed max-w-xl">
                ISEC delivers comprehensive solutions across our major practice areas, combining deep technical expertise with strategic business process transformation to empower your organisation.
            </p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($services as $service): ?>
                <div class="group bg-slate-50 dark:bg-slate-950 rounded-3xl p-8 border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-2xl hover:shadow-accent/5 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-[320px]" data-aos="fade-up">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-accent/10 group-hover:bg-accent group-hover:text-white flex items-center justify-center text-accent text-2xl mb-6 transition-all border border-accent/10">
                            <i class="fa-solid <?= e($service['icon']) ?>"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary dark:text-white mb-4 group-hover:text-accent transition-colors leading-tight"><?= e($service['title']) ?></h3>
                        <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed mb-6">
                            <?= e(excerpt($service['description'], 25)) ?>
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-200/50 dark:border-slate-850 mt-auto">
                        <a href="<?= url('/services/' . $service['slug']) ?>" class="text-xs font-bold tracking-widest uppercase text-accent inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                            Explore Service Details <i class="fa-solid fa-arrow-right"></i>
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
