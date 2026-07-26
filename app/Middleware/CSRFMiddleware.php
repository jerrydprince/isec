<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;

/**
 * Validates CSRF tokens on POST requests
 */
class CSRFMiddleware extends Middleware {
    public function execute(Request $request, Response $response): void {
        if ($request->isPost()) {
            $session = new Session();
            $token = $request->get('csrf_token') ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            
            if (!$token || $token !== $session->get('csrf_token')) {
                $response->setStatusCode(403);
                View::render('errors/403', ['title' => 'CSRF Verification Failed']);
                exit;
            }
        }
    }
}
