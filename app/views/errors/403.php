<section class="py-32 flex items-center justify-center bg-slate-50 dark:bg-slate-950">
    <div class="max-w-md mx-auto text-center space-y-6 px-4">
        <div class="w-20 h-20 bg-rose-500/10 rounded-full flex items-center justify-center text-rose-500 text-4xl mx-auto shadow-sm">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h1 class="text-6xl font-black text-rose-500">403</h1>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Forbidden Access</h2>
        <p class="text-slate-500 dark:text-slate-400 font-light text-sm">
            You do not possess the required credential privileges or your security CSRF token verification failed. Action logged in audit trail.
        </p>
        <div class="pt-4 flex gap-4 justify-center">
            <a href="<?= url('/admin') ?>" class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-6 py-3 rounded-full text-xs transition-all">
                Control Panel
            </a>
            <a href="<?= url('/') ?>" class="border border-slate-250 dark:border-slate-800 hover:text-accent hover:border-accent font-bold px-6 py-3 rounded-full text-xs transition-all">
                Home Portal
            </a>
        </div>
    </div>
</section>
