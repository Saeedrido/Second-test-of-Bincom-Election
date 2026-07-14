<?php $__env->startSection('title', 'Polling Unit Results'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="pollingUnitIndex" data-search-query="<?php echo e($search ?? ''); ?>">

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Polling Unit Results
            </h1>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Search and browse results for all polling units
            </p>
        </div>

        
        <div class="relative w-full sm:w-80">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <i data-lucide="search" class="h-4 w-4 text-slate-400" aria-hidden="true"></i>
            </div>
            <input
                type="text"
                x-model="searchQuery"
                @input="search()"
                placeholder="Search by name or number..."
                aria-label="Search polling units"
                class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400"
            />
            <?php if($search): ?>
                <a href="<?php echo e(route('polling-units.index')); ?>" class="absolute inset-y-0 right-0 flex items-center pr-3.5" aria-label="Clear search">
                    <i data-lucide="x" class="h-4 w-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if(($pollingUnits instanceof \Illuminate\Support\Collection && $pollingUnits->count()) || ($pollingUnits instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $pollingUnits->count())): ?>
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
             <?php $__env->slot('header', null, []); ?> 
                <span class="text-xs text-slate-500 dark:text-slate-400">
                    <?php echo e($pollingUnits instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $pollingUnits->total() : $pollingUnits->count()); ?> results
                </span>
             <?php $__env->endSlot(); ?>

            <thead class="bg-slate-50 dark:bg-slate-900/50">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Unit Name</th>
                    <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Number</th>
                    <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ward</th>
                    <th scope="col" class="hidden lg:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">LGA</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <span class="sr-only">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                <?php $__currentLoopData = $pollingUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 shrink-0">
                                    <i data-lucide="map-pin" class="h-4 w-4 text-blue-600 dark:text-blue-400" aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0">
                                    <a href="<?php echo e(route('polling-units.show', $unit->uniqueid)); ?>" class="text-sm font-medium text-slate-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition-colors truncate block">
                                        <?php echo e($unit->polling_unit_name); ?>

                                    </a>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 sm:hidden"><?php echo e($unit->ward?->ward_name ?? '—'); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden sm:table-cell">
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                <?php echo e($unit->polling_unit_number); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <span class="text-sm text-slate-600 dark:text-slate-400"><?php echo e($unit->ward?->ward_name ?? '—'); ?></span>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <span class="text-sm text-slate-600 dark:text-slate-400"><?php echo e($unit->lga?->lga_name ?? '—'); ?></span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-right">
                            <a href="<?php echo e(route('polling-units.show', $unit->uniqueid)); ?>"
                               class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                                View
                                <i data-lucide="arrow-right" class="h-3 w-3" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
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

        
        <?php if($pollingUnits instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $pollingUnits->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($pollingUnits->withQueryString()->links('vendor.pagination.tailwind')); ?>

            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => ''.e($search ? 'No results found' : 'No polling units available').'','description' => ''.e($search ? 'No polling units match your search. Try a different query.' : 'There are no polling units with valid data to display.').'','icon' => 'search-x']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($search ? 'No results found' : 'No polling units available').'','description' => ''.e($search ? 'No polling units match your search. Try a different query.' : 'There are no polling units with valid data to display.').'','icon' => 'search-x']); ?>
            <?php if($search): ?>
                 <?php $__env->slot('action', null, []); ?> 
                    <a href="<?php echo e(route('polling-units.index')); ?>"
                       class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <i data-lucide="x" class="h-4 w-4" aria-hidden="true"></i>
                        Clear Search
                    </a>
                 <?php $__env->endSlot(); ?>
            <?php endif; ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/polling-units/index.blade.php ENDPATH**/ ?>