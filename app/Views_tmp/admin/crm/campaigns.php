<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Marketing Campaigns</h1>
        <p class="text-sm text-slate-500">Send promotional messages via Email, SMS, or WhatsApp to all CRM customers.</p>
    </div>
    <div>
        <a href="<?= url('/admin/crm') ?>" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to CRM
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Compose Campaign -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-800"><i class="fa-solid fa-paper-plane mr-2 text-indigo-600"></i> New Campaign</h3>
            </div>
            <div class="p-6">
                <form action="<?= url('/admin/crm/campaigns/send') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Channel</label>
                        <select name="type" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none text-slate-800 font-medium transition-all" required>
                            <option value="Email">Email Broadcast</option>
                            <option value="SMS">SMS (Termii)</option>
                            <option value="WhatsApp">WhatsApp (Termii)</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Subject (For Email)</label>
                        <input type="text" name="subject" placeholder="e.g. Special Offer!" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none text-slate-800 transition-all">
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Message Body</label>
                        <textarea name="message" rows="6" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-xl px-4 py-3 text-sm outline-none text-slate-800 transition-all" required placeholder="Type your promotional message here..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all flex justify-center items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Send Campaign
                    </button>
                    <p class="text-[10px] text-center text-slate-400 mt-3">Messages will be sent to all customers in your CRM.</p>
                </form>
            </div>
        </div>
    </div>

    <!-- Campaign History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Campaign History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold border-b border-slate-200">Date Sent</th>
                            <th class="p-4 font-semibold border-b border-slate-200">Channel</th>
                            <th class="p-4 font-semibold border-b border-slate-200">Message Preview</th>
                            <th class="p-4 font-semibold border-b border-slate-200 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($campaigns)): ?>
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400">
                                    <i class="fa-solid fa-history text-4xl mb-3 text-slate-200"></i>
                                    <p>No campaigns sent yet.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($campaigns as $camp): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 text-xs text-slate-500 whitespace-nowrap">
                                        <div class="font-bold text-slate-700"><?= date('M j, Y', strtotime($camp['sent_at'])) ?></div>
                                        <div class="text-[10px]"><?= date('h:i A', strtotime($camp['sent_at'])) ?></div>
                                    </td>
                                    <td class="p-4 text-sm font-medium text-slate-900">
                                        <?php if ($camp['type'] === 'Email'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-bold bg-blue-100 text-blue-700">
                                                <i class="fa-solid fa-envelope"></i> Email
                                            </span>
                                        <?php elseif ($camp['type'] === 'SMS'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-bold bg-purple-100 text-purple-700">
                                                <i class="fa-solid fa-comment-sms"></i> SMS
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-bold bg-emerald-100 text-emerald-700">
                                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-xs text-slate-600">
                                        <?php if ($camp['subject']): ?>
                                            <div class="font-bold mb-1">Sub: <?= e($camp['subject']) ?></div>
                                        <?php endif; ?>
                                        <div class="truncate max-w-[250px]" title="<?= e($camp['message']) ?>">
                                            <?= e($camp['message']) ?>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <?php if ($camp['status'] === 'Sent'): ?>
                                            <span class="text-xs font-bold text-emerald-600"><i class="fa-solid fa-check mr-1"></i> Sent</span>
                                        <?php else: ?>
                                            <span class="text-xs font-bold text-slate-400"><?= e($camp['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
