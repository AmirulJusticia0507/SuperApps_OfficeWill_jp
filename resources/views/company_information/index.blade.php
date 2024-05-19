@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Company Information - DEP SERVICE - OFFICE WILL - JAPAN</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Company Information</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('company-information.index') }}">Create Company</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Company Information</li>
                    </ol>
                </nav>

                <div align="right">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCompanyModal"><i class="fas fa-plus"></i> Create Company</button>&emsp;
                </div>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Company Information</b></div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap"
                            style="width:100%" id="companyTable">
                            <thead>
                                <tr>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Login Screen URL</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Teaching Material</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->company_name }}</td>
                                    <td>{{ $company->login_screen_url }}</td>
                                    <!-- <td>
                                            <img src="{{ Storage::url($company->icon_storage_file_path) }}" alt="Company Icon" style="max-width: 100px;">
                                        </td>
                                        <td>
                                            <img src="{{ Storage::url($company->teaching_material_storage_file_path) }}" alt="Teaching Material" style="max-width: 100px;">
                                        </td> -->
                                    <td>
                                        <a data-fancybox="gallery{{ $company->id }}"
                                            data-src="{{ Storage::url($company->icon_storage_file_path) }}"
                                            data-caption="Company Icon">
                                            <img src="{{ Storage::url($company->icon_storage_file_path) }}" alt="Company Icon"
                                                style="max-width: 100px;">
                                        </a>
                                    </td>
                                    <td>
                                        <a data-fancybox="gallery{{ $company->id }}"
                                            data-src="{{ Storage::url($company->teaching_material_storage_file_path) }}"
                                            data-caption="Teaching Material">
                                            <img src="{{ Storage::url($company->teaching_material_storage_file_path) }}"
                                                alt="Teaching Material" style="max-width: 100px;">
                                        </a>
                                    </td>

                                    <td>
                                        <!-- Tombol Edit Company Modal -->
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editCompanyModal{{ $company->id }}"><i class="fas fa-edit"></i> Edit</button>
                                        <!-- Form Delete Company -->
                                        <form action="{{ route('company-information.destroy', $company->company_id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Include Footer -->
                @include('includes.footer')

                <!-- Create Company Modal -->
                <div class="modal fade" id="createCompanyModal" tabindex="-1" aria-labelledby="createCompanyModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCompanyModalLabel">Create Company</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Create Company -->
                            <form method="POST" action="{{ route('company-information.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="company_name">Company Name:</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="login_screen_url">Login Screen URL:</label>
                                    <input type="text" class="form-control" id="login_screen_url" name="login_screen_url" required>
                                </div>

                                <div class="form-group">
                                    <label for="icon_storage_file_path">Icon Storage File:</label>
                                    <input type="file" class="form-control" id="icon_storage_file_path"
                                        name="icon_storage_file_path" required onchange="previewIcon(this)">
                                    <!-- Tambahkan atribut 'required' untuk memastikan file dipilih -->
                                    <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                                </div>


                                <div class="form-group">
                                    <label for="teaching_material_storage_file_path">Teaching Material Storage File:</label>
                                    <input type="file" class="form-control" id="teaching_material_storage_file_path"
                                        name="teaching_material_storage_file_path" onchange="previewMaterial(this)">
                                    <img id="material_preview" src="#" alt="Preview Material"
                                        style="max-width: 100px; display: none;">
                                </div><br><br>
                                <div align="center">
                                    <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                                    <button type="button" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i>Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

                <!-- Edit Company Modal -->
                @foreach($companies as $company)
                <div class="modal fade" id="editCompanyModal{{ $company->id }}" tabindex="-1"
                aria-labelledby="editCompanyModalLabel{{ $company->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCompanyModalLabel{{ $company->id }}">Edit Company</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Edit Company -->
                            <form method="POST" action="{{ route('company-information.update', $company->company_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="company_name">Company Name:</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        value="{{ $company->company_name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="login_screen_url">Login Screen URL:</label>
                                    <input type="text" class="form-control" id="login_screen_url" name="login_screen_url"
                                        value="{{ $company->login_screen_url }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="icon_storage_file_path">Icon Storage File:</label>
                                    <input type="file" class="form-control" id="icon_storage_file_path"
                                        name="icon_storage_file_path" onchange="previewIcon(this)">
                                    <img id="icon_preview" src="{{ $company->icon_storage_file_path }}" alt="Current Icon"
                                        style="max-width: 100px;">
                                </div>

                                <div class="form-group">
                                    <label for="teaching_material_storage_file_path">Teaching Material Storage File:</label>
                                    <input type="file" class="form-control" id="teaching_material_storage_file_path"
                                        name="teaching_material_storage_file_path" onchange="previewMaterial(this)">
                                    <img id="material_preview" src="{{ $company->teaching_material_storage_file_path }}"
                                        alt="Current Material" style="max-width: 100px;">
                                </div>
                                <div align="center">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-pen"></i> Update</button>&emsp;
                                    <button type="reset" class="btn btn-dark"><i class="fas fa-power-off"></i> Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                @endforeach

            </main>
        </div>
    </div>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

    <!-- Script for Modals -->
    <script>
        // Function to show modal when the button is clicked
        const createCompanyModal = new bootstrap.Modal(document.getElementById('createCompanyModal'));
        $(document).ready(function () {
            var table = $('#companyTable').DataTable({
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
        $(document).ready(function () {
            $("[data-fancybox]").fancybox({});
        });

    </script>
    @endsection

    @section('scripts')
    <script>
        function previewIcon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#icon_preview').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMaterial(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#material_preview').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
    @endsection
</body>
</html>
