@props([
    'id' => 'bar-chart-' . uniqid(),
    'labels' => '[]',
    'data' => '[]',
    'colors' => '["#3B82F6"]',
    'title' => null,
    'subtitle' => null,
])

@php
    $chartId = 'chart_' . str_replace('-', '_', $id);
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800']) }}>
    @if ($title || isset($header))
        <div class="mb-6 flex items-center justify-between">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>
            @if (isset($header))
                {{ $header }}
            @endif
        </div>
    @endif

    <div x-data="{{ $chartId }}Data" x-init="initChart()" class="relative" style="height: 300px;">
        <canvas
            id="{{ $id }}"
            role="img"
            aria-label="{{ $title ?? 'Bar chart' }}"
            class="h-full w-full"
        ></canvas>
    </div>
</div>

@once
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
@endonce

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('{{ $chartId }}Data', () => ({
            chart: null,
            initChart() {
                const ctx = document.getElementById('{{ $id }}');
                if (!ctx) return;

                const labels = {{ $labels }};
                const data = {{ $data }};
                const colors = {{ $colors }};

                const backgroundColors = Array.isArray(colors[0])
                    ? colors.map(c => `rgba(${c.join(',')}, 0.8)`)
                    : colors.map(c => c + 'CC');
                const borderColors = Array.isArray(colors[0])
                    ? colors.map(c => `rgba(${c.join(',')}, 1)`)
                    : colors;

                const isDark = document.documentElement.classList.contains('dark');
                const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
                const textColor = isDark ? '#9CA3AF' : '#6B7280';

                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 48,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#1F2937' : '#FFFFFF',
                                titleColor: isDark ? '#F3F4F6' : '#111827',
                                bodyColor: isDark ? '#D1D5DB' : '#374151',
                                borderColor: isDark ? '#374151' : '#E5E7EB',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 8,
                                boxPadding: 4,
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: textColor, font: { size: 12 } },
                                border: { display: false },
                            },
                            y: {
                                grid: { color: gridColor },
                                ticks: { color: textColor, font: { size: 12 } },
                                border: { display: false },
                                beginAtZero: true,
                            }
                        }
                    }
                });
            }
        }));
    });
</script>

