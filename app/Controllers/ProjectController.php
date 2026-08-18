<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Payment;
use App\Helpers\Mailer;

class ProjectController extends AdminController {

    public function index(Request $request, Response $response): string {
        $this->checkPermission('manage_invoices'); // Adjust permission later if needed
        $db = Payment::getDB();
        
        $projects = $db->query("SELECT p.*, c.name as customer_name,
            (SELECT COUNT(id) FROM project_tasks WHERE project_id = p.id) as total_tasks,
            (SELECT COUNT(id) FROM project_tasks WHERE project_id = p.id AND status = 'Completed') as completed_tasks
            FROM projects p 
            LEFT JOIN customers c ON p.customer_id = c.id 
            ORDER BY p.created_at DESC")->fetchAll();
            
        return $this->render('admin/project-management/index', [
            'title' => 'Project Management',
            'projects' => $projects
        ]);
    }

    public function create(Request $request, Response $response): string {
        $this->checkPermission('manage_invoices');
        $db = Payment::getDB();
        $customers = $db->query("SELECT id, name FROM customers ORDER BY name ASC")->fetchAll();
        
        return $this->render('admin/project-management/form', [
            'title' => 'New Project',
            'customers' => $customers,
            'project' => null
        ]);
    }

    public function store(Request $request, Response $response): void {
        $this->checkPermission('manage_invoices');
        $session = new \App\Core\Session();
        
        $name = trim($request->get('name'));
        $description = $request->get('description');
        $customer_id = $request->get('customer_id') ?: null;
        $status = $request->get('status') ?: 'Not Started';
        $start_date = $request->get('start_date') ?: null;
        $due_date = $request->get('due_date') ?: null;
        $budget = $request->get('budget') ?: 0;
        
        if (empty($name)) {
            $session->setFlash('error', 'Project name is required.');
            $response->redirect('/admin/project-management/create');
            return;
        }

        $db = Payment::getDB();
        $stmt = $db->prepare("INSERT INTO projects (name, description, customer_id, status, start_date, due_date, budget) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $customer_id, $status, $start_date, $due_date, $budget]);
        
        $session->setFlash('success', 'Project created successfully.');
        $response->redirect('/admin/project-management');
    }

    public function view(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_invoices');
        $id = $params['id'];
        $db = Payment::getDB();
        
        $project = $db->prepare("SELECT p.*, c.name as customer_name, c.email as customer_email 
            FROM projects p 
            LEFT JOIN customers c ON p.customer_id = c.id 
            WHERE p.id = ?");
        $project->execute([$id]);
        $project = $project->fetch();

        if (!$project) {
            $session = new \App\Core\Session();
            $session->setFlash('error', 'Project not found.');
            $response->redirect('/admin/project-management');
            return "";
        }

        $tasks = $db->prepare("SELECT * FROM project_tasks WHERE project_id = ? ORDER BY due_date ASC");
        $tasks->execute([$id]);
        $tasks = $tasks->fetchAll();
        
        $timeLogs = $db->prepare("SELECT l.*, t.title as task_title, u.name as user_name 
            FROM project_time_logs l 
            LEFT JOIN project_tasks t ON l.task_id = t.id
            LEFT JOIN users u ON l.user_id = u.id
            WHERE l.project_id = ? ORDER BY l.date_logged DESC, l.created_at DESC");
        $timeLogs->execute([$id]);
        $timeLogs = $timeLogs->fetchAll();

        $files = $db->prepare("SELECT f.*, u.name as uploader_name 
            FROM project_files f 
            LEFT JOIN users u ON f.uploaded_by = u.id 
            WHERE f.project_id = ? ORDER BY f.created_at DESC");
        $files->execute([$id]);
        $files = $files->fetchAll();
        
        // Invoices linked to this project or customer
        $invoices = $db->prepare("SELECT * FROM invoices WHERE project_id = ? ORDER BY created_at DESC");
        $invoices->execute([$id]);
        $invoices = $invoices->fetchAll();

        return $this->render('admin/project-management/view', [
            'title' => $project['name'] . ' - Project Details',
            'project' => $project,
            'tasks' => $tasks,
            'timeLogs' => $timeLogs,
            'files' => $files,
            'invoices' => $invoices
        ]);
    }

    public function edit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_invoices');
        $id = $params['id'];
        $db = Payment::getDB();
        
        $project = $db->prepare("SELECT * FROM projects WHERE id = ?");
        $project->execute([$id]);
        $project = $project->fetch();
        
        if (!$project) {
            $response->redirect('/admin/project-management');
            return "";
        }
        
        $customers = $db->query("SELECT id, name FROM customers ORDER BY name ASC")->fetchAll();
        
        return $this->render('admin/project-management/form', [
            'title' => 'Edit Project',
            'project' => $project,
            'customers' => $customers
        ]);
    }

    public function update(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $session = new \App\Core\Session();
        $id = $params['id'];
        
        $name = trim($request->get('name'));
        $description = $request->get('description');
        $customer_id = $request->get('customer_id') ?: null;
        $status = $request->get('status') ?: 'Not Started';
        $start_date = $request->get('start_date') ?: null;
        $due_date = $request->get('due_date') ?: null;
        $budget = $request->get('budget') ?: 0;
        
        if (empty($name)) {
            $session->setFlash('error', 'Project name is required.');
            $response->redirect("/admin/project-management/edit/$id");
            return;
        }

        $db = Payment::getDB();
        
        $oldProject = $db->prepare("SELECT p.status, c.email FROM projects p LEFT JOIN customers c ON p.customer_id = c.id WHERE p.id = ?");
        $oldProject->execute([$id]);
        $oldProjectData = $oldProject->fetch();
        
        $stmt = $db->prepare("UPDATE projects SET name=?, description=?, customer_id=?, status=?, start_date=?, due_date=?, budget=? WHERE id=?");
        $stmt->execute([$name, $description, $customer_id, $status, $start_date, $due_date, $budget, $id]);
        
        // Notify client if project status changed to Completed
        if ($oldProjectData && $oldProjectData['status'] !== 'Completed' && $status === 'Completed' && !empty($oldProjectData['email'])) {
            try {
                $html = "<div style='font-family:sans-serif; max-width:600px; margin:0 auto; padding:20px;'>
                    <h2 style='color:#16a34a;'>Project Completed!</h2>
                    <p>Great news! Your project <b>{$name}</b> has been marked as Completed by our team.</p>
                    <p>If you have any questions or require final handover documents, please let us know.</p>
                    <p>Thank you for choosing ISEC Limited.</p>
                </div>";
                Mailer::send('info@isecltd.ng', $oldProjectData['email'], "Project Completed: {$name}", $html, 'ISEC Limited');
            } catch (\Throwable $e) {}
        }
        
        $session->setFlash('success', 'Project updated successfully.');
        $response->redirect("/admin/project-management/view/$id");
    }

    public function delete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $db = Payment::getDB();
        $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$params['id']]);
        
        $session = new \App\Core\Session();
        $session->setFlash('success', 'Project deleted successfully.');
        $response->redirect('/admin/project-management');
    }

    // --- TASK MANAGEMENT ---
    
    public function taskStore(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $session = new \App\Core\Session();
        
        $title = trim($request->get('title'));
        $description = $request->get('description');
        $status = $request->get('status') ?: 'To Do';
        $priority = $request->get('priority') ?: 'Medium';
        $due_date = $request->get('due_date') ?: null;
        
        if (empty($title)) {
            $session->setFlash('error', 'Task title is required.');
            $response->redirect("/admin/project-management/view/$project_id");
            return;
        }

        $db = Payment::getDB();
        $stmt = $db->prepare("INSERT INTO project_tasks (project_id, title, description, status, priority, due_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$project_id, $title, $description, $status, $priority, $due_date]);
        
        $session->setFlash('success', 'Task added successfully.');
        $response->redirect("/admin/project-management/view/$project_id");
    }

    public function taskUpdate(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $task_id = $params['task_id'];
        $session = new \App\Core\Session();
        
        $title = trim($request->get('title'));
        $description = $request->get('description');
        $status = $request->get('status');
        $priority = $request->get('priority');
        $due_date = $request->get('due_date') ?: null;
        
        $db = Payment::getDB();
        $stmt = $db->prepare("UPDATE project_tasks SET title=?, description=?, status=?, priority=?, due_date=? WHERE id=? AND project_id=?");
        $stmt->execute([$title, $description, $status, $priority, $due_date, $task_id, $project_id]);
        
        $session->setFlash('success', 'Task updated successfully.');
        $response->redirect("/admin/project-management/view/$project_id");
    }

    public function taskStatus(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $task_id = $params['task_id'];
        $status = $request->get('status');
        
        $db = Payment::getDB();
        $db->prepare("UPDATE project_tasks SET status=? WHERE id=?")->execute([$status, $task_id]);
        
        // Notify client if task completed
        if ($status === 'Completed') {
            $project = $db->prepare("SELECT p.name, c.email FROM projects p LEFT JOIN customers c ON p.customer_id = c.id WHERE p.id = ?");
            $project->execute([$project_id]);
            $proj = $project->fetch();
            
            $taskData = $db->prepare("SELECT title FROM project_tasks WHERE id = ?");
            $taskData->execute([$task_id]);
            $taskTitle = $taskData->fetchColumn();

            if ($proj && !empty($proj['email'])) {
                try {
                    $html = "<div style='font-family:sans-serif; max-width:600px; margin:0 auto; padding:20px;'>
                        <h2 style='color:#2563eb;'>Project Progress Update</h2>
                        <p>Hello,</p>
                        <p>We wanted to let you know that a task has just been completed on your project <b>{$proj['name']}</b>.</p>
                        <p><b>Task Completed:</b> {$taskTitle}</p>
                        <p>Our team is hard at work! We will keep you updated.</p>
                    </div>";
                    Mailer::send('info@isecltd.ng', $proj['email'], "Task Completed - {$proj['name']}", $html, 'ISEC Limited');
                } catch (\Throwable $e) {}
            }
        }
        
        $session = new \App\Core\Session();
        $session->setFlash('success', 'Task status updated.');
        $response->redirect("/admin/project-management/view/$project_id");
    }

    public function taskDelete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $task_id = $params['task_id'];
        
        $db = Payment::getDB();
        $db->prepare("DELETE FROM project_tasks WHERE id=?")->execute([$task_id]);
        
        $session = new \App\Core\Session();
        $session->setFlash('success', 'Task deleted.');
        $response->redirect("/admin/project-management/view/$project_id");
    }

    // --- TIME TRACKING ---
    
    public function logTime(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $session = new \App\Core\Session();
        
        $task_id = $request->get('task_id') ?: null;
        $hours = (float)$request->get('hours');
        $date_logged = $request->get('date_logged');
        $notes = $request->get('notes');
        $user_id = current_user()['id'];
        
        if ($hours <= 0 || empty($date_logged)) {
            $session->setFlash('error', 'Valid hours and date are required.');
            $response->redirect("/admin/project-management/view/$project_id");
            return;
        }

        $db = Payment::getDB();
        $stmt = $db->prepare("INSERT INTO project_time_logs (project_id, task_id, user_id, hours, date_logged, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$project_id, $task_id, $user_id, $hours, $date_logged, $notes]);
        
        $session->setFlash('success', 'Time logged successfully.');
        $response->redirect("/admin/project-management/view/$project_id");
    }
    
    public function deleteTime(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $log_id = $params['log_id'];
        
        $db = Payment::getDB();
        $db->prepare("DELETE FROM project_time_logs WHERE id=?")->execute([$log_id]);
        
        $session = new \App\Core\Session();
        $session->setFlash('success', 'Time log deleted.');
        $response->redirect("/admin/project-management/view/$project_id");
    }

    // --- FILE ATTACHMENTS ---
    
    public function uploadFile(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $session = new \App\Core\Session();
        
        $uploadDir = __DIR__ . '/../../../public/uploads/projects/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file = $request->getFile('document');
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $session->setFlash('error', 'Please select a valid file to upload.');
            $response->redirect("/admin/project-management/view/$project_id");
            return;
        }

        $fileName = basename($file['name']);
        $fileSize = $file['size'];
        
        // Secure file name
        $safeFileName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $fileName);
        $uniqueName = uniqid() . '_' . $safeFileName;
        $destination = $uploadDir . $uniqueName;
        
        $publicPath = '/uploads/projects/' . $uniqueName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $db = Payment::getDB();
            $stmt = $db->prepare("INSERT INTO project_files (project_id, file_name, file_path, file_size, uploaded_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$project_id, $fileName, $publicPath, $fileSize, current_user()['id']]);
            
            $session->setFlash('success', 'File uploaded successfully.');
        } else {
            $session->setFlash('error', 'Failed to move uploaded file.');
        }

        $response->redirect("/admin/project-management/view/$project_id");
    }

    public function deleteFile(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_invoices');
        $project_id = $params['id'];
        $file_id = $params['file_id'];
        
        $db = Payment::getDB();
        $file = $db->prepare("SELECT file_path FROM project_files WHERE id=?");
        $file->execute([$file_id]);
        $fileData = $file->fetch();

        if ($fileData) {
            $fullPath = __DIR__ . '/../../../public' . $fileData['file_path'];
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            $db->prepare("DELETE FROM project_files WHERE id=?")->execute([$file_id]);
        }
        
        $session = new \App\Core\Session();
        $session->setFlash('success', 'File deleted.');
        $response->redirect("/admin/project-management/view/$project_id");
    }
}
