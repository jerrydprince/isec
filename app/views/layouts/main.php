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
    <title><?= e($title ?? 'Software Development Company in Abuja | ISEC') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/favicon.png') ?>?v=2">
    
    <!-- Meta tags for SEO -->
    <?php
        $finalDesc = $metaDescription ?? 'ISEC builds property management systems, retail POS, business websites and custom software for Nigerian businesses. Based in Abuja. Free 30-minute assessment.';
        $finalImage = isset($metaImage) ? url($metaImage) : url('/assets/images/industry.png'); // Fallback image
        $finalUrl = url($requestUri ?? $_SERVER['REQUEST_URI'] ?? '/');
    ?>
    <meta name="description" content="<?= e($finalDesc) ?>">
    <meta name="keywords" content="<?= e(Settings::get('meta_keywords', 'software development company Abuja, property management software Nigeria, POS system Nigeria, website design Abuja, custom software Nigeria')) ?>">
    
    <!-- OpenGraph SEO -->
    <meta property="og:title" content="<?= e($title ?? $siteName) ?>">
    <meta property="og:description" content="<?= e($finalDesc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($finalUrl) ?>">
    <meta property="og:image" content="<?= e($finalImage) ?>">
    
    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($title ?? $siteName) ?>">
    <meta name="twitter:description" content="<?= e($finalDesc) ?>">
    <meta name="twitter:image" content="<?= e($finalImage) ?>">
    
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
    <style>
        /* Hide body until Tailwind CSS is loaded to prevent FOUC (Flash of Unstyled Content) twitching */
        body { visibility: hidden; opacity: 0; transition: opacity 0.1s ease-in; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Wait for Tailwind to inject its style tag, then reveal the body smoothly
        const observer = new MutationObserver((mutations) => {
            if (document.getElementById('tailwind-play')) {
                document.body.style.visibility = 'visible';
                document.body.style.opacity = '1';
                observer.disconnect();
            }
        });
        observer.observe(document.head, { childList: true });
        
        // Fallback reveal
        window.addEventListener('load', () => {
            document.body.style.visibility = 'visible';
            document.body.style.opacity = '1';
        });

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
        html {
            overflow-y: scroll; /* Prevents scrollbar twitching between pages */
        }
        [x-cloak] { display: none !important; }
    </style>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- GSAP Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WVW3262FN6"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-WVW3262FN6');
    </script>
</head>
<body class="bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100 font-body" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" :class="{ 'dark': darkMode }">

    <!-- Sticky Navigation Glassmorphism -->
    <nav class="sticky top-0 z-50 glassmorphism shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center" style="width: 95px; height: 40px;">
                    <a href="<?= url('/') ?>" class="flex items-center">
                        <img src="<?= asset('images/logo.png') ?>?v=5" alt="ISEC Logo" width="1024" height="435" style="aspect-ratio: 1024/435;" class="h-10 w-auto object-contain dark:invert transition-all" />
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
                        <i x-cloak x-show="!darkMode" class="fa-solid fa-moon text-lg"></i>
                        <i x-cloak x-show="darkMode" class="fa-solid fa-sun text-lg"></i>
                    </button>
                    <a href="<?= url('/contact') ?>" class="bg-gradient-to-r from-primary to-secondary text-white font-semibold px-5 py-2.5 rounded-full text-sm shadow-md hover:shadow-lg hover:scale-105 transition-all">
                        Request Quote
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 text-slate-600 dark:text-slate-300">
                        <i x-cloak x-show="!darkMode" class="fa-solid fa-moon text-lg"></i>
                        <i x-cloak x-show="darkMode" class="fa-solid fa-sun text-lg"></i>
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

    <!-- Sticky Mobile WhatsApp Button -->
    <a href="https://wa.me/2348100794455?text=Hi%20ISEC,%20I'd%20like%20to%20know%20more%20about%20%E2%80%94" target="_blank" class="md:hidden fixed bottom-6 left-6 z-[9999] bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
    </a>

    <!-- Main Dynamic Content -->
    <main class="min-h-[70vh]">
        {{content}}
    </main>

    <!-- Premium Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-850 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 mb-12">
                <!-- Branding column -->
                <div class="space-y-4 md:col-span-2 pr-4">
                    <h3 class="text-white font-bold text-lg mb-2">Integrated Systems Efficiency Consults Limited</h3>
                    <p class="text-sm text-slate-400 font-light leading-relaxed">
                        Plot 1333, World Trade Centre,<br>
                        Central Business District,<br>
                        Abuja, FCT, Nigeria
                    </p>
                    <div class="space-y-1 text-sm pt-2">
                        <p>+234 810 079 4455 &bull; +234 903 141 4971</p>
                        <p><a href="mailto:info@isecltd.ng" class="hover:text-white transition-colors">info@isecltd.ng</a> &bull; <a href="mailto:admin@isecltd.ng" class="hover:text-white transition-colors">admin@isecltd.ng</a></p>
                    </div>
                </div>
                
                <!-- Products -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-widest uppercase mb-4">Products</h4>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="<?= url('/#products') ?>" class="hover:text-teal-400 transition-colors">Property Manager</a></li>
                        <li><a href="<?= url('/#products') ?>" class="hover:text-teal-400 transition-colors">Retail POS</a></li>
                        <li><a href="<?= url('/#products') ?>" class="hover:text-teal-400 transition-colors">Business Websites</a></li>
                        <li><a href="<?= url('/#products') ?>" class="hover:text-teal-400 transition-colors">Custom Software</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-widest uppercase mb-4">Company</h4>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="<?= url('/about') ?>" class="hover:text-teal-400 transition-colors">About</a></li>
                        <li><a href="<?= url('/' . Settings::get('company_profile_pdf', 'assets/uploads/documents/company_profile.pdf')) ?>" target="_blank" class="hover:text-teal-400 transition-colors">Corporate Profile</a></li>
                        <li><a href="<?= url('/projects') ?>" class="hover:text-teal-400 transition-colors">Case Studies</a></li>
                        <li><a href="<?= url('/verify-certificate') ?>" class="hover:text-teal-400 transition-colors">Verify Certificate</a></li>
                        <li><a href="<?= url('/contact') ?>" class="hover:text-teal-400 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Enterprise -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-widest uppercase mb-4">Enterprise</h4>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="<?= url('/services/it-infrastructure-integration') ?>" class="hover:text-teal-400 transition-colors">Infrastructure</a></li>
                        <li><a href="<?= url('/services/cybersecurity-data-protection') ?>" class="hover:text-teal-400 transition-colors">Cybersecurity</a></li>
                        <li><a href="<?= url('/services/document-records-management') ?>" class="hover:text-teal-400 transition-colors">Records Digitisation</a></li>
                        <li><a href="<?= url('/services/training-managed-services') ?>" class="hover:text-teal-400 transition-colors">Capacity Building</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-slate-800 mb-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-slate-500 font-medium">
                <div class="mb-4 md:mb-0 flex gap-4 text-[10px] font-mono">
                    <span>RC 7251009</span>
                    <span>CPN 009261/2024</span>
                    <span>NITDA/59335513</span>
                    <span>BPP 0000-0019-3476</span>
                </div>
                <p>&copy; 2026 Integrated Systems Efficiency Consults Limited. All rights reserved.</p>
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
