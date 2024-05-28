@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
    <!-- Header -->
    @include('includes.header')

    <div class="row justify-content-center">
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-8">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" Title="Course Settings">コース設定</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-list') }}" Title="Course List">コースリスト</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="Course Settings">コース設定</li>
                </ol>
            </nav>
            <!-- Create Classification Form -->
            <div id="filterCourseWrap">
                <div class="card" x-data="{ open: false }">
                    <div class="card-header" style="background-color: darkblue"
                        title="Course Settings -> Choose your course"><b style="color:aliceblue">コース設定 - >コースを選択します</b>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('course-settings') }}" x-init x-target="filterCourseWrap" x-show="open">
                            <div class="form-group">
                                <label for="course_classification">&emsp;コース分類:</label>
                                <select class="form-control" id="course_classification_id" name="course_classification_id"
                                    title="Course Classification" style="display: inline-block; width: 60%;">
                                    @foreach ($classifications as $classification)
                                        <option value=""></option>
                                        <option value="{{ $classification->id }}">
                                            {{ $classification->course_classification_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Course Classification Details Filter -->
                            <div class="form-group">
                                <label for="course_classification_details">&emsp;コース分類の詳細:</label>
                                <select class="form-control" id="course_classification_details_id"
                                    name="course_classification_details_id" title="Course Classification Details"
                                    style="display: inline-block; width: 60%;">
                                    @foreach ($details as $detail)
                                        <option value="{{ $detail->course_classification_details_id }}">
                                            {{ $detail->course_classification_detailsname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_name">&emsp;コース名:</label>
                                &emsp;<input type="text" name="course_name" id="course_name" class="form-control"
                                    title="Course Name" style="display: inline-block; width: 60%;"
                                    value="{{ isset($course) ? $course->coursename : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_01" style="display: inline-block; width: 30%;">&emsp;コース属性01
                                    :</label>
                                <select name="course_attributes_01" id="course_attributes_01" title="(Course attribute 01)"
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
                                        <input type="radio" name="search_option" value="exact_match" Title="Exact Match">
                                        完全に一致
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="range_search"
                                            title="Range Search">
                                        Range
                                        Search
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_more_search"
                                            title="Or More Search"> Or
                                        More Search
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_less_search"
                                            title="Or Less Search">以下の検索h
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_02" style="display: inline-block; width: 30%;">&emsp;コース属性02
                                    :</label>
                                <input type="text" name="course_attributes_02" id="course_attributes_02"
                                    class="form-control" title="(Course attribute02)"
                                    style="display: inline-block; width: 60%;">
                            </div>
                            <div class="form-group">
                                <label style="display: inline-block; width: 30%;"></label>
                                <div style="display: inline-block; width: 60%;">
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="partial_match"
                                            title="Partial Match">
                                        部分的な一致
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="range_search"
                                            title="Range Search">
                                        範囲検索
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_more_search"
                                            title="Or More Search"> またはそれ以上の検索
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_less_search"
                                            title="Or Less Search"> 以下の検索
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_03" style="display: inline-block; width: 30%;">&emsp;コース属性03
                                    :</label>
                                <select name="course_attributes_03" id="course_attributes_03"
                                    title="(Course attribute03)" style="display: inline-block; width: 60%;"
                                    class="form-control">
                                    <option value="-"> </option>
                                    <option value="Perfect matching" Title="(Perfect matching)">（完全なマッチング）</option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_04" style="display: inline-block; width: 30%;">&emsp;コース属性04
                                    :</label>
                                <input type="text" name="course_attributes_04" id="course_attributes_04"
                                    title="(Course attribute04)" class="form-control"
                                    style="display: inline-block; width: 60%;">
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_05" style="display: inline-block; width: 30%;">&emsp;コース属性05
                                    :</label>
                                <input type="text" name="course_attributes_05" id="course_attributes_05"
                                    title="(Course attribute05)" class="form-control"
                                    style="display: inline-block; width: 60%;">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info" title="search"
                                    style="color: white">検索</button>
                            </div>
                        </form>
                        <div class="text-right">
                            <button x-on:click="open = ! open"
                                x-text="open ? 'Close search conditions': 'Open search conditions'"></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-header" style="background-color: #92CDFC" title="Course List" align="center"><b
                                style="color:aliceblue">コースリスト</b></div>
                        <!-- DataTable -->
                        <table id="courseTable"
                            class="display table table-bordered table-striped table-hover responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th Title="Course Classification">コース分類</th>
                                    <th title="Course Classification Details">コース分類の詳細</th>
                                    <th Title="Course Name">コース名</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td><input type="checkbox" class="course-checkbox"
                                                value="{{ $course->course_id }}">
                                        </td>
                                        <td>{{ $course->classification->course_classification_name }}</td>
                                        <td>{{ $course->classification_detail->course_classification_detailsname }}</td>
                                        <td>{{ $course->coursename }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="filterEmployeeWrap">
                <div class="card" x-data="{ open: false }">
                    <div class="card-header" style="background-color: darkblue" Title="Employee Choice"><b
                            style="color:aliceblue">従業員の選択</b></div>
                    <div class="card-body">
                        <form action="{{ route('course-settings') }}" x-init x-target="filterEmployeeWrap"
                            x-show="open"><br>
                            <div class="form-group">
                                <label for="affiliation_code">&emsp;所属:</label>
                                <select class="form-control" title="Affiliation" id="affiliation_code"
                                    name="affiliation_code" style="display: inline-block; width: 60%;"
                                    @input.debounce="$el.form.requestSubmit()">
                                    <option value="" Title="Select Affiliation">所属を選択します</option>
                                    @foreach ($affiliations as $affiliation)
                                        <option value="{{ $affiliation->affiliation_code }}"
                                            @if (request()->affiliation_code == $affiliation->affiliation_code) selected @endif>
                                            {{ $affiliation->affiliation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="job">&emsp;役職:</label>
                                <select class="form-control" title="Job Title" id="job" name="job"
                                    style="display: inline-block; width: 60%;" @input.debounce="$el.form.requestSubmit()">
                                    <option value="" title="Select Job Title">役職を選択します</option>
                                    @foreach ($jobTitles as $job)
                                        <option value="{{ $job->job_id }}"
                                            @if (request()->job == $job->job_id) selected @endif>
                                            {{ $job->job_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fullname">&emsp;フルネーム:</label>
                                <input type="text" class="form-control" title="Full Name" id="fullname"
                                    name="fullname" value="{{ request()->fullname }}" placeholder="Enter Full Name"
                                    style="display: inline-block; width: 60%;" @input.debounce="$el.form.requestSubmit()">
                            </div>
                            <div class="form-group">
                                <label for="employee_code">&emsp;従業員コード:</label>
                                <input type="text" class="form-control" title="Employee Code" id="employee_code"
                                    name="employee_code" value="{{ request()->employee_code }}"
                                    placeholder="Enter Employee Code" style="display: inline-block; width: 60%;"
                                    @input.debounce="$el.form.requestSubmit()">
                            </div>
                            <div class="mb-3">
                                <div style="display: flex; align-items: center;">
                                    <label for="sex" style="margin-right: 10px;" title="Sex"
                                        style="width: 100%">&emsp;セックス: <b style="color: red">*</b></label>
                                    <div style="display: flex;" style="display: inline-block; width: 60%;">
                                        <label for="male" style="margin-right: 10px;">
                                            <input type="radio" name="sex" id="male" value="male"
                                                title="Male" @if (request()->sex == 'male') checked @endif
                                                @input.debounce="$el.form.requestSubmit()">
                                            &emsp;男</label>
                                        <label for="female" style="margin-right: 10px;">
                                            <input type="radio" name="sex" id="female" value="female"
                                                title="Female" @if (request()->sex == 'female') checked @endif
                                                @input.debounce="$el.form.requestSubmit()">
                                            &emsp;女性</label>
                                        <label for="other">
                                            <input type="radio" name="sex" id="other" title="Other"
                                                value="other" @if (request()->sex == 'other') checked @endif
                                                @input.debounce="$el.form.requestSubmit()">
                                            &emsp;他の</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="date_of_birth" style="margin-right: 10px; flex-grow: 1;">&emsp;生年月日: <b
                                        style="color: red">*</b></label>
                                &emsp;<input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                    title="Date of Birth" min="1970-01-01" max="{{ date('Y-m-d') }}"
                                    value="{{ request()->date_of_birth }}" style="width: 70%; display: inline-block;"
                                    @input.debounce="$el.form.requestSubmit()">
                            </div>
                            <div class="form-group">
                                <label style="display: inline-block; width: 30%;"></label>
                                <div style="display: inline-block; width: 60%;">
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="exact_match"
                                            Title="Exact Match" @input.debounce="$el.form.requestSubmit()">完全に一致h
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="range_search"
                                            Title="Range Search" @input.debounce="$el.form.requestSubmit()">
                                        範囲検索
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="or_more_search"
                                            Title="Or More Search" @input.debounce="$el.form.requestSubmit()"> Or More
                                        Search
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="or_less_search"
                                            title="Or Less Search" @input.debounce="$el.form.requestSubmit()"> Or Less
                                        Search
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="date_of_joining" style="margin-right: 10px; flex-grow: 1;">&emsp;入社の日:</label>
                                <input type="date" name="date_of_joining" id="date_of_joining" class="form-control"
                                    title="Date of Joining" min="2022-01-01" max="{{ date('Y-m-d') }}"
                                    value="{{ request()->date_of_joining }}" style="width: 70%; display: inline-block;"
                                    @input.debounce="$el.form.requestSubmit()">
                            </div>
                            <div class="form-group">
                                <label style="display: inline-block; width: 30%;"></label>
                                <div style="display: inline-block; width: 60%;">
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="exact_match"
                                            Title="Exact Match" @input.debounce="$el.form.requestSubmit()">
                                        完全に一致
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="range_search"
                                            Title="Range Search" @input.debounce="$el.form.requestSubmit()">範囲検索h
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="or_more_search"
                                            Title="Or More Search" @input.debounce="$el.form.requestSubmit()"> またはそれ以上の検索
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="or_less_search"
                                            Title="Or Less Search" @input.debounce="$el.form.requestSubmit()"> 以下の検索
                                    </label>
                                </div>
                            </div>
                            <x-attributeEmployeeComponent />
                            <div class="text-center">
                                <button x-show="true" type="submit" class="btn btn-info" title="search"
                                    style="color: white">検索</button>
                            </div>
                        </form>
                        <div class="text-right">
                            <button x-on:click="open = ! open"
                                x-text="open ? 'Close search conditions': 'Open search conditions'"></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-header" title="Employee List" style="background-color: #92CDFC" align="center">
                            <b style="color:aliceblue">従業員リスト</b>
                        </div>
                        <!-- DataTable -->
                        <table id="employeeTable"
                            class="display table table-bordered table-striped table-hover responsive nowrap"
                            style="width:100%">
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
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td><input type="checkbox" class="employee-checkbox"
                                                value="{{ $employee->employee_id }}">
                                        </td>
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
            <div class="card">
                <div class="card-body">
                    <form action="{{route('course-settings.store')}}" method="POST" id="formSetupAttendence" class="form-inline">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="staticEmail2">Deadline for enrollment</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control date-picker" name="deadline" required>
                        </div>
                        <button type="submit" class="btn btn-info mb-2">Set up attendance</button>
                    </form>
                </div>
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
    <script>
        $(document).ready(function() {
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
