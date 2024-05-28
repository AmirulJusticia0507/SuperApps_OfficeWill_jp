@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    .sticky-list-group {
        position: sticky;
        top: 10px;
        /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
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
            <div id="courseRegistrationWrap" class="card" x-data="{ todo_type: '' }">
                <form action="{{ route('course-information.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="courseregistration" class="card-header" style="background-color: darkblue">
                        <div class="row">
                            <div class="col"><b style="color:aliceblue" title="Course information registration">コース情報登録</b></div>
                            <div class="col">
                                <div class="text-right"><a class="btn btn-light btn-sm" href="#">Use of existing
                                        courses</a>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- <form method="POST" action="{{ route('course-information.store') }}" enctype="multipart/form-data"> --}}

                    <div id="basicinformation" class="card-header" style="background-color: #92CDFC;border-radius:0;"><b
                            style="color:aliceblue">
                            basic information</b></div>
                    <div class="card-body">
                        @csrf

                        <div class="form-group">
                            <label for="course_classification_id" style="display: inline-block; width: 30%;">コース分類
                                :</label><b style="color: red">*</b>
                            <select class="form-control" id="course_classification_id" name="course_classification_id"
                                required style="display: inline-block; width: 60%;" title="Course Classification"
                                onchange="loadCourseAttribute(this)">
                                <option value="">Select Course Classification</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}">
                                        {{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course_classification_details_id" style="display: inline-block; width: 30%;">コース分類詳細
                                :</label>
                            <select class="form-control" id="course_classification_details_id"
                                name="course_classification_details_id" style="display: inline-block; width: 60%;"
                                title="Classification Detail">
                                <option value="">Select Course Classification Detail</option>
                                @foreach ($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}">
                                        {{ $detail->course_classification_detailsname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="coursename" style="display: inline-block; width: 30%;">コース名 : </label><b
                                style="color: red">*</b>
                            <input id="coursename" type="text" class="form-control" name="coursename"
                                value="{{ isset($course) ? $course->coursename : '' }}" required
                                style="display: inline-block; width: 60%;" title="Course Name">
                        </div>

                        <div class="form-group">
                            <label for="coursename_kana" style="display: inline-block; width: 30%;">コース名カナ :</label>
                            <input type="text" name="coursename_kana" id="coursename_kana" class="form-control"
                                style="display: inline-block; width: 60%;" title="Course Name (Kana)">
                        </div>

                        <div class="form-group">
                            <label for="course_description" style="display: inline-block; width: 30%;">コース説明 : <b
                                    style="color: red">*</b></label>
                            <textarea name="course_description" id="course_description" class="form-control" cols="5" rows="5" required
                                style="display: inline-block; width: 60%;" title="Course Description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="possible_retake_course_deadline"
                                style="display: inline-block; width: 30%;">受講期限内の再受講
                                :<b style="color: red">*</b></label>
                            <div style="display: inline-block; width: 60%;">
                                <input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible"
                                    value="1" required title="Re-attendance possible">
                                <label for="re_attendance_possible"
                                    style="margin-right: 5px; margin-left: 5px;">再受講可</label>
                                <input type="radio" name="possible_retake_course_deadline"
                                    id="re_attendance_not_allowed" value="2" required
                                    title="Re-attendance not allowed">
                                <label for="re_attendance_not_allowed"
                                    style="margin-right: 10px; margin-left: 5px;">再受講不可</label>
                            </div>
                        </div>

                        <div id="attributeWrapper"></div>
                        <div class="form-group">
                            <label for="remarks" style="display: inline-block; width: 30%;">備考 :</label>
                            <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control"
                                style="display: inline-block; width: 60%;" title="Remarks"></textarea>
                        </div>
                    </div>



                    <div id="textbookinformation" class="card-header" style="background-color: #92CDFC"><b
                            style="color:aliceblue">教材情報</b></div>
                    <div class="card-body" x-sort x-data="{ fields: [{ teaching_material_name: '', material_type: '' }] }">
                        <template x-for="(field, index) in fields" :key="index">
                            <div x-sort:item x-data="{ movie: false, book: false }">
                                <div x-sort:handle class="card-header" style="background-color: #F7F7F7">
                                    <div class="row">
                                        <div class="col row justify-content-center">
                                            <b style="color:black">教
                                                材</b>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-right">
                                                <button class="btn btn-light btn-sm" href="#"
                                                    x-on:click="fields.push('')">addition</button>
                                                <button class="btn btn-secondary btn-sm" href="#"
                                                    x-show="fields.length > 1"
                                                    x-on:click="fields.splice(index, 1)">delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="Teaching Material Name"
                                        class="col-sm-2 col-form-label required">教材名</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            x-bind:name="`teaching_material[${index}][teaching_material_name]`"
                                            title="Teaching Material Name" required class="form-control"
                                            x-model="fields[index].teaching_material_name">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="material_type" class="col-sm-2 col-form-label required">教材種別</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input x-on:click="movie = true;book=false"
                                                    x-model="fields[index].material_type" class="form-check-input"
                                                    type="radio"
                                                    x-bind:name="`teaching_material[${index}][material_type]`"
                                                    value="1" title="Video" required>
                                                &emsp;動画</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input x-on:click="movie = false;book=true"
                                                    x-model="fields[index].material_type" class="form-check-input"
                                                    type="radio"
                                                    x-bind:name="`teaching_material[${index}][material_type]`"
                                                    value="2" title="Books" required>
                                                &emsp;書籍</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" x-show="movie">
                                    <label for="youtube_video_url" class="col-sm-2 col-form-label required">動画URL</label>
                                    <div class="col-sm-10">
                                        <input type="url" x-model="fields[index].youtube_video_url"
                                            x-bind:name="`teaching_material[${index}][youtube_video_url]`"
                                            title="Video URL" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row" x-show="book">
                                    <label for="book_file_path" class="col-sm-2 col-form-label required">書籍ファイル</label>
                                    <div class="col-sm-10">
                                        <input type="file" x-model="fields[index].bookfile"
                                            x-bind:name="`teaching_material[${index}][bookfile]`" class="form-control"
                                            title="Book File">
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                    <div id="posttodo" class="card-header" style="background-color: #92CDFC;border-radius:0;"><b
                            style="color:aliceblue">
                            受講後ToDo</b></div>
                    <div class="card-body" x-data="{ fields: [{ question: '', answer_type: 'text', answer_type: '' }] }">
                        <div class="mb-3">
                            <div style="display: flex; align-items: center;">
                                <label for="todo_type" style="margin-right: 10px;" style="width: 100%">ToDo種別: <b
                                        style="color: red">*</b></label>
                                <div style="display: flex;">
                                    <input type="radio" x-model="todo_type" x-bind:name="`todo_type`"
                                        id="survey_answers" value="1" title="Survey answers" required>
                                    <label for="survey_answers" style="margin-right: 10px;">&emsp;アンケート回答</label>
                                    <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="tests"
                                        value="2" title="Tests" required>
                                    <label for="tests" style="margin-right: 10px;">&emsp;テスト</label>
                                    <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="reports"
                                        value="3" title="Reports" required>
                                    <label for="reports" style="margin-right: 10px;">&emsp;レポート</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="todo_description">ToDo説明 : <b style="color: red">*</b></label>
                            <textarea name="todo_description" id="todo_description" cols="5" rows="5" class="form-control"
                                title="ToDo Description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <div style="display: flex; align-items: center;">
                                <label for="sex" style="margin-right: 10px;" style="width: 100%">再テスト有無: <b
                                        style="color: red">*</b></label>
                                <div style="display: flex;">
                                    <input type="radio" name="repeated_retest" id="retest_availability" value="1"
                                        title="Retest availability" required>
                                    <label for="retest_availability" style="margin-right: 10px;">&emsp;再テストあり</label>
                                    <input type="radio" name="repeated_retest" id="no_retest_availability"
                                        value="2" title="No Retest Availability" required>
                                    <label for="no_retest_availability" style="margin-right: 10px;">&emsp;再テストなし</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="test_passed_score">テスト合格閾値 :</label>
                            <input type="text" name="test_passed_score" id="test_passed_score" class="form-control"
                                placeholder="xx.xx" pattern="[0-9]" style="display: inline-block; width: 10%;"
                                title="Test Pass Threshold">
                            <p>% 以上の正解で受講修了</p>
                        </div>


                        <div class="todo-question-wrapper">
                            <template x-if="todo_type=='1' || todo_type=='2'" x-sort class="todo-question ">
                                <template x-for="(field, index) in fields" :key="index">
                                    <div x-sort:item x-data="{ options: [{ correct_answer: 0, option: '' }], others: [{ correct_answer: 0, other: '' }] }">
                                        <div x-sort:handle class="card-header" style="background-color: #F7F7F7">
                                            <div class="row">
                                                <div class="col row justify-content-center">
                                                    <b style="color:black">Question</b>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-right">
                                                        <button class="btn btn-light btn-sm" href="#"
                                                            x-on:click="index == (fields.length-1) ? fields.push('') :  fields.splice(index, 0, '')">addition</button>
                                                        <button class="btn btn-light btn-sm" href="#"
                                                            x-on:click="fields.splice(index, 0, '')">copy</button>
                                                        <button class="btn btn-secondary btn-sm" href="#"
                                                            x-show="fields.length > 1"
                                                            x-on:click="fields.splice(index, 1)">delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <label for="Question"
                                                class="col-sm-2 col-form-label required">question</label>
                                            <div class="col-sm-6">
                                                <textarea x-bind:name="`todo[${index}][question]`" title="Question" required class="form-control"
                                                    x-model="fields[index].question"rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label for="Answer type" class="col-sm-5 col-form-label ">Answer
                                                        type</label>
                                                    <div class="col-sm-7">
                                                        <select x-model="fields[index].answer_type"
                                                            x-bind:name="`todo[${index}][answer_type]`"
                                                            class="custom-select custom-select-sm">
                                                            <option value="1" selected>Text</option>
                                                            <option value="2">Radio</option>
                                                            <option value="3">Checkbox</option>
                                                            <option value="4">Dropdown</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Answer type" class="col-sm-5 col-form-label ">Answer
                                                        input</label>
                                                    <div class="col-sm-7">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input x-model="fields[index].answer_input"
                                                                    class="form-check-input" type="radio"
                                                                    x-bind:name="`todo[${index}][answer_input]`"
                                                                    class="custom-control-input" value="1">
                                                                Required</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input x-model="fields[index].answer_input"
                                                                    class="form-check-input" type="radio"
                                                                    x-bind:name="`todo[${index}][answer_input]`"
                                                                    class="custom-control-input" value="2">
                                                                Optional</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        {{-- Radio --}}
                                        <template x-if="fields[index].answer_type == '2'">
                                            <div><template x-for="(option, optionIndex) in options"
                                                    :key="optionIndex">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="d-flex justify-content-end align-items-center h-100">
                                                                <input x-model="options[optionIndex].correct_answer"
                                                                    class="form-check-input" type="radio"
                                                                    x-bind:name="`todo[${index}][correct_answer]`"
                                                                    class="custom-control-input">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" x-model="options[optionIndex].option"
                                                                x-bind:name="`todo[${index}][option][${optionIndex}]`"
                                                                title="Option" class="form-control"
                                                                placeholder="(Option)">

                                                        </div>
                                                        <div class="col-sm-1 pl-0">
                                                            <button
                                                                x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="javascript:void(0);"
                                                            x-on:click="options.push({correct_answer : options.length, option: ''})">Add
                                                            choice</a>
                                                        <span x-show="todo_type=='1'">
                                                            or
                                                            <a href="javascript:void(0);"
                                                                x-on:click="others.push({correct_answer : others.length, other : '1'})">Add
                                                                "Other"</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <template x-if="todo_type=='1'">
                                                    <template x-for="(other, otherIndex) in others"
                                                        :key="otherIndex">
                                                        <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center h-100">
                                                                    <input x-model="others[otherIndex].correct_answer"
                                                                        class="form-check-input" type="radio"
                                                                        x-bind:name="`todo[${index}][correct_answer]`"
                                                                        class="custom-control-input">

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 ">
                                                                <p>others</p>
                                                                <input type="hidden" x-model="others[otherIndex].other"
                                                                    x-bind:name="`todo[${index}][other][${otherIndex}]`">
                                                            </div>
                                                            <div class="col-sm-1 pl-0">
                                                                <button
                                                                    x-on:click="confirm('Are you sure?') ? others.splice(otherIndex, 1) : false"
                                                                    type="button">X</button>

                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template x-if="todo_type=='2'">
                                                    <div class="form-group row">
                                                        <label for="explanation"
                                                            class="col-sm-2 col-form-label required">Explanation</label>
                                                        <div class="col-sm-6">
                                                            <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="form-control"
                                                                x-model="fields[index].explanation"rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        {{-- Checkbox --}}
                                        <template x-if="fields[index].answer_type == '3'">
                                            <div><template x-for="(option, optionIndex) in options"
                                                    :key="optionIndex">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="d-flex justify-content-end align-items-center h-100">
                                                                <input x-model="options[optionIndex].correct_answer"
                                                                    class="form-check-input" type="checkbox"
                                                                    x-bind:name="`todo[${index}][correct_answer]`"
                                                                    class="custom-control-input">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 ">
                                                            <input type="text" x-model="options[optionIndex].option"
                                                                x-bind:name="`todo[${index}][option][${optionIndex}]`"
                                                                title="Option" class="form-control"
                                                                placeholder="(Option)">

                                                        </div>
                                                        <div class="col-sm-1 pl-0">
                                                            <button
                                                                x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">

                                                    </div>
                                                    <div class="col-sm-10">
                                                        <a href="javascript:void(0);"
                                                            x-on:click="options.push({correct_answer : options.length, option: ''})">Add
                                                            choice</a>
                                                        <span x-show="todo_type=='1'">
                                                            or
                                                            <a href="javascript:void(0);"
                                                                x-on:click="others.push({correct_answer : others.length, other : '1'})">Add
                                                                "Other"</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <template x-if="todo_type=='1'">
                                                    <template x-for="(other, otherIndex) in others"
                                                        :key="otherIndex">
                                                        <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center h-100">
                                                                    <input x-model="others[otherIndex].correct_answer"
                                                                        class="form-check-input" type="checkbox"
                                                                        x-bind:name="`todo[${index}][correct_answer]`"
                                                                        class="custom-control-input">

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p>others</p>
                                                                <input type="hidden" x-model="others[otherIndex].other"
                                                                    x-bind:name="`todo[${index}][other][${otherIndex}]`">
                                                            </div>
                                                            <div class="col-sm-1 pl-0">
                                                                <button
                                                                    x-on:click="confirm('Are you sure?') ? others.splice(otherIndex, 1) : false"
                                                                    type="button">X</button>

                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template x-if="todo_type=='2'">
                                                    <div class="form-group row">
                                                        <label for="explanation"
                                                            class="col-sm-2 col-form-label required">Explanation</label>
                                                        <div class="col-sm-6">
                                                            <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="form-control"
                                                                x-model="fields[index].explanation"rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        {{-- Dropdown --}}
                                        <template x-if="fields[index].answer_type == '4'">
                                            <div><template x-for="(option, optionIndex) in options"
                                                    :key="optionIndex">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="d-flex justify-content-end align-items-center h-100">
                                                                {{-- <input x-model="options[optionIndex].correct_answer"
                                                                class="form-check-input" type="radio"
                                                                x-bind:name="`todo[${index}][correct_answer]`"
                                                                class="custom-control-input"> --}}

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" x-model="options[optionIndex].option"
                                                                x-bind:name="`todo[${index}][option][${optionIndex}]`"
                                                                title="Option" class="form-control"
                                                                placeholder="(Option)">

                                                        </div>
                                                        <div class="col-sm-1 pl-0">
                                                            <button
                                                                x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="javascript:void(0);"
                                                            x-on:click="options.push({correct_answer : options.length, option: ''})">Add
                                                            choice</a>
                                                    </div>
                                                </div>
                                                <template x-if="todo_type=='2'">
                                                    <div class="form-group row">
                                                        <label for="explanation"
                                                            class="col-sm-2 col-form-label required">Explanation</label>
                                                        <div class="col-sm-6">
                                                            <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="form-control"
                                                                x-model="fields[index].explanation"rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                </template>
                            </template>
                        </div>

                        <div class="row" id="save-course">
                            <div class="col d-flex justify-content-center">
                                <button type="submit" class="btn btn-info" title="Save Course"><i
                                        class="fas fa-sent"></i>
                                    コースを保存する</button>
                            </div>

                            <div class="col-auto"> <button type="reset" class="btn btn-secondary"
                                    title="Delete a course"> コースを削除する</button></div>
                        </div>
                    </div>


                </form>
            </div>
        </div>

        <!-- List of Links and Buttons -->
        <div class="col-md-2">
            <br><br><br><br><br>
            <div class="mt-2 sticky-list-group">
                <ul class="list-group">
                    <li class="list-group-item" style="background-color: darkblue">
                        <a href="{{ route('course-list') }}" title="Course list"><b style="color:aliceblue">
                                コース一覧</b></a>
                    </li>
                    <li class="list-group-item" style="background-color: darkblue">
                        <a href="#courseregistration" title="Course registration"><b style="color:aliceblue">
                                コース登録トップ</b></a>
                    </li>
                    <li class="list-group-item" style="background-color: #92CDFC">
                        <a href="#basicinformation" title="Basic information"><b style="color:aliceblue"> 基本情報</b></a>
                    </li>
                    <li class="list-group-item" style="background-color: #92CDFC">
                        <a href="#textbookinformation" title="Textbook information"><b style="color:aliceblue">
                                教材情報</b></a>
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
        <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel"
            aria-hidden="true">
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
                                        <input type="text" class="form-control" id="questionText" name="questionText"
                                            placeholder="questionaire" required title="Question">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answerType">答タイプ:</label>
                                        <select class="form-control" id="answerType" name="answerType"
                                            title="Answer Type" required>
                                            <option value="text">Text</option>
                                            <option value="radio">Radio Button</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="select">Selectbox</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="isRequired">答入力:</label><br>
                                        <input type="radio" id="isRequiredYes" name="isRequired" value="yes"
                                            title="required" required>
                                        <label for="isRequiredYes">必須</label>
                                        <input type="radio" id="isRequiredNo" name="isRequired" value="no"
                                            title="Optional" required>
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
                                    <input type="text" class="form-control" id="radioOptions" name="radioOptions"
                                        placeholder="Option 1, Option 2, Option 3, ...">
                                </div>
                            </div>

                            <!-- Formulir untuk jawaban Checkbox -->
                            <div id="checkboxAnswerForm" class="answerForm" style="display: none;">
                                <div class="form-group">
                                    <label for="checkboxOptions">Checkbox Options:</label>
                                    <input type="text" class="form-control" id="checkboxOptions"
                                        name="checkboxOptions" placeholder="Option 1, Option 2, Option 3, ...">
                                </div>
                            </div>

                            <!-- Formulir untuk jawaban Selectbox -->
                            <div id="selectAnswerForm" class="answerForm" style="display: none;">
                                <div class="form-group">
                                    <label for="selectOptions">Selectbox Options:</label>
                                    <input type="text" class="form-control" id="selectOptions" name="selectOptions"
                                        placeholder="Option 1, Option 2, Option 3, ...">
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
        $(document).ready(function() {
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
