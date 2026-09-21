<?php $__env->startSection('title', 'Conversation - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<div class="chat-shell py-6 md:py-10">
    <div class="mx-auto max-w-5xl">
        <div class="grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
            <aside data-page-animate class="chat-panel overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <div class="chat-hero relative px-6 py-6 text-white">
                    <div class="relative z-[1]">
                        <a href="<?php echo e(route('chats.index')); ?>" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/80 transition hover:bg-white/15 hover:text-white hover:-translate-y-0.5">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                            Inbox
                        </a>

                        <div class="mt-6 flex items-center gap-4">
                            <div class="chat-avatar-xl bg-white text-slate-900 shadow-lg ring-4 ring-white/20">
                                <?php echo e(strtoupper(substr($otherParticipant->name, 0, 1))); ?>

                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Support contact</p>
                                <h1 class="mt-1 text-2xl font-black tracking-tight"><?php echo e($otherParticipant->name); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 px-6 py-6">
                    <div data-page-animate class="page-delay-1 rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Topic</p>
                        <p class="mt-2 text-sm font-semibold text-slate-800">
                            <?php echo e($conversation->subject ?: 'General support and account assistance'); ?>

                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                        <div data-page-animate class="page-delay-2 rounded-2xl border border-slate-200 px-4 py-4 transition hover:border-sky-200 hover:shadow-md">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Member since</p>
                            <p class="mt-2 text-sm font-semibold text-slate-800"><?php echo e($otherParticipant->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div data-page-animate class="page-delay-3 rounded-2xl border border-slate-200 px-4 py-4 transition hover:border-sky-200 hover:shadow-md">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Messages</p>
                            <p class="mt-2 text-sm font-semibold text-slate-800"><?php echo e($messages->count()); ?> in this thread</p>
                        </div>
                    </div>

                    <p data-page-animate class="page-delay-4 text-sm leading-6 text-slate-500">
                        Keep your replies focused and specific so the support team can resolve issues faster.
                    </p>
                </div>
            </aside>

            <section data-page-animate class="page-delay-1 chat-panel flex min-h-[calc(100vh-10rem)] flex-col overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <header class="border-b border-slate-100 px-5 py-5 sm:px-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Conversation</p>
                            <h2 class="mt-1 text-xl font-black tracking-tight text-slate-900"><?php echo e($otherParticipant->name); ?></h2>
                            <p class="mt-1 text-sm text-slate-500">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversation->last_message_at): ?>
                                    Last update <?php echo e($conversation->last_message_at->diffForHumans()); ?>

                                <?php else: ?>
                                    New thread
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-2 self-start rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            <span class="chat-live-dot h-2 w-2 rounded-full bg-emerald-500"></span>
                            Support online
                        </span>
                    </div>
                </header>

                <div id="chat-thread" class="chat-thread flex-1 space-y-5 overflow-y-auto px-5 py-6 sm:px-6 scroll-smooth">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php echo $__env->make('chats._message', [
                            'message' => $message,
                            'isOwn' => $message->sender_id === auth()->id(),
                            'index' => $loop->index,
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="chat-empty-state flex h-full min-h-80 items-center justify-center">
                            <div class="max-w-sm text-center text-slate-500">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-slate-100 to-sky-50 text-sky-500">
                                    <i class="fas fa-paper-plane text-2xl"></i>
                                </div>
                                <h3 class="mt-5 text-lg font-bold text-slate-900">Start the conversation</h3>
                                <p class="mt-2 text-sm leading-6">Ask a question, report a problem, or request learning support.</p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <form action="<?php echo e(route('chats.store')); ?>" method="POST" class="border-t border-slate-100 bg-slate-50/80 px-5 py-5 sm:px-6">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="conversation_id" value="<?php echo e($conversation->id); ?>">

                    <label for="body" class="mb-3 block text-sm font-semibold text-slate-700">Reply</label>
                    <textarea
                        id="body"
                        name="body"
                        rows="4"
                        placeholder="Type your message here..."
                        class="chat-input w-full <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-400 ring-rose-100 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    ><?php echo e(old('body')); ?></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-rose-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Responses are saved immediately in this thread.</p>
                        <div class="flex gap-3">
                            <a href="<?php echo e(route('chats.index')); ?>" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 min-h-0">
                                Back
                            </a>
                            <button type="submit" class="chat-send-btn inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 min-h-0">
                                <i class="fas fa-paper-plane text-xs"></i>
                                Send message
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php echo $__env->make('partials.page-animate', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thread = document.getElementById('chat-thread');
        const body = document.getElementById('body');

        if (thread) {
            thread.scrollTo({ top: thread.scrollHeight, behavior: 'smooth' });
        }

        if (body) {
            body.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    body.closest('form').requestSubmit();
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\chats\show.blade.php ENDPATH**/ ?>