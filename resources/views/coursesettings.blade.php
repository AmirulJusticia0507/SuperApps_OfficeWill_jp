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
                    <li class="breadcrumb-item"><a href="#" title="{{ __('Course Settings') }}">{{ __('Course Settings') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-list') }}" title="{{ __('Course List') }}">{{ __('Course List') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="{{ __('Course Settings') }}">{{ __('Course Settings') }}</li>
                </ol>
            </nav>
            <!-- Create Classification Form -->
            <div id="filterCourseWrap">
                <div class="card" x-data="{ open: false }">
                    <div class="card-header" style="background-color: darkblue"
                        title="{{ __('Course Settings - Choose your course') }}"><b style="color:aliceblue">{{ __('Course Settings - Choose your course') }}</b>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('course-settings') }}" x-init x-target="filterCourseWrap" x-show="open">
                            <div class="form-group">
                                <label for="course_classification">{{ __('Course Classification') }}:</label>
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
                                <label for="course_classification_details">{{ __('Course Classification Details') }}:</label>
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
                                <label for="course_name">{{ __('Course Name') }}:</label>
                                &emsp;<input type="text" name="course_name" id="course_name" class="form-control"
                                    title="Course Name" style="display: inline-block; width: 60%;"
                                    value="{{ isset($course) ? $course->coursename : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_01" style="display: inline-block; width: 30%;">{{ __('Course Attribute') }} 01
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
                                        {{ __('Exact Match') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="range_search"
                                            title="Range Search">
                                        {{ __('Range Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_more_search"
                                            title="{{ __('Or More Search') }}">{{ __('Or More Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_less_search"
                                            title="{{ __('Or Less Search') }}">{{ __('Or Less Search') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_02" style="display: inline-block; width: 30%;">{{ __('Course Attribute') }} 02
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
                                        {{ __('Partial Match') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="range_search"
                                            title="Range Search">
                                        {{ __('Range Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_more_search"
                                            title="{{ __('Or More Search') }}">{{ __('Or More Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="or_less_search"
                                            title="{{ __('Or Less Search') }}">{{ __('Or Less Search') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_03" style="display: inline-block; width: 30%;">{{ __('Course Attribute') }} 03
                                    :</label>
                                <select name="course_attributes_03" id="course_attributes_03"
                                    title="(Course attribute03)" style="display: inline-block; width: 60%;"
                                    class="form-control">
                                    <option value="-"> </option>
                                    <option value="Perfect matching" title="{{ __('Perfect Match') }}">{{ __('Perfect Match') }}</option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_04" style="display: inline-block; width: 30%;">{{ __('Course Attribute') }} 04
                                    :</label>
                                <input type="text" name="course_attributes_04" id="course_attributes_04"
                                    title="(Course attribute04)" class="form-control"
                                    style="display: inline-block; width: 60%;">
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_05" style="display: inline-block; width: 30%;">{{ __('Course Attribute') }} 05
                                    :</label>
                                <input type="text" name="course_attributes_05" id="course_attributes_05"
                                    title="(Course attribute05)" class="form-control"
                                    style="display: inline-block; width: 60%;">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info" title="{{ __('Search') }}"
                                    style="color: white">{{ __('Search') }}</button>
                            </div>
                        </form>
                        <div class="text-right">
                            <button type="button" class="btn btn-outline-light btn-sm" x-on:click="open = ! open"
                                :aria-expanded="open.toString()" aria-label="{{ __('Toggle search conditions') }}"
                                x-text="open ? '−' : '+'"></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-header" style="background-color: #92CDFC" title="Course List" align="center"><b
                                style="color:aliceblue">{{ __('Course List') }}</b></div>
                        <!-- DataTable -->
                        <table id="courseTable"
                            class="display table table-bordered table-striped table-hover responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</th>
                                    <th title="{{ __('Course Classification Details') }}">{{ __('Course Classification Details') }}</th>
                                    <th title="{{ __('Course Name') }}">{{ __('Course Name') }}</th>
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
                    <div class="card-header" style="background-color: darkblue" title="{{ __('Employee Selection') }}"><b
                            style="color:aliceblue">{{ __('Employee Selection') }}</b></div>
                    <div class="card-body">
                        <form action="{{ route('course-settings') }}" x-init x-target="filterEmployeeWrap"
                            x-show="open"><br>
                            <div class="form-group">
                                <label for="affiliation_code">{{ __('Affiliation') }}:</label>
                                <select class="form-control" title="Affiliation" id="affiliation_code"
                                    name="affiliation_code" style="display: inline-block; width: 60%;"
                                    @input.debounce="$el.form.requestSubmit()">
                                    <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                    @foreach ($affiliations as $affiliation)
                                        <option value="{{ $affiliation->affiliation_code }}"
                                            @if (request()->affiliation_code == $affiliation->affiliation_code) selected @endif>
                                            {{ $affiliation->affiliation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="job">{{ __('Job Title') }}:</label>
                                <select class="form-control" title="Job Title" id="job" name="job"
                                    style="display: inline-block; width: 60%;" @input.debounce="$el.form.requestSubmit()">
                                    <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                                    @foreach ($jobTitles as $job)
                                        <option value="{{ $job->job_id }}"
                                            @if (request()->job == $job->job_id) selected @endif>
                                            {{ $job->job_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fullname">{{ __('Full Name') }}:</label>
                                <input type="text" class="form-control" title="Full Name" id="fullname"
                                    name="fullname" value="{{ request()->fullname }}" placeholder="{{ __('Enter Full Name') }}"
                                    style="display: inline-block; width: 60%;" @input.debounce="$el.form.requestSubmit()">
                            </div>
                            <div class="form-group">
                                <label for="employee_code">{{ __('Employee Code') }}:</label>
                                <input type="text" class="form-control" title="Employee Code" id="employee_code"
                                    name="employee_code" value="{{ request()->employee_code }}"
                                    placeholder="{{ __('Enter Employee Code') }}" style="display: inline-block; width: 60%;"
                                    @input.debounce="$el.form.requestSubmit()">
                            </div>
                            <div class="mb-3">
                                <div style="display: flex; align-items: center;">
                                    <label for="sex" style="margin-right: 10px;" title="Sex"
                                        style="width: 100%">{{ __('Sex') }}: <b style="color: red">*</b></label>
                                    <div style="display: flex;" style="display: inline-block; width: 60%;">
                                        <label for="male" style="margin-right: 10px;">
                                            <input type="radio" name="sex" id="male" value="male"
                                                title="Male" @if (request()->sex == 'male') checked @endif
                                                @input.debounce="$el.form.requestSubmit()">
                                            {{ __('Male') }}</label>
                                        <label for="female" style="margin-right: 10px;">
                                            <input type="radio" name="sex" id="female" value="female"
                                                title="Female" @if (request()->sex == 'female') checked @endif
                                                @input.debounce="$el.form.requestSubmit()">
                                            {{ __('Female') }}</label>
                                        <label for="other">
                                            <input type="radio" name="sex" id="other" title="Other"
                                                value="other" @if (request()->sex == 'other') checked @endif
                                                @input.debounce="$el.form.requestSubmit()">
                                            {{ __('Other') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="date_of_birth" style="margin-right: 10px; flex-grow: 1;">{{ __('Date of Birth') }}: <b
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
                                            title="{{ __('Exact Match') }}" @input.debounce="$el.form.requestSubmit()">{{ __('Exact Match') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="range_search"
                                            title="{{ __('Range Search') }}" @input.debounce="$el.form.requestSubmit()">
                                        {{ __('Range Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="or_more_search"
                                            title="{{ __('Or More Search') }}" @input.debounce="$el.form.requestSubmit()">{{ __('Or More Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_birth_option" value="or_less_search"
                                            title="{{ __('Or Less Search') }}" @input.debounce="$el.form.requestSubmit()">{{ __('Or Less Search') }}
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="date_of_joining" style="margin-right: 10px; flex-grow: 1;">{{ __('Date of Joining') }}:</label>
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
                                        {{ __('Exact Match') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="range_search"
                                            title="{{ __('Range Search') }}" @input.debounce="$el.form.requestSubmit()">{{ __('Range Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="or_more_search"
                                            title="{{ __('Or More Search') }}" @input.debounce="$el.form.requestSubmit()">{{ __('Or More Search') }}
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="date_of_joining_option" value="or_less_search"
                                            title="{{ __('Or Less Search') }}" @input.debounce="$el.form.requestSubmit()">{{ __('Or Less Search') }}
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
                            <button type="button" class="btn btn-outline-secondary btn-sm" x-on:click="open = ! open"
                                :aria-expanded="open.toString()" aria-label="{{ __('Toggle search conditions') }}"
                                x-text="open ? '−' : '+'"></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-header" title="Employee List" style="background-color: #92CDFC" align="center">
                            <b style="color:aliceblue">{{ __('Employee List') }}</b>
                        </div>
                        <!-- DataTable -->
                        <table id="employeeTable"
                            class="display table table-bordered table-striped table-hover responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th title="{{ __('Affiliation') }}">{{ __('Affiliation') }}</th>
                                    <th title="{{ __('Job Title (Pos)') }}">{{ __('Job Title (Pos)') }}</th>
                                    <th title="{{ __('Full Name') }}">{{ __('Full Name') }}</th>
                                    <th title="{{ __('Employee Code') }}">{{ __('Employee Code') }}</th>
                                    <th title="{{ __('Sex') }}">{{ __('Sex') }}</th>
                                    <th title="{{ __('Age') }}">{{ __('Age') }}</th>
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
                            <label for="staticEmail2">{{ __('Deadline for enrollment') }}</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control date-picker" name="deadline" required>
                        </div>
                        <button type="submit" class="btn btn-info mb-2">{{ __('Set up attendance') }}</button>
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
