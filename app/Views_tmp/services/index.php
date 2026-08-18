<!-- Services Header -->
<section class="py-24 lg:py-32 bg-slate-950 relative overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-transparent z-10"></div>
    <div class="absolute inset-0 z-0 right-0 w-full lg:w-1/2 ml-auto opacity-70 lg:opacity-100">
        <img src="<?= url('/assets/images/professionals.png') ?>" alt="ISEC Professionals" class="w-full h-full object-cover" style="mask-image: linear-gradient(to right, transparent, black 30%); -webkit-mask-image: linear-gradient(to right, transparent, black 30%);">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
        <div class="max-w-2xl space-y-6" data-aos="fade-right">
            <span class="text-xs font-bold text-accent uppercase tracking-widest border border-accent/20 bg-accent/10 px-4 py-1.5 rounded-full inline-block">Systems & Capability Catalogue</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Systems That Run <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-secondary">Your Business</span>
            </h1>
            <p class="text-slate-300 font-light text-lg leading-relaxed max-w-xl">
                From ready-to-deploy retail and property management software for SMEs, to custom enterprise integrations for government agencies, ISEC delivers measurable digital transformation.
            </p>
        </div>
    </div>
</section>

<!-- Ready-to-Deploy Products Grid -->
<section class="py-24 bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-850">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12" data-aos="fade-right">
            <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-2">Off-the-Shelf Systems</h2>
            <p class="text-slate-500 dark:text-slate-400 font-light">Rapid deployment solutions designed specifically for Nigerian growing businesses.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product 1 -->
            <div class="group bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-teal-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-teal-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fa-solid fa-building-user"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">ISEC Property Manager</h3>
                    </div>
                </div>
                <p class="text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider mb-4">For: serviced apartments, short-lets, estate managers</p>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                    Tenants, bookings, rent and service charge tracking, receipts, maintenance requests and arrears — in one place, on your phone.
                </p>
                <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <p class="text-lg font-bold text-slate-900 dark:text-white">From ₦45,000<span class="text-sm text-slate-500 font-normal">/month</span></p>
                        <a href="<?= url('/contact?subject=Demo+Property+Manager') ?>" class="text-xs font-bold tracking-widest uppercase text-teal-600 dark:text-teal-400 inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                            Request Demo <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="group bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-blue-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">ISEC Retail POS</h3>
                    </div>
                </div>
                <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-4">For: shops, distributors and multi-branch retail</p>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                    Sell, invoice and track stock from one screen. Know your real margin per item, catch stock losses early, and close the day with figures you can trust.
                </p>
                <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <p class="text-lg font-bold text-slate-900 dark:text-white">From ₦35,000<span class="text-sm text-slate-500 font-normal">/month</span></p>
                        <a href="<?= url('/contact?subject=Demo+Retail+POS') ?>" class="text-xs font-bold tracking-widest uppercase text-blue-600 dark:text-blue-400 inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                            Request Demo <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="group bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-purple-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-purple-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Business Websites</h3>
                    </div>
                </div>
                <p class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-4">For: any business that needs to sell online</p>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                    Fast, mobile-first websites that load on Nigerian networks and turn visitors into customers. Built to be found on Google and easy to update.
                </p>
                <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <p class="text-lg font-bold text-slate-900 dark:text-white">From ₦450,000<span class="text-sm text-slate-500 font-normal"> one-off</span></p>
                        <a href="<?= url('/contact?subject=Quote+Business+Website') ?>" class="text-xs font-bold tracking-widest uppercase text-purple-600 dark:text-purple-400 inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                            Get Quote <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="group bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-950 rounded-3xl p-8 border border-slate-700 shadow-lg hover:shadow-2xl hover:border-slate-500 transition-all duration-500 relative overflow-hidden flex flex-col text-white h-auto" data-aos="fade-up" data-aos-delay="400">
                <div class="absolute inset-0 bg-[url('<?= url('/assets/images/mesh-bg.png') ?>')] opacity-20 bg-cover bg-center group-hover:scale-105 transition-transform duration-700"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">Custom Software</h3>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-4">For: unique business operations</p>
                    <p class="text-slate-300 text-sm mb-6 leading-relaxed flex-grow">
                        When your operation is genuinely different, we build to your process — properly specified, properly documented, and yours to keep.
                    </p>
                    <div class="mt-auto pt-6 border-t border-slate-700/50">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <p class="text-lg font-bold">Priced per project</p>
                            <a href="<?= url('/contact?subject=Assessment+Custom+Software') ?>" class="text-xs font-bold tracking-widest uppercase text-white inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                                Book Assessment <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enterprise Services Grid -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-12" data-aos="fade-right">
            <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-2">Enterprise Consulting & Delivery</h2>
            <p class="text-slate-500 dark:text-slate-400 font-light">Bespoke technical advisory and complex systems integration for the public sector and large organizations.</p>
        </div>

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
        <h2 class="text-2xl sm:text-3xl font-extrabold text-primary dark:text-white">Require a system that isn't listed here?</h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-sm max-w-xl mx-auto">
            Our enterprise architects can construct specialized integration frameworks and custom workflows tailored precisely to your operational or statutory requirements.
        </p>
        <a href="<?= url('/contact?subject=Custom+Systems+Assessment') ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-accent text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-md hover:scale-105 transition-all">
            Book a Free 30-Minute Assessment <i class="fa-solid fa-calculator"></i>
        </a>
    </div>
</section>
