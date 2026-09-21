

<?php $__env->startSection('title', 'System Logs - SkillUp Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">

    
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">System Logs</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">System Logs</span>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logExists): ?>
                    <a href="<?php echo e(route('admin.systemlog.download')); ?>"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-download text-gray-500"></i> Download
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logExists): ?>
                    <form method="POST" action="<?php echo e(route('admin.systemlog.clear')); ?>"
                          onsubmit="return confirm('Clear the entire log file? This cannot be undone.')">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                            <i class="fas fa-trash-alt"></i> Clear Log
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="p-3 bg-cyan-100 rounded-lg">
                    <i class="fas fa-scroll text-cyan-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-5 py-4">
                <i class="fas fa-check-circle text-green-500 shrink-0"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-lg px-5 py-4">
                <i class="fas fa-exclamation-circle text-red-500 shrink-0"></i>
                <span><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 rounded-lg <?php echo e($logExists ? 'bg-green-100' : 'bg-gray-100'); ?>">
                    <i class="fas fa-file-alt text-lg <?php echo e($logExists ? 'text-green-600' : 'text-gray-400'); ?>"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Log File</p>
                    <p class="text-sm font-semibold text-gray-800"><?php echo e($logExists ? 'laravel.log' : 'Not found'); ?></p>
                </div>
            </div>

            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-weight-hanging text-blue-600 text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">File Size</p>
                    <p class="text-sm font-semibold text-gray-800">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logExists): ?>
                            <?php
                                $kb = round($logSize / 1024, 1);
                                $mb = round($logSize / 1024 / 1024, 2);
                            ?>
                            <?php echo e($mb >= 1 ? $mb . ' MB' : $kb . ' KB'); ?>

                        <?php else: ?>
                            —
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                </div>
            </div>

            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-list-ol text-purple-600 text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Entries</p>
                    <p class="text-sm font-semibold text-gray-800"><?php echo e(number_format($total)); ?></p>
                </div>
            </div>

            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Last Modified</p>
                    <p class="text-sm font-semibold text-gray-800">
                        <?php echo e($lastModified ? $lastModified->diffForHumans() : '—'); ?>

                    </p>
                </div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logExists && $total > 0): ?>
        <div class="flex flex-wrap gap-3 mb-6">
            <?php
                $levelConfig = [
                    'emergency' => ['bg-red-700',    'text-white',      'fa-radiation'],
                    'alert'     => ['bg-red-600',    'text-white',      'fa-bell'],
                    'critical'  => ['bg-red-500',    'text-white',      'fa-times-circle'],
                    'error'     => ['bg-red-400',    'text-white',      'fa-exclamation-circle'],
                    'warning'   => ['bg-yellow-400', 'text-yellow-900', 'fa-exclamation-triangle'],
                    'notice'    => ['bg-blue-400',   'text-white',      'fa-info'],
                    'info'      => ['bg-blue-500',   'text-white',      'fa-info-circle'],
                    'debug'     => ['bg-gray-400',   'text-white',      'fa-bug'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $levelConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl => [$bg, $text, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php $count = $levelCounts->get($lvl, 0); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($count > 0): ?>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['level' => $lvl, 'page' => 1])); ?>"
                       class="<?php echo e($bg); ?> <?php echo e($text); ?> inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold hover:opacity-80 transition <?php echo e($filterLevel === $lvl ? 'ring-2 ring-offset-1 ring-gray-700' : ''); ?>">
                        <i class="fas <?php echo e($icon); ?>"></i>
                        <?php echo e(ucfirst($lvl)); ?> <span class="opacity-80">(<?php echo e($count); ?>)</span>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterLevel !== ''): ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['level' => '', 'page' => 1])); ?>"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    <i class="fas fa-times"></i> Clear filter
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 mb-6">
            <form method="GET" action="<?php echo e(route('admin.systemlog')); ?>" class="flex flex-wrap gap-3 items-end">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterLevel !== ''): ?>
                    <input type="hidden" name="level" value="<?php echo e($filterLevel); ?>">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="flex-1min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Search message</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fas fa-search text-sm"></i>
                        </span>
                        <input type="text" name="search" value="<?php echo e($filterSearch); ?>"
                               placeholder="Search log messages…"
                               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Level</label>
                    <select name="level"
                            class="py-2 pl-3 pr-8 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 outline-none bg-white">
                        <option value="">All levels</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = array_keys($levelConfig); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($lvl); ?>" <?php echo e($filterLevel === $lvl ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($lvl)); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg transition">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="<?php echo e(route('admin.systemlog')); ?>"
                       class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $logExists): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-16 text-center">
                <i class="fas fa-file-slash text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">No log file found</p>
                <p class="text-gray-400 text-sm mt-1">The Laravel log file does not exist yet. It will be created automatically when events are logged.</p>
            </div>
        <?php elseif($total === 0): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-16 text-center">
                <i class="fas fa-check-circle text-5xl text-green-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">No log entries match your filter</p>
                <a href="<?php echo e(route('admin.systemlog')); ?>" class="text-cyan-500 text-sm hover:underline mt-2 inline-block">Clear filters</a>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-semibold"><?php echo e(($page - 1) * 100 + 1); ?></span>–<span class="font-semibold"><?php echo e(min($page * 100, $total)); ?></span> of <span class="font-semibold"><?php echo e(number_format($total)); ?></span> entries
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterLevel || $filterSearch): ?>
                            <span class="ml-2 text-cyan-600">(filtered)</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                    <p class="text-xs text-gray-400">Newest first</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-3 text-left w-40">Timestamp</th>
                                <th class="px-4 py-3 text-left w-20">Channel</th>
                                <th class="px-4 py-3 text-left w-24">Level</th>
                                <th class="px-4 py-3 text-left">Message</th>
                                <th class="px-4 py-3 text-center w-16">Context</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paginated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $lvl = $entry['level'];
                                    $rowColor = match($lvl) {
                                        'emergency', 'alert', 'critical' => 'bg-red-50',
                                        'error'   => 'bg-red-50/60',
                                        'warning' => 'bg-yellow-50',
                                        'notice'  => 'bg-blue-50/40',
                                        'debug'   => 'bg-gray-50/60',
                                        default   => '',
                                    };
                                    [$badgeBg, $badgeText, $badgeIcon] = $levelConfig[$lvl] ?? ['bg-gray-200', 'text-gray-700', 'fa-circle'];
                                ?>
                                <tr class="<?php echo e($rowColor); ?> hover:bg-opacity-80 transition-colors">
                                    <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap font-mono">
                                        <?php echo e($entry['timestamp']); ?>

                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-600 whitespace-nowrap">
                                        <?php echo e($entry['channel']); ?>

                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="<?php echo e($badgeBg); ?> <?php echo e($badgeText); ?> inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold">
                                            <i class="fas <?php echo e($badgeIcon); ?> text-[10px]"></i>
                                            <?php echo e(ucfirst($lvl)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 break-all max-w-lg">
                                        <span class="line-clamp-2"><?php echo e($entry['message']); ?></span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(trim($entry['context']) !== ''): ?>
                                            <button type="button"
                                                    onclick="toggleContext(<?php echo e($i); ?>)"
                                                    class="text-cyan-500 hover:text-cyan-700 transition"
                                                    title="Toggle stack trace">
                                                <i class="fas fa-chevron-down" id="icon-<?php echo e($i); ?>"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="text-gray-300">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(trim($entry['context']) !== ''): ?>
                                    <tr id="context-<?php echo e($i); ?>" class="hidden <?php echo e($rowColor); ?>">
                                        <td colspan="5" class="px-6 py-3">
                                            <pre class="text-xs text-gray-600 bg-gray-900/5 rounded p-3 overflow-x-auto whitespace-pre-wrap break-all"><?php echo e(trim($entry['context'])); ?></pre>
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalPages > 1): ?>
                    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">Page <?php echo e($page); ?> of <?php echo e($totalPages); ?></p>
                        <div class="flex gap-1">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page > 1): ?>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $page - 1])); ?>"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php
                                $start = max(1, $page - 2);
                                $end   = min($totalPages, $page + 2);
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start > 1): ?>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => 1])); ?>"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">1</a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start > 2): ?>
                                    <span class="px-2 py-1.5 text-sm text-gray-400">…</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($p = $start; $p <= $end; $p++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $p])); ?>"
                                   class="px-3 py-1.5 text-sm border rounded-lg transition
                                          <?php echo e($p === $page ? 'bg-cyan-500 text-white border-cyan-500' : 'border-gray-300 hover:bg-gray-50'); ?>">
                                    <?php echo e($p); ?>

                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($end < $totalPages): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($end < $totalPages - 1): ?>
                                    <span class="px-2 py-1.5 text-sm text-gray-400">…</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $totalPages])); ?>"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition"><?php echo e($totalPages); ?></a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page < $totalPages): ?>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $page + 1])); ?>"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div>

<script>
    function toggleContext(id) {
        const row  = document.getElementById('context-' + id);
        const icon = document.getElementById('icon-' + id);
        const hidden = row.classList.toggle('hidden');
        icon.classList.toggle('fa-chevron-down', hidden);
        icon.classList.toggle('fa-chevron-up', !hidden);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\systemlog.blade.php ENDPATH**/ ?>