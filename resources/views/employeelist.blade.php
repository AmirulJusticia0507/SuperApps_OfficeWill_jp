@extends('layouts.app')

@section('content')
<style>
    .employee-list-page { min-height: 100vh; background: #f4f6f9; }
    .employee-list-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .employee-list-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .employee-list-page__content, body.sidebar-collapsed .employee-list-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<div class="employee-list-page">
@include('includes.header')
@include('includes.sidebar')
<main class="employee-list-page__content">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
            <li><a href="{{ route('member-registration.create') }}" title="{{ __('Employee Registration') }}" class="hover:underline">{{ __('Employee Registration') }}</a></li>
            <li class="before:content-['/'] before:mx-1"><a href="{{ route('employee-list') }}" title="{{ __('Employee List') }}" class="hover:underline">{{ __('Employee List') }}</a></li>
            <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Employee List') }}">{{ __('Employee List') }}</li>
        </ol>
    </nav>

    <!-- Search Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
        <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Employee List">
            {{ __('Employee List') }}
        </div>
        <div class="p-5">
            <form action="" method="get">
                <div class="mb-4">
                    <label for="affiliation_code" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation') }}:</label>
                    <div class="flex items-center gap-4 flex-wrap">
                        <select class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" title="Affiliation" id="affiliation_code" name="affiliation_code" style="width: 60%;">
                            <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                            @foreach ($affiliations as $affiliation)
                                <option value="{{ $affiliation->affiliation_code }}">
                                    {{ $affiliation->affiliation_name }}</option>
                            @endforeach
                        </select>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-1.5 text-sm">
                                <input type="radio" name="search_option" value="Display selected affiliation"
                                    title="{{ __('Display selected affiliation') }}"> {{ __('Display selected affiliation') }}
                            </label>
                            <label class="flex items-center gap-1.5 text-sm">
                                <input type="radio" name="search_option"
                                    value="Display selected affiliation and below"
                                    title="{{ __('Display selected affiliation and below') }}"> {{ __('Display selected affiliation and below') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="job" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Job Title') }}: <b class="text-red-500">*</b></label>
                    <select name="job" id="job" title="Job Title" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                        style="display: inline-block; width: 88%;">
                        <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                        @foreach ($jobTitles as $jobTitle)
                            <option value="{{ $jobTitle->job_id }}">{{ $jobTitle->job_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="fullname" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Full Name') }}:</label>
                    <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Full Name" id="fullname" name="fullname"
                        value="{{ request()->fullname ?? '' }}" placeholder="Enter Full Name"
                        style="display: inline-block; width: 60%;" onkeyup="updateEmployeeCode()">
                </div>
                <div class="mb-4">
                    <label for="employee_code" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Employee Code') }}:</label>
                    <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Employee Code" id="employee_code"
                        name="employee_code" placeholder="Enter Employee Code"
                        value="{{ request()->employee_code ?? '' }}" style="display: inline-block; width: 60%;">
                </div>
                <div class="text-center">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition" title="Search">{{ __('Search') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee List Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl" title="Employee List">
            <div class="flex items-center justify-between">
                <div class="flex-1 text-center font-semibold">{{ __('Employee List') }}</div>
                <div>
                    <a class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200" href="{{route('member-registration.create')}}">Sign up</a>
                </div>
            </div>
        </div>
        <div class="p-5 overflow-x-auto">
            <!-- DataTable -->
            <table id="employeelistTable"
                class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%">
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
                            <td><input type="checkbox" class="employee-checkbox" value="{{ $employee->employee_id }}">
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
    <script>
        function updateEmployeeCode() {
            var fullname = document.getElementById('fullname').value;
            // Logika untuk menghasilkan kode karyawan berdasarkan nama lengkap
            // Misalnya, Anda dapat menggunakan inisial atau bagian dari nama sebagai kode karyawan
            var employeeCode = generateEmployeeCode(fullname);
            document.getElementById('employee_code').value = employeeCode;
        }

        function generateEmployeeCode(fullname) {
            // Misalnya, menggunakan inisial dari setiap kata dalam nama lengkap
            var initials = fullname.split(' ').map(name => name.charAt(0).toUpperCase()).join('');
            return initials;
        }
    </script>
@endsection
