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

/**
 * Parse article content for basic markdown images and paragraphs
 */
if (!function_exists('parse_article_content')) {
    function parse_article_content(?string $text): string {
        if (!$text) return '';
        
        // Convert Markdown Headers
        $text = preg_replace('/^### (.*?)$/m', '<h4>$1</h4>', $text);
        $text = preg_replace('/^## (.*?)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^# (.*?)$/m', '<h2>$1</h2>', $text);
        
        // Convert markdown images: ![alt](url)
        $text = preg_replace('/!\[(.*?)\]\((.*?)\)/', '<img src="$2" alt="$1" class="w-full h-auto rounded-xl shadow-md my-8">', $text);
        
        // Convert markdown links: [text](url)
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" class="text-accent hover:underline font-medium">$1</a>', $text);
        
        // Convert markdown bold and italic
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__(.*?)__/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.*?)_/', '<em>$1</em>', $text);
        
        // Convert list items
        $text = preg_replace('/^\s*[\-\*]\s+(.*)$/m', '<li>$1</li>', $text);
        // Wrap consecutive <li> elements in <ul>
        $text = preg_replace('/(<li>.*<\/li>(\n<li>.*<\/li>)*)/', '<ul class="list-disc pl-5 my-4 space-y-2">$1</ul>', $text);

        // If content already contains HTML block tags, assume it's HTML formatted.
        // Otherwise, wrap blocks in <p> tags.
        if (strpos($text, '<p>') === false && strpos($text, '<br>') === false && strpos($text, '<br/>') === false && strpos($text, '<h4>') === false && strpos($text, '<h3>') === false && strpos($text, '<h2>') === false && strpos($text, '<ul>') === false) {
            // Replace \r\n with \n
            $text = str_replace("\r\n", "\n", $text);
            // Replace double newlines with paragraph boundaries
            $text = '<p>' . preg_replace('/\n\s*\n/', '</p><p>', trim($text)) . '</p>';
            // Replace single newlines with <br> inside paragraphs (excluding ul/li areas)
            // It's safer to just let the markdown handle structure, but we add <br> for plain text
            $text = nl2br($text);
            // Remove empty paragraphs
            $text = str_replace('<p></p>', '', $text);
        }
        
        return $text;
    }
}
