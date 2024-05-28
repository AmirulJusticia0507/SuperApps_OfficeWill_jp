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
                    <li class="breadcrumb-item" title="List of courses taken" aria-current="page">撮影したコースのリスト</li>
                    <li class="breadcrumb-item active" title="Attendance" aria-current="page">出席</li>
                </ol>
            </nav>
            <!-- Create Classification Form -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="List of courses taken"><b
                        style="color:aliceblue"> Course information</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap"
                        style="width:100%" id="confirmcoursesTable">
                        <thead>
                            <tr>
                                <th title="Course Name">コース名</th>
                                <th title="Deadline for enrollment">登録の締め切り</th>
                                <th title="ToDo">ToDo</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                            <div>{{ $scheduleResultCourse->course->classification->course_classification_name }}</di>
                                            <div>{{ $scheduleResultCourse->course->classification_detail->course_classification_detailsname }}</div>
                                            <div><a href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}">{{ $scheduleResultCourse->course->coursename }}</a></div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $scheduleResultCourse->deadline_enrollment }}</td>
                                <td>{{ $scheduleResultCourse->todo_progress_text }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="m-1">
                        <h3 class="py-2"><b title="Course Description:">コース説明:</b></h3>
                        <div class="course-desc mb-2">
                            <p>{{ $scheduleResultCourse->course->course_description }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue"> Materials</b>
                </div>
                <div class="card-body">
                    <table class="display table responsive nowrap" style="width:100%" id="confirmcoursesTable">
                        <tbody>
                            @foreach ($scheduleResultCourse->course->material->sortBy('display_order') as $material)
                                <tr>
                                    <td width="80%">{{ $material->teaching_material_name }}</td>
                                    <td width="20%" class="text-right"><a class="btn btn-info btn-sm" target="_blank"
                                            href="{{ $material->material_type == '1' ? $material->youtube_video_url : asset($material->book_file_path) }}" title="View materials">教材を見る</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-danger">
                        <p title="Once you have completed the course using the learning materials, please proceed to ToDo.">教材による受講終了後は、ToDoに進んでください。
                        </p>
                        <p title="(You will not be able to complete the course unless you complete the ToDo.)">(ToDoが完了しないと受講が修了になりません)</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body"><a class="btn btn-info save-confirm" data-confirm-title="Go to ToDo" data-confirm-html="The test results from the previous completion will be initialized. <br />(If there is a passing setting, it is necessary to clear the passing score) is this good?"
                        href="{{ route('confirm-courses.todo-answer.index', $scheduleResultCourse->course->course_id) }}" title="Go Todo">ToDoに進む</a></div>
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
