<?php
use App\Models\Settings;
use App\Core\Session;

$shortName = Settings::get('site_short_name', 'ISEC');
$user = current_user();

if (!$user) {
    $response = new App\Core\Response();
    $response->redirect('/admin/login');
}

$session = new Session();
$flashSuccess = $session->getFlash('success');
$flashError = $session->getFlash('error');

// Get current path to highlight active sidebar item
$request = new App\Core\Request();
$currentPath = $request->getPath();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'ISEC Control Center') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/favicon.png') ?>?v=2">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js for Admin Dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3 {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #334155;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-20 flex flex-col w-64 bg-slate-900 text-slate-400 border-r border-slate-800 transition-transform duration-300 transform md:translate-x-0 md:static md:inset-auto" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Branding -->
            <div class="flex items-center justify-between h-20 px-6 bg-slate-950 border-b border-slate-850 flex-shrink-0">
                <a href="<?= url('/admin') ?>" class="flex items-center bg-white px-3 py-1.5 rounded-xl shadow-sm hover:opacity-90 transition-all">
                    <img src="<?= asset('images/logo.png') ?>?v=5" alt="ISEC Logo" class="h-7 w-auto object-contain" />
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <!-- Navigation links -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto sidebar-scroll">
                
                <!-- MAIN -->
                <?php $isMainOpen = in_array($currentPath, ['/admin']) || strpos($currentPath, '/admin/messages') === 0 || strpos($currentPath, '/admin/mail') === 0; ?>
                <div x-data="{ open: <?= $isMainOpen ? 'true' : 'false' ?> }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 mt-2 mb-2 text-[10px] font-black text-slate-500 tracking-widest uppercase hover:text-slate-300 transition-colors focus:outline-none">
                        <span>Main</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse>
                        <a href="<?= url('/admin') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : '' ?>">
                            <i class="fa-solid fa-chart-line w-5 text-center"></i> Dashboard
                        </a>
                        
                        <?php if (has_permission('manage_messages')): ?>
                            <a href="<?= url('/admin/messages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/messages') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-envelope-open-text w-5 text-center"></i> Message Inbox
                            </a>
                            <a href="<?= url('/admin/mail') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/mail') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-paper-plane w-5 text-center"></i> Webmail & Broadcast
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CRM, FINANCE & PROJECTS -->
                <?php $isCrmOpen = strpos($currentPath, '/admin/crm') === 0 || strpos($currentPath, '/admin/subscriptions') === 0 || strpos($currentPath, '/admin/project-management') === 0 || strpos($currentPath, '/admin/templates') === 0 || strpos($currentPath, '/admin/billing') === 0 || strpos($currentPath, '/admin/accounting') === 0; ?>
                <div x-data="{ open: <?= $isCrmOpen ? 'true' : 'false' ?> }" class="mt-4">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 mb-2 text-[10px] font-black text-slate-500 tracking-widest uppercase hover:text-slate-300 transition-colors focus:outline-none">
                        <span>CRM & Operations</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse>
                        <?php if ($user['role_name'] === 'Admin'): ?>
                            <a href="<?= url('/admin/crm') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/crm') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-users w-5 text-center"></i> CRM & Marketing
                            </a>
                            <a href="<?= url('/admin/subscriptions') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/subscriptions') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-rotate w-5 text-center"></i> Subscriptions
                            </a>
                        <?php endif; ?>
                        
                        <?php if (has_permission('manage_invoices')): ?>
                            <a href="<?= url('/admin/project-management') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/project-management') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-diagram-project w-5 text-center"></i> Projects Workspace
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_messages')): ?>
                            <a href="<?= url('/admin/templates') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/templates') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-code w-5 text-center"></i> Message Templates
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_settings')): // Note: adjust to specific permission if needed later ?>
                            <a href="<?= url('/admin/billing') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/billing') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Billing & Invoices
                            </a>
                            <a href="<?= url('/admin/accounting') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/accounting') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-calculator w-5 text-center"></i> Finance & Accounting
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CONTENT MANAGEMENT -->
                <?php $isContentOpen = strpos($currentPath, '/admin/services') === 0 || strpos($currentPath, '/admin/projects') === 0 || strpos($currentPath, '/admin/insights') === 0 || strpos($currentPath, '/admin/careers') === 0 || strpos($currentPath, '/admin/certificates') === 0 || strpos($currentPath, '/admin/team') === 0 || strpos($currentPath, '/admin/cms-pages') === 0 || strpos($currentPath, '/admin/dynamic-pages') === 0; ?>
                <div x-data="{ open: <?= $isContentOpen ? 'true' : 'false' ?> }" class="mt-4">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 mb-2 text-[10px] font-black text-slate-500 tracking-widest uppercase hover:text-slate-300 transition-colors focus:outline-none">
                        <span>Website Content</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse>
                        <?php if (has_permission('manage_services')): ?>
                            <a href="<?= url('/admin/services') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/services') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-laptop-code w-5 text-center"></i> Services
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_projects')): ?>
                            <a href="<?= url('/admin/projects') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/projects') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-briefcase w-5 text-center"></i> Portfolio & Cases
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_blogs')): ?>
                            <a href="<?= url('/admin/insights') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/insights') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-newspaper w-5 text-center"></i> Insights Blog
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_careers')): ?>
                            <a href="<?= url('/admin/careers') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/careers' || $currentPath === '/admin/careers/create' || strpos($currentPath, '/admin/careers/edit') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-user-tie w-5 text-center"></i> Careers Vacancies
                            </a>
                            <a href="<?= url('/admin/careers/applications') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/careers/applications' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-file-import w-5 text-center"></i> Job Applications
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_settings')): ?>
                            <a href="<?= url('/admin/certificates') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/certificates') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-award w-5 text-center"></i> Certificates
                            </a>
                            <a href="<?= url('/admin/team') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/team') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-people-group w-5 text-center"></i> Leadership Team
                            </a>
                            <a href="<?= url('/admin/cms-pages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/cms-pages' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-file-lines w-5 text-center"></i> Static Text Blocks
                            </a>
                            <a href="<?= url('/admin/dynamic-pages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/dynamic-pages') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-layer-group w-5 text-center"></i> Dynamic Pages
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- SYSTEM ADMINISTRATION -->
                <?php $isAdminOpen = strpos($currentPath, '/admin/users') === 0 || strpos($currentPath, '/admin/roles') === 0 || strpos($currentPath, '/admin/settings') === 0 || strpos($currentPath, '/admin/system-logs') === 0; ?>
                <div x-data="{ open: <?= $isAdminOpen ? 'true' : 'false' ?> }" class="mt-4 mb-4">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 mb-2 text-[10px] font-black text-slate-500 tracking-widest uppercase hover:text-slate-300 transition-colors focus:outline-none">
                        <span>System Admin</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse>
                        <?php if (has_permission('manage_users')): ?>
                            <a href="<?= url('/admin/users') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/users') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-users-gear w-5 text-center"></i> Manage Users
                            </a>
                        <?php endif; ?>

                        <?php if (has_permission('manage_settings')): ?>
                            <a href="<?= url('/admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/settings' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-gears w-5 text-center"></i> System Settings
                            </a>
                        <?php endif; ?>

                        <?php if ($user['role_name'] === 'Admin'): ?>
                            <a href="<?= url('/admin/logs') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/logs' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                                <i class="fa-solid fa-shield-halved w-5 text-center"></i> Audit Trail Logs
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
            
            <!-- User summary panel -->
            <div class="p-4 bg-slate-950 border-t border-slate-850 space-y-3 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white font-bold border border-slate-700">
                        <?= substr($user['name'], 0, 1) ?>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-xs font-bold text-white truncate"><?= e($user['name']) ?></span>
                        <span class="text-[10px] text-slate-500 font-medium tracking-wider uppercase"><?= e($user['role_name']) ?></span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="<?= url('/') ?>" target="_blank" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white text-center py-2 rounded-lg text-xs font-semibold"><i class="fa-solid fa-globe"></i> View Site</a>
                    <a href="<?= url('/admin/logout') ?>" class="flex-1 bg-rose-600/20 hover:bg-rose-600 text-rose-300 hover:text-white text-center py-2 rounded-lg text-xs font-semibold"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </aside>

        <!-- Main Body -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header bar -->
            <header class="flex items-center justify-between h-20 px-6 bg-white border-b border-slate-200">
                <button @click="sidebarOpen = true" class="md:hidden text-slate-600">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div class="hidden sm:block text-sm font-semibold text-slate-500 dark:text-slate-400">
                    <span class="text-indigo-600">Secure CRM</span> &bull; Welcome back
                </div>
                <div class="flex items-center gap-3">
                    <!-- Display date -->
                    <span class="text-xs font-medium text-slate-400 hidden lg:inline"><i class="fa-regular fa-calendar-days mr-1"></i> <?= date('F d, Y') ?></span>
                </div>
            </header>
            
            <!-- Dynamic view content -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                <!-- Notifications -->
                <?php if ($flashSuccess): ?>
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 animate-fade-in-up">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                        <span class="font-medium text-sm"><?= e($flashSuccess) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($flashError): ?>
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center gap-3 animate-fade-in-up">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500 text-lg"></i>
                        <span class="font-medium text-sm"><?= e($flashError) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Inject View -->
                {{content}}
            </main>
        </div>
    </div>
</body>
</html>
