<div class="space-y-8">

    <!-- Top Greetings banner -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">CMS Control Center</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Real-time status overview of systems content and received client inquiries.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Services -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Services</span>
                <span class="text-2xl font-bold text-slate-800"><?= $stats['services'] ?></span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-lg"><i class="fa-solid fa-laptop-code"></i></div>
        </div>
        <!-- Projects -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Case Studies</span>
                <span class="text-2xl font-bold text-slate-800"><?= $stats['projects'] ?></span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg"><i class="fa-solid fa-briefcase"></i></div>
        </div>
        <!-- Blogs -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Insights</span>
                <span class="text-2xl font-bold text-slate-800"><?= $stats['blogs'] ?></span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center text-lg"><i class="fa-solid fa-newspaper"></i></div>
        </div>
        <!-- Jobs -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Vacancies</span>
                <span class="text-2xl font-bold text-slate-800"><?= $stats['jobs'] ?></span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg"><i class="fa-solid fa-user-tie"></i></div>
        </div>
        <!-- Unread Messages -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 flex items-center justify-between shadow-sm relative">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Unread Inbox</span>
                <span class="text-2xl font-bold text-slate-800"><?= $stats['messages'] ?></span>
            </div>
            <div class="w-12 h-12 rounded-xl <?= $stats['messages'] > 0 ? 'bg-rose-500/15 text-rose-600 animate-pulse' : 'bg-slate-100 text-slate-500' ?> flex items-center justify-center text-lg">
                <i class="fa-solid fa-envelope"></i>
            </div>
        </div>
    </div>

    <!-- Charts & Action Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Analytics Chart -->
        <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-850 text-sm tracking-wide">Client Inquiries Analytics</h3>
            <div class="h-64">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>
        
        <!-- Quick actions -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4 flex flex-col justify-between">
            <h3 class="font-bold text-slate-850 text-sm tracking-wide">Quick Operations</h3>
            <div class="grid grid-cols-1 gap-2.5">
                <a href="<?= url('/admin/services/create') ?>" class="flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 rounded-xl transition-all"><i class="fa-solid fa-plus text-indigo-500"></i> Add Consulting Service</a>
                <a href="<?= url('/admin/projects/create') ?>" class="flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 rounded-xl transition-all"><i class="fa-solid fa-plus text-emerald-500"></i> Post Project Case Study</a>
                <a href="<?= url('/admin/insights/create') ?>" class="flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 rounded-xl transition-all"><i class="fa-solid fa-plus text-blue-500"></i> Publish Insight Post</a>
                <a href="<?= url('/admin/careers/create') ?>" class="flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 rounded-xl transition-all"><i class="fa-solid fa-plus text-amber-500"></i> Post Career Vacancy</a>
            </div>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Messages -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-slate-850 text-sm">Recent Public Inquiries</h3>
                <a href="<?= url('/admin/messages') ?>" class="text-[10px] font-bold text-indigo-600 uppercase hover:underline">View Inbox</a>
            </div>
            <div class="overflow-x-auto min-w-full">
                <table class="min-w-full text-left text-xs font-light text-slate-650">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="pb-3">Sender</th>
                            <th class="pb-3">Topic</th>
                            <th class="pb-3">Submitted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($recent_messages as $msg): ?>
                            <tr>
                                <td class="py-3.5 font-semibold text-slate-800"><?= e($msg['name']) ?></td>
                                <td class="py-3.5 text-slate-500"><?= e($msg['service_interested'] ?: 'General') ?></td>
                                <td class="py-3.5 text-slate-400 font-medium"><?= date('M d, H:i', strtotime($msg['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Audit Logs -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-slate-850 text-sm">Security Audit Trail</h3>
                <?php if (current_user()['role_name'] === 'Admin'): ?>
                    <a href="<?= url('/admin/logs') ?>" class="text-[10px] font-bold text-indigo-600 uppercase hover:underline">View Logs</a>
                <?php endif; ?>
            </div>
            <div class="overflow-x-auto min-w-full">
                <table class="min-w-full text-left text-xs font-light text-slate-650">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="pb-3">Staff</th>
                            <th class="pb-3">Action</th>
                            <th class="pb-3">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($recent_logs as $log): ?>
                            <tr>
                                <td class="py-3.5 font-semibold text-slate-800"><?= e($log['user_name'] ?: 'System') ?></td>
                                <td class="py-3.5 text-slate-500"><span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold uppercase"><?= e($log['action']) ?></span></td>
                                <td class="py-3.5 text-slate-400 font-medium"><?= date('M d, H:i', strtotime($log['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Chart Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Inquiries Received',
                    data: [12, 19, 15, 24, 22, 30, 28],
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.05)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
