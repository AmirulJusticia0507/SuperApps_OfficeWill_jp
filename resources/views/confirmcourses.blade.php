@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Confirm and take course - DEP SERVICE - OFFICE WILL - JAPAN</title>

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
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Confirm and take courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List of courses taken</li>
                    </ol>
                </nav>
                <!-- Create Classification Form -->
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">List of courses taken</b></div>
                        <div class="card-body">
                            <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="confirmcoursesTable">
                                <thead>
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Deadline for enrollment</th>
                                        <th>ToDo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td><a href="#" data-toggle="modal" data-target="#exampleModal"></a>{{ $course->Course_Name }}</td>
                                            <td>{{ $course->Deadline_for_Enrollment }}</td>
                                            <td>{{ $course->ToDo }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Course Details</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Isi modal disini -->
                                <!-- Contoh: Menampilkan detail kursus -->
                                <p>Courses Name: <span id="courseName"></span></p>
                                <p>Deadline for Enrollment: <span id="deadline"></span></p>
                                <p>ToDo: <span id="todo"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <script>
        $(document).ready(function () {
            var table = $('#confirmcoursesTable').DataTable({
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
            $('#confirmcoursesTable').on('click', 'a[data-toggle="modal"]', function () {
                var courseName = $(this).text();
                var row = $(this).closest('tr');
                var deadline = row.find('td:eq(1)').text();
                var todo = row.find('td:eq(2)').text();

                // Mengatur nilai pada modal sesuai dengan data kursus yang dipilih
                $('#courseName').text(courseName);
                $('#deadline').text(deadline);
                $('#todo').text(todo);
            });
        });
    </script>

@endsection
