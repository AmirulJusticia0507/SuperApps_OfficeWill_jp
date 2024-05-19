@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DEP SERVICE - OFFICE WILL - JAPAN</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>

@section('content')
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
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

        <div class="content-wrapper">
            <!-- Konten Utama -->
            <main class="content">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('course-settings') }}">Course Settings</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course List</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Registration</b></div>
                            <div class="card-body">
                                <!-- Form Filter -->
                                <form action="{{ route('course.filter') }}" method="GET">
                                    <!-- Course Classification Filter -->
                                    <div class="form-group">
                                        <label for="course_classification_id">Course Classification:</label>
                                        <select class="form-control" id="course_classification_id" name="course_classification_id" required style="display: inline-block; width: 60%;">
                                            @foreach($classifications as $classification)
                                            <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Course Classification Details Filter -->
                                    <div class="form-group">
                                        <label for="course_classification_details_id">Course Classification Details:</label>
                                        <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required style="display: inline-block; width: 60%;">
                                            @foreach($details as $detail)
                                            <option value="{{ $detail->id }}">{{ $detail->course_classification_detailsname }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Course Name Filter -->
                                    <!-- <div class="form-group">
                                        <label for="course_name">Course Name:</label>
                                        <input type="text" name="course_name" id="course_name" class="form-control" value="{{ isset($course) ? $course->coursename : '' }}" style="display: inline-block; width: 60%;">
                                    </div> -->
                                    <div class="form-group">
                                        <label for="course_name">&emsp;Course Name:</label>
                                        &emsp;<input type="text" name="course_name" id="course_name" class="form-control"
                                            style="display: inline-block; width: 60%;"
                                            value="{{ isset($course) ? $course->coursename : '' }}">
                                    </div>
                                    <!-- Search Button -->
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary btn-block" style="background-color: darkblue">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <!-- DataTable -->
                                <table id="courseTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" >
                                    <thead>
                                        <tr>
                                            <th>Course Classification</th>
                                            <th>Course Classification Details</th>
                                            <th>Course Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($filteredCourses))
                                            @foreach($filteredCourses as $course)
                                                <tr>
                                                    <td>{{ $course->course_classification_id }}</td>
                                                    <td>{{ $course->course_classification_details_id }}</td>
                                                    <td>{{ $course->coursename }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">No courses found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    @include('includes.footer')
@endsection

@section('scripts')
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
<script>
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
    });
</script>
<!-- Script for Modals -->
<script>
    $(document).ready(function () {
            var table = $('#courseTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip',
                buttons: ['copy', 'excel', 'pdf']
            });
        });
</script>
@endsection
