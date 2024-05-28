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
                    <li class="breadcrumb-item"><a href="{{ route('employee-inquiry') }}" title="Inquiry by employee">従業員による問い合わせ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="List of employees">従業員のリスト</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="Attendance inquiry by employee">従業員による出席照会</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="Employee"><b style="color:aliceblue">従業員</b></div>
                    <form action="{{ route('employee.filter') }}" method="get"><br>
                        @csrf
                        <div class="form-group">
                            <label for="affiliation_id">&emsp;所属:</label>
                            <select class="form-control" title="Affiliation" id="affiliation_id" name="affiliationId" required style="display: inline-block; width: 60%;">
                                <option title="Select Affiliation" value="">所属を選択します</option>
                                @foreach($affiliations as $affiliation)
                                    <option value="{{ $affiliation->id }}">{{ $affiliation->affiliation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="job_id">&emsp;役職:</label>
                            <select class="form-control" title="Job Title" id="job_id" name="jobId" required style="display: inline-block; width: 60%;">
                                <option title="Select Job Title" value="">役職を選択します</option>
                                @foreach($jobTitles as $job)
                                    <option value="{{ $job->id }}">{{ $job->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fullname">&emsp;フルネーム:</label>
                            <input type="text" title="Full Name" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" style="display: inline-block; width: 60%;">
                        </div>
                        <div class="form-group">
                            <label for="employee_code">&emsp;従業員コード:</label>
                            <input type="text" title="Employee Code" class="form-control" id="employee_code" name="employee_code" placeholder="Enter Employee Code" style="display: inline-block; width: 60%;">
                        </div>
                        <div class="card-header" style="background-color: darkblue" title="Course Taken"><b style="color:aliceblue">コースが取られました</b></div><br>
                        <div class="form-group">
                            <label for="course_classification">&emsp;コース分類:</label>
                            <select class="form-control" id="course_classification_id" name="course_classification_id" title="Course Classification" required style="display: inline-block; width: 60%;">
                            <option title="Select Course Classification" value="">コース分類を選択します</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_classification_details">&emsp;コース分類の詳細:</label>
                            <select class="form-control" id="course_classification_details_id" title="Course Classification Details" name="course_classification_details_id" required style="display: inline-block; width: 60%;">
                                <option title="Select Course Classification Details" value="">コース分類の詳細を選択します</option>
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
                        <label for="course_id">&emsp;コース名:</label>
                        <select name="course_id" id="course_id" title="Course Name" class="form-control" style="display: inline-block; width: 60%;">
                            <option title="Select Course" value="">コースを選択します</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div align="center">
                        <button type="submit" class="btn btn-primary btn-block" title="Search" style="background-color: darkblue">検索</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-header" style="background-color: #92CDFC" align="center" title="Employee List"><b style="color:aliceblue">従業員リスト</b></div>
                    <!-- DataTable -->
                    <table id="employeeinquiryTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th title="Affiliation">所属</th>
                                <th title="Job Title (Pos)">役職 POS</th>
                                <th title="Full Name">フルネーム</th>
                                <th title="Employee Code">従業員コード</th>
                                <th title="Sex">セックス</th>
                                <th title="Age">年</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($filteredEmployees as $employee)
                            <tr>
                                <td><input type="checkbox" class="employee-checkbox" value="{{ $employee->id }}"></td>
                     <td>{{ $employee->employee_affiliation->affiliation->affiliation_name }}</td>
                                    <td>{{ $employee->employee_affiliation->job->job_title }}</td>
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
        </div>
        
            <div class="col-md-2">
            <br><br><br><br><br>
                <div class="mt-2 sticky-list-group">
                    <ul class="list-group rounded-6" style="float: right;">
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-list') }}" title="Course list"><b style="color:aliceblue"> 社員一覧</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-inquiry') }}" title="Attendance inquiry"><b style="color:aliceblue">  受講照会トップ</b></a></li>
                    </ul>
                </div>
            </div>
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
