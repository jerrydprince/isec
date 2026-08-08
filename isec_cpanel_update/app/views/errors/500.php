<section class="py-32 flex items-center justify-center bg-slate-50 dark:bg-slate-950">
    <div class="max-w-xl mx-auto text-center space-y-6 px-4">
        <div class="w-20 h-20 bg-rose-500/10 rounded-full flex items-center justify-center text-rose-500 text-4xl mx-auto shadow-sm">
            <i class="fa-solid fa-bug"></i>
        </div>
        <h1 class="text-6xl font-black text-rose-600">500</h1>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200">System Processing Fault</h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-sm">
            An internal server exception interrupted systems execution. If you are an administrator, verify parameters in configuration logs.
        </p>

        <?php if (defined('APP_ENV') && APP_ENV === 'development' && isset($exception)): ?>
            <div class="bg-slate-900 text-left p-6 rounded-2xl border border-slate-800 text-xs font-mono text-rose-400 overflow-x-auto max-w-full space-y-2">
                <p class="font-bold">Exception: <?= e($exception->getMessage()) ?></p>
                <p class="text-[10px] text-slate-400">File: <?= e($exception->getFile()) ?> (Line: <?= e($exception->getLine()) ?>)</p>
                <pre class="text-[9px] text-slate-550 pt-2 border-t border-slate-850"><?= e($exception->getTraceAsString()) ?></pre>
            </div>
        <?php endif; ?>

        <div class="pt-4">
            <a href="<?= url('/') ?>" class="bg-gradient-to-r from-primary to-accent text-white font-bold px-8 py-3.5 rounded-full text-sm shadow-md hover:scale-105 transition-all">
                Return to Home Portal
            </a>
        </div>
    </div>
</section>
