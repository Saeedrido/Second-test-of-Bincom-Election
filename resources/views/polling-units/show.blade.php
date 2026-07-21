@extends('layouts.app')

@section('title', $polling_unit->polling_unit_name ?? 'Polling Unit')

@section('content')
@php
    $unit = $polling_unit;
    $unitResults = $results;
    $totalVotes = $total_votes;
    $chartColors = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1'];
@endphp

<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    {{-- Breadcrumb --}}
    <x-breadcrumb :links="[
        ['label' => 'Polling Unit Results', 'url' => route('polling-units.index')],
        ['label' => $unit->polling_unit_name]
    ]" />

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                {{ $unit->polling_unit_name }}
            </h1>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Detailed results and vote breakdown
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3" x-show="loaded" x-transition>
            <a href="{{ route('pdf.polling-unit', $unit->uniqueid) }}"
               class="no-print inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="download" class="h-4 w-4" aria-hidden="true"></i>
                <span class="hidden sm:inline">Export PDF</span>
                <span class="sm:hidden">PDF</span>
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 no-print">
                <i data-lucide="printer" class="h-4 w-4" aria-hidden="true"></i>
                <span class="hidden sm:inline">Print</span>
            </button>
        </div>
    </div>

    {{-- Unit Info Card --}}
    <div class="mb-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded"
         x-transition:enter="transition duration-500 ease-out"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="flex items-center gap-3 mb-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30">
                <i data-lucide="map-pin" class="h-5 w-5 text-blue-600 dark:text-blue-400" aria-hidden="true"></i>
            </div>
            <h2 class="text-base font-semibold text-slate-900 dark:text-white">Polling Unit Information</h2>
        </div>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Name</p>
                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $unit->polling_unit_name }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Number</p>
                <p class="text-sm font-mono font-medium text-slate-900 dark:text-white">{{ $unit->polling_unit_number }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Description</p>
                <p class="text-sm text-slate-700 dark:text-slate-300">{{ $unit->polling_unit_description ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Ward</p>
                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $unit->ward?->ward_name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">LGA</p>
                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $unit->lga?->lga_name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">State</p>
                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $unit->lga?->state?->state_name ?? '—' }}</p>
            </div>
            @if($unit->lat && $unit->long)
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Coordinates</p>
                    <p class="text-sm font-mono text-slate-700 dark:text-slate-300">{{ $unit->lat }}, {{ $unit->long }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Summary Card --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3"
         x-show="loaded"
         x-transition:enter="transition duration-500 ease-out delay-100"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Total Votes Cast</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white tabular-nums">{{ number_format($totalVotes) }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Winning Party</p>
            <div class="flex items-center gap-2 mt-1">
                @if($winner)
                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                        <i data-lucide="trophy" class="h-3 w-3 mr-1" aria-hidden="true"></i>
                        {{ $winner['party_name'] }}
                    </span>
                @else
                    <span class="text-sm text-slate-500 dark:text-slate-400">No data</span>
                @endif
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Parties Reporting</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white tabular-nums">{{ count($unitResults) }}</p>
        </div>
    </div>

    @if(!empty($unitResults))
        {{-- Charts --}}
        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">

            {{-- Bar Chart --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-4">Vote Distribution</h3>
                <div class="space-y-3">
                    @foreach($unitResults as $index => $result)
                        @php
                            $pct = $totalVotes > 0 ? round(($result['party_score'] / $totalVotes) * 100, 1) : 0;
                            $color = $chartColors[$index % count($chartColors)];
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-medium text-slate-700 dark:text-slate-300">{{ $result['party_name'] }}</span>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 tabular-nums">{{ number_format($result['party_score']) }} ({{ $pct }}%)</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000 ease-out"
                                     style="width: 0%; background-color: {{ $color }}"
                                     x-init="$nextTick(() => $el.style.width = '{{ $pct }}%')"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pie Chart (CSS-based) --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-4">Percentage Share</h3>
                <div class="flex items-center justify-center">
                    <div class="relative w-48 h-48 sm:w-52 sm:h-52">
                        @php
                            $cumulative = 0;
                            $gradientParts = [];
                            foreach($unitResults as $i => $r) {
                                $pct = $totalVotes > 0 ? ($r['party_score'] / $totalVotes) * 100 : 0;
                                $color = $chartColors[$i % count($chartColors)];
                                $start = $cumulative;
                                $cumulative += $pct;
                                $gradientParts[] = "{$color} {$start}% {$cumulative}%";
                            }
                        @endphp
                        <div class="w-full h-full rounded-full shadow-inner dark:shadow-slate-900"
                             style="background: conic-gradient({{ implode(', ', $gradientParts) }})">
                            <div class="absolute inset-6 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center shadow-inner">
                                <div class="text-center">
                                    <p class="text-xl font-bold text-slate-900 dark:text-white tabular-nums">{{ number_format($totalVotes) }}</p>
                                    <p class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-x-4 gap-y-2">
                    @foreach($unitResults as $i => $result)
                        @php $color = $chartColors[$i % count($chartColors)]; @endphp
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="h-2.5 w-2.5 rounded-full shrink-0" style="background-color: {{ $color }}" aria-hidden="true"></span>
                            <span class="text-xs text-slate-600 dark:text-slate-400 truncate">{{ $result['party_name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Results Table --}}
        <div x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <x-data-table title="Election Results" subtitle="Sorted by highest votes">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">#</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Party</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Votes</th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Percentage</th>
                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Distribution</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($unitResults as $index => $result)
                        @php
                            $pct = $totalVotes > 0 ? round(($result['party_score'] / $totalVotes) * 100, 1) : 0;
                            $isWinner = $index === 0 && $result['party_score'] > 0;
                            $barColor = $chartColors[$index % count($chartColors)];
                        @endphp
                        <tr class="{{ $isWinner ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50' }} transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <span class="text-sm font-medium text-slate-400 dark:text-slate-500">{{ $index + 1 }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $result['party_name'] }}</span>
                                    @if($isWinner)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            <i data-lucide="trophy" class="h-2.5 w-2.5" aria-hidden="true"></i>
                                            Winner
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <span class="text-sm font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($result['party_score']) }}</span>
                            </td>
                            <td class="px-6 py-4 text-right hidden sm:table-cell">
                                <span class="text-sm tabular-nums text-slate-600 dark:text-slate-400">{{ $pct }}%</span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="w-full max-w-[200px]">
                                    <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $pct }}%; background-color: {{ $barColor }}"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 dark:bg-slate-900/50">
                        <td colspan="2" class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">Total</td>
                        <td class="px-4 sm:px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($totalVotes) }}</td>
                        <td class="px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white hidden sm:table-cell">100%</td>
                        <td class="hidden md:table-cell"></td>
                    </tr>
                </tfoot>
            </x-data-table>
        </div>
    @else
        <x-empty-state
            title="No results available"
            description="No election results have been recorded for this polling unit yet."
            icon="bar-chart-3"
        >
            <x-slot:action>
                <a href="{{ route('polling-units.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                    Back to Results
                </a>
            </x-slot:action>
        </x-empty-state>
    @endif
</div>
@endsection

