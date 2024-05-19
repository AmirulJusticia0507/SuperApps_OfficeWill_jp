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
                        <li class="breadcrumb-item"><a href="#">Course Settings</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Settings</li>
                    </ol>
                </nav>
                <!-- Create Classification Form -->
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Settings -> Choose your course</b></div><br><br>
                    <form action="{{ route('course.filter') }}" method="get"><br>
                        @csrf
                        <div class="form-group">
                            <label for="course_classification">&emsp;Course Classification:</label>
                            <select class="form-control" id="course_classification_id" name="Course_classification_id" required style="display: inline-block; width: 60%;">
                                @foreach($classifications as $classification)
                                <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course Classification Details Filter -->
                        <div class="form-group">
                            <label for="course_classification_details">&emsp;Course Classification Details:</label>
                            <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required style="display: inline-block; width: 60%;">
                                @foreach($details as $detail)
                                <option value="{{ $detail->course_classification_details_id }}">
                                    {{ $detail->course_classification_detailsname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_name">&emsp;Course Name:</label>
                            &emsp;<input type="text" name="course_name" id="course_name" class="form-control" style="display: inline-block; width: 60%;" value="{{ isset($course) ? $course->coursename : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_01" style="display: inline-block; width: 30%;">&emsp;(Course attribute 01) :</label>
                            <select name="course_attributes_01" id="course_attributes_01"
                                style="display: inline-block; width: 60%;" class="form-control">
                                <option value="-"> </option>
                                <option value=""> </option>
                                <option value=""> </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="display: inline-block; width: 30%;"></label>
                            <div style="display: inline-block; width: 60%;">
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="exact_match"> Exact Match
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="range_search"> Range Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_more_search"> Or More Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_02" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                02) :</label>
                            <input type="text" name="course_attributes_02" id="course_attributes_02" class="form-control"
                                style="display: inline-block; width: 60%;">
                        </div>
                        <div class="form-group">
                            <label style="display: inline-block; width: 30%;"></label>
                            <div style="display: inline-block; width: 60%;">
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="partial_match"> Partial Match
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="range_search"> Range Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_more_search"> Or More Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_03" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                03) :</label>
                            <select name="course_attributes_03" id="course_attributes_03"
                                style="display: inline-block; width: 60%;" class="form-control">
                                <option value="-"> </option>
                                <option value="Perfect matching">(Perfect matching)</option>
                                <option value=""> </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_04" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                04) :</label>
                            <input type="text" name="course_attributes_04" id="course_attributes_04" class="form-control"
                                style="display: inline-block; width: 60%;">
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_05" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                05) :</label>
                            <input type="text" name="course_attributes_05" id="course_attributes_05" class="form-control"
                                style="display: inline-block; width: 60%;">
                        </div>
                        <div align="center">
                            <button type="submit" class="btn btn-info" style="color: white">search</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header" style="background-color: #92CDFC" align="center"><b
                                style="color:aliceblue">Course List</b></div>
                        <!-- DataTable -->
                        <table id="courseTable" class="display table table-bordered table-striped table-hover responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Course Classification</th>
                                    <th>Course Classification Details</th>
                                    <th>Course Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredCourses as $course)
                                <tr>
                                    <td><input type="checkbox" class="course-checkbox" value="{{ $course->id }}"></td>
                                    <td>{{ $course->classification->course_classification_name }}</td>
                                    <td>{{ $course->detail->course_classification_detailsname }}</td>
                                    <td>{{ $course->coursename }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><hr>

                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Employee Choice</b></div>
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
                        <div class="mb-3">
                            <div style="display: flex; align-items: center;">
                                <label for="sex" style="margin-right: 10px;" style="width: 100%">&emsp;Sex: <b style="color: red">*</b></label>
                                <div style="display: flex;" style="display: inline-block; width: 60%;">
                                    <input type="radio" name="sex" id="male" value="male" required>
                                    <label for="male" style="margin-right: 10px;">&emsp;Male</label>
                                    <input type="radio" name="sex" id="female" value="female" required>
                                    <label for="female" style="margin-right: 10px;">&emsp;Female</label>
                                    <input type="radio" name="sex" id="other" value="other" required>
                                    <label for="other">&emsp;Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="date_of_birth" style="margin-right: 10px; flex-grow: 1;">&emsp;Date of Birth: <b style="color: red">*</b></label>
                            &emsp;<input type="date" name="date_of_birth" id="date_of_birth" class="form-control" min="1970-01-01" max="{{ date('Y-m-d') }}" style="width: 70%; display: inline-block;" required>
                        </div>
                        <div class="form-group">
                            <label style="display: inline-block; width: 30%;"></label>
                            <div style="display: inline-block; width: 60%;">
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="exact_match"> Exact Match
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="range_search"> Range Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_more_search"> Or More Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                                </label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="date_of_joining" style="margin-right: 10px; flex-grow: 1;">&emsp;Date of Joining:</label>
                            <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" min="2022-01-01" max="{{ date('Y-m-d') }}" style="width: 70%; display: inline-block;" required>
                        </div>
                        <div class="form-group">
                            <label style="display: inline-block; width: 30%;"></label>
                            <div style="display: inline-block; width: 60%;">
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="exact_match"> Exact Match
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="range_search"> Range Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_more_search"> Or More Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_01" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                01) :</label>
                            <select name="course_attributes_01" id="course_attributes_01"
                                style="display: inline-block; width: 60%;" class="form-control">
                                <option value="-"> </option>
                                <option value=""> </option>
                                <option value=""> </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="display: inline-block; width: 30%;"></label>
                            <div style="display: inline-block; width: 60%;">
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="exact_match"> Exact Match
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="range_search"> Range Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_more_search"> Or More Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_02" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                02) :</label>
                            <input type="text" name="course_attributes_02" id="course_attributes_02" class="form-control"
                                style="display: inline-block; width: 60%;">
                        </div>
                        <div class="form-group">
                            <label style="display: inline-block; width: 30%;"></label>
                            <div style="display: inline-block; width: 60%;">
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="partial_match"> Partial Match
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="range_search"> Range Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_more_search"> Or More Search
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_03" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                03) :</label>
                            <select name="course_attributes_03" id="course_attributes_03"
                                style="display: inline-block; width: 60%;" class="form-control">
                                <option value="-"> </option>
                                <option value="Perfect matching">(Perfect matching)</option>
                                <option value=""> </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_04" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                04) :</label>
                            <input type="text" name="course_attributes_04" id="course_attributes_04" class="form-control"
                                style="display: inline-block; width: 60%;">
                        </div>
                        <div class="form-group">
                            <label for="course_attributes_05" style="display: inline-block; width: 30%;">&emsp;(Course attribute
                                05) :</label>
                            <input type="text" name="course_attributes_05" id="course_attributes_05" class="form-control"
                                style="display: inline-block; width: 60%;">
                        </div>
                        <div align="center">
                            <button type="submit" class="btn btn-info" style="color: white">search</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">Employee List</b></div>
                        <!-- DataTable -->
                        <table id="employeeTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
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
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </main>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Footer -->
    @include('includes.footer')
    @endsection

    @section('scripts')
    <!-- Script DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
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
