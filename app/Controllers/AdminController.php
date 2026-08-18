<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Message;
use App\Models\Settings;
use App\Models\AuditLog;
use App\Models\Job;
use App\Models\Application;
use App\Models\Certificate;
use App\Models\Team;
use App\Models\User;

/**
 * Main CMS Admin Dashboard and Content Operations Coordinator
 */
class AdminController extends Controller {

    public function __construct() {
        $this->setLayout('admin');
    }

    /**
     * Helper to verify if the active session user has permission
     */
    protected function checkPermission(string $permission): void {
        if (!has_permission($permission)) {
            $response = new Response();
            $response->setStatusCode(403);
            $this->render('errors/403', ['title' => 'Forbidden Access']);
            exit;
        }
    }

    /**
     * Database Setup for Accounting and Billing
     */
    public function setupDb(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $db = \App\Core\Database::getConnection();
        $output = "Starting Database Setup...<br>";

        try {
            // 1. Alter Invoices
            try {
                $db->exec("ALTER TABLE `invoices` ADD COLUMN `amount_paid` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `total_amount`");
                $output .= "Added amount_paid column.<br>";
            } catch (\PDOException $e) { $output .= "amount_paid column already exists.<br>"; }
            
            try {
                $db->exec("ALTER TABLE `invoices` ADD COLUMN `balance_due` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `amount_paid`");
                $output .= "Added balance_due column.<br>";
            } catch (\PDOException $e) { $output .= "balance_due column already exists.<br>"; }

            try {
                $db->exec("ALTER TABLE `invoices` MODIFY COLUMN `status` VARCHAR(50) NOT NULL DEFAULT 'Draft'");
                $output .= "Modified status column to VARCHAR.<br>";
            } catch (\PDOException $e) { $output .= "Failed to modify status column: " . $e->getMessage() . "<br>"; }

            // 2. Create invoice_payments table
            $db->exec("CREATE TABLE IF NOT EXISTS `invoice_payments` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `invoice_id` INT NOT NULL,
                `amount` DECIMAL(15,2) NOT NULL,
                `payment_date` DATE NOT NULL,
                `payment_method` VARCHAR(50) NOT NULL,
                `reference` VARCHAR(100) NULL,
                `notes` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created invoice_payments table.<br>";

            // 3. Update existing invoices balances
            $db->exec("UPDATE `invoices` SET `balance_due` = `total_amount` WHERE `amount_paid` = 0");
            $output .= "Updated existing invoice balances.<br>";

            // 4. Create expenses table
            $db->exec("CREATE TABLE IF NOT EXISTS `expenses` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT NULL,
                `amount` DECIMAL(15,2) NOT NULL,
                `category` VARCHAR(100) NOT NULL,
                `expense_date` DATE NOT NULL,
                `receipt_path` VARCHAR(255) NULL,
                `recorded_by` INT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`recorded_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created expenses table.<br>";

            // 5. Create customers table for CRM
            $db->exec("CREATE TABLE IF NOT EXISTS `customers` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL UNIQUE,
                `phone` VARCHAR(50) NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created customers table.<br>";

            // 6. Create campaigns table for CRM
            $db->exec("CREATE TABLE IF NOT EXISTS `campaigns` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `type` ENUM('Email', 'SMS', 'WhatsApp') NOT NULL,
                `subject` VARCHAR(255) NULL,
                `message` TEXT NOT NULL,
                `status` ENUM('Pending', 'Sent', 'Failed') NOT NULL DEFAULT 'Sent',
                `sent_by` INT NULL,
                `sent_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`sent_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created campaigns table.<br>";

            // 7. Create subscriptions table
            $db->exec("CREATE TABLE IF NOT EXISTS `subscriptions` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `customer_id` BIGINT UNSIGNED NULL,
                `service_name` VARCHAR(255) NOT NULL,
                `provider_platform` VARCHAR(255) NULL,
                `cost` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
                `billing_cycle` ENUM('Monthly', 'Quarterly', 'Yearly') NOT NULL DEFAULT 'Yearly',
                `start_date` DATE NOT NULL,
                `next_due_date` DATE NOT NULL,
                `status` ENUM('Active', 'Expired', 'Cancelled') NOT NULL DEFAULT 'Active',
                `notify_client` TINYINT(1) NOT NULL DEFAULT 1,
                `notify_office` TINYINT(1) NOT NULL DEFAULT 1,
                `reminders_sent` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created subscriptions table.<br>";

            // 8. Create projects table
            $db->exec("CREATE TABLE IF NOT EXISTS `projects` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NULL,
                `customer_id` BIGINT UNSIGNED NULL,
                `status` ENUM('Not Started', 'In Progress', 'On Hold', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Not Started',
                `start_date` DATE NULL,
                `due_date` DATE NULL,
                `budget` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created projects table.<br>";

            // 9. Create project_tasks table
            $db->exec("CREATE TABLE IF NOT EXISTS `project_tasks` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `project_id` BIGINT UNSIGNED NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT NULL,
                `status` ENUM('To Do', 'In Progress', 'In Review', 'Completed') NOT NULL DEFAULT 'To Do',
                `priority` ENUM('Low', 'Medium', 'High', 'Urgent') NOT NULL DEFAULT 'Medium',
                `due_date` DATE NULL,
                `assigned_to` INT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created project_tasks table.<br>";

            // 10. Create project_time_logs table
            $db->exec("CREATE TABLE IF NOT EXISTS `project_time_logs` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `project_id` BIGINT UNSIGNED NOT NULL,
                `task_id` BIGINT UNSIGNED NULL,
                `user_id` INT NOT NULL,
                `hours` DECIMAL(5,2) NOT NULL,
                `date_logged` DATE NOT NULL,
                `notes` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`task_id`) REFERENCES `project_tasks`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created project_time_logs table.<br>";

            // 11. Create project_files table
            $db->exec("CREATE TABLE IF NOT EXISTS `project_files` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `project_id` BIGINT UNSIGNED NOT NULL,
                `file_name` VARCHAR(255) NOT NULL,
                `file_path` VARCHAR(255) NOT NULL,
                `file_size` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                `uploaded_by` INT NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $output .= "Created project_files table.<br>";

            // 12. Add project_id to invoices if it doesn't exist
            try {
                $db->exec("ALTER TABLE `invoices` ADD COLUMN `project_id` BIGINT UNSIGNED NULL AFTER `customer_id`");
                $db->exec("ALTER TABLE `invoices` ADD CONSTRAINT `fk_invoice_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL");
                $output .= "Added project_id column to invoices table.<br>";
            } catch (\PDOException $e) {
                // Ignore if column already exists
                if (strpos($e->getMessage(), 'Duplicate column name') === false) {
                    $output .= "<span style='color:orange;'>Warning altering invoices: " . $e->getMessage() . "</span><br>";
                }
            }

            $output .= "<br><b>Database setup completed successfully!</b>";
            $html = "<div style='font-family:sans-serif; padding:20px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px;'>" . $output . "</div>";
            echo $html;
            return $html;

        } catch (\PDOException $e) {
            $html = "<div style='font-family:sans-serif; padding:20px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca; border-radius:8px;'><b>Error:</b> " . $e->getMessage() . "</div>";
            echo $html;
            return $html;
        }
    }

    /**
     * Admin Dashboard Home Page
     */
    public function index(Request $request, Response $response): string {
        $servicesCount = count(Service::all());
        $projectsCount = count(Project::all());
        $blogsCount = count(Blog::all());
        $jobsCount = count(Job::all());
        
        $db = Service::getDb();
        $unreadMessagesCount = (int)$db->query("SELECT COUNT(id) FROM messages WHERE is_read = 0")->fetchColumn();
        
        $recentMessages = Message::query("SELECT * FROM messages ORDER BY id DESC LIMIT 5");
        $recentLogs = AuditLog::query("
            SELECT al.*, u.name as user_name 
            FROM audit_logs al 
            LEFT JOIN users u ON al.user_id = u.id 
            ORDER BY al.id DESC LIMIT 5
        ");

        return $this->render('admin/dashboard', [
            'title' => 'CMS Control Panel Dashboard',
            'stats' => [
                'services' => $servicesCount,
                'projects' => $projectsCount,
                'blogs' => $blogsCount,
                'jobs' => $jobsCount,
                'messages' => $unreadMessagesCount
            ],
            'recent_messages' => $recentMessages,
            'recent_logs' => $recentLogs
        ]);
    }

    // ==========================================
    // SERVICES CRUD
    // ==========================================
    
    public function services(Request $request, Response $response): string {
        $this->checkPermission('manage_services');
        $services = Service::all('id DESC');
        return $this->render('admin/services/index', [
            'title' => 'Manage Services',
            'services' => $services
        ]);
    }

    public function serviceCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_services');
        return $this->render('admin/services/create', [
            'title' => 'Add New Service'
        ]);
    }

    public function serviceStore(Request $request, Response $response): void {
        $this->checkPermission('manage_services');
        $session = new Session();
        
        $title = $request->get('title');
        $description = $request->get('description');
        $benefits = $request->get('benefits');
        $features = $request->get('features');
        $methodology = $request->get('methodology');
        $deliverables = $request->get('deliverables');
        $technologies = $request->get('technologies');
        $industries = $request->get('industries_served');
        $icon = $request->get('icon', 'fa-cogs');
        $status = $request->get('status', 'draft');

        if (empty($title) || empty($description)) {
            $session->setFlash('error', 'Title and Description are required.');
            $response->redirect('/admin/services/create');
        }

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)), '-');
        
        Service::create([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'benefits' => $benefits,
            'features' => $features,
            'methodology' => $methodology,
            'deliverables' => $deliverables,
            'technologies' => $technologies,
            'industries_served' => $industries,
            'icon' => $icon,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Create Service', 'Created service: ' . $title);
        $session->setFlash('success', 'Service added successfully.');
        $response->redirect('/admin/services');
    }

    public function serviceEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_services');
        $id = (int)($params['id'] ?? 0);
        $service = Service::find($id);

        if (!$service) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        return $this->render('admin/services/edit', [
            'title' => 'Edit Service - ' . $service['title'],
            'service' => $service
        ]);
    }

    public function serviceUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_services');
        $id = (int)($params['id'] ?? 0);
        $session = new Session();

        $title = $request->get('title');
        $description = $request->get('description');
        $benefits = $request->get('benefits');
        $features = $request->get('features');
        $methodology = $request->get('methodology');
        $deliverables = $request->get('deliverables');
        $technologies = $request->get('technologies');
        $industries = $request->get('industries_served');
        $icon = $request->get('icon', 'fa-cogs');
        $status = $request->get('status', 'draft');

        if (empty($title) || empty($description)) {
            $session->setFlash('error', 'Title and Description are required.');
            $response->redirect('/admin/services/edit/' . $id);
        }

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)), '-');

        Service::update($id, [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'benefits' => $benefits,
            'features' => $features,
            'methodology' => $methodology,
            'deliverables' => $deliverables,
            'technologies' => $technologies,
            'industries_served' => $industries,
            'icon' => $icon,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Update Service', 'Updated service ID: ' . $id);
        $session->setFlash('success', 'Service updated successfully.');
        $response->redirect('/admin/services');
    }

    public function serviceDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_services');
        $id = (int)($params['id'] ?? 0);
        
        Service::delete($id);
        AuditLog::log(current_user()['id'], 'Delete Service', 'Deleted service ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Service deleted successfully.');
        $response->redirect('/admin/services');
    }

    // ==========================================
    // PROJECTS CRUD
    // ==========================================

    public function projects(Request $request, Response $response): string {
        $this->checkPermission('manage_projects');
        $projects = Project::getAllProjectsWithCategory();
        return $this->render('admin/projects/index', [
            'title' => 'Manage Projects',
            'projects' => $projects
        ]);
    }

    public function projectCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_projects');
        $categories = Project::query("SELECT * FROM project_categories ORDER BY name ASC");
        return $this->render('admin/projects/create', [
            'title' => 'Add New Project Case Study',
            'categories' => $categories
        ]);
    }

    public function projectStore(Request $request, Response $response): void {
        $this->checkPermission('manage_projects');
        $session = new Session();

        $title = $request->get('title');
        $client = $request->get('client');
        $categoryId = (int)$request->get('category_id');
        $location = $request->get('location', 'Nigeria');
        $duration = $request->get('duration');
        $budget = $request->get('budget', 'Confidential');
        $technologies = $request->get('technologies');
        $challenge = $request->get('challenge');
        $solution = $request->get('solution');
        $outcome = $request->get('outcome');
        $status = $request->get('status', 'draft');

        if (empty($title) || empty($client) || empty($categoryId)) {
            $session->setFlash('error', 'Title, Client, and Category are required.');
            $response->redirect('/admin/projects/create');
        }

        // Upload Project Image
        $file = $request->getFile('banner_image');
        $bannerPath = 'project_placeholder.jpg';
        
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = uniqid('project_', true) . '.' . $ext;
            $dir = PUBLIC_DIR . '/assets/uploads/projects/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                $bannerPath = 'assets/uploads/projects/' . $filename;
            }
        }

        // Upload Project Gallery Images
        $galleryPaths = [];
        if (isset($_FILES['gallery_images']) && is_array($_FILES['gallery_images']['name'])) {
            $files = $_FILES['gallery_images'];
            $dir = PUBLIC_DIR . '/assets/uploads/projects/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                        $filename = uniqid('project_gallery_', true) . '.' . $ext;
                        if (move_uploaded_file($files['tmp_name'][$i], $dir . $filename)) {
                            $galleryPaths[] = 'assets/uploads/projects/' . $filename;
                        }
                    }
                }
            }
        }
        $galleryImages = !empty($galleryPaths) ? implode(',', $galleryPaths) : null;

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)), '-');

        Project::create([
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'client' => $client,
            'location' => $location,
            'duration' => $duration,
            'budget' => $budget,
            'technologies' => $technologies,
            'challenge' => $challenge,
            'solution' => $solution,
            'outcome' => $outcome,
            'banner_image' => $bannerPath,
            'gallery_images' => $galleryImages,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Create Project', 'Created project: ' . $title);
        $session->setFlash('success', 'Project created successfully.');
        $response->redirect('/admin/projects');
    }

    public function projectEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_projects');
        $id = (int)($params['id'] ?? 0);
        $project = Project::find($id);
        $categories = Project::query("SELECT * FROM project_categories ORDER BY name ASC");

        if (!$project) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        return $this->render('admin/projects/edit', [
            'title' => 'Edit Project Case Study',
            'project' => $project,
            'categories' => $categories
        ]);
    }

    public function projectUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_projects');
        $id = (int)($params['id'] ?? 0);
        $project = Project::find($id);
        $session = new Session();

        if (!$project) {
            $session->setFlash('error', 'Project not found.');
            $response->redirect('/admin/projects');
        }

        $title = $request->get('title');
        $client = $request->get('client');
        $categoryId = (int)$request->get('category_id');
        $location = $request->get('location', 'Nigeria');
        $duration = $request->get('duration');
        $budget = $request->get('budget', 'Confidential');
        $technologies = $request->get('technologies');
        $challenge = $request->get('challenge');
        $solution = $request->get('solution');
        $outcome = $request->get('outcome');
        $status = $request->get('status', 'draft');

        if (empty($title) || empty($client) || empty($categoryId)) {
            $session->setFlash('error', 'Title, Client, and Category are required.');
            $response->redirect('/admin/projects/edit/' . $id);
        }

        $bannerPath = $project['banner_image'];
        $file = $request->getFile('banner_image');
        
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = uniqid('project_', true) . '.' . $ext;
            $dir = PUBLIC_DIR . '/assets/uploads/projects/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                $bannerPath = 'assets/uploads/projects/' . $filename;
            }
        }

        $galleryImages = $project['gallery_images'];
        // Process new gallery uploads if any
        $galleryPaths = [];
        if (isset($_FILES['gallery_images']) && is_array($_FILES['gallery_images']['name'])) {
            $files = $_FILES['gallery_images'];
            $dir = PUBLIC_DIR . '/assets/uploads/projects/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                        $filename = uniqid('project_gallery_', true) . '.' . $ext;
                        if (move_uploaded_file($files['tmp_name'][$i], $dir . $filename)) {
                            $galleryPaths[] = 'assets/uploads/projects/' . $filename;
                        }
                    }
                }
            }
            if (!empty($galleryPaths)) {
                $galleryImages = implode(',', $galleryPaths);
            }
        }

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)), '-');

        Project::update($id, [
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'client' => $client,
            'location' => $location,
            'duration' => $duration,
            'budget' => $budget,
            'technologies' => $technologies,
            'challenge' => $challenge,
            'solution' => $solution,
            'outcome' => $outcome,
            'banner_image' => $bannerPath,
            'gallery_images' => $galleryImages,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Update Project', 'Updated project ID: ' . $id);
        $session->setFlash('success', 'Project updated successfully.');
        $response->redirect('/admin/projects');
    }

    public function projectDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_projects');
        $id = (int)($params['id'] ?? 0);
        
        Project::delete($id);
        AuditLog::log(current_user()['id'], 'Delete Project', 'Deleted project ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Project deleted successfully.');
        $response->redirect('/admin/projects');
    }

    // ==========================================
    // INSIGHTS (BLOGS) CRUD
    // ==========================================

    public function insights(Request $request, Response $response): string {
        $this->checkPermission('manage_blogs');
        $blogs = Blog::all('id DESC');
        return $this->render('admin/insights/index', [
            'title' => 'Manage Insights & Publications',
            'blogs' => $blogs
        ]);
    }

    public function insightCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_blogs');
        $categories = Blog::query("SELECT * FROM blog_categories ORDER BY name ASC");
        return $this->render('admin/insights/create', [
            'title' => 'Create Insight Post',
            'categories' => $categories
        ]);
    }

    public function insightStore(Request $request, Response $response): void {
        $this->checkPermission('manage_blogs');
        $session = new Session();

        $title = $request->get('title');
        $content = $_POST['content'] ?? '';
        $summary = $request->get('summary');
        $categoryId = (int)$request->get('category_id');
        $type = $request->get('type', 'blog');
        $status = $request->get('status', 'draft');
        $tags = $request->get('tags');
        $quote = $request->get('quote');

        if (empty($title) || empty($content) || empty($categoryId)) {
            $session->setFlash('error', 'Title, Content, and Category are required.');
            $response->redirect('/admin/insights/create');
        }

        // Upload Blog Image
        $file = $request->getFile('banner_image');
        $bannerPath = 'insight_placeholder.jpg';
        
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = uniqid('blog_', true) . '.' . $ext;
            $dir = PUBLIC_DIR . '/assets/uploads/blogs/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                $bannerPath = 'assets/uploads/blogs/' . $filename;
            }
        }

        // Upload Gallery Images
        $galleryImages = null;
        $galleryPaths = [];
        if (isset($_FILES['gallery_images']) && is_array($_FILES['gallery_images']['name'])) {
            $files = $_FILES['gallery_images'];
            $dir = PUBLIC_DIR . '/assets/uploads/blogs/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $filename = uniqid('blog_gallery_', true) . '.' . $ext;
                        if (move_uploaded_file($files['tmp_name'][$i], $dir . $filename)) {
                            $galleryPaths[] = 'assets/uploads/blogs/' . $filename;
                        }
                    }
                }
            }
            if (!empty($galleryPaths)) {
                $galleryImages = implode(',', $galleryPaths);
            }
        }

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)), '-');
        $publishedAt = ($status === 'published') ? date('Y-m-d H:i:s') : null;

        Blog::create([
            'category_id' => $categoryId,
            'author_id' => current_user()['id'],
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'summary' => $summary,
            'tags' => $tags,
            'quote' => $quote,
            'banner_image' => $bannerPath,
            'gallery_images' => $galleryImages,
            'type' => $type,
            'status' => $status,
            'published_at' => $publishedAt
        ]);

        AuditLog::log(current_user()['id'], 'Create Insight', 'Created insight post: ' . $title);
        $session->setFlash('success', 'Insight post created successfully.');
        $response->redirect('/admin/insights');
    }

    public function insightEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_blogs');
        $id = (int)($params['id'] ?? 0);
        $blog = Blog::find($id);
        $categories = Blog::query("SELECT * FROM blog_categories ORDER BY name ASC");

        if (!$blog) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        return $this->render('admin/insights/edit', [
            'title' => 'Edit Insight Post',
            'blog' => $blog,
            'categories' => $categories
        ]);
    }

    public function insightUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_blogs');
        $id = (int)($params['id'] ?? 0);
        $blog = Blog::find($id);
        $session = new Session();

        if (!$blog) {
            $session->setFlash('error', 'Insight not found.');
            $response->redirect('/admin/insights');
        }

        $title = $request->get('title');
        $content = $_POST['content'] ?? ''; // Bypass Request sanitizer for rich text
        $summary = $request->get('summary');
        $categoryId = (int)$request->get('category_id');
        $type = $request->get('type', 'blog');
        $status = $request->get('status', 'draft');
        $tags = $request->get('tags');
        $quote = $request->get('quote');

        if (empty($title) || empty($content) || empty($categoryId)) {
            $session->setFlash('error', 'Title, Content, and Category are required.');
            $response->redirect('/admin/insights/edit/' . $id);
        }

        $bannerPath = $blog['banner_image'];
        $file = $request->getFile('banner_image');
        
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = uniqid('blog_', true) . '.' . $ext;
            $dir = PUBLIC_DIR . '/assets/uploads/blogs/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                $bannerPath = 'assets/uploads/blogs/' . $filename;
            }
        }

        // Upload Gallery Images
        $galleryImages = $blog['gallery_images'] ?? null;
        $galleryPaths = [];
        if (isset($_FILES['gallery_images']) && is_array($_FILES['gallery_images']['name']) && !empty($_FILES['gallery_images']['name'][0])) {
            $files = $_FILES['gallery_images'];
            $dir = PUBLIC_DIR . '/assets/uploads/blogs/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $filename = uniqid('blog_gallery_', true) . '.' . $ext;
                        if (move_uploaded_file($files['tmp_name'][$i], $dir . $filename)) {
                            $galleryPaths[] = 'assets/uploads/blogs/' . $filename;
                        }
                    }
                }
            }
            if (!empty($galleryPaths)) {
                $galleryImages = implode(',', $galleryPaths);
            }
        }

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)), '-');
        
        // Handle publishing timestamp adjustments
        $publishedAt = $blog['published_at'];
        if ($status === 'published' && empty($publishedAt)) {
            $publishedAt = date('Y-m-d H:i:s');
        } elseif ($status === 'draft') {
            $publishedAt = null;
        }

        Blog::update($id, [
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'summary' => $summary,
            'tags' => $tags,
            'quote' => $quote,
            'banner_image' => $bannerPath,
            'gallery_images' => $galleryImages,
            'type' => $type,
            'status' => $status,
            'published_at' => $publishedAt
        ]);

        AuditLog::log(current_user()['id'], 'Update Insight', 'Updated insight post ID: ' . $id);
        $session->setFlash('success', 'Insight post updated successfully.');
        $response->redirect('/admin/insights');
    }

    public function insightDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_blogs');
        $id = (int)($params['id'] ?? 0);
        
        Blog::delete($id);
        AuditLog::log(current_user()['id'], 'Delete Insight', 'Deleted insight post ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Post deleted successfully.');
        $response->redirect('/admin/insights');
    }

    public function insightCategories(Request $request, Response $response): string {
        $this->checkPermission('manage_blogs');
        $categories = \App\Models\BlogCategory::all('name ASC');
        return $this->render('admin/insights/categories', [
            'title' => 'Manage Blog Categories',
            'categories' => $categories
        ]);
    }

    public function insightCategoryStore(Request $request, Response $response): void {
        $this->checkPermission('manage_blogs');
        $session = new Session();
        
        $name = trim($request->get('name'));
        if (empty($name)) {
            $session->setFlash('error', 'Category name is required.');
            $response->redirect('/admin/insights/categories');
            return;
        }

        $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)), '-');
        
        \App\Models\BlogCategory::create([
            'name' => $name,
            'slug' => $slug
        ]);
        
        AuditLog::log(current_user()['id'], 'Create Category', 'Created insight category: ' . $name);
        $session->setFlash('success', 'Category created successfully.');
        $response->redirect('/admin/insights/categories');
    }

    public function insightCategoryDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_blogs');
        $id = (int)($params['id'] ?? 0);
        
        \App\Models\BlogCategory::delete($id);
        AuditLog::log(current_user()['id'], 'Delete Category', 'Deleted insight category ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Category deleted successfully.');
        $response->redirect('/admin/insights/categories');
    }

    // ==========================================
    // CAREERS CRUD
    // ==========================================

    public function careers(Request $request, Response $response): string {
        $this->checkPermission('manage_careers');
        $jobs = Job::all('id DESC');
        return $this->render('admin/careers/index', [
            'title' => 'Manage Vacancies',
            'jobs' => $jobs
        ]);
    }

    public function careerCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_careers');
        return $this->render('admin/careers/create', [
            'title' => 'Add New Vacancy Position'
        ]);
    }

    public function careerStore(Request $request, Response $response): void {
        $this->checkPermission('manage_careers');
        $session = new Session();

        $title = $request->get('title');
        $description = $request->get('description');
        $requirements = $request->get('requirements');
        $location = $request->get('location', 'Abuja, Nigeria');
        $jobType = $request->get('job_type', 'full-time');
        $status = $request->get('status', 'open');

        if (empty($title) || empty($description) || empty($requirements)) {
            $session->setFlash('error', 'Title, Description, and Requirements are required.');
            $response->redirect('/admin/careers/create');
        }

        Job::create([
            'title' => $title,
            'description' => $description,
            'requirements' => $requirements,
            'location' => $location,
            'job_type' => $jobType,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Create Job Post', 'Created vacancy: ' . $title);
        $session->setFlash('success', 'Job vacancy posted successfully.');
        $response->redirect('/admin/careers');
    }

    public function careerEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_careers');
        $id = (int)($params['id'] ?? 0);
        $job = Job::find($id);

        if (!$job) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        return $this->render('admin/careers/edit', [
            'title' => 'Edit Vacancy Position',
            'job' => $job
        ]);
    }

    public function careerUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_careers');
        $id = (int)($params['id'] ?? 0);
        $session = new Session();

        $title = $request->get('title');
        $description = $request->get('description');
        $requirements = $request->get('requirements');
        $location = $request->get('location', 'Abuja, Nigeria');
        $jobType = $request->get('job_type', 'full-time');
        $status = $request->get('status', 'open');

        if (empty($title) || empty($description) || empty($requirements)) {
            $session->setFlash('error', 'Title, Description, and Requirements are required.');
            $response->redirect('/admin/careers/edit/' . $id);
        }

        Job::update($id, [
            'title' => $title,
            'description' => $description,
            'requirements' => $requirements,
            'location' => $location,
            'job_type' => $jobType,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Update Job Post', 'Updated vacancy ID: ' . $id);
        $session->setFlash('success', 'Job vacancy updated successfully.');
        $response->redirect('/admin/careers');
    }

    public function careerDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_careers');
        $id = (int)($params['id'] ?? 0);
        
        Job::delete($id);
        AuditLog::log(current_user()['id'], 'Delete Job Post', 'Deleted job vacancy ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Job vacancy deleted successfully.');
        $response->redirect('/admin/careers');
    }

    public function careerApplications(Request $request, Response $response): string {
        $this->checkPermission('manage_careers');
        $applications = Application::getApplicationsWithJobs();
        return $this->render('admin/careers/applications', [
            'title' => 'Received Applications',
            'applications' => $applications
        ]);
    }

    // ==========================================
    // MESSAGES
    // ==========================================

    public function messages(Request $request, Response $response): string {
        $this->checkPermission('manage_messages');
        $messages = Message::all('id DESC');
        return $this->render('admin/messages/index', [
            'title' => 'Inquiries & Contact Messages',
            'messages' => $messages
        ]);
    }

    public function messageView(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_messages');
        $id = (int)($params['id'] ?? 0);
        $msg = Message::find($id);

        if (!$msg) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        if ($msg['is_read'] === 0) {
            Message::update($id, ['is_read' => 1]);
        }

        return $this->render('admin/messages/view', [
            'title' => 'Message details from: ' . $msg['name'],
            'message' => $msg
        ]);
    }

    public function messageDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_messages');
        $id = (int)($params['id'] ?? 0);
        
        Message::delete($id);
        AuditLog::log(current_user()['id'], 'Delete Message', 'Deleted contact message log ID: ' . $id);
        
        $session = new Session();
        $session->setFlash('success', 'Inquiry log deleted successfully.');
        $response->redirect('/admin/messages');
    }

    // ==========================================
    // SITE SETTINGS
    // ==========================================

    public function settings(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        return $this->render('admin/settings', [
            'title' => 'Site Configuration Panel'
        ]);
    }

    public function settingsUpdate(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();
        
        $inputs = $request->getBody();
        // Remove csrf_token from settings values mapping
        unset($inputs['csrf_token']);

        // Handle Company Profile PDF upload
        $file = $request->getFile('company_profile_pdf');
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $dir = PUBLIC_DIR . '/assets/uploads/documents/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = 'company_profile.pdf';
                if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                    Settings::set('company_profile_pdf', 'assets/uploads/documents/' . $filename);
                }
            } else {
                $session->setFlash('error', 'Only PDF files are allowed for the Company Profile.');
                $response->redirect('/admin/settings');
                return;
            }
        }

        foreach ($inputs as $key => $val) {
            Settings::set($key, $val);
        }

        AuditLog::log(current_user()['id'], 'Update Site Settings', 'Global site metadata settings updated.');
        $session->setFlash('success', 'Site settings updated successfully.');
        $response->redirect('/admin/settings');
    }

    // ==========================================
    // AUDIT LOGS
    // ==========================================

    public function logs(Request $request, Response $response): string {
        $this->checkPermission('view_audit_logs');
        $logs = AuditLog::getLogsWithUser();
        AuditLog::log(current_user()['id'], 'Security Audit Trail Logs', 'Viewed administrative security logs.');
        return $this->render('admin/logs', [
            'title' => 'Security Audit Trail Logs',
            'logs' => $logs
        ]);
    }

    // ==========================================
    // WEBMAIL & NEWSLETTER ACTIONS
    // ==========================================

    public function mailInbox(Request $request, Response $response): string {
        $this->checkPermission('manage_messages');
        $activeAccount = $request->get('account', 'info@isecltd.ng');
        
        // Fetch newsletter subscribers
        $subscribers = \App\Models\Newsletter::all('id DESC');
        
        // Check if IMAP is enabled
        $imapEnabled = function_exists('imap_open');
        $emails = [];
        $imapError = '';
        
        if ($imapEnabled) {
            $host = Settings::get('mail_imap_host');
            $port = Settings::get('mail_imap_port', '993');
            $encryption = Settings::get('mail_imap_encryption', 'ssl');
            $prefix = explode('@', $activeAccount)[0] ?? 'info';
            $password = Settings::get('mail_pass_' . $prefix);
            
            if ($host && $password) {
                $sslFlag = ($encryption === 'ssl') ? '/ssl/novalidate-cert' : '/novalidate-cert';
                $mboxPath = "{" . $host . ":" . $port . "/imap" . $sslFlag . "}INBOX";
                
                // Open connection with a 5 second timeout to prevent blocking
                imap_timeout(IMAP_OPENTIMEOUT, 5);
                $mbox = @imap_open($mboxPath, $activeAccount, $password);
                
                if ($mbox) {
                    $numMsgs = imap_num_msg($mbox);
                    // Fetch last 15 emails
                    $start = max(1, $numMsgs - 14);
                    for ($i = $numMsgs; $i >= $start; $i--) {
                        $header = imap_headerinfo($mbox, $i);
                        
                        // Parse sender details
                        $from = $header->from[0] ?? null;
                        $fromAddress = $from ? ($from->mailbox . "@" . $from->host) : 'unknown';
                        $fromName = $from ? ($from->personal ?? $fromAddress) : 'Unknown';
                        
                        // Fetch full body and create snippet
                        $fullBody = $this->getImapBody($mbox, $i);
                        $snippet = strip_tags(str_replace(['<br>', '<br/>', '</p>'], ' ', $fullBody));
                        $snippet = preg_replace('/\s+/', ' ', $snippet);
                        $snippet = mb_substr(trim($snippet), 0, 100) . '...';
                        
                        $emails[] = [
                            'uid' => $i,
                            'from_name' => decode_mime_header($fromName),
                            'from_email' => $fromAddress,
                            'subject' => decode_mime_header($header->subject ?? '(No Subject)'),
                            'date' => $header->date ?? '',
                            'body' => $fullBody,
                            'snippet' => $snippet
                        ];
                    }
                    imap_close($mbox);
                } else {
                    $imapError = 'IMAP Connection Error: ' . imap_last_error();
                }
            } else {
                $imapError = 'Please configure your IMAP host and email account password in the settings form below.';
            }
        } else {
            $imapError = 'PHP IMAP extension is disabled in php.ini. Displaying sandbox fallback inbox.';
            
            // Seed some mock emails for testing if IMAP extension is missing
            $emails = [
                [
                    'uid' => 1,
                    'from_name' => 'Dr. Prince Oyakhire',
                    'from_email' => 'jerry@isecltd.ng',
                    'subject' => 'Integrated Systems Strategy 2026',
                    'date' => date('D, d M Y H:i:s O', strtotime('-1 hour')),
                    'body' => '<p>Hi Team,</p><p>Please audit the Kwara GIS project endpoints. We need to secure the boundary API integrations immediately.</p>',
                    'snippet' => 'Hi Team, please audit the Kwara GIS project endpoints...'
                ],
                [
                    'uid' => 2,
                    'from_name' => 'FMS Agency Abuja',
                    'from_email' => 'fms.procure@abuja.gov.ng',
                    'subject' => 'Technical Audits SLA Proposal',
                    'date' => date('D, d M Y H:i:s O', strtotime('-1 day')),
                    'body' => '<p>Dear ISEC,</p><p>We have reviewed the revenue automation blueprints. Please send the pricing schedule from info@isecltd.ng.</p>',
                    'snippet' => 'Dear ISEC, we have reviewed the revenue automation blueprints...'
                ],
                [
                    'uid' => 3,
                    'from_name' => 'System Guardian Alerts',
                    'from_email' => 'no-reply@cpanel.isecltd.ng',
                    'subject' => '[Security Log] Successful Admin Panel Login',
                    'date' => date('D, d M Y H:i:s O', strtotime('-2 days')),
                    'body' => 'Success login detected for admin@isecltd.ng from IP 192.168.1.45. Activity recorded in secure audit log trail.',
                    'snippet' => 'Success login detected for admin@isecltd.ng from IP 192.168.1.45...'
                ]
            ];
        }
        $templates = \App\Models\MessageTemplate::query("SELECT * FROM message_templates WHERE type = 'Email' ORDER BY name ASC");
        
        return $this->render('admin/mail/index', [
            'title' => 'Secure Mail & Broadcast Center',
            'activeAccount' => $activeAccount,
            'emails' => $emails,
            'subscribers' => $subscribers,
            'templates' => $templates,
            'imapEnabled' => $imapEnabled,
            'imapError' => $imapError
        ]);
    }

    /**
     * Extracts the best readable body from an IMAP email structure
     */
    private function getImapBody($mbox, $uid) {
        $structure = @imap_fetchstructure($mbox, $uid);
        if (!$structure) {
            return 'Could not read email structure.';
        }
        
        $body = '';
        $encoding = 0;
        
        if (isset($structure->parts) && count($structure->parts)) {
            // Multipart message
            $partNum = 1;
            foreach ($structure->parts as $index => $sub) {
                if (strtoupper($sub->subtype) === 'HTML') {
                    $partNum = $index + 1;
                    $encoding = $sub->encoding ?? 0;
                    break;
                }
            }
            if ($partNum === 1) {
                $encoding = $structure->parts[0]->encoding ?? 0;
            }
            
            // Check for nested parts (e.g. multipart/alternative inside mixed)
            if ($structure->parts[$partNum - 1]->type === TYPEMULTIPART && isset($structure->parts[$partNum - 1]->parts)) {
                $subPartNum = 1;
                foreach ($structure->parts[$partNum - 1]->parts as $subIndex => $subSub) {
                    if (strtoupper($subSub->subtype) === 'HTML') {
                        $subPartNum = $subIndex + 1;
                        $encoding = $subSub->encoding ?? 0;
                        break;
                    }
                }
                $partNum = $partNum . "." . $subPartNum;
            }
            
            $body = @imap_fetchbody($mbox, $uid, (string)$partNum);
        } else {
            // Simple email
            $body = @imap_fetchbody($mbox, $uid, 1);
            $encoding = $structure->encoding ?? 0;
        }
        
        if ($encoding == 3) {
            $body = @imap_base64($body);
        } elseif ($encoding == 4) {
            $body = @quoted_printable_decode($body);
        }
        
        // Ensure valid UTF-8 encoding
        return mb_convert_encoding($body, 'UTF-8', 'UTF-8, ISO-8859-1, ASCII');
    }
    
    public function mailCompose(Request $request, Response $response): void {
        $this->checkPermission('manage_messages');
        $session = new Session();
        
        $from = $request->get('from');
        $to = $request->get('to');
        $subject = $request->get('subject');
        $body = $request->get('body');
        
        if (empty($from) || empty($to) || empty($subject) || empty($body)) {
            $session->setFlash('error', 'Please fill all fields to send email.');
            $response->redirect('/admin/mail');
            return;
        }
        
        try {
            \App\Helpers\Mailer::send($from, $to, $subject, $body, 'ISEC Systems Center');
            AuditLog::log(current_user()['id'], 'Compose Webmail', "Individual email sent to $to from $from");
            $session->setFlash('success', "Email successfully sent to $to.");
        } catch (\Exception $e) {
            $session->setFlash('error', 'Failed sending email: ' . $e->getMessage());
        }
        
        $response->redirect('/admin/mail');
    }
    
    public function mailBulk(Request $request, Response $response): void {
        $this->checkPermission('manage_messages');
        $session = new Session();
        
        $from = $request->get('from');
        $subject = $request->get('subject');
        $body = $request->get('body');
        $target = $request->get('target_group'); // all, newsletter, manual
        $manualEmails = $request->get('manual_emails');
        
        if (empty($from) || empty($subject) || empty($body)) {
            $session->setFlash('error', 'Please provide sender address, subject, and content.');
            $response->redirect('/admin/mail');
            return;
        }
        
        $recipients = [];
        if ($target === 'newsletter') {
            $subscribers = \App\Models\Newsletter::all();
            foreach ($subscribers as $sub) {
                $recipients[] = $sub['email'];
            }
        } elseif ($target === 'manual' && !empty($manualEmails)) {
            $parts = explode(',', $manualEmails);
            foreach ($parts as $p) {
                $email = trim($p);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = $email;
                }
            }
        } else {
            // Send to both newsletter and contacts
            $subscribers = \App\Models\Newsletter::all();
            foreach ($subscribers as $sub) {
                $recipients[] = $sub['email'];
            }
            $messages = \App\Models\Message::all();
            foreach ($messages as $msg) {
                if (!in_array($msg['email'], $recipients)) {
                    $recipients[] = $msg['email'];
                }
            }
        }
        
        if (empty($recipients)) {
            $session->setFlash('error', 'No email recipients found for the selected broadcast group.');
            $response->redirect('/admin/mail');
            return;
        }
        
        $successCount = 0;
        $failCount = 0;
        
        foreach ($recipients as $recipient) {
            try {
                // Add a basic unsubscribe footer to the email
                $formattedBody = $body . "<br><br><hr><p style='font-size: 10px; color: #888;'>You are receiving this operational broadcast from Integrated Systems Efficiency Consults (ISEC). To unsubscribe, please contact info@isecltd.ng.</p>";
                \App\Helpers\Mailer::send($from, $recipient, $subject, $formattedBody, 'ISEC Broadcast');
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
            }
        }
        
        AuditLog::log(current_user()['id'], 'Bulk Email Broadcast', "Sent broadcast from $from to $successCount recipients ($failCount failed).");
        $session->setFlash('success', "Broadcast campaign completed: $successCount sent successfully, $failCount failed.");
        $response->redirect('/admin/mail');
    }
    
    public function mailSettingsUpdate(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();
        
        $inputs = $request->getBody();
        unset($inputs['csrf_token']);
        
        foreach ($inputs as $key => $val) {
            Settings::set($key, $val);
        }
        
        AuditLog::log(current_user()['id'], 'Update Webmail Configuration', 'SMTP/IMAP server connection details modified.');
        $session->setFlash('success', 'Webmail settings updated successfully.');
        $response->redirect('/admin/mail');
    }

    // --- Trainee Certificates CRUD ---

    public function certificates(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        $search = $request->get('search');
        
        if (!empty($search)) {
            $searchVal = '%' . $search . '%';
            $certificates = Certificate::query("SELECT * FROM `certificates` WHERE `recipient_name` LIKE :search OR `certificate_number` LIKE :search ORDER BY id DESC", ['search' => $searchVal]);
        } else {
            $certificates = Certificate::query("SELECT * FROM `certificates` ORDER BY id DESC");
        }

        return $this->render('admin/certificates/index', [
            'title' => 'Manage Trainee Certificates - ISEC CMS',
            'certificates' => $certificates,
            'search' => $search
        ]);
    }

    public function certificateCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        return $this->render('admin/certificates/create', [
            'title' => 'Register Trainee Certificate - ISEC CMS'
        ]);
    }

    public function certificateStore(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();

        $certNumber = trim($request->get('certificate_number'));
        $recipientName = trim($request->get('recipient_name'));
        $courseName = trim($request->get('course_name'));
        $issueDate = $request->get('issue_date');
        $expiryDate = $request->get('expiry_date') ?: null;
        $gradeStatus = $request->get('grade_status', 'Certified');

        if (empty($certNumber) || empty($recipientName) || empty($courseName) || empty($issueDate)) {
            $session->setFlash('error', 'Certificate number, recipient name, course, and issue date are required.');
            $response->redirect('/admin/certificates/create');
            return;
        }

        // Check if certificate number already exists
        $existing = Certificate::findByNumber($certNumber);
        if ($existing) {
            $session->setFlash('error', 'A certificate with this registration number already exists.');
            $response->redirect('/admin/certificates/create');
            return;
        }

        // Handle optional certificate PDF file upload
        $pdfPath = null;
        $file = $request->getFile('pdf_file');
        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['pdf', 'png', 'jpg', 'jpeg'])) {
                    $dir = PUBLIC_DIR . '/assets/uploads/certificates/';
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $filename = uniqid('cert_', true) . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                        $pdfPath = 'assets/uploads/certificates/' . $filename;
                    } else {
                        $session->setFlash('error', 'Failed to move uploaded file. Check server permissions.');
                        $response->redirect('/admin/certificates/create');
                        return;
                    }
                } else {
                    $session->setFlash('error', 'Only PDF, PNG, or JPG files are allowed for certificate uploads.');
                    $response->redirect('/admin/certificates/create');
                    return;
                }
            } else {
                $session->setFlash('error', 'File upload error: ' . $file['error']);
                $response->redirect('/admin/certificates/create');
                return;
            }
        }

        Certificate::create([
            'certificate_number' => $certNumber,
            'recipient_name' => $recipientName,
            'course_name' => $courseName,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'grade_status' => $gradeStatus,
            'pdf_path' => $pdfPath
        ]);

        AuditLog::log(current_user()['id'], 'Create Certificate', "Issued certificate $certNumber to $recipientName.");
        $session->setFlash('success', 'Trainee certificate registered successfully.');
        $response->redirect('/admin/certificates');
    }

    public function certificateEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $certificate = Certificate::find($id);

        if (!$certificate) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        return $this->render('admin/certificates/edit', [
            'title' => 'Edit Trainee Certificate - ISEC CMS',
            'certificate' => $certificate
        ]);
    }

    public function certificateUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $certificate = Certificate::find($id);
        $session = new Session();

        if (!$certificate) {
            $session->setFlash('error', 'Certificate not found.');
            $response->redirect('/admin/certificates');
            return;
        }

        $recipientName = trim($request->get('recipient_name'));
        $courseName = trim($request->get('course_name'));
        $issueDate = $request->get('issue_date');
        $expiryDate = $request->get('expiry_date') ?: null;
        $gradeStatus = $request->get('grade_status', 'Certified');

        if (empty($recipientName) || empty($courseName) || empty($issueDate)) {
            $session->setFlash('error', 'Recipient name, course, and issue date are required.');
            $response->redirect('/admin/certificates/edit/' . $id);
            return;
        }

        $pdfPath = $certificate['pdf_path'];
        $file = $request->getFile('pdf_file');
        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['pdf', 'png', 'jpg', 'jpeg'])) {
                    $dir = PUBLIC_DIR . '/assets/uploads/certificates/';
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $filename = uniqid('cert_', true) . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                        $pdfPath = 'assets/uploads/certificates/' . $filename;
                    } else {
                        $session->setFlash('error', 'Failed to move uploaded file. Check directory permissions.');
                        $response->redirect('/admin/certificates/edit/' . $id);
                        return;
                    }
                } else {
                    $session->setFlash('error', 'Only PDF, PNG, or JPG files are allowed.');
                    $response->redirect('/admin/certificates/edit/' . $id);
                    return;
                }
            } else {
                $session->setFlash('error', 'File upload error: ' . $file['error']);
                $response->redirect('/admin/certificates/edit/' . $id);
                return;
            }
        }

        Certificate::update($id, [
            'recipient_name' => $recipientName,
            'course_name' => $courseName,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'grade_status' => $gradeStatus,
            'pdf_path' => $pdfPath
        ]);

        AuditLog::log(current_user()['id'], 'Update Certificate', "Modified certificate ID $id ($recipientName).");
        $session->setFlash('success', 'Trainee certificate updated successfully.');
        $response->redirect('/admin/certificates');
    }

    public function certificateDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $certificate = Certificate::find($id);
        $session = new Session();

        if ($certificate) {
            Certificate::delete($id);
            AuditLog::log(current_user()['id'], 'Delete Certificate', "Deleted certificate: " . $certificate['certificate_number']);
            $session->setFlash('success', 'Certificate deleted successfully.');
        }

        $response->redirect('/admin/certificates');
    }

    // --- Dynamic CMS Page Contents CMS ---

    public function cmsPages(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $contents = Project::query("SELECT * FROM `page_contents` ORDER BY page_key ASC, section_key ASC");
        
        // Group by page_key
        $grouped = [];
        foreach ($contents as $row) {
            $grouped[$row['page_key']][] = $row;
        }

        return $this->render('admin/cms_pages', [
            'title' => 'Static Page Contents CMS Editor - ISEC',
            'grouped_contents' => $grouped
        ]);
    }

    public function cmsPagesUpdate(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();

        $contentValues = $request->get('content_values');
        
        if (is_array($contentValues)) {
            $db = Project::getDb();
            $stmt = $db->prepare("UPDATE `page_contents` SET `content_value` = :val WHERE `id` = :id");
            
            foreach ($contentValues as $id => $val) {
                $stmt->execute([
                    'val' => $val,
                    'id' => (int)$id
                ]);
            }
            
            AuditLog::log(current_user()['id'], 'Update CMS Page Content', 'Dynamic text blocks across web pages modified.');
            $session->setFlash('success', 'Page contents updated successfully.');
        }

        $response->redirect('/admin/cms-pages');
    }

    // --- Leadership Team CRUD ---

    public function team(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $team = Team::query("SELECT * FROM `team` ORDER BY display_order ASC, id DESC");
        
        return $this->render('admin/team/index', [
            'title' => 'Manage Leadership Team - ISEC CMS',
            'team' => $team
        ]);
    }

    public function teamCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        return $this->render('admin/team/create', [
            'title' => 'Add Board Member - ISEC CMS'
        ]);
    }

    public function teamStore(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();

        $name = trim($request->get('name'));
        $position = trim($request->get('position'));
        $bio = trim($request->get('bio'));
        $displayOrder = (int)$request->get('display_order', 0);
        $status = $request->get('status', 'active');

        if (empty($name) || empty($position)) {
            $session->setFlash('error', 'Name and position are required fields.');
            $response->redirect('/admin/team/create');
            return;
        }

        // Handle profile image upload
        $imagePath = 'team_placeholder.jpg';
        $file = $request->getFile('image');
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $dir = PUBLIC_DIR . '/assets/uploads/team/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = uniqid('team_', true) . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                    $imagePath = $filename;
                }
            }
        }

        // Map social media links
        $social = [
            'linkedin' => trim($request->get('linkedin', '')),
            'twitter' => trim($request->get('twitter', ''))
        ];

        Team::create([
            'name' => $name,
            'position' => $position,
            'bio' => $bio,
            'image' => $imagePath,
            'social_links' => json_encode($social),
            'display_order' => $displayOrder,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Add Team Member', "Added $name ($position) to the leadership board.");
        $session->setFlash('success', 'Leadership board member added successfully.');
        $response->redirect('/admin/team');
    }

    public function teamEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $member = Team::find($id);

        if (!$member) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        // Parse social links
        $social = json_decode($member['social_links'] ?? '', true) ?: ['linkedin' => '', 'twitter' => ''];

        return $this->render('admin/team/edit', [
            'title' => 'Edit Board Member - ISEC CMS',
            'member' => $member,
            'social' => $social
        ]);
    }

    public function teamUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $member = Team::find($id);
        $session = new Session();

        if (!$member) {
            $session->setFlash('error', 'Board member not found.');
            $response->redirect('/admin/team');
            return;
        }

        $name = trim($request->get('name'));
        $position = trim($request->get('position'));
        $bio = trim($request->get('bio'));
        $displayOrder = (int)$request->get('display_order', 0);
        $status = $request->get('status', 'active');

        if (empty($name) || empty($position)) {
            $session->setFlash('error', 'Name and position are required fields.');
            $response->redirect('/admin/team/edit/' . $id);
            return;
        }

        $imagePath = $member['image'];
        $file = $request->getFile('image');
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $dir = PUBLIC_DIR . '/assets/uploads/team/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = uniqid('team_', true) . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                    $imagePath = $filename;
                }
            }
        }

        $social = [
            'linkedin' => trim($request->get('linkedin', '')),
            'twitter' => trim($request->get('twitter', ''))
        ];

        Team::update($id, [
            'name' => $name,
            'position' => $position,
            'bio' => $bio,
            'image' => $imagePath,
            'social_links' => json_encode($social),
            'display_order' => $displayOrder,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Update Team Member', "Modified details for team member ID $id ($name).");
        $session->setFlash('success', 'Leadership board member updated successfully.');
        $response->redirect('/admin/team');
    }

    public function teamDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        $member = Team::find($id);
        $session = new Session();

        if ($member) {
            Team::delete($id);
            AuditLog::log(current_user()['id'], 'Delete Team Member', "Removed team member: " . $member['name']);
            $session->setFlash('success', 'Board member removed successfully.');
        }

        $response->redirect('/admin/team');
    }

    // --- Administrative Users CRUD ---

    public function users(Request $request, Response $response): string {
        $this->checkPermission('manage_users');
        
        $users = User::query("SELECT u.*, r.name as role_name 
                              FROM `users` u 
                              JOIN `roles` r ON u.role_id = r.id 
                              ORDER BY u.id DESC");
                              
        return $this->render('admin/users/index', [
            'title' => 'Administrative Users Manager - ISEC CMS',
            'users' => $users
        ]);
    }

    public function userCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_users');
        
        $roles = User::query("SELECT * FROM `roles` ORDER BY name ASC");
        
        return $this->render('admin/users/create', [
            'title' => 'Register New User - ISEC CMS',
            'roles' => $roles
        ]);
    }

    public function userStore(Request $request, Response $response): void {
        $this->checkPermission('manage_users');
        $session = new Session();

        $name = trim($request->get('name'));
        $email = trim($request->get('email'));
        $password = trim($request->get('password'));
        $roleId = (int)$request->get('role_id');
        $status = $request->get('status', 'active');

        if (empty($name) || empty($email) || empty($password) || empty($roleId)) {
            $session->setFlash('error', 'All fields are required.');
            $response->redirect('/admin/users/create');
            return;
        }

        // Validate unique email
        $existing = User::findByEmail($email);
        if ($existing) {
            $session->setFlash('error', 'A user with this email address already exists.');
            $response->redirect('/admin/users/create');
            return;
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash,
            'role_id' => $roleId,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Create User Account', "Created credentials for $name ($email).");
        $session->setFlash('success', 'User account created successfully.');
        $response->redirect('/admin/users');
    }

    public function userEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_users');
        $id = (int)($params['id'] ?? 0);
        $user = User::find($id);

        if (!$user) {
            $response->setStatusCode(404);
            return $this->render('errors/404');
        }

        $roles = User::query("SELECT * FROM `roles` ORDER BY name ASC");

        return $this->render('admin/users/edit', [
            'title' => 'Edit User Account - ISEC CMS',
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function userUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_users');
        $id = (int)($params['id'] ?? 0);
        $user = User::find($id);
        $session = new Session();

        if (!$user) {
            $session->setFlash('error', 'User not found.');
            $response->redirect('/admin/users');
            return;
        }

        $name = trim($request->get('name'));
        $email = trim($request->get('email'));
        $password = trim($request->get('password'));
        $roleId = (int)$request->get('role_id');
        $status = $request->get('status', 'active');

        if (empty($name) || empty($email) || empty($roleId)) {
            $session->setFlash('error', 'Name, email, and role are required fields.');
            $response->redirect('/admin/users/edit/' . $id);
            return;
        }

        // Validate unique email (excluding current user)
        $existing = User::findByEmail($email);
        if ($existing && (int)$existing['id'] !== $id) {
            $session->setFlash('error', 'This email address is already in use by another user.');
            $response->redirect('/admin/users/edit/' . $id);
            return;
        }

        $updateData = [
            'name' => $name,
            'email' => $email,
            'role_id' => $roleId,
            'status' => $status
        ];

        // Update password if a new one is provided
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        User::update($id, $updateData);

        AuditLog::log(current_user()['id'], 'Update User Account', "Modified credentials for $name ($email).");
        $session->setFlash('success', 'User account updated successfully.');
        $response->redirect('/admin/users');
    }

    public function userDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_users');
        $id = (int)($params['id'] ?? 0);
        $session = new Session();

        // Prevent self-deletion
        if ($id === (int)current_user()['id']) {
            $session->setFlash('error', 'Self-deletion is forbidden. You cannot delete your own active session.');
            $response->redirect('/admin/users');
            return;
        }

        $user = User::find($id);
        if ($user) {
            User::delete($id);
            AuditLog::log(current_user()['id'], 'Delete User Account', "Removed account for: " . $user['name'] . " (" . $user['email'] . ")");
            $session->setFlash('success', 'User account deleted successfully.');
        }

        $response->redirect('/admin/users');
    }

    // --- Dynamic Pages CRUD ---

    public function dynamicPages(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        
        $pages = \App\Models\SitePage::query("SELECT * FROM `dynamic_pages` ORDER BY id DESC");
        
        return $this->render('admin/dynamic_pages/index', [
            'title' => 'Manage Dynamic Pages - ISEC CMS',
            'pages' => $pages
        ]);
    }

    public function dynamicPageCreate(Request $request, Response $response): string {
        $this->checkPermission('manage_settings');
        return $this->render('admin/dynamic_pages/create', [
            'title' => 'Create New Page - ISEC CMS'
        ]);
    }

    public function dynamicPageStore(Request $request, Response $response): void {
        $this->checkPermission('manage_settings');
        $session = new Session();

        $title = trim($request->get('title'));
        $content = trim($request->get('content'));
        $status = $request->get('status') === 'published' ? 'published' : 'draft';

        if (empty($title)) {
            $session->setFlash('error', 'Page title is required.');
            $response->redirect('/admin/dynamic-pages/create');
            return;
        }

        $slug = \App\Core\Helpers::generateSlug($title);
        
        // Ensure unique slug
        $existing = \App\Models\SitePage::query("SELECT id FROM dynamic_pages WHERE slug = :slug", ['slug' => $slug]);
        if (count($existing) > 0) {
            $slug = $slug . '-' . time();
        }

        $id = \App\Models\SitePage::create([
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => $status
        ]);

        if ($id) {
            AuditLog::log(current_user()['id'], 'Create Dynamic Page', "Created page: $title");
            $session->setFlash('success', 'Page created successfully.');
        } else {
            $session->setFlash('error', 'Failed to create page.');
        }

        $response->redirect('/admin/dynamic-pages');
    }

    public function dynamicPageEdit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_settings');
        $id = (int)($params['id'] ?? 0);
        
        $page = \App\Models\SitePage::find($id);
        
        if (!$page) {
            (new Session())->setFlash('error', 'Page not found.');
            $response->redirect('/admin/dynamic-pages');
            return '';
        }

        return $this->render('admin/dynamic_pages/edit', [
            'title' => 'Edit Page - ISEC CMS',
            'page' => $page
        ]);
    }

    public function dynamicPageUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $session = new Session();
        $id = (int)($params['id'] ?? 0);
        
        $page = \App\Models\SitePage::find($id);
        if (!$page) {
            $session->setFlash('error', 'Page not found.');
            $response->redirect('/admin/dynamic-pages');
            return;
        }

        $title = trim($request->get('title'));
        $content = trim($request->get('content'));
        $status = $request->get('status') === 'published' ? 'published' : 'draft';

        if (empty($title)) {
            $session->setFlash('error', 'Page title is required.');
            $response->redirect("/admin/dynamic-pages/$id/edit");
            return;
        }

        $slug = \App\Core\Helpers::generateSlug($title);
        
        // Ensure unique slug
        $existing = \App\Models\SitePage::query("SELECT id FROM dynamic_pages WHERE slug = :slug AND id != :id", ['slug' => $slug, 'id' => $id]);
        if (count($existing) > 0) {
            $slug = $slug . '-' . time();
        }

        \App\Models\SitePage::update($id, [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => $status
        ]);

        AuditLog::log(current_user()['id'], 'Update Dynamic Page', "Updated page: $title");
        $session->setFlash('success', 'Page updated successfully.');
        $response->redirect('/admin/dynamic-pages');
    }

    public function dynamicPageDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_settings');
        $session = new Session();
        $id = (int)($params['id'] ?? 0);
        
        $page = \App\Models\SitePage::find($id);
        if ($page) {
            \App\Models\SitePage::delete($id);
            AuditLog::log(current_user()['id'], 'Delete Dynamic Page', "Deleted page: " . $page['title']);
            $session->setFlash('success', 'Page deleted successfully.');
        }

        $response->redirect('/admin/dynamic-pages');
    }

    // ==========================================
    // PAYMENTS
    // ==========================================
    public function payments(Request $request, Response $response): string {
        // Assuming admin can view payments if they can manage users or settings.
        if (!has_permission('manage_users') && !has_permission('manage_settings')) {
            $this->checkPermission('manage_settings');
        }
        
        $db = \App\Models\Payment::getDB();
        $stmt = $db->query("SELECT * FROM payments ORDER BY id DESC");
        $payments = $stmt->fetchAll();

        return $this->render('admin/payments/index', [
            'title' => 'Payment Transactions',
            'payments' => $payments
        ]);
    }
}
