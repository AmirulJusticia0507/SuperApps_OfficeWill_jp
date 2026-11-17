@extends('layouts.app')

@section('content')
<style>
    .attendence-page { min-height: 100vh; background: #f4f6f9; }
    .attendence-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .attendence-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .attendence-page__content, body.sidebar-collapsed .attendence-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="attendence-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="attendence-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a title="{{ __('Confirm and attend courses') }}" href="{{ route('confirm-courses.index') }}" class="hover:text-blue-600">{{ __('Confirm and attend courses') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a title="{{ __('List of courses taken') }}" href="{{ route('confirm-courses.index') }}" class="hover:text-blue-600">{{ __('List of courses taken') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" title="{{ __('Attendance') }}" aria-current="page">{{ __('Attendance') }}</li>
            </ol>
        </nav>

        <!-- Course Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Course Information">
                {{ __('Course Information') }}
            </div>
            <div class="p-5 overflow-x-auto">
                <table class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%" id="confirmcoursesTable">
                    <thead>
                        <tr>
                            <th title="{{ __('Course Name') }}">{{ __('Course Name') }}</th>
                            <th title="{{ __('Deadline for enrollment') }}">{{ __('Deadline for enrollment') }}</th>
                            <th title="ToDo">ToDo</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Description Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="p-5">
                <h3 class="text-base font-semibold text-slate-800 mb-2" title="{{ __('Course Description') }}:">{{ __('Course Description') }}:</h3>
                <div class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <p>{{ $scheduleResultCourse->course->course_description }}</p>
                </div>
            </div>
        </div>

        <!-- Materials Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-3.5 bg-blue-100 text-blue-900 rounded-t-xl font-semibold flex items-center justify-between">
                <span>{{ __('Materials') }}</span>
            </div>
            <div class="p-5 overflow-x-auto">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($scheduleResultCourse->course->material->sortBy('display_order') as $material)
                            <tr>
                                <td class="py-3 px-2 text-slate-800 font-medium">{{ $material->teaching_material_name }}</td>
                                <td class="py-3 px-2 text-right">
                                    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-medium rounded-lg transition" target="_blank"
                                        href="{{ $material->material_type == '1' ? $material->youtube_video_url : asset($material->book_file_path) }}" title="{{ __('View materials') }}"><i class="fas fa-eye"></i> {{ __('View materials') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Warning Card -->
        <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl text-sm space-y-1">
            <p class="font-medium" title="{{ __('Once you have completed the course using the learning materials, please proceed to ToDo.') }}"><i class="fas fa-info-circle mr-1"></i> {{ __('Once you have completed the course using the learning materials, please proceed to ToDo.') }}</p>
            <p class="text-xs text-amber-700" title="{{ __('You will not be able to complete the course unless you complete the ToDo.') }}">({{ __('You will not be able to complete the course unless you complete the ToDo.') }})</p>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex justify-end">
            <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition save-confirm" data-confirm-title="Go to ToDo" data-confirm-html="The test results from the previous completion will be initialized. <br />(If there is a passing setting, it is necessary to clear the passing score) is this good?"
                href="{{ route('confirm-courses.todo-answer.index', $scheduleResultCourse->course->course_id) }}" title="{{ __('Go to ToDo') }}">
                <i class="fas fa-arrow-right"></i> {{ __('Go to ToDo') }}
            </a>
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
