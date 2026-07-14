<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'subtitle' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => null,
    'subtitle' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800'])); ?>>
    <?php if($title || isset($header)): ?>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-slate-200 px-4 py-3 sm:px-6 sm:py-4 dark:border-slate-700">
            <div>
                <?php if($title): ?>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white"><?php echo e($title); ?></h3>
                <?php endif; ?>
                <?php if($subtitle): ?>
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400"><?php echo e($subtitle); ?></p>
                <?php endif; ?>
            </div>
            <?php if(isset($header)): ?>
                <div class="flex items-center gap-3">
                    <?php echo e($header); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto scrollbar-thin">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" role="table">
            <?php echo e($slot); ?>

        </table>
    </div>
</div>
<?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/components/data-table.blade.php ENDPATH**/ ?>