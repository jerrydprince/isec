<?php

use App\Core\Session;

/**
 * Dynamic URL generator
 */
if (!function_exists('url')) {
    function url(string $path = ''): string {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

/**
 * Asset URL helper
 */
if (!function_exists('asset')) {
    function asset(string $path = ''): string {
        return ASSET_URL . '/' . ltrim($path, '/');
    }
}

/**
 * Escapes HTML to protect against XSS
 */
if (!function_exists('e')) {
    function e(?string $string): string {
        return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8', false);
    }
}

/**
 * Get or generate CSRF token from Session
 */
if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        $session = new Session();
        $token = $session->get('csrf_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $session->set('csrf_token', $token);
        }
        return $token;
    }
}

/**
 * Generate CSRF hidden input field
 */
if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
}

/**
 * Get the current logged-in user
 */
if (!function_exists('current_user')) {
    function current_user(): ?array {
        $session = new Session();
        return $session->get('user');
    }
}

/**
 * Check if the current user has a specific permission
 */
if (!function_exists('has_permission')) {
    function has_permission(string $permission): bool {
        $user = current_user();
        if (!$user) {
            return false;
        }
        // If Admin, bypass check
        if ($user['role_name'] === 'Admin') {
            return true;
        }
        
        $permissions = $user['permissions'] ?? [];
        return in_array($permission, $permissions);
    }
}

/**
 * Dump and Die (for development debugging)
 */
if (!function_exists('dd')) {
    function dd(mixed $data): void {
        echo "<pre style='background: #0f172a; color: #38bdf8; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 13px; overflow: auto; max-height: 500px;'>";
        var_dump($data);
        echo "</pre>";
        exit;
    }
}

/**
 * Extract word-limited excerpt from text
 */
if (!function_exists('excerpt')) {
    function excerpt(string $text, int $limit = 20, string $end = '...'): string {
        $text = strip_tags($text);
        $words = explode(' ', $text);
        if (count($words) > $limit) {
            return implode(' ', array_slice($words, 0, $limit)) . $end;
        }
        return $text;
    }
}

/**
 * Decodes MIME-encoded headers (e.g. subjects, sender names)
 */
if (!function_exists('decode_mime_header')) {
    function decode_mime_header(?string $str): string {
        if (!$str) {
            return '';
        }
        if (strpos($str, '=?') === false) {
            return $str;
        }
        if (function_exists('iconv_mime_decode')) {
            return iconv_mime_decode($str, 0, 'UTF-8') ?: $str;
        }
        if (function_exists('mb_decode_mimeheader')) {
            return mb_decode_mimeheader($str);
        }
        if (function_exists('imap_mime_header_decode')) {
            $elements = imap_mime_header_decode($str);
            if ($elements) {
                $decoded = '';
                foreach ($elements as $element) {
                    $decoded .= $element->text;
                }
                return $decoded;
            }
        }
        return $str;
    }
}

/**
 * Fetch dynamic page content blocks from the database
 */
if (!function_exists('page_content')) {
    function page_content(string $pageKey, string $sectionKey, string $default = ''): string {
        static $cachedContents = null;
        
        if ($cachedContents === null) {
            $cachedContents = [];
            try {
                $db = \App\Core\Model::getDb();
                $stmt = $db->query("SELECT page_key, section_key, content_value FROM `page_contents`");
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $cachedContents[$row['page_key']][$row['section_key']] = $row['content_value'];
                }
            } catch (\Exception $e) {
                return $default;
            }
        }
        
        return $cachedContents[$pageKey][$sectionKey] ?? $default;
    }
}

/**
 * Fetch dynamic site settings from database
 */
if (!function_exists('settings')) {
    function settings(string $key, string $default = ''): string {
        return \App\Models\Settings::get($key, $default);
    }
}
