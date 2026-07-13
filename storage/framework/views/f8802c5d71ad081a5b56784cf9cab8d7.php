<?php $__env->startSection('title', 'LGA Results'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{
    selectedLga: '',
    submitting: false,
    loaded: false
}" x-init="$nextTick(() => loaded = true)">

    
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
            LGA Results Analysis
        </h1>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Aggregate election results by Local Government Area
        </p>
    </div>

    
    <div class="max-w-2xl"
         x-show="loaded"
         x-transition:enter="transition duration-500 ease-out"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-900/30">
                        <i data-lucide="building-2" class="h-5 w-5 text-purple-600 dark:text-purple-400" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-slate-900 dark:text-white">Select an LGA</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Choose a Local Government Area to calculate its aggregated results</p>
                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('lga.calculate')); ?>" method="POST" @submit="submitting = true">
                <?php echo csrf_field(); ?>
                <div class="p-6 space-y-5">
                    
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-900/50">
                        <div class="flex gap-3">
                            <i data-lucide="info" class="h-5 w-5 text-blue-500 shrink-0 mt-0.5" aria-hidden="true"></i>
                            <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                                <p>This will aggregate <strong class="text-slate-900 dark:text-white">all polling unit results</strong> within the selected LGA by summing party scores across all polling units.</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500">Results are computed in real-time from the <code class="rounded bg-slate-200 px-1 py-0.5 text-xs font-mono dark:bg-slate-700">announced_pu_results</code> table.</p>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <label for="lga_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Local Government Area <span class="text-red-500" aria-hidden="true">*</span>
                        </label>
                        <select
                            name="lga_id"
                            id="lga_id"
                            x-model="selectedLga"
                            required
                            aria-required="true"
                            class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-blue-400"
                        >
                            <option value="">Select an LGA...</option>
                            <?php $__currentLoopData = $lgas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lga->uniqueid); ?>"><?php echo e($lga->lga_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['lga_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400" role="alert"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 px-6 py-4 dark:border-slate-700">
                    <button type="submit"
                            :disabled="!selectedLga || submitting"
                            :class="!selectedLga || submitting ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700 focus:ring-blue-500'"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <i data-lucide="calculator" class="h-4 w-4" aria-hidden="true"></i>
                                Calculate Results
                            </span>
                        </template>
                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Calculating...
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>

        
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <i data-lucide="building-2" class="h-4 w-4 text-blue-600 dark:text-blue-400" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Total LGAs</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white tabular-nums"><?php echo e(number_format($lgas->count())); ?></p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <i data-lucide="map-pin" class="h-4 w-4 text-purple-600 dark:text-purple-400" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 dark:text-slate-500">State</p>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Delta State</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Method</p>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Real-time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/lga/index.blade.php ENDPATH**/ ?>