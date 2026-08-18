<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Trainee Certificates Manager</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Manage, search, register, and update trainee professional certificates database.</p>
        </div>
        <a href="<?= url('/admin/certificates/create') ?>" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-3 rounded-xl text-xs shadow-md transition-all flex items-center gap-1.5 self-start">
            <i class="fa-solid fa-plus"></i> Issue Certificate
        </a>
    </div>

    <!-- Search Filters -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm">
        <form action="<?= url('/admin/certificates') ?>" method="GET" class="flex items-center gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400"><i class="fa-solid fa-magnifying-glass text-xs"></i></span>
                <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Search by recipient name or certificate number..." class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl pl-9 pr-4 py-2.5 text-xs outline-none transition-all text-slate-850">
            </div>
            <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition-all">Search</button>
            <?php if (!empty($search)): ?>
                <a href="<?= url('/admin/certificates') ?>" class="border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold px-4 py-2.5 rounded-xl text-xs transition-all">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Database Listing Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Certificate ID / Number</th>
                        <th class="px-6 py-4">Recipient Trainee</th>
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4">Issue Date</th>
                        <th class="px-6 py-4 text-center">Grade / Status</th>
                        <th class="px-6 py-4 text-center">PDF Copy</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    <?php if (!empty($certificates)): ?>
                        <?php foreach ($certificates as $cert): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-indigo-650"><?= e($cert['certificate_number']) ?></td>
                                <td class="px-6 py-4 font-semibold text-slate-900"><?= e($cert['recipient_name']) ?></td>
                                <td class="px-6 py-4 max-w-xs truncate"><?= e($cert['course_name']) ?></td>
                                <td class="px-6 py-4"><?= date('Y-m-d', strtotime($cert['issue_date'])) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase tracking-wider">
                                        <?= e($cert['grade_status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if (!empty($cert['pdf_path'])): ?>
                                        <a href="<?= url('/' . $cert['pdf_path']) ?>" target="_blank" class="text-red-500 hover:text-red-700 text-base" title="Download PDF Certificate Copy"><i class="fa-solid fa-file-pdf"></i></a>
                                    <?php else: ?>
                                        <span class="text-slate-300"><i class="fa-solid fa-circle-minus"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/certificates/edit/' . $cert['id']) ?>" class="hover:text-indigo-600 font-semibold transition-colors"><i class="fa-solid fa-pen-to-square mr-0.5"></i> Edit</a>
                                    <a href="<?= url('/admin/certificates/delete/' . $cert['id']) ?>" onclick="return confirm('Are you sure you want to revoke/delete this certificate record?')" class="text-red-500 hover:text-red-700 font-semibold transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-award text-3xl mb-3 block text-slate-200"></i>
                                <span>No certificate registration logs found matching search filters.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
