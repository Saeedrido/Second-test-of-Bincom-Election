@props([
    'links' => [],
])

@if(count($links) > 0)
<nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm">
    <ol class="flex flex-wrap items-center gap-1.5" role="list">
        <li class="flex items-center">
            <a
                href="{{ route('dashboard') }}"
                class="text-slate-400 transition-colors hover:text-blue-600 dark:text-slate-500 dark:hover:text-blue-400"
                aria-label="Home"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </a>
        </li>

        @foreach ($links as $index => $link)
            <li class="flex items-center gap-1.5">
                <svg class="h-4 w-4 flex-shrink-0 text-slate-300 dark:text-slate-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/>
                </svg>

                @if ($loop->last || !isset($link['url']))
                    <span class="font-medium text-slate-900 dark:text-white"{{ $loop->last ? ' aria-current="page"' : '' }}>
                        {{ $link['label'] }}
                    </span>
                @else
                    <a
                        href="{{ $link['url'] }}"
                        class="text-slate-500 transition-colors hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
                    >
                        {{ $link['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
