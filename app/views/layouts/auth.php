<?php
use App\Models\Settings;
use App\Core\Session;

$siteName = Settings::get('site_name', 'Integrated Systems Efficiency Consults Limited');
$shortName = Settings::get('site_short_name', 'ISEC');

$session = new Session();
$flashSuccess = $session->getFlash('success');
$flashError = $session->getFlash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'ISEC Admin Panel') ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Abstract Gradient Mesh background shapes -->
    <div class="absolute w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[100px] top-[-10%] left-[-10%]"></div>
    <div class="absolute w-[500px] h-[500px] bg-teal-600/10 rounded-full blur-[100px] bottom-[-10%] right-[-10%]"></div>

    <div class="w-full max-w-md p-6 relative z-10">
        <!-- Flash messages inside login -->
        <?php if ($flashError): ?>
            <div class="bg-rose-500/25 border border-rose-500/30 text-rose-300 px-4 py-3 rounded-xl mb-4 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-sm"></i>
                <span><?= e($flashError) ?></span>
            </div>
        <?php endif; ?>
        <?php if ($flashSuccess): ?>
            <div class="bg-emerald-500/25 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-xl mb-4 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-sm"></i>
                <span><?= e($flashSuccess) ?></span>
            </div>
        <?php endif; ?>

        {{content}}
    </div>

</body>
</html>
