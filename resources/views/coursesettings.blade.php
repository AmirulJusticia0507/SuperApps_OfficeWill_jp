@extends('layouts.app')

@section('content')
<style>
    .coursesettings-page { min-height: 100vh; background: #f4f6f9; }
    .coursesettings-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .coursesettings-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .coursesettings-page__content, body.sidebar-collapsed .coursesettings-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="coursesettings-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="coursesettings-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Course Settings') }}" class="hover:text-blue-600">{{ __('Course Settings') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-list') }}" title="{{ __('Course List') }}" class="hover:text-blue-600">{{ __('Course List') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Course Settings') }}">{{ __('Course Settings') }}</li>
            </ol>
        </nav>

        <!-- Course Filter and Table Card -->
        <div id="filterCourseWrap">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ courseFiltersOpen: false }">
                <div class="px-5 py-4 bg-blue-900 text-white font-semibold flex justify-between items-center"
                    title="{{ __('Course Settings - Choose your course') }}">
                    <span>{{ __('Course Settings - Choose your course') }}</span>
                    <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded border border-white/40 hover:bg-white/10 text-white font-bold text-sm transition" x-on:click="courseFiltersOpen = ! courseFiltersOpen"
                        :aria-expanded="courseFiltersOpen.toString()" aria-label="{{ __('Toggle course search conditions') }}"
                        x-text="courseFiltersOpen ? '−' : '+'"></button>
                </div>

                <div class="p-5 border-b border-slate-100" x-show="courseFiltersOpen" x-transition>
                    <form action="{{ route('course-settings') }}" x-init x-target="filterCourseWrap" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_classification_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification') }}:</label>
                            <div class="md:col-span-9">
                                <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" title="Course Classification">
                                    <option value=""></option>
                                    @foreach ($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_classification_details_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification Details') }}:</label>
                            <div class="md:col-span-9">
                                <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id" name="course_classification_details_id" title="Course Classification Details">
                                    @foreach ($details as $detail)
                                        <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_name" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Name') }}:</label>
                            <div class="md:col-span-9">
                                <input type="text" name="course_name" id="course_name" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    title="Course Name" value="{{ isset($course) ? $course->coursename : '' }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_attributes_01" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Attribute') }} 01:</label>
                            <div class="md:col-span-9">
                                <select name="course_attributes_01" id="course_attributes_01" title="(Course attribute 01)" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <div class="md:col-span-3"></div>
                            <div class="md:col-span-9 flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="exact_match" class="text-blue-600"> {{ __('Exact Match') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="range_search" class="text-blue-600"> {{ __('Range Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="or_more_search" class="text-blue-600"> {{ __('Or More Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="or_less_search" class="text-blue-600"> {{ __('Or Less Search') }}</label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_attributes_02" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Attribute') }} 02:</label>
                            <div class="md:col-span-9">
                                <input type="text" name="course_attributes_02" id="course_attributes_02" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="(Course attribute02)">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <div class="md:col-span-3"></div>
                            <div class="md:col-span-9 flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="partial_match" class="text-blue-600"> {{ __('Partial Match') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="range_search" class="text-blue-600"> {{ __('Range Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="or_more_search" class="text-blue-600"> {{ __('Or More Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="search_option" value="or_less_search" class="text-blue-600"> {{ __('Or Less Search') }}</label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_attributes_03" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Attribute') }} 03:</label>
                            <div class="md:col-span-9">
                                <select name="course_attributes_03" id="course_attributes_03" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="-"> </option>
                                    <option value="Perfect matching">{{ __('Perfect Match') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_attributes_04" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Attribute') }} 04:</label>
                            <div class="md:col-span-9">
                                <input type="text" name="course_attributes_04" id="course_attributes_04" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="course_attributes_05" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Attribute') }} 05:</label>
                            <div class="md:col-span-9">
                                <input type="text" name="course_attributes_05" id="course_attributes_05" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="pt-2 flex justify-center">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="{{ __('Search') }}">
                                <i class="fas fa-search"></i> {{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="p-5">
                    <div class="px-4 py-2.5 bg-blue-100 text-blue-900 rounded-lg font-semibold text-center text-sm mb-4" title="Course List">
                        {{ __('Course List') }}
                    </div>
                    <div class="flex justify-end mb-4" data-course-details-action>
                        <a href="#" data-course-details-url="{{ route('course-information.show', ['id' => '__COURSE_ID__']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg shadow-sm transition d-none" data-course-details-button aria-hidden="true" tabindex="-1">
                            <i class="fas fa-eye"></i> {{ __('Check course details') }}
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="courseTable" class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
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
                                        <td><input type="checkbox" class="course-checkbox w-4 h-4 text-blue-600 rounded" value="{{ $course->course_id }}"></td>
                                        <td>{{ $course->classification?->course_classification_name ?? __('Not available') }}</td>
                                        <td>{{ $course->classification_detail?->course_classification_detailsname ?? __('Not available') }}</td>
                                        <td>{{ $course->coursename }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Filter and Table Card -->
        <div id="filterEmployeeWrap">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ employeeFiltersOpen: false }">
                <div class="px-5 py-4 bg-blue-900 text-white font-semibold flex justify-between items-center" title="{{ __('Employee Selection') }}">
                    <span>{{ __('Employee Selection') }}</span>
                    <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded border border-white/40 hover:bg-white/10 text-white font-bold text-sm transition" x-on:click="employeeFiltersOpen = ! employeeFiltersOpen"
                        :aria-expanded="employeeFiltersOpen.toString()" aria-label="{{ __('Toggle employee search conditions') }}"
                        x-text="employeeFiltersOpen ? '−' : '+'"></button>
                </div>

                <div class="p-5 border-b border-slate-100" x-show="employeeFiltersOpen" x-transition>
                    <form action="{{ route('course-settings') }}" x-init x-target="filterEmployeeWrap" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="affiliation_code" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Affiliation') }}:</label>
                            <div class="md:col-span-9">
                                <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Affiliation" id="affiliation_code" name="affiliation_code" @input.debounce="$el.form.requestSubmit()">
                                    <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                    @foreach ($affiliations as $affiliation)
                                        <option value="{{ $affiliation->affiliation_code }}" @if (request()->affiliation_code == $affiliation->affiliation_code) selected @endif>
                                            {{ $affiliation->affiliation_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="job" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Job Title') }}:</label>
                            <div class="md:col-span-9">
                                <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Job Title" id="job" name="job" @input.debounce="$el.form.requestSubmit()">
                                    <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                                    @foreach ($jobTitles as $job)
                                        <option value="{{ $job->job_id }}" @if (request()->job == $job->job_id) selected @endif>
                                            {{ $job->job_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="fullname" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Full Name') }}:</label>
                            <div class="md:col-span-9">
                                <input type="text" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Full Name" id="fullname" name="fullname" value="{{ request()->fullname }}" placeholder="{{ __('Enter Full Name') }}" @input.debounce="$el.form.requestSubmit()">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="employee_code" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Employee Code') }}:</label>
                            <div class="md:col-span-9">
                                <input type="text" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Employee Code" id="employee_code" name="employee_code" value="{{ request()->employee_code }}" placeholder="{{ __('Enter Employee Code') }}" @input.debounce="$el.form.requestSubmit()">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Sex') }}: <span class="text-red-500">*</span></label>
                            <div class="md:col-span-9 flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="sex" id="male" value="male" class="text-blue-600" @if (request()->sex == 'male') checked @endif @input.debounce="$el.form.requestSubmit()">
                                    {{ __('Male') }}
                                </label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="sex" id="female" value="female" class="text-blue-600" @if (request()->sex == 'female') checked @endif @input.debounce="$el.form.requestSubmit()">
                                    {{ __('Female') }}
                                </label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="sex" id="other" value="other" class="text-blue-600" @if (request()->sex == 'other') checked @endif @input.debounce="$el.form.requestSubmit()">
                                    {{ __('Other') }}
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="date_of_birth" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Date of Birth') }}: <span class="text-red-500">*</span></label>
                            <div class="md:col-span-9">
                                <input type="date" name="date_of_birth" id="date_of_birth" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Date of Birth" min="1970-01-01" max="{{ date('Y-m-d') }}" value="{{ request()->date_of_birth }}" @input.debounce="$el.form.requestSubmit()">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <div class="md:col-span-3"></div>
                            <div class="md:col-span-9 flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_birth_option" value="exact_match" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Exact Match') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_birth_option" value="range_search" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Range Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_birth_option" value="or_more_search" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Or More Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_birth_option" value="or_less_search" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Or Less Search') }}</label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <label for="date_of_joining" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Date of Joining') }}:</label>
                            <div class="md:col-span-9">
                                <input type="date" name="date_of_joining" id="date_of_joining" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Date of Joining" min="2022-01-01" max="{{ date('Y-m-d') }}" value="{{ request()->date_of_joining }}" @input.debounce="$el.form.requestSubmit()">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <div class="md:col-span-3"></div>
                            <div class="md:col-span-9 flex flex-wrap gap-4 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_joining_option" value="exact_match" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Exact Match') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_joining_option" value="range_search" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Range Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_joining_option" value="or_more_search" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Or More Search') }}</label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="date_of_joining_option" value="or_less_search" class="text-blue-600" @input.debounce="$el.form.requestSubmit()"> {{ __('Or Less Search') }}</label>
                            </div>
                        </div>

                        <x-attributeEmployeeComponent />

                        <div class="pt-2 flex justify-center">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="search">
                                <i class="fas fa-search"></i> 検索
                            </button>
                        </div>
                    </form>
                </div>

                <div class="p-5">
                    <div class="px-4 py-2.5 bg-blue-100 text-blue-900 rounded-lg font-semibold text-center text-sm mb-4" title="Employee List">
                        {{ __('Employee List') }}
                    </div>
                    <div class="overflow-x-auto">
                        <table id="employeeTable" class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
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
                                        <td><input type="checkbox" class="employee-checkbox w-4 h-4 text-blue-600 rounded" value="{{ $employee->employee_id }}"></td>
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
        </div>

        <!-- Setup Attendance Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
            <form action="{{ route('course-settings.store') }}" method="POST" id="formSetupAttendence" class="flex flex-wrap items-center gap-4">
                @csrf
                <label for="staticEmail2" class="text-sm font-semibold text-slate-700">{{ __('Deadline for enrollment') }}</label>
                <input type="text" class="px-3 py-2 border border-slate-300 rounded-lg text-sm date-picker focus:outline-none focus:ring-2 focus:ring-blue-500" name="deadline" required placeholder="YYYY-MM-DD">
                <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    <i class="fas fa-calendar-check"></i> {{ __('Set up attendance') }}
                </button>
            </form>
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
            var table = $('#courseTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip',
                buttons: ['copy', 'excel', 'pdf']
            });

            let selectedCourseId = null;
            const syncCourseDetailsButton = function() {
                const detailsButton = $('[data-course-details-button]');

                if (selectedCourseId) {
                    const detailsUrl = detailsButton.data('course-details-url').replace('__COURSE_ID__', encodeURIComponent(selectedCourseId));
                    detailsButton.attr('href', detailsUrl).removeClass('d-none').attr('aria-hidden', 'false').removeAttr('tabindex');
                } else {
                    detailsButton.addClass('d-none').attr({ href: '#', 'aria-hidden': 'true', tabindex: '-1' });
                }
            };

            $(document).on('change', '#courseTable .course-checkbox', function() {
                selectedCourseId = this.checked ? this.value : null;
                $('#courseTable .course-checkbox').each(function() {
                    this.checked = selectedCourseId !== null && this.value === selectedCourseId;
                });
                syncCourseDetailsButton();
            });

            $('#courseTable').on('draw.dt', function() {
                $('#courseTable .course-checkbox').each(function() {
                    this.checked = selectedCourseId !== null && this.value === selectedCourseId;
                });
            });
        });
    </script>
@endsection
