<?php
use App\Models\Settings;
use App\Models\Service;

// Load config settings
$contactEmail = Settings::get('contact_email', 'info@isec.com.ng');
$contactPhone = Settings::get('contact_phone', '+234 803 123 4567');
$contactAddress = Settings::get('contact_address', 'Abuja, Nigeria');
$whatsappNumber = Settings::get('whatsapp_number', '+2348031234567');
$googleMapEmbed = Settings::get('google_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25751.572645386423!2d7.481050699783806!3d9.048882733229076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104e0b6d50c2ef9f%3A0x71db97e7651f14c1!2sWorld%20Trade%20Center%20Abuja%20-%20Luxury%20Apartments%20%26%20Premier%20Office%20Spaces!5e0!3m2!1sen!2sng!4v1786522386561!5m2!1sen!2sng');

$services = Service::getPublished();
?>
<!-- Contact Header -->
<section class="py-20 relative overflow-hidden bg-slate-900 dark:bg-slate-950 text-white">
    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-accent opacity-30 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
        <span class="text-xs font-bold text-accent uppercase tracking-widest">Connect with ISEC</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Contact Our Advisory Offices</h1>
        <p class="max-w-2xl mx-auto text-slate-300 font-light text-base">
            Discuss integrations, system audits, or schedule technical advisory consultations.
        </p>
    </div>
</section>

<!-- Main Form and details -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Left Side Details -->
            <div class="lg:col-span-5 space-y-10" data-aos="fade-right">
                <div class="space-y-4">
                    <span class="text-xs font-bold text-accent uppercase tracking-widest block">Communications channels</span>
                    <h2 class="text-3xl font-extrabold text-primary dark:text-white">Get in touch</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-light text-sm leading-relaxed">
                        We maintain active communication channels. Choose your preferred contact pathway to speak with our analysts.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-950 flex items-center justify-center text-accent text-xl border border-slate-200 dark:border-slate-850"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <h4 class="font-bold text-primary dark:text-white text-sm">Abuja Headquarters Office</h4>
                            <p class="text-xs font-light text-slate-400 leading-relaxed mt-1"><?= e($contactAddress) ?></p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-950 flex items-center justify-center text-accent text-xl border border-slate-200 dark:border-slate-850"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <h4 class="font-bold text-primary dark:text-white text-sm">Corporate Phone</h4>
                            <p class="text-xs font-light text-slate-400 leading-relaxed mt-1"><?= e($contactPhone) ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-950 flex items-center justify-center text-accent text-xl border border-slate-200 dark:border-slate-850"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <h4 class="font-bold text-primary dark:text-white text-sm">Official Email Inquiry</h4>
                            <p class="text-xs font-light text-slate-400 leading-relaxed mt-1"><?= e($contactEmail) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Whatsapp Button -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-850">
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>" target="_blank" class="inline-flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3.5 rounded-2xl text-sm shadow-md shadow-emerald-500/10 hover:shadow-emerald-500/30 hover:scale-105 transition-all">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Chat on WhatsApp
                    </a>
                </div>
            </div>

            <!-- Right Side Form panel -->
            <div class="lg:col-span-7" data-aos="fade-left">
                <div class="bg-slate-50 dark:bg-slate-950 p-8 rounded-3xl border border-slate-200 dark:border-slate-850 shadow-md">
                    <h4 class="font-bold text-primary dark:text-white text-lg mb-2">Request Technical Advisory / Quote</h4>
                    <p class="text-xs font-light text-slate-400 mb-6">Complete your inquiry profile below. All communications are protected under corporate NDA guidelines.</p>
                    
                    <form action="<?= url('/contact') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <?= csrf_field() ?>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Full Name *</label>
                                <input type="text" name="name" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Company / Agency Name</label>
                                <input type="text" name="company" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email Address *</label>
                                <input type="email" name="email" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Country</label>
                                <input type="text" name="country" placeholder="Nigeria" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Phone Number</label>
                                <input type="text" name="phone" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Service Interested</label>
                                <select name="service_interested" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white">
                                    <option value="">-- Select Service --</option>
                                    <optgroup label="SME Solutions">
                                        <option value="ISEC Retail POS">ISEC Retail POS</option>
                                        <option value="Property Management System">Property Management System</option>
                                        <option value="Business Websites & eCommerce">Business Websites & eCommerce</option>
                                        <option value="Off-The-Shelf Software">Other Off-The-Shelf Software</option>
                                    </optgroup>
                                    <optgroup label="Enterprise Solutions">
                                        <?php foreach ($services as $srv): ?>
                                            <option value="<?= e($srv['title']) ?>"><?= e($srv['title']) ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <option value="Custom Advisory">Other Custom Inquiry</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Message / Requirements Outline *</label>
                            <textarea name="message" rows="4" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white" required></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Attach RFP / Specifications Document (PDF, max 5MB)</label>
                            <input type="file" name="attachment" accept=".pdf,.doc,.docx,.zip" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 focus:border-accent rounded-xl px-4 py-3 text-xs outline-none transition-all text-primary dark:text-white">
                        </div>

                        <button type="submit" class="w-full bg-accent hover:brightness-110 text-white font-bold py-4 rounded-xl text-xs shadow-md transition-all">Submit Advisory Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Map -->
<?php if (!empty($googleMapEmbed)): ?>
    <section class="h-[450px] w-full bg-slate-100">
        <iframe src="<?= e($googleMapEmbed) ?>" class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
<?php endif; ?>

<!-- Alpine FAQs Accordion -->
<section class="py-24 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-850">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-xs font-bold text-accent uppercase tracking-widest block">Support Queries</span>
            <h2 class="text-3xl font-extrabold text-primary dark:text-white mb-4">Frequently Asked Questions</h2>
            <p class="text-slate-500 dark:text-slate-400 font-light text-sm">Quick answers regarding project scopes, technology implementations, and SLAs.</p>
        </div>

        <div x-data="{ activeAccordion: 0 }" class="space-y-4">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-850 overflow-hidden shadow-sm" data-aos="fade-up">
                    <button @click="activeAccordion = (activeAccordion === <?= $index + 1 ?>) ? 0 : <?= $index + 1 ?>" class="w-full flex justify-between items-center p-6 text-left font-bold text-sm text-primary dark:text-white focus:outline-none select-none">
                        <span><?= e($faq['question']) ?></span>
                        <div class="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-850 flex items-center justify-center text-slate-500 text-xs transition-transform duration-300" :class="activeAccordion === <?= $index + 1 ?> ? 'rotate-180 bg-accent/10 text-accent' : ''">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </button>
                    <div x-show="activeAccordion === <?= $index + 1 ?>" x-transition.origin.top.left class="px-6 pb-6 border-t border-slate-100 dark:border-slate-850 pt-4" style="display: none;">
                        <p class="text-slate-550 dark:text-slate-400 font-light text-xs leading-relaxed">
                            <?= nl2br(e($faq['answer'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
