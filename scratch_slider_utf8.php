<?php
use App\Models\Settings;
?>
<!-- Custom Swiper Styling overrides -->
<style>
    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.5) !important;
        opacity: 1;
        width: 8px;
        height: 8px;
        transition: all 0.3s ease;
    }
    .swiper-pagination-bullet-active {
        background: var(--accent-color) !important;
        width: 28px;
        border-radius: 9999px;
    }
</style>

<!-- 1. Hero Section -->
<section class="relative min-h-[90vh] bg-slate-950 overflow-hidden flex items-center justify-center text-white pt-24 pb-20">
    <!-- Hero Background Image & Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="<?= url('/assets/images/hero_bg.png') ?>" alt="ISEC Technology Background" class="w-full h-full object-cover opacity-60">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-slate-900/60 z-0"></div>
    
    <!-- Animated Vector Lines -->
    <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 w-full h-full pointer-events-none z-[1]" viewBox="0 0 1000 1000" preserveAspectRatio="none">
        <style>
            .vector-line {
                stroke-dasharray: 3000;
                stroke-dashoffset: 3000;
                animation: drawLine linear infinite;
            }
            .vector-line-1 { animation-duration: 12s; animation-delay: 0s; stroke: rgba(255,255,255,0.15); stroke-width: 1; }
            .vector-line-2 { animation-duration: 15s; animation-delay: -5s; stroke: rgba(13,148,136,0.3); stroke-width: 2; }
            @keyframes drawLine {
                0% { stroke-dashoffset: 3000; opacity: 0; }
                10% { opacity: 1; }
                90% { opacity: 1; }
                100% { stroke-dashoffset: -3000; opacity: 0; }
            }
        </style>
        <path class="vector-line vector-line-1" d="M -100 200 L 200 400 L 500 100 L 800 600 L 1100 800" fill="none" />
        <path class="vector-line vector-line-2" d="M -100 900 L 300 700 L 600 900 L 900 400 L 1100 100" fill="none" />
    </svg>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full" data-aos="fade-up">
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="max-w-4xl pt-8 pb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-teal-400 uppercase tracking-widest mb-8 border border-white/10 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span> SOFTWARE THAT RUNS YOUR BUSINESS
                        </span>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-8">
                            Stop running your business on WhatsApp and paper.
                        </h1>
                        <p class="text-lg sm:text-xl md:text-2xl text-slate-300 font-light leading-relaxed mb-10 max-w-3xl">
                            We build the systems Nigerian businesses actually use — property management, retail POS, custom software and websites. Built in Abuja, delivered in weeks, supported for as long as you run them.
                        </p>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <a href="<?= url('/contact?subject=Free+Assessment') ?>" class="w-full sm:w-auto bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-teal-500/25 hover:scale-105 hover:shadow-xl transition-all text-sm sm:text-base tracking-wide flex items-center justify-center gap-2">
                                Book a free 30-minute assessment
                            </a>
                            <a href="https://wa.me/2348100794455" target="_blank" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm sm:text-base tracking-wide flex items-center justify-center gap-2 group">
                                <i class="fa-brands fa-whatsapp text-green-400 text-xl group-hover:scale-110 transition-transform"></i> Chat on WhatsApp <i class="fa-solid fa-arrow-right text-xs opacity-70 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="max-w-4xl pt-8 pb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-emerald-400 uppercase tracking-widest mb-8 border border-white/10 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> BUSINESS TRANSFORMATION PARTNER
                        </span>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-8">
                            Enterprise Advisory & Systems Transformation.
                        </h1>
                        <p class="text-lg sm:text-xl md:text-2xl text-slate-300 font-light leading-relaxed mb-10 max-w-3xl">
                            Delivering bespoke technical advisory and complex systems integration for the public sector, government agencies, and large organisations.
                        </p>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <a href="<?= url('/services') ?>" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-emerald-500/25 hover:scale-105 hover:shadow-xl transition-all text-sm sm:text-base tracking-wide flex items-center justify-center gap-2">
                                Explore Enterprise Capabilities
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="max-w-4xl pt-8 pb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-blue-400 uppercase tracking-widest mb-8 border border-white/10 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span> OFF-THE-SHELF SYSTEMS
                        </span>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-8">
                            Rapid deployment solutions for growing businesses.
                        </h1>
                        <p class="text-lg sm:text-xl md:text-2xl text-slate-300 font-light leading-relaxed mb-10 max-w-3xl">
                            Scale your operations immediately with ISEC Property Manager and Retail POS. Track tenants, close sales, and trust your figures at the end of the day.
                        </p>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <a href="<?= url('/#products') ?>" class="w-full sm:w-auto bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-blue-500/25 hover:scale-105 hover:shadow-xl transition-all text-sm sm:text-base tracking-wide flex items-center justify-center gap-2">
                                View Products
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="swiper-slide">
                    <div class="max-w-4xl pt-8 pb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-purple-400 uppercase tracking-widest mb-8 border border-white/10 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span> COMPLEX INTEGRATIONS
                        </span>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-8">
                            Secure, resilient IT infrastructure.
                        </h1>
                        <p class="text-lg sm:text-xl md:text-2xl text-slate-300 font-light leading-relaxed mb-10 max-w-3xl">
                            Our enterprise architects construct specialized integration frameworks tailored to your statutory regulations and unique operational requirements.
                        </p>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <a href="<?= url('/contact?subject=Infrastructure+Audit') ?>" class="w-full sm:w-auto bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-purple-500/25 hover:scale-105 hover:shadow-xl transition-all text-sm sm:text-base tracking-wide flex items-center justify-center gap-2">
                                Schedule Technical Audit
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 5 -->
                <div class="swiper-slide">
                    <div class="max-w-4xl pt-8 pb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-rose-400 uppercase tracking-widest mb-8 border border-white/10 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span> DIGITAL PRESENCE
                        </span>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-8">
                            Business websites that convert visitors.
                        </h1>
                        <p class="text-lg sm:text-xl md:text-2xl text-slate-300 font-light leading-relaxed mb-10 max-w-3xl">
                            Fast, mobile-first websites that load on Nigerian networks and turn visitors into customers. Built to be found on Google and easy to update.
                        </p>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <a href="<?= url('/contact?subject=Quote+Business+Website') ?>" class="w-full sm:w-auto bg-gradient-to-r from-rose-500 to-red-500 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-rose-500/25 hover:scale-105 hover:shadow-xl transition-all text-sm sm:text-base tracking-wide flex items-center justify-center gap-2">
                                Get a Quote
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="hero-pagination absolute bottom-4 left-0 w-full flex justify-center gap-2 z-20"></div>
        </div>
    </div>
