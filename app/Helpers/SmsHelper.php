<?php
namespace App\Helpers;

class SmsHelper {
    public static function sendSms(string $phone, string $message): bool {
        // TODO: Implement actual Termii API call for SMS
        error_log("STUB: Sending Termii SMS to $phone: $message");
        return true;
    }

    public static function sendWhatsApp(string $phone, string $message): bool {
        // TODO: Implement actual Termii API call for WhatsApp
        error_log("STUB: Sending Termii WhatsApp to $phone: $message");
        return true;
    }
}
