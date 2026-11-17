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
        .dashboard-page { min-height: 100vh; background: #f4f6f9; }
        .dashboard-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
        body.sidebar-collapsed .dashboard-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
        .dashboard-chart { position: relative; height: 300px; }
        .dashboard-chart--donut { height: 280px; }
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
                            <div class="bg-white rounded-xl shadow-sm border border-slate-200 h-full flex flex-col">
                                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-2 flex-wrap">
                                    <h3 class="text-base font-semibold text-slate-800 m-0">{{ __('Course Enrollments') }} - {{ __('Last :months Months', ['months' => $months]) }}</h3>
                                    <form method="GET" action="{{ route('dashboard') }}" class="m-0">
                                        <label for="dashboardMonths" class="sr-only">{{ __('Number of months') }}</label>
                                        <select id="dashboardMonths" name="months" class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()" aria-label="{{ __('Number of months') }}">
                                            @foreach(range(1, 12) as $option)
                                                <option value="{{ $option }}" @selected($months === $option)>{{ $option }} {{ __('Months') }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="p-5 flex-1">
                                    <div class="dashboard-chart">
                                        <canvas id="enrollmentTrendChart" role="img" aria-label="{{ __('Course Enrollments') }} - {{ __('Last :months Months', ['months' => $months]) }}"></canvas>
                                        <p id="enrollmentChartFallback" class="text-slate-400 text-center text-sm pt-12" hidden>{{ __('Chart library unavailable') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-4">
                            <div class="bg-white rounded-xl shadow-sm border border-slate-200 h-full flex flex-col">
                                <div class="px-5 py-4 border-b border-slate-100">
                                    <h3 class="text-base font-semibold text-slate-800 m-0">{{ __('ToDo Progress') }}</h3>
                                </div>
                                <div class="p-5 flex-1 flex items-center justify-center">
                                    <div class="dashboard-chart dashboard-chart--donut w-full">
                                        <canvas id="todoProgressChart" role="img" aria-label="{{ __('ToDo Progress') }}"></canvas>
                                        <p id="todoChartFallback" class="text-slate-400 text-center text-sm pt-12" hidden>{{ __('Chart library unavailable') }}</p>
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
                        backgroundColor: 'rgba(54, 162, 235, 0.15)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                    plugins: { legend: { display: false } },
                },
            });

            new Chart(document.getElementById('todoProgressChart'), {
                type: 'doughnut',
                data: {
                    labels: todoProgress.map((item) => item.label),
                    datasets: [{
                        data: todoProgress.map((item) => item.total),
                        backgroundColor: ['#22c55e', '#06b6d4', '#f59e0b'],
                        borderWidth: 1,
                    }],
                },
                options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } },
            });
        });
    </script>
</body>
</html>