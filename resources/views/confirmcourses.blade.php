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
                <li><a title="{{ __('Confirm and attend courses') }}" href="#" class="hover:text-blue-600">{{ __('Confirm and attend courses') }}</a></li>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <a href="#" class="text-blue-600 hover:underline font-medium" data-toggle="modal" data-target="#exampleModal">{{ $course->Course_Name }}</a>
                                </td>
                                <td>{{ $course->Deadline_for_Enrollment }}</td>
                                <td>{{ $course->ToDo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-semibold text-slate-800" id="exampleModalLabel" title="{{ __('Course Details') }}">{{ __('Course Details') }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-sm space-y-2">
                        <p title="{{ __('Course Name') }}"><span class="font-medium text-slate-600">{{ __('Course Name') }}:</span> <span id="courseName" class="text-slate-800"></span></p>
                        <p title="{{ __('Deadline for enrollment') }}"><span class="font-medium text-slate-600">{{ __('Deadline for enrollment') }}:</span> <span id="deadline" class="text-slate-800"></span></p>
                        <p title="ToDo"><span class="font-medium text-slate-600">ToDo:</span> <span id="todo" class="text-slate-800"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition" data-dismiss="modal" title="{{ __('Close') }}">{{ __('Close') }}</button>
                    </div>
                </div>
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
        $(document).ready(function () {
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
    <script>
        $(document).ready(function () {
            $('#confirmcoursesTable').on('click', 'a[data-toggle="modal"]', function () {
                var courseName = $(this).text();
                var row = $(this).closest('tr');
                var deadline = row.find('td:eq(1)').text();
                var todo = row.find('td:eq(2)').text();

                $('#courseName').text(courseName);
                $('#deadline').text(deadline);
                $('#todo').text(todo);
            });
        });
    </script>
@endsection
