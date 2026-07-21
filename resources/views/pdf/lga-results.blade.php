@extends('layouts.app')

@section('title', $lga->lga_name . ' LGA Results')

@push('header-actions')
    <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 no-print">
        <i data-lucide="printer" class="h-4 w-4" aria-hidden="true"></i>
        Print / Save PDF
    </button>
@endpush

@section('content')
@php
    $chartColors = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1'];
@endphp

<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    <div class="mb-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition>
        <div class="text-center border-b border-slate-200 dark:border-slate-700 pb-6 mb-6">
            <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400 sm:text-3xl">INEC Election Results</h1>
            <p class="text-base text-slate-500 dark:text-slate-400 mt-1">{{ $lga->lga_name }} LGA — Aggregated Results</p>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">LGA</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $lga->lga_name }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">State</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $lga->state?->state_name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">LGA Code</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $lga->lga_code ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Polling Units</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ number_format($polling_unit_count) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Votes</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ number_format($total_votes) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Parties Reporting</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ count($results) }}</p>
            </div>
        </div>
    </div>

    @if($winner)
    <div class="mb-8 rounded-xl border-2 border-emerald-500 bg-emerald-50 p-6 shadow-sm dark:bg-emerald-900/20 dark:border-emerald-600"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-2">Declared Winner</p>
        <p class="text-2xl font-bold text-emerald-800 dark:text-emerald-300">{{ $winner['party_name'] }}</p>
        <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-2">
            {{ number_format($winner['total_score']) }} votes
            ({{ $total_votes > 0 ? round(($winner['total_score'] / $total_votes) * 100, 1) : 0 }}% of total)
            @if($runnerUp)
                — Margin: {{ number_format($margin) }} votes ahead of {{ $runnerUp['party_name'] }}
            @endif
        </p>
    </div>
    @endif

    <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($polling_unit_count) }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Polling Units</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($total_votes) }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Total Votes</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $winner ? $winner['party_name'] : 'N/A' }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Winning Party</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($margin) }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Margin of Victory</div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Results by Party</h2>
        </div>
        <div class="overflow-x-auto scrollbar-thin">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rank</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Code</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Party</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Votes</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">%</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Distribution</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($results as $index => $result)
                        @php
                            $pct = $total_votes > 0 ? round(($result['total_score'] / $total_votes) * 100, 1) : 0;
                            $color = $chartColors[$index % count($chartColors)];
                            $isWinner = $index === 0;
                        @endphp
                        <tr class="{{ $isWinner ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'hover:bg-slate-50 dark:hover:bg-slate-700/50' }} transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-300">{{ $result['party_abbreviation'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">
                                {{ $result['party_name'] }}
                                @if($isWinner)
                                    <span class="ml-2 inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Winner</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($result['total_score']) }}</td>
                            <td class="px-6 py-4 text-right text-sm tabular-nums text-slate-600 dark:text-slate-400">{{ $pct }}%</td>
                            <td class="px-6 py-4">
                                <div class="w-full max-w-[200px]">
                                    <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $pct }}%; background-color: {{ $color }}"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 text-center text-xs text-slate-400 dark:text-slate-500">
        <p class="font-semibold text-slate-500 dark:text-slate-400">INEC Election Dashboard — Official LGA Results Report</p>
        <p class="mt-1">This document was automatically generated by the INEC Election Management System</p>
        <p class="mt-1">Bincom PHP/MySQL Developer Technical Interview Assessment</p>
    </div>
</div>
@endsection

