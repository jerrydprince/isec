<?php
use App\Models\Settings;
?>
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Dynamic Site Settings</h1>
        <p class="text-xs text-slate-500 font-light mt-0.5">Manage global site branding colors, metadata, and communications coordinates.</p>
    </div>

    <!-- Form Panel Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8">
        <form action="<?= url('/admin/settings') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            
            <h3 class="font-bold text-sm text-slate-800 border-b pb-2"><i class="fa-solid fa-palette text-indigo-500 mr-2"></i> Corporate Theme Branding Colors</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Primary Branding Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="primary_color" value="<?= e(Settings::get('primary_color', '#0f172a')) ?>" class="h-10 w-12 border rounded-lg cursor-pointer">
                        <input type="text" value="<?= e(Settings::get('primary_color', '#0f172a')) ?>" readonly class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Secondary Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="secondary_color" value="<?= e(Settings::get('secondary_color', '#1e3a8a')) ?>" class="h-10 w-12 border rounded-lg cursor-pointer">
                        <input type="text" value="<?= e(Settings::get('secondary_color', '#1e3a8a')) ?>" readonly class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Accent Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="accent_color" value="<?= e(Settings::get('accent_color', '#0d9488')) ?>" class="h-10 w-12 border rounded-lg cursor-pointer">
                        <input type="text" value="<?= e(Settings::get('accent_color', '#0d9488')) ?>" readonly class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-500">
                    </div>
                </div>
            </div>
 
            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-address-card text-indigo-500 mr-2"></i> Corporate Profile & Directory</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Site Name</label>
                    <input type="text" name="site_name" value="<?= e(Settings::get('site_name')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Site Short Abbreviation</label>
                    <input type="text" name="site_short_name" value="<?= e(Settings::get('site_short_name')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
            </div>
 
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Corporate Headline / Description</label>
                <textarea name="site_description" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('site_description')) ?></textarea>
            </div>
 
            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-square-phone text-indigo-500 mr-2"></i> Communications Coordinates</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Inquiry Emails</label>
                    <input type="email" name="contact_email" value="<?= e(Settings::get('contact_email')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Phone Lines</label>
                    <input type="text" name="contact_phone" value="<?= e(Settings::get('contact_phone')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">WhatsApp Mobile Number</label>
                    <input type="text" name="whatsapp_number" value="<?= e(Settings::get('whatsapp_number')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
            </div>
 
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Abuja Corporate Headquarters Address</label>
                    <input type="text" name="contact_address" value="<?= e(Settings::get('contact_address')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Google Maps Embed URL Source</label>
                    <input type="text" name="google_map_embed" value="<?= e(Settings::get('google_map_embed')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
            </div>

            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-file-contract text-indigo-500 mr-2"></i> Statutory Compliance Registry</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">CAC Registration Number</label>
                    <input type="text" name="cac_number" value="<?= e(Settings::get('cac_number', 'RC - 1234567')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">FIRS TIN (Tax Identification Number)</label>
                    <input type="text" name="firs_tin" value="<?= e(Settings::get('firs_tin', 'TIN - 987654321-0001')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">NSITF Compliance Reference</label>
                    <input type="text" name="nsitf_status" value="<?= e(Settings::get('nsitf_status', 'Compliant - Certificate No. NSITF/2026/0998')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">ITF Compliance Reference</label>
                    <input type="text" name="itf_status" value="<?= e(Settings::get('itf_status', 'Compliant - Registration No. ITF/RC/8876')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">BPP IRR Reference Number</label>
                    <input type="text" name="bpp_status" value="<?= e(Settings::get('bpp_status', 'Registered - BPP IRR No. IRR-998877')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">CPN Corporate License Status</label>
                    <input type="text" name="cpn_status" value="<?= e(Settings::get('cpn_status', 'Member - CPN Corporate No. CPN/2026/5543')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">NITDA Authorization Status</label>
                    <input type="text" name="nitda_status" value="<?= e(Settings::get('nitda_status', 'Licensed - NITDA IT-ServiceProvider License #NITDA/2026/102')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
            </div>

            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-file-pdf text-indigo-500 mr-2"></i> Company Profile Document</h3>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Upload Company Profile PDF</label>
                <input type="file" name="company_profile_pdf" accept=".pdf" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                <span class="text-[10px] text-slate-450 mt-2 block">
                    <i class="fa-solid fa-circle-info text-accent mr-1"></i> Current file: 
                    <a href="<?= url('/' . Settings::get('company_profile_pdf', 'assets/uploads/documents/company_profile.pdf')) ?>" target="_blank" class="text-indigo-600 hover:underline font-semibold font-mono"><?= e(basename(Settings::get('company_profile_pdf', 'company_profile.pdf'))) ?></a>
                </span>
            </div>
            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-brands fa-searchengin text-indigo-500 mr-2"></i> SEO & Discovery</h3>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Default Keywords (Comma separated)</label>
                <input type="text" name="meta_keywords" value="<?= e(Settings::get('meta_keywords')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
            </div>

            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-share-nodes text-indigo-500 mr-2"></i> Corporate Social Profiles</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">LinkedIn Page URL</label>
                    <input type="url" name="linkedin_url" value="<?= e(Settings::get('linkedin_url', '#')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Twitter / X URL</label>
                    <input type="url" name="twitter_url" value="<?= e(Settings::get('twitter_url', '#')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Facebook Page URL</label>
                    <input type="url" name="facebook_url" value="<?= e(Settings::get('facebook_url', '#')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
            </div>

            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-calculator text-indigo-500 mr-2"></i> Accounting & Financial Defaults</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="<?= e(Settings::get('currency_symbol', '₦')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850" placeholder="e.g. ₦ or $">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Expense Categories (Comma separated)</label>
                    <input type="text" name="expense_categories" value="<?= e(Settings::get('expense_categories', 'Software/Licenses,Contractor Fees,Office Supplies,Marketing,Travel,Taxes,General')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850">
                </div>
            </div>

            <h3 class="font-bold text-sm text-slate-800 border-b pb-2 pt-6"><i class="fa-solid fa-bell text-indigo-500 mr-2"></i> Subscription Reminder Templates (14 Days & Due Date)</h3>
            <div class="text-xs text-slate-500 bg-indigo-50 p-3 rounded-lg border border-indigo-100 mb-4">
                <i class="fa-solid fa-circle-info mr-1"></i> <b>Available Variables:</b> <code>{client_name}</code>, <code>{service_name}</code>, <code>{due_date}</code>, <code>{cost}</code>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">14-Days Email Template</label>
                    <textarea name="sub_email_14" rows="4" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('sub_email_14', "Dear {client_name},\n\nThis is a friendly reminder that your subscription for {service_name} will expire on {due_date}. The renewal cost is {cost}.\n\nPlease arrange for payment to avoid service disruption.\n\nThank you!")) ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Due-Date Email Template</label>
                    <textarea name="sub_email_0" rows="4" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('sub_email_0', "Dear {client_name},\n\nYour subscription for {service_name} expires TODAY ({due_date}). The renewal cost is {cost}.\n\nImmediate payment is required to maintain your service.\n\nThank you!")) ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">14-Days SMS Template</label>
                    <textarea name="sub_sms_14" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('sub_sms_14', "Reminder: Your {service_name} subscription expires on {due_date}. Renewal fee: {cost}. Please arrange payment.")) ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Due-Date SMS Template</label>
                    <textarea name="sub_sms_0" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('sub_sms_0', "URGENT: Your {service_name} expires TODAY. Please pay {cost} immediately to avoid disruption.")) ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">14-Days WhatsApp Template</label>
                    <textarea name="sub_wa_14" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('sub_wa_14', "Hello {client_name}! ⏳ Your {service_name} subscription is due for renewal on *{due_date}*. The cost is *{cost}*.\n\nPlease process payment soon to avoid downtime.")) ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Due-Date WhatsApp Template</label>
                    <textarea name="sub_wa_0" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none text-slate-850"><?= e(Settings::get('sub_wa_0', "Hello {client_name}! ⚠️ Your {service_name} subscription expires *TODAY*. Please process your payment of *{cost}* immediately.")) ?></textarea>
                </div>
            </div>

            <hr class="border-slate-100">

            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3.5 rounded-xl text-xs shadow-md transition-all">Save Config Configurations</button>
            </div>
        </form>
    </div>
</div>
