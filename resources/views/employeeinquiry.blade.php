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
                        <li class="breadcrumb-item"><a href="#">Inquiry by employee</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employee-list') }}">List of employees</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Attendance inquiry by employee</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Employee</b></div>
                                <form action="{{ route('employee.filter') }}" method="get"><br>
                                    @csrf
                                    <div class="form-group">
                                        <label for="affiliation_id">&emsp;Affiliation:</label>
                                        <select class="form-control" id="affiliation_id" name="affiliationId" required style="display: inline-block; width: 60%;">
                                            <option value="">Select Affiliation</option>
                                            @foreach($affiliations as $affiliation)
                                                <option value="{{ $affiliation->id }}">{{ $affiliation->affiliation_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_id">&emsp;Job Title:</label>
                                        <select class="form-control" id="job_id" name="jobId" required style="display: inline-block; width: 60%;">
                                            <option value="">Select Job Title</option>
                                            @foreach($jobTitles as $job)
                                                <option value="{{ $job->id }}">{{ $job->job_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname">&emsp;Full Name:</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" style="display: inline-block; width: 60%;">
                                    </div>
                                    <div class="form-group">
                                        <label for="employee_code">&emsp;Employee Code:</label>
                                        <input type="text" class="form-control" id="employee_code" name="employee_code" placeholder="Enter Employee Code" style="display: inline-block; width: 60%;">
                                    </div>
                                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Taken</b></div><br>
                                    <div class="form-group">
                                        <label for="course_classification">&emsp;Course Classification:</label>
                                        <select class="form-control" id="course_classification" name="course_classification" required style="display: inline-block; width: 60%;">
                                            <option value="">Select Course Classification</option>
                                            @foreach($classifications as $classification)
                                                <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_classification_details">&emsp;Course Classification Details:</label>
                                        <select class="form-control" id="course_classification_details" name="course_classification_details" required style="display: inline-block; width: 60%;">
                                            <option value="">Select Course Classification Details</option>
                                            <!-- Tambahkan foreach loop untuk menampilkan pilihan course classification details -->
                                            @foreach($details as $detail)
                                                <option value="{{ $detail->id }}">{{ $detail->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <!-- <div class="form-group">
                                    <label for="course_name">&emsp;Course Name:</label>
                                    <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Enter Course Name" required style="display: inline-block; width: 60%;">
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="course_name">&emsp;Course Name:</label>
                                    &emsp;<input type="text" name="course_name" id="course_name" class="form-control"
                                        style="display: inline-block; width: 60%;"
                                        value="{{ isset($course) ? $course->coursename : '' }}">
                                </div> -->
                                <div class="form-group">
                                    <label for="course_id">&emsp;Course Name:</label>
                                    <select name="course_id" id="course_id" class="form-control" style="display: inline-block; width: 60%;">
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @if(isset($selectedCourse) && $selectedCourse->id == $course->id) selected @endif>{{ $course->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div align="center">
                                    <button type="submit" class="btn btn-primary btn-block" style="background-color: darkblue">Search</button>
                                </div>
                            </form>

                            <div class="card-header" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">Employee List</b></div>
                                <!-- DataTable -->
                                <table id="employeeinquiryTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Affiliation</th>
                                            <th>Job Title (Pos)</th>
                                            <th>Full Name</th>
                                            <th>Employee Code</th>
                                            <th>Sex</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($filteredEmployees as $employee)
                                        <tr>
                                            <td><input type="checkbox" class="employee-checkbox" value="{{ $employee->id }}"></td>
                                            <td>{{ $employee->affiliation->affiliation_name }}</td>
                                            <td>{{ $employee->job->job_title }}</td>
                                            <td>{{ $employee->fullname }}</td>
                                            <td>{{ $employee->employee_code }}</td>
                                            <td>{{ $employee->sex }}</td>
                                            <td>{{ \Carbon\Carbon::parse($employee->dateofbirth)->age }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mt-2">
                                <ul class="list-group rounded-6" style="float: right;">
                                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-list') }}" title="Course list"><b style="color:aliceblue"> 社員一覧</b></a></li>
                                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-inquiry') }}" title="Attendance inquiry"><b style="color:aliceblue">  受講照会トップ</b></a></li>
                                </ul>
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
    <!-- Script DataTables -->

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
            var table = $('#employeeinquiryTable').DataTable({
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