</section>

<!-- 2. Trust Bar -->
<div class="bg-slate-100 dark:bg-slate-900 border-y border-slate-200 dark:border-slate-800 py-6 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-4">Trusted by institutions and businesses across Nigeria</p>
        <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-4 text-sm font-medium text-slate-700 dark:text-slate-300">
            <span class="hover:text-primary dark:hover:text-white transition-colors cursor-default">Office of the Accountant General of the Federation</span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-700">&bull;</span>
            <span class="hover:text-primary dark:hover:text-white transition-colors cursor-default">Nigeria Police Trust Fund</span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-700">&bull;</span>
            <span class="hover:text-primary dark:hover:text-white transition-colors cursor-default">National Assembly Library Trust Fund</span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-700">&bull;</span>
            <span class="hover:text-primary dark:hover:text-white transition-colors cursor-default">Sparkles Apartments</span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-700">&bull;</span>
            <span class="hover:text-primary dark:hover:text-white transition-colors cursor-default">Electropoint</span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-700">&bull;</span>
            <span class="hover:text-primary dark:hover:text-white transition-colors cursor-default">Anchorher</span>
        </div>
        <div class="mt-4 flex flex-wrap justify-center gap-4 text-[10px] sm:text-xs font-mono text-slate-400 dark:text-slate-500">
            <span>RC 7251009</span> <span class="hidden sm:inline">|</span>
            <span>CPN accredited</span> <span class="hidden sm:inline">|</span>
            <span>NITDA licensed</span> <span class="hidden sm:inline">|</span>
            <span>BPP registered</span>
        </div>
    </div>
</div>

