@props([
    'title' => 'No data found',
    'description' => null,
    'icon' => 'inbox',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-16 px-6 text-center']) }}>
    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/50">
        <i data-lucide="{{ $icon }}" class="h-8 w-8 text-slate-400 dark:text-slate-500" aria-hidden="true"></i>
    </div>

    <h3 class="mb-1 text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>

    @if ($description)
        <p class="mb-6 max-w-sm text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
    @else
        <div class="mb-6"></div>
    @endif

    @if (isset($action))
        {{ $action }}
    @endif
</div>
