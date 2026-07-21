@use('Illuminate\Support\Facades\Route')
<!DOCTYPE html>
<html lang="en" x-data="darkMode" :class="{ 'dark': dark }" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="INEC Election Dashboard — Real-time polling unit results and LGA aggregation">
    <title>@yield('title', 'Dashboard') — INEC Election Dashboard</title>

    <script>
        (function() {
            var stored = localStorage.getItem('darkMode');
            var isDark = stored !== null ? stored === 'true' : true;
            if (isDark) document.documentElement.classList.add('dark');
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 font-sans antialiased min-h-screen"
      x-data="{ sidebarOpen: false, pageLoaded: false }"
      x-init="$nextTick(() => pageLoaded = true)"
      :class="{ 'overflow-hidden': sidebarOpen }">

    <a href="#main-content" class="skip-link">Skip to main content</a>

    {{-- Loading overlay --}}
    <div x-show="!pageLoaded" x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9998] bg-slate-50 dark:bg-slate-900 flex items-center justify-center">
        <div class="flex flex-col items-center gap-3">
            <div class="w-8 h-8 border-[3px] border-slate-900 dark:border-slate-100 border-t-transparent rounded-full animate-spin"></div>
            <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Loading...</p>
        </div>
    </div>

    <div class="flex min-h-screen" :class="{ 'page-loaded': pageLoaded }">

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 w-[280px] bg-white dark:bg-slate-950 border-r border-slate-200 dark:border-slate-800 flex flex-col transition-transform duration-300 ease-out lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               :aria-hidden="!sidebarOpen"
               role="navigation" aria-label="Main navigation">

            {{-- Brand --}}
            <div class="flex items-center gap-3 px-6 h-16 border-b border-slate-200 dark:border-slate-800 shrink-0">
                <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-gradient-to-br from-brand-600 to-brand-800 text-white shadow-sm shadow-brand-500/25">
                    <i data-lucide="shield-check" class="w-5 h-5" aria-hidden="true"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold tracking-tight text-slate-900 dark:text-white">INEC Dashboard</span>
                    <span class="text-[11px] font-medium text-slate-400 dark:text-slate-500 -mt-0.5">Election Management</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 scrollbar-thin" aria-label="Sidebar">
                <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500" aria-hidden="true">Main</p>

                @php
                    $navItems = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
                        ['route' => 'polling-units.index', 'label' => 'Polling Unit Results', 'icon' => 'map-pin'],
                        ['route' => 'lga.index', 'label' => 'LGA Results', 'icon' => 'building-2'],
                        ['route' => 'results.create', 'label' => 'Add Results', 'icon' => 'plus-circle'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php $active = Route::currentRouteNamed($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                              {{ $active
                                  ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400 shadow-sm'
                                  : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}"
                       aria-current="{{ $active ? 'page' : null }}">
                        <i data-lucide="{{ $item['icon'] }}" class="w-[18px] h-[18px] shrink-0 {{ $active ? 'text-brand-600 dark:text-brand-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" aria-hidden="true"></i>
                        {{ $item['label'] }}
                        @if($active)
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-600 dark:bg-brand-400" aria-hidden="true"></span>
                        @endif
                    </a>
                @endforeach

            </nav>

            {{-- Bottom section --}}
            <div class="px-3 py-4 border-t border-slate-200 dark:border-slate-800 space-y-1 shrink-0">
                <button @click="toggleDark()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all duration-200" aria-label="Toggle dark mode">
                    <template x-if="dark">
                        <i data-lucide="sun" class="w-[18px] h-[18px] text-slate-400" aria-hidden="true"></i>
                    </template>
                    <template x-if="!dark">
                        <i data-lucide="moon" class="w-[18px] h-[18px] text-slate-400" aria-hidden="true"></i>
                    </template>
                    <span x-text="dark ? 'Light mode' : 'Dark mode'"></span>
                </button>

                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-500 dark:text-slate-500">
                    <i data-lucide="circle-dot" class="w-[18px] h-[18px] text-emerald-500" aria-hidden="true"></i>
                    <span class="text-xs">System operational</span>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <main id="main-content" class="flex-1 lg:ml-[280px] min-h-screen flex flex-col" role="main">

            {{-- Top header --}}
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800" role="banner">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="Toggle navigation menu" :aria-expanded="sidebarOpen">
                            <i data-lucide="menu" class="w-5 h-5" aria-hidden="true"></i>
                        </button>
                        <div>
                            <h1 class="text-lg font-semibold text-slate-900 dark:text-white">@yield('title', 'Dashboard')</h1>
                            @hasSection('subtitle')
                                <p class="text-sm text-slate-500 dark:text-slate-400 -mt-0.5">@yield('subtitle')</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @stack('header-actions')
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                         x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-sm text-emerald-700 dark:text-emerald-400 shadow-sm"
                         role="alert">
                        <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0" aria-hidden="true"></i>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button @click="show = false" class="shrink-0 p-0.5 rounded hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-colors" aria-label="Dismiss">
                            <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                         x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-sm text-red-700 dark:text-red-400 shadow-sm"
                         role="alert">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0" aria-hidden="true"></i>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button @click="show = false" class="shrink-0 p-0.5 rounded hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors" aria-label="Dismiss">
                            <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Page content --}}
            <div class="flex-1 px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('styles')
    @stack('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('alpine:initialized', () => lucide.createIcons());
    </script>
</body>
</html>

