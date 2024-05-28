@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Course Information</div>
                <span>basic information</span>
                <div class="card-body">
                    <form method="POST" action="{{ route('course-information.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="course_classification_id">Course Classification : <b style="color: red">*</b></label>
                            <select class="form-control" id="course_classification_id" name="course_classification_id" required>
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
                            <input id="coursename" type="text" class="form-control" name="coursename" required>
                        </div>
                        <div class="form-group">
                            <label for="coursename_kana">Course Name (Kana) :</label>
                            <input type="text" name="coursename_kana" id="coursename_kana" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="course_description">Course Description : <b style="color: red">*</b></label>
                            <textarea name="course_description" id="course_description" cols="10" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="possible_retake_course_deadline">Retaking the course within the course deadline : <b style="color: red">*</b></label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible" value="Re-attendance possible" required>
                                    <label for="re_attendance_possible"> Re-attendance possible</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" name="possible_retake_course_deadline" id="re_attendance_not_allowed" value="Re-attendance not allowed" required>
                                    <label for="re_attendance_not_allowed"> Re-attendance not allowed</label>
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
    </div>
</div>
@endsection
