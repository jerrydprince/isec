<?php

namespace App\Core;

/**
 * Encapsulates HTTP Responses
 */
class Response {
    /**
     * Set HTTP status code
     */
    public function setStatusCode(int $code): void {
        http_response_code($code);
    }

    /**
     * Redirect to another URL (automatically prepends base path if absolute path is not specified)
     */
    public function redirect(string $url): void {
        // If the URL starts with / (but not //), append the BASE_URL to prevent redirect breaking on subfolders
        if (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
            $url = BASE_URL . $url;
        }
        header("Location: " . $url);
        exit;
    }

    /**
     * Respond with JSON content
     */
    public function json(array $data, int $statusCode = 200): void {
        $this->setStatusCode($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}
