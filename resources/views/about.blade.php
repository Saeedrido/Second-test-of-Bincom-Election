@extends('layouts.app')

@section('title', 'About')

@section('content')
<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)">

    {{-- Page Header --}}
    <div class="mb-10">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
            About This Application
        </h1>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Bincom Election Results Dashboard
        </p>
    </div>

    {{-- Overview --}}
    <div class="mb-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/30">
                <i data-lucide="info" class="h-5 w-5 text-blue-600 dark:text-blue-400" aria-hidden="true"></i>
            </div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Overview</h2>
        </div>
        <div class="prose prose-slate dark:prose-invert max-w-none">
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                The <strong>INEC Election Results Dashboard</strong> is a production-grade web application designed for the
                Independent National Electoral Commission (INEC) to manage, view, and analyze election results across
                polling units in <strong>Delta State, Nigeria</strong>. It provides real-time result aggregation,
                comprehensive search capabilities, and the ability to enter new polling unit results — all through
                a clean, professional interface built for speed and reliability.
            </p>
        </div>
    </div>

    {{-- Database Schema --}}
    <div class="mb-8 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-900/30">
                    <i data-lucide="database" class="h-5 w-5 text-purple-600 dark:text-purple-400" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Database Schema</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Core tables and their relationships</p>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700" role="table">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Table</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Purpose</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 hidden md:table-cell">Key Relationships</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @php
                        $tables = [
                            ['name' => 'states', 'purpose' => '37 Nigerian states', 'relations' => 'state_id (PK)'],
                            ['name' => 'lga', 'purpose' => '25 LGAs in Delta State', 'relations' => 'uniqueid (PK), state_id → states'],
                            ['name' => 'ward', 'purpose' => '263 wards', 'relations' => 'uniqueid (PK), lga_id → lga'],
                            ['name' => 'polling_unit', 'purpose' => '272 polling units', 'relations' => 'uniqueid (PK), uniquewardid → ward, lga_id → lga'],
                            ['name' => 'party', 'purpose' => '9 political parties', 'relations' => 'id (PK), partyid (abbreviation)'],
                            ['name' => 'announced_pu_results', 'purpose' => 'Polling unit results', 'relations' => 'result_id (PK), polling_unit_uniqueid → polling_unit'],
                            ['name' => 'agentname', 'purpose' => 'Party agents', 'relations' => 'name_id (PK), pollingunit_uniqueid → polling_unit'],
                        ];
                    @endphp
                    @foreach($tables as $table)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-semibold text-slate-700 dark:bg-slate-700 dark:text-slate-300">{{ $table['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $table['purpose'] }}</td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-500 dark:text-slate-500 hidden md:table-cell">{{ $table['relations'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Architecture --}}
    <div class="mb-8 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/30">
                    <i data-lucide="layers" class="h-5 w-5 text-emerald-600 dark:text-emerald-400" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Architecture</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Tech stack and project structure</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                {{-- Tech Stack --}}
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">Tech Stack</h3>
                    <div class="space-y-2">
                        @php
                            $stack = [
                                ['name' => 'Laravel 12', 'desc' => 'PHP framework', 'color' => 'red'],
                                ['name' => 'PHP 8.2', 'desc' => 'Server-side language', 'color' => 'blue'],
                                ['name' => 'MySQL', 'desc' => 'Relational database', 'color' => 'amber'],
                                ['name' => 'Tailwind CSS', 'desc' => 'Utility-first CSS', 'color' => 'cyan'],
                                ['name' => 'Alpine.js', 'desc' => 'Lightweight JS framework', 'color' => 'purple'],
                                ['name' => 'Vite', 'desc' => 'Build tool & dev server', 'color' => 'violet'],
                            ];
                            $colorClasses = [
                                'red' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'amber' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                'cyan' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                'purple' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                'violet' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400',
                            ];
                        @endphp
                        @foreach($stack as $item)
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold {{ $colorClasses[$item['color']] }}">{{ $item['name'] }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $item['desc'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Folder Structure --}}
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">Folder Structure</h3>
                    <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-900/50">
                        <pre class="text-xs font-mono text-slate-600 dark:text-slate-400 leading-relaxed overflow-x-auto"><code>app/
├── Http/Controllers/
├── Models/
├── Services/
├── Repositories/
├── Http/Requests/
resources/views/
├── layouts/
├── components/
├── dashboard.blade.php
├── polling-units/
├── lga/
├── results/
└── about.blade.php</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Questions Addressed --}}
    <div class="mb-8 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-900/30">
                    <i data-lucide="help-circle" class="h-5 w-5 text-amber-600 dark:text-amber-400" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Questions Addressed</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Assessment requirements fulfilled</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex gap-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30 shrink-0">
                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">Q1</span>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Polling Unit Results</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Display and search all polling unit results with party vote breakdowns, visual charts, and export capabilities.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30 shrink-0">
                    <span class="text-sm font-bold text-purple-600 dark:text-purple-400">Q2</span>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">LGA Aggregated Results</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Sum all polling unit results within an LGA, with comparison charts, winner announcement, and margin of victory.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30 shrink-0">
                    <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">Q3</span>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Submit New Results</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Chained AJAX dropdowns (State → LGA → Ward → Polling Unit) for entering new election results with validation.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Credits --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800"
         x-show="loaded" x-transition:enter="transition duration-500 ease-out delay-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700">
                <i data-lucide="award" class="h-5 w-5 text-slate-600 dark:text-slate-400" aria-hidden="true"></i>
            </div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Assessment</h2>
        </div>
        <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-900/50">
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                This application was developed as part of the <strong class="text-slate-900 dark:text-white">Bincom Employment Assessment</strong>.
                It demonstrates proficiency in Laravel development, database design, API integration, real-time data aggregation,
                responsive UI design, and modern frontend frameworks.
            </p>
        </div>
    </div>
</div>
@endsection
