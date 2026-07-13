<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'No data found',
    'description' => null,
    'icon' => 'inbox',
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
    'title' => 'No data found',
    'description' => null,
    'icon' => 'inbox',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'flex flex-col items-center justify-center py-16 px-6 text-center'])); ?>>
    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/50">
        <i data-lucide="<?php echo e($icon); ?>" class="h-8 w-8 text-slate-400 dark:text-slate-500" aria-hidden="true"></i>
    </div>

    <h3 class="mb-1 text-lg font-semibold text-slate-900 dark:text-white"><?php echo e($title); ?></h3>

    <?php if($description): ?>
        <p class="mb-6 max-w-sm text-sm text-slate-500 dark:text-slate-400"><?php echo e($description); ?></p>
    <?php else: ?>
        <div class="mb-6"></div>
    <?php endif; ?>

    <?php if(isset($action)): ?>
        <?php echo e($action); ?>

    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/components/empty-state.blade.php ENDPATH**/ ?>