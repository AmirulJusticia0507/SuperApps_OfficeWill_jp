@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
    <!-- Header -->
    @include('includes.header')

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-8">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('course-settings') }}" title="{{ __('Course Settings') }}">{{ __('Course Settings') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('course-list') }}" title="{{ __('Course List') }}">{{ __('Course List') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="{{ __('Course List') }}">{{ __('Course List') }}</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="Course Registration">
                    <div class="row">
                        <div class="col">
                            <div class="text-center"><b style="color:aliceblue">{{ __('Course Registration') }}</b></div>
                        </div>
                        <div class="col-auto"> <a class="btn btn-light btn-sm"
                                href="{{ route('course-registration.index') }}">{{ __('Register a course') }}</a></div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Form Filter -->
                    <form action="{{ route('course.filter') }}" method="GET">
                        <!-- Course Classification Filter -->
                        <div class="form-group">
                            <label for="course_classification_id">{{ __('Course Classification') }}:</label>
                            <select class="form-control" id="course_classification_id" name="course_classification_id"
                                title="{{ __('Course Classification') }}" required style="display: inline-block; width: 60%;">
                                <option value="">{{ __('Select Course Classification') }}</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->id }}">
                                        {{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course Classification Details Filter -->
                        <div class="form-group">
                            <label for="course_classification_details_id">{{ __('Course Classification Details') }}:</label>
                            <select class="form-control" id="course_classification_details_id"
                                name="course_classification_details_id" title="Course Classification Details" required
                                style="display: inline-block; width: 60%;">
                                <option value="">{{ __('Select Course Classification Details') }}</option>
                                @foreach ($details as $detail)
                                    <option value="{{ $detail->id }}">{{ $detail->course_classification_detailsname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course Name Filter -->
                        <!-- <div class="form-group">
                                                        <label for="course_name">Course Name:</label>
                                                        <input type="text" name="course_name" id="course_name" class="form-control" value="{{ isset($course) ? $course->coursename : '' }}" style="display: inline-block; width: 60%;">
                                                    </div> -->
                        <div class="form-group">
                            <label for="course_name">{{ __('Course Name') }}:</label>
                            &emsp;<input type="text" name="course_name" id="course_name" class="form-control"
                                style="display: inline-block; width: 60%;" title="Course Name"
                                value="{{ isset($course) ? $course->coursename : '' }}">
                        </div>
                        <!-- Search Button -->
                        <div align="center">
                            <button type="submit" class="btn btn-primary btn-block" title="Search"
                                style="background-color: darkblue">{{ __('Search') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <!-- DataTable -->
                    <table id="courseTable" class="display table table-bordered table-striped table-hover responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</th>
                                <th title="{{ __('Course Classification Details') }}">{{ __('Course Classification Details') }}</th>
                                <th title="{{ __('Course Name') }}">{{ __('Course Name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($courses))
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->classification?->course_classification_name ?? __('Not available') }}</td>
                                        <td>{{ $course->classification_detail?->course_classification_detailsname ?? __('Not available') }}</td>
                                        <td><a href="#">{{ $course->coursename }}</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="3">{{ __('No courses found.') }}</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
