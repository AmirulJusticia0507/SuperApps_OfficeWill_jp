@extends('layouts.app')

@section('styles')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <!-- Header -->
    @include('includes.header')

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-6">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="List of courses taken">撮影したコースのリスト</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="Attendance">出席</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="Post-course ToDo">コースポストトッド</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="Course Information > Survey Response"><b style="color:aliceblue">コース情報>調査応答</b></div>
                <div class="card-body">
                    <div class="card-header" title="Course information" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">コース情報</b></div>
                    <!-- DataTable -->
                    <table id="employeelistTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th title="Course Name">コース名</th>
                                <th title="Deadline for enrollment">登録の締め切り</th>
                                <th title="ToDo">ToDo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courseScheduleResults as $index => $result)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $result->course->coursename ?? 'N/A' }}</td>
                                    <td>{{ $result->deadline_enrollment }}</td>
                                    <td>{{ $result->todo_complete ? '完了' : '未完了' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>    
            </div>
            <a href="" title="Return to Class" class="btn btn-light"><i class="fas fa-arrow-left"></i> クラスに戻ります</a><br><br>
            <div class="card">
                <div class="card-body">
                    <div class="card-header" title="Course Description" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">コースの説明:</b></div><br>
                    @foreach($courses as $course)
                        <textarea name="course_description" id="course_description" cols="10" rows="10">{{ $course->course_description }}</textarea>
                    @endforeach
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createQuestionModal"><i class="fas fa-plus"></i> 質問を作成します</button>
                </div>
            </div>
            </div><br>

            <!-- Modal -->
            <div class="modal fade" id="createQuestionModal" tabindex="-1" role="dialog" aria-labelledby="createQuestionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createQuestionModalLabel" title="Create New Question">新しい質問を作成します</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for Creating Question -->
                            <form method="POST" action="{{ route('questions.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="questionText">質問を書き留める:</label>
                                    <input type="text" class="form-control" title="Question text" id="questionText" name="questionText" required>
                                </div>
                                <div class="form-group">
                                    <label for="answerType" title="Answer type">回答タイプ:</label>
                                    <select class="form-control" id="answerType" name="answerType" required>
                                        <option value="radio" title="radio button">ラジオボタン</option>
                                        <option value="checkbox" title="checkbox">チェックボックス</option>
                                        <option value="select" title="selectbox">セレクトボックス</option>
                                        <option value="text" title="text">テキスト</option>
                                    </select>
                                </div>
                                <div class="form-group" id="answerOptions">
                                    <!-- Option fields will be appended here based on answerType selection -->
                                </div>
                                <div class="form-group">
                                    <label for="isRequired">が必要です:</label>
                                    <input type="checkbox" id="isRequired" name="isRequired" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <br><br><br><br><br>
                <div class="mt-2 sticky-list-group">
                    <ul class="list-group rounded-6" style="float: right;">
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('course-list') }}" title="Course list"><b style="color:aliceblue"> コース一覧</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Return to class"><b style="color:aliceblue"> 受講に戻る</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="ToDo"><b style="color:aliceblue"> ToDoトップ</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Questionnaire answers"><b style="color:aliceblue"> アンケート回答</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Test Scoring"><b style="color:aliceblue"> テスト採点</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Report submission"><b style="color:aliceblue"> レポート提出</b></a></li>
                        <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Save Temporary"><b style="color:aliceblue"> 一時保存</b></a></li>
                    </ul>
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
    $('#answerType').change(function() {
            var answerType = $(this).val();
            $('#answerOptions').empty();

            if (answerType === 'radio' || answerType === 'checkbox') {
                $('#answerOptions').append('<label for="options">Jawaban:</label>');
                $('#answerOptions').append('<input type="text" class="form-control" id="options" name="options" required>');
            } else if (answerType === 'select') {
                $('#answerOptions').append('<label for="options">Jawaban:</label>');
                $('#answerOptions').append('<select class="form-control" id="options" name="options" required><option value="Option 1">Option 1</option><option value="Option 2">Option 2</option><option value="Option 3">Option 3</option></select>');
            }
    });
</script>
@endsection