@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
@section('content')
    <!-- Header -->
    @include('includes.header')


    <!-- Main Content -->
    {{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-8">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('member-registration.create') }}"
                            title="{{ __('Employee Registration') }}">{{ __('Employee Registration') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="{{ __('Employee List') }}">{{ __('Employee List') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="{{ __('Employee List') }}">{{ __('Employee List') }}</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="Employee List"><b
                        style="color:aliceblue">{{ __('Employee List') }}</b></div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="form-group">
                            <label for="affiliation_code">{{ __('Affiliation') }}:</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control" title="Affiliation" id="affiliation_code"
                                    name="affiliation_code" style="display: inline-block; width: 60%;">
                                    <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                    @foreach ($affiliations as $affiliation)
                                        <option value="{{ $affiliation->affiliation_code }}">
                                            {{ $affiliation->affiliation_name }}</option>
                                    @endforeach
                                </select>&emsp;
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" name="search_option" value="Display selected affiliation"
                                            title="{{ __('Display selected affiliation') }}"> {{ __('Display selected affiliation') }}
                                    </label>
                                    <label class="radio-inline ml-3">
                                        <input type="radio" name="search_option"
                                            value="Display selected affiliation and below"
                                            title="{{ __('Display selected affiliation and below') }}"> {{ __('Display selected affiliation and below') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="job">{{ __('Job Title') }}: <b style="color: red">*</b></label>
                            <select name="job" id="job" title="Job Title" class="form-control"
                                style="display: inline-block; width: 88%;">
                                <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                                @foreach ($jobTitles as $jobTitle)
                                    <option value="{{ $jobTitle->job_id }}">{{ $jobTitle->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fullname">{{ __('Full Name') }}:</label>
                            <input type="text" class="form-control" title="Full Name" id="fullname" name="fullname"
                                value="{{ request()->fullname ?? '' }}" placeholder="Enter Full Name"
                                style="display: inline-block; width: 60%;" onkeyup="updateEmployeeCode()">
                        </div>
                        <div class="form-group">
                            <label for="employee_code">{{ __('Employee Code') }}:</label>
                            <input type="text" class="form-control" title="Employee Code" id="employee_code"
                                name="employee_code" placeholder="Enter Employee Code"
                                value="{{ request()->employee_code ?? '' }}" style="display: inline-block; width: 60%;">
                        </div>
                        <div align="center">
                            <button type="submit" class="btn btn-primary btn-block" title="Search"
                                style="background-color: darkblue">{{ __('Search') }}</button>
                        </div>
                    </form>
                </div>
            </div><br><br>

            <div class="card">
                <div class="card-header" title="Employee List" style="background-color: darkblue">
                    <div class="row">
                        <div class="col d-flex justify-content-center"><b style="color:aliceblue;">{{ __('Employee List') }}</b></div>
                        <div class="col-md-2 d-flex justify-content-end">
                            <a class="btn btn-light" href="{{route('member-registration.create')}}">Sign up</a>
                        </div>
                    </div>


                </div>

                <div class="card-body">

                    <!-- DataTable -->
                    <table id="employeelistTable"
                        class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
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
        </div>
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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
