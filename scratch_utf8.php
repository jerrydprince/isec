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
</style>

<!-- 1. Hero Section -->
<section class="relative h-[90vh] bg-slate-950 overflow-hidden flex items-center justify-center text-white text-center">
    <!-- Hero Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="<?= url('/assets/images/hero_bg.png') ?>" alt="ISEC Technology Background" class="w-full h-full object-cover opacity-60">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent z-0"></div>
    <div class="absolute inset-0 bg-slate-950/40 backdrop-brightness-75 z-0"></div>
    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20" data-aos="fade-up">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-white/10 backdrop-blur-md text-accent uppercase tracking-widest mb-6 border border-white/10">
            <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span> Technology & Management Consulting
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight leading-none mb-8">
            Integrated Systems Efficiency Consults Ltd.
        </h1>
        <p class="max-w-4xl mx-auto text-base sm:text-xl text-slate-300 font-light leading-relaxed mb-10">
            Helping organisations transform their operations through digital technologies, enterprise information management, business process automation, software engineering, IT infrastructure, cybersecurity, data management and professional advisory services.
        </p>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="<?= url('/services') ?>" class="w-full sm:w-auto bg-gradient-to-r from-accent to-secondary text-white font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 hover:brightness-110 transition-all text-sm tracking-wide flex items-center justify-center gap-2">
                Explore Our Portfolio <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="<?= url('/about') ?>" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-full backdrop-blur-md transition-all text-sm tracking-wide">
                Our Philosophy
            </a>
        </div>
    </div>
</section>

<!-- 2. Key Differentiator Section -->
<section class="py-24 bg-white dark:bg-slate-950 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-3xl sm:text-5xl font-extrabold text-primary dark:text-white mb-6" data-aos="fade-up">
            We don't simply implement technology;<br>
            <span class="bg-gradient-to-r from-accent to-secondary bg-clip-text text-transparent">we transform the processes</span>, information and systems that enable organisations to perform.
        </h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-lg max-w-4xl mx-auto mb-16" data-aos="fade-up" data-aos-delay="100">
            ISEC works at the intersection of business processes, technology and organisational efficiency, helping public-sector institutions, government agencies, enterprises and other organisations move from fragmented, manual and paper-driven operations to integrated, secure, intelligent and measurable digital environments.
        </p>
        
        <!-- The End-to-End Chain -->
        <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-4 font-bold text-xs sm:text-sm tracking-widest uppercase text-slate-800 dark:text-slate-300" data-aos="zoom-in" data-aos-delay="200">
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Consulting</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Process Transformation</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Software & Solutions</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Infrastructure</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Integration</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Cybersecurity</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Data & Intelligence</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Training</span>
            <i class="fa-solid fa-arrow-right text-accent"></i>
            <span class="bg-slate-100 dark:bg-slate-900 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800">Managed Services</span>
        </div>
    </div>
</section>

<!-- 3. Core Philosophy -->
<section class="py-24 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-xs font-bold text-accent uppercase tracking-widest">Our Core Philosophy</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-primary dark:text-white mt-2">Measurable Organisational Value</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-4 max-w-2xl mx-auto">
                Our solutions are designed around five fundamental objectives.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <!-- Efficiency -->
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 rounded-2xl bg-accent/10 flex items-center justify-center text-accent text-2xl mb-6">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <h3 class="text-xl font-bold text-primary dark:text-white mb-3">Efficiency</h3>
                <p class="text-slate-500 dark:text-slate-400 font-light text-sm">Eliminate unnecessary manual processes and duplication.</p>
            </div>
            
            <!-- Integration -->
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-2xl mb-6">
                    <i class="fa-solid fa-link"></i>
                </div>
                <h3 class="text-xl font-bold text-primary dark:text-white mb-3">Integration</h3>
                <p class="text-slate-500 dark:text-slate-400 font-light text-sm">Connect people, processes, systems and information.</p>
            </div>
            
            <!-- Transparency -->
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 text-2xl mb-6">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h3 class="text-xl font-bold text-primary dark:text-white mb-3">Transparency</h3>
                <p class="text-slate-500 dark:text-slate-400 font-light text-sm">Improve visibility, accountability and auditability.</p>
            </div>
            
            <!-- Security -->
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="w-14 h-14 rounded-2xl bg-rose-500/10 flex items-center justify-center text-rose-500 text-2xl mb-6">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-xl font-bold text-primary dark:text-white mb-3">Security</h3>
                <p class="text-slate-500 dark:text-slate-400 font-light text-sm">Protect information, systems and organisational assets.</p>
            </div>
            
            <!-- Intelligence -->
            <div class="bg-white dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                <div class="w-14 h-14 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-500 text-2xl mb-6">
                    <i class="fa-solid fa-brain"></i>
                </div>
                <h3 class="text-xl font-bold text-primary dark:text-white mb-3">Intelligence</h3>
                <p class="text-slate-500 dark:text-slate-400 font-light text-sm">Convert organisational data into actionable information for decision-making.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Consulting Model -->
