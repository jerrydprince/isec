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
        if (headers_sent($file, $line)) {
            echo "<div style='padding:20px; font-family:sans-serif; text-align:center;'>";
            echo "<p style='color:red; font-weight:bold;'>Debug: Headers already sent in $file on line $line. A background error or whitespace prevented automatic redirect.</p>";
            echo "<p>If you are not redirected automatically, <a href='".htmlspecialchars($url)."' style='color:blue; text-decoration:underline;'>click here to continue</a>.</p>";
            echo "</div>";
            echo "<script>setTimeout(function() { window.location.href = '" . addslashes($url) . "'; }, 3000);</script>";
            echo "<noscript><meta http-equiv='refresh' content='3;url=" . htmlspecialchars($url) . "'></noscript>";
        } else {
            header("Location: " . $url);
        }
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
