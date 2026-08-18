<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Leadership Board CMS</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Manage details, corporate positions, bios, and order parameters for ISEC board members.</p>
        </div>
        <a href="<?= url('/admin/team/create') ?>" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-3 rounded-xl text-xs shadow-md transition-all flex items-center gap-1.5 self-start">
            <i class="fa-solid fa-plus"></i> Add Board Member
        </a>
    </div>

    <!-- Leadership Registry Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Board Member</th>
                        <th class="px-6 py-4">Corporate Position</th>
                        <th class="px-6 py-4">Brief Bio Extract</th>
                        <th class="px-6 py-4 text-center">Display Weight</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Social Profiles</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    <?php if (!empty($team)): ?>
                        <?php foreach ($team as $member): ?>
                            <?php $social = json_decode($member['social_links'] ?? '', true) ?: []; ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary to-accent flex items-center justify-center text-white text-xs font-black shadow-sm flex-shrink-0">
                                            <?= substr($member['name'], 0, 1) ?>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block"><?= e($member['name']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-650"><?= e($member['position']) ?></td>
                                <td class="px-6 py-4 max-w-xs truncate font-light text-slate-500"><?= e($member['bio']) ?></td>
                                <td class="px-6 py-4 text-center font-mono font-semibold"><?= (int)$member['display_order'] ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold <?= $member['status'] === 'active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200' ?> uppercase tracking-wider">
                                        <?= e($member['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <?php if (!empty($social['linkedin'])): ?>
                                            <a href="<?= e($social['linkedin']) ?>" target="_blank" class="text-indigo-650 hover:opacity-75 text-sm" title="LinkedIn Profile"><i class="fa-brands fa-linkedin"></i></a>
                                        <?php endif; ?>
                                        <?php if (!empty($social['twitter'])): ?>
                                            <a href="<?= e($social['twitter']) ?>" target="_blank" class="text-slate-700 hover:opacity-75 text-sm" title="Twitter Profile"><i class="fa-brands fa-square-x-twitter"></i></a>
                                        <?php endif; ?>
                                        <?php if (empty($social['linkedin']) && empty($social['twitter'])): ?>
                                            <span class="text-slate-300"><i class="fa-solid fa-link-slash"></i></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="<?= url('/admin/team/edit/' . $member['id']) ?>" class="hover:text-indigo-600 font-semibold transition-colors"><i class="fa-solid fa-pen-to-square mr-0.5"></i> Edit</a>
                                    <a href="<?= url('/admin/team/delete/' . $member['id']) ?>" onclick="return confirm('Remove this member from the leadership board?')" class="text-red-500 hover:text-red-700 font-semibold transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-people-group text-3xl mb-3 block text-slate-200"></i>
                                <span>No leadership board member records found in the database.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
