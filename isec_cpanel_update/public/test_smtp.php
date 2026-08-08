<?php
/**
 * ISEC SMTP Real-Time Diagnostic Script
 */

// 1. Detect environment and load configuration paths
if (file_exists(__DIR__ . '/../isec_app/vendor/autoload.php')) {
    // Production (Option A split-folder structure)
    require_once __DIR__ . '/../isec_app/vendor/autoload.php';
    require_once __DIR__ . '/../isec_app/app/config/config.php';
    require_once __DIR__ . '/../isec_app/app/Helpers/helpers.php';
} else {
    // Local / Development structure
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../app/config/config.php';
    require_once __DIR__ . '/../app/Helpers/helpers.php';
}

use App\Helpers\Mailer;
use App\Models\Settings;

// 2. Enable absolute error outputting for diagnostic visibility
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='font-family: sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);'>";
echo "<h2 style='color: #4f46e5; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-top: 0;'>SMTP Server Diagnostic Portal</h2>";

// Print active configuration parameters
echo "<h3>Current Mail Server Settings:</h3>";
echo "<ul>";
echo "<li><strong>SMTP Host:</strong> " . htmlspecialchars(Settings::get('mail_smtp_host') ?: '(Not Configured)') . "</li>";
echo "<li><strong>SMTP Port:</strong> " . htmlspecialchars(Settings::get('mail_smtp_port', '465')) . "</li>";
echo "<li><strong>SMTP Encryption:</strong> " . htmlspecialchars(Settings::get('mail_smtp_encryption', 'ssl')) . "</li>";
echo "<li><strong>Sender (From):</strong> info@isecltd.ng</li>";
echo "<li><strong>Recipient (To):</strong> contact@isecltd.ng</li>";
echo "<li><strong>Password Present (info):</strong> " . (Settings::get('mail_pass_info') ? "Yes (length: " . strlen(Settings::get('mail_pass_info')) . ")" : "No") . "</li>";
echo "</ul>";

echo "<h3>Executing SMTP Test Connection...</h3>";
flush();

try {
    $result = Mailer::send('info@isecltd.ng', 'contact@isecltd.ng', 'Diagnostic Test Message - ' . date('Y-m-d H:i:s'), 'This is a secure connection test email dispatched by the diagnostic portal.', 'ISEC Diagnostic');
    
    if ($result) {
        echo "<p style='background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px; border-radius: 8px; font-weight: bold;'>";
        echo "SUCCESS: SMTP Mailer connected and successfully delivered message to Exim queue.";
        echo "</p>";
    }
} catch (\Exception $e) {
    echo "<p style='background-color: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px; border-radius: 8px; font-weight: bold;'>";
    echo "SMTP CONNECTION ERROR: " . htmlspecialchars($e->getMessage());
    echo "</p>";
}

echo "</div>";
