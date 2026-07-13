<?php $__env->startSection('title', 'Add Polling Unit Results'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $chartColors = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1'];
?>

<div x-data="resultForm" x-init="$nextTick(() => loaded = true)">

    
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
            Submit Polling Unit Results
        </h1>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Enter election results for a polling unit
        </p>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20"
             x-show="loaded" x-transition role="alert">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-circle" class="h-5 w-5 text-red-500 shrink-0 mt-0.5" aria-hidden="true"></i>
                <div>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="text-sm text-red-600 dark:text-red-400"><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('results.store')); ?>" method="POST" x-ref="resultForm">
        <?php echo csrf_field(); ?>

        
        <div class="mb-6 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30">
                        <i data-lucide="map-pin" class="h-5 w-5 text-blue-600 dark:text-blue-400" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900 dark:text-white">Select Location</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Choose the polling unit where results were recorded</p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                
                <div>
                    <label for="state_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        State <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <select name="state_id" id="state_id"
                            x-model="selectedState"
                            @change="fetchLgas()"
                            required aria-required="true"
                            class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400">
                        <option value="">Select state...</option>
                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($state->state_id); ?>"><?php echo e($state->state_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div>
                    <label for="lga_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        LGA <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <div class="relative">
                        <select name="lga_id" id="lga_id"
                                x-model="selectedLga"
                                @change="fetchWards()"
                                :disabled="!selectedState || loadingLgas"
                                required aria-required="true"
                            class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400">
                            <option value="" x-text="!selectedState ? 'Select state first' : (loadingLgas ? 'Loading...' : 'Select LGA...')"></option>
                            <template x-for="lga in lgas" :key="lga.uniqueid">
                                <option :value="lga.uniqueid" x-text="lga.lga_name"></option>
                            </template>
                        </select>
                        <div x-show="loadingLgas" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                
                <div>
                    <label for="ward_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Ward <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <div class="relative">
                        <select name="ward_id" id="ward_id"
                                x-model="selectedWard"
                                @change="fetchPollingUnits()"
                                :disabled="!selectedLga || loadingWards"
                                required aria-required="true"
                            class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400">
                            <option value="" x-text="!selectedLga ? 'Select LGA first' : (loadingWards ? 'Loading...' : 'Select ward...')"></option>
                            <template x-for="ward in wards" :key="ward.uniqueid">
                                <option :value="ward.uniqueid" x-text="ward.ward_name"></option>
                            </template>
                        </select>
                        <div x-show="loadingWards" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                
                <div>
                    <label for="polling_unit_uniqueid" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Polling Unit <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <div class="relative">
                        <select name="polling_unit_uniqueid" id="polling_unit_uniqueid"
                                x-model="selectedPu"
                                :disabled="!selectedWard || loadingPu"
                                required aria-required="true"
                            class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400">
                            <option value="" x-text="!selectedWard ? 'Select ward first' : (loadingPu ? 'Loading...' : 'Select polling unit...')"></option>
                            <template x-for="pu in pollingUnits" :key="pu.uniqueid">
                                <option :value="pu.uniqueid" x-text="pu.polling_unit_name + ' (' + pu.polling_unit_number + ')'"></option>
                            </template>
                        </select>
                        <div x-show="loadingPu" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mb-6 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-100"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/30">
                            <i data-lucide="bar-chart-2" class="h-5 w-5 text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-slate-900 dark:text-white">Party Results</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Enter the number of votes each party received</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-sm">
                        <span class="text-slate-500 dark:text-slate-400">Running total:</span>
                        <span class="font-bold tabular-nums text-slate-900 dark:text-white" x-text="grandTotal.toLocaleString()" aria-live="polite">0</span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $parties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $party): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $color = $chartColors[$index % count($chartColors)]; ?>
                        <div class="group relative rounded-xl border border-slate-200 p-4 transition-all hover:border-blue-300 hover:shadow-sm dark:border-slate-700 dark:hover:border-blue-600">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-bold uppercase tracking-wider text-white"
                                      style="background-color: <?php echo e($color); ?>" aria-hidden="true">
                                    <?php echo e($party->partyid); ?>

                                </span>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?php echo e($party->partyname); ?></span>
                            </div>
                            <input type="number"
                                   name="results[<?php echo e($index); ?>][party_score]"
                                   min="0"
                                   value="<?php echo e(old("results.{$index}.party_score")); ?>"
                                   required
                                   aria-label="<?php echo e($party->partyname); ?> votes"
                                   placeholder="0"
                                   @input="recalcTotal()"
                                   class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-mono tabular-nums text-slate-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-400" />
                            <input type="hidden" name="results[<?php echo e($index); ?>][party_abbreviation]" value="<?php echo e($party->partyid); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="mt-4 flex sm:hidden items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-900/50">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Running Total</span>
                    <span class="text-lg font-bold tabular-nums text-slate-900 dark:text-white" x-text="grandTotal.toLocaleString()" aria-live="polite">0</span>
                </div>
            </div>
        </div>

        
        <div class="flex items-center justify-end gap-3"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <a href="<?php echo e(route('dashboard')); ?>"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                Cancel
            </a>
            <button type="submit"
                    x-on:click="submitted = true"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                <template x-if="!submitted">
                    <span class="flex items-center gap-2">
                        <i data-lucide="check" class="h-4 w-4" aria-hidden="true"></i>
                        Submit Results
                    </span>
                </template>
                <template x-if="submitted">
                    <span class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Submitting...
                    </span>
                </template>
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/results/create.blade.php ENDPATH**/ ?>