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
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-6">
            <br><br><br>
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
            </div><br>
                @php
                    $totalQuestions = $testAnswers->count(); // Menghitung jumlah total pertanyaan
                    $totalCorrectAnswers = $testAnswers->where('is_correct', true)->count(); // Menghitung jumlah jawaban yang benar
                    $passFail = ($totalCorrectAnswers / $totalQuestions) >= 0.6 ? 'Pass' : 'Fail'; // Menentukan apakah lulus atau tidak (60% adalah batas kelulusan)
                    $correctAnswerRate = ($totalCorrectAnswers / $totalQuestions) * 100; // Menghitung tingkat kebenaran jawaban dalam persen
                @endphp
            <div class="card">
                <div class="card-body">
                    <div class="card-header" title="Scoring Results" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">得点の結果</b></div><br>
                    <p title="Test Pass/Fail">パス/失敗: {{ $passFail }}</p>
                    <p title="Number of questions">質問の数: {{ $totalQuestions }}</p>
                    <p title="The number of correct answers">正解の数: {{ $totalCorrectAnswers }}</p>
                    <p title="Correct answer rate">正解率: {{ number_format($correctAnswerRate, 2) }}%</p>
                </div>
            </div><br>
            <a href="" title="Return to Class" class="btn btn-light"><i class="fas fa-arrow-left"></i> クラスに戻ります</a><br><br>
            <div class="card">
                <div class="card-body">
                    <div class="card-header" title="Test Explanation" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">テストの説明</b></div><br>
                    @foreach ($questions as $question)
                        <div class="question">
                            <p><strong>Question:</strong> {{ $question->question_text }}</p>
                            <p><strong>Answer Type:</strong> {{ $question->answer_type }}</p>
                            <p><strong>Answered:</strong> {{ $question->answered }}</p>
                            <p><strong>Explanation:</strong> {{ $question->explanation }}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>

            <div align="center">
                <button type="submit" class="btn btn-info"><i class="fas fa-checklist"></i> Complete</button>
                <button type="reset" class="btn btn-info"><i class="fas fa-rotate"></i> Retest</button>
            </div>
            <div class="col-md-2">
            <br><br><br><br><br>
            <div class="mt-2 sticky-list-group">
                <ul class="list-group rounded-6" style="float: right;">
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('course-list') }}" title="Course list"><b style="color:aliceblue"> コース一覧</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Return to class"><b style="color:aliceblue"> 受講に戻る</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Test Scoring"><b style="color:aliceblue"> テスト採点</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Retest"><b style="color:aliceblue"> 再テスト</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Complete"><b style="color:aliceblue"> 完了</b></a></li>
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
    </script>
@endsection