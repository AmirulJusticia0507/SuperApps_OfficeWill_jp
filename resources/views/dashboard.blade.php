<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ __('DEP SERVICE - OFFICE WILL - JAPAN') }}</title>
    <!-- Tailwind CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .dashboard-page { min-height: 100vh; background: #f4f6f9; }
        .dashboard-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
        body.sidebar-collapsed .dashboard-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
        .dashboard-page .breadcrumb { margin-bottom: 1.25rem; }
        .dashboard-page .small-box { min-height: 128px; border-radius: .75rem; box-shadow: 0 .125rem .75rem rgba(0,0,0,.08); overflow: hidden; }
        .dashboard-page .small-box h3 { font-size: 2rem; font-weight: 700; }
        .dashboard-page .small-box p { font-size: .95rem; }
        .dashboard-page .card { border: 0; border-radius: .75rem; box-shadow: 0 .125rem .75rem rgba(0,0,0,.08); }
        .dashboard-page .card-header { border-bottom: 1px solid rgba(0,0,0,.08); background: #fff; padding: 1rem 1.25rem; }
        .dashboard-page .card-title { margin: 0; font-size: 1rem; font-weight: 600; }
        .dashboard-page .card-body { padding: 1.25rem; }
        .dashboard-chart { position: relative; height: 300px; }
        .dashboard-chart--donut { height: 280px; }
        @media (max-width: 767.98px) {
            .dashboard-page__content, body.sidebar-collapsed .dashboard-page__content { margin-left: 0; width: 100%; padding: 1rem; }
            .dashboard-chart, .dashboard-chart--donut { height: 250px; }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper dashboard-page">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow">
            <!-- Tambahkan tombol hamburger di sini -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Include Header -->
            @include('includes.header')
        </nav>

        <!-- Include Sidebar -->
        @include('includes.sidebar')

        <div class="content-wrapper dashboard-page__content">
            <!-- Konten Utama -->
            <main class="content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
                    </ol>
                </nav>
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-3 mb-3">
                            <div class="dashboard-stat-card dashboard-stat-card--cyan">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-book"></i></div><p class="dashboard-stat-card__label">{{ __('Courses') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($courseCount) }}</h3></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 mb-3">
                            <div class="dashboard-stat-card dashboard-stat-card--blue">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-users"></i></div><p class="dashboard-stat-card__label">{{ __('Course Enrollments') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($enrollmentCount) }}</h3></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 mb-3">
                            <div class="dashboard-stat-card dashboard-stat-card--green">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-check-circle"></i></div><p class="dashboard-stat-card__label">{{ __('Completed') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($completedCount) }}</h3></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 mb-3">
                            <div class="dashboard-stat-card dashboard-stat-card--amber">
                                <div class="dashboard-stat-card__body"><div class="dashboard-stat-card__icon"><i class="fas fa-clock"></i></div><p class="dashboard-stat-card__label">{{ __('In Progress or Not Started') }}</p><h3 class="dashboard-stat-card__value">{{ number_format($inProgressCount + $notStartedCount) }}</h3></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-8 mb-3">
                            <div class="card h-100">
                                <div class="card-header"><h3 class="card-title">{{ __('Course Enrollments - Last 6 Months') }}</h3></div>
                                 <div class="card-body"><div class="dashboard-chart"><canvas id="enrollmentTrendChart" role="img" aria-label="{{ __('Course Enrollments - Last 6 Months') }}"></canvas><p id="enrollmentChartFallback" class="text-muted text-center" hidden>{{ __('Chart library unavailable') }}</p></div></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <div class="card h-100">
                                <div class="card-header"><h3 class="card-title">{{ __('ToDo Progress') }}</h3></div>
                                 <div class="card-body d-flex align-items-center justify-content-center"><div class="dashboard-chart dashboard-chart--donut w-100"><canvas id="todoProgressChart" role="img" aria-label="{{ __('ToDo Progress') }}"></canvas><p id="todoChartFallback" class="text-muted text-center" hidden>{{ __('Chart library unavailable') }}</p></div></div>
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
    <!-- AdminLTE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    <script>
        const enrollmentTrend = @json($enrollmentTrend);
        const todoProgress = {!! json_encode([
            ['label' => __('Completed'), 'total' => $completedCount],
            ['label' => __('In Progress'), 'total' => $inProgressCount],
            ['label' => __('Not Started'), 'total' => $notStartedCount],
        ]) !!};

        $(document).ready(function() {
            // Tambahkan event click pada tombol pushmenu
            $('.nav-link[data-widget="pushmenu"]').on('click', function() {
                // Toggle class 'sidebar-collapse' pada elemen body
                $('body').toggleClass('sidebar-collapse');
            });

            // Tambahkan event click pada tombol toggler untuk sidebar
            $('.navbar-toggler[aria-controls="sidebar"]').on('click', function() {
                // Toggle class 'show' pada elemen sidebar
            $('#sidebar').toggleClass('show');
            });

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
                        backgroundColor: ['#28a745', '#17a2b8', '#ffc107'],
                        borderWidth: 1,
                    }],
                },
                options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } },
            });
        });
    </script>
</body>
</html>
