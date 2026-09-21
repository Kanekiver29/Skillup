<?php
    $delay = min(($index ?? 0), 10) * 55;
?>

<article
    data-message-id="<?php echo e($message->id); ?>"
    data-updated-at="<?php echo e($message->updated_at->toIso8601String()); ?>"
    class="chat-message flex items-end gap-3 <?php echo e($isOwn ? 'justify-end' : 'justify-start'); ?>"
    style="animation-delay: <?php echo e($delay); ?>ms"
>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! ($isOwn)): ?>
        <div class="chat-avatar shrink-0 bg-white text-slate-900 shadow-sm ring-1 ring-slate-200">
            <?php echo e(strtoupper(substr($message->sender->name, 0, 1))); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="max-w-[88%] sm:max-w-[72%] <?php echo e($isOwn ? 'items-end' : 'items-start'); ?> flex flex-col gap-2">
        <div class="flex items-center gap-2 <?php echo e($isOwn ? 'justify-end' : 'justify-start'); ?>">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                <?php echo e($isOwn ? 'You' : $message->sender->name); ?>

            </p>
            <time class="text-xs text-slate-400" datetime="<?php echo e($message->created_at->toIso8601String()); ?>">
                <?php echo e($message->created_at->format('M d, H:i')); ?>

            </time>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOwn && $message->read_at): ?>
                <span class="ml-1 text-xs text-green-500">Read</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="chat-bubble <?php echo e($isOwn ? 'chat-bubble-own' : 'chat-bubble-other'); ?>">
            <p class="text-sm leading-6 whitespace-pre-wrap break-words"><?php echo e($message->body); ?></p>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOwn): ?>
        <div class="chat-avatar shrink-0 bg-slate-900 text-white shadow-lg shadow-slate-900/15">
            <?php echo e(strtoupper(substr($message->sender->name, 0, 1))); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</article>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\chats\_message.blade.php ENDPATH**/ ?>