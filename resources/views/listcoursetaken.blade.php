@extends('layouts.app')

@section('content')
<style>
    .list-course-taken-page { min-height: 100vh; background: #f4f6f9; }
    .list-course-taken-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .list-course-taken-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .list-course-taken-page__content, body.sidebar-collapsed .list-course-taken-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="list-course-taken-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="list-course-taken-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('confirm-courses.index') }}" title="Confirm and take courses" class="hover:text-blue-600">コースを確認して撮影します</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('employee-list') }}" title="List of courses taken" class="hover:text-blue-600">撮影したコースのリスト</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="Attendance">出席</li>
            </ol>
        </nav>

        <!-- Course Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Course information">
                コース情報
            </div>
            <div class="p-5 overflow-x-auto space-y-4">
                <div class="px-4 py-2.5 bg-blue-100 text-blue-900 rounded-lg font-semibold text-center text-sm" title="Employee List">
                    従業員リスト
                </div>
                <table id="employeelistTable" class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th title="Course Name">コース名</th>
                            <th>{{ __('Employee') }}</th>
                            <th title="Deadline for enrollment">登録の締め切り</th>
                            <th title="ToDo">全て</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseScheduleResults as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result->course->coursename ?? 'N/A' }}</td>
                                <td>{{ $result->employee->fullname ?? 'N/A' }}</td>
                                <td>{{ $result->deadline_enrollment }}</td>
                                <td>
                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $result->todo_complete ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $result->todo_complete ? '完了' : '未完了' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Course Description Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-3.5 bg-blue-100 text-blue-900 rounded-t-xl font-semibold text-center text-sm" title="Course Description">
                コースの説明:
            </div>
            <div class="p-5 space-y-4">
                @foreach($courses as $course)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 leading-relaxed">
                        {{ $course->course_description }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Materials Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-3.5 bg-blue-100 text-blue-900 rounded-t-xl font-semibold text-center text-sm" title="Materials">
                材料:
            </div>
            <div class="p-5">
                <ul class="divide-y divide-slate-100 text-sm">
                    @foreach($materials as $material)
                        <li class="py-2.5 flex items-center gap-2 text-slate-800">
                            <i class="fas fa-file-alt text-slate-400"></i> {{ $material->teaching_material_name }}
                        </li>
                    @endforeach
                </ul>
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
            var table = $('#employeelistTable').DataTable({
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
