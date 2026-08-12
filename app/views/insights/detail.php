<!-- Insight Detail Header -->
<section class="py-24 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
        <a href="<?= url('/insights') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-accent uppercase tracking-widest hover:text-white transition-colors mb-4"><i class="fa-solid fa-arrow-left-long"></i> Back to Knowledge Hub</a>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
            <span class="px-2.5 py-0.5 rounded bg-accent/20 text-accent"><?= e($insight['type']) ?></span>
            <span>•</span>
            <span>Category: <?= e($insight['category_name']) ?></span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight"><?= e($insight['title']) ?></h1>
        <div class="flex items-center gap-3 text-xs font-medium text-slate-350 pt-2">
            <span class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center font-bold text-white"><?= substr($insight['author_name'], 0, 1) ?></span>
            <span>By <?= e($insight['author_name']) ?></span>
            <span>•</span>
            <span>Published: <?= date('F d, Y', strtotime($insight['published_at'])) ?></span>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Article Banner Image -->
        <?php if (!empty($insight['banner_image']) && $insight['banner_image'] !== 'insight_placeholder.jpg'): ?>
            <div class="mb-12 rounded-[2rem] overflow-hidden shadow-2xl border border-slate-100 dark:border-slate-800 h-[300px] sm:h-[450px]">
                <img src="<?= url(trim($insight['banner_image'])) ?>" alt="<?= e($insight['title']) ?>" class="w-full h-full object-cover">
            </div>
        <?php endif; ?>
        
        <!-- Main Rich Text Content area -->
        <article class="prose prose-slate dark:prose-invert max-w-none text-slate-650 dark:text-slate-350 leading-relaxed font-light text-sm space-y-6">
            <!-- Custom CSS injected dynamically to support standard styling inside unescaped HTML database queries -->
            <style>
                article h4 { font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; color: #0f172a; }
                .dark article h4 { color: #f8fafc; }
                article p { margin-bottom: 1.25rem; }
                article ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
            </style>
            
            <?php if (!empty($insight['quote'])): ?>
                <blockquote class="border-l-4 border-accent pl-6 py-4 my-8 bg-slate-50 dark:bg-slate-800/50 rounded-r-2xl italic font-medium text-lg text-slate-800 dark:text-slate-200">
                    "<?= e($insight['quote']) ?>"
                </blockquote>
            <?php endif; ?>

            <?= parse_article_content($insight['content']) // Formatted to support markdown images and plain text paragraphs ?>

            <?php if (!empty($insight['gallery_images'])): ?>
                <?php $gallery = explode(',', $insight['gallery_images']); ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-12 mb-8">
                    <?php foreach($gallery as $img): ?>
                        <div class="rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800 h-48">
                            <img src="<?= url(trim($img)) ?>" alt="Gallery Image" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </article>

        <?php if (!empty($insight['tags'])): ?>
            <?php $tags = array_map('trim', explode(',', $insight['tags'])); ?>
            <div class="flex flex-wrap gap-2 mt-10">
                <?php foreach($tags as $tag): ?>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[10px] font-bold uppercase tracking-widest rounded-full"><?= e($tag) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Dynamic Share bar -->
        <?php 
            $shareUrl = urlencode(url('/insights/' . $insight['slug']));
            $shareTitle = urlencode($insight['title']);
        ?>
        <div class="border-t border-slate-100 dark:border-slate-850 pt-8 mt-8 flex flex-wrap justify-between items-center gap-4 text-xs font-bold text-slate-400">
            <div class="flex items-center gap-4">
                <span>Share this:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#1877F2] transition-colors"><i class="fa-brands fa-facebook text-lg"></i></a>
                <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#1DA1F2] transition-colors"><i class="fa-brands fa-x-twitter text-lg"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $shareUrl ?>&title=<?= $shareTitle ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#0A66C2] transition-colors"><i class="fa-brands fa-linkedin text-lg"></i></a>
            </div>
            <a href="<?= url('/insights') ?>" class="text-accent hover:underline">Back to insights list</a>
        </div>
        <!-- Unique Author Profile Card -->
        <div class="mt-20 bg-gradient-to-br from-slate-50 to-white dark:from-slate-900 dark:to-slate-950 rounded-[2rem] p-8 sm:p-10 border border-slate-200/60 dark:border-slate-800 shadow-xl shadow-slate-200/20 dark:shadow-none flex flex-col md:flex-row items-center md:items-start gap-8 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full blur-3xl -mr-20 -mt-20 transition-transform duration-700 group-hover:scale-150"></div>
            
            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-primary to-accent flex-shrink-0 flex items-center justify-center text-3xl sm:text-4xl font-extrabold text-white shadow-lg border-4 border-white dark:border-slate-900 z-10">
                <?= substr($insight['author_name'], 0, 1) ?>
            </div>
            
            <div class="text-center md:text-left flex-1 z-10">
                <span class="inline-block px-3 py-1 bg-accent/10 text-accent text-[10px] font-bold uppercase tracking-widest rounded-full mb-3">About the Author</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-3"><?= e($insight['author_name']) ?></h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed max-w-2xl">
                    <?= e($insight['author_name']) ?> is an expert contributor at ISEC, specializing in systems efficiency and technology optimization. They frequently share valuable insights and perspectives on <?= strtolower(e($insight['category_name'])) ?> and strategic implementations.
                </p>
                <div class="mt-6 flex justify-center md:justify-start gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-white hover:bg-[#0A66C2] transition-all duration-300 shadow-sm"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-900 transition-all duration-300 shadow-sm"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-white hover:bg-accent transition-all duration-300 shadow-sm"><i class="fa-solid fa-envelope text-sm"></i></a>
                </div>
            </div>
        </div>

        <!-- Related Insights -->
        <?php if (!empty($related)): ?>
            <div class="border-t border-slate-100 dark:border-slate-850 pt-16 mt-16">
                <h3 class="text-2xl font-bold text-primary dark:text-white mb-8">Related Publications</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($related as $rel): ?>
                        <div class="bg-slate-50 dark:bg-slate-950 p-6 rounded-3xl border border-slate-200 dark:border-slate-850 hover:border-accent hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <span class="text-[9px] font-bold text-accent uppercase tracking-widest mb-2 block"><?= e($rel['type']) ?></span>
                                <h4 class="font-bold text-sm text-primary dark:text-white mb-2 line-clamp-2"><a href="<?= url('/insights/' . $rel['slug']) ?>"><?= e($rel['title']) ?></a></h4>
                            </div>
                            <a href="<?= url('/insights/' . $rel['slug']) ?>" class="text-[10px] font-bold text-accent inline-flex items-center gap-1.5 hover:gap-3 transition-all mt-4">Read <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
