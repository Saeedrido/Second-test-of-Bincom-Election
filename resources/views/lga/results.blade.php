@extends('layouts.app')

@section('title', $lga->lga_name . ' — LGA Results')

@section('content')
@php
    $lgaResults = $results;
    $totalVotes = $total_votes;
    $runnerUp = $runner_up;
    $puCount = $polling_unit_count;
    $chartColors = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1'];
@endphp

<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    {{-- Breadcrumb --}}
    <x-breadcrumb :links="[
        ['label' => 'LGA Results', 'url' => route('lga.index')],
        ['label' => $lga->lga_name]
    ]" />

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                {{ $lga->lga_name }}
            </h1>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Aggregated results from {{ number_format($puCount) }} polling units
            </p>
        </div>
        <div class="flex items-center gap-3" x-show="loaded" x-transition>
            <a href="{{ route('lga.index') }}"
               class="no-print inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                Back
            </a>
            <a href="{{ route('pdf.lga', $lga->uniqueid) }}"
               class="no-print inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="download" class="h-4 w-4" aria-hidden="true"></i>
                Export PDF
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 no-print">
                <i data-lucide="printer" class="h-4 w-4" aria-hidden="true"></i>
                Print
            </button>
        </div>
    </div>

    {{-- Winner Announcement --}}
    @if($winner)
        <div class="mb-8 rounded-xl border-2 border-emerald-200 bg-gradient-to-r from-emerald-50 to-green-50 p-6 shadow-sm dark:border-emerald-800 dark:from-emerald-900/20 dark:to-green-900/20"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 shrink-0">
                    <i data-lucide="trophy" class="h-7 w-7 text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-1">Declared Winner</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white">{{ $winner['party_name'] }}</p>
                    <div class="flex flex-wrap items-center gap-3 mt-1.5">
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 tabular-nums">
                            {{ number_format($winner['total_score']) }} votes
                        </span>
                        @if($totalVotes > 0)
                            <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-400 tabular-nums">
                                {{ round(($winner['total_score'] / $totalVotes) * 100, 1) }}% of total
                            </span>
                        @endif
                        @if($runnerUp)
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Margin: {{ number_format($margin) }} votes ahead of {{ $runnerUp['party_name'] }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Summary Stats --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
         x-show="loaded"
         x-transition:enter="transition duration-500 ease-out delay-100"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <x-stat-card title="Polling Units" value="{{ number_format($puCount) }}" icon="map-pin" color="blue" />
        <x-stat-card title="Total Votes" value="{{ number_format($totalVotes) }}" icon="bar-chart-2" color="green" />
        <x-stat-card title="Winning Party" value="{{ $winner ? $winner['party_name'] : '—' }}" icon="trophy" color="amber" />
        <x-stat-card title="Margin of Victory" value="{{ number_format($margin ?? 0) }}" icon="trending-up" color="purple" />
    </div>

    @if(!empty($lgaResults))
        {{-- Charts --}}
        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2"
             x-show="loaded"
             x-transition:enter="transition duration-500 ease-out delay-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">

            {{-- Bar Chart --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-5">Party Vote Comparison</h3>
                <div class="space-y-3">
                    @foreach($lgaResults as $index => $result)
                        @php
                            $pct = $totalVotes > 0 ? round(($result['total_score'] / $totalVotes) * 100, 1) : 0;
                            $color = $chartColors[$index % count($chartColors)];
                            $isTop = $index === 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">{{ $result['party_name'] }}</span>
                                    @if($isTop)
                                        <span class="inline-flex items-center rounded bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 shrink-0">1st</span>
                                    @endif
                                </div>
                                <span class="text-xs font-semibold tabular-nums text-slate-600 dark:text-slate-400 shrink-0 ml-3">
                                    {{ number_format($result['total_score']) }} <span class="text-slate-400 dark:text-slate-500">({{ $pct }}%)</span>
                                </span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000 ease-out"
                                     style="width: 0%; background-color: {{ $color }}"
                                     x-init="$nextTick(() => $el.style.width = '{{ $pct }}%')"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pie Chart --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-5">Vote Distribution</h3>
                <div class="flex items-center justify-center">
                    <div class="relative w-52 h-52">
                        @php
                            $cumulative = 0;
                            $gradientParts = [];
                            foreach($lgaResults as $i => $r) {
                                $pct = $totalVotes > 0 ? ($r['total_score'] / $totalVotes) * 100 : 0;
                                $color = $chartColors[$i % count($chartColors)];
                                $start = $cumulative;
                                $cumulative += $pct;
                                $gradientParts[] = "{$color} {$start}% {$cumulative}%";
                            }
                        @endphp
                        <div class="w-52 h-52 rounded-full shadow-inner"
                             style="background: conic-gradient({{ implode(', ', $gradientParts) }})">
                            <div class="absolute inset-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white tabular-nums">{{ number_format($totalVotes) }}</p>
                                    <p class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Votes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach($lgaResults as $i => $result)
                        @php $color = $chartColors[$i % count($chartColors)]; @endphp
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="h-2.5 w-2.5 rounded-full shrink-0" style="background-color: {{ $color }}" aria-hidden="true"></span>
                            <span class="text-[11px] text-slate-600 dark:text-slate-400 truncate">{{ $result['party_name'] }}</span>
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
            <x-data-table title="Aggregated Results" subtitle="{{ $lga->lga_name }} — All polling units combined">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rank</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Party</th>
                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Votes</th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Percentage</th>
                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Share</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($lgaResults as $index => $result)
                        @php
                            $pct = $totalVotes > 0 ? round(($result['total_score'] / $totalVotes) * 100, 1) : 0;
                            $isWinner = $index === 0 && $result['total_score'] > 0;
                            $barColor = $chartColors[$index % count($chartColors)];
                        @endphp
                        <tr class="{{ $isWinner ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50' }} transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                @if($isWinner)
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        <i data-lucide="crown" class="h-3.5 w-3.5" aria-hidden="true"></i>
                                    </span>
                                @else
                                    <span class="text-sm font-medium text-slate-400 dark:text-slate-500 pl-1.5">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $result['party_name'] }}</span>
                                    @if($isWinner)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            Winner
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <span class="text-sm font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($result['total_score']) }}</span>
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
            description="There are no recorded results for polling units in this LGA."
            icon="bar-chart-3"
        >
            <x-slot:action>
                <a href="{{ route('lga.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                    Select Another LGA
                </a>
            </x-slot:action>
        </x-empty-state>
    @endif
</div>
@endsection
