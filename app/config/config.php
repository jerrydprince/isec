<?php
/**
 * ISEC Configuration File
 */

// Application Info
define('APP_NAME', 'Integrated Systems Efficiency Consults Limited');
define('APP_SHORT_NAME', 'ISEC');
// Dynamic Database Configuration (Local vs Live)
    define('APP_ENV', 'development');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'isec_db');
define('DB_HOST', 'localhost');
// Dynamic Base URL and Subfolder detection
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// Determine directory containing index.php relative to web root
$basePath = str_replace('/index.php', '', $scriptName);
$baseUrl = rtrim($protocol . $host . $basePath, '/');

define('BASE_URL', $baseUrl);
define('ASSET_URL', BASE_URL . '/assets');

// Dynamic Public Directory Resolution for local/production split-folders
$appRootDir = dirname(dirname(__DIR__));
$publicHtmlDir = dirname($appRootDir) . '/public_html';
if (is_dir($publicHtmlDir)) {
    define('PUBLIC_DIR', $publicHtmlDir);
} else {
    define('PUBLIC_DIR', $appRootDir . '/public');
}

// Security Configurations
define('SESSION_LIFETIME', 3600); // 1 hour
define('CSRF_KEY', 'isec_csrf_secret_key_2026');
define('JWT_SECRET', 'isec_jwt_token_secret_key_2026_secure');

// Error Reporting
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
