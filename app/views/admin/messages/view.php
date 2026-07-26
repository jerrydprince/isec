<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Message Detail</h1>
            <p class="text-xs text-slate-500 font-light mt-0.5">Submitted inquiry from: <?= e($message['name']) ?></p>
        </div>
        <a href="<?= url('/admin/messages') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-800"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Inbox</a>
    </div>

    <!-- Message Detail Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-8 space-y-6">
        
        <!-- Metadata Header -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-100 text-xs">
            <div class="space-y-2">
                <div>
                    <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Sender Name</span>
                    <span class="font-semibold text-slate-800"><?= e($message['name']) ?></span>
                </div>
                <div>
                    <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Email Address</span>
                    <a href="mailto:<?= e($message['email']) ?>" class="font-semibold text-indigo-600 hover:underline"><?= e($message['email']) ?></a>
                </div>
                <div>
                    <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Phone Line</span>
                    <span class="font-semibold text-slate-700"><?= e($message['phone'] ?: 'Not Provided') ?></span>
                </div>
            </div>
            <div class="space-y-2">
                <div>
                    <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Company / Agency</span>
                    <span class="font-semibold text-slate-700"><?= e($message['company'] ?: 'Personal / Non-corporate') ?></span>
                </div>
                <div>
                    <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Country</span>
                    <span class="font-semibold text-slate-700"><?= e($message['country'] ?: 'Nigeria') ?></span>
                </div>
                <div>
                    <span class="font-bold text-slate-400 block uppercase tracking-wider mb-0.5">Interested Specialty</span>
                    <span class="px-2.5 py-0.5 rounded bg-indigo-50 text-indigo-600 font-bold uppercase tracking-wider text-[10px] inline-block mt-0.5"><?= e($message['service_interested'] ?: 'General Consults') ?></span>
                </div>
            </div>
        </div>

        <!-- Message Body -->
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Inquiry Message</h3>
            <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl text-slate-750 font-light text-sm leading-relaxed whitespace-pre-line">
                <?= e($message['message']) ?>
            </div>
        </div>

        <!-- Optional Attachment -->
        <?php if (!empty($message['attachment_path'])): ?>
            <div class="bg-indigo-50/20 border border-indigo-100 p-6 rounded-2xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-lg"><i class="fa-solid fa-file-pdf"></i></div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-800"><?= e(basename($message['attachment_path'])) ?></h4>
                        <p class="text-[10px] text-slate-400 font-medium">Uploaded by sender alongside message form.</p>
                    </div>
                </div>
                <a href="<?= url('/' . $message['attachment_path']) ?>" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-down"></i> Download Attachment
                </a>
            </div>
        <?php endif; ?>

        <hr class="border-slate-100">

        <!-- Action footer -->
        <div class="flex justify-between items-center text-xs">
            <span class="text-slate-400 font-medium">Received: <?= date('F d, Y H:i:s', strtotime($message['created_at'])) ?></span>
            <div class="flex gap-2">
                <a href="<?= url('/admin/messages/delete/' . $message['id']) ?>" onclick="return confirm('Are you sure you want to delete this message permanently?');" class="bg-rose-50 hover:bg-rose-600 text-rose-500 hover:text-white px-5 py-3 rounded-xl font-bold transition-all"><i class="fa-solid fa-trash-can"></i> Delete message permanently</a>
            </div>
        </div>

    </div>
</div>
