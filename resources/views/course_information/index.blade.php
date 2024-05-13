@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

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
                        <li class="breadcrumb-item"><a href="#">Course Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Employee Information Registration</li>
                    </ol>
                </nav>
                <div class="card">
                    <div id="courseregistration" class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Registration</b></div>
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
                                <div style="display: inline-block; width: 100%;">
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

                            <div id="textbookinformation" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue">Teaching Material Information</b></div>
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
                            </div>
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
                                <input type="text" name="test_passed_score" id="test_passed_score" class="form-control" placeholder="xx.xx" style="width: 20%"><p>Complete the course with % or more correct</p>
                            </div>
                            {{-- <div align="left">
                                <button class="btn btn-warning" title="*If ToDo type is survey response">※ToDo種別がアンケート回答の場合</button>
                            </div><br> --}}
                            {{-- <div class="card-header" style="background-color: #F7F7F7" align="center"><b style="color:black"> Question</b></div><br><br> --}}
                            <div align="center" id="save-course">
                                <button type="submit" class="btn btn-info"><i class="fas fa-sent"></i> Save Course</button>
                                <button type="reset" class="btn btn-secondary"> Delete</button>
                            </div>
                        </form>
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

@section('scripts')
<!-- Script DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Script for Modals -->
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

        $('input[type=radio][name=material_type]').change(function() {
            if (this.value === 'Video') {
                $('#videoFields').show();
                $('#booksFields').hide();
            } else if (this.value === 'Books') {
                $('#videoFields').hide();
                $('#booksFields').show();
            }
        });
    });
</script>

@endsection
