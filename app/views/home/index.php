<?php
use App\Models\Settings;
?>
<!-- Custom Swiper Styling overrides for trendy pagination -->
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
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 18px !important;
        font-weight: bold;
    }
</style>

<!-- 1. Hero Swiper Section -->
<section class="relative h-[85vh] sm:h-[90vh] bg-slate-950 overflow-hidden">
    <div class="swiper heroSwiper h-full">
        <div class="swiper-wrapper">
            
            <!-- Slide 1: General Consultancy & Architecture -->
            <div class="swiper-slide relative h-full flex items-center justify-center text-white text-center">
                <!-- Slide background mesh -->
                <div class="absolute inset-0 gradient-mesh opacity-90 z-0"></div>
                <div class="absolute inset-0 bg-slate-950/20 backdrop-brightness-75 z-0"></div>
                <div class="absolute inset-0 z-0 opacity-10 bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:30px_30px]"></div>
                
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-accent uppercase tracking-widest mb-6 border border-white/10 gsap-hero-desc">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span> Systems Efficiency Specialists
                    </span>
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-none mb-6 gsap-hero-title">
                        Optimizing Systems. <br>
                        <span class="bg-gradient-to-r from-accent via-teal-300 to-indigo-300 bg-clip-text text-transparent font-black">Powering Performance.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 font-light leading-relaxed mb-10 gsap-hero-desc">
                        <?= e(page_content('home', 'hero_subtitle', 'Enterprise architecture, digital transformation, and workflow automation for public agencies and leading commercial operations.')) ?>
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 gsap-hero-btns">
                        <a href="<?= url('/services') ?>" class="w-full sm:w-auto bg-gradient-to-r from-accent to-secondary text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-accent/20 hover:scale-105 hover:brightness-110 transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                            Explore Expertise <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="<?= url('/contact') ?>" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide">
                            Speak with a Consultant
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: E-Governance & Revenue -->
            <div class="swiper-slide relative h-full flex items-center justify-center text-white text-center">
                <!-- Custom dark teal background mesh -->
                <div class="absolute inset-0 bg-slate-950 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-primary via-indigo-950 to-teal-900 opacity-90 z-0"></div>
                <div class="absolute inset-0 bg-slate-950/30 backdrop-brightness-75 z-0"></div>
                <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(#808080_1px,transparent_1px)] bg-[size:24px_24px]"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-emerald-400 uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Revenue Protection & Growth
                    </span>
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-none mb-6">
                        Leakage Prevention. <br>
                        <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-indigo-300 bg-clip-text text-transparent font-black">Automated Governance.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 font-light leading-relaxed mb-10">
                        Custom-engineered revenue automations, integrated payroll, and civic registration portals deployed for state entities and municipalities.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="<?= url('/projects') ?>" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 hover:brightness-110 transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                            Read Case Studies <i class="fa-solid fa-square-poll-vertical"></i>
                        </a>
                        <a href="<?= url('/contact') ?>" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide">
                            Schedule Revenue Demo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3: GIS & Property Registries -->
            <div class="swiper-slide relative h-full flex items-center justify-center text-white text-center">
                <!-- Custom amber and indigo mesh -->
                <div class="absolute inset-0 bg-slate-950 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-slate-900 to-emerald-950 opacity-95 z-0"></div>
                <div class="absolute inset-0 bg-slate-950/20 backdrop-brightness-75 z-0"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-amber-400 uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> GIS Registries
                    </span>
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-none mb-6">
                        Secured Land Titles. <br>
                        <span class="bg-gradient-to-r from-amber-400 via-teal-300 to-indigo-450 bg-clip-text text-transparent font-black">Digital Property Mapping.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 font-light leading-relaxed mb-10">
                        Digitalization of land record archives and property registries utilizing secure Geographic Information Systems (GIS) plotting.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="<?= url('/services/gis-solutions') ?>" class="w-full sm:w-auto bg-gradient-to-r from-amber-500 to-yellow-600 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 hover:brightness-110 transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                            Explore GIS Blueprints <i class="fa-solid fa-map-location-dot"></i>
                        </a>
                        <a href="<?= url('/contact') ?>" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide">
                            Consult GIS Engineers
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Bespoke Software & Infrastructure -->
            <div class="swiper-slide relative h-full flex items-center justify-center text-white text-center">
                <!-- Custom violet and purple mesh -->
                <div class="absolute inset-0 bg-slate-900 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-tl from-indigo-900 via-slate-950 to-purple-900 opacity-90 z-0"></div>
                <div class="absolute inset-0 bg-slate-950/20 backdrop-brightness-75 z-0"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-violet-400 uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-400 animate-pulse"></span> ICT Infrastructure
                    </span>
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-none mb-6">
                        Bespoke Software. <br>
                        <span class="bg-gradient-to-r from-violet-400 via-indigo-300 to-teal-350 bg-clip-text text-transparent font-black">Resilient Operations.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 font-light leading-relaxed mb-10">
                        Deploying hybrid cloud architectures, corporate core networking, and custom software systems with TOGAF compliance.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="<?= url('/services') ?>" class="w-full sm:w-auto bg-gradient-to-r from-violet-600 to-indigo-650 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 hover:brightness-110 transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                            Infrastructure Audits <i class="fa-solid fa-server"></i>
                        </a>
                        <a href="<?= url('/contact') ?>" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide">
                            Request ICT Audit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 5: Capacity Building & Training -->
            <div class="swiper-slide relative h-full flex items-center justify-center text-white text-center">
                <!-- Custom rose and indigo mesh -->
                <div class="absolute inset-0 bg-slate-950 z-0"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-slate-900 to-rose-950 opacity-90 z-0"></div>
                <div class="absolute inset-0 bg-slate-950/20 backdrop-brightness-75 z-0"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-rose-450 uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-450 animate-pulse"></span> Capacity Building
                    </span>
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-none mb-6">
                        Empowering Teams. <br>
                        <span class="bg-gradient-to-r from-rose-450 via-pink-400 to-indigo-355 bg-clip-text text-transparent font-black">Institutional Growth.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 font-light leading-relaxed mb-10">
                        Bespoke capacity building, technical skills training, and e-governance workshops for public agencies and corporate leaders.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="<?= url('/services/capacity-building') ?>" class="w-full sm:w-auto bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 hover:brightness-110 transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                            Explore Training Courses <i class="fa-solid fa-graduation-cap"></i>
                        </a>
                        <a href="<?= url('/contact') ?>" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide">
                            Schedule Team Workshop
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Swiper controls -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next text-white/40 hover:text-white transition-colors !hidden sm:!flex"></div>
        <div class="swiper-button-prev text-white/40 hover:text-white transition-colors !hidden sm:!flex"></div>
    </div>
</section>

<!-- 2. Client Partner Logos -->
<section class="py-12 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">Trusted by public entities & corporate giants</h3>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 opacity-55 hover:opacity-85 transition-opacity">
            <span class="text-lg font-bold text-slate-700 dark:text-slate-300 tracking-wider">KWARA LANDS</span>
            <span class="text-lg font-bold text-slate-700 dark:text-slate-300 tracking-wider">AMAC REVENUE</span>
            <span class="text-lg font-bold text-slate-700 dark:text-slate-300 tracking-wider">ABUJA PARKS</span>
            <span class="text-lg font-bold text-slate-700 dark:text-slate-300 tracking-wider">NIGERIA FMS</span>
        </div>
    </div>
</section>

<!-- 3. Corporate Overview -->
<section class="py-24 bg-slate-50 dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <div class="lg:col-span-7" data-aos="fade-right">
                <span class="text-xs font-bold text-accent uppercase tracking-widest mb-3 block">Corporate Introduction</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-primary dark:text-white leading-tight mb-6">
                    Redefining Enterprise Capacity and Operations.
                </h2>
                <p class="text-slate-600 dark:text-slate-400 font-light leading-relaxed mb-6">
                    Integrated Systems Efficiency Consults Limited (ISEC) is a premium management, technology, and engineering consulting company. We architect, deploy, and monitor scalable solutions designed to eliminate bottlenecks, integrate distributed divisions, and optimize revenue streams.
                </p>
                <p class="text-slate-600 dark:text-slate-400 font-light leading-relaxed mb-8">
                    By merging engineering compliance standards with modern Agile software frameworks, we deliver robust automation architectures that match international benchmarks.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center text-accent flex-shrink-0">
                            <i class="fa-solid fa-circle-nodes"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary dark:text-white text-sm">TOGAF Standards</h4>
                            <p class="text-xs text-slate-500 font-medium">Enterprise level compliance modeling.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center text-accent flex-shrink-0">
                            <i class="fa-solid fa-vault"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-primary dark:text-white text-sm">Revenue Leakage Guard</h4>
                            <p class="text-xs text-slate-500 font-medium">Digital financial auditing pipelines.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-5 relative" data-aos="fade-left">
                <div class="absolute inset-0 bg-gradient-to-tr from-accent to-secondary rounded-3xl rotate-3 scale-95 opacity-20 blur-xl"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-slate-900 border border-slate-800 p-8 flex flex-col justify-between min-h-[350px] text-white">
                    <div class="w-12 h-12 rounded-2xl bg-accent/20 flex items-center justify-center text-accent text-xl font-bold border border-accent/20">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="text-slate-300 font-light italic leading-relaxed text-sm my-6">
                        "ISEC's integration methodology successfully restructured our digital workflow pipelines, eliminating historical delays and saving significant administrative capital."
                    </p>
                    <div>
                        <hr class="border-slate-800 mb-4">
                        <h5 class="font-bold text-sm text-white">Engr. Sarah Ndukwe</h5>
                        <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Director of Public Engineering Reforms</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Expertise Section -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-xs font-bold text-accent uppercase tracking-widest mb-3 block">Expertise Catalog</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-primary dark:text-white mb-4">Our Core Specializations</h2>
            <p class="text-slate-500 dark:text-slate-400 font-light leading-relaxed">
                Premium services delivered by senior systems engineers, financial analysts, and corporate transformation consultants.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($services as $service): ?>
                <div class="group relative rounded-3xl bg-slate-50 dark:bg-slate-950 p-8 border border-slate-200 dark:border-slate-850 hover:border-accent hover:scale-[1.03] hover:shadow-xl hover:shadow-accent/5 transition-all duration-300 flex flex-col justify-between min-h-[320px]" data-aos="fade-up">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-accent/10 group-hover:bg-accent group-hover:text-white flex items-center justify-center text-accent text-xl mb-6 transition-all border border-accent/10">
                            <i class="fa-solid <?= e($service['icon']) ?>"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary dark:text-white mb-3 group-hover:text-accent transition-colors"><?= e($service['title']) ?></h3>
                        <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed mb-6">
                            <?= e(excerpt($service['description'], 15)) ?>
                        </p>
                    </div>
                    <a href="<?= url('/services/' . $service['slug']) ?>" class="text-xs font-bold tracking-wider uppercase text-accent inline-flex items-center gap-2 group-hover:translate-x-1 transition-transform">
                        Explore Blueprint <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 border border-slate-200 dark:border-slate-800 hover:border-accent font-bold px-8 py-3.5 rounded-full text-sm hover:text-accent transition-all">
                View All Consultancies <i class="fa-solid fa-ellipsis"></i>
            </a>
        </div>
    </div>
</section>

<!-- 5. Dynamic Growth Statistics -->
<section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 text-center">
            <div data-aos="zoom-in">
                <div class="text-4xl lg:text-5xl font-extrabold text-accent mb-2">150K+</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Land Files Digitalized</div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="100">
                <div class="text-4xl lg:text-5xl font-extrabold text-accent mb-2">55%</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">AMAC Quarter Revenue Growth</div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="200">
                <div class="text-4xl lg:text-5xl font-extrabold text-accent mb-2">15+</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Public Agencies Integrated</div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="300">
                <div class="text-4xl lg:text-5xl font-extrabold text-accent mb-2">99.8%</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Systems Efficiency Uptime</div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Executed Case Studies Portfolio -->
<section class="py-24 bg-slate-50 dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16" data-aos="fade-up">
            <div>
                <span class="text-xs font-bold text-accent uppercase tracking-widest mb-3 block">Corporate Portfolio</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-primary dark:text-white mb-4">Featured Case Studies</h2>
                <p class="text-slate-500 dark:text-slate-400 font-light max-w-xl">
                    Explore real-world system audits, digital integrations, and deployment outcomes we delivered for state clients.
                </p>
            </div>
            <a href="<?= url('/projects') ?>" class="mt-4 md:mt-0 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-accent hover:text-accent font-bold px-6 py-3 rounded-xl text-sm transition-all flex items-center gap-2">
                All Case Studies <i class="fa-solid fa-grid-horizontal"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <?php foreach ($projects as $project): ?>
                <div class="group bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-2xl hover:shadow-accent/5 transition-all duration-300" data-aos="fade-up">
                    <div class="h-64 bg-slate-800 relative overflow-hidden">
                        <!-- Simulated banner image or gradient overlay -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-slate-950/80 to-slate-950/20 z-10"></div>
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
                        <div class="absolute bottom-6 left-6 z-20">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-accent text-white uppercase tracking-widest mb-2 inline-block"><?= e($project['category_name']) ?></span>
                            <h3 class="text-xl font-bold text-white"><?= e($project['title']) ?></h3>
                        </div>
                    </div>
                    <div class="p-8 space-y-4">
                        <div class="flex justify-between text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <span>Client: <?= e($project['client']) ?></span>
                            <span>Duration: <?= e($project['duration']) ?></span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed">
                            <?= e(excerpt($project['challenge'], 20)) ?>
                        </p>
                        <hr class="border-slate-100 dark:border-slate-850">
                        <a href="<?= url('/projects/' . $project['slug']) ?>" class="text-xs font-bold tracking-widest uppercase text-accent inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                            Read Outcomes <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 7. Call To Action Form link -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
        <div class="relative bg-gradient-to-tr from-primary via-slate-900 to-accent rounded-3xl p-12 lg:p-16 text-white overflow-hidden shadow-2xl">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] bg-[size:16px_16px]"></div>
            <div class="relative z-10 space-y-6 max-w-3xl mx-auto">
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">Ready to Audit and Optimize Your Operations?</h2>
                <p class="text-slate-300 font-light text-base leading-relaxed">
                    Arrange a private advisory session with our lead systems architects to establish efficiency indicators, identify revenue leakages, and construct digital transformation blueprints.
                </p>
                <div class="pt-4">
                    <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-accent hover:brightness-110 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 transition-all text-base tracking-wide">
                        Submit Advisory Request <i class="fa-solid fa-calendar-check"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. Insights Feed -->