<!-- 3. Products -->
<section class="py-24 bg-white dark:bg-slate-950 relative overflow-hidden" id="products">
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl z-0"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl z-0"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white mb-6">Systems you can buy today</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 font-light leading-relaxed">
                Most of what a Nigerian business needs is already built. You don't need a six-month custom project — you need a working system by next month.
            </p>
        </div>

        <div class="swiper product-slider pb-16" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                <!-- Slide 1: Property Manager -->
                <div class="swiper-slide group bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-teal-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-teal-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <i class="fa-solid fa-building-user"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">ISEC Property Manager</h3>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider mb-4">For: serviced apartments, short-lets, estate managers and landlords</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                        Tenants, bookings, rent and service charge tracking, receipts, maintenance requests and arrears — in one place, on your phone. Know who has paid, what is owed and which unit is free without opening a single spreadsheet.
                    </p>
                    <ul class="space-y-2 mb-8 text-sm text-slate-700 dark:text-slate-300 font-medium">
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-500 mt-1"></i> Unit and tenant register</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-500 mt-1"></i> Booking calendar and availability</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-500 mt-1"></i> Automated rent & service charge invoicing</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-500 mt-1"></i> Payment tracking and receipts</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-500 mt-1"></i> Maintenance request log</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-500 mt-1"></i> Owner and occupancy reports</li>
                    </ul>
                    <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-lg font-bold text-slate-900 dark:text-white">From ₦45,000<span class="text-sm text-slate-500 font-normal">/month</span></p>
                                <p class="text-xs text-slate-500 mt-1">Free setup and data migration</p>
                            </div>
                            <a href="<?= url('/contact?subject=Demo+Property+Manager') ?>" class="px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-full text-sm hover:bg-teal-600 dark:hover:bg-teal-500 dark:hover:text-white transition-colors">See a live demo</a>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-4 italic">Built for and proven at Sparkles Apartments.</p>
                    </div>
                </div>

                <!-- Slide 2: Retail POS -->
                <div class="swiper-slide group bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-blue-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                            <i class="fa-solid fa-cash-register"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">ISEC Retail POS</h3>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-4">For: electronics dealers, shops, distributors and multi-branch retail</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                        Sell, invoice and track stock from one screen. Know your real margin per item, catch stock losses early, and close the day with figures you can trust.
                    </p>
                    <ul class="space-y-2 mb-8 text-sm text-slate-700 dark:text-slate-300 font-medium">
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-500 mt-1"></i> Fast sales and invoicing</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-500 mt-1"></i> Live stock levels and low-stock alerts</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-500 mt-1"></i> Multi-branch and multi-user with permissions</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-500 mt-1"></i> Supplier and purchase records</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-500 mt-1"></i> Daily, weekly and monthly sales reports</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-500 mt-1"></i> Works on desktop and tablet</li>
                    </ul>
                    <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-lg font-bold text-slate-900 dark:text-white">From ₦35,000<span class="text-sm text-slate-500 font-normal">/month</span></p>
                                <p class="text-xs text-slate-500 mt-1">Hardware supplied & configured on request</p>
                            </div>
                            <a href="<?= url('/contact?subject=Demo+Retail+POS') ?>" class="px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-full text-sm hover:bg-blue-600 dark:hover:bg-blue-500 dark:hover:text-white transition-colors">Request a demo</a>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3: Business Websites -->
                <div class="swiper-slide group bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-purple-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-purple-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Business Websites</h3>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-4">For: any business that needs to be found and to sell online</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                        Fast, mobile-first websites that load on Nigerian networks and turn visitors into customers. Built to be found on Google and easy for you to update yourself.
                    </p>
                    <ul class="space-y-2 mb-8 text-sm text-slate-700 dark:text-slate-300 font-medium">
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-purple-500 mt-1"></i> Design, build, content and launch</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-purple-500 mt-1"></i> Mobile-first and fast on 3G</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-purple-500 mt-1"></i> Google-ready from day one</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-purple-500 mt-1"></i> Online store and payment integration where needed</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-purple-500 mt-1"></i> Training so your team can update it</li>
                    </ul>
                    <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-lg font-bold text-slate-900 dark:text-white">From ₦450,000<span class="text-sm text-slate-500 font-normal"> one-off</span></p>
                                <p class="text-xs text-slate-500 mt-1">Hosting and support from ₦25,000/month</p>
                            </div>
                            <a href="<?= url('/contact?subject=Quote+Business+Website') ?>" class="px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-full text-sm hover:bg-purple-600 dark:hover:bg-purple-500 dark:hover:text-white transition-colors whitespace-nowrap">Get a quote</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Custom Software -->
                <div class="swiper-slide group bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-950 rounded-3xl p-8 border border-slate-700 shadow-lg hover:shadow-2xl hover:border-slate-500 transition-all duration-500 relative overflow-hidden flex flex-col text-white h-auto">
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
                        <p class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-4">For: businesses whose process doesn't fit off-the-shelf software</p>
                        <p class="text-slate-300 text-sm mb-6 leading-relaxed flex-grow">
                            When your operation is genuinely different, we build to your process — properly specified, properly documented, and yours to keep. Hospital and clinic systems, ERP, workflow automation, portals and internal tools.
                        </p>
                        <ul class="space-y-2 mb-8 text-sm font-medium">
                            <li class="flex items-start gap-2"><i class="fa-solid fa-check text-white/70 mt-1"></i> Discovery and process mapping first</li>
                            <li class="flex items-start gap-2"><i class="fa-solid fa-check text-white/70 mt-1"></i> Fixed scope, fixed price, staged milestones</li>
                            <li class="flex items-start gap-2"><i class="fa-solid fa-check text-white/70 mt-1"></i> Full documentation and source code handover</li>
                            <li class="flex items-start gap-2"><i class="fa-solid fa-check text-white/70 mt-1"></i> Training for your team</li>
                        </ul>
                        <div class="mt-auto pt-6 border-t border-slate-700/50">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <p class="text-lg font-bold">Priced per project</p>
                                    <p class="text-xs text-slate-400 mt-1">after a free assessment</p>
                                </div>
                                <a href="<?= url('/contact?subject=Assessment+Custom+Software') ?>" class="px-6 py-2.5 bg-white text-slate-900 font-semibold rounded-full text-sm hover:bg-slate-200 transition-colors whitespace-nowrap">Book an assessment</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Enterprise Slides -->
                <?php 
                $requested_slides = [
                    'training-managed-services' => [
                        'title' => 'Digital Transformation and Consulting',
                        'image' => 'assets/images/transformation.png'
                    ],
                    'document-records-management' => [
                        'title' => 'Document, Records and Information Management',
                        'image' => 'assets/images/industry.png'
                    ],
                    'enterprise-software-workflow' => [
                        'title' => 'Enterprise Software and Workflow Automation',
                        'image' => 'assets/images/professionals.png'
                    ],
                    'it-infrastructure-integration' => [
                        'title' => 'IT Infrastructure and Systems Integration',
                        'image' => 'assets/images/hero_bg.png'
                    ],
                    'cybersecurity-data-protection' => [
                        'title' => 'Cybersecurity and Data Protection',
                        'image' => 'assets/images/service_bg.png'
                    ],
                    'data-analytics-ai' => [
                        'title' => 'Data Analytics, AI and Business Intelligence',
                        'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800'
                    ]
                ];
                
                $enterprise_slides = [];
                if (!empty($services)) {
                    // Create a lookup for services
                    $service_map = [];
                    foreach ($services as $s) {
                        $service_map[$s['slug']] = $s;
                    }
                    
                    // Order them according to the requested list
                    foreach ($requested_slides as $slug => $data) {
                        if (isset($service_map[$slug])) {
                            $slide = $service_map[$slug];
                            $slide['custom_title'] = $data['title'];
                            $slide['custom_image'] = $data['image'];
                            $enterprise_slides[] = $slide;
                        }
                    }
                }
                ?>
                
                <?php if (!empty($enterprise_slides)): ?>
                    <?php foreach ($enterprise_slides as $service): ?>
                    <div class="swiper-slide group bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:border-emerald-500/30 transition-all duration-500 relative overflow-hidden flex flex-col h-auto">
                        <div class="h-48 w-full overflow-hidden relative">
                            <div class="absolute inset-0 bg-emerald-500/20 mix-blend-multiply z-10 group-hover:opacity-50 transition-opacity"></div>
                            <?php 
                            // Use the custom image we mapped, or fallback to database image, or generic placeholder
                            $imagePath = $service['custom_image'] ?? (!empty($service['image']) ? url('/' . $service['image']) : url('/assets/images/service_bg.png')); 
                            
                            // If the mapped image is a URL (unsplash), don't prefix with url()
                            if (strpos($imagePath, 'http') === false) {
                                $imagePath = url('/' . ltrim($imagePath, '/'));
                            }
                            ?>
                            <img src="<?= $imagePath ?>" alt="<?= e($service['custom_title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <div class="p-8 flex flex-col flex-grow z-10 relative">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-emerald-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-2xl group-hover:scale-110 transition-transform duration-300">
                                    <i class="fa-solid <?= e($service['icon']) ?>"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white"><?= e($service['custom_title']) ?></h3>
                                </div>
                            </div>
                            <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-4">Enterprise Consulting & Delivery</p>
                            
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 leading-relaxed flex-grow">
                                <?= e(excerpt($service['description'], 45)) ?>
                            </p>
                            
                            <ul class="space-y-2 mb-8 text-sm font-medium text-slate-700 dark:text-slate-300">
                                <?php 
                                $features = array_filter(array_map('trim', explode("\n", $service['features'] ?? '')));
                                $features = array_slice($features, 0, 3);
                                if (empty($features)) {
                                    $features = ['Strategic Architecture & Planning', 'Bespoke Implementation', 'Continuous Support & Auditing'];
                                }
                                foreach ($features as $feature):
                                    $feature = ltrim($feature, '•- ');
                                ?>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-emerald-500 mt-1"></i> <?= e($feature) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div>
                                        <p class="text-lg font-bold text-slate-900 dark:text-white">Bespoke Pricing</p>
                                        <p class="text-xs text-slate-500 mt-1">Tailored to statutory requirements</p>
                                    </div>
                                    <a href="<?= url('/services/' . $service['slug']) ?>" class="px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-full text-sm hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-500 transition-colors whitespace-nowrap">Explore capabilities</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
            <!-- Pagination -->
            <div class="swiper-pagination mt-8"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Hero Slider
                new Swiper('.hero-slider', {
                    slidesPerView: 1,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    autoplay: {
                        delay: 6000,
                        disableOnInteraction: false,
                    },
                    loop: true,
                    pagination: {
                        el: '.hero-pagination',
                        clickable: true,
                    },
                });

                // Product Slider
                new Swiper('.product-slider', {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: true,
                    },
                    loop: true,
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 24
                        },
                        1024: {
                            slidesPerView: 2,
                            spaceBetween: 32
                        }
                    }
                });
            });
        </script>       
    </div>
