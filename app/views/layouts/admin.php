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
    </style>
</head>
<body class="bg-slate-100 text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-20 flex flex-col w-64 bg-slate-900 text-slate-400 border-r border-slate-800 transition-transform duration-300 transform md:translate-x-0 md:static md:inset-auto" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Branding -->
            <div class="flex items-center justify-between h-20 px-6 bg-slate-950 border-b border-slate-850">
                <a href="<?= url('/admin') ?>" class="flex items-center bg-white px-3 py-1.5 rounded-xl shadow-sm hover:opacity-90 transition-all">
                    <img src="<?= asset('images/logo.png') ?>?v=5" alt="ISEC Logo" class="h-7 w-auto object-contain" />
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <!-- Navigation links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <a href="<?= url('/admin') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : '' ?>">
                    <i class="fa-solid fa-chart-line text-base"></i> Dashboard
                </a>
                
                <?php if (has_permission('manage_services')): ?>
                    <a href="<?= url('/admin/services') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/services') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-laptop-code text-base"></i> Services CRUD
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_projects')): ?>
                    <a href="<?= url('/admin/projects') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/projects') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-briefcase text-base"></i> Case Studies
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_blogs')): ?>
                    <a href="<?= url('/admin/insights') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/insights') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-newspaper text-base"></i> Insights & Blogs
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_careers')): ?>
                    <a href="<?= url('/admin/careers') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/careers' || $currentPath === '/admin/careers/create' || strpos($currentPath, '/admin/careers/edit') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-user-tie text-base"></i> Careers Vacancies
                    </a>
                    <a href="<?= url('/admin/careers/applications') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/careers/applications' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-file-import text-base"></i> Job Applications
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_messages')): ?>
                    <a href="<?= url('/admin/messages') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/messages') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-envelope-open-text text-base"></i> Message Inbox
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_messages')): ?>
                    <a href="<?= url('/admin/mail') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/mail') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-envelope-open text-base"></i> Webmail & Broadcast
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_settings')): ?>
                    <a href="<?= url('/admin/certificates') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/certificates') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-award text-base"></i> Certificates Manager
                    </a>
                    <a href="<?= url('/admin/cms-pages') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/cms-pages' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-file-pen text-base"></i> Pages Content CMS
                    </a>
                    <a href="<?= url('/admin/team') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/team') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-people-group text-base"></i> Leadership Board
                    </a>
                    <a href="<?= url('/admin/settings') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/settings' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-gears text-base"></i> Dynamic Settings
                    </a>
                <?php endif; ?>

                <?php if (has_permission('manage_users')): ?>
                    <a href="<?= url('/admin/users') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= strpos($currentPath, '/admin/users') === 0 ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-users-gear text-base"></i> User Management
                    </a>
                <?php endif; ?>

                <?php if ($user['role_name'] === 'Admin'): ?>
                    <a href="<?= url('/admin/logs') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all <?= $currentPath === '/admin/logs' ? 'bg-indigo-600 text-white shadow-md' : '' ?>">
                        <i class="fa-solid fa-shield-halved text-base"></i> Audit Trail Logs
                    </a>
                <?php endif; ?>
            </nav>
            
            <!-- User summary panel -->
            <div class="p-4 bg-slate-950 border-t border-slate-850 space-y-3">
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
                    <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-6 text-sm font-semibold flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                        <span><?= e($flashSuccess) ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($flashError): ?>
                    <div class="bg-rose-100 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl mb-6 text-sm font-semibold flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-base text-rose-500"></i>
                        <span><?= e($flashError) ?></span>
                    </div>
                <?php endif; ?>

                {{content}}
            </main>
        </div>
        
    <!-- Source Protection: Disable right-click & key combinations for DevTools/View Source -->
    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (
                e.key === 'F12' ||
                ((e.ctrlKey || e.metaKey) && (
                    e.key.toLowerCase() === 'u' ||
                    e.key.toLowerCase() === 's'
                )) ||
                ((e.ctrlKey || e.metaKey) && e.shiftKey && (
                    e.key.toLowerCase() === 'i' ||
                    e.key.toLowerCase() === 'c' ||
                    e.key.toLowerCase() === 'j'
                ))
            ) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