<section class="py-24 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-850">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-xs font-bold text-accent uppercase tracking-widest mb-3 block">Knowledge Base</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-primary dark:text-white mb-4">Latest Insights & Publications</h2>
            <p class="text-slate-500 dark:text-slate-400 font-light">Stay updated with research journals, whitepapers, and operational blueprints compiled by ISEC consultants.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($insights as $post): ?>
                <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-850 hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-aos="fade-up">
                    <div class="p-8">
                        <div class="flex items-center gap-2 text-[10px] font-bold text-accent uppercase tracking-widest mb-4">
                            <span class="px-2 py-0.5 rounded bg-accent/10"><?= e($post['type']) ?></span>
                            <span class="text-slate-400">•</span>
                            <span class="text-slate-400"><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                        </div>
                        <h3 class="text-lg font-bold text-primary dark:text-white mb-3 hover:text-accent transition-colors">
                            <a href="<?= url('/insights/' . $post['slug']) ?>"><?= e($post['title']) ?></a>
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-light text-xs leading-relaxed mb-6">
                            <?= e(excerpt($post['summary'], 18)) ?>
                        </p>
                    </div>
                    <div class="px-8 pb-8">
                        <a href="<?= url('/insights/' . $post['slug']) ?>" class="text-xs font-bold text-accent inline-flex items-center gap-1.5 hover:gap-3 transition-all">
                            Read Publication <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Swiper Initialization Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
    });
</script>
