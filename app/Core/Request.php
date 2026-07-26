<?php

namespace App\Core;

/**
 * Encapsulates HTTP Requests & Inputs
 */
class Request {
    /**
     * Get the routing path (strips query strings & dynamic subdirectories)
     */
    public function getPath(): string {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Strip query parameters
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        // Auto-detect and strip subfolders (e.g. /isec/public/)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = str_replace('/index.php', '', $scriptName);

        if ($basePath !== '' && strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        $path = '/' . trim($path, '/');
        return $path === '' ? '/' : $path;
    }

    /**
     * Get request method (GET, POST, etc.)
     */
    public function getMethod(): string {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function isGet(): bool {
        return $this->getMethod() === 'GET';
    }

    public function isPost(): bool {
        return $this->getMethod() === 'POST';
    }

    /**
     * Retrieve and sanitize input body params
     */
    public function getBody(): array {
        $body = [];
        
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = $this->sanitize($value);
            }
        }
        
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = $this->sanitize($value);
            }
        }
        
        return $body;
    }

    /**
     * Retrieve a specific input parameter
     */
    public function get(string $key, $default = null): mixed {
        $body = $this->getBody();
        return $body[$key] ?? $default;
    }

    /**
     * Handle files uploaded
     */
    public function getFiles(): array {
        return $_FILES;
    }

    public function getFile(string $key): ?array {
        return $_FILES[$key] ?? null;
    }

    /**
     * Internal input sanitization
     */
    private function sanitize(mixed $value): mixed {
        if (is_array($value)) {
            return array_map([$this, 'sanitize'], $value);
        }
        return htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
    }
}
