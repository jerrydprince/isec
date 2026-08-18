<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo "<div style='color:red; padding:20px; font-family:sans-serif; background:#fff; border:2px solid red; margin:20px;'>";
        echo "<h2>Fatal Error Caught</h2>";
        echo "<strong>Message:</strong> " . htmlspecialchars($error['message']) . "<br>";
        echo "<strong>File:</strong> " . htmlspecialchars($error['file']) . " on line " . $error['line'];
        echo "</div>";
    }
});

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

// Payment Routes
$router->get('/payment/verify', [\App\Controllers\PaymentController::class, 'verify']);
$router->get('/payment/thank-you', [\App\Controllers\PaymentController::class, 'thankYou']);
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
$router->get('/admin/insights/categories', [\App\Controllers\AdminController::class, 'insightCategories'], [AuthMiddleware::class]);
$router->post('/admin/insights/categories/create', [\App\Controllers\AdminController::class, 'insightCategoryStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/insights/categories/delete/{id}', [\App\Controllers\AdminController::class, 'insightCategoryDelete'], [AuthMiddleware::class]);
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

// Message Templates CRUD
$router->get('/admin/templates', [\App\Controllers\TemplateController::class, 'index'], [AuthMiddleware::class]);
$router->get('/admin/templates/create', [\App\Controllers\TemplateController::class, 'create'], [AuthMiddleware::class]);
$router->post('/admin/templates/create', [\App\Controllers\TemplateController::class, 'store'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/templates/{id}/edit', [\App\Controllers\TemplateController::class, 'edit'], [AuthMiddleware::class]);
$router->post('/admin/templates/{id}/edit', [\App\Controllers\TemplateController::class, 'update'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->post('/admin/templates/{id}/delete', [\App\Controllers\TemplateController::class, 'delete'], [AuthMiddleware::class, CSRFMiddleware::class]);

// Admin Certificates CRUD
$router->get('/admin/certificates', [\App\Controllers\AdminController::class, 'certificates'], [AuthMiddleware::class]);
$router->get('/admin/certificates/create', [\App\Controllers\AdminController::class, 'certificateCreate'], [AuthMiddleware::class]);
$router->post('/admin/certificates/create', [\App\Controllers\AdminController::class, 'certificateStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/certificates/edit/{id}', [\App\Controllers\AdminController::class, 'certificateEdit'], [AuthMiddleware::class]);
$router->post('/admin/certificates/edit/{id}', [\App\Controllers\AdminController::class, 'certificateUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/certificates/delete/{id}', [\App\Controllers\AdminController::class, 'certificateDelete'], [AuthMiddleware::class]);

// Billing & Invoices
$router->get('/admin/billing', [\App\Controllers\BillingController::class, 'index'], [AuthMiddleware::class]);
$router->get('/admin/billing/create', [\App\Controllers\BillingController::class, 'create'], [AuthMiddleware::class]);
$router->post('/admin/billing/create', [\App\Controllers\BillingController::class, 'store'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/billing/edit/{id}', [\App\Controllers\BillingController::class, 'edit'], [AuthMiddleware::class]);
$router->post('/admin/billing/edit/{id}', [\App\Controllers\BillingController::class, 'update'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/billing/delete/{id}', [\App\Controllers\BillingController::class, 'delete'], [AuthMiddleware::class]);
$router->get('/admin/billing/mark-paid/{id}', [\App\Controllers\BillingController::class, 'markPaid'], [AuthMiddleware::class]);
$router->post('/admin/billing/payment/{id}', [\App\Controllers\BillingController::class, 'addPayment'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/billing/send-email/{id}', [\App\Controllers\BillingController::class, 'sendEmail'], [AuthMiddleware::class]);

// Public View for Invoices and Receipts (no auth required so clients can view them via email link)
$router->get('/billing/view/{id}', [\App\Controllers\BillingController::class, 'viewInvoice']);
$router->get('/billing/receipt/{id}', [\App\Controllers\BillingController::class, 'viewReceipt']);
$router->get('/billing/payment/verify', [\App\Controllers\BillingController::class, 'verifyOnlinePayment']);

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

// DB Setup Route
$router->get('/admin/setup-db', [\App\Controllers\AdminController::class, 'setupDb'], [AuthMiddleware::class]);
$router->get('/admin/logs', [\App\Controllers\AdminController::class, 'logs'], [AuthMiddleware::class, AdminOnlyMiddleware::class]);

// --- PROJECT MANAGEMENT ---
$router->get('/admin/project-management', [\App\Controllers\ProjectController::class, 'index'], [AuthMiddleware::class]);
$router->get('/admin/project-management/create', [\App\Controllers\ProjectController::class, 'create'], [AuthMiddleware::class]);
$router->post('/admin/project-management/store', [\App\Controllers\ProjectController::class, 'store'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/project-management/view/{id}', [\App\Controllers\ProjectController::class, 'view'], [AuthMiddleware::class]);
$router->get('/admin/project-management/edit/{id}', [\App\Controllers\ProjectController::class, 'edit'], [AuthMiddleware::class]);
$router->post('/admin/project-management/update/{id}', [\App\Controllers\ProjectController::class, 'update'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/project-management/delete/{id}', [\App\Controllers\ProjectController::class, 'delete'], [AuthMiddleware::class]);

// Project Tasks
$router->post('/admin/project-management/task/{id}', [\App\Controllers\ProjectController::class, 'taskStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->post('/admin/project-management/task/{id}/{task_id}', [\App\Controllers\ProjectController::class, 'taskUpdate'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/project-management/task-status/{id}/{task_id}', [\App\Controllers\ProjectController::class, 'taskStatus'], [AuthMiddleware::class]);
$router->get('/admin/project-management/task-delete/{id}/{task_id}', [\App\Controllers\ProjectController::class, 'taskDelete'], [AuthMiddleware::class]);

// Project Time Logs
$router->post('/admin/project-management/time/{id}', [\App\Controllers\ProjectController::class, 'logTime'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/project-management/time-delete/{id}/{log_id}', [\App\Controllers\ProjectController::class, 'deleteTime'], [AuthMiddleware::class]);

// Project Files
$router->post('/admin/project-management/file/{id}', [\App\Controllers\ProjectController::class, 'uploadFile'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/project-management/file-delete/{id}/{file_id}', [\App\Controllers\ProjectController::class, 'deleteFile'], [AuthMiddleware::class]);

// Admin CRM & Marketing
$router->get('/admin/crm', [\App\Controllers\CrmController::class, 'index'], [AuthMiddleware::class]);
$router->post('/admin/crm/customer-store', [\App\Controllers\CrmController::class, 'customerStore'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/crm/customer-delete/{id}', [\App\Controllers\CrmController::class, 'customerDelete'], [AuthMiddleware::class]);
$router->get('/admin/crm/campaigns', [\App\Controllers\CrmController::class, 'campaigns'], [AuthMiddleware::class]);
$router->post('/admin/crm/campaigns/send', [\App\Controllers\CrmController::class, 'sendCampaign'], [AuthMiddleware::class, CSRFMiddleware::class]);

// Admin Accounting & Finance
$router->get('/admin/accounting', [\App\Controllers\AccountingController::class, 'dashboard'], [AuthMiddleware::class]);
$router->get('/admin/accounting/expenses', [\App\Controllers\AccountingController::class, 'expenses'], [AuthMiddleware::class]);
$router->post('/admin/accounting/expenses/store', [\App\Controllers\AccountingController::class, 'storeExpense'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/accounting/expenses/delete/{id}', [\App\Controllers\AccountingController::class, 'deleteExpense'], [AuthMiddleware::class]);
$router->get('/admin/accounting/statement', [\App\Controllers\AccountingController::class, 'statement'], [AuthMiddleware::class]);
$router->get('/admin/accounting/reports', [\App\Controllers\AccountingController::class, 'reports'], [AuthMiddleware::class]);

// Admin Subscriptions Management
$router->get('/admin/subscriptions', [\App\Controllers\SubscriptionController::class, 'index'], [AuthMiddleware::class]);
$router->get('/admin/subscriptions/create', [\App\Controllers\SubscriptionController::class, 'create'], [AuthMiddleware::class]);
$router->post('/admin/subscriptions/create', [\App\Controllers\SubscriptionController::class, 'store'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/subscriptions/edit/{id}', [\App\Controllers\SubscriptionController::class, 'edit'], [AuthMiddleware::class]);
$router->post('/admin/subscriptions/edit/{id}', [\App\Controllers\SubscriptionController::class, 'update'], [AuthMiddleware::class, CSRFMiddleware::class]);
$router->get('/admin/subscriptions/delete/{id}', [\App\Controllers\SubscriptionController::class, 'delete'], [AuthMiddleware::class]);
$router->post('/admin/subscriptions/remind', [\App\Controllers\SubscriptionController::class, 'sendReminder'], [AuthMiddleware::class, CSRFMiddleware::class]);

// 4. Run Application
$app->run();
