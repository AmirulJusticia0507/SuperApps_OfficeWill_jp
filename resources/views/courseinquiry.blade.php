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
                        <li class="breadcrumb-item"><a href="{{ route('course-inquiry') }}">Course-specific Inquiry</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course-specific inquiry</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Specific Inquiry</b></div>
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
                            <div class="form-group">
                                <label for="course_id">&emsp;Course Name:</label>
                                <select name="course_id" id="course_id" class="form-control" style="display: inline-block; width: 60%;">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" @if(isset($selectedCourse) && $selectedCourse->id == $course->id) selected @endif>{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue"> Employees attending the course</b></div>
                            <div class="card-body">
                                <form action="{{ route('course-inquiry-search') }}" method="get">
                                    <div class="form-group">
                                        <label for="affiliation_id">Affiliation:</label>
                                        <div class="d-flex align-items-center">
                                            <select class="form-control" id="affiliation_id" name="affiliationId" required style="display: inline-block; width: 60%;">
                                                <option value="">Select Affiliation</option>
                                                @foreach($affiliations as $affiliation)
                                                    <option value="{{ $affiliation->id }}">{{ $affiliation->affiliation_name }}</option>
                                                @endforeach
                                            </select>&emsp;
                                            <div>
                                                <label class="radio-inline">
                                                    <input type="radio" name="search_option" value="Display selected affiliation"> Display selected affiliation
                                                </label>
                                                <label class="radio-inline ml-3">
                                                    <input type="radio" name="search_option" value="Display selected affiliation and below"> Display selected affiliation and below
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_id">Job Title:</label>
                                        <select class="form-control" id="job_id" name="jobId" required style="display: inline-block; width: 50%;">
                                            <option value="">Select Job Title</option>
                                            @foreach($jobTitles as $job)
                                                <option value="{{ $job->id }}">{{ $job->job_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname">&emsp;Full Name:</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" style="display: inline-block; width: 60%;" onkeyup="updateEmployeeCode()">
                                    </div>
                                    <div class="form-group">
                                        <label for="employee_code">&emsp;Employee Code:</label>
                                        <input type="text" class="form-control" id="employee_code" name="employee_code" placeholder="Enter Employee Code" style="display: inline-block; width: 60%;">
                                    </div>
                                    <div class="form-group">
                                        <label for="course_deadline">&emsp;Course Deadline :</label>
                                        <div class="d-flex align-items-center">
                                            <input type="date" name="course_deadline" id="course_deadline" class="form-control mr-3" style="width: 20%;">
                                            <div >
                                                <label class="radio-inline">
                                                    <input type="radio" name="search_option" value="Designated date"> Designated date
                                                </label>
                                                <label class="radio-inline ml-3">
                                                    <input type="radio" name="search_option" value="After the designated date"> After the designated date
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary btn-block" style="background-color: darkblue">Search</button>
                                    </div>
                                </form>
                            </div><br>

                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header" style="background-color: #92CDFC; display: flex; justify-content: space-between; align-items: center;">
                                        <b style="color: aliceblue; margin: 0;">List of employees attending the course</b>
                                        <a href="#" class="btn btn-info">ToDo Inquiry</a>
                                    </div>
                                    <!-- DataTable -->
                                    <table id="courseinquiryTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" >
                                        <thead>
                                            <tr>
                                                <th>Affiliation</th>
                                                <th>Job Title(Pos)</th>
                                                <th>Full Name</th>
                                                <th>Employee Codes</th>
                                                <th>Sex</th>
                                                <th>Age</th>
                                                <th>Information day</th>
                                                <th>Course deadline</th>
                                                <th>ToDo progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employees as $employee)
                                            <tr>
                                                <td>{{ $employee->affiliation }}</td>
                                                <td>{{ $employee->job_title }}</td>
                                                <td>{{ $employee->fullname }}</td>
                                                <td>{{ $employee->employee_code }}</td>
                                                <td>{{ $employee->sex }}</td>
                                                <td>{{ $employee->age }}</td>
                                                <!-- Kosongkan untuk kolom lainnya -->
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <br><br><br><br><br>
                        <div class="mt-2">
                            <ul class="list-group rounded-6" style="float: right;">
                                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-list') }}" title="Course list"><b style="color:aliceblue"> コース一覧</b></a></li>
                                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('course-inquiry') }}" title="Attendance inquiry"><b style="color:aliceblue">  受講照会トップ</b></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
            <br>
        </div>
    </div><br><br><br><br><br><br>

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
            var table = $('#courseinquiryTable').DataTable({
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
    <script>
        function updateEmployeeCode() {
            var fullname = document.getElementById('fullname').value;
            // Logika untuk menghasilkan kode karyawan berdasarkan nama lengkap
            // Misalnya, Anda dapat menggunakan inisial atau bagian dari nama sebagai kode karyawan
            var employeeCode = generateEmployeeCode(fullname);
            document.getElementById('employee_code').value = employeeCode;
        }

        function generateEmployeeCode(fullname) {
            // Misalnya, menggunakan inisial dari setiap kata dalam nama lengkap
            var initials = fullname.split(' ').map(name => name.charAt(0).toUpperCase()).join('');
            return initials;
        }
    </script>
@endsection
