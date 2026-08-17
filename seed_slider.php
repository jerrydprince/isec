<?php
require_once __DIR__ . '/app/config/config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $slides = [
        [
            'section_key' => 'slide_1_label',
            'content_value' => 'SOFTWARE THAT RUNS YOUR BUSINESS'
        ],
        [
            'section_key' => 'slide_1_title',
            'content_value' => 'Stop running your business on WhatsApp and paper.'
        ],
        [
            'section_key' => 'slide_1_subtitle',
            'content_value' => 'We build the systems Nigerian businesses actually use — property management, retail POS, custom software and websites. Built in Abuja, delivered in weeks, supported for as long as you run them.'
        ],
        
        [
            'section_key' => 'slide_2_label',
            'content_value' => 'BUSINESS TRANSFORMATION PARTNER'
        ],
        [
            'section_key' => 'slide_2_title',
            'content_value' => 'Enterprise Advisory & Systems Transformation.'
        ],
        [
            'section_key' => 'slide_2_subtitle',
            'content_value' => 'Delivering bespoke technical advisory and complex systems integration for the public sector, government agencies, and large organisations.'
        ],

        [
            'section_key' => 'slide_3_label',
            'content_value' => 'OFF-THE-SHELF SYSTEMS'
        ],
        [
            'section_key' => 'slide_3_title',
            'content_value' => 'Rapid deployment solutions for growing businesses.'
        ],
        [
            'section_key' => 'slide_3_subtitle',
            'content_value' => 'Scale your operations immediately with ISEC Property Manager and Retail POS. Track tenants, close sales, and trust your figures at the end of the day.'
        ],

        [
            'section_key' => 'slide_4_label',
            'content_value' => 'COMPLEX INTEGRATIONS'
        ],
        [
            'section_key' => 'slide_4_title',
            'content_value' => 'Secure, resilient IT infrastructure.'
        ],
        [
            'section_key' => 'slide_4_subtitle',
            'content_value' => 'Our enterprise architects construct specialized integration frameworks tailored to your statutory regulations and unique operational requirements.'
        ],

        [
            'section_key' => 'slide_5_label',
            'content_value' => 'DIGITAL PRESENCE'
        ],
        [
            'section_key' => 'slide_5_title',
            'content_value' => 'Business websites that convert visitors.'
        ],
        [
            'section_key' => 'slide_5_subtitle',
            'content_value' => 'Fast, mobile-first websites that load on Nigerian networks and turn visitors into customers. Built to be found on Google and easy to update.'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO `page_contents` (page_key, section_key, content_type, content_value) VALUES ('home', :section_key, 'text', :content_value)");

    foreach ($slides as $slide) {
        // Check if exists
        $check = $pdo->prepare("SELECT id FROM `page_contents` WHERE page_key = 'home' AND section_key = :section_key");
        $check->execute(['section_key' => $slide['section_key']]);
        
        if (!$check->fetch()) {
            $stmt->execute([
                'section_key' => $slide['section_key'],
                'content_value' => $slide['content_value']
            ]);
        }
    }
    
    // Also remove the old single banner title and subtitle so they don't clutter the CMS
    $pdo->query("DELETE FROM `page_contents` WHERE page_key = 'home' AND section_key IN ('hero_title', 'hero_subtitle')");

    echo "<h1>Success!</h1><p>Slider CMS fields have been added to the database.</p>";

} catch (PDOException $e) {
    die("<h1>Database Error</h1><p>" . $e->getMessage() . "</p>");
}
