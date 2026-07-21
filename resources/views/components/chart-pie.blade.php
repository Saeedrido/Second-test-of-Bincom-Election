@props([
    'id' => 'pie-chart-' . uniqid(),
    'labels' => '[]',
    'data' => '[]',
    'colors' => '["#3B82F6", "#10B981", "#F59E0B", "#EF4444", "#8B5CF6", "#EC4899", "#06B6D4"]',
    'title' => null,
    'subtitle' => null,
    'doughnut' => false,
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

    <div x-data="{{ $chartId }}Data" x-init="initChart()">
        <div class="relative mx-auto" style="max-width: 280px; height: 280px;">
            <canvas
                id="{{ $id }}"
                role="img"
                aria-label="{{ $title ?? ($doughnut ? 'Doughnut' : 'Pie') . ' chart' }}"
                class="h-full w-full"
            ></canvas>
        </div>

        <div class="mt-6 flex flex-wrap justify-center gap-x-5 gap-y-2" aria-label="Chart legend">
            <template x-for="(label, i) in chartLabels" :key="i">
                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                    <span
                        class="inline-block h-3 w-3 flex-shrink-0 rounded-full"
                        :style="`background-color: ${chartColors[i]}`"
                    ></span>
                    <span x-text="label"></span>
                </div>
            </template>
        </div>
    </div>
</div>

@once
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
@endonce

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('{{ $chartId }}Data', () => ({
            chart: null,
            chartLabels: {{ $labels }},
            chartColors: {{ $colors }},
            initChart() {
                const ctx = document.getElementById('{{ $id }}');
                if (!ctx) return;

                const labels = this.chartLabels;
                const data = {{ $data }};
                const colors = this.chartColors;

                const backgroundColors = colors.map(c => c + 'CC');
                const borderColors = colors.map(() => '#FFFFFF');

                const isDark = document.documentElement.classList.contains('dark');

                this.chart = new Chart(ctx, {
                    type: '{{ $doughnut ? 'doughnut' : 'pie' }}',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 2,
                            hoverOffset: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '{{ $doughnut ? '65' : '0' }}%',
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
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const pct = ((context.parsed / total) * 100).toFixed(1);
                                        return ` ${context.label}: ${context.parsed.toLocaleString()} (${pct}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }));
    });
</script>

