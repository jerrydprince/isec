<div class="px-6 py-8 md:py-10 max-w-7xl mx-auto" x-data="{ activeTab: 'tasks', showTaskModal: false, editTaskData: null, showTimeModal: false, showFileModal: false }">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-2 font-medium">
                <a href="<?= url('/admin/project-management') ?>" class="hover:text-indigo-600 transition-colors">Projects</a>
                <span>/</span>
                <span class="text-slate-900"><?= e($project['name']) ?></span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight"><?= e($project['name']) ?></h1>
                <?php 
                    $statusColors = [
                        'Not Started' => 'bg-slate-100 text-slate-600 border-slate-200',
                        'In Progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'On Hold' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'Completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200'
                    ];
                    $sColor = $statusColors[$project['status']] ?? $statusColors['Not Started'];
                ?>
                <span class="px-3 py-1 rounded-full text-xs font-semibold border <?= $sColor ?>"><?= $project['status'] ?></span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= url('/admin/project-management/edit/' . $project['id']) ?>" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-pen mr-1.5"></i> Edit
            </a>
            <a href="<?= url('/admin/project-management/delete/' . $project['id']) ?>" onclick="return confirm('Delete this project completely? This action cannot be undone.')" class="px-4 py-2 bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>
    </div>

    <!-- Quick Stats Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-regular fa-building"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Client</p>
                <p class="font-bold text-slate-900 line-clamp-1"><?= $project['customer_name'] ? e($project['customer_name']) : 'Internal' ?></p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Budget</p>
                <p class="font-bold text-slate-900">₦<?= number_format($project['budget'], 2) ?></p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Time Logged</p>
                <p class="font-bold text-slate-900">
                    <?php 
                        $totalHours = array_sum(array_column($timeLogs, 'hours'));
                        echo $totalHours . ' hrs';
                    ?>
                </p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fa-regular fa-calendar-xmark"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Deadline</p>
                <p class="font-bold text-slate-900"><?= $project['due_date'] ? date('M j, Y', strtotime($project['due_date'])) : '--' ?></p>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-slate-200 mb-8 overflow-x-auto">
        <nav class="flex space-x-8 min-w-max px-2">
            <button @click="activeTab = 'tasks'" :class="activeTab === 'tasks' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fa-solid fa-list-check mr-2"></i> Tasks & Board
            </button>
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fa-solid fa-circle-info mr-2"></i> Overview & Info
            </button>
            <button @click="activeTab = 'time'" :class="activeTab === 'time' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fa-solid fa-stopwatch mr-2"></i> Time Logs
            </button>
            <button @click="activeTab = 'files'" :class="activeTab === 'files' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fa-solid fa-paperclip mr-2"></i> Attachments (<?= count($files) ?>)
            </button>
            <button @click="activeTab = 'invoices'" :class="activeTab === 'invoices' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fa-solid fa-file-invoice mr-2"></i> Invoices
            </button>
        </nav>
    </div>

    <!-- TAB: TASKS (KANBAN) -->
    <div x-show="activeTab === 'tasks'" style="display: none;" class="animate-fade-in-up">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Task Board</h2>
            <button @click="editTaskData = null; showTaskModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Add Task
            </button>
        </div>

        <?php 
            $boardCols = [
                'To Do' => ['color' => 'bg-slate-100', 'textColor' => 'text-slate-800', 'borderColor' => 'border-slate-200'],
                'In Progress' => ['color' => 'bg-blue-50', 'textColor' => 'text-blue-800', 'borderColor' => 'border-blue-200'],
                'In Review' => ['color' => 'bg-amber-50', 'textColor' => 'text-amber-800', 'borderColor' => 'border-amber-200'],
                'Completed' => ['color' => 'bg-emerald-50', 'textColor' => 'text-emerald-800', 'borderColor' => 'border-emerald-200']
            ];
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
            <?php foreach($boardCols as $colStatus => $colConfig): ?>
                <div class="<?= $colConfig['color'] ?> border <?= $colConfig['borderColor'] ?> rounded-2xl p-4 min-h-[400px]">
                    <h3 class="font-bold <?= $colConfig['textColor'] ?> mb-4 flex justify-between items-center">
                        <?= $colStatus ?>
                        <span class="bg-white/50 px-2 py-0.5 rounded-full text-xs"><?= count(array_filter($tasks, fn($t) => $t['status'] === $colStatus)) ?></span>
                    </h3>
                    
                    <div class="space-y-3">
                        <?php foreach($tasks as $t): ?>
                            <?php if($t['status'] === $colStatus): ?>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 group relative">
                                    
                                    <div class="flex justify-between items-start mb-2">
                                        <?php 
                                            $priColor = match($t['priority']) {
                                                'Low' => 'text-slate-400 bg-slate-100',
                                                'Medium' => 'text-blue-600 bg-blue-50',
                                                'High' => 'text-orange-600 bg-orange-50',
                                                'Urgent' => 'text-rose-600 bg-rose-50',
                                                default => 'text-slate-500 bg-slate-100'
                                            };
                                        ?>
                                        <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded <?= $priColor ?>">
                                            <?= $t['priority'] ?>
                                        </span>
                                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button @click="editTaskData = <?= htmlspecialchars(json_encode($t)) ?>; showTaskModal = true" class="text-slate-400 hover:text-indigo-600 p-1">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <a href="<?= url('/admin/project-management/task-delete/'.$project['id'].'/'.$t['id']) ?>" onclick="return confirm('Delete task?')" class="text-slate-400 hover:text-rose-600 p-1">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <h4 class="font-semibold text-slate-800 text-sm mb-1"><?= e($t['title']) ?></h4>
                                    <?php if($t['description']): ?>
                                        <p class="text-xs text-slate-500 line-clamp-2 mb-3"><?= e($t['description']) ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="flex justify-between items-center text-xs mt-3 pt-3 border-t border-slate-100">
                                        <span class="text-slate-400"><i class="fa-regular fa-clock mr-1"></i> <?= $t['due_date'] ? date('M j', strtotime($t['due_date'])) : '-' ?></span>
                                        
                                        <!-- Quick Status Change Dropdown -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="text-indigo-600 hover:bg-indigo-50 p-1 rounded transition-colors">
                                                <i class="fa-solid fa-ellipsis-vertical"></i> Move
                                            </button>
                                            <div x-show="open" style="display:none;" class="absolute right-0 bottom-full mb-1 w-40 bg-white border border-slate-200 shadow-lg rounded-xl z-10 overflow-hidden text-left">
                                                <?php foreach(['To Do', 'In Progress', 'In Review', 'Completed'] as $st): ?>
                                                    <?php if($st !== $colStatus): ?>
                                                        <a href="<?= url('/admin/project-management/task-status/'.$project['id'].'/'.$t['id'].'?status='.urlencode($st).'&notify_client=1') ?>" class="block px-4 py-2 hover:bg-slate-50 text-slate-700"><?= $st ?></a>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <?php if (count(array_filter($tasks, fn($t) => $t['status'] === $colStatus)) === 0): ?>
                            <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center text-sm text-slate-400">
                                No tasks
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- TAB: OVERVIEW -->
    <div x-show="activeTab === 'overview'" style="display: none;" class="animate-fade-in-up">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Project Overview</h2>
            
            <div class="prose max-w-none text-slate-600 mb-8">
                <?= nl2br(e($project['description'] ?: 'No description provided.')) ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-100">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Dates & Financials</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between"><span class="text-slate-500">Start Date:</span> <span class="font-medium text-slate-900"><?= $project['start_date'] ? date('M j, Y', strtotime($project['start_date'])) : '-' ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-500">Due Date:</span> <span class="font-medium text-slate-900"><?= $project['due_date'] ? date('M j, Y', strtotime($project['due_date'])) : '-' ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-500">Estimated Budget:</span> <span class="font-medium text-slate-900">₦<?= number_format($project['budget'], 2) ?></span></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Client Details</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between"><span class="text-slate-500">Name:</span> <span class="font-medium text-slate-900"><?= $project['customer_name'] ?: 'Internal' ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-500">Email:</span> <span class="font-medium text-slate-900"><?= $project['customer_email'] ?: '-' ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: TIME LOGS -->
    <div x-show="activeTab === 'time'" style="display: none;" class="animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Time Tracking</h2>
            <button @click="showTimeModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-stopwatch mr-1"></i> Log Time
            </button>
        </div>
        
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold">Date</th>
                        <th class="p-4 font-semibold">Member</th>
                        <th class="p-4 font-semibold">Task</th>
                        <th class="p-4 font-semibold">Hours</th>
                        <th class="p-4 font-semibold">Notes</th>
                        <th class="p-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($timeLogs as $log): ?>
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-4 text-sm text-slate-900"><?= date('M j, Y', strtotime($log['date_logged'])) ?></td>
                            <td class="p-4 text-sm text-slate-600"><?= e($log['user_name']) ?></td>
                            <td class="p-4 text-sm text-slate-600"><?= $log['task_title'] ? e($log['task_title']) : '<i class="text-slate-400">General Project</i>' ?></td>
                            <td class="p-4 text-sm font-bold text-indigo-600"><?= number_format($log['hours'], 2) ?></td>
                            <td class="p-4 text-sm text-slate-500 max-w-xs truncate" title="<?= e($log['notes']) ?>"><?= e($log['notes'] ?: '-') ?></td>
                            <td class="p-4 text-right">
                                <a href="<?= url('/admin/project-management/time-delete/'.$project['id'].'/'.$log['id']) ?>" onclick="return confirm('Delete this time log?')" class="text-slate-400 hover:text-rose-600 p-2">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($timeLogs)): ?>
                        <tr><td colspan="6" class="p-8 text-center text-slate-500">No time logged yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB: FILES -->
    <div x-show="activeTab === 'files'" style="display: none;" class="animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Project Attachments</h2>
            <button @click="showFileModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Upload File
            </button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach($files as $f): ?>
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-start gap-4 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 text-xl">
                        <i class="fa-regular fa-file"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="<?= url($f['file_path']) ?>" target="_blank" class="text-sm font-bold text-slate-800 hover:text-indigo-600 line-clamp-1 block mb-0.5 transition-colors">
                            <?= e($f['file_name']) ?>
                        </a>
                        <p class="text-xs text-slate-500"><?= round($f['file_size'] / 1024, 1) ?> KB &bull; <?= date('M j', strtotime($f['created_at'])) ?></p>
                    </div>
                    <a href="<?= url('/admin/project-management/file-delete/'.$project['id'].'/'.$f['id']) ?>" onclick="return confirm('Delete this file?')" class="text-slate-300 hover:text-rose-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            <?php endforeach; ?>
            <?php if(empty($files)): ?>
                <div class="col-span-full border-2 border-dashed border-slate-200 rounded-2xl p-12 text-center text-slate-500">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                    <p>No files uploaded yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- TAB: INVOICES -->
    <div x-show="activeTab === 'invoices'" style="display: none;" class="animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Linked Invoices</h2>
            <a href="<?= url('/admin/billing/create') ?>" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> New Invoice
            </a>
        </div>
        
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold">Invoice #</th>
                        <th class="p-4 font-semibold">Date</th>
                        <th class="p-4 font-semibold">Total</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">View</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($invoices as $inv): ?>
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-4 font-bold text-slate-900">#<?= $inv['invoice_number'] ?></td>
                            <td class="p-4 text-sm text-slate-600"><?= date('M j, Y', strtotime($inv['issue_date'])) ?></td>
                            <td class="p-4 text-sm font-bold text-slate-900">₦<?= number_format($inv['total_amount'], 2) ?></td>
                            <td class="p-4">
                                <?php if($inv['status'] === 'Paid'): ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Paid</span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 text-right">
                                <a href="<?= url('/admin/billing/edit/'.$inv['id']) ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Open <i class="fa-solid fa-arrow-right text-xs ml-1"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($invoices)): ?>
                        <tr><td colspan="5" class="p-8 text-center text-slate-500">No invoices linked to this project. Create an invoice and select this client/project.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- MODALS -->

    <!-- Task Modal -->
    <div x-show="showTaskModal" style="display:none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showTaskModal" @click="showTaskModal = false" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" aria-hidden="true"></div>
            <div x-show="showTaskModal" class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-slate-900" x-text="editTaskData ? 'Edit Task' : 'New Task'"></h3>
                    <button @click="showTaskModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                
                <form :action="editTaskData ? '<?= url('/admin/project-management/task/'.$project['id'].'/') ?>' + editTaskData.id : '<?= url('/admin/project-management/task/'.$project['id']) ?>'" method="POST" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" x-model="editTaskData ? editTaskData.title : ''" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none">
                                <template x-for="st in ['To Do', 'In Progress', 'In Review', 'Completed']">
                                    <option :value="st" x-text="st" :selected="editTaskData && editTaskData.status === st"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Priority</label>
                            <select name="priority" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none">
                                <template x-for="p in ['Low', 'Medium', 'High', 'Urgent']">
                                    <option :value="p" x-text="p" :selected="editTaskData && editTaskData.priority === p"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" :value="editTaskData ? editTaskData.due_date : ''" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="3" x-model="editTaskData ? editTaskData.description : ''" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none"></textarea>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showTaskModal = false" class="px-4 py-2 font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Time Log Modal -->
    <div x-show="showTimeModal" style="display:none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showTimeModal" @click="showTimeModal = false" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showTimeModal" class="relative inline-block w-full max-w-sm p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-slate-900">Log Time</h3>
                    <button @click="showTimeModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form action="<?= url('/admin/project-management/time/'.$project['id']) ?>" method="POST" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Date</label>
                        <input type="date" name="date_logged" value="<?= date('Y-m-d') ?>" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Hours</label>
                        <input type="number" step="0.25" min="0.25" name="hours" required placeholder="2.5" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Task (Optional)</label>
                        <select name="task_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none">
                            <option value="">-- General Project Work --</option>
                            <?php foreach($tasks as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= e($t['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Notes</label>
                        <input type="text" name="notes" placeholder="What did you work on?" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm">Save Time</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- File Upload Modal -->
    <div x-show="showFileModal" style="display:none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showFileModal" @click="showFileModal = false" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showFileModal" class="relative inline-block w-full max-w-sm p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-slate-900">Upload File</h3>
                    <button @click="showFileModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <form action="<?= url('/admin/project-management/file/'.$project['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    
                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center bg-slate-50 hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-300 mb-3"></i>
                        <div class="text-sm text-slate-600 mb-1">Select a file to upload</div>
                        <input type="file" name="document" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-2">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm">Upload to Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
