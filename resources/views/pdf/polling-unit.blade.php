@extends('layouts.app')

@section('title', ($polling_unit->polling_unit_name ?? 'Polling Unit') . ' PDF Export')

@php
    $unit = $polling_unit;
    $totalVotes = $total_votes;
    $chartColors = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#F97316','#6366F1'];
@endphp

@push('header-actions')
    <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 no-print">
        <i data-lucide="printer" class="h-4 w-4" aria-hidden="true"></i>
        Print / Save PDF
    </button>
@endpush

@section('content')
<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    <div class="mb-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition>
        <div class="text-center border-b border-slate-200 dark:border-slate-700 pb-6 mb-6">
            <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400 sm:text-3xl">INEC Election Results</h1>
            <p class="text-base text-slate-500 dark:text-slate-400 mt-1">{{ $unit->polling_unit_name }}</p>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Polling Unit Number</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $unit->polling_unit_number }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Ward</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $unit->ward?->ward_name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">LGA</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $unit->lga?->lga_name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">State</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $unit->lga?->state?->state_name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Description</p>
                <p class="text-sm font-semibold text-slate-900 dark:text-white mt-1">{{ $unit->polling_unit_description ?? 'N/A' }}</p>
            </div>
            @if($unit->lat && $unit->long)
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">Coordinates</p>
                <p class="text-sm font-mono text-slate-900 dark:text-white mt-1">{{ $unit->lat }}, {{ $unit->long }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 tabular-nums">{{ number_format($totalVotes) }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Total Votes Cast</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $winner ? $winner['party_name'] : 'N/A' }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Winning Party</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm text-center dark:border-slate-700 dark:bg-slate-800">
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 tabular-nums">{{ count($results) }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 uppercase tracking-wider">Parties Reporting</div>
        </div>
    </div>

    @if($winner)
    <div class="mb-8 rounded-xl border-2 border-emerald-500 bg-emerald-50 p-6 shadow-sm dark:bg-emerald-900/20 dark:border-emerald-600"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-150" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-2">Declared Winner</p>
        <p class="text-2xl font-bold text-emerald-800 dark:text-emerald-300">{{ $winner['party_name'] }}</p>
        <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-2">
            {{ number_format($winner['party_score']) }} votes
            ({{ $totalVotes > 0 ? round(($winner['party_score'] / $totalVotes) * 100, 1) : 0 }}% of total)
        </p>
    </div>
    @endif

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($results as $index => $result)
                        @php
                            $pct = $totalVotes > 0 ? round(($result['party_score'] / $totalVotes) * 100, 1) : 0;
                            $isWinner = $index === 0 && $result['party_score'] > 0;
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
                            <td class="px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($result['party_score']) }}</td>
                            <td class="px-6 py-4 text-right text-sm tabular-nums text-slate-600 dark:text-slate-400">{{ $pct }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 text-center text-xs text-slate-400 dark:text-slate-500">
        <p class="font-semibold text-slate-500 dark:text-slate-400">INEC Election Dashboard — Official Results Report</p>
        <p class="mt-1">This document was automatically generated by the INEC Election Management System</p>
        <p class="mt-1">Bincom PHP/MySQL Developer Technical Interview Assessment</p>
    </div>
</div>
@endsection
