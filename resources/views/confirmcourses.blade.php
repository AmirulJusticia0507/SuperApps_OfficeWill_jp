@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
    <!-- Header -->
    @include('includes.header')

    <div class="row justify-content-center">
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-8">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a title="Confirm and take courses" href="#">コースを確認して撮影します</a></li>
                    <li class="breadcrumb-item active" title="List of courses taken" aria-current="page">撮影したコースのリスト</li>
                </ol>
            </nav>
            <!-- Create Classification Form -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="List of courses taken"><b style="color:aliceblue">撮影したコースのリスト</b></div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="confirmcoursesTable">
                            <thead>
                                <tr>
                                    <th title="Course Name">コース名</th>
                                    <th title="Deadline for enrollment">登録の締め切り</th>
                                    <th title="ToDo">全て</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#exampleModal"></a>
                                            {{ $course->Course_Name }}</td>
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
                            <h5 class="modal-title" id="exampleModalLabel" title="Course Details">詳細ルート</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Isi modal disini -->
                            <!-- Contoh: Menampilkan detail kursus -->
                            <p title="Courses Name">コース名: <span id="courseName"></span></p>
                            <p title="Deadline for Enrollment">登録の締め切り: <span id="deadline"></span></p>
                            <p title="ToDo">全て: <span id="todo"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Close">近い</button>
                        </div>
                    </div>
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