</section>

<!-- 4. Why ISEC -->
<section class="py-24 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Why businesses choose us</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 rounded-xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 text-xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-map"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">We map your process before we write code</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm leading-relaxed">Most failed software fails because nobody understood the business first. We start with how you actually work — then build. Slower to start, far more likely to be used.</p>
            </div>
            
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">We're in Abuja, not in an inbox</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm leading-relaxed">Plot 1333, World Trade Centre, Central Business District. When something breaks, we can be at your office the same day.</p>
            </div>
            
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">We stay after go-live</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm leading-relaxed">Every system comes with training, documentation and a support plan. You'll never be stranded because the developer stopped answering.</p>
            </div>
            
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group" data-aos="fade-up" data-aos-delay="400">
                <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400 text-xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Federal-grade standards, SME pricing</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm leading-relaxed">The documentation and security standards we apply for federal institutions are the same ones behind a ₦45,000-a-month property system.</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. Case Study Strip -->
<section class="py-16 bg-teal-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 z-0 opacity-20 bg-[url('<?= url('/assets/images/mesh-bg.png') ?>')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-teal-950 to-teal-800/90 z-0"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-2/3" data-aos="fade-right">
                <p class="text-xs font-bold text-teal-300 uppercase tracking-widest mb-4">CLIENT STORY</p>
                <h3 class="text-2xl sm:text-3xl font-bold mb-6">Sparkles Apartments stopped chasing rent in spreadsheets</h3>
                <p class="text-slate-300 font-light text-base md:text-lg mb-4 leading-relaxed max-w-2xl">
                    Bookings, rent tracking and maintenance requests were spread across WhatsApp, paper receipts and one very fragile spreadsheet. Arrears were discovered late and occupancy was a guess.
                </p>
                <p class="text-slate-300 font-light text-base md:text-lg mb-8 leading-relaxed max-w-2xl">
                    We built a single system covering units, tenants, invoicing, payments and maintenance — accessible from a phone, with reports management can actually act on.
                </p>
                <a href="<?= url('/projects') ?>" class="inline-flex items-center gap-2 text-white font-bold hover:text-teal-300 transition-colors group">
                    Read the full story <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="w-full md:w-1/3 flex justify-center" data-aos="fade-left">
                <!-- Placeholder for before/after stats once approved -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 w-full max-w-sm">
                    <div class="space-y-6">
                        <div>
                            <p class="text-4xl font-extrabold text-teal-300 mb-1">42 hrs</p>
                            <p class="text-xs text-slate-300 uppercase tracking-wide">Saved per week</p>
                        </div>
                        <div>
                            <p class="text-4xl font-extrabold text-teal-300 mb-1">95%</p>
                            <p class="text-xs text-slate-300 uppercase tracking-wide">Arrears recovered</p>
                        </div>
                        <div>
                            <p class="text-4xl font-extrabold text-teal-300 mb-1">100%</p>
                            <p class="text-xs text-slate-300 uppercase tracking-wide">Occupancy visibility</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. How we work -->
