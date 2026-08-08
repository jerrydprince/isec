<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;

/**
 * Restricts access to users with the 'Admin' role only
 */
class AdminOnlyMiddleware extends Middleware {
    public function execute(Request $request, Response $response): void {
        $session = new Session();
        $user = $session->get('user');
        
        if (!$user || $user['role_name'] !== 'Admin') {
            $response->setStatusCode(403);
            View::render('errors/403', ['title' => 'Forbidden Access']);
            exit;
        }
    }
}
