<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'value',
    'icon' => 'bar-chart-2',
    'color' => 'blue',
    'trend' => null,
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
    'title',
    'value',
    'icon' => 'bar-chart-2',
    'color' => 'blue',
    'trend' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colorMap = [
        'blue'   => ['bg' => 'bg-blue-50 dark:bg-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-l-blue-500', 'circle' => 'bg-blue-100 dark:bg-blue-800/50'],
        'green'  => ['bg' => 'bg-emerald-50 dark:bg-emerald-900/30', 'text' => 'text-emerald-600 dark:text-emerald-400', 'border' => 'border-l-emerald-500', 'circle' => 'bg-emerald-100 dark:bg-emerald-800/50'],
        'amber'  => ['bg' => 'bg-amber-50 dark:bg-amber-900/30', 'text' => 'text-amber-600 dark:text-amber-400', 'border' => 'border-l-amber-500', 'circle' => 'bg-amber-100 dark:bg-amber-800/50'],
        'red'    => ['bg' => 'bg-red-50 dark:bg-red-900/30', 'text' => 'text-red-600 dark:text-red-400', 'border' => 'border-l-red-500', 'circle' => 'bg-red-100 dark:bg-red-800/50'],
        'purple' => ['bg' => 'bg-purple-50 dark:bg-purple-900/30', 'text' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-l-purple-500', 'circle' => 'bg-purple-100 dark:bg-purple-800/50'],
    ];

    $scheme = $colorMap[$color] ?? $colorMap['blue'];

    $trendDirection = null;
    $trendValue = null;
    if ($trend !== null) {
        $trendDirection = $trend >= 0 ? 'up' : 'down';
        $trendValue = $trend >= 0 ? '+' . abs($trend) . '%' : '-' . abs($trend) . '%';
    }
?>

<div
    <?php echo e($attributes->merge(['class' => "relative flex items-center gap-4 rounded-xl border border-slate-200 {$scheme['border']} bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-slate-700 dark:bg-slate-800"])); ?>

    role="article"
    aria-label="<?php echo e($title); ?>: <?php echo e($value); ?>"
>
    <div class="flex-shrink-0">
        <div class="flex h-12 w-12 items-center justify-center rounded-full <?php echo e($scheme['circle']); ?>">
            <i data-lucide="<?php echo e($icon); ?>" class="h-6 w-6 <?php echo e($scheme['text']); ?>" aria-hidden="true"></i>
        </div>
    </div>

    <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-medium text-slate-500 dark:text-slate-400"><?php echo e($title); ?></p>
        <p class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white"><?php echo e($value); ?></p>
    </div>

    <?php if($trend !== null): ?>
        <div class="flex-shrink-0">
            <span
                class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold
                    <?php echo e($trendDirection === 'up'
                        ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                        : 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400'); ?>"
                aria-label="Trend: <?php echo e($trendValue); ?>"
            >
                <?php if($trendDirection === 'up'): ?>
                    <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd"/>
                    </svg>
                <?php else: ?>
                    <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd"/>
                    </svg>
                <?php endif; ?>
                <?php echo e($trendValue); ?>

            </span>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/components/stat-card.blade.php ENDPATH**/ ?>