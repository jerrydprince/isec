<?php
use App\Models\Settings;
use App\Core\Session;

// Load Dynamic site config
$siteName = Settings::get('site_name', 'Integrated Systems Efficiency Consults Limited');
$shortName = Settings::get('site_short_name', 'ISEC');
$siteDesc = Settings::get('site_description', 'Premium technology, engineering, public sector, and business consulting.');
$contactEmail = Settings::get('contact_email', 'info@isec.com.ng');
$contactPhone = Settings::get('contact_phone', '+234 803 123 4567');
$contactAddress = Settings::get('contact_address', 'Abuja, Nigeria');

$primaryColor = Settings::get('primary_color', '#0f172a');
$secondaryColor = Settings::get('secondary_color', '#1e3a8a');
$accentColor = Settings::get('accent_color', '#0d9488');

$session = new Session();
$flashSuccess = $session->getFlash('success');
$flashError = $session->getFlash('error');

// Menu Active State Helpers
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
function getDesktopClass($path, $currentUri) {
    $urlPath = parse_url(url($path), PHP_URL_PATH);
    $isActive = ($path === '/') ? ($currentUri === $urlPath || $currentUri === rtrim($urlPath, '/')) : (strpos($currentUri, $urlPath) === 0);
    return $isActive ? 'text-sm font-semibold text-accent transition-colors' : 'text-sm font-semibold hover:text-accent transition-colors';
}
function getMobileClass($path, $currentUri) {
    $urlPath = parse_url(url($path), PHP_URL_PATH);
    $isActive = ($path === '/') ? ($currentUri === $urlPath || $currentUri === rtrim($urlPath, '/')) : (strpos($currentUri, $urlPath) === 0);
    return $isActive ? 'block px-3 py-3 rounded-lg text-base font-medium bg-slate-200/50 dark:bg-slate-800/50 text-accent' : 'block px-3 py-3 rounded-lg text-base font-medium hover:bg-slate-200/50 dark:hover:bg-slate-800/50';
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? $siteName) ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/favicon.png') ?>?v=2">
    
    <!-- Meta tags for SEO -->
    <meta name="description" content="<?= e($siteDesc) ?>">
    <meta name="keywords" content="<?= e(Settings::get('meta_keywords', 'consulting, e-governance, digital transformation')) ?>">
    
    <!-- OpenGraph SEO -->
    <meta property="og:title" content="<?= e($title ?? $siteName) ?>">
    <meta property="og:description" content="<?= e($siteDesc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e(url($requestUri ?? '')) ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Scroll Animations CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- SwiperJS Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Tailwind CSS (Play CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--primary-color)',
                        secondary: 'var(--secondary-color)',
                        accent: 'var(--accent-color)',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Dynamic Theme Styling variables -->
    <style>
        :root {
            --primary-color: <?= $primaryColor ?>;
            --secondary-color: <?= $secondaryColor ?>;
            --accent-color: <?= $accentColor ?>;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }
        .dark .glassmorphism {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .gradient-mesh {
            background-color: hsla(224,100%,9%,1);
            background-image:
                radial-gradient(at 0% 0%, hsla(242,86%,21%,1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, hsla(172,100%,37%,1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(263,73%,40%,1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, hsla(201,100%,19%,1) 0px, transparent 50%);
        }
    </style>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- GSAP Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100 font-body" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" :class="{ 'dark': darkMode }">

    <!-- Sticky Navigation Glassmorphism -->
    <nav class="sticky top-0 z-50 glassmorphism shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?= url('/') ?>" class="flex items-center">
                        <img src="<?= asset('images/logo.png') ?>?v=5" alt="ISEC Logo" class="h-10 w-auto object-contain dark:invert transition-all" />
                    </a>
                </div>
                
                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= url('/') ?>" class="<?= getDesktopClass('/', $currentUri) ?>">Home</a>
                    <a href="<?= url('/about') ?>" class="<?= getDesktopClass('/about', $currentUri) ?>">About Us</a>
                    <a href="<?= url('/services') ?>" class="<?= getDesktopClass('/services', $currentUri) ?>">Services</a>
                    <a href="<?= url('/projects') ?>" class="<?= getDesktopClass('/projects', $currentUri) ?>">Case Studies</a>
                    <a href="<?= url('/insights') ?>" class="<?= getDesktopClass('/insights', $currentUri) ?>">Insights</a>
                    <a href="<?= url('/careers') ?>" class="<?= getDesktopClass('/careers', $currentUri) ?>">Careers</a>
                    <a href="<?= url('/contact') ?>" class="<?= getDesktopClass('/contact', $currentUri) ?>">Contact</a>
                </div>

                <!-- Icons & Dark Mode Toggle -->
                <div class="hidden md:flex items-center space-x-4">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors text-slate-600 dark:text-slate-300">
                        <i x-show="!darkMode" class="fa-solid fa-moon text-lg"></i>
                        <i x-show="darkMode" class="fa-solid fa-sun text-lg"></i>
                    </button>
                    <a href="<?= url('/contact') ?>" class="bg-gradient-to-r from-primary to-secondary text-white font-semibold px-5 py-2.5 rounded-full text-sm shadow-md hover:shadow-lg hover:scale-105 transition-all">
                        Request Quote
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 text-slate-600 dark:text-slate-300">
                        <i x-show="!darkMode" class="fa-solid fa-moon text-lg"></i>
                        <i x-show="darkMode" class="fa-solid fa-sun text-lg"></i>
                    </button>
                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-lg hover:bg-slate-200/50 dark:hover:bg-slate-800/50 text-slate-600 dark:text-slate-300">
                        <i :class="mobileMenu ? 'fa-solid fa-xmark text-2xl' : 'fa-solid fa-bars text-2xl'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenu" x-transition.origin.top.right class="md:hidden glassmorphism border-t border-slate-200 dark:border-slate-800" style="display: none;">
            <div class="px-2 pt-2 pb-4 space-y-1 sm:px-3">
                <a href="<?= url('/') ?>" class="<?= getMobileClass('/', $currentUri) ?>">Home</a>
                <a href="<?= url('/about') ?>" class="<?= getMobileClass('/about', $currentUri) ?>">About Us</a>
                <a href="<?= url('/services') ?>" class="<?= getMobileClass('/services', $currentUri) ?>">Services</a>
                <a href="<?= url('/projects') ?>" class="<?= getMobileClass('/projects', $currentUri) ?>">Case Studies</a>
                <a href="<?= url('/insights') ?>" class="<?= getMobileClass('/insights', $currentUri) ?>">Insights</a>
                <a href="<?= url('/careers') ?>" class="<?= getMobileClass('/careers', $currentUri) ?>">Careers</a>
                <a href="<?= url('/contact') ?>" class="<?= getMobileClass('/contact', $currentUri) ?>">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Flash Message Notification Banners -->
    <?php if ($flashSuccess): ?>
        <div class="fixed bottom-5 right-5 z-50 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce" x-data="{ show: true }" x-show="show">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <span class="text-sm font-semibold"><?= e($flashSuccess) ?></span>
            <button @click="show = false" class="hover:opacity-75 ml-4"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="fixed bottom-5 right-5 z-50 bg-rose-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce" x-data="{ show: true }" x-show="show">
            <i class="fa-solid fa-circle-exclamation text-xl"></i>
            <span class="text-sm font-semibold"><?= e($flashError) ?></span>
            <button @click="show = false" class="hover:opacity-75 ml-4"><i class="fa-solid fa-xmark"></i></button>
        </div>
    <?php endif; ?>

    <!-- Main Dynamic Content -->
    <main class="min-h-[70vh]">
        {{content}}
    </main>

    <!-- Premium Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-850 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Branding column -->
                <div class="space-y-4">
                    <a href="<?= url('/') ?>" class="inline-block">
                        <img src="<?= asset('images/logo.png') ?>?v=5" alt="ISEC Logo" class="h-12 w-auto object-contain invert transition-all" />
                    </a>
                    <p class="text-sm text-slate-400 font-light leading-relaxed"><?= e($siteDesc) ?></p>
                    <div class="flex space-x-4 pt-2">
                        <a href="<?= e(Settings::get('linkedin_url', '#')) ?>" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-accent hover:text-white flex items-center justify-center transition-all duration-300"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                        <a href="<?= e(Settings::get('twitter_url', '#')) ?>" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-accent hover:text-white flex items-center justify-center transition-all duration-300"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                        <a href="<?= e(Settings::get('facebook_url', '#')) ?>" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-accent hover:text-white flex items-center justify-center transition-all duration-300"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    </div>
                </div>
                
                <!-- Quick links -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-widest uppercase mb-4">Core Agency</h4>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="<?= url('/about') ?>" class="hover:text-accent transition-colors">About History</a></li>
                        <li><a href="<?= url('/services') ?>" class="hover:text-accent transition-colors">Consulting Services</a></li>
                        <li><a href="<?= url('/projects') ?>" class="hover:text-accent transition-colors">Case Studies</a></li>
                        <li><a href="<?= url('/careers') ?>" class="hover:text-accent transition-colors">Job Openings</a></li>
                        <li><a href="<?= url('/verify-certificate') ?>" class="hover:text-accent transition-colors">Verify Certificate</a></li>
                        <li><a href="<?= url('/' . Settings::get('company_profile_pdf', 'assets/uploads/documents/company_profile.pdf')) ?>" target="_blank" class="hover:text-accent transition-colors text-xs font-semibold text-red-500"><i class="fa-solid fa-file-pdf mr-1"></i> Company Profile.pdf</a></li>
                    </ul>
                </div>

                <!-- Office Contact info -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-widest uppercase mb-4">Abuja Office</h4>
                    <ul class="space-y-2 text-sm font-light">
                        <li class="flex items-start gap-2"><i class="fa-solid fa-location-dot mt-1 text-accent text-xs"></i> <span><?= e($contactAddress) ?></span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-phone text-accent text-xs"></i> <span><?= e($contactPhone) ?></span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-envelope text-accent text-xs"></i> <span><?= e($contactEmail) ?></span></li>
                    </ul>
                </div>

                <!-- Newsletter form -->
                <div class="space-y-4">
                    <h4 class="text-white font-bold text-sm tracking-widest uppercase mb-4">Corporate Digest</h4>
                    <p class="text-xs font-light text-slate-400">Subscribe for executive whitepapers and systems efficiency research notes.</p>
                    <form action="<?= url('/newsletter') ?>" method="POST" class="flex gap-2 bg-slate-800 p-1.5 rounded-full border border-slate-700 focus-within:border-accent">
                        <?= csrf_field() ?>
                        <input type="email" name="email" placeholder="Your work email..." class="bg-transparent border-0 flex-1 outline-none text-xs text-white px-3" required>
                        <button type="submit" class="bg-gradient-to-r from-primary to-accent hover:opacity-90 text-white rounded-full px-4 py-2 text-xs font-semibold tracking-wide transition-all shadow-md">Join</button>
                    </form>
                </div>
            </div>
            
            <hr class="border-slate-800 mb-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-slate-500 font-medium">
                <p>&copy; <?= date('Y') ?> Integrated Systems Efficiency Consults Limited (ISEC). All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="<?= url('/admin/login') ?>" class="hover:text-slate-300 transition-colors"><i class="fa-solid fa-lock text-[10px] mr-1"></i> Admin Portal</a>
                    <a href="<?= url('/privacy') ?>" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
                    <a href="<?= url('/terms') ?>" class="hover:text-slate-300 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Scroll Animations script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        // Entrance GSAP transitions
        gsap.from(".gsap-hero-title", { duration: 1, y: 30, opacity: 0, ease: "power3.out" });
        gsap.from(".gsap-hero-desc", { duration: 1, y: 30, opacity: 0, delay: 0.2, ease: "power3.out" });
        gsap.from(".gsap-hero-btns", { duration: 1, y: 30, opacity: 0, delay: 0.4, ease: "power3.out" });
    </script>

    <!-- Source Protection: Disable right-click & key combinations for DevTools/View Source -->
    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (
                e.key === 'F12' ||
                ((e.ctrlKey || e.metaKey) && (
                    e.key.toLowerCase() === 'u' ||
                    e.key.toLowerCase() === 's'
                )) ||
                ((e.ctrlKey || e.metaKey) && e.shiftKey && (
                    e.key.toLowerCase() === 'i' ||
                    e.key.toLowerCase() === 'c' ||
                    e.key.toLowerCase() === 'j'
                ))
            ) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
