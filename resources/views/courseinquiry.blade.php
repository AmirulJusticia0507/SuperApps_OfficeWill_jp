@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
    <!-- Header -->
    @include('includes.header')


    <!-- Main Content -->
    {{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-7">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Course-specific Inquiry</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Course-specific inquiry</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Specific Inquiry</b></div>
                <h3>Course Classification: </h3>
                <h3>Course Classification Details: </h3>
                <h3>Course Name: </h3>
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue"> Employees attending the course</b></div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="form-group">
                            <label for="affiliation_id">Affiliation:</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control mr-3" id="affiliation_id" name="affiliation_id" required style="width: 60%;">
                                    <!-- Opsi pilihan affiliasi -->
                                </select>
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
                            <label for="job_id">&emsp;Job Title:</label>
                            <select class="form-control" id="job_id" name="job_id" required style="display: inline-block; width: 60%;">

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
                        <div class="form-group">
                            <label for="course_deadline">Course Deadline :</label>
                            <div class="d-flex align-items-center">
                                <input type="date" name="course_deadline" id="course_deadline" class="form-control mr-3" style="width: 20%;">
                                <div>
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- List of Links and Buttons -->
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

    <!-- Footer -->
    @include('includes.footer')
@endsection

@section('scripts')
    <!-- Script DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
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
@endsection
