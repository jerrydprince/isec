<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Write Insight Post</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Publish an article, executive whitepaper, or detailed case study.</p>
        </div>
        <a href="<?= url('/admin/insights') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to listing</a>
    </div>

    <!-- Form Panel Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <form action="<?= url('/admin/insights/create') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Article Title *</label>
                    <input type="text" name="title" placeholder="e.g. Systems Efficiency Frameworks in Governance" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Category *</label>
                    <select name="category_id" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Publication Type</label>
                    <select name="type" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                        <option value="blog">Blog & Article</option>
                        <option value="case-study">Case Study</option>
                        <option value="whitepaper">Executive Whitepaper</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Banner Image Thumbnail</label>
                    <input type="file" name="banner_image" accept=".jpg,.jpeg,.png" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Status</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                        <option value="draft">Draft (Private Sandbox)</option>
                        <option value="published">Published (Public Catalog)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Brief Excerpt Summary *</label>
                <input type="text" name="summary" placeholder="Provide a concise 1-2 sentence overview for indexing lists..." class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Tags (Comma separated)</label>
                    <input type="text" name="tags" placeholder="e.g. Technology, Security, ERP" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Article Gallery Images (Optional)</label>
                    <input type="file" name="gallery_images[]" multiple accept=".jpg,.jpeg,.png,.webp" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Highlight Quote (Optional)</label>
                <textarea name="quote" rows="2" placeholder="An impactful quote to highlight within the article..." class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Article Content (HTML Supported) *</label>
                <textarea name="content" rows="10" placeholder="<h4>Key Principles</h4><p>Details...</p>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all font-mono text-indigo-900" required></textarea>
            </div>

            <hr class="border-slate-100">

            <div class="flex justify-end gap-3">
                <a href="<?= url('/admin/insights') ?>" class="border border-slate-200 hover:bg-slate-50 font-bold px-6 py-3 rounded-xl text-xs text-slate-550 transition-all">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-xl text-xs shadow-md transition-all">Save Publication</button>
            </div>
        </form>
    </div>
</div>
