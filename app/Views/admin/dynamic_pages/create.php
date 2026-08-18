<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="<?= url('/admin/dynamic-pages') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Create Dynamic Page</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Design a new custom page using the rich text editor.</p>
        </div>
    </div>

    <form action="<?= url('/admin/dynamic-pages/store') ?>" method="POST" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Page Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all"
                        placeholder="e.g. Privacy Policy">
                </div>

                <div class="space-y-2">
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Status</label>
                    <select id="status" name="status"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        <option value="draft">Draft (Hidden)</option>
                        <option value="published">Published (Live)</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Page Content <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" class="tinymce"></textarea>
            </div>
        </div>

        <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <a href="<?= url('/admin/dynamic-pages') ?>" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200/50 transition-colors">Cancel</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Create Page
            </button>
        </div>
    </form>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        height: 500,
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        content_style: 'body { font-family:Inter,sans-serif; font-size:16px }',
        skin: 'oxide',
        branding: false,
        promotion: false
    });
</script>
