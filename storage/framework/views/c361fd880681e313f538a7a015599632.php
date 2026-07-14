<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'links' => [],
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
    'links' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(count($links) > 0): ?>
<nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm">
    <ol class="flex flex-wrap items-center gap-1.5" role="list">
        <li class="flex items-center">
            <a
                href="<?php echo e(route('dashboard')); ?>"
                class="text-slate-400 transition-colors hover:text-blue-600 dark:text-slate-500 dark:hover:text-blue-400"
                aria-label="Home"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </a>
        </li>

        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="flex items-center gap-1.5">
                <svg class="h-4 w-4 flex-shrink-0 text-slate-300 dark:text-slate-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/>
                </svg>

                <?php if($loop->last || !isset($link['url'])): ?>
                    <span class="font-medium text-slate-900 dark:text-white"<?php echo e($loop->last ? ' aria-current="page"' : ''); ?>>
                        <?php echo e($link['label']); ?>

                    </span>
                <?php else: ?>
                    <a
                        href="<?php echo e($link['url']); ?>"
                        class="text-slate-500 transition-colors hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
                    >
                        <?php echo e($link['label']); ?>

                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php endif; ?>
<?php /**PATH C:\Users\Prof. Timehin\Desktop\bincom-election-assessment\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>