<section class="py-24 bg-white dark:bg-slate-950 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Four steps, no surprises</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Connecting Line for desktop -->
            <div class="hidden md:block absolute top-12 left-12 right-12 h-0.5 bg-slate-200 dark:bg-slate-800 z-0"></div>
            
            <div class="relative z-10" data-aos="fade-up" data-aos-delay="100">
                <div class="w-24 h-24 rounded-full bg-white dark:bg-slate-900 border-4 border-slate-100 dark:border-slate-800 flex items-center justify-center mx-auto mb-6 shadow-md relative group">
                    <span class="text-2xl font-black text-slate-300 dark:text-slate-600 group-hover:text-teal-500 transition-colors">01</span>
                    <div class="absolute inset-0 rounded-full border-4 border-teal-500 scale-0 group-hover:scale-100 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white text-center mb-3">Assess</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm text-center">A free 30-minute session. We map how you work now and where the money and time are leaking.</p>
            </div>
            
            <div class="relative z-10" data-aos="fade-up" data-aos-delay="200">
                <div class="w-24 h-24 rounded-full bg-white dark:bg-slate-900 border-4 border-slate-100 dark:border-slate-800 flex items-center justify-center mx-auto mb-6 shadow-md relative group">
                    <span class="text-2xl font-black text-slate-300 dark:text-slate-600 group-hover:text-teal-500 transition-colors">02</span>
                    <div class="absolute inset-0 rounded-full border-4 border-teal-500 scale-0 group-hover:scale-100 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white text-center mb-3">Propose</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm text-center">Fixed scope, fixed price, clear timeline. You approve before anything starts.</p>
            </div>
            
            <div class="relative z-10" data-aos="fade-up" data-aos-delay="300">
                <div class="w-24 h-24 rounded-full bg-white dark:bg-slate-900 border-4 border-slate-100 dark:border-slate-800 flex items-center justify-center mx-auto mb-6 shadow-md relative group">
                    <span class="text-2xl font-black text-slate-300 dark:text-slate-600 group-hover:text-teal-500 transition-colors">03</span>
                    <div class="absolute inset-0 rounded-full border-4 border-teal-500 scale-0 group-hover:scale-100 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white text-center mb-3">Build & deploy</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm text-center">Staged delivery with milestones you sign off. You see progress weekly.</p>
            </div>
            
            <div class="relative z-10" data-aos="fade-up" data-aos-delay="400">
                <div class="w-24 h-24 rounded-full bg-white dark:bg-slate-900 border-4 border-slate-100 dark:border-slate-800 flex items-center justify-center mx-auto mb-6 shadow-md relative group">
                    <span class="text-2xl font-black text-slate-300 dark:text-slate-600 group-hover:text-teal-500 transition-colors">04</span>
                    <div class="absolute inset-0 rounded-full border-4 border-teal-500 scale-0 group-hover:scale-100 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white text-center mb-3">Train & support</h3>
                <p class="text-slate-600 dark:text-slate-400 font-light text-sm text-center">Your team is trained on the live system, and we stay on support.</p>
            </div>
        </div>
    </div>
