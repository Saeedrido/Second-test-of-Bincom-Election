@extends('layouts.app')

@section('title', 'Polling Unit Results')

@section('content')
<div x-data="pollingUnitIndex" data-search-query="{{ $search ?? '' }}">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Polling Unit Results
            </h1>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Search and browse results for all polling units
            </p>
        </div>

        {{-- Search --}}
        <div class="relative w-full sm:w-80">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <i data-lucide="search" class="h-4 w-4 text-slate-400" aria-hidden="true"></i>
            </div>
            <input
                type="text"
                x-model="searchQuery"
                @input="search()"
                placeholder="Search by name or number..."
                aria-label="Search polling units"
                class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400"
            />
            @if($search)
                <a href="{{ route('polling-units.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3.5" aria-label="Clear search">
                    <i data-lucide="x" class="h-4 w-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"></i>
                </a>
            @endif
        </div>
    </div>

    {{-- Results --}}
    @if(($pollingUnits instanceof \Illuminate\Support\Collection && $pollingUnits->count()) || ($pollingUnits instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $pollingUnits->count()))
        <x-data-table>
            <x-slot:header>
                <span class="text-xs text-slate-500 dark:text-slate-400">
                    {{ $pollingUnits instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $pollingUnits->total() : $pollingUnits->count() }} results
                </span>
            </x-slot:header>

            <thead class="bg-slate-50 dark:bg-slate-900/50">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Unit Name</th>
                    <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Number</th>
                    <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ward</th>
                    <th scope="col" class="hidden lg:table-cell px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">LGA</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <span class="sr-only">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @foreach($pollingUnits as $unit)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 sm:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 shrink-0">
                                    <i data-lucide="map-pin" class="h-4 w-4 text-blue-600 dark:text-blue-400" aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('polling-units.show', $unit->uniqueid) }}" class="text-sm font-medium text-slate-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition-colors truncate block">
                                        {{ $unit->polling_unit_name }}
                                    </a>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 sm:hidden">{{ $unit->ward?->ward_name ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden sm:table-cell">
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                {{ $unit->polling_unit_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $unit->ward?->ward_name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $unit->lga?->lga_name ?? '—' }}</span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-right">
                            <a href="{{ route('polling-units.show', $unit->uniqueid) }}"
                               class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                                View
                                <i data-lucide="arrow-right" class="h-3 w-3" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-data-table>

        {{-- Pagination --}}
        @if($pollingUnits instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $pollingUnits->hasPages())
            <div class="mt-6">
                {{ $pollingUnits->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @else
        <x-empty-state
            title="{{ $search ? 'No results found' : 'No polling units available' }}"
            description="{{ $search ? 'No polling units match your search. Try a different query.' : 'There are no polling units with valid data to display.' }}"
            icon="search-x"
        >
            @if($search)
                <x-slot:action>
                    <a href="{{ route('polling-units.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        <i data-lucide="x" class="h-4 w-4" aria-hidden="true"></i>
                        Clear Search
                    </a>
                </x-slot:action>
            @endif
        </x-empty-state>
    @endif
</div>
@endsection

