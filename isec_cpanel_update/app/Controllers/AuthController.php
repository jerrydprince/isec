<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\User;
use App\Models\AuditLog;

/**
 * Handles Authentication actions
 */
class AuthController extends Controller {
    
    public function __construct() {
        $this->setLayout('auth');
    }

    /**
     * Render Login page
     */
    public function login(Request $request, Response $response): string {
        $session = new Session();
        if ($session->get('user')) {
            $response->redirect('/admin');
        }
        return $this->render('auth/login', [
            'title' => 'Sign In - ISEC CMS Administration'
        ]);
    }

    /**
     * Authenticate form submission credentials
     */
    public function authenticate(Request $request, Response $response): void {
        $email = $request->get('email');
        $password = $request->get('password');
        
        $session = new Session();
        
        if (empty($email) || empty($password)) {
            $session->setFlash('error', 'Please fill in all credentials fields.');
            $response->redirect('/admin/login');
        }

        $user = User::findByEmail($email);

        if ($user && $user['status'] === 'active' && password_verify($password, $user['password'])) {
            // Strip password from stored session profile
            unset($user['password']);
            
            // Set User Session
            $session->set('user', $user);
            
            // Write Audit Log
            AuditLog::log($user['id'], 'User login', 'User logged in successfully via web panel.');
            
            $session->setFlash('success', 'Welcome back, ' . $e = $user['name'] . '!');
            $response->redirect('/admin');
        }

        // Write Audit Log for failed attempt
        AuditLog::log(null, 'Failed login attempt', 'Failed login try targeting: ' . $email);

        $session->setFlash('error', 'Invalid email address or password.');
        $response->redirect('/admin/login');
    }

    /**
     * Secure Logout
     */
    public function logout(Request $request, Response $response): void {
        $session = new Session();
        $user = $session->get('user');
        
        if ($user) {
            AuditLog::log($user['id'], 'User logout', 'User logged out securely.');
        }
        
        $session->destroy();
        
        // Re-open session briefly to set final logged-out flash message
        $newSession = new Session();
        $newSession->setFlash('success', 'You have been successfully logged out.');
        
        $response->redirect('/admin/login');
    }
}
