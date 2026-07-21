@props([
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800']) }}>
    @if ($title || isset($header))
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-slate-200 px-4 py-3 sm:px-6 sm:py-4 dark:border-slate-700">
            <div>
                @if ($title)
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>
            @if (isset($header))
                <div class="flex items-center gap-3">
                    {{ $header }}
                </div>
            @endif
        </div>
    @endif

    <div class="overflow-x-auto scrollbar-thin">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" role="table">
            {{ $slot }}
        </table>
    </div>
</div>

