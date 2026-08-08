<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * ISEC Front Controller Entry Point
 */

// 1. Define Core Path (Handles cPanel 'isec_app' vs Local XAMPP structure)
$corePath = is_dir(__DIR__ . '/../isec_app') ? __DIR__ . '/../isec_app' : dirname(__DIR__);

// 2. Load Autoloader & Helpers
require_once $corePath . '/vendor/autoload.php';
require_once $corePath . '/app/config/config.php';
require_once $corePath . '/app/Helpers/helpers.php';

use App\Core\App;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminOnlyMiddleware;
use App\Middleware\CSRFMiddleware;

// 3. Initialize Application
$app = new App($corePath);

// 3. Define Routes
$router = $app->router;

// --- Frontend Routes ---
$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/about', [\App\Controllers\HomeController::class, 'about']);
$router->get('/privacy', [\App\Controllers\HomeController::class, 'privacy']);
$router->get('/terms', [\App\Controllers\HomeController::class, 'terms']);
$router->get('/verify-certificate', [\App\Controllers\HomeController::class, 'verifyCertificate']);
$router->get('/services', [\App\Controllers\ServicesController::class, 'index']);
$router->get('/services/{slug}', [\App\Controllers\ServicesController::class, 'show']);
$router->get('/projects', [\App\Controllers\ProjectsController::class, 'index']);
$router->get('/projects/{slug}', [\App\Controllers\ProjectsController::class, 'show']);
$router->get('/insights', [\App\Controllers\HomeController::class, 'insights']);
$router->get('/insights/{slug}', [\App\Controllers\HomeController::class, 'insightDetail']);
$router->get('/careers', [\App\Controllers\HomeController::class, 'careers']);
$router->get('/careers/{id}', [\App\Controllers\HomeController::class, 'jobDetail']);
$router->post('/careers/{id}/apply', [\App\Controllers\HomeController::class, 'apply'], [CSRFMiddleware::class]);
$router->get('/gallery', [\App\Controllers\HomeController::class, 'gallery']);
$router->get('/downloads', [\App\Controllers\HomeController::class, 'downloads']);
$router->get('/downloads/track/{id}', [\App\Controllers\HomeController::class, 'downloadTrack']);
$router->get('/contact', [\App\Controllers\HomeController::class, 'contact']);
$router->post('/contact', [\App\Controllers\HomeController::class, 'contactSubmit'], [CSRFMiddleware::class]);
$router->post('/newsletter', [\App\Controllers\HomeController::class, 'newsletterSubmit'], [CSRFMiddleware::class]);
$router->get('/page/{slug}', [\App\Controllers\HomeController::class, 'dynamicPage']);

// --- Authentication Routes ---
$router->get('/admin/login', [\App\Controllers\AuthController::class, 'login']);
$router->post('/admin/login', [\App\Controllers\AuthController::class, 'authenticate']);
$router->get('/admin/logout', [\App\Controllers\AuthController::class, 'logout']);

// --- Admin Panel CMS Routes ---
$router->get('/admin', [\App\Controllers\AdminController::class, 'index'], [AuthMiddleware::class]);

