<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Dashboard
            </h1>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Election Results Overview
            </p>
        </div>
        <div class="flex items-center gap-3" x-show="loaded" x-transition>
            <a href="<?php echo e(route('pdf.dashboard')); ?>"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="download" class="h-4 w-4" aria-hidden="true"></i>
                <span class="hidden sm:inline">Export PDF</span>
                <span class="sm:hidden">PDF</span>
            </a>
        </div>
    </div>

    
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Total Polling Units','value' => ''.e(number_format($stats['total_polling_units'] ?? 0)).'','icon' => 'map-pin','color' => 'blue','xShow' => 'loaded','xTransition:enter' => 'transition duration-500 ease-out','xTransition:enterStart' => 'opacity-0 translate-y-4','xTransition:enterEnd' => 'opacity-100 translate-y-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Polling Units','value' => ''.e(number_format($stats['total_polling_units'] ?? 0)).'','icon' => 'map-pin','color' => 'blue','x-show' => 'loaded','x-transition:enter' => 'transition duration-500 ease-out','x-transition:enter-start' => 'opacity-0 translate-y-4','x-transition:enter-end' => 'opacity-100 translate-y-0']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Total LGAs','value' => ''.e(number_format($stats['total_lgas'] ?? 0)).'','icon' => 'building-2','color' => 'purple','xShow' => 'loaded','xTransition:enter' => 'transition duration-500 ease-out delay-100','xTransition:enterStart' => 'opacity-0 translate-y-4','xTransition:enterEnd' => 'opacity-100 translate-y-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total LGAs','value' => ''.e(number_format($stats['total_lgas'] ?? 0)).'','icon' => 'building-2','color' => 'purple','x-show' => 'loaded','x-transition:enter' => 'transition duration-500 ease-out delay-100','x-transition:enter-start' => 'opacity-0 translate-y-4','x-transition:enter-end' => 'opacity-100 translate-y-0']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Total Wards','value' => ''.e(number_format($stats['total_wards'] ?? 0)).'','icon' => 'users','color' => 'green','xShow' => 'loaded','xTransition:enter' => 'transition duration-500 ease-out delay-200','xTransition:enterStart' => 'opacity-0 translate-y-4','xTransition:enterEnd' => 'opacity-100 translate-y-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Wards','value' => ''.e(number_format($stats['total_wards'] ?? 0)).'','icon' => 'users','color' => 'green','x-show' => 'loaded','x-transition:enter' => 'transition duration-500 ease-out delay-200','x-transition:enter-start' => 'opacity-0 translate-y-4','x-transition:enter-end' => 'opacity-100 translate-y-0']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Political Parties','value' => ''.e(number_format($stats['total_parties'] ?? 0)).'','icon' => 'flag','color' => 'amber','xShow' => 'loaded','xTransition:enter' => 'transition duration-500 ease-out delay-300','xTransition:enterStart' => 'opacity-0 translate-y-4','xTransition:enterEnd' => 'opacity-100 translate-y-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Political Parties','value' => ''.e(number_format($stats['total_parties'] ?? 0)).'','icon' => 'flag','color' => 'amber','x-show' => 'loaded','x-transition:enter' => 'transition duration-500 ease-out delay-300','x-transition:enter-start' => 'opacity-0 translate-y-4','x-transition:enter-end' => 'opacity-100 translate-y-0']); ?>
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

    
    <div class="mb-8"
         x-show="loaded"
         x-transition:enter="transition duration-500 ease-out delay-200"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <h2 class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-4 uppercase tracking-wider">Quick Actions</h2>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

            <a href="<?php echo e(route('polling-units.index')); ?>"
               class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-blue-300 dark:border-slate-700 dark:bg-slate-800 dark:hover:border-blue-600">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:group-hover:bg-blue-900/50">
                        <i data-lucide="search" class="h-5 w-5" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Polling Unit Results</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Search and view results</p>
                    </div>
                </div>
                <i data-lucide="arrow-right" class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-300 transition-all group-hover:text-blue-500 group-hover:translate-x-1 dark:text-slate-600" aria-hidden="true"></i>
            </a>

            <a href="<?php echo e(route('lga.index')); ?>"
               class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-purple-300 dark:border-slate-700 dark:bg-slate-800 dark:hover:border-purple-600">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-purple-600 transition-colors group-hover:bg-purple-100 dark:bg-purple-900/30 dark:text-purple-400 dark:group-hover:bg-purple-900/50">
                        <i data-lucide="building-2" class="h-5 w-5" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">LGA Results</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Aggregate results by LGA</p>
                    </div>
                </div>
                <i data-lucide="arrow-right" class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-300 transition-all group-hover:text-purple-500 group-hover:translate-x-1 dark:text-slate-600" aria-hidden="true"></i>
            </a>

            <a href="<?php echo e(route('results.create')); ?>"
               class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-emerald-300 dark:border-slate-700 dark:bg-slate-800 dark:hover:border-emerald-600 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:group-hover:bg-emerald-900/50">
                        <i data-lucide="plus-circle" class="h-5 w-5" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Add Results</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Submit new polling data</p>
                    </div>
                </div>
                <i data-lucide="arrow-right" class="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-300 transition-all group-hover:text-emerald-500 group-hover:translate-x-1 dark:text-slate-600" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    
    <?php if(!empty($stats['top_parties']) && $stats['top_parties']->count()): ?>
        <div class="mb-8"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-4 uppercase tracking-wider">Top Performing Parties</h2>
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <?php
                    $topPartyTotal = $stats['top_parties']->sum('total_score');
                ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $stats['top_parties']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $party): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pct = $topPartyTotal > 0 ? round(($party->total_score / $topPartyTotal) * 100, 1) : 0;
                            $colors = ['bg-blue-500', 'bg-rose-500', 'bg-emerald-500', 'bg-amber-500', 'bg-violet-500'];
                            $colorClass = $colors[$index % count($colors)];
                        ?>
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 w-4 text-right" aria-hidden="true"><?php echo e($index + 1); ?></span>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-medium text-slate-900 dark:text-white truncate"><?php echo e($party->party_name); ?></span>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-3 tabular-nums"><?php echo e(number_format($party->total_score)); ?> <span class="text-slate-400 dark:text-slate-500 font-normal">(<?php echo e($pct); ?>%)</span></span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                    <div class="h-full rounded-full <?php echo e($colorClass); ?> transition-all duration-1000 ease-out"
                                         style="width: 0%"
                                         x-init="$nextTick(() => $el.style.width = '<?php echo e($pct); ?>%')"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if(!empty($stats['recent_results']) && $stats['recent_results']->count()): ?>
        <div x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-400"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-4 uppercase tracking-wider">Recent Polling Unit Submissions</h2>
            <?php if (isset($component)) { $__componentOriginalc8463834ba515134d5c98b88e1a9dc03 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8463834ba515134d5c98b88e1a9dc03 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.data-table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Polling Unit</th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ward</th>
                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">LGA</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Votes</th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    <?php $__currentLoopData = $stats['recent_results']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $pu = $entry->polling_unit;
                            $totalVotes = $entry->results->sum('party_score');
                        ?>
                        <?php if($pu): ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 sm:px-6 py-4">
                                    <a href="<?php echo e(route('polling-units.show', $pu->uniqueid)); ?>" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                        <?php echo e($pu->polling_unit_name); ?>

                                    </a>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 sm:hidden"><?php echo e($pu->ward?->ward_name ?? '—'); ?></p>
                                </td>
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-400"><?php echo e($pu->ward?->ward_name ?? '—'); ?></span>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-400"><?php echo e($pu->lga?->lga_name ?? '—'); ?></span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-right">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700 dark:bg-slate-700 dark:text-slate-300 tabular-nums">
                                        <?php echo e(number_format($totalVotes)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right hidden sm:table-cell">
                                    <span class="text-xs text-slate-400 dark:text-slate-500 tabular-nums"><?php echo e($entry->latest_entry ? \Carbon\Carbon::parse($entry->latest_entry)->format('M d, Y') : '—'); ?></span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
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
    <?php endif; ?>

    
    <?php if(empty($stats['top_parties']) || !$stats['top_parties']->count()): ?>
        <?php if(empty($stats['recent_results']) || !$stats['recent_results']->count()): ?>
            <div x-show="loaded" x-transition>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No election data yet','description' => 'Results will appear here once polling unit data has been recorded.','icon' => 'bar-chart-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No election data yet','description' => 'Results will appear here once polling unit data has been recorded.','icon' => 'bar-chart-3']); ?>
                     <?php $__env->slot('action', null, []); ?> 
                        <a href="<?php echo e(route('results.create')); ?>"
                           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                            <i data-lucide="plus" class="h-4 w-4" aria-hidden="true"></i>
                            Add First Results
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
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/dashboard.blade.php ENDPATH**/ ?>