<section class="py-24 bg-white dark:bg-slate-950 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <span class="text-xs font-bold text-accent uppercase tracking-widest">End-to-End Transformation</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-primary dark:text-white mt-2 mb-6">ISEC's Consulting Model</h2>
                <p class="text-slate-500 dark:text-slate-400 font-light text-lg mb-8">
                    We provide a comprehensive transformation lifecycle, combining consulting, technology implementation, systems integration, training and ongoing support.
                </p>
                
                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">01</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Discover</h4>
                            <p class="text-xs text-slate-500 mt-1">Understand the organisation, processes, problems and objectives.</p>
                        </div>
                    </div>
                    
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">02</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Assess</h4>
                            <p class="text-xs text-slate-500 mt-1">Evaluate existing systems, infrastructure, information and capabilities.</p>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">03</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Design</h4>
                            <p class="text-xs text-slate-500 mt-1">Develop the business, technical and solution architecture.</p>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">04</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Transform</h4>
                            <p class="text-xs text-slate-500 mt-1">Implement technology, redesign processes and migrate information.</p>
                        </div>
                    </div>
                    
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">05</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Integrate</h4>
                            <p class="text-xs text-slate-500 mt-1">Connect systems, applications, databases and users.</p>
                        </div>
                    </div>
                    
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">06</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Secure</h4>
                            <p class="text-xs text-slate-500 mt-1">Implement security, governance, access controls and compliance.</p>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">07</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Train</h4>
                            <p class="text-xs text-slate-500 mt-1">Build organisational capability and user adoption.</p>
                        </div>
                    </div>
                    
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-950 bg-slate-200 dark:bg-slate-800 text-slate-500 group-[.is-active]:bg-accent group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <span class="text-xs font-bold">08</span>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-sm">
                            <h4 class="font-bold text-primary dark:text-white">Support</h4>
                            <p class="text-xs text-slate-500 mt-1">Provide managed services, maintenance and continuous improvement.</p>
                        </div>
                    </div>

                </div>
            </div>
            
            <div data-aos="fade-left" class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-slate-100 dark:border-slate-800">
                <img src="<?= url('/assets/images/transformation.png') ?>" alt="Transformation Lifecycle" class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-80"></div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Industry Focus -->
<section class="py-24 bg-slate-950 text-white relative overflow-hidden">
    <!-- Industry Background Image -->
    <div class="absolute inset-0 z-0 opacity-40">
        <img src="<?= url('/assets/images/industry.png') ?>" alt="Industry Focus" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 to-primary/90 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-xs font-bold text-accent uppercase tracking-widest" data-aos="fade-up">Industry Focus</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold mt-2 mb-16" data-aos="fade-up" data-aos-delay="100">Empowering Diverse Sectors</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all" data-aos="zoom-in" data-aos-delay="100">
                <i class="fa-solid fa-landmark text-4xl text-accent mb-4"></i>
                <h3 class="font-bold text-lg mb-2">Government & Public Sector</h3>
                <p class="text-xs text-slate-300 font-light">Ministries, Departments, Agencies</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all" data-aos="zoom-in" data-aos-delay="200">
                <i class="fa-solid fa-building-columns text-4xl text-accent mb-4"></i>
                <h3 class="font-bold text-lg mb-2">Financial Services</h3>
                <p class="text-xs text-slate-300 font-light">Banks, Insurance, Microfinance</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all" data-aos="zoom-in" data-aos-delay="300">
                <i class="fa-solid fa-graduation-cap text-4xl text-accent mb-4"></i>
                <h3 class="font-bold text-lg mb-2">Education</h3>
                <p class="text-xs text-slate-300 font-light">Universities, Research Institutions</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all" data-aos="zoom-in" data-aos-delay="400">
                <i class="fa-solid fa-notes-medical text-4xl text-accent mb-4"></i>
                <h3 class="font-bold text-lg mb-2">Healthcare</h3>
                <p class="text-xs text-slate-300 font-light">Hospitals, Health Agencies</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all" data-aos="zoom-in" data-aos-delay="500">
                <i class="fa-solid fa-bolt text-4xl text-accent mb-4"></i>
                <h3 class="font-bold text-lg mb-2">Energy & Infrastructure</h3>
                <p class="text-xs text-slate-300 font-light">Oil & Gas, Utilities</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all" data-aos="zoom-in" data-aos-delay="600">
                <i class="fa-solid fa-building text-4xl text-accent mb-4"></i>
                <h3 class="font-bold text-lg mb-2">Corporate & Commercial</h3>
                <p class="text-xs text-slate-300 font-light">SMEs, Enterprises, Retail</p>
            </div>
        </div>
    </div>
</section>

<!-- 6. Call to Action -->
<section class="py-20 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-6" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-primary dark:text-white">Ready to Transform Your Organisation?</h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-sm max-w-xl mx-auto">
            Our experts are ready to design and implement technology solutions that address your regulatory environment and strategic objectives.
        </p>
        <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-accent text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-md hover:scale-105 transition-all">
            Schedule a Consultation <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>
