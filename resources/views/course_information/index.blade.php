@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    .sticky-list-group {
        position: sticky;
        top: 10px; /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
    }
</style>

@section('content')
<!-- Header -->
@include('includes.header')
<!-- <div class="container"> -->
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
            <div class="col-md-6">
                <br><br>
                <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">コース登録</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('course-list') }}">コース一覧</a></li>
                                <li class="breadcrumb-item active" aria-current="page">コース情報登録</li>
                            </ol>
                        </nav>
                        <div class="card">
                            <div id="courseregistration" class="card-header" style="background-color: darkblue"><b style="color:aliceblue">コース情報登録</b></div>
                            <div class="card-body">
                                    <form method="POST" action="{{ route('course-information.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="company_id" style="display: inline-block; width: 30%;">会社名 :</label>&nbsp;&nbsp;
                                            <select class="form-control" id="company_id" name="company_id" style="display: inline-block; width: 60%;" title="Company">
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="course_classification_id" style="display: inline-block; width: 30%;">コース分類 :</label><b style="color: red">*</b>
                                            <select class="form-control" id="course_classification_id" name="course_classification_id" required style="display: inline-block; width: 60%;" title="Course Classification">
                                                @foreach($classifications as $classification)
                                                <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="course_classification_details_id" style="display: inline-block; width: 30%;">コース分類詳細 :</label><b style="color: red">*</b>
                                            <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required style="display: inline-block; width: 60%;" title="Classification Detail">
                                                @foreach($details as $detail)
                                                <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="coursename" style="display: inline-block; width: 30%;">コース名 : </label><b style="color: red">*</b>
                                            <input id="coursename" type="text" class="form-control" name="coursename" value="{{ old('coursename') }}" required style="display: inline-block; width: 60%;" title="Course Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="coursename_kana" style="display: inline-block; width: 30%;">コース名カナ :</label>
                                            <input type="text" name="coursename_kana" id="coursename_kana" class="form-control" style="display: inline-block; width: 60%;" title="Course Name (Kana)">
                                        </div>

                                        <div class="form-group">
                                            <label for="course_description" style="display: inline-block; width: 30%;">コース説明 : <b style="color: red">*</b></label>
                                            <textarea name="course_description" id="course_description" class="form-control" cols="5" rows="5" required style="display: inline-block; width: 60%;" title="Course Description">{{ old('course_description') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="possible_retake_course_deadline" title="Possible Retake Course Deadline" style="display: inline-block; width: 30%;">受講期限内の再受講 :<b style="color: red">*</b></label>
                                            <div style="display: inline-block; width: 60%;">
                                                <input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible" value="Re-attendance possible" required title="Re-attendance possible">
                                                <label for="re_attendance_possible" style="margin-right: 5px; margin-left: 5px;">再受講可</label>
                                                <input type="radio" name="possible_retake_course_deadline" id="re_attendance_not_allowed" value="Re-attendance not allowed" required title="Re-attendance not allowed">
                                                <label for="re_attendance_not_allowed" style="margin-right: 10px; margin-left: 5px;">再受講不可</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="course_attributes_01" style="display: inline-block; width: 30%;">(コース属性01) :</label>
                                            <select name="course_attributes_01" id="course_attributes_01" style="display: inline-block; width: 60%;" class="form-control" title="Course attribute 01">
                                                <option value="-"> </option>
                                                <option value=""> </option>
                                                <option value=""> </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="course_attributes_02" style="display: inline-block; width: 30%;">(コース属性02) :</label>
                                            <input type="text" name="course_attributes_02" id="course_attributes_02" class="form-control" style="display: inline-block; width: 60%;" title="Course attribute 02">
                                        </div>

                                        <div class="form-group">
                                            <label for="course_attributes_03" style="display: inline-block; width: 30%;">(コース属性03) :</label>
                                            <select name="course_attributes_03" id="course_attributes_03" style="display: inline-block; width: 60%;" class="form-control" title="Course attribute 03">
                                                <option value="-"> </option>
                                                <option value=""> </option>
                                                <option value=""> </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="course_attributes_04" style="display: inline-block; width: 30%;">(コース属性04) :</label>
                                            <input type="text" name="course_attributes_04" id="course_attributes_04" class="form-control" style="display: inline-block; width: 60%;" title="Course attribute 04">
                                        </div>

                                        <div class="form-group">
                                            <label for="course_attributes_05" style="display: inline-block; width: 30%;">(コース属性05) :</label>
                                            <select name="course_attributes_05" id="course_attributes_05" style="display: inline-block; width: 60%;" class="form-control" title="Course attribute 05">
                                                <option value="-"> </option>
                                                <option value=""> </option>
                                                <option value=""> </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="remarks" style="display: inline-block; width: 30%;">備考 :</label>
                                            <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control" style="display: inline-block; width: 60%;" title="Remarks"></textarea>
                                        </div>
                                        <div id="posttodo" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue"> 受講後ToDo</b></div>

                                        <div class="mb-3">
                                            <div style="display: flex; align-items: center;">
                                                <label for="todo_type" style="margin-right: 10px;" style="width: 100%">ToDo種別: <b style="color: red">*</b></label>
                                                <div style="display: flex;">
                                                    <input type="radio" name="todo_type" id="survey_answers" value="survey_answers" title="Survey answers" required>
                                                    <label for="survey_answers" style="margin-right: 10px;">&emsp;アンケート回答</label>
                                                    <input type="radio" name="todo_type" id="tests" value="Tests" title="Tests" required>
                                                    <label for="tests" style="margin-right: 10px;">&emsp;テスト</label>
                                                    <input type="radio" name="todo_type" id="reports" value="Reports" title="Reports" required>
                                                    <label for="reports" style="margin-right: 10px;">&emsp;レポート</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="todo_description">ToDo説明 : <b style="color: red">*</b></label>
                                            <textarea name="todo_description" id="todo_description" cols="5" rows="5" class="form-control" title="ToDo Description" required>{{ old('todo_description') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <div style="display: flex; align-items: center;">
                                                <label for="sex" style="margin-right: 10px;" style="width: 100%">再テスト有無: <b style="color: red">*</b></label>
                                                <div style="display: flex;">
                                                    <input type="radio" name="repeated_retest" id="retest_availability" value="Retest Availability" title="Retest availability" required>
                                                    <label for="retest_availability" style="margin-right: 10px;">&emsp;再テストあり</label>
                                                    <input type="radio" name="repeated_retest" id="no_retest_availability" value="No Retest Availability" title="No Retest Availability" required>
                                                    <label for="no_retest_availability" style="margin-right: 10px;">&emsp;再テストなし</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="test_passed_score">テスト合格閾値 :</label>
                                            <input type="text" name="test_passed_score" id="test_passed_score" class="form-control" placeholder="xx.xx" style="display: inline-block; width: 10%;" title="Test Pass Threshold" value="{{ old('test_passed_score') }}">
                                            <p>% 以上の正解で受講修了</p>
                                        </div>

                                        
                                    <div id="textbookinformation" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue">教材情報</b></div>
                                    <div class="card-body">
                                        <div class="card-header" style="background-color: #F7F7F7" align="center"><b style="color:black">教 材</b></div>
                                            <br>
                                            <div class="form-group">
                                                <label for="Teaching Material Name" style="display: inline-block; width: 30%;">教材名 :</label><b style="color: red">*</b>
                                                <input type="text" name="teaching_material_name" id="teaching_material_name" style="display: inline-block; width: 65%;" title="Teaching Material Name" required class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <div style="display: flex; align-items: center;">
                                                    <label for="material_type" style="margin-right: 10px;" style="width: 100%">教材種別:<b style="color: red">*</b></label>
                                                    <div style="display: flex;">
                                                        <input type="radio" name="material_type" id="video" value="Video" title="Video" required>
                                                        <label for="video" style="margin-right: 10px;">&emsp;動画</label>
                                                        <input type="radio" name="material_type" id="books" value="Books" title="Books" required>
                                                        <label for="books" style="margin-right: 10px;">&emsp;書籍</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="videoFields" >
                                                <div class="form-group">
                                                    <label for="youtube_video_url">動画URL: <b style="color: red">*</b></label>
                                                    <input type="url" name="youtube_video_url" id="youtube_video_url" title="Video URL" class="form-control" >
                                                </div>
                                            </div>

                                            <div id="booksFields" >
                                                <div class="form-group">
                                                    <label for="book_file_path">書籍ファイル: <b style="color: red">*</b></label>
                                                    <input type="file" name="bookfile" id="bookfile" class="form-control" title="Book File" >
                                                </div>
                                            </div>
                                            <div align="center">
                                                <button type="submit" class="btn btn-info" title="Save Material"><i class="fas fa-sent"></i> マテリアルの保存</button>
                                            </div>
                                        </form>
                                    </div>
                                <div align="left">
                                    <button class="btn btn-warning" title="*If ToDo type is survey response" data-toggle="modal" data-target="#questionModal">※ToDo種別がアンケート回答の場合</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- List of Links and Buttons -->
                    <div class="col-md-2">
                        <br><br><br><br><br>
                        <div class="mt-2 sticky-list-group">
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
                                                        <label for="questionText">設問:</label>
                                                        <input type="text" class="form-control" id="questionText" name="questionText" placeholder="questionaire" required title="Question">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="answerType">答タイプ:</label>
                                                        <select class="form-control" id="answerType" name="answerType" title="Answer Type" required>
                                                            <option value="text">Text</option>
                                                            <option value="radio">Radio Button</option>
                                                            <option value="checkbox">Checkbox</option>
                                                            <option value="select">Selectbox</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="isRequired">答入力:</label><br>
                                                        <input type="radio" id="isRequiredYes" name="isRequired" value="yes" title="required" required>
                                                        <label for="isRequiredYes">必須</label>
                                                        <input type="radio" id="isRequiredNo" name="isRequired" value="no" title="Optional" required>
                                                        <label for="isRequiredNo">任意</label>
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
<script>
    // JavaScript for handling form submission and showing/hiding fields based on Material Type
$(document).ready(function() {
    // Handle form submission
    $('#teachingMaterialForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        // Collect data from both forms
        var formDataCourse = $('#courseForm').serialize();
        var formDataMaterial = $('#materialForm').serialize();
        // Combine data
        var combinedData = formDataCourse + '&' + formDataMaterial;
        // AJAX request to submit combined data
        $.ajax({
            url: '/submit-data',
            type: 'POST',
            data: combinedData,
            success: function(response) {
                // Handle success response
                alert('Data submitted successfully');
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('Error submitting data');
            }
        });
    });

    // Show/hide fields based on Material Type selection
    $('input[name="material_type"]').change(function() {
        var materialType = $(this).val();
        if (materialType === 'Video') {
            $('#videoFields').show();
            $('#booksFields').hide();
        } else if (materialType === 'Books') {
            $('#videoFields').hide();
            $('#booksFields').show();
        }
    });
});

</script>
@endsection
