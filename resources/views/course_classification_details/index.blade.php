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
                        <li class="breadcrumb-item"><a href="#">Course Classification Details Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-classification-details.index') }}">Course Classification Details</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Classification Details Registration</li>
                    </ol>
                </nav>
                <div class="row">
                    <!-- Course Classifications Table -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header" style="background-color: darkblue">
                                <b style="color: aliceblue">Course Classification Details</b>
                            </div>
                            <div class="card-body">
                                <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationdetailsTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Classification Name</th>
                                            <th scope="col">Classification Detail Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($details->isNotEmpty())
                                        @foreach ($details as $detail)
                                            <tr>
                                                <td>{{ $detail->course_classification_details_id }}</td>
                                                <td>{{ $detail->classification->course_classification_name ?? '' }}</td>
                                                <td>{{ $detail->course_classification_detailsname }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No data found</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom untuk form -->
                    <div class="col-md-8">
                        <div class="card mb-8">
                            <div class="card-header" style="background-color: darkblue">
                                <b style="color: aliceblue">Course Classification Detail</b>
                                <b style="color: red">*</b>
                                <p style="color: aliceblue">This is a required field.</p>
                            </div>
                            <div class="card-body">
                                <form id="classificationDetailsForm" action="{{ route('details.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company</label>
                                        <input type="hidden" id="selectedCompanyId" name="company_id" value="{{ isset($editClassification) ? $editClassification->company_id : '' }}">
                                        <select class="form-select" id="company_name" name="company_id" required>
                                            <option value="" selected disabled>Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->company_id }}" @if(isset($editClassification) && $editClassification->company_id == $company->company_id) selected @endif>{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_id" class="form-label">Course Classification</label>
                                        <select class="form-select" id="course_classification_id" name="Course_classification_id" required>
                                            <option value="" selected disabled>Select Course Classification</option>
                                            @foreach($classifications as $classification)
                                                <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_detailsname" class="form-label">Classification Detail Name <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" id="course_classification_detailsname" name="course_classification_detailsname" required style="display: inline-block; width: 75%;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">Display Ranking <b style="color: red">*</b></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" required style="display: inline-block; width: 84%;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label">Course classification details icon</label>
                                        <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" style="display: inline-block; width: 72%;">
                                    </div><br><br>
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

            var table = $('#classificationdetailsTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip',
                buttons: ['copy', 'excel', 'pdf']
            });

            // Edit Button Click Event
            $('.edit-btn').click(function() {
                var detailData = $(this).data('detail');

                // Set Form Action and Method for Edit
                $('#classificationDetailsForm').attr('action', '/details/' + detailData.course_classification_details_id);
                $('#classificationDetailsForm').append('<input type="hidden" name="_method" value="PUT">');

                // Fill Form Fields with Data
                $('#course_classification_detailsname').val(detailData.course_classification_detailsname);
                $('#icon_file_path').val(detailData.icon_file_path);
                $('#display_order').val(detailData.display_order);

                // Fill Company Data
                $('#selectedCompanyId').val(detailData.company_id);
                $('#company_name').val(detailData.company_id);

                // Scroll to Form
                $('html, body').animate({
                    scrollTop: $('#classificationDetailsForm').offset().top
                }, 500);

                // Show Form
                $('#classificationDetailsForm').show();
                $('#saveBtn').html('<i class="fas fa-save"></i> Save Changes');
            });
        });
    </script>
@endsection
