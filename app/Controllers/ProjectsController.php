<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Project;

/**
 * Handles Portfolio Projects Public Directory & Detail Case Studies
 */
class ProjectsController extends Controller {
    /**
     * Portfolio Grid Listing
     */
    public function index(Request $request, Response $response): string {
        $categorySlug = $request->get('category');
        
        $projects = Project::getAllPublished($categorySlug);
        $categories = Project::query("SELECT * FROM project_categories ORDER BY name ASC");
        
        return $this->render('projects/index', [
            'title' => 'Executed Consulting Projects & Case Studies',
            'projects' => $projects,
            'categories' => $categories,
            'selected_category' => $categorySlug
        ]);
    }

    /**
     * Case Study Detail Page
     */
    public function show(Request $request, Response $response, array $params): string {
        $slug = $params['slug'] ?? '';
        $project = Project::getBySlugWithCategory($slug);

        if (!$project || $project['status'] !== 'published') {
            $response->setStatusCode(404);
            return $this->render('errors/404', ['title' => 'Case Study Not Found']);
        }

        // Fetch related projects from the same category
        $related = Project::query(
            "SELECT p.*, pc.name as category_name 
             FROM projects p 
             JOIN project_categories pc ON p.category_id = pc.id 
             WHERE p.status = 'published' AND p.category_id = :catId AND p.id != :projId 
             LIMIT 3",
            [
                'catId' => $project['category_id'],
                'projId' => $project['id']
            ]
        );

        return $this->render('projects/show', [
            'title' => $project['title'] . ' - ISEC Case Study',
            'project' => $project,
            'related_projects' => $related
        ]);
    }
}
