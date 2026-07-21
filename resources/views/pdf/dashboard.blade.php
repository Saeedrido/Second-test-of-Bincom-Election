@extends('layouts.app')

@section('title', 'Dashboard PDF Export')

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
            <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400 sm:text-3xl">INEC Election Dashboard</h1>
            <p class="text-base text-slate-500 dark:text-slate-400 mt-1">Comprehensive Election Results Summary</p>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="text-center p-5 rounded-xl bg-gradient-to-br from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20 border border-blue-200 dark:border-blue-800">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['total_polling_units']) }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 uppercase tracking-wider">Polling Units</div>
            </div>
            <div class="text-center p-5 rounded-xl bg-gradient-to-br from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20 border border-blue-200 dark:border-blue-800">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['total_lgas']) }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 uppercase tracking-wider">Local Government Areas</div>
            </div>
            <div class="text-center p-5 rounded-xl bg-gradient-to-br from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20 border border-blue-200 dark:border-blue-800">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['total_wards']) }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 uppercase tracking-wider">Wards</div>
            </div>
            <div class="text-center p-5 rounded-xl bg-gradient-to-br from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20 border border-blue-200 dark:border-blue-800">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['total_parties']) }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 uppercase tracking-wider">Political Parties</div>
            </div>
        </div>
    </div>

    @if(!empty($stats['top_parties']) && $stats['top_parties']->count())
    <div class="mb-8 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Top Performing Parties</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rank</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Party</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Votes</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @php
                        $grandTotal = $stats['top_parties']->sum('total_score');
                    @endphp
                    @foreach($stats['top_parties'] as $index => $party)
                        @php
                            $pct = $grandTotal > 0 ? round(($party->total_score / $grandTotal) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $party->party_name }}</td>
                            <td class="px-6 py-4 text-right text-sm font-semibold tabular-nums text-slate-900 dark:text-white">{{ number_format($party->total_score) }}</td>
                            <td class="px-6 py-4 text-right text-sm tabular-nums text-slate-600 dark:text-slate-400">{{ $pct }}%</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 dark:bg-slate-900/50">
                        <td colspan="2" class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">TOTAL</td>
                        <td class="px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($grandTotal) }}</td>
                        <td class="px-6 py-4 text-right text-sm font-bold tabular-nums text-slate-900 dark:text-white">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    @if(!empty($stats['recent_results']) && $stats['recent_results']->count())
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Recent Polling Unit Submissions</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Polling Unit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ward</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">LGA</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Votes</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($stats['recent_results'] as $entry)
                        @php
                            $pu = $entry->polling_unit;
                            $totalVotes = $entry->results->sum('party_score');
                        @endphp
                        @if($pu)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $pu->polling_unit_name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $pu->ward?->ward_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $pu->lga?->lga_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-right text-sm font-semibold tabular-nums text-slate-900 dark:text-white">{{ number_format($totalVotes) }}</td>
                            <td class="px-6 py-4 text-right text-xs tabular-nums text-slate-400 dark:text-slate-500">{{ $entry->latest_entry ? \Carbon\Carbon::parse($entry->latest_entry)->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="mt-8 text-center text-xs text-slate-400 dark:text-slate-500">
        <p class="font-semibold text-slate-500 dark:text-slate-400">INEC Election Dashboard — Official Summary Report</p>
        <p class="mt-1">This document was automatically generated by the INEC Election Management System</p>
        <p class="mt-1">Bincom PHP/MySQL Developer Technical Interview Assessment</p>
    </div>
</div>
@endsection

