@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DEP SERVICE - OFFICE WILL - JAPAN</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>

@section('content')
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow">
            <!-- Tambahkan tombol hamburger di sini -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Include Header -->
            @include('includes.header')
        </nav>

        <!-- Include Sidebar -->
        @include('includes.sidebar')

        <div class="content-wrapper">
            <!-- Konten Utama -->
            <main class="content">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Job Title/Position Master Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('job-titles.index') }}">Job/Position Master Registration</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Job Title/Position Master Registration</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header" style="background-color: darkblue">
                                <b style="color: aliceblue">List of Job Titles</b>
                            </div>
                            <div class="card-body">
                                <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="jobTitleTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Job ID</th>
                                            {{-- <th scope="col">Company ID</th> --}}
                                            <th scope="col">Job Title</th>
                                            {{-- <th scope="col">Display Order</th> --}}
                                            <!-- <th scope="col" nowrap>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobTitles as $jobTitle)
                                            <tr>
                                                <td>{{ $jobTitle->Job_id }}</td>
                                                {{-- <td>{{ $jobTitle->company_id }}</td> --}}
                                                <td>{{ $jobTitle->job_title }}</td>
                                                {{-- <td>{{ $jobTitle->display_order }}</td> --}}
                                                <!-- <td nowrap>
                                                    <a href="{{ route('job-titles.show', $jobTitle->Job_id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                                                    <a href="{{ route('job-titles.edit', $jobTitle->Job_id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                    <form action="{{ route('job-titles.destroy', $jobTitle->Job_id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </td> -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom untuk form -->
                    <div class="col-md-8">
                        <div class="card mb-8">
                            <div class="card-header" style="background-color: darkblue">
                                <b style="color: aliceblue">Job Title Information Form</b>
                                <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('job-titles.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="job_title">Job Title: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" id="job_title" name="job_title" style="display: inline-block; width: 80%;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_order">Display Order: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" id="display_order" name="display_order" style="display: inline-block; width: 71%;" required>
                                    </div>
                                    <div align="center">
                                        <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                                        <button type="button" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i> Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    @include('includes.footer')

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Tambahkan event click pada tombol pushmenu
        $('.nav-link[data-widget="pushmenu"]').on('click', function() {
            // Toggle class 'sidebar-collapse' pada elemen body
            $('body').toggleClass('sidebar-collapse');
        });

        // Tambahkan event click pada tombol toggler untuk sidebar
        $('.navbar-toggler[aria-controls="sidebar"]').on('click', function() {
            // Toggle class 'show' pada elemen sidebar
            $('#sidebar').toggleClass('show');
        });
    });
</script>
<!-- Script for DataTables -->
<script>
    $(document).ready(function () {
        var table = $('#jobTitleTable').DataTable({
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