// Admin Services CRUD
$router->get('/admin/services', [\App\Controllers\AdminController::class, 'services'], [AuthMiddleware::class]);
$router->get('/admin/services/create', [\App\Controllers\AdminController::class, 'serviceCreate'], [AuthMiddleware::class]);
$router->post('/admin/services/create', [\App\Controllers\AdminController::class, 'serviceStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/services/edit/{id}', [\App\Controllers\AdminController::class, 'serviceEdit'], [AuthMiddleware::class]);
$router->post('/admin/services/edit/{id}', [\App\Controllers\AdminController::class, 'serviceUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/services/delete/{id}', [\App\Controllers\AdminController::class, 'serviceDelete'], [AuthMiddleware::class]);

// Admin Projects CRUD
$router->get('/admin/projects', [\App\Controllers\AdminController::class, 'projects'], [AuthMiddleware::class]);
$router->get('/admin/projects/create', [\App\Controllers\AdminController::class, 'projectCreate'], [AuthMiddleware::class]);
$router->post('/admin/projects/create', [\App\Controllers\AdminController::class, 'projectStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/projects/edit/{id}', [\App\Controllers\AdminController::class, 'projectEdit'], [AuthMiddleware::class]);
$router->post('/admin/projects/edit/{id}', [\App\Controllers\AdminController::class, 'projectUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/projects/delete/{id}', [\App\Controllers\AdminController::class, 'projectDelete'], [AuthMiddleware::class]);

// Admin Insights CRUD
$router->get('/admin/insights', [\App\Controllers\AdminController::class, 'insights'], [AuthMiddleware::class]);
$router->get('/admin/insights/create', [\App\Controllers\AdminController::class, 'insightCreate'], [AuthMiddleware::class]);
$router->post('/admin/insights/create', [\App\Controllers\AdminController::class, 'insightStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/insights/edit/{id}', [\App\Controllers\AdminController::class, 'insightEdit'], [AuthMiddleware::class]);
$router->post('/admin/insights/edit/{id}', [\App\Controllers\AdminController::class, 'insightUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/insights/delete/{id}', [\App\Controllers\AdminController::class, 'insightDelete'], [AuthMiddleware::class]);

// Admin Careers CRUD
$router->get('/admin/careers', [\App\Controllers\AdminController::class, 'careers'], [AuthMiddleware::class]);
$router->get('/admin/careers/create', [\App\Controllers\AdminController::class, 'careerCreate'], [AuthMiddleware::class]);
$router->post('/admin/careers/create', [\App\Controllers\AdminController::class, 'careerStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/careers/edit/{id}', [\App\Controllers\AdminController::class, 'careerEdit'], [AuthMiddleware::class]);
$router->post('/admin/careers/edit/{id}', [\App\Controllers\AdminController::class, 'careerUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/careers/delete/{id}', [\App\Controllers\AdminController::class, 'careerDelete'], [AuthMiddleware::class]);
$router->get('/admin/careers/applications', [\App\Controllers\AdminController::class, 'careerApplications'], [AuthMiddleware::class]);

// Admin Messages
$router->get('/admin/messages', [\App\Controllers\AdminController::class, 'messages'], [AuthMiddleware::class]);
$router->get('/admin/messages/view/{id}', [\App\Controllers\AdminController::class, 'messageView'], [AuthMiddleware::class]);
$router->get('/admin/messages/delete/{id}', [\App\Controllers\AdminController::class, 'messageDelete'], [AuthMiddleware::class]);

// Admin Webmail & Newsletter Center
$router->get('/admin/mail', [\App\Controllers\AdminController::class, 'mailInbox'], [AuthMiddleware::class]);
$router->post('/admin/mail/compose', [\App\Controllers\AdminController::class, 'mailCompose'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->post('/admin/mail/bulk', [\App\Controllers\AdminController::class, 'mailBulk'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->post('/admin/mail/settings', [\App\Controllers\AdminController::class, 'mailSettingsUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);

// Admin Certificates CRUD
$router->get('/admin/certificates', [\App\Controllers\AdminController::class, 'certificates'], [AuthMiddleware::class]);
$router->get('/admin/certificates/create', [\App\Controllers\AdminController::class, 'certificateCreate'], [AuthMiddleware::class]);
$router->post('/admin/certificates/create', [\App\Controllers\AdminController::class, 'certificateStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/certificates/edit/{id}', [\App\Controllers\AdminController::class, 'certificateEdit'], [AuthMiddleware::class]);
$router->post('/admin/certificates/edit/{id}', [\App\Controllers\AdminController::class, 'certificateUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/certificates/delete/{id}', [\App\Controllers\AdminController::class, 'certificateDelete'], [AuthMiddleware::class]);

// Admin CMS Dynamic Page Editor
$router->get('/admin/cms-pages', [\App\Controllers\AdminController::class, 'cmsPages'], [AuthMiddleware::class]);
$router->post('/admin/cms-pages', [\App\Controllers\AdminController::class, 'cmsPagesUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);

// Admin Dynamic Pages CRUD
$router->get('/admin/dynamic-pages', [\App\Controllers\AdminController::class, 'dynamicPages'], [AuthMiddleware::class]);
$router->get('/admin/dynamic-pages/create', [\App\Controllers\AdminController::class, 'dynamicPageCreate'], [AuthMiddleware::class]);
$router->post('/admin/dynamic-pages/store', [\App\Controllers\AdminController::class, 'dynamicPageStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/dynamic-pages/edit/{id}', [\App\Controllers\AdminController::class, 'dynamicPageEdit'], [AuthMiddleware::class]);
$router->post('/admin/dynamic-pages/update/{id}', [\App\Controllers\AdminController::class, 'dynamicPageUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/dynamic-pages/delete/{id}', [\App\Controllers\AdminController::class, 'dynamicPageDelete'], [AuthMiddleware::class]);

// Admin Leadership Team CRUD
$router->get('/admin/team', [\App\Controllers\AdminController::class, 'team'], [AuthMiddleware::class]);
$router->get('/admin/team/create', [\App\Controllers\AdminController::class, 'teamCreate'], [AuthMiddleware::class]);
$router->post('/admin/team/create', [\App\Controllers\AdminController::class, 'teamStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/team/edit/{id}', [\App\Controllers\AdminController::class, 'teamEdit'], [AuthMiddleware::class]);
$router->post('/admin/team/edit/{id}', [\App\Controllers\AdminController::class, 'teamUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/team/delete/{id}', [\App\Controllers\AdminController::class, 'teamDelete'], [AuthMiddleware::class]);

// Admin User Management CRUD
$router->get('/admin/users', [\App\Controllers\AdminController::class, 'users'], [AuthMiddleware::class]);
$router->get('/admin/users/create', [\App\Controllers\AdminController::class, 'userCreate'], [AuthMiddleware::class]);
$router->post('/admin/users/create', [\App\Controllers\AdminController::class, 'userStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/users/edit/{id}', [\App\Controllers\AdminController::class, 'userEdit'], [AuthMiddleware::class]);
$router->post('/admin/users/edit/{id}', [\App\Controllers\AdminController::class, 'userUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/users/delete/{id}', [\App\Controllers\AdminController::class, 'userDelete'], [AuthMiddleware::class]);

// Admin Audit Logs & Settings
$router->get('/admin/settings', [\App\Controllers\AdminController::class, 'settings'], [AuthMiddleware::class]);
$router->post('/admin/settings', [\App\Controllers\AdminController::class, 'settingsUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/logs', [\App\Controllers\AdminController::class, 'logs'], [AuthMiddleware::class, AdminOnlyMiddleware::class]);

// 4. Run Application
$app->run();
