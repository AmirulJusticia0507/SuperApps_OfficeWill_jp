@extends('layouts.app')

@section('content')
<style>
    .confirmcourses-page { min-height: 100vh; background: #f4f6f9; }
    .confirmcourses-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .confirmcourses-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .confirmcourses-page__content, body.sidebar-collapsed .confirmcourses-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="confirmcourses-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="confirmcourses-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a title="{{ __('Confirm and attend courses') }}" href="{{ route('confirm-courses.index') }}" class="hover:text-blue-600">{{ __('Confirm and attend courses') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" title="{{ __('List of courses taken') }}" aria-current="page">{{ __('List of courses taken') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('List of courses taken') }}">
                {{ __('List of courses taken') }}
            </div>
            <div class="p-5 overflow-x-auto">
                <table class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%" id="confirmcoursesTable">
                    <thead>
                        <tr>
                            <th title="{{ __('Course Name') }}">{{ __('Course Name') }}</th>
                            <th title="{{ __('Deadline for enrollment') }}">{{ __('Deadline for enrollment') }}</th>
                            <th title="ToDo">ToDo</th>
                            <th title="{{ __('Certificate') }}">{{ __('Certificate') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scheduleResultCourses as $scheduleResultCourse)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0">
                                            @if($scheduleResultCourse->course->classification_detail->icon_file_path)
                                                <img src="{{ asset('storage/' . $scheduleResultCourse->course->classification_detail->icon_file_path) }}" alt="Icon" class="w-16 h-16 object-contain rounded border border-slate-200">
                                            @else
                                                <span class="text-slate-400 text-xs italic">{{ __('No Image') }}</span>
                                            @endif
                                        </div>
                                        <div class="space-y-0.5">
                                            <div class="text-xs text-slate-500">{{ $scheduleResultCourse->course->classification->course_classification_name }}</div>
                                            <div class="text-xs text-slate-600 font-medium">{{ $scheduleResultCourse->course->classification_detail->course_classification_detailsname }}</div>
                                            <div><a href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}" class="text-blue-600 hover:underline font-semibold">{{ $scheduleResultCourse->course->coursename }}</a></div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $scheduleResultCourse->deadline_enrollment }}</td>
                                <td>{{ $scheduleResultCourse->todo_progress_text }}</td>
                                <td>
                                    @if ((string) $scheduleResultCourse->todo_progress === '2' && $scheduleResultCourse->todo_complete)
                                        <a href="{{ route('confirm-courses.certificate', $scheduleResultCourse->attendance_setting_id) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-700 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-blue-800">
                                            <i class="fas fa-award" aria-hidden="true"></i>{{ __('Get certificate') }}
                                        </a>
                                    @else
                                        <span class="text-sm text-slate-400">{{ __('Available after course completion') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

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
            var table = $('#confirmcoursesTable').DataTable({
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
