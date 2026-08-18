<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?= $template ? 'Edit Template' : 'Create Template' ?></h1>
            <p class="text-sm text-slate-500 mt-1"><?= $template ? 'Modify your existing message template.' : 'Design a new message template for your broadcasts.' ?></p>
        </div>
        <a href="<?= url('/admin/templates') ?>" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Templates
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-data="{ type: '<?= $template ? e($template['type']) : 'Email' ?>' }">
        <form action="<?= $template ? url("/admin/templates/{$template['id']}/edit") : url('/admin/templates/create') ?>" method="POST" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Template Name *</label>
                    <input type="text" name="name" value="<?= $template ? e($template['name']) : '' ?>" placeholder="e.g., Welcome Email, Payment Reminder" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none transition-all font-semibold text-slate-800" required>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Template Type *</label>
                    <div class="relative">
                        <select name="type" x-model="type" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none transition-all font-semibold text-slate-800 appearance-none cursor-pointer" required>
                            <option value="Email" <?= ($template && $template['type'] === 'Email') ? 'selected' : '' ?>>Email (Supports HTML)</option>
                            <option value="SMS" <?= ($template && $template['type'] === 'SMS') ? 'selected' : '' ?>>SMS (Plain Text)</option>
                            <option value="WhatsApp" <?= ($template && $template['type'] === 'WhatsApp') ? 'selected' : '' ?>>WhatsApp (Rich Text/Markdown)</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Subject (Only for Email) -->
            <div x-show="type === 'Email'" x-collapse>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email Subject *</label>
                <input type="text" name="subject" value="<?= $template ? e($template['subject'] ?? '') : '' ?>" placeholder="e.g., Action Required: Your Invoice is Ready" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none transition-all font-semibold text-slate-800" :required="type === 'Email'">
            </div>

            <!-- Body -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Message Content *</label>
                    <span x-show="type === 'Email'" class="text-[10px] font-bold text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md">HTML SUPPORTED</span>
                    <span x-show="type === 'SMS'" class="text-[10px] font-bold text-sky-500 bg-sky-50 px-2 py-0.5 rounded-md">PLAIN TEXT ONLY</span>
                    <span x-show="type === 'WhatsApp'" class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-md">MARKDOWN SUPPORTED</span>
                </div>
                <textarea name="body" rows="12" placeholder="Write your template content here..." class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none transition-all font-mono text-slate-800" required><?= $template ? e($template['body']) : '' ?></textarea>
                <p class="text-xs text-slate-400 mt-2"><i class="fa-solid fa-circle-info mr-1"></i> You can use variables in your application (e.g., {{name}}) and they will be replaced when sending.</p>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-sm shadow-indigo-600/20 transition-all flex items-center gap-2">
                    <i class="fa-solid <?= $template ? 'fa-check' : 'fa-plus' ?>"></i>
                    <?= $template ? 'Update Template' : 'Save Template' ?>
                </button>
            </div>
        </form>
    </div>
</div>
