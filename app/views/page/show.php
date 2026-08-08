<!-- Hero Header -->
<section class="relative pt-32 pb-20 bg-slate-900 overflow-hidden">
    <!-- Background Patterns -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg class="absolute left-0 top-0 w-full h-full text-indigo-500" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
            <polygon points="0,100 100,0 100,100"/>
        </svg>
    </div>
    <div class="absolute inset-0 bg-gradient-to-tr from-primary/90 to-accent/90 mix-blend-multiply"></div>

    <div class="container mx-auto px-4 relative z-10 text-center text-white mt-12">
        <h1 class="text-4xl md:text-6xl font-bold font-outfit mb-6 animate-fade-in-up">
            <?= e($page['title']) ?>
        </h1>
        <div class="w-24 h-1.5 bg-gradient-to-r from-accent to-white mx-auto rounded-full mb-8 animate-fade-in-up" style="animation-delay: 0.2s;"></div>
    </div>
</section>

<!-- Content Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto prose prose-slate prose-lg lg:prose-xl prose-headings:font-outfit prose-a:text-indigo-600 hover:prose-a:text-indigo-800">
            <?= $page['content'] ?>
        </div>
    </div>
</section>
