<?php
/**
 * ISEC CMS - Automated Subscriptions Reminder Cron Job
 * 
 * This script should be run daily via cPanel Cron Jobs.
 * Command example for cPanel:
 * /usr/local/bin/php /home/username/public_html/cron.php
 */

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Core/Mailer.php';
require_once __DIR__ . '/app/Models/Settings.php';
require_once __DIR__ . '/app/Helpers/SmsHelper.php';

use App\Core\Database;
use App\Core\Mailer;
use App\Models\Settings;
use App\Helpers\SmsHelper;

echo "Starting ISEC Subscription Reminder Cron Job at " . date('Y-m-d H:i:s') . "\n";

try {
    $db = Database::getConnection();
    
    // Get settings
    $officeEmail = Settings::get('contact_email', 'info@isecltd.ng');
    $currency = Settings::get('currency_symbol', '₦');

    // Get Active Subscriptions
    $stmt = $db->query("
        SELECT s.*, c.name as client_name, c.email as client_email, c.phone as client_phone 
        FROM subscriptions s 
        LEFT JOIN customers c ON s.customer_id = c.id 
        WHERE s.status = 'Active'
    ");
    $subscriptions = $stmt->fetchAll();

    foreach ($subscriptions as $sub) {
        $remindersSent = json_decode($sub['reminders_sent'] ?? '[]', true) ?: [];
        $today = new DateTime();
        $dueDate = new DateTime($sub['next_due_date']);
        
        $interval = $today->diff($dueDate);
        $daysUntilDue = (int)$interval->format('%R%a'); // Will be positive if in the future, negative if past
        
        $costFormatted = $currency . number_format($sub['cost'], 2);
        
        // Define replacement map
        $replacements = [
            '{client_name}' => $sub['client_name'] ?? 'Client',
            '{service_name}' => $sub['service_name'],
            '{due_date}' => $dueDate->format('M d, Y'),
            '{cost}' => $costFormatted
        ];

        // 14-Days Reminder
        if ($daysUntilDue === 14 && !in_array('14_days', $remindersSent)) {
            echo "Processing 14-days reminder for Subscription #{$sub['id']}\n";
            
            $emailBody = strtr(Settings::get('sub_email_14', ''), $replacements);
            $smsBody = strtr(Settings::get('sub_sms_14', ''), $replacements);
            $waBody = strtr(Settings::get('sub_wa_14', ''), $replacements);

            if ($sub['notify_client'] && $sub['customer_id']) {
                if (!empty($sub['client_email'])) {
                    Mailer::send('no-reply@isecltd.ng', $sub['client_email'], "Upcoming Renewal: {$sub['service_name']}", nl2br($emailBody));
                }
                if (!empty($sub['client_phone'])) {
                    SmsHelper::sendSms($sub['client_phone'], $smsBody);
                    SmsHelper::sendWhatsApp($sub['client_phone'], $waBody);
                }
            }

            if ($sub['notify_office']) {
                Mailer::send('no-reply@isecltd.ng', $officeEmail, "Action Required: Subscription Renewal in 14 Days ({$sub['service_name']})", nl2br($emailBody));
            }

            $remindersSent[] = '14_days';
            $db->prepare("UPDATE subscriptions SET reminders_sent = ? WHERE id = ?")->execute([json_encode($remindersSent), $sub['id']]);
        }

        // 0-Days (Due Date) Reminder
        if ($daysUntilDue === 0 && !in_array('0_days', $remindersSent)) {
            echo "Processing Due Date reminder for Subscription #{$sub['id']}\n";
            
            $emailBody = strtr(Settings::get('sub_email_0', ''), $replacements);
            $smsBody = strtr(Settings::get('sub_sms_0', ''), $replacements);
            $waBody = strtr(Settings::get('sub_wa_0', ''), $replacements);

            if ($sub['notify_client'] && $sub['customer_id']) {
                if (!empty($sub['client_email'])) {
                    Mailer::send('no-reply@isecltd.ng', $sub['client_email'], "URGENT Renewal: {$sub['service_name']}", nl2br($emailBody));
                }
                if (!empty($sub['client_phone'])) {
                    SmsHelper::sendSms($sub['client_phone'], $smsBody);
                    SmsHelper::sendWhatsApp($sub['client_phone'], $waBody);
                }
            }

            if ($sub['notify_office']) {
                Mailer::send('no-reply@isecltd.ng', $officeEmail, "URGENT: Subscription Renewal Due TODAY ({$sub['service_name']})", nl2br($emailBody));
            }

            $remindersSent[] = '0_days';
            $db->prepare("UPDATE subscriptions SET reminders_sent = ? WHERE id = ?")->execute([json_encode($remindersSent), $sub['id']]);
        }

        // Auto-expire if past due by 7 days
        if ($daysUntilDue < -7) {
            echo "Auto-expiring Subscription #{$sub['id']}\n";
            $db->prepare("UPDATE subscriptions SET status = 'Expired' WHERE id = ?")->execute([$sub['id']]);
        }
    }

    echo "Cron Job completed successfully.\n";

} catch (Exception $e) {
    echo "Error during cron execution: " . $e->getMessage() . "\n";
}
