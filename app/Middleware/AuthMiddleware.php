<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

/**
 * Ensures user is authenticated before proceeding
 */
class AuthMiddleware extends Middleware {
    public function execute(Request $request, Response $response): void {
        $session = new Session();
        if (!$session->get('user')) {
            $session->setFlash('error', 'Authentication required. Please login.');
            $response->redirect('/admin/login');
        }
    }
}
