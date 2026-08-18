<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Message Templates</h1>
            <p class="text-sm text-slate-500 mt-1">Manage reusable templates for Email, SMS, and WhatsApp broadcasts.</p>
        </div>
        <a href="<?= url('/admin/templates/create') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm shadow-indigo-600/20 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Create Template
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-wrap gap-2">
        <a href="<?= url('/admin/templates') ?>" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all <?= empty($currentType) ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>">All Templates</a>
        <a href="<?= url('/admin/templates?type=Email') ?>" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all <?= $currentType === 'Email' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>"><i class="fa-solid fa-envelope mr-1"></i> Email</a>
        <a href="<?= url('/admin/templates?type=SMS') ?>" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all <?= $currentType === 'SMS' ? 'bg-sky-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>"><i class="fa-solid fa-comment-sms mr-1"></i> SMS</a>
        <a href="<?= url('/admin/templates?type=WhatsApp') ?>" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all <?= $currentType === 'WhatsApp' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>"><i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp</a>
    </div>

    <!-- Templates List -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <?php if (count($templates) > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Type</th>
                            <th class="px-6 py-4 font-semibold">Subject</th>
                            <th class="px-6 py-4 font-semibold">Created At</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($templates as $tmpl): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800"><?= e($tmpl['name']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($tmpl['type'] === 'Email'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200"><i class="fa-solid fa-envelope"></i> Email</span>
                                    <?php elseif ($tmpl['type'] === 'SMS'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200"><i class="fa-solid fa-comment-sms"></i> SMS</span>
                                    <?php elseif ($tmpl['type'] === 'WhatsApp'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"><i class="fa-brands fa-whatsapp"></i> WhatsApp</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-600"><?= $tmpl['subject'] ? e($tmpl['subject']) : '<span class="text-slate-400 italic">N/A</span>' ?></span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    <?= date('M d, Y', strtotime($tmpl['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url("/admin/templates/{$tmpl['id']}/edit") ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-indigo-600 transition-colors" title="Edit Template">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="<?= url("/admin/templates/{$tmpl['id']}/delete") ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this template?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:bg-rose-100 hover:text-rose-600 transition-colors" title="Delete Template">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-12 text-center flex flex-col items-center">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-4 text-2xl">
                    <i class="fa-solid fa-code"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">No Templates Found</h3>
                <p class="text-slate-500 mt-1 max-w-sm">You haven't created any message templates yet. Create one to reuse across your broadcasts.</p>
                <a href="<?= url('/admin/templates/create') ?>" class="mt-6 bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">Create First Template</a>
            </div>
        <?php endif; ?>
    </div>
</div>
