<div class="px-6 py-8 md:py-10 max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-8 flex items-center gap-4">
        <a href="<?= url('/admin/project-management') ?>" class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center hover:bg-slate-300 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight"><?= htmlspecialchars($title) ?></h1>
            <p class="text-slate-500 mt-1"><?= isset($project) ? 'Update project details and settings' : 'Start tracking a new project' ?></p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="<?= url(isset($project) ? '/admin/project-management/update/' . $project['id'] : '/admin/project-management/store') ?>" method="POST" class="p-6 md:p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Project Name -->
                <div class="col-span-full">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Project Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="<?= isset($project) ? e($project['name']) : '' ?>" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white" 
                        placeholder="e.g., Website Redesign Q3">
                </div>
                
                <!-- Customer -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Client / Customer (Optional)</label>
                    <select name="customer_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white">
                        <option value="">-- Internal Project (No Client) --</option>
                        <?php foreach($customers as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= (isset($project) && $project['customer_id'] == $c['id']) ? 'selected' : '' ?>>
                                <?= e($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white">
                        <option value="Not Started" <?= (isset($project) && $project['status'] === 'Not Started') ? 'selected' : '' ?>>Not Started</option>
                        <option value="In Progress" <?= (isset($project) && $project['status'] === 'In Progress') ? 'selected' : '' ?>>In Progress</option>
                        <option value="On Hold" <?= (isset($project) && $project['status'] === 'On Hold') ? 'selected' : '' ?>>On Hold</option>
                        <option value="Completed" <?= (isset($project) && $project['status'] === 'Completed') ? 'selected' : '' ?>>Completed</option>
                        <option value="Cancelled" <?= (isset($project) && $project['status'] === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Start Date</label>
                    <input type="date" name="start_date" value="<?= isset($project) && $project['start_date'] ? $project['start_date'] : '' ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white">
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Due Date</label>
                    <input type="date" name="due_date" value="<?= isset($project) && $project['due_date'] ? $project['due_date'] : '' ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white">
                </div>

                <!-- Budget -->
                <div class="col-span-full">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Estimated Budget / Value (₦)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-semibold">₦</span>
                        <input type="number" step="0.01" min="0" name="budget" value="<?= isset($project) ? $project['budget'] : '0.00' ?>"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white" 
                            placeholder="0.00">
                    </div>
                </div>

                <!-- Description -->
                <div class="col-span-full">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Project Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white" 
                        placeholder="Detailed project requirements..."><?= isset($project) ? e($project['description']) : '' ?></textarea>
                </div>
                
            </div>
            
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="<?= url(isset($project) ? '/admin/project-management/view/'.$project['id'] : '/admin/project-management') ?>" class="px-5 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> <?= isset($project) ? 'Save Changes' : 'Create Project' ?>
                </button>
            </div>
        </form>
    </div>
</div>
