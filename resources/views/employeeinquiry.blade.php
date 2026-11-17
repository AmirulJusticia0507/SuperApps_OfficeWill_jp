@extends('layouts.app')

@section('content')
<style>
    .employee-inquiry-page { min-height: 100vh; background: #f4f6f9; }
    .employee-inquiry-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .employee-inquiry-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .employee-inquiry-page__content, body.sidebar-collapsed .employee-inquiry-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="employee-inquiry-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="employee-inquiry-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('employee-inquiry') }}" title="{{ __('Employee Inquiry') }}" class="hover:text-blue-600">{{ __('Employee Inquiry') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('employee-list') }}" title="{{ __('Employee List') }}" class="hover:text-blue-600">{{ __('Employee List') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Employee Attendance Inquiry') }}">{{ __('Employee Attendance Inquiry') }}</li>
            </ol>
        </nav>

        <!-- Search Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Employee') }}">
                {{ __('Employee') }}
            </div>
            <form action="{{ route('employee-inquiry.filter') }}" method="get">
                @csrf
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="affiliation_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Affiliation') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Affiliation" id="affiliation_id" name="affiliationId" required>
                                <option title="{{ __('Select Affiliation') }}" value="">{{ __('Select Affiliation') }}</option>
                                @foreach($affiliations as $affiliation)
                                    <option value="{{ $affiliation->affiliation_code }}">{{ $affiliation->affiliation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="job_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Job Title') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Job Title" id="job_id" name="jobId" required>
                                <option title="{{ __('Select Job Title') }}" value="">{{ __('Select Job Title') }}</option>
                                @foreach($jobTitles as $job)
                                    <option value="{{ $job->job_id }}">{{ $job->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="fullname" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Full Name') }}:</label>
                        <div class="md:col-span-9">
                            <input type="text" title="Full Name" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="fullname" name="fullname" placeholder="{{ __('Enter Full Name') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="employee_code" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Employee Code') }}:</label>
                        <div class="md:col-span-9">
                            <input type="text" title="Employee Code" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="employee_code" name="employee_code" placeholder="{{ __('Enter Employee Code') }}">
                        </div>
                    </div>
                </div>

                <div class="px-5 py-3.5 bg-blue-100 text-blue-900 font-semibold border-t border-slate-200" title="{{ __('Courses Taken') }}">
                    {{ __('Courses Taken') }}
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_classification_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" title="Course Classification" required>
                                <option title="{{ __('Select Course Classification') }}" value="">{{ __('Select Course Classification') }}</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_classification_details_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification Details') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id" title="Course Classification Details" name="course_classification_details_id" required>
                                <option title="{{ __('Select Course Classification Details') }}" value="">{{ __('Select Course Classification Details') }}</option>
                                @foreach($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}" data-classification-id="{{ $detail->Course_classification_id }}">{{ $detail->course_classification_detailsname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Name') }}:</label>
                        <div class="md:col-span-9">
                            <select name="course_id" id="course_id" title="Course Name" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option title="{{ __('Select Course') }}" value="">{{ __('Select Course') }}</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}" data-classification-id="{{ $course->Course_classification_id }}" data-detail-id="{{ $course->course_classification_details_id }}">{{ $course->coursename }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-center">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="{{ __('Search') }}">
                            <i class="fas fa-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filtered Employees Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Employee List') }}">
                {{ __('Employee List') }}
            </div>
            <div class="p-5 overflow-x-auto">
                <table id="employeeinquiryTable" class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th title="{{ __('Affiliation') }}">{{ __('Affiliation') }}</th>
                            <th title="{{ __('Job Title (Pos)') }}">{{ __('Job Title (Pos)') }}</th>
                            <th title="{{ __('Full Name') }}">{{ __('Full Name') }}</th>
                            <th title="{{ __('Employee Code') }}">{{ __('Employee Code') }}</th>
                            <th title="{{ __('Sex') }}">{{ __('Sex') }}</th>
                            <th title="{{ __('Age') }}">{{ __('Age') }}</th>
                            <th title="{{ __('Actions') }}">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filteredEmployees as $employee)
                            <tr>
                                <td><input type="checkbox" class="employee-checkbox w-4 h-4 text-blue-600 rounded" value="{{ $employee->employee_id }}"></td>
                                <td>{{ $employee->employee_affiliation->affiliation->affiliation_name }}</td>
                                <td>{{ $employee->employee_affiliation->job->job_title }}</td>
                                <td>{{ $employee->fullname }}</td>
                                <td>{{ $employee->employee_code }}</td>
                                <td>{{ $employee->sex }}</td>
                                <td>{{ \Carbon\Carbon::parse($employee->dateofbirth)->age }}</td>
                                <td><a href="{{ route('employee-inquiry.attendance', $employee->employee_id) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-700 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-800"><i class="fas fa-clock-rotate-left"></i>{{ __('Attendance History') }}</a></td>
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

            const classificationSelect = document.getElementById('course_classification_id');
            const detailSelect = document.getElementById('course_classification_details_id');
            const courseSelect = document.getElementById('course_id');
            const details = Array.from(detailSelect.options).slice(1);
            const courses = Array.from(courseSelect.options).slice(1);

            function updateCourseOptions() {
                const classificationId = classificationSelect.value;
                const detailId = detailSelect.value;
                detailSelect.replaceChildren(new Option(@json(__('Select Course Classification Details')), ''));
                details.forEach(function(option) {
                    if (!classificationId || option.dataset.classificationId === classificationId) {
                        detailSelect.add(option.cloneNode(true));
                    }
                });
                courseSelect.replaceChildren(new Option(@json(__('Select Course')), ''));
                courses.forEach(function(option) {
                    const matchesClassification = !classificationId || option.dataset.classificationId === classificationId;
                    const matchesDetail = !detailSelect.value || option.dataset.detailId === detailSelect.value;
                    if (matchesClassification && matchesDetail) courseSelect.add(option.cloneNode(true));
                });
            }

            classificationSelect.addEventListener('change', function() {
                detailSelect.value = '';
                updateCourseOptions();
            });
            detailSelect.addEventListener('change', updateCourseOptions);
            updateCourseOptions();
        });
    </script>
@endsection
