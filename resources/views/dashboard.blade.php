<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ __('DEP SERVICE - OFFICE WILL - JAPAN') }}</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .dashboard-page { min-height: 100vh; background: #f1f5f9; }
        .dashboard-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
        body.sidebar-collapsed .dashboard-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
        .dashboard-chart { position: relative; height: 320px; }
        .dashboard-chart--donut { height: 252px; }
        .dashboard-chart-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
        .dashboard-chart-card { border: 1px solid rgba(226, 232, 240, .9); border-radius: 1.25rem; background: linear-gradient(145deg, #fff, #fbfdff); box-shadow: 0 12px 32px rgba(15, 23, 42, .055); overflow: hidden; }
        .dashboard-chart-select { border: 1px solid #e2e8f0; border-radius: .75rem; padding: .55rem 2.25rem .55rem .85rem; color: #334155; background-color: #f8fafc; font-size: .8rem; font-weight: 600; outline: none; transition: all .2s ease; }
        .dashboard-chart-select:focus { border-color: #06b6d4; box-shadow: 0 0 0 4px rgba(6, 182, 212, .12); background: white; }
        @media (max-width: 767.98px) {
            .dashboard-page__content, body.sidebar-collapsed .dashboard-page__content { margin-left: 0; width: 100%; padding: 1rem; }
            .dashboard-chart, .dashboard-chart--donut { height: 250px; }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini bg-gray-50 antialiased">
    <div class="wrapper dashboard-page">
        <!-- Include Header -->
        @include('includes.header')

        <!-- Include Sidebar -->
        @include('includes.sidebar')

        <div class="dashboard-page__content">
            <!-- Konten Utama -->
            <main class="content">
                <nav aria-label="breadcrumb">
                    <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                        <li><a href="#" class="hover:text-blue-600">{{ __('Home') }}</a></li>
                        <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page">{{ __('Dashboard') }}</li>
                    </ol>
                </nav>
                <div class="w-full">
                    <!-- Stat Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                        <div>
                            <div class="dashboard-stat-card dashboard-stat-card--cyan">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-book"></i></div><p class="dashboard-stat-card__label">{{ __('Courses') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($courseCount) }}</h3></div>
                            </div>
                        </div>
                        <div>
                            <div class="dashboard-stat-card dashboard-stat-card--blue">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-users"></i></div><p class="dashboard-stat-card__label">{{ __('Course Enrollments') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($enrollmentCount) }}</h3></div>
                            </div>
                        </div>
                        <div>
                            <div class="dashboard-stat-card dashboard-stat-card--green">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-check-circle"></i></div><p class="dashboard-stat-card__label">{{ __('Completed') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($completedCount) }}</h3></div>
                            </div>
                        </div>
                        <div>
                            <div class="dashboard-stat-card dashboard-stat-card--amber">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-clock"></i></div><p class="dashboard-stat-card__label">{{ __('In Progress or Not Started') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($inProgressCount + $notStartedCount) }}</h3></div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <div class="lg:col-span-8">
                            <div class="dashboard-chart-card h-full flex flex-col">
                                <div class="px-5 py-5 border-b border-slate-100 flex items-center justify-between gap-2 flex-wrap">
                                    <div class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700"><i class="fas fa-chart-line" aria-hidden="true"></i></span><div><h3 class="text-base font-bold tracking-tight text-slate-900 m-0">{{ __('Course Enrollments') }}</h3><p class="mt-0.5 text-xs text-slate-500">{{ __('Last :months Months', ['months' => $months]) }}</p></div></div>
                                    <form method="GET" action="{{ route('dashboard') }}" class="m-0">
                                        <label for="dashboardMonths" class="sr-only">{{ __('Number of months') }}</label>
                                        <select id="dashboardMonths" name="months" class="dashboard-chart-select" onchange="this.form.submit()" aria-label="{{ __('Number of months') }}">
                                            @foreach(range(1, 12) as $option)
                                                <option value="{{ $option }}" @selected($months === $option)>{{ $option }} {{ __('Months') }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="px-5 py-4 flex-1">
                                    <div class="dashboard-chart">
                                        <canvas id="enrollmentTrendChart" role="img" aria-label="{{ __('Course Enrollments') }} - {{ __('Last :months Months', ['months' => $months]) }}"></canvas>
                                        <p id="enrollmentChartFallback" class="text-slate-400 text-center text-sm pt-12" hidden>{{ __('Chart library unavailable') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4">
                            <div class="dashboard-chart-card h-full flex flex-col">
                                <div class="px-5 py-5 border-b border-slate-100">
                                    <div class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700"><i class="fas fa-circle-check" aria-hidden="true"></i></span><div><h3 class="text-base font-bold tracking-tight text-slate-900 m-0">{{ __('ToDo Progress') }}</h3><p class="mt-0.5 text-xs text-slate-500">{{ __('Task completion overview') }}</p></div></div>
                                </div>
                                <div class="px-5 pt-3 pb-5 flex-1 flex flex-col items-center justify-center">
                                    <div class="dashboard-chart dashboard-chart--donut w-full">
                                        <canvas id="todoProgressChart" role="img" aria-label="{{ __('ToDo Progress') }}"></canvas>
                                        <div class="dashboard-chart-center"><span class="text-3xl font-bold tracking-tight text-slate-900">{{ number_format($completedCount + $inProgressCount + $notStartedCount) }}</span><span class="mt-1 text-[10px] font-bold uppercase tracking-[.16em] text-slate-400">{{ __('Tasks') }}</span></div>
                                        <p id="todoChartFallback" class="text-slate-400 text-center text-sm pt-12" hidden>{{ __('Chart library unavailable') }}</p>
                                    </div>
                                    <div class="mt-1 grid w-full grid-cols-3 gap-2 text-center">
                                        <div class="rounded-xl bg-emerald-50/80 px-2 py-3"><p class="text-lg font-bold text-emerald-700">{{ number_format($completedCount) }}</p><p class="mt-0.5 text-[10px] font-semibold text-emerald-800/70">{{ __('Completed') }}</p></div>
                                        <div class="rounded-xl bg-cyan-50/80 px-2 py-3"><p class="text-lg font-bold text-cyan-700">{{ number_format($inProgressCount) }}</p><p class="mt-0.5 text-[10px] font-semibold text-cyan-800/70">{{ __('In Progress') }}</p></div>
                                        <div class="rounded-xl bg-amber-50/80 px-2 py-3"><p class="text-lg font-bold text-amber-700">{{ number_format($notStartedCount) }}</p><p class="mt-0.5 text-[10px] font-semibold text-amber-800/70">{{ __('Not Started') }}</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Include Footer -->
    @include('includes.footer')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    <script>
        const enrollmentTrend = @json($enrollmentTrend);
        const todoProgress = {!! json_encode([
            ['label' => __('Completed'), 'total' => $completedCount],
            ['label' => __('In Progress'), 'total' => $inProgressCount],
            ['label' => __('Not Started'), 'total' => $notStartedCount],
        ]) !!};

        $(document).ready(function() {
            if (typeof Chart === 'undefined') {
                document.getElementById('enrollmentChartFallback').hidden = false;
                document.getElementById('todoChartFallback').hidden = false;
                return;
            }

            new Chart(document.getElementById('enrollmentTrendChart'), {
                type: 'line',
                data: {
                    labels: enrollmentTrend.map((item) => item.label),
                    datasets: [{
                        label: @json(__('Course Enrollments')),
                        data: enrollmentTrend.map((item) => item.total),
                        backgroundColor: (context) => {
                            const {ctx, chartArea} = context.chart;
                            if (!chartArea) return 'rgba(6, 182, 212, .12)';
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(6, 182, 212, .28)');
                            gradient.addColorStop(1, 'rgba(6, 182, 212, .015)');
                            return gradient;
                        },
                        borderColor: '#0891b2',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0891b2',
                        pointBorderWidth: 2,
                        fill: true,
                        tension: 0.38,
                        borderCapStyle: 'round',
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { family: 'inherit', size: 11, weight: '500' } } },
                        y: { beginAtZero: true, ticks: { precision: 0, color: '#94a3b8', padding: 10, font: { family: 'inherit', size: 11 } }, grid: { color: 'rgba(148, 163, 184, .14)', drawTicks: false }, border: { display: false } },
                    },
                    plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0f172a', titleFont: { weight: '600' }, bodyFont: { weight: '500' }, padding: 12, cornerRadius: 10, displayColors: false } },
                },
            });

            new Chart(document.getElementById('todoProgressChart'), {
                type: 'doughnut',
                data: {
                    labels: todoProgress.map((item) => item.label),
                    datasets: [{
                        data: todoProgress.map((item) => item.total),
                        backgroundColor: ['#22c55e', '#06b6d4', '#f59e0b'],
                        borderWidth: 5,
                        borderColor: '#fff',
                        hoverOffset: 7,
                        borderRadius: 7,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '78%',
                    animation: { animateRotate: true, duration: 900 },
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#0f172a', padding: 12, cornerRadius: 10, titleFont: { weight: '600' }, bodyFont: { weight: '500' }, callbacks: { label: (context) => ` ${context.label}: ${context.parsed.toLocaleString()}` } },
                    },
                },
            });
        });
    </script>
</body>
</html>
