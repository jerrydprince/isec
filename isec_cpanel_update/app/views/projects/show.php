<!-- Project Header -->
<section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
        <a href="<?= url('/projects') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-accent uppercase tracking-widest hover:text-white transition-colors mb-4"><i class="fa-solid fa-arrow-left-long"></i> Back to Portfolio</a>
        <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-accent text-white uppercase tracking-widest inline-block"><?= e($project['category_name']) ?> Case Study</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight max-w-4xl"><?= e($project['title']) ?></h1>
    </div>
</section>

<!-- Detail Case Study -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Left Side narrative details -->
            <div class="lg:col-span-8 space-y-12">
                
                <!-- Challenge -->
                <?php if (!empty($project['challenge'])): ?>
                    <div class="space-y-4">
                        <h3 class="text-2xl font-bold text-primary dark:text-white"><span class="text-rose-500 mr-2">1.</span> The Challenge</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-light leading-relaxed text-sm">
                            <?= nl2br(e($project['challenge'])) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Solution -->
                <?php if (!empty($project['solution'])): ?>
                    <div class="space-y-4 border-t border-slate-100 dark:border-slate-850 pt-8">
                        <h3 class="text-2xl font-bold text-primary dark:text-white"><span class="text-accent mr-2">2.</span> The Technical Solution</h3>
                        <p class="text-slate-600 dark:text-slate-400 font-light leading-relaxed text-sm">
                            <?= nl2br(e($project['solution'])) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Outcome -->
                <?php if (!empty($project['outcome'])): ?>
                    <div class="space-y-4 border-t border-slate-100 dark:border-slate-850 pt-8 bg-emerald-500/5 dark:bg-emerald-500/10 p-8 rounded-3xl border border-emerald-500/10">
                        <h3 class="text-2xl font-bold text-emerald-800 dark:text-emerald-300"><span class="text-emerald-500 mr-2"><i class="fa-solid fa-square-poll-vertical"></i></span> Project Outcomes</h3>
                        <p class="text-emerald-950 dark:text-slate-300 font-light leading-relaxed text-sm">
                            <?= nl2br(e($project['outcome'])) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Photo Gallery / Photo Speaks -->
                <?php if (!empty($project['gallery_images'])): ?>
                    <div class="space-y-4 border-t border-slate-100 dark:border-slate-850 pt-8" x-data="{ lightboxOpen: false, activeImage: '' }">
                        <h3 class="text-2xl font-bold text-primary dark:text-white flex items-center gap-2">
                            <span><i class="fa-solid fa-images text-accent"></i></span> Project Gallery / Photo Speaks
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-light">Visual overview of onsite integration, workshops, and system operational deployment.</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                            <?php foreach (explode(',', $project['gallery_images']) as $imagePath): ?>
                                <?php if (!empty(trim($imagePath))): ?>
                                    <div class="group relative aspect-square bg-slate-100 dark:bg-slate-850 rounded-2xl overflow-hidden cursor-pointer border border-slate-200 dark:border-slate-800 shadow-sm"
                                         @click="activeImage = '<?= url(trim($imagePath)) ?>'; lightboxOpen = true">
                                        <img src="<?= url(trim($imagePath)) ?>" alt="Project Photo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                            <span class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Lightbox Overlay (using Alpine.js) -->
                        <div x-show="lightboxOpen" 
                             class="fixed inset-0 z-50 bg-slate-950/95 backdrop-blur-sm flex items-center justify-center p-4" 
                             style="display: none;"
                             @keydown.escape.window="lightboxOpen = false">
                            <button @click="lightboxOpen = false" class="absolute top-5 right-5 text-white/75 hover:text-white hover:scale-110 transition-all p-3 rounded-full bg-white/10">
                                <i class="fa-solid fa-xmark text-2xl"></i>
                            </button>
                            <div class="max-w-4xl max-h-[85vh] overflow-hidden rounded-2xl border border-white/10 shadow-2xl relative" @click.away="lightboxOpen = false">
                                <img :src="activeImage" alt="Expanded Photo Speaks" class="w-auto h-auto max-h-[85vh] max-w-full object-contain">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar metadata card -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850 space-y-6">
                    <h4 class="font-bold text-primary dark:text-white text-base">Project Metadata</h4>
                    <hr class="border-slate-200 dark:border-slate-800">
                    
                    <div class="grid grid-cols-2 gap-y-6 gap-x-4 text-xs">
                        <div>
                            <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Client</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300"><?= e($project['client']) ?></span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Location</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300"><?= e($project['location']) ?></span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Duration</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300"><?= e($project['duration'] ?? 'Completed') ?></span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Project Budget</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300"><?= e($project['budget'] ?? 'Confidential') ?></span>
                        </div>
                    </div>
                    
                    <hr class="border-slate-200 dark:border-slate-800">

                    <?php if (!empty($project['technologies'])): ?>
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Technologies Implemented</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach (explode(',', $project['technologies']) as $tech): ?>
                                    <span class="bg-slate-200 dark:bg-slate-800 px-2.5 py-1 rounded-md text-[10px] font-bold text-slate-600 dark:text-slate-300"><?= trim(e($tech)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Related Projects -->
        <?php if (!empty($related_projects)): ?>
            <div class="border-t border-slate-100 dark:border-slate-850 pt-20 mt-20">
                <h3 class="text-2xl font-bold text-primary dark:text-white mb-8">Other Case Studies in this Sector</h3>
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
