<?php

namespace App\Helpers;

use App\Models\Settings;
use Exception;

/**
 * Socket-based SMTP & PHP native mailer
 */
class Mailer {
    
    /**
     * Send email with SMTP authentication or PHP mail() fallback
     */
    public static function send(string $from, string $to, string $subject, string $body, string $fromName = 'ISEC'): bool {
        // Fetch SMTP config
        $host = Settings::get('mail_smtp_host');
        $port = (int)Settings::get('mail_smtp_port', 465);
        $encryption = Settings::get('mail_smtp_encryption', 'ssl');
        
        // Get password for specific email account
        $prefix = explode('@', $from)[0] ?? 'info';
        $password = Settings::get('mail_pass_' . $prefix);
        
        if (empty($host) || empty($password)) {
            // Fallback to PHP native mail() if SMTP credentials are not yet entered
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: " . $fromName . " <" . $from . ">\r\n";
            $headers .= "Reply-To: " . $from . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            return mail($to, $subject, $body, $headers);
        }
        
        // Secure SMTP Socket Connection
        $server = $host;
        if ($encryption === 'ssl') {
            $server = 'ssl://' . $host;
        }
        
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        $socket = @stream_socket_client($server . ':' . $port, $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);
        if (!$socket) {
            throw new Exception("SMTP Socket Connection Failed: $errstr ($errno)");
        }
        
        self::readResponse($socket, '220');
        
        self::sendCommand($socket, "EHLO " . ($_SERVER['SERVER_NAME'] ?: 'localhost'), '250');
        
        if ($encryption === 'tls') {
            self::sendCommand($socket, "STARTTLS", '220');
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception("SMTP TLS Negotiation Failed");
            }
            self::sendCommand($socket, "EHLO " . ($_SERVER['SERVER_NAME'] ?: 'localhost'), '250');
        }
        
        self::sendCommand($socket, "AUTH LOGIN", '334');
        self::sendCommand($socket, base64_encode($from), '334');
        self::sendCommand($socket, base64_encode($password), '235');
        
        self::sendCommand($socket, "MAIL FROM: <$from>", '250');
        self::sendCommand($socket, "RCPT TO: <$to>", '250');
        self::sendCommand($socket, "DATA", '354');
        
        // Construct standard mail headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <" . $from . ">\r\n";
        $headers .= "To: <" . $to . ">\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "Date: " . date('r') . "\r\n";
        $headers .= "Message-ID: <" . uniqid('mail_', true) . "@" . ($host ?: 'isecltd.ng') . ">\r\n\r\n";
        
        $data = $headers . $body . "\r\n.\r\n";
        
        fwrite($socket, $data);
        self::readResponse($socket, '250');
        
        self::sendCommand($socket, "QUIT", '221');
        fclose($socket);
        
        return true;
    }
    
    private static function sendCommand($socket, $command, $expectedResponse): void {
        fwrite($socket, $command . "\r\n");
        self::readResponse($socket, $expectedResponse);
    }
    
    private static function readResponse($socket, $expectedResponse): string {
        $response = '';
        while ($str = fgets($socket, 515)) {
            $response .= $str;
            if (substr($str, 3, 1) === ' ') {
                break;
            }
        }
        if (strpos($response, $expectedResponse) !== 0) {
            throw new Exception("SMTP Server Error: Expected $expectedResponse. Got: $response");
        }
        return $response;
    }
}
