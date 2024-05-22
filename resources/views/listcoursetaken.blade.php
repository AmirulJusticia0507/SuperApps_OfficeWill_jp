@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<style>
    /* Style untuk textarea */
    textarea {
        resize: both; /* Membuat textarea bisa diresize */
        overflow: auto; /* Menambahkan scrollbar jika konten terlalu besar */
        width: 100%; /* Lebar textarea */
        height: 150px; /* Tinggi textarea */
    }

    .sticky-list-group {
        position: sticky;
        top: 10px; /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
    }
</style>

@section('content')
    <!-- Header -->
    @include('includes.header')


    <!-- Main Content -->
    {{-- <div class="container"> --}}
        <div class="row justify-content-center">
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <div class="col-md-6">
                <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('confirm-courses.index') }}" title="Confirm and take courses">コースを確認して撮影します</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="List of courses taken">撮影したコースのリスト</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="Attendance">出席</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue" title=" Course information"><b style="color:aliceblue">コース情報</b></div>
                        <div class="card-body">
                            <div class="card-header" title="Employee List" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">従業員リスト</b></div>
                            <!-- DataTable -->
                            <table id="employeelistTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th title="Course Name">コース名</th>
                                        <th title="Deadline for enrollment">登録の締め切り</th>
                                        <th title="ToDo">全て</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courseScheduleResults as $index => $result)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->course->coursename ?? 'N/A' }}</td>
                                            <td>{{ $result->employee->fullname ?? 'N/A' }}</td>
                                            <td>{{ $result->deadline_enrollment }}</td>
                                            <td>{{ $result->todo_complete ? '完了' : '未完了' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>    
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header" title="Course Description" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">コースの説明:</b></div><br>
                        <textarea name="course_description" id="course_description" cols="10" rows="10" readonly>{{ $course->course_description }}</textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header" title="Materials" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">材料:</b></div>
                        <ul>
                            @foreach($materials as $material)
                                <li>{{ $material->teaching_material_name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
            <br><br><br><br><br>
                <div class="mt-2 sticky-list-group">
                    <ul class="list-group rounded-6" style="float: right;">
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-list') }}" title="Course list"><b style="color:aliceblue"> 社員一覧</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-inquiry') }}" title="Attendance inquiry"><b style="color:aliceblue">  受講照会トップ</b></a></li>
                    </ul>
                </div>
            </div>
        </div>
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