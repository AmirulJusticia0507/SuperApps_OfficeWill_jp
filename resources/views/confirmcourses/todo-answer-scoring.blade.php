@extends('layouts.app')

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
                    <li class="breadcrumb-item"><a href="{{ route('course-inquiry') }}">Attendance</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-inquiry') }}">Post-course ToDo</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Scoring</li>
                </ol>
            </nav>
            <div id="courseRegistrationWrap">
                <form action="{{ route('confirm-courses.todo-answer.store', $scheduleResultCourse->course->course_id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $scheduleResultCourse->course->course_id }}">
                    <input type="hidden" name="attendance_settings_id"
                        value="{{ $scheduleResultCourse->attendance_setting_id }}">
                    <input type="hidden" name="todo_type" value="{{ $scheduleResultCourse->course->todo_type }}">
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
                                                <div class="col">
                                                    {{ $scheduleResultCourse->course->classification->course_classification_name }}
                                                </div>
                                                <div class="col">
                                                    {{ $scheduleResultCourse->course->classification_detail->course_classification_detailsname }}
                                                </div>
                                            </div>
                                            <a
                                                href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}">{{ $scheduleResultCourse->course->coursename }}</a>
                                        </td>
                                        <td>{{ $scheduleResultCourse->deadline_enrollment }}</td>
                                        <td>{{ $scheduleResultCourse->todo_progress_text }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="survey_response" class="card-header" style="background-color: #92CDFC">
                            <div class="row">
                                <div class="col"><b style="color:aliceblue"> Scoring results </b></div>
                            </div>
                        </div>
                        <div class="card-body">


                            <div class="row">
                                <div class="col-md-4">Test pass/fail</div>
                                <div class="col-md-8">failure</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Number of questions
                                </div>
                                <div class="col-md-8">
                                    {{ $scheduleResultCourse->number_test_conducted }} questions
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">The number of correct answers
                                </div>
                                <div class="col-md-8">{{ $scheduleResultCourse->latest_test_number_correct_answer }} questions</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Correct answer rate
                                </div>
                                <div class="col-md-8">{{ $scheduleResultCourse->latest_test_accuracy_rate }}%</div>
                            </div>
                            <div class="mt-3">
                                <a class="btn btn-secondary btn-sm"
                                    href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}">Return
                                    to class</a>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div id="survey_response" class="card-header" style="background-color: #92CDFC">
                            <div class="row">
                                <div class="col"><b style="color:aliceblue"> Test explanation </b></div>
                            </div>
                        </div>
                        <div class="card-body" x-data="{{ $dataTodoAnswer }}">
                            <template x-for="(todo, index) in todos" :key="index">
                                <div class="row mb-3">
                                    <div class="col"><span x-text="index+1"></span></div>
                                    <div class="col-11">
                                        <div class="mb-2"><span x-text="todo.question"></span></div>
                                        <div class="mb-2">
                                            <input type="hidden" x-model="todo.todo_item_id"
                                                x-bind:name="`todo[${index}][todo_item_id]`">
                                            <input type="hidden" x-model="todo.answer_type"
                                                x-bind:name="`todo[${index}][answer_type]`">
                                            <template x-if="todo.answer_type == '1'">
                                                <textarea x-model="answer[index].text_answer" x-bind:name="`todo[${index}][choices_text]`" class="form-control"></textarea>
                                            </template>
                                            <template x-if="todo.answer_type == '2'">
                                                <template x-for="(choice, choiceIndex) in todo.choices"
                                                    :key="choiceIndex">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input x-model="answer[index].choice"
                                                                x-bind:name="`todo[${index}][choices]`"
                                                                class="form-check-input" type="radio"
                                                                :value="choice
                                                                    .todo_option_id"
                                                                title="Books" required>
                                                            &emsp;<span x-text="choice.choices"></span></label>
                                                    </div>
                                                </template>
                                            </template>
                                            <template x-if="todo.answer_type == '3'">
                                                <template x-for="(choice, choiceIndex) in todo.choices"
                                                    :key="choiceIndex">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input x-model="answer[index].choice"
                                                                x-bind:name="`todo[${index}][choices]`"
                                                                class="form-check-input" type="checkbox"
                                                                :value="choice.todo_option_id" title="Books" required>
                                                            &emsp;<span x-text="choice.choices"></span></label>
                                                    </div>
                                                </template>
                                            </template>
                                            <template x-if="todo.answer_type == '4'">
                                                <select x-model="answer[index].choice"
                                                    x-bind:name="`todo[${index}][choices]`" class="form-control">
                                                    <option value="">-</option>
                                                    <template x-for="(choice, choiceIndex) in todo.choices"
                                                        :key="choiceIndex">
                                                        <option :value="choice.todo_option_id" x-text="choice.choices">
                                                        </option>
                                                    </template>
                                                </select>
                                            </template>
                                        </div>
                                        <template
                                            x-if="answer[index].choice && todo.choices.find((e) => e.todo_option_id == answer[index].choice).choices == 'others';">
                                            <textarea x-model="answer[index].text_answer" x-bind:name="`todo[${index}][text_answer]`" class="form-control"></textarea>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <div class="text-center">
                                <button type="submit" class="btn btn-info save-confirm" data-save="0"
                                    data-confirm-title="Post-class To-Do"
                                    data-confirm-html="The input information is temporarily saved.<br>is this good?">retest</button>
                                <button type="submit" class="btn btn-info save-confirm" data-save="0"
                                    data-confirm-title="Post-class To-Do"
                                    data-confirm-html="The input information is temporarily saved.<br>is this good?">complete</button>
                  
                            </div>

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
                        <a href="#curse" title="course"><b style="color:aliceblue">
                                コース一覧
                            </b></a>
                    </li>
                    <li class="list-group-item" style="background-color: darkblue">
                        <a href="#attending_course" title="Employees attending the course"><b style="color:aliceblue">
                                社員一覧
                            </b></a>
                    </li>
                    <li class="list-group-item" style="background-color: #92CDFC">
                        <a href="#survey_response" title="Survey responses"><b style="color:aliceblue"> 回答トップ
                            </b></a>
                    </li>

                </ul>
            </div>
        </div>

    </div>

    <!-- Footer -->
    @include('includes.footer')
@endsection
