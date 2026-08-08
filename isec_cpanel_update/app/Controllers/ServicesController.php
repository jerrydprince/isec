<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Service;
use App\Models\Project;

/**
 * Handles Service Public Directory & Details
 */
class ServicesController extends Controller {
    /**
     * Services Catalog Listing
     */
    public function index(Request $request, Response $response): string {
        $services = Service::getPublished();
        return $this->render('services/index', [
            'title' => 'Consulting Expertise & Corporate Services',
            'services' => $services
        ]);
    }

    /**
     * Detailed Service Page
     */
    public function show(Request $request, Response $response, array $params): string {
        $slug = $params['slug'] ?? '';
        $service = Service::findBySlug($slug);

        if (!$service || $service['status'] !== 'published') {
            $response->setStatusCode(404);
            return $this->render('errors/404', ['title' => 'Service Not Found']);
        }

        // Fetch up to 3 related projects in the portfolio mapping
        $related = Project::query(
            "SELECT p.*, pc.name as category_name 
             FROM projects p 
             JOIN project_categories pc ON p.category_id = pc.id 
             WHERE p.status = 'published' AND (pc.name LIKE :serviceTitle OR p.technologies LIKE :tech) 
             LIMIT 3",
            [
                'serviceTitle' => '%' . $service['title'] . '%',
                'tech' => '%' . ($service['technologies'] ?? '') . '%'
            ]
        );

        $viewPath = dirname(__DIR__) . '/views/services/' . $slug . '.php';
        $viewName = file_exists($viewPath) ? 'services/' . $slug : 'services/show';

        return $this->render($viewName, [
            'title' => $service['title'] . ' - ISEC Consulting',
            'service' => $service,
            'related_projects' => $related
        ]);
    }
}
