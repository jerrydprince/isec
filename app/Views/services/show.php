<!-- Service Header -->
<section class="py-24 relative overflow-hidden bg-slate-950 text-white">
    <div class="absolute inset-0 z-0 opacity-40">
        <img src="<?= url('/assets/images/service_bg.png') ?>" alt="Consulting Architecture" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-transparent z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
        <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-accent uppercase tracking-widest hover:text-white transition-colors mb-4"><i class="fa-solid fa-arrow-left-long"></i> Back to Services</a>
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <div class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur-md flex items-center justify-center text-accent text-4xl font-bold border border-white/20 flex-shrink-0 shadow-xl" data-aos="zoom-in">
                <i class="fa-solid <?= e($service['icon']) ?>"></i>
            </div>
            <div data-aos="fade-right">
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-2"><?= e($service['title']) ?></h1>
                <p class="text-slate-300 font-light text-base sm:text-lg max-w-2xl border-l-2 border-accent pl-4">Consultancy Framework & System Engineering Blueprint</p>
            </div>
        </div>
    </div>
</section>

<!-- Detail Content -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Left Side main text -->
            <div class="lg:col-span-8 space-y-12">
                
                <div class="rounded-3xl overflow-hidden shadow-lg border-4 border-slate-50 dark:border-slate-800" data-aos="fade-up">
                    <img src="<?= url('/assets/images/professionals.png') ?>" alt="ISEC Professionals" class="w-full h-64 object-cover">
                </div>

                <!-- Overview -->
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-primary dark:text-white">Service Overview</h3>
                    <div class="text-slate-600 dark:text-slate-400 font-light leading-relaxed space-y-4 text-sm">
                        <?= nl2br(e($service['description'])) ?>
                    </div>
                </div>

                <!-- Features & Benefits Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php if (!empty($service['features'])): ?>
                        <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850">
                            <h4 class="font-bold text-lg text-primary dark:text-white mb-4"><i class="fa-solid fa-list-check text-accent mr-2"></i> Features & Modules</h4>
                            <div class="text-slate-600 dark:text-slate-400 font-light text-xs leading-relaxed space-y-2">
                                <?= nl2br(e($service['features'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($service['benefits'])): ?>
                        <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850">
                            <h4 class="font-bold text-lg text-primary dark:text-white mb-4"><i class="fa-solid fa-arrow-trend-up text-accent mr-2"></i> Measurable Benefits</h4>
                            <div class="text-slate-600 dark:text-slate-400 font-light text-xs leading-relaxed space-y-2">
                                <?= nl2br(e($service['benefits'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Methodology -->
                <?php if (!empty($service['methodology'])): ?>
                    <div class="space-y-4 border-t border-slate-100 dark:border-slate-850 pt-8">
                        <h3 class="text-2xl font-bold text-primary dark:text-white">Methodology</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-light leading-relaxed text-sm">
                            <?= nl2br(e($service['methodology'])) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Deliverables -->
                <?php if (!empty($service['deliverables'])): ?>
                    <div class="space-y-4 border-t border-slate-100 dark:border-slate-850 pt-8">
                        <h3 class="text-2xl font-bold text-primary dark:text-white">Key Deliverables</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-light leading-relaxed text-sm">
                            <?= nl2br(e($service['deliverables'])) ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar meta tags -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Tech stack card -->
                <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850 space-y-6">
                    <h4 class="font-bold text-primary dark:text-white text-base">Advisory Details</h4>
                    <hr class="border-slate-200 dark:border-slate-800">
                    
                    <?php if (!empty($service['technologies'])): ?>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Technologies Used</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach (explode(',', $service['technologies']) as $tech): ?>
                                    <span class="bg-slate-200 dark:bg-slate-800 px-2.5 py-1 rounded-md text-[10px] font-bold text-slate-600 dark:text-slate-300"><?= trim(e($tech)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($service['industries_served'])): ?>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Industries Served</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach (explode(',', $service['industries_served']) as $ind): ?>
                                    <span class="bg-indigo-500/10 px-2.5 py-1 rounded-md text-[10px] font-bold text-indigo-400"><?= trim(e($ind)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Call to action side box -->
                <div class="bg-gradient-to-tr from-primary to-secondary p-8 rounded-3xl text-white space-y-4 text-center">
                    <h4 class="font-bold text-lg">Request Advisory Session</h4>
                    <p class="text-xs text-slate-300 font-light leading-relaxed">Arrange a call with our senior architects to structure an SLA mapping your requirements.</p>
                    <a href="<?= url('/contact?service=' . urlencode($service['title'])) ?>" class="block w-full bg-accent hover:brightness-110 text-white font-bold text-xs py-3.5 rounded-xl shadow-md transition-all">Submit Advisory Request</a>
                </div>
            </div>
        </div>

        <!-- Related Case Studies -->
        <?php if (!empty($related_projects)): ?>
            <div class="border-t border-slate-100 dark:border-slate-850 pt-20 mt-20">
                <h3 class="text-2xl font-bold text-primary dark:text-white mb-8">Related Case Studies</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($related_projects as $proj): ?>
                        <div class="group bg-slate-50 dark:bg-slate-950 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                            <div class="p-8">
                                <span class="px-2.5 py-0.5 rounded bg-accent/10 text-[9px] font-bold text-accent uppercase tracking-widest mb-3 inline-block"><?= e($proj['category_name']) ?></span>
                                <h4 class="font-bold text-primary dark:text-white mb-2 group-hover:text-accent transition-colors"><a href="<?= url('/projects/' . $proj['slug']) ?>"><?= e($proj['title']) ?></a></h4>
                                <p class="text-slate-500 dark:text-slate-400 font-light text-xs leading-relaxed"><?= e(excerpt($proj['challenge'], 18)) ?></p>
                            </div>
                            <div class="px-8 pb-8">
                                <a href="<?= url('/projects/' . $proj['slug']) ?>" class="text-[10px] font-bold uppercase tracking-wider text-accent inline-flex items-center gap-1.5 hover:gap-3 transition-all">Read Case Study <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
