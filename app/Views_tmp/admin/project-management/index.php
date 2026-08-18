<div class="px-6 py-8 md:py-10 max-w-7xl mx-auto" x-data="{ searchTerm: '', statusFilter: 'All' }">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Project Management</h1>
            <p class="text-slate-500 mt-1">Track projects, tasks, and team progress</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= url('/admin/project-management/create') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-plus"></i> New Project
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <i class="fa-solid fa-search"></i>
            </div>
            <input x-model="searchTerm" type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm" placeholder="Search projects or clients...">
        </div>
        <select x-model="statusFilter" class="block w-full md:w-48 px-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm">
            <option value="All">All Statuses</option>
            <option value="Not Started">Not Started</option>
            <option value="In Progress">In Progress</option>
            <option value="On Hold">On Hold</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($projects as $project): ?>
            <?php 
                // Calculate progress
                $total = (int)$project['total_tasks'];
                $completed = (int)$project['completed_tasks'];
                $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                
                // Status colors
                $statusColors = [
                    'Not Started' => 'bg-slate-100 text-slate-600 border-slate-200',
                    'In Progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'On Hold' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'Completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200'
                ];
                $sColor = $statusColors[$project['status']] ?? $statusColors['Not Started'];
            ?>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col"
                 x-show="(statusFilter === 'All' || statusFilter === '<?= $project['status'] ?>') && ('<?= strtolower($project['name'] . ' ' . $project['customer_name']) ?>'.includes(searchTerm.toLowerCase()))">
                
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-start mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border <?= $sColor ?>">
                            <?= $project['status'] ?>
                        </span>
                        
                        <div class="flex items-center space-x-1">
                            <a href="<?= url('/admin/project-management/edit/' . $project['id']) ?>" class="text-slate-400 hover:text-indigo-600 p-1 transition-colors" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </div>
                    </div>
                    
                    <a href="<?= url('/admin/project-management/view/' . $project['id']) ?>" class="block group">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1 mb-1">
                            <?= e($project['name']) ?>
                        </h3>
                        <?php if ($project['customer_name']): ?>
                            <p class="text-sm text-slate-500 mb-4 flex items-center gap-1.5">
                                <i class="fa-regular fa-building"></i> <?= e($project['customer_name']) ?>
                            </p>
                        <?php else: ?>
                            <p class="text-sm text-slate-400 mb-4 italic">Internal Project</p>
                        <?php endif; ?>
                    </a>
                    
                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-medium mb-1.5">
                            <span class="text-slate-600">Progress</span>
                            <span class="text-slate-900"><?= $progress ?>%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: <?= $progress ?>%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-slate-500 mt-1.5">
                            <span><?= $completed ?> / <?= $total ?> Tasks</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-auto pt-4 border-t border-slate-100 text-sm">
                        <div>
                            <span class="block text-xs text-slate-500 font-medium mb-0.5">Due Date</span>
                            <span class="text-slate-800 font-medium <?= ($project['due_date'] && strtotime($project['due_date']) < time() && $project['status'] !== 'Completed') ? 'text-rose-600' : '' ?>">
                                <?= $project['due_date'] ? date('M j, Y', strtotime($project['due_date'])) : 'No Date' ?>
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-500 font-medium mb-0.5">Budget</span>
                            <span class="text-slate-800 font-medium">
                                <?= $project['budget'] > 0 ? '₦' . number_format($project['budget'], 2) : '--' ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 border-t border-slate-200 px-5 py-3">
                    <a href="<?= url('/admin/project-management/view/' . $project['id']) ?>" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center justify-center gap-1.5">
                        Open Project Workspace <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($projects)): ?>
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 border-dashed">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">No projects found</h3>
                <p class="text-slate-500 mb-6">You haven't created any projects yet.</p>
                <a href="<?= url('/admin/project-management/create') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                    <i class="fa-solid fa-plus"></i> Create First Project
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
