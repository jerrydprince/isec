<?php
use App\Models\Settings;
?>
<!-- Custom styling overrides for scrollbars and active selections -->
<style>
    .mail-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .mail-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .mail-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }
    .dark .mail-scroll::-webkit-scrollbar-thumb {
        background: #475569;
    }
</style>

<div class="space-y-6" x-data="{ 
    tab: 'inbox', 
    selectedEmail: null,
    emailsList: <?= htmlspecialchars(json_encode($emails), ENT_QUOTES, 'UTF-8') ?>,
    searchQuery: '',
    targetGroup: 'newsletter',
    get filteredEmails() {
        if (!this.searchQuery) return this.emailsList;
        const query = this.searchQuery.toLowerCase();
        return this.emailsList.filter(e => 
            e.from_name.toLowerCase().includes(query) || 
            e.from_email.toLowerCase().includes(query) || 
            e.subject.toLowerCase().includes(query)
        );
    }
}" x-init="if(emailsList.length > 0) { selectedEmail = emailsList[0]; }">

    <!-- Top Navigation Header -->
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-server text-indigo-600"></i> Corporate Webmail Center
            </h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Manage incoming client messages, draft custom templates, and execute secure broadcast campaigns from ISEC domain handles.</p>
        </div>
        
        <!-- Premium Navigation Tab controller -->
        <div class="bg-slate-200/80 dark:bg-slate-800 p-1 rounded-xl flex gap-1 self-start text-xs font-bold border border-slate-300/30">
            <button @click="tab = 'inbox'" :class="tab === 'inbox' ? 'bg-white dark:bg-slate-900 text-indigo-600 shadow-sm' : 'text-slate-550 hover:text-slate-850 dark:text-slate-400 dark:hover:text-white'" class="px-4 py-2.5 rounded-lg transition-all flex items-center gap-2">
                <i class="fa-solid fa-inbox text-[13px]"></i> Inbox (<?= count($emails) ?>)
            </button>
            <button @click="tab = 'compose'" :class="tab === 'compose' ? 'bg-white dark:bg-slate-900 text-indigo-600 shadow-sm' : 'text-slate-550 hover:text-slate-850 dark:text-slate-400 dark:hover:text-white'" class="px-4 py-2.5 rounded-lg transition-all flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-[13px]"></i> Compose Mail
            </button>
            <button @click="tab = 'broadcast'" :class="tab === 'broadcast' ? 'bg-white dark:bg-slate-900 text-indigo-600 shadow-sm' : 'text-slate-550 hover:text-slate-850 dark:text-slate-400 dark:hover:text-white'" class="px-4 py-2.5 rounded-lg transition-all flex items-center gap-2">
                <i class="fa-solid fa-bullhorn text-[13px]"></i> Bulk Broadcaster
            </button>
            <button @click="tab = 'settings'" :class="tab === 'settings' ? 'bg-white dark:bg-slate-900 text-indigo-600 shadow-sm' : 'text-slate-550 hover:text-slate-850 dark:text-slate-400 dark:hover:text-white'" class="px-4 py-2.5 rounded-lg transition-all flex items-center gap-2">
                <i class="fa-solid fa-gears text-[13px]"></i> Connection Config
            </button>
        </div>
    </div>

    <!-- Active Handles Switcher Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 shadow-md border border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] bg-[size:16px_16px]"></div>
        <div class="flex items-center gap-3.5 relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-accent text-xl border border-white/10 shadow-inner">
                <i class="fa-solid fa-envelope-circle-check"></i>
            </div>
            <div>
                <span class="text-[9px] text-slate-350 font-bold uppercase tracking-widest block">Operational Handler</span>
                <span class="text-base font-black text-accent tracking-wide"><?= e($activeAccount) ?></span>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2.5 relative z-10">
            <?php foreach (['info@isecltd.ng', 'admin@isecltd.ng', 'contact@isecltd.ng', 'jerry@isecltd.ng'] as $account): ?>
                <a href="<?= url('/admin/mail?account=' . $account) ?>" 
                   class="px-4 py-2.5 rounded-2ch text-xs font-bold transition-all border <?= $activeAccount === $account ? 'bg-accent border-accent text-white shadow-lg shadow-accent/20' : 'bg-white/5 border-white/10 hover:bg-white/15 text-slate-200' ?>">
                    <?= explode('@', $account)[0] ?>@
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- IMAP Sandbox Warn Alerts -->
    <?php if (!$imapEnabled): ?>
        <div class="bg-gradient-to-r from-amber-500/10 to-amber-600/5 border border-amber-500/20 rounded-2xl p-4 flex gap-3 text-xs text-amber-800 dark:text-amber-300 font-medium">
            <div class="text-amber-500 text-lg"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="space-y-0.5">
                <p class="font-bold">cPanel Connection Simulator Active</p>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-light leading-relaxed">The PHP `imap` extension is disabled locally on this machine (`php.ini`). Incoming mail logs are running in fallback sandbox developer mode displaying cached/mock records. Outgoing SMTP composed and broadcast operations will still connect normally if hosts are configured.</p>
            </div>
        </div>
    <?php elseif (!empty($imapError)): ?>
        <div class="bg-rose-500/5 border border-rose-500/15 rounded-2xl p-4 flex gap-3 text-xs text-rose-800 dark:text-rose-350 font-medium">
            <div class="text-rose-500 text-lg"><i class="fa-solid fa-server"></i></div>
            <div class="space-y-0.5">
                <p class="font-bold">Mail Connection Server Alert</p>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-light leading-relaxed"><?= e($imapError) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- ==================================================== -->
    <!-- TAB: INBOX LAYOUT (Premium Outlook Style Split Pane) -->
    <!-- ==================================================== -->
    <div x-show="tab === 'inbox'" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch" x-transition>
        
        <!-- Left Pane: Mail Index List (5 Cols) -->
        <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col h-[600px]">
            <!-- List Header Search -->
            <div class="p-4 border-b border-slate-100 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Inquiry Logs</span>
                    <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-black uppercase">cPanel Sync</span>
                </div>
                <div class="relative">
                    <input x-model="searchQuery" type="text" placeholder="Search by sender, email, subject..." class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl pl-9 pr-4 py-2.5 text-xs outline-none transition-all text-slate-800 placeholder-slate-400">
                    <div class="absolute left-3.5 top-3.5 text-slate-400 text-[11px]"><i class="fa-solid fa-magnifying-glass"></i></div>
                </div>
            </div>
            
            <!-- List Scroll Box -->
            <div class="flex-1 overflow-y-auto mail-scroll divide-y divide-slate-50">
                <template x-if="filteredEmails.length === 0">
                    <div class="p-8 text-center text-slate-400 text-xs font-medium">
                        <i class="fa-regular fa-envelope-open text-xl mb-2 block text-slate-300"></i> No emails matching search terms.
                    </div>
                </template>
                <template x-for="email in filteredEmails" :key="email.uid">
                    <div @click="selectedEmail = email" 
                         :class="selectedEmail && selectedEmail.uid === email.uid ? 'bg-indigo-50/50 border-l-4 border-indigo-600' : 'hover:bg-slate-50/50 border-l-4 border-transparent'" 
                         class="p-4 transition-all cursor-pointer flex flex-col gap-1.5 border-b border-slate-100/50">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-900 text-xs truncate max-w-[150px]" x-text="email.from_name"></span>
                            <span class="text-[9px] text-slate-400 font-bold" x-text="email.date"></span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-xs truncate" x-text="email.subject"></h4>
                        <p class="text-[10px] text-slate-500 font-light truncate" x-text="email.body"></p>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Right Pane: Mail Reading Pane (7 Cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col h-[600px] overflow-hidden relative">
            <template x-if="selectedEmail">
                <div class="flex flex-col h-full">
                    <!-- Reading Pane Header -->
                    <div class="p-6 border-b border-slate-150 bg-slate-50/50 flex flex-col gap-4">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-700 border border-slate-300 text-sm" x-text="selectedEmail.from_name.charAt(0)"></div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-sm" x-text="selectedEmail.from_name"></h3>
                                    <span class="text-[10px] text-slate-450 font-semibold" x-text="selectedEmail.from_email"></span>
                                </div>
                            </div>
                            <span class="text-[9px] bg-indigo-50 border border-indigo-100 text-indigo-600 px-2.5 py-1 rounded font-bold uppercase" x-text="selectedEmail.date"></span>
                        </div>
                        <h2 class="text-base font-black text-slate-900 tracking-tight" x-text="selectedEmail.subject"></h2>
                    </div>
                    
                    <!-- Reading Pane Body -->
                    <div class="flex-1 p-6 overflow-y-auto mail-scroll text-slate-750 text-xs font-light leading-relaxed whitespace-pre-line" x-text="selectedEmail.body"></div>
                    
                    <!-- Reading Pane Action Footer -->
                    <div class="p-4 border-t border-slate-150 bg-slate-50/30 flex justify-end gap-2">
                        <button @click="tab = 'compose'; $nextTick(() => { document.getElementsByName('to')[0].value = selectedEmail.from_email; document.getElementsByName('subject')[0].value = 'Re: ' + selectedEmail.subject; })" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition-all">
                            <i class="fa-solid fa-reply"></i> Reply
                        </button>
                    </div>
                </div>
            </template>
            <template x-if="!selectedEmail">
                <div class="flex flex-col items-center justify-center h-full text-center p-8 space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300 text-2xl border border-slate-100">
                        <i class="fa-regular fa-envelope-open"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Select Email to Read</h3>
                    <p class="text-[10px] text-slate-400 font-light max-w-xs">Click on any inquiry message from the index on the left to review its content and metadata.</p>
                </div>
            </template>
        </div>
    </div>

    <!-- ==================================================== -->
    <!-- TAB: COMPOSE PANE (Premium form) -->
    <!-- ==================================================== -->
    <div x-show="tab === 'compose'" x-transition>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 max-w-4xl">
            <form action="<?= url('/admin/mail/compose') ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>
                
                <h3 class="text-sm font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2"><i class="fa-solid fa-signature text-indigo-500"></i> New Outgoing Mail</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">From Address *</label>
                        <select name="from" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                            <option value="info@isecltd.ng" <?= $activeAccount === 'info@isecltd.ng' ? 'selected' : '' ?>>info@isecltd.ng</option>
                            <option value="admin@isecltd.ng" <?= $activeAccount === 'admin@isecltd.ng' ? 'selected' : '' ?>>admin@isecltd.ng</option>
                            <option value="contact@isecltd.ng" <?= $activeAccount === 'contact@isecltd.ng' ? 'selected' : '' ?>>contact@isecltd.ng</option>
                            <option value="jerry@isecltd.ng" <?= $activeAccount === 'jerry@isecltd.ng' ? 'selected' : '' ?>>jerry@isecltd.ng</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">To (Recipient Address) *</label>
                        <input type="email" name="to" placeholder="client@domain.com" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Subject *</label>
                    <input type="text" name="subject" placeholder="Integrated Systems Architecture Audit Follow-up" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email Body (HTML/Rich-Text Support) *</label>
                    <textarea name="body" rows="10" placeholder="<h3>Dear Partner,</h3><p>Detail audit records...</p>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all font-mono text-slate-800" required></textarea>
                </div>

                <hr class="border-slate-100">
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3.5 rounded-xl text-xs shadow-md transition-all">
                        <i class="fa-solid fa-paper-plane mr-1.5"></i> Send Individual Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================================================== -->
    <!-- TAB: BULK BROADCASTER (Marketing Campaign) -->
    <!-- ==================================================== -->
    <div x-show="tab === 'broadcast'" x-transition>
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-stretch">
            
            <!-- Left Broadcaster Form (7 Cols) -->
            <div class="xl:col-span-8 bg-white rounded-3xl border border-slate-200 shadow-sm p-8 flex flex-col justify-between">
                <form action="<?= url('/admin/mail/bulk') ?>" method="POST" class="space-y-6">
                    <?= csrf_field() ?>
                    
                    <h3 class="text-sm font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2"><i class="fa-solid fa-bullhorn text-indigo-500"></i> Compose Broadcast Bulletin</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Send From handle *</label>
                            <select name="from" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                                <option value="info@isecltd.ng">info@isecltd.ng</option>
                                <option value="admin@isecltd.ng">admin@isecltd.ng</option>
                                <option value="contact@isecltd.ng">contact@isecltd.ng</option>
                                <option value="jerry@isecltd.ng">jerry@isecltd.ng</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Target Audience *</label>
                            <select name="target_group" x-model="targetGroup" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                                <option value="newsletter">Newsletter Subscribers Only</option>
                                <option value="all">All Contacts & Subscribers (Inboxes + Newsletters)</option>
                                <option value="manual">Manual Email List (Comma-separated)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Manual CSV Emails list -->
                    <div x-show="targetGroup === 'manual'" x-transition>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Manual CSV Recipients *</label>
                        <input type="text" name="manual_emails" placeholder="client1@domain.com, client2@domain.com, lead@isecltd.ng" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                        <span class="text-[9px] text-slate-400 mt-1 block">Separate multiple email addresses with a comma.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Campaign Bulletin Title *</label>
                        <input type="text" name="subject" placeholder="[ISEC System Bulletins] Q3 Systems Efficiency Frameworks" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">HTML Broadcast Body content (HTML templates supported) *</label>
                        <textarea name="body" rows="10" placeholder="<h2>Operational Excellence Guide</h2><p>Our team has documented the following blueprints...</p>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all font-mono text-slate-850" required></textarea>
                    </div>

                    <hr class="border-slate-100">
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3.5 rounded-xl text-xs shadow-md transition-all">
                            <i class="fa-solid fa-bullhorn mr-1.5"></i> Launch Bulk Campaign
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Right Subscribers Panel (4 Cols) -->
            <div class="xl:col-span-4 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between h-[650px] overflow-hidden self-start">
                <div class="space-y-4 h-full flex flex-col">
                    <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Broadcast Lists</h3>
                            <p class="text-[9px] text-slate-400 font-light mt-0.5">Active newsletter users log records</p>
                        </div>
                        <span class="text-xs bg-indigo-50 text-indigo-600 font-black px-2 py-0.5 rounded"><?= count($subscribers) ?> total</span>
                    </div>
                    
                    <!-- Subscribers Scroll List -->
                    <div class="flex-1 overflow-y-auto mail-scroll divide-y divide-slate-100">
                        <?php if (!empty($subscribers)): ?>
                            <?php foreach ($subscribers as $sub): ?>
                                <div class="py-3 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2 truncate">
                                        <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 text-[10px]"><i class="fa-solid fa-user"></i></div>
                                        <span class="font-bold text-slate-800 text-[11px] truncate max-w-[180px]" title="<?= e($sub['email']) ?>"><?= e($sub['email']) ?></span>
                                    </div>
                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-wider"><?= date('y-m-d', strtotime($sub['created_at'])) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-slate-400 font-medium text-xs text-center py-10">No active newsletter subscribers registered.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================================================== -->
    <!-- TAB: CONNECTION CONFIGURATION (Settings Form) -->
    <!-- ==================================================== -->
    <div x-show="tab === 'settings'" x-transition>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 max-w-4xl">
            <form action="<?= url('/admin/mail/settings') ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>
                
                <h3 class="text-sm font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2"><i class="fa-solid fa-server text-indigo-500"></i> Mail Server Parameters</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">IMAP Server Host *</label>
                        <input type="text" name="mail_imap_host" value="<?= e(Settings::get('mail_imap_host', 'mail.isecltd.ng')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">IMAP Port *</label>
                        <input type="text" name="mail_imap_port" value="<?= e(Settings::get('mail_imap_port', '993')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">IMAP Encryption</label>
                        <select name="mail_imap_encryption" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                            <option value="ssl" <?= Settings::get('mail_imap_encryption') === 'ssl' ? 'selected' : '' ?>>SSL (Recommended)</option>
                            <option value="tls" <?= Settings::get('mail_imap_encryption') === 'tls' ? 'selected' : '' ?>>TLS</option>
                            <option value="none" <?= Settings::get('mail_imap_encryption') === 'none' ? 'selected' : '' ?>>None</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">SMTP Server Host *</label>
                        <input type="text" name="mail_smtp_host" value="<?= e(Settings::get('mail_smtp_host', 'mail.isecltd.ng')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">SMTP Port *</label>
                        <input type="text" name="mail_smtp_port" value="<?= e(Settings::get('mail_smtp_port', '465')) ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">SMTP Encryption</label>
                        <select name="mail_smtp_encryption" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                            <option value="ssl" <?= Settings::get('mail_smtp_encryption', 'ssl') === 'ssl' ? 'selected' : '' ?>>SSL (Recommended)</option>
                            <option value="tls" <?= Settings::get('mail_smtp_encryption') === 'tls' ? 'selected' : '' ?>>TLS</option>
                            <option value="none" <?= Settings::get('mail_smtp_encryption') === 'none' ? 'selected' : '' ?>>None</option>
                        </select>
                    </div>
                </div>

                <h3 class="text-sm font-black text-slate-900 border-b border-slate-100 pb-3 pt-6 flex items-center gap-2"><i class="fa-solid fa-key text-indigo-500"></i> cPanel Mail Passwords</h3>
                <p class="text-[10px] text-slate-400 font-light -mt-2">Provide SMTP authentication credentials for your specific domain email handlers.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">info@isecltd.ng Password</label>
                        <input type="password" name="mail_pass_info" value="<?= e(Settings::get('mail_pass_info')) ?>" placeholder="••••••••••••" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">admin@isecltd.ng Password</label>
                        <input type="password" name="mail_pass_admin" value="<?= e(Settings::get('mail_pass_admin')) ?>" placeholder="••••••••••••" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">contact@isecltd.ng Password</label>
                        <input type="password" name="mail_pass_contact" value="<?= e(Settings::get('mail_pass_contact')) ?>" placeholder="••••••••••••" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">jerry@isecltd.ng Password</label>
                        <input type="password" name="mail_pass_jerry" value="<?= e(Settings::get('mail_pass_jerry')) ?>" placeholder="••••••••••••" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-xs outline-none transition-all text-slate-850">
                    </div>
                </div>

                <hr class="border-slate-100">
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3.5 rounded-xl text-xs shadow-md transition-all">
                        Save Server Configurations
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
