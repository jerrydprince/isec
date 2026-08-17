<?php

namespace App\Core;

/**
 * Custom Session and Flash Message Manager
 */
class Session {
    protected const FLASH_KEY = 'isec_flash';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            // Harden session configuration
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            
            // Set cookie security flags if on HTTPS
            $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                        (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') || 
                        (($_SERVER['SERVER_PORT'] ?? 80) == 443);
            if ($isSecure) {
                ini_set('session.cookie_secure', 1);
            }
            
            session_start();
        }

        // Flag existing flash messages to delete at request end
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$msg) {
            $msg['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Set a flash message for the next request
     */
    public function setFlash(string $key, string $message): void {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     * Retrieve a flash message
     */
    public function getFlash(string $key): ?string {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? null;
    }

    /**
     * Store key-value in session
     */
    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve session value
     */
    public function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Remove key from session
     */
    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy active session
     */
    public function destroy(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), 
                '', 
                time() - 42000,
                $params["path"], 
                $params["domain"],
                $params["secure"], 
                $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Housekeep flash messages, deleting those marked for removal
     */
    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $msg) {
            if ($msg['remove'] === true) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
