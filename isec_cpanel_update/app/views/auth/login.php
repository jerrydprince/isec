<div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl relative">
    <!-- Branding logo inside card -->
    <div class="flex flex-col items-center mb-8">
        <div class="bg-white p-3 rounded-2xl shadow-md mb-4 flex items-center justify-center">
            <img src="<?= asset('images/logo.png') ?>?v=5" alt="ISEC Logo" class="h-10 w-auto object-contain" />
        </div>
        <h2 class="text-xs font-bold tracking-widest text-slate-400 uppercase"><?= e($shortName ?? 'ISEC') ?> Control Panel</h2>
    </div>

    <!-- Login Form -->
    <form action="<?= url('/admin/login') ?>" method="POST" class="space-y-4">
        <?= csrf_field() ?>
        
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Work Email Address</label>
            <div class="relative flex items-center">
                <i class="fa-solid fa-envelope absolute left-4 text-slate-500 text-xs"></i>
                <input type="email" name="email" placeholder="name@isec.com.ng" class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 rounded-xl pl-11 pr-4 py-3.5 text-xs outline-none text-white transition-all placeholder:text-slate-650" required>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Security Password</label>
            <div class="relative flex items-center">
                <i class="fa-solid fa-lock absolute left-4 text-slate-500 text-xs"></i>
                <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 rounded-xl pl-11 pr-4 py-3.5 text-xs outline-none text-white transition-all placeholder:text-slate-650" required>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white font-bold py-4 rounded-xl text-xs shadow-md transition-all flex items-center justify-center gap-2">
                <span>Authenticate credentials</span> <i class="fa-solid fa-shield-halved"></i>
            </button>
        </div>
    </form>
    
    <div class="text-center mt-6">
        <a href="<?= url('/') ?>" class="text-[10px] text-slate-500 hover:text-slate-350 transition-colors font-medium"><i class="fa-solid fa-arrow-left mr-1"></i> Back to public site</a>
    </div>
</div>