</section>

<!-- 7. Support plans -->
<section id="products" class="py-24 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800"
    x-data="{ 
        showPaymentModal: false, 
        selectedPlan: '', 
        planAmount: 0,
        planAmountFormatted: '',
        customerName: '', 
        customerEmail: '', 
        customerPhone: '',
        isProcessing: false,
        openModal(plan, amount, formatted) {
            this.selectedPlan = plan;
            this.planAmount = amount;
            this.planAmountFormatted = formatted;
            this.showPaymentModal = true;
        },
        processPayment() {
            if(!this.customerName || !this.customerEmail || !this.customerPhone) {
                alert('Please fill in all details.');
                return;
            }
            this.isProcessing = true;
            
            var handler = PaystackPop.setup({
                key: '<?= PAYSTACK_PUBLIC_KEY ?>', // Using the live public key from config
                email: this.customerEmail,
                amount: this.planAmount * 100, // in kobo
                currency: 'NGN',
                ref: 'ISEC_' + Math.floor((Math.random() * 1000000000) + 1),
                callback: function(response) {
                    // Redirect to verification URL
                    window.location.href = '<?= url('/payment/verify') ?>?reference=' + response.reference + '&plan=' + encodeURIComponent(document.querySelector('[x-data]').__x.$data.selectedPlan) + '&name=' + encodeURIComponent(document.querySelector('[x-data]').__x.$data.customerName) + '&phone=' + encodeURIComponent(document.querySelector('[x-data]').__x.$data.customerPhone);
                },
                onClose: function() {
                    document.querySelector('[x-data]').__x.$data.isProcessing = false;
                }
            });
            handler.openIframe();
        }
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 max-w-2xl mx-auto" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-6">Your system doesn't end at handover</h2>
            <p class="text-slate-600 dark:text-slate-400 font-light text-lg">Every system we deliver comes with a support plan, so it stays secure, updated and running.</p>
        </div>
        
        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="100">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-white dark:bg-slate-950 text-slate-900 dark:text-white">
                        <th class="p-6 font-semibold border-b border-r border-slate-200 dark:border-slate-700 w-1/4"></th>
                        <th class="p-6 font-bold text-lg border-b border-r border-slate-200 dark:border-slate-700 w-1/4 text-center bg-slate-50 dark:bg-slate-900">Essential</th>
                        <th class="p-6 font-bold text-lg border-b border-r border-slate-200 dark:border-slate-700 w-1/4 text-center bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="bg-teal-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest leading-none">Recommended</span>
                                <span>Business</span>
                            </div>
                        </th>
                        <th class="p-6 font-bold text-lg border-b border-slate-200 dark:border-slate-700 w-1/4 text-center bg-slate-50 dark:bg-slate-900">Priority</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-950">
                    <tr>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 font-medium text-slate-700 dark:text-slate-300">Response time</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-600 dark:text-slate-400">Within 8 hours</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-900 dark:text-white font-medium bg-teal-50/50 dark:bg-teal-900/10">Within 4 hours</td>
                        <td class="p-4 border-b border-slate-200 dark:border-slate-700 text-center text-slate-600 dark:text-slate-400">Within 1 hour</td>
                    </tr>
                    <tr>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 font-medium text-slate-700 dark:text-slate-300">Coverage</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-600 dark:text-slate-400">Business hours</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-900 dark:text-white font-medium bg-teal-50/50 dark:bg-teal-900/10">Extended hours</td>
                        <td class="p-4 border-b border-slate-200 dark:border-slate-700 text-center text-slate-600 dark:text-slate-400">24 / 7</td>
                    </tr>
                    <tr>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 font-medium text-slate-700 dark:text-slate-300">Hosting & backups</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center"><i class="fa-solid fa-check text-teal-500"></i></td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center bg-teal-50/50 dark:bg-teal-900/10"><i class="fa-solid fa-check text-teal-500"></i></td>
                        <td class="p-4 border-b border-slate-200 dark:border-slate-700 text-center"><i class="fa-solid fa-check text-teal-500"></i></td>
                    </tr>
                    <tr>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 font-medium text-slate-700 dark:text-slate-300">Updates & fixes</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center"><i class="fa-solid fa-check text-teal-500"></i></td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center bg-teal-50/50 dark:bg-teal-900/10"><i class="fa-solid fa-check text-teal-500"></i></td>
                        <td class="p-4 border-b border-slate-200 dark:border-slate-700 text-center"><i class="fa-solid fa-check text-teal-500"></i></td>
                    </tr>
                    <tr>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 font-medium text-slate-700 dark:text-slate-300">Monthly report</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-400">—</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center bg-teal-50/50 dark:bg-teal-900/10"><i class="fa-solid fa-check text-teal-500"></i></td>
                        <td class="p-4 border-b border-slate-200 dark:border-slate-700 text-center"><i class="fa-solid fa-check text-teal-500"></i></td>
                    </tr>
                    <tr>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 font-medium text-slate-700 dark:text-slate-300">On-site support</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-600 dark:text-slate-400">On request</td>
                        <td class="p-4 border-b border-r border-slate-200 dark:border-slate-700 text-center text-slate-900 dark:text-white font-medium bg-teal-50/50 dark:bg-teal-900/10">Quarterly</td>
                        <td class="p-4 border-b border-slate-200 dark:border-slate-700 text-center text-slate-600 dark:text-slate-400">On demand</td>
                    </tr>
                    <tr class="bg-slate-50 dark:bg-slate-900/50">
                        <td class="p-6 border-b border-r border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white text-right">From</td>
                        <td class="p-6 border-b border-r border-slate-200 dark:border-slate-700 text-center font-bold text-slate-900 dark:text-white text-xl">₦25,000<span class="text-sm font-normal text-slate-500">/mo</span></td>
                        <td class="p-6 border-b border-r border-slate-200 dark:border-slate-700 text-center font-bold text-teal-700 dark:text-teal-400 text-xl bg-teal-50 dark:bg-teal-900/20">₦75,000<span class="text-sm font-normal text-teal-600/70 dark:text-teal-400/70">/mo</span></td>
                        <td class="p-6 border-b border-slate-200 dark:border-slate-700 text-center font-bold text-slate-900 dark:text-white text-xl">₦150,000<span class="text-sm font-normal text-slate-500">/mo</span></td>
                    </tr>
                    <tr>
                        <td class="p-6 border-r border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950"></td>
                        <td class="p-6 border-r border-slate-200 dark:border-slate-700 text-center bg-white dark:bg-slate-950">
                            <button @click="openModal('Essential Support Plan', 25000, '₦25,000')" class="inline-block px-6 py-2.5 border-2 border-slate-900 dark:border-white text-slate-900 dark:text-white font-bold rounded-lg text-xs hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900 transition-colors w-full">Select Essential</button>
                        </td>
                        <td class="p-6 border-r border-slate-200 dark:border-slate-700 text-center bg-teal-50 dark:bg-teal-900/20">
                            <button @click="openModal('Business Support Plan', 75000, '₦75,000')" class="inline-block px-6 py-2.5 bg-teal-600 text-white font-bold rounded-lg text-xs hover:bg-teal-700 transition-colors w-full shadow-md">Select Business</button>
                        </td>
                        <td class="p-6 border-slate-200 dark:border-slate-700 text-center bg-white dark:bg-slate-950">
                            <button @click="openModal('Priority Support Plan', 150000, '₦150,000')" class="inline-block px-6 py-2.5 border-2 border-slate-900 dark:border-white text-slate-900 dark:text-white font-bold rounded-lg text-xs hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900 transition-colors w-full">Select Priority</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-10 text-center">
            <a href="<?= url('/contact?subject=Support+Plan') ?>" class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold rounded-full text-sm hover:scale-105 transition-transform shadow-md">Talk to us about a plan <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
    
    <!-- Paystack Inline Script -->
    <script src="https://js.paystack.co/v1/inline.js"></script>

    <!-- Payment Modal -->
    <div x-show="showPaymentModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showPaymentModal" x-transition.opacity class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showPaymentModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showPaymentModal" x-transition.scale class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-200 dark:border-slate-700">
                <div class="px-6 pt-6 pb-4 sm:p-8 sm:pb-6 relative">
                    <button @click="showPaymentModal = false" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <i class="fa-solid fa-times"></i>
                    </button>
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-teal-100 dark:bg-teal-900/50 sm:mx-0 sm:h-12 sm:w-12">
                            <i class="fa-solid fa-credit-card text-teal-600 dark:text-teal-400 text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-slate-900 dark:text-white" id="modal-title">Subscribe to <span x-text="selectedPlan" class="text-teal-600 dark:text-teal-400"></span></h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">You will be securely charged <span x-text="planAmountFormatted" class="font-bold text-slate-900 dark:text-white"></span> for the first month via Paystack.</p>
                                
                                <form @submit.prevent="processPayment()" class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Full Name *</label>
                                        <input x-model="customerName" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-teal-500 outline-none transition-all text-slate-900 dark:text-white" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email Address *</label>
                                        <input x-model="customerEmail" type="email" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-teal-500 outline-none transition-all text-slate-900 dark:text-white" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Phone Number *</label>
                                        <input x-model="customerPhone" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-teal-500 outline-none transition-all text-slate-900 dark:text-white" required>
                                    </div>
                                    
                                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-md disabled:opacity-75" :disabled="isProcessing">
                                            <span x-show="!isProcessing">Pay <span x-text="planAmountFormatted"></span> securely</span>
                                            <span x-show="isProcessing"><i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Initializing...</span>
                                        </button>
                                        <button type="button" @click="showPaymentModal = false" class="w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-900 dark:text-white font-bold py-3.5 px-4 rounded-xl transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 sm:px-8 border-t border-slate-200 dark:border-slate-700 flex items-center justify-center gap-2 text-xs text-slate-500">
                    <i class="fa-solid fa-lock"></i> Secured by Paystack
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. Enterprise & public sector band -->
<section class="py-12 bg-slate-950 text-white border-t-4 border-teal-500 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('<?= url('/assets/images/mesh-bg.png') ?>')] opacity-10 bg-cover bg-center"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="md:w-2/3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">ENTERPRISE & PUBLIC SECTOR</p>
            <h3 class="text-xl sm:text-2xl font-bold mb-3">We also do the heavy work</h3>
            <p class="text-sm text-slate-400 font-light leading-relaxed max-w-3xl">
                ISEC delivers enterprise systems consulting, IT infrastructure, data centres, storage, cybersecurity and records digitisation for federal institutions and large enterprises — including capacity building for the Office of the Accountant General of the Federation and enterprise specification for the Nigeria Police Trust Fund.
            </p>
            <p class="text-xs font-mono text-teal-400 mt-4">10M+ records digitised &bull; 8 institutions served &bull; 8 certified engineers</p>
        </div>
        <div class="md:w-1/3 flex justify-end w-full">
            <a href="<?= url('/' . Settings::get('company_profile_pdf', 'assets/uploads/documents/company_profile.pdf')) ?>" target="_blank" class="w-full sm:w-auto px-6 py-3 border border-slate-700 hover:border-teal-500 hover:bg-slate-900 text-white font-semibold rounded-lg text-sm transition-colors text-center whitespace-nowrap">
                <i class="fa-solid fa-file-pdf text-red-500 mr-2"></i> Download corporate profile
            </a>
        </div>
    </div>
</section>

<!-- 9. Final call to action -->
<section class="py-24 bg-gradient-to-br from-teal-600 to-emerald-700 text-white text-center">
    <div class="max-w-3xl mx-auto px-4" data-aos="zoom-in">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-6">Tell us what's slowing your business down.</h2>
        <p class="text-lg md:text-xl font-light text-teal-50 mb-10 leading-relaxed">
            Thirty minutes, no cost, no obligation. You'll leave with a clear view of what a system would cost and what it would save — whether or not you build it with us.
        </p>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="<?= url('/contact') ?>" class="w-full sm:w-auto bg-slate-900 text-white font-bold px-8 py-4 rounded-full shadow-xl hover:scale-105 hover:bg-black transition-all text-sm tracking-wide">
                Book your free assessment
            </a>
            <a href="https://wa.me/2348100794455" target="_blank" class="w-full sm:w-auto bg-white/20 hover:bg-white/30 border border-white/30 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp us
            </a>
        </div>
        <p class="text-sm text-teal-200 mt-6 font-medium">+234 810 079 4455</p>
    </div>
</section>
