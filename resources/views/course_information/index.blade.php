@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<!-- Header -->
@include('includes.header')
{{-- <div class="container"> --}}
        <div class="row justify-content-center">
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <div class="col-md-5">
                <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Course Information Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Information Registration</li>
                    </ol>
                </nav>
                <div class="card">
                    <div id="courseregistration" class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Information Registration</b></div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($course) ? route('course-information.update', $course->course_id) : route('course-information.store') }}">
                            @csrf
                            @if(isset($course))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="course_classification_id" style="display: inline-block; width: 30%;">Course Classification :</label><b style="color: red">*</b>
                                <select class="form-control" id="course_classification_id" name="Course_classification_id" required style="display: inline-block; width: 60%;">
                                    @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="course_classification_details_id" style="display: inline-block; width: 30%;">Classification Detail :</label><b style="color: red">*</b>
                                <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required style="display: inline-block; width: 60%;">
                                    @foreach($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="coursename" style="display: inline-block; width: 30%;">Course Name : </label><b style="color: red">*</b>
                                <input id="coursename" type="text" class="form-control" name="coursename" value="{{ isset($course) ? $course->coursename : '' }}" required style="display: inline-block; width: 60%;">
                            </div>

                            <div class="form-group">
                                <label for="coursename_kana" style="display: inline-block; width: 30%;">Course Name (Kana) :</label>
                                <input type="text" name="coursename_kana" id="coursename_kana" class="form-control" style="display: inline-block; width: 60%;">
                            </div>

                            <div class="form-group">
                                <label for="course_description" style="display: inline-block; width: 30%;">Course Description : <b style="color: red">*</b></label>
                                <textarea name="course_description" id="course_description" class="form-control" cols="5" rows="5" required style="display: inline-block; width: 60%;"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="possible_retake_course_deadline" style="display: inline-block; width: 30%;">Retake course deadline :<b style="color: red">*</b></label>
                                <div style="display: inline-block; width: 60%;">
                                    <input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible" value="Re-attendance possible" required>
                                    <label for="re_attendance_possible" style="margin-right: 5px; margin-left: 5px;">Re-attendance possible</label>
                                    <input type="radio" name="possible_retake_course_deadline" id="re_attendance_not_allowed" value="Re-attendance not allowed" required>
                                    <label for="re_attendance_not_allowed" style="margin-right: 10px; margin-left: 5px;">Re-attendance not allowed</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="course_attributes_01" style="display: inline-block; width: 30%;">(Course attribute 01) :</label>
                                <select name="course_attributes_01" id="course_attributes_01" style="display: inline-block; width: 60%;" class="form-control">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="course_attributes_02" style="display: inline-block; width: 30%;">(Course attribute 02) :</label>
                                <input type="text" name="course_attributes_02" id="course_attributes_02" class="form-control" style="display: inline-block; width: 60%;">
                            </div>

                            <div class="form-group">
                                <label for="course_attributes_03" style="display: inline-block; width: 30%;">(Course attribute 03) :</label>
                                <select name="course_attributes_03" id="course_attributes_03" style="display: inline-block; width: 60%;" class="form-control">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="course_attributes_04" style="display: inline-block; width: 30%;">(Course attribute 04) :</label>
                                <input type="text" name="course_attributes_04" id="course_attributes_04" class="form-control" style="display: inline-block; width: 60%;">
                            </div>

                            <div class="form-group">
                                <label for="course_attributes_05" style="display: inline-block; width: 30%;">(Course attribute 05) :</label>
                                <select name="course_attributes_05" id="course_attributes_05" style="display: inline-block; width: 60%;" class="form-control">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="remarks" style="display: inline-block; width: 30%;">Remarks :</label>
                                <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control" style="display: inline-block; width: 60%;"></textarea>
                            </div>

                            <!-- <div id="textbookinformation" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue">Teaching Material Information</b></div>
                            <div class="card-body">
                                <div class="card-header" style="background-color: #F7F7F7" align="center"><b style="color:black">Teaching Material</b></div>
                                <div align="right"><br>
                                    <button type="button" class="btn btn-light" onclick="addMaterial()">Addition</button>
                                    <button type="button" class="btn btn-dark" onclick="removeMaterial()">Delete</button>
                                </div><br>
                                <form id="teachingMaterialForm">
                                    <div class="form-group">
                                        <label for="Teaching Material Name" style="display: inline-block; width: 30%;">Teaching Material Name :</label><b style="color: red">*</b>
                                        <input type="text" name="teaching_material_name" id="teaching_material_name" style="display: inline-block; width: 65%;" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <div style="display: flex; align-items: center;">
                                            <label for="material_type" style="margin-right: 10px;" style="width: 100%">Material Type:<b style="color: red">*</b></label>
                                            <div style="display: flex;">
                                                <input type="radio" name="material_type" id="video" value="Video" required>
                                                <label for="video" style="margin-right: 10px;">&emsp;Video</label>
                                                <input type="radio" name="material_type" id="books" value="Books" required>
                                                <label for="books" style="margin-right: 10px;">&emsp;Books</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="videoFields" style="display: none;">
                                        <div class="form-group">
                                            <label for="youtube_video_url">Video URL: <b style="color: red">*</b></label>
                                            <input type="url" name="youtube_video_url" id="youtube_video_url" class="form-control" required>
                                        </div>
                                    </div>

                                    <div id="booksFields" style="display: none;">
                                        <div class="form-group">
                                            <label for="book_file_path">Book File: <b style="color: red">*</b></label>
                                            <input type="file" name="bookfile" id="bookfile" class="form-control" required>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                            <div id="posttodo" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue"> Post-course ToDo</b></div>
                            <div class="mb-3">
                                <div style="display: flex; align-items: center;">
                                    <label for="todo_type" style="margin-right: 10px;" style="width: 100%">ToDo Type : <b style="color: red">*</b></label>
                                    <div style="display: flex;">
                                        <input type="radio" name="todo_type" id="survey_answers" value="survey_answers" required>
                                        <label for="survey_answers" style="margin-right: 10px;">&emsp;Survey answers</label>
                                        <input type="radio" name="todo_type" id="tests" value="Tests" required>
                                        <label for="tests" style="margin-right: 10px;">&emsp;Tests</label>
                                        <input type="radio" name="todo_type" id="reports" value="Reports" required>
                                        <label for="reports" style="margin-right: 10px;">&emsp;Reports</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="todo_description">ToDo Description : <b style="color: red">*</b></label>
                                <textarea name="todo_description" id="todo_description" cols="5" rows="5" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <div style="display: flex; align-items: center;">
                                    <label for="sex" style="margin-right: 10px;" style="width: 100%">Retest availability: <b style="color: red">*</b></label>
                                    <div style="display: flex;">
                                        <input type="radio" name="repeated_retest" id="retest_availability" value="Retest Availability" required>
                                        <label for="retest_availability" style="margin-right: 10px;">&emsp;Retest availability</label>
                                        <input type="radio" name="repeated_retest" id="no_retest_availability" value="No Retest Availability" required>
                                        <label for="no_retest_availability" style="margin-right: 10px;">&emsp;No Retest Availability</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="test_passed_score">Test Pass Threshold :</label>
                                <input type="text" name="test_passed_score" id="test_passed_score" class="form-control" placeholder="xx.xx" style="display: inline-block; width: 10%;">
                                <p>Complete the course with % or more correct</p>
                            </div>
                            {{-- <div class="card-header" style="background-color: #F7F7F7" align="center"><b style="color:black"> Question</b></div><br><br> --}}
                            <div align="center" id="save-course">
                                <button type="submit" class="btn btn-info"><i class="fas fa-sent"></i> Save Course</button>
                                <button type="reset" class="btn btn-secondary"> Delete</button>
                            </div><br><br>
                        </form><br>
                        <div align="left">
                            <button class="btn btn-warning" title="*If ToDo type is survey response" data-toggle="modal" data-target="#questionModal">※ToDo種別がアンケート回答の場合</button>
                        </div>
                        <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="questionModalLabel">Add Question</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form untuk menambah pertanyaan -->
                                        <form id="questionForm">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="questionText">Question:</label>
                                                        <input type="text" class="form-control" id="questionText" name="questionText" placeholder="questionaire" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="answerType">Answer Type:</label>
                                                        <select class="form-control" id="answerType" name="answerType" required>
                                                            <option value="text">Text</option>
                                                            <option value="radio">Radio Button</option>
                                                            <option value="checkbox">Checkbox</option>
                                                            <option value="select">Selectbox</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="isRequired">Is Required:</label><br>
                                                        <input type="radio" id="isRequiredYes" name="isRequired" value="yes" required>
                                                        <label for="isRequiredYes">Yes</label>
                                                        <input type="radio" id="isRequiredNo" name="isRequired" value="no" required>
                                                        <label for="isRequiredNo">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Formulir untuk jawaban Text -->
                                            <div id="textAnswerForm" class="answerForm" style="display: none;">
                                                <div class="form-group">
                                                    <label for="textAnswer">Text Answer:</label>
                                                    <input type="text" class="form-control" id="textAnswer" name="textAnswer">
                                                </div>
                                            </div>

                                            <!-- Formulir untuk jawaban Radio Button -->
                                            <div id="radioAnswerForm" class="answerForm" style="display: none;">
                                                <div class="form-group">
                                                    <label for="radioOptions">Radio Options:</label>
                                                    <input type="text" class="form-control" id="radioOptions" name="radioOptions" placeholder="Option 1, Option 2, Option 3, ...">
                                                </div>
                                            </div>

                                            <!-- Formulir untuk jawaban Checkbox -->
                                            <div id="checkboxAnswerForm" class="answerForm" style="display: none;">
                                                <div class="form-group">
                                                    <label for="checkboxOptions">Checkbox Options:</label>
                                                    <input type="text" class="form-control" id="checkboxOptions" name="checkboxOptions" placeholder="Option 1, Option 2, Option 3, ...">
                                                </div>
                                            </div>

                                            <!-- Formulir untuk jawaban Selectbox -->
                                            <div id="selectAnswerForm" class="answerForm" style="display: none;">
                                                <div class="form-group">
                                                    <label for="selectOptions">Selectbox Options:</label>
                                                    <input type="text" class="form-control" id="selectOptions" name="selectOptions" placeholder="Option 1, Option 2, Option 3, ...">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Question</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- List of Links and Buttons -->
            <div class="col-md-3">
                <br><br><br><br><br>
                <div class="mt-2">
                    <ul class="list-group">
                        <li class="list-group-item" style="background-color: darkblue">
                            <a href="{{ route('course-list') }}" title="Course list"><b style="color:aliceblue"> コース一覧</b></a>
                        </li>
                        <li class="list-group-item" style="background-color: darkblue">
                            <a href="#courseregistration" title="Course registration"><b style="color:aliceblue"> コース登録トップ</b></a>
                        </li>
                        <li class="list-group-item" style="background-color: #92CDFC">
                            <a href="#basicinformation" title="Basic information"><b style="color:aliceblue"> 基本情報</b></a>
                        </li>
                        <li class="list-group-item" style="background-color: #92CDFC">
                            <a href="#textbookinformation" title="Textbook information"><b style="color:aliceblue"> 教材情報</b></a>
                        </li>
                        <li class="list-group-item" style="background-color: #92CDFC">
                            <a href="#posttodo" title="Post-course ToDo"><b style="color:aliceblue"> 受講後ToDo</b></a>
                        </li>
                        <li class="list-group-item" style="background-color: darkblue">
                            <a href="#save-course"><b style="color:aliceblue"> コース保存</b></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
@include('includes.footer')
@endsection


<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@section('scripts')
<script>
    $(document).ready(function () {
        var table = $('#courseTable').DataTable({
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
<!-- Script for Modals -->
@section('scripts')
<script>
    $(document).ready(function () {
        // Tampilkan modal saat tombol "Addition" diklik
        $('#addQuestionBtn').click(function() {
            $('#questionModal').modal('show');
        });

        // Handler untuk submit form survei
        $('#questionForm').submit(function(event) {
            event.preventDefault();

            // Ambil nilai dari form
            var questionText = $('#questionText').val();
            var answerType = $('#answerType').val();
            var isRequired = $('input[name="isRequired"]:checked').val();

            // Data yang akan dikirim
            var formData = {
                questionText: questionText,
                answerType: answerType,
                isRequired: isRequired
            };

            // Kirim data ke fungsi controller store menggunakan AJAX
            $.ajax({
                type: "POST",
                url: "{{ route('questionnaire.store') }}", // Ganti dengan URL yang sesuai
                data: formData,
                success: function(response) {
                    // Lakukan sesuatu setelah data berhasil disimpan
                    console.log(response);
                    // Tutup modal
                    $('#questionModal').modal('hide');
                },
                error: function(error) {
                    // Tampilkan pesan error jika terjadi kesalahan
                    console.log(error);
                }
            });
        });

        // Tampilkan atau sembunyikan formulir jawaban sesuai dengan tipe jawaban yang dipilih
        $('#answerType').change(function() {
            var selectedAnswerType = $(this).val();
            $('.answerForm').hide(); // sembunyikan semua formulir jawaban

            // Tampilkan formulir jawaban yang sesuai dengan tipe yang dipilih
            $('#' + selectedAnswerType + 'AnswerForm').show();
        });
    });
</script>

@endsection
