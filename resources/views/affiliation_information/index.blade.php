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
                        <li class="breadcrumb-item"><a href="#">Affiliation Master Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('affiliation-information.index') }}">Affiliation List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Affiliation Information Registration</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header" style="background-color: darkblue">
                                <b style="color: aliceblue">List of Affiliation</b>
                            </div>
                            <div class="card-body">
                                <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="affiliationTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Affiliation Code</th>
                                            <th scope="col" nowrap>Affiliation Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($affiliations as $affiliation)
                                            <tr>
                                                <td>{{ $affiliation->affiliation_code }}</td>
                                                <td nowrap>{{ $affiliation->affiliation_name }}</td>
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
                                <b style="color: aliceblue">Affiliation Information Form</b>
                                <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('affiliation-information.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="company_name">Company Name: <b style="color: red">*</b></label>
                                        <select class="form-select" id="company_name" name="company_name" required>
                                            <option value="" selected disabled>Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="affiliation_code">Affiliation Code: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" id="affiliation_code" name="affiliation_code" style="display: inline-block; width: 81%;" required>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="company_id">Company ID:</label>
                                        <input type="text" class="form-control" id="company_id" name="company_id">
                                    </div> -->
                                    <div class="form-group">
                                        <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" id="affiliation_name" name="affiliation_name" style="display: inline-block; width: 80%;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_order">Display Order: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" id="display_order" name="display_order" style="display: inline-block; width: 83%;">
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_type">Organization Type: <b style="color: red">*</b></label>
                                        <div class="row" style="display: inline-block; width: 60%;">
                                            <div class="form-check">
                                                &emsp;<input class="form-check-input" type="radio" name="organization_type" id="main_store_equivalent" value="Main store equivalent" required>
                                                <label class="form-check-label" for="main_store_equivalent"> Main store equivalent</label>
                                            {{-- </div>
                                            <div class="form-check"> --}}
                                                &emsp;&emsp;<input class="form-check-input" type="radio" name="organization_type" id="fc_store" value="FC Store" required>
                                                <label class="form-check-label" for="fc_store">FC Store</label>
                                            </div>
                                        </div>
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
    <!-- jQuery -->
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
    $(document).ready(function () {
        var table = $('#affiliationTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });

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
@endsection
