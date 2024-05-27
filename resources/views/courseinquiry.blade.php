@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<style>
    .sticky-list-group {
        position: sticky;
        top: 10px; /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
    }
</style>
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
                    <li class="breadcrumb-item"><a href="{{ route('course-inquiry') }}" title="Course by Inquiry">コース別照会</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-list') }}" title="Course List">コース一覧</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="Course by inquiry">コース別受講照会</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="Course Specific Inquiry"><b style="color:aliceblue">コース</b></div>
                <!-- <h3>Course Classification: </h3> -->
                <!-- <h3>Course Classification Details: </h3> -->
                <!-- <h3>Course Name: </h3> -->
                <!-- <br><br> -->
                <div class="form-group">
                    <label for="course_classification">&emsp;コース分類/Course classification:</label>
                    <select class="form-control" id="course_classification" name="course_classification" title="Course Classification" required style="display: inline-block; width: 60%;">
                        <option value="" title="Select Course Classification">コース分類を選択します</option>
                        @foreach($classifications as $classification)
                            <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="course_classification_details">&emsp;コース分類詳細/Course classification details:</label>
                    <select class="form-control" id="course_classification_details" name="course_classification_details" title="Course Classification Details" required style="display: inline-block; width: 60%;">
                        <option value="" title="Select Course Classification Details">コース分類の詳細を選択します</option>
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
                    <label for="course_id">&emsp;コース名/Course Name:</label>
                    <select name="course_id" title="Course Name" id="course_id" class="form-control" style="display: inline-block; width: 60%;">
                        <option value="" title="Select Course">コース名</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" @if(isset($selectedCourse) && $selectedCourse->id == $course->id) selected @endif>{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-header" style="background-color: darkblue" title="Employees attending the course"><b style="color:aliceblue"> 受講社員/Employees attending the course</b></div>
                <div class="card-body">
                    <form action="{{ route('course-inquiry-search') }}" method="get">
                        <div class="form-group">
                            <label for="affiliation_id">所属名/Affiliation name:</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control" id="affiliation_id" title="Affiliation" name="affiliationId" required style="display: inline-block; width: 60%;">
                                    <option value="" title="Select Affiliation">所属名</option>
                                    @foreach($affiliations as $affiliation)
                                        <option value="{{ $affiliation->id }}">{{ $affiliation->affiliation_name }}</option>
                                    @endforeach
                                </select>&emsp;
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="Display selected affiliation" title="Display selected affiliation"> 選択所属を表示
                                    </label>
                                    <label class="radio-inline ml-3">
                                        <input type="radio" name="search_option" value="Display selected affiliation and below" title="Show below selected affiliation"> 選択所属以下を表示
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="job_id">役職名:</label>
                            <select class="form-control" title="Job Title" id="job_id" name="jobId" required style="display: inline-block; width: 50%;">
                                <option value="" title="Select Job Title">役職名</option>
                                @foreach($jobTitles as $job)
                                    <option value="{{ $job->id }}">{{ $job->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fullname">&emsp;氏名/Full name:</label>
                            <input type="text" class="form-control" title="Full Name" id="fullname" name="fullname" placeholder="Enter Full Name" style="display: inline-block; width: 60%;" onkeyup="updateEmployeeCode()">
                        </div>
                        <div class="form-group">
                            <label for="employee_code">&emsp;社員コード/Employee Code:</label>
                            <input type="text" class="form-control" title="Employee Code" id="employee_code" name="employee_code" placeholder="Enter Employee Code" style="display: inline-block; width: 60%;">
                        </div>
                        <div class="form-group">
                            <label for="course_deadline">&emsp;受講期限/Course Deadline :</label>
                            <div class="d-flex align-items-center">
                                <input type="date" title="Course Deadline" name="course_deadline" id="course_deadline" class="form-control mr-3" style="width: 20%;">
                                <div >
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="Designated date" title="Designated date"> 指定日
                                    </label>
                                    <label class="radio-inline ml-3">
                                        <input type="radio" name="search_option" value="After the designated date" title="After the specified date"> 指定日以降
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div align="center">
                            <button type="submit" class="btn btn-primary btn-block" title="Search" style="background-color: darkblue">検索</button>
                        </div>
                    </form>
                </div><br>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header" title="List of employees attending the course" style="background-color: #92CDFC; display: flex; justify-content: space-between; align-items: center;">
                            <b style="color: aliceblue; margin: 0;">受講社員一覧/List of employees attending the course</b>
                            <a href="#" class="btn btn-info" title="ToDo Inquiry">ToDo照会</a>
                        </div>
                        <!-- DataTable -->
                        <table id="courseinquiryTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" >
                            <thead>
                                <tr>
                                    <th title="Affiliation">所属</th>
                                    <th title="Job Title(Pos)">役職</th>
                                    <th title="Full Name">氏名</th>
                                    <th title="Employee Codes">社員コード</th>
                                    <th title="Sex">性別</th>
                                    <th title="Age">年齢</th>
                                    <th title="Information day">案内日</th>
                                    <th title="Course deadline">受講期限</th>
                                    <th title="ToDo progress">ToDo進捗</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->affiliation ? $employee->affiliation->affiliation_name : 'No Affiliation' }}</td>
                                    <td>{{ $employee->job ? $employee->job->job_title : 'No Job Title' }}</td>
                                    <td>{{ $employee->fullname }}</td>
                                    <td>{{ $employee->employee_code }}</td>
                                    <td>{{ $employee->sex }}</td>
                                    <td>{{ \Carbon\Carbon::parse($employee->dateofbirth)->age }}</td>
                                    <!-- Kosongkan untuk kolom lainnya -->
                                    <td></td>
                                    <td>{{ $employee->courseInformation ? $employee->courseInformation->deadline_enrollment : 'No Deadline' }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- List of Links and Buttons -->
        <div class="col-md-2">
            <br><br><br><br><br>
            <div class="mt-2 sticky-list-group">
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
