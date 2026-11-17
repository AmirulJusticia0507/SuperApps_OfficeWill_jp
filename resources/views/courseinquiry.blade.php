@extends('layouts.app')

@section('content')
<style>
    .course-inquiry-page { min-height: 100vh; width: 100%; max-width: none; margin: 0; padding: 0; background: #f4f6f9; }
    .course-inquiry-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-inquiry-page { width: 100%; margin: 0; }
    body.sidebar-collapsed .course-inquiry-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-inquiry-page, body.sidebar-collapsed .course-inquiry-page { width: 100%; margin: 0; padding: 0; }
        .course-inquiry-page__content, body.sidebar-collapsed .course-inquiry-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="course-inquiry-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-inquiry-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('course-inquiry') }}" title="{{ __('Course-specific Inquiry') }}" class="hover:text-blue-600">{{ __('Course-specific Inquiry') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-list') }}" title="{{ __('Course List') }}" class="hover:text-blue-600">{{ __('Course List') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Course-specific Inquiry') }}">{{ __('Course-specific Inquiry') }}</li>
            </ol>
        </nav>

        <!-- Course Selection Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Course Specific Inquiry">
                {{ __('Course-specific Inquiry') }}
            </div>
            <div class="p-5 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="course_classification_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification') }}:</label>
                    <div class="md:col-span-9">
                        <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" title="Course Classification" required>
                            <option value="" title="{{ __('Select Course Classification') }}">{{ __('Select Course Classification') }}</option>
                            @foreach ($classifications as $classification)
                                <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="course_classification_details_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification Details') }}:</label>
                    <div class="md:col-span-9">
                        <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id" name="course_classification_details_id" title="Course Classification Details" required>
                            <option value="" title="{{ __('Select Course Classification Details') }}">{{ __('Select Course Classification Details') }}</option>
                            @foreach ($details as $detail)
                                <option value="{{ $detail->course_classification_details_id }}" data-classification-id="{{ $detail->Course_classification_id }}">{{ $detail->course_classification_detailsname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label for="course_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Name') }}:</label>
                    <div class="md:col-span-9">
                        <select name="course_id" title="Course Name" id="course_id" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" title="{{ __('Select Course') }}">{{ __('Select Course') }}</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}" data-classification-id="{{ $course->Course_classification_id }}" data-detail-id="{{ $course->course_classification_details_id }}">{{ $course->coursename }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Employee Search Form -->
            <div class="px-5 py-3.5 bg-blue-100 text-blue-900 font-semibold border-t border-slate-200" title="Employees attending the course">
                {{ __('Employees Enrolled in Course') }}
            </div>
            <div class="p-5">
                <form action="{{ route('course-inquiry-search') }}" method="get" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="affiliation_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Affiliation') }}:</label>
                        <div class="md:col-span-9 flex flex-wrap items-center gap-4">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="affiliation_id" title="Affiliation" name="affiliationId" required>
                                <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                @foreach ($affiliations as $affiliation)
                                    <option value="{{ $affiliation->id }}">{{ $affiliation->affiliation_name }}</option>
                                @endforeach
                            </select>
                            <div class="flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="search_option" value="Display selected affiliation" class="text-blue-600"> {{ __('Display selected affiliation') }}
                                </label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="search_option" value="Display selected affiliation and below" class="text-blue-600"> {{ __('Display selected affiliation and below') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="job_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Job Title') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Job Title" id="job_id" name="jobId" required>
                                <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                                @foreach ($jobTitles as $job)
                                    <option value="{{ $job->id }}">{{ $job->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="fullname" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Full Name') }}:</label>
                        <div class="md:col-span-9">
                            <input type="text" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Full Name" id="fullname" name="fullname"
                                placeholder="{{ __('Enter Full Name') }}" onkeyup="updateEmployeeCode()">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="employee_code" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Employee Code') }}:</label>
                        <div class="md:col-span-9">
                            <input type="text" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Employee Code" id="employee_code"
                                name="employee_code" placeholder="{{ __('Enter Employee Code') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_deadline" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Deadline') }}:</label>
                        <div class="md:col-span-9 flex flex-wrap items-center gap-4">
                            <input type="date" title="Course Deadline" name="course_deadline" id="course_deadline" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="search_option" value="Designated date" class="text-blue-600"> {{ __('Specified Date') }}
                                </label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="search_option" value="After the designated date" class="text-blue-600"> {{ __('After Specified Date') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-center">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="Search">
                            <i class="fas fa-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enrolled Employees Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold flex justify-between items-center" title="List of employees attending the course">
                <span>{{ __('Employees Enrolled in Course') }}</span>
                <a href="{{ route('course-inquiry.results') }}" class="inline-flex items-center gap-1 px-3 py-1 bg-white text-slate-800 hover:bg-slate-100 text-xs font-semibold rounded-lg shadow-sm transition" title="{{ __('Course Result Inquiry') }}">{{ __('All Inquiries') }}</a>
            </div>
            <div class="p-5 overflow-x-auto">
                <table id="courseinquiryTable" class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th title="{{ __('Affiliation') }}">{{ __('Affiliation') }}</th>
                            <th title="{{ __('Job Title (Pos)') }}">{{ __('Job Title (Pos)') }}</th>
                            <th title="{{ __('Full Name') }}">{{ __('Full Name') }}</th>
                            <th title="{{ __('Employee Code') }}">{{ __('Employee Code') }}</th>
                            <th title="{{ __('Sex') }}">{{ __('Sex') }}</th>
                            <th title="{{ __('Age') }}">{{ __('Age') }}</th>
                            <th title="{{ __('Information Date') }}">{{ __('Information Date') }}</th>
                            <th title="{{ __('Course Deadline') }}">{{ __('Course Deadline') }}</th>
                            <th title="{{ __('ToDo Progress') }}">{{ __('ToDo Progress') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->employee_affiliation->affiliation->affiliation_name }}</td>
                                <td>{{ $employee->employee_affiliation->job->job_title }}</td>
                                <td>{{ $employee->fullname }}</td>
                                <td>{{ $employee->employee_code }}</td>
                                <td>{{ $employee->sex }}</td>
                                <td>{{ \Carbon\Carbon::parse($employee->dateofbirth)->age }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
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
            var table = $('#courseinquiryTable').DataTable({
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
            const allDetails = Array.from(detailSelect.options).slice(1);
            const allCourses = Array.from(courseSelect.options).slice(1);

            function updateInquiryOptions() {
                const classificationId = classificationSelect.value;
                const detailId = detailSelect.value;

                detailSelect.replaceChildren(new Option(@json(__('Select Course Classification Details')), ''));
                allDetails.forEach(function(option) {
                    if (!classificationId || option.dataset.classificationId === classificationId) {
                        detailSelect.add(option.cloneNode(true));
                    }
                });
                if (detailId && Array.from(detailSelect.options).some(option => option.value === detailId)) {
                    detailSelect.value = detailId;
                }

                courseSelect.replaceChildren(new Option(@json(__('Select Course')), ''));
                allCourses.forEach(function(option) {
                    const classificationMatches = !classificationId || option.dataset.classificationId === classificationId;
                    const detailMatches = !detailSelect.value || option.dataset.detailId === detailSelect.value;
                    if (classificationMatches && detailMatches) courseSelect.add(option.cloneNode(true));
                });
            }

            classificationSelect.addEventListener('change', function() {
                detailSelect.value = '';
                updateInquiryOptions();
            });
            detailSelect.addEventListener('change', updateInquiryOptions);
            updateInquiryOptions();
        });
    </script>
    <script>
        function updateEmployeeCode() {
            var fullname = document.getElementById('fullname').value;
            var employeeCode = generateEmployeeCode(fullname);
            document.getElementById('employee_code').value = employeeCode;
        }

        function generateEmployeeCode(fullname) {
            var initials = fullname.split(' ').map(name => name.charAt(0).toUpperCase()).join('');
            return initials;
        }
    </script>
@endsection
