<?php $this->layout('layouts/main', ['title' => 'Payment Successful - ISEC']) ?>

<section class="py-24 bg-slate-50 dark:bg-slate-950 min-h-[70vh] flex items-center justify-center">
    <div class="max-w-2xl w-full mx-auto px-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 md:p-12 text-center shadow-lg">
            
            <?php if ($payment): ?>
                <div class="w-20 h-20 bg-teal-100 dark:bg-teal-900/50 text-teal-600 dark:text-teal-400 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-check text-4xl"></i>
                </div>
                
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2">Payment Successful!</h1>
                <p class="text-slate-500 dark:text-slate-400 mb-8">Thank you for subscribing to the <span class="font-bold text-slate-900 dark:text-white"><?= e($payment['plan']) ?></span>.</p>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 text-left mb-8 border border-slate-100 dark:border-slate-700">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Transaction Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Reference:</span>
                            <span class="font-mono text-slate-900 dark:text-white font-medium"><?= e($payment['reference']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Name:</span>
                            <span class="text-slate-900 dark:text-white font-medium"><?= e($payment['name']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Amount Paid:</span>
                            <span class="text-slate-900 dark:text-white font-medium">NGN <?= number_format($payment['amount'], 2) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Date:</span>
                            <span class="text-slate-900 dark:text-white font-medium"><?= date('M j, Y h:i A', strtotime($payment['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

                <p class="text-sm text-slate-500 dark:text-slate-400 mb-8">A confirmation email has been sent to <span class="font-medium text-slate-900 dark:text-white"><?= e($payment['email']) ?></span>.</p>

            <?php else: ?>
                
                <div class="w-20 h-20 bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-exclamation text-4xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2">Transaction Not Found</h1>
                <p class="text-slate-500 dark:text-slate-400 mb-8">We couldn't verify this transaction reference. If you believe this is an error, please contact support.</p>
                
            <?php endif; ?>

            <a href="<?= url('/') ?>" class="inline-block px-8 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold rounded-full text-sm hover:scale-105 transition-transform">
                Return to Home
            </a>
        </div>
    </div>
</section>
