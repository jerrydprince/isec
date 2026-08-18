<div class="max-w-4xl mx-auto space-y-6" x-data="{ activeTab: 'home' }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Frontend Pages CMS Editor</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Customize headings, descriptors, missions, and philosophies dynamically without modifying code templates.</p>
        </div>
    </div>

    <!-- Tab Buttons -->
    <div class="flex items-center gap-2 border-b border-slate-200 p-1 bg-white rounded-xl shadow-sm border">
        <button @click="activeTab = 'home'" :class="activeTab === 'home' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-550 hover:bg-slate-50'" class="px-5 py-2.5 rounded-lg text-xs font-bold transition-all">Home Page</button>
        <button @click="activeTab = 'about'" :class="activeTab === 'about' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-550 hover:bg-slate-50'" class="px-5 py-2.5 rounded-lg text-xs font-bold transition-all">About Page</button>
    </div>

    <!-- Form Panel Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <form action="<?= url('/admin/cms-pages') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            
            <!-- Home Tab Content -->
            <div x-show="activeTab === 'home'" class="space-y-6">
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-1.5"><i class="fa-solid fa-house text-accent text-xs"></i> Home Page Content Blocks</h3>
                <?php if (isset($grouped_contents['home'])): ?>
                    <?php foreach ($grouped_contents['home'] as $block): ?>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <?= e(str_replace('_', ' ', $block['section_key'])) ?>
                            </label>
                            <textarea name="content_values[<?= $block['id'] ?>]" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850"><?= e($block['content_value']) ?></textarea>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-xs text-slate-400">No editable blocks configured for the Home Page.</p>
                <?php endif; ?>
            </div>

            <!-- About Tab Content -->
            <div x-show="activeTab === 'about'" class="space-y-6" style="display: none;">
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-1.5"><i class="fa-solid fa-address-card text-accent text-xs"></i> About Page Content Blocks</h3>
                <?php if (isset($grouped_contents['about'])): ?>
                    <?php foreach ($grouped_contents['about'] as $block): ?>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <?= e(str_replace('_', ' ', $block['section_key'])) ?>
                            </label>
                            <textarea name="content_values[<?= $block['id'] ?>]" rows="4" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850"><?= e($block['content_value']) ?></textarea>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-xs text-slate-400">No editable blocks configured for the About Page.</p>
                <?php endif; ?>
            </div>

            <hr class="border-slate-100">

            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-xl text-xs shadow-md transition-all">Save Page Contents</button>
            </div>
        </form>
    </div>
</div>
