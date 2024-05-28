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
                    <li class="breadcrumb-item"><a title="Confirm and take courses" href="{{ route('confirm-courses.index') }}">コースを確認して撮影します</a></li>
                    <li class="breadcrumb-item active" title="List of courses taken" aria-current="page">撮影したコースのリスト</li>
                </ol>
            </nav>
            <!-- Create Classification Form -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="List of courses taken"><b
                        style="color:aliceblue">撮影したコースのリスト</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap"
                        style="width:100%" id="confirmcoursesTable">
                        <thead>
                            <tr>
                                <th title="Course Name">コース名</th>
                                <th title="Deadline for enrollment">登録の締め切り</th>
                                <th title="ToDo">全て</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scheduleResultCourses as $scheduleResultCourse)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-auto">
                                                @if($scheduleResultCourse->course->classification_detail->icon_file_path)
                                                    <img src="{{ asset('storage/' . $scheduleResultCourse->course->classification_detail->icon_file_path) }}" alt="Icon" style="max-width: 100px;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <div>{{ $scheduleResultCourse->course->classification->course_classification_name }}</div>
                                                <div>{{ $scheduleResultCourse->course->classification_detail->course_classification_detailsname }}</div>
                                                <div><a href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}">{{ $scheduleResultCourse->course->coursename }}</a></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $scheduleResultCourse->deadline_enrollment }}</td>
                                    <td>{{ $scheduleResultCourse->todo_progress_text }}</td>
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
@endsection
