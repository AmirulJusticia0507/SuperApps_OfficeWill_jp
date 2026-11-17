@extends('layouts.app')

@section('content')
<style>
    .courselist-page { min-height: 100vh; background: #f4f6f9; }
    .courselist-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .courselist-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .courselist-page__content, body.sidebar-collapsed .courselist-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="courselist-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="courselist-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('course-settings') }}" title="{{ __('Course Settings') }}" class="hover:text-blue-600">{{ __('Course Settings') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-list') }}" title="{{ __('Course List') }}" class="hover:text-blue-600">{{ __('Course List') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Course List') }}">{{ __('Course List') }}</li>
            </ol>
        </nav>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold flex items-center justify-between" title="Course Registration">
                <span>{{ __('Course Registration') }}</span>
                <a class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-slate-700 hover:bg-slate-100 text-xs font-semibold rounded-lg shadow-sm transition"
                    href="{{ route('course-registration.index') }}"><i class="fas fa-plus"></i> {{ __('Register a course') }}</a>
            </div>
            <div class="p-5">
                <form action="{{ route('course.filter') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_classification_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id"
                                title="{{ __('Course Classification') }}" required>
                                <option value="">{{ __('Select Course Classification') }}</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}">
                                        {{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_classification_details_id" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Classification Details') }}:</label>
                        <div class="md:col-span-9">
                            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id"
                                name="course_classification_details_id" title="Course Classification Details" required>
                                <option value="">{{ __('Select Course Classification Details') }}</option>
                                @foreach ($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <label for="course_name" class="md:col-span-3 text-sm font-medium text-slate-700">{{ __('Course Name') }}:</label>
                        <div class="md:col-span-9">
                            <input type="text" name="course_name" id="course_name" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                title="Course Name" value="{{ isset($course) ? $course->coursename : '' }}" placeholder="{{ __('Enter Course Name') }}">
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

        <!-- Course Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="p-5 overflow-x-auto">
                <table id="courseTable" class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
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
                                    <td><a href="{{ route('course-information.show', $course->course_id) }}" class="text-blue-600 hover:underline font-medium">{{ $course->coursename }}</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="3" class="text-center text-slate-400 py-4">{{ __('No courses found.') }}</td></tr>
                        @endif
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
