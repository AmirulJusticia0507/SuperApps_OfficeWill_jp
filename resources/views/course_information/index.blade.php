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
            {{-- <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Course Information</div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="courseTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->course_id }}</td>
                                    <td>{{ $course->coursename }}</td>
                                    <td>
                                        <a href="{{ route('course-information.edit', $course->course_id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('course-information.destroy', $course->course_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-4">
                <br><br><br>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Registration</b></div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($course) ? route('course-information.update', $course->course_id) : route('course-information.store') }}">
                            @csrf
                            @if(isset($course))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="course_classification_id">Course Classification : <b style="color: red">*</b></label>
                                <select class="form-control" id="course_classification_id" name="Course_classification_id" required>
                                    @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="course_classification_details_id">Classification Detail :</label>
                                <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required>
                                    @foreach($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="coursename">Course Name : <b style="color: red">*</b></label>
                                <input id="coursename" type="text" class="form-control" name="coursename" value="{{ isset($course) ? $course->coursename : '' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="coursename_kana">Course Name (Kana) :</label>
                                <input type="text" name="coursename_kana" id="coursename_kana" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="course_description">Course Description : <b style="color: red">*</b></label>
                                <textarea name="course_description" id="course_description" class="form-control" cols="5" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="possible_retake_course_deadline">Retaking the course within the course deadline : <b style="color: red">*</b></label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="possible_retake_course_deadline" id="re_attendance_possible" value="Re-attendance possible" required>
                                            <label class="form-check-label" for="re_attendance_possible"> Re-attendance possible</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="possible_retake_course_deadline" id="re_attendance_not_allowed" value="Re-attendance not allowed" required>
                                            <label class="form-check-label" for="re_attendance_not_allowed"> Re-attendance not allowed</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="course_attributes_01">(Course attribute 01) :</label>
                                <select name="course_attributes_01" id="course_attributes_01">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_02">(Course attribute 02) :</label>
                                <select name="course_attributes_02" id="course_attributes_02">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_03">(Course attribute 03) :</label>
                                <select name="course_attributes_03" id="course_attributes_03">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_04">(Course attribute 04) :</label>
                                <select name="course_attributes_04" id="course_attributes_04">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_attributes_05">(Course attribute 05) :</label>
                                <select name="course_attributes_05" id="course_attributes_05">
                                    <option value="-"> </option>
                                    <option value=""> </option>
                                    <option value=""> </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks :</label>
                                <textarea name="remarks" id="remarks" cols="10" rows="10" class="form-control"></textarea>
                            </div>
                            <span>Post-course ToDo</span>
                            <div class="form-group">
                                <label for="todo_type">ToDo type : <b style="color: red">*</b></label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="radio" name="todo_type" id="survey_answers" value="Survey answers" required>
                                        <label for="survey_answers"> Survey answers</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" name="todo_type" id="tests" value="Tests" required>
                                        <label for="tests"> Tests</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" name="todo_type" id="reports" value="Reports" required>
                                        <label for="reports"> Reports</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="todo_description">ToDo Description : <b style="color: red">*</b></label>
                                <textarea name="todo_description" id="todo_description" cols="10" rows="10" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="repeated_retest">Retest availability : <b style="color: red">*</b></label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="radio" name="repeated_retest" id="retest_availability" value="Retest availability" required>
                                        <label for="retest_availability"> Retest availability</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" name="repeated_retest" id="no_retest_availability" value="No retest availability" required>
                                        <label for="no_retest_availability"> No retest availability</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="test_passed_score">Test Pass Threshold :</label>
                                <input type="text" name="test_passed_score" id="test_passed_score" class="form-control"><p>Complete the course with % or more correc</p>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="fas fa-sent"></i> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- List of Links and Buttons -->
            <div class="col-md-3">
                <br><br><br>
                <div class="mt-2">
                    <ul class="list-group">
                        <li class="list-group-item" style="background-color: darkblue"><a href="#"><b style="color:aliceblue"> コース一覧</b></a></li>
                        <li class="list-group-item" style="background-color: darkblue"><a href="#"><b style="color:aliceblue">  コース登録トップ</b></a></li>
                        <li class="list-group-item" style="background-color: #92CDFC"><a href="#"><b style="color:aliceblue"> 基本情報</b></a></li>
                        <li class="list-group-item" style="background-color: #92CDFC"><a href="#"><b style="color:aliceblue"> 教材情報</b></a></li>
                        <li class="list-group-item" style="background-color: #92CDFC"><a href="#"><b style="color:aliceblue"> 受講後ToDo</b></a></li>
                        <li class="list-group-item" style="background-color: darkblue"><a href=""><b style="color:aliceblue"> コース保存</b></a></li>
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
        });
</script>
@endsection
