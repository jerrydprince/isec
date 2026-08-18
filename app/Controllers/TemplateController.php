<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\MessageTemplate;
use App\Models\AuditLog;

/**
 * Handles Message Templates for Email, SMS, WhatsApp
 */
class TemplateController extends AdminController {

    public function index(Request $request, Response $response): string {
        $this->checkPermission('manage_messages');
        
        $type = $request->get('type');
        
        $query = "SELECT * FROM message_templates";
        $params = [];
        
        if ($type) {
            $query .= " WHERE type = :type";
            $params['type'] = $type;
        }
        
        $query .= " ORDER BY created_at DESC";
        $templates = MessageTemplate::query($query, $params);
        
        return $this->render('admin/templates/index', [
            'title' => 'Message Templates',
            'templates' => $templates,
            'currentType' => $type
        ], 'layouts/admin');
    }

    public function create(Request $request, Response $response): string {
        $this->checkPermission('manage_messages');
        return $this->render('admin/templates/form', [
            'title' => 'Create Template',
            'template' => null
        ], 'layouts/admin');
    }

    public function store(Request $request, Response $response): void {
        $this->checkPermission('manage_messages');
        $session = new Session();
        
        $name = trim($request->get('name'));
        $type = $request->get('type');
        $subject = trim($request->get('subject'));
        $body = trim($request->get('body'));
        
        if (empty($name) || empty($type) || empty($body)) {
            $session->setFlash('error', 'Name, Type, and Body are required fields.');
            $response->redirect('/admin/templates/create');
            return;
        }
        
        MessageTemplate::create([
            'name' => $name,
            'type' => $type,
            'subject' => $type === 'Email' ? $subject : null,
            'body' => $body
        ]);
        
        AuditLog::log(current_user()['id'], 'Create Template', "Created $type template: $name");
        $session->setFlash('success', 'Template created successfully.');
        $response->redirect('/admin/templates');
    }

    public function edit(Request $request, Response $response, array $params): string {
        $this->checkPermission('manage_messages');
        $id = (int)($params['id'] ?? 0);
        
        $template = MessageTemplate::find($id);
        if (!$template) {
            $session = new Session();
            $session->setFlash('error', 'Template not found.');
            $response->redirect('/admin/templates');
        }
        
        return $this->render('admin/templates/form', [
            'title' => 'Edit Template',
            'template' => $template
        ], 'layouts/admin');
    }

    public function update(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_messages');
        $session = new Session();
        $id = (int)($params['id'] ?? 0);
        
        $template = MessageTemplate::find($id);
        if (!$template) {
            $session->setFlash('error', 'Template not found.');
            $response->redirect('/admin/templates');
            return;
        }
        
        $name = trim($request->get('name'));
        $type = $request->get('type');
        $subject = trim($request->get('subject'));
        $body = trim($request->get('body'));
        
        if (empty($name) || empty($type) || empty($body)) {
            $session->setFlash('error', 'Name, Type, and Body are required fields.');
            $response->redirect("/admin/templates/$id/edit");
            return;
        }
        
        MessageTemplate::update($id, [
            'name' => $name,
            'type' => $type,
            'subject' => $type === 'Email' ? $subject : null,
            'body' => $body
        ]);
        
        AuditLog::log(current_user()['id'], 'Update Template', "Updated template: $name");
        $session->setFlash('success', 'Template updated successfully.');
        $response->redirect('/admin/templates');
    }

    public function delete(Request $request, Response $response, array $params): void {
        $this->checkPermission('manage_messages');
        $session = new Session();
        $id = (int)($params['id'] ?? 0);
        
        $template = MessageTemplate::find($id);
        if ($template) {
            MessageTemplate::delete($id);
            AuditLog::log(current_user()['id'], 'Delete Template', "Deleted template: " . $template['name']);
            $session->setFlash('success', 'Template deleted successfully.');
        }
        
        $response->redirect('/admin/templates');
    }
}
