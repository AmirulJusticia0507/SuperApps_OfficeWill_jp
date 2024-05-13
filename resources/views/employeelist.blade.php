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
                        <li class="breadcrumb-item"><a href="{{ route('member-registration.create') }}">Employee Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employee-list') }}">Employee List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Employee List</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Employee List</b></div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="form-group">
                                    <label for="affiliation_id">Affiliation:</label>
                                    <div class="d-flex align-items-center">
                                        <select class="form-control mr-3" id="affiliation_id" name="affiliation_id" required style="width: 60%;">
                                            <!-- Opsi pilihan affiliasi -->
                                        </select>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" name="search_option" value="Display selected affiliation"> Display selected affiliation
                                            </label>
                                            <label class="radio-inline ml-3">
                                                <input type="radio" name="search_option" value="Display selected affiliation and below"> Display selected affiliation and below
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="job_id">&emsp;Job Title:</label>
                                    <select class="form-control" id="job_id" name="job_id" required style="display: inline-block; width: 60%;">
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">&emsp;Full Name:</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" style="display: inline-block; width: 60%;">
                                </div>
                                <div class="form-group">
                                    <label for="employee_code">&emsp;Employee Code:</label>
                                    <input type="text" class="form-control" id="employee_code" name="employee_code" placeholder="Enter Employee Code" style="display: inline-block; width: 60%;">
                                </div>
                                <div align="center">
                                    <button type="submit" class="btn btn-primary btn-block" style="background-color: darkblue">Search</button>
                                </div>
                            </form>
                        </div>
                </div><br><br>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">Employee List</b></div>
                        <!-- DataTable -->
                        <table id="employeelistTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Affiliation</th>
                                    <th>Job Title (Pos)</th>
                                    <th>Full Name</th>
                                    <th>Employee Code</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($filteredEmployees as $employee)
                                <tr>
                                    <td><input type="checkbox" class="employee-checkbox" value="{{ $employee->id }}"></td>
                                    <td>{{ $employee->affiliation->affiliation_name }}</td>
                                    <td>{{ $employee->job->job_title }}</td>
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
