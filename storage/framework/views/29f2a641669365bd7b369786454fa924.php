<?php $__env->startSection('title', $lga->lga_name . ' — LGA Results'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $lgaResults = $results;
    $totalVotes = $total_votes;
    $runnerUp = $runner_up;
    $puCount = $polling_unit_count;
    $chartColors = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1'];
?>

<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['links' => [
        ['label' => 'LGA Results', 'url' => route('lga.index')],
        ['label' => $lga->lga_name]
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'LGA Results', 'url' => route('lga.index')],
        ['label' => $lga->lga_name]
    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                <?php echo e($lga->lga_name); ?>

            </h1>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Aggregated results from <?php echo e(number_format($puCount)); ?> polling units
            </p>
        </div>
        <div class="flex items-center gap-3" x-show="loaded" x-transition>
            <a href="<?php echo e(route('lga.index')); ?>"
               class="no-print inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                Back
            </a>
            <a href="<?php echo e(route('pdf.lga', $lga->uniqueid)); ?>"
               class="no-print inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="download" class="h-4 w-4" aria-hidden="true"></i>
                Export PDF
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 no-print">
                <i data-lucide="printer" class="h-4 w-4" aria-hidden="true"></i>
                Print
            </button>
        </div>
    </div>

    
    <?php if($winner): ?>
        <div class="mb-8 rounded-xl border-2 border-emerald-200 bg-gradient-to-r from-emerald-50 to-green-50 p-6 shadow-sm dark:border-emerald-800 dark:from-emerald-900/20 dark:to-green-900/20"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 shrink-0">
                    <i data-lucide="trophy" class="h-7 w-7 text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-1">Declared Winner</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white"><?php echo e($winner['party_name']); ?></p>
                    <div class="flex flex-wrap items-center gap-3 mt-1.5">
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 tabular-nums">
                            <?php echo e(number_format($winner['total_score'])); ?> votes
                        </span>
                        <?php if($totalVotes > 0): ?>
                            <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-400 tabular-nums">
                                <?php echo e(round(($winner['total_score'] / $totalVotes) * 100, 1)); ?>% of total
                            </span>
                        <?php endif; ?>
                        <?php if($runnerUp): ?>
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Margin: <?php echo e(number_format($margin)); ?> votes ahead of <?php echo e($runnerUp['party_name']); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
         x-show="loaded"
         x-transition:enter="transition duration-500 ease-out delay-100"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Polling Units','value' => ''.e(number_format($puCount)).'','icon' => 'map-pin','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Polling Units','value' => ''.e(number_format($puCount)).'','icon' => 'map-pin','color' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Total Votes','value' => ''.e(number_format($totalVotes)).'','icon' => 'bar-chart-2','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Votes','value' => ''.e(number_format($totalVotes)).'','icon' => 'bar-chart-2','color' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Winning Party','value' => ''.e($winner ? $winner['party_name'] : '—').'','icon' => 'trophy','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Winning Party','value' => ''.e($winner ? $winner['party_name'] : '—').'','icon' => 'trophy','color' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Margin of Victory','value' => ''.e(number_format($margin ?? 0)).'','icon' => 'trending-up','color' => 'purple']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Margin of Victory','value' => ''.e(number_format($margin ?? 0)).'','icon' => 'trending-up','color' => 'purple']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
    </div>

    <?php if(!empty($lgaResults)): ?>
        
        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">

            
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-5">Party Vote Comparison</h3>
                <div class="space-y-3">
                    <?php $__currentLoopData = $lgaResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pct = $totalVotes > 0 ? round(($result['total_score'] / $totalVotes) * 100, 1) : 0;
                            $color = $chartColors[$index % count($chartColors)];
                            $isTop = $index === 0;
                        ?>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate"><?php echo e($result['party_name']); ?></span>
                                    <?php if($isTop): ?>
                                        <span class="inline-flex items-center rounded bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 shrink-0">1st</span>
                                    <?php endif; ?>
                                </div>
                                <span class="text-xs font-semibold tabular-nums text-slate-600 dark:text-slate-400 shrink-0 ml-3">
                                    <?php echo e(number_format($result['total_score'])); ?> <span class="text-slate-400 dark:text-slate-500">(<?php echo e($pct); ?>%)</span>
                                </span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000 ease-out"
                                     style="width: 0%; background-color: <?php echo e($color); ?>"
                                     x-init="$nextTick(() => $el.style.width = '<?php echo e($pct); ?>%')"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-5">Vote Distribution</h3>
                <div class="flex items-center justify-center">
                    <div class="relative w-52 h-52">
                        <?php
                            $cumulative = 0;
                            $gradientParts = [];
                            foreach($lgaResults as $i => $r) {
                                $pct = $totalVotes > 0 ? ($r['total_score'] / $totalVotes) * 100 : 0;
                                $color = $chartColors[$i % count($chartColors)];
                                $start = $cumulative;
                                $cumulative += $pct;
                                $gradientParts[] = "{$color} {$start}% {$cumulative}%";
                            }
                        ?>
                        <div class="w-52 h-52 rounded-full shadow-inner"
                             style="background: conic-gradient(<?php echo e(implode(', ', $gradientParts)); ?>)">
                            <div class="absolute inset-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white tabular-nums"><?php echo e(number_format($totalVotes)); ?></p>
                                    <p class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Votes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <?php $__currentLoopData = $lgaResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $color = $chartColors[$i % count($chartColors)]; ?>
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="h-2.5 w-2.5 rounded-full shrink-0" style="background-color: <?php echo e($color); ?>" aria-hidden="true"></span>
                            <span class="text-[11px] text-slate-600 dark:text-slate-400 truncate"><?php echo e($result['party_name']); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        
        <div x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <?php if (isset($component)) { $__componentOriginalc8463834ba515134d5c98b88e1a9dc03 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8463834ba515134d5c98b88e1a9dc03 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.data-table','data' => ['title' => 'Aggregated Results','subtitle' => ''.e($lga->lga_name).' — All polling units combined']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Aggregated Results','subtitle' => ''.e($lga->lga_name).' — All polling units combined']); ?>
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rank</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Party</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Votes</th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Percentage</th>
                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Share</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    <?php $__currentLoopData = $lgaResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pct = $totalVotes > 0 ? round(($result['total_score'] / $totalVotes) * 100, 1) : 0;
                            $isWinner = $index === 0 && $result['total_score'] > 0;
                            $barColor = $chartColors[$index % count($chartColors)];
                        ?>
                        <tr class="<?php echo e($isWinner ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50'); ?> transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <?php if($isWinner): ?>
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        <i data-lucide="crown" class="h-3.5 w-3.5" aria-hidden="true"></i>
                                    </span>
                                <?php else: ?>
                                    <span class="text-sm font-medium text-slate-400 dark:text-slate-500 pl-1.5"><?php echo e($index + 1); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($result['party_name']); ?></span>
                                    <?php if($isWinner): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            Winner
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <span class="text-sm font-bold tabular-nums text-slate-900 dark:text-white"><?php echo e(number_format($result['total_score'])); ?></span>
                            </td>
                            <td class="px-6 py-4 text-right hidden sm:table-cell">
                                <span class="text-sm tabular-nums text-slate-600 dark:text-slate-400"><?php echo e($pct); ?>%</span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="w-full max-w-[200px]">
                                    <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-1000 ease-out" style="width: <?php echo e($pct); ?>%; background-color: <?php echo e($barColor); ?>"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 dark:bg-slate-900/50">
                        <td colspan="2" class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">Total</td>
                        <td class="px-4 sm:px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white"><?php echo e(number_format($totalVotes)); ?></td>
                        <td class="px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white hidden sm:table-cell">100%</td>
                        <td class="hidden md:table-cell"></td>
                    </tr>
                </tfoot>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8463834ba515134d5c98b88e1a9dc03)): ?>
<?php $attributes = $__attributesOriginalc8463834ba515134d5c98b88e1a9dc03; ?>
<?php unset($__attributesOriginalc8463834ba515134d5c98b88e1a9dc03); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8463834ba515134d5c98b88e1a9dc03)): ?>
<?php $component = $__componentOriginalc8463834ba515134d5c98b88e1a9dc03; ?>
<?php unset($__componentOriginalc8463834ba515134d5c98b88e1a9dc03); ?>
<?php endif; ?>
        </div>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No results available','description' => 'There are no recorded results for polling units in this LGA.','icon' => 'bar-chart-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No results available','description' => 'There are no recorded results for polling units in this LGA.','icon' => 'bar-chart-3']); ?>
             <?php $__env->slot('action', null, []); ?> 
                <a href="<?php echo e(route('lga.index')); ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                    Select Another LGA
                </a>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/lga/results.blade.php ENDPATH**/ ?>