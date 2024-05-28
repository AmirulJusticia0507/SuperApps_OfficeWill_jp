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
                    <li class="breadcrumb-item"><a href="{{ route('course-inquiry') }}">コース固有の問い合わせ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ToDo answer inquiry after taking the course</li>
                </ol>
            </nav>
            <div id="courseRegistrationWrap" class="card" x-data={}>
                <form action="{{ route('course-todo-answer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                    <div id="curse" class="card-header" style="background-color: darkblue">
                        <div class="row">
                            <div class="col"><b style="color:aliceblue"> course</b></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">Course Classification</div>
                            <div class="col-md-8">{{ $course->classification->course_classification_name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Course classification details
                            </div>
                            <div class="col-md-8">{{ $course->classification_detail->course_classification_detailsname }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Course Name
                            </div>
                            <div class="col-md-8">{{ $course->coursename }}</div>
                        </div>

                    </div>
                    <div id="attending_course" class="card-header" style="background-color: darkblue">
                        <div class="row">
                            <div class="col"><b style="color:aliceblue"> Employees attending the course</b></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">Affiliation name</div>
                            <div class="col-md-8">{{ $employee->employee_affiliation->affiliation->affiliation_name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Job title
                            </div>
                            <div class="col-md-8">{{ $employee->employee_affiliation->job->job_title }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">full name
                            </div>
                            <div class="col-md-8">{{ $employee->fullname }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">employee code
                            </div>
                            <div class="col-md-8">{{ $employee->employee_code }}</div>
                        </div>

                    </div>
                    <div id="survey_response" class="card-header" style="background-color: darkblue">
                        <div class="row">
                            <div class="col"><b style="color:aliceblue"> Survey responses </b></div>
                        </div>
                    </div>

                    <div class="card-body" x-data="{{ $dataTodoAnswer }}">
                        <template x-for="(todo, index) in todos" :key="index">
                            <div class="row mb-3">
                                <div class="col"><span x-text="index+1"></span></div>
                                <div class="col-11">
                                    <div class="mb-2"><span x-text="todo.question"></span></div>
                                    <div class="mb-2"><template x-if="todo.answer_type == 1">
                                            <textarea name="" id="" class="form-control"></textarea>
                                        </template>
                                        <template x-if="todo.answer_type == 2">
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input x-model="answer[index].choice"
                                                            x-bind:name="`todo[${index}][choices]`" class="form-check-input"
                                                            type="radio"
                                                            :value="choice.choices == 'others' ? 'others' : choice
                                                                .todo_option_id"
                                                            title="Books" required>
                                                        &emsp;<span x-text="choice.choices"></span></label>
                                                </div>

                                            </template>
                                        </template>
                                        <template x-if="todo.answer_type == 3">
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input x-model="answer[index].choice"
                                                            x-bind:name="`todo[${index}][choices]`" class="form-check-input"
                                                            type="checkbox" :value="choice.todo_option_id" title="Books"
                                                            required>
                                                        &emsp;<span x-text="choice.choices"></span></label>
                                                </div>
                                            </template>
                                        </template>
                                        <template x-if="todo.answer_type == 4">
                                            <select x-model="answer[index].choice" x-bind:name="`todo[${index}][choices]`"
                                                class="form-control">
                                                <option value="">-</option>
                                                <template x-for="(choice, choiceIndex) in todo.choices"
                                                    :key="choiceIndex">
                                                    <option :value="choice.todo_option_id" x-text="choice.choices">
                                                    </option>
                                                </template>
                                            </select>
                                        </template>
                                    </div>
                                    <template x-if="answer[index].choice == 'others'">
                                        <textarea x-model="answer[index].choice_text" x-bind:name="`todo[${index}][choices_text]`" class="form-control"></textarea>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <div class="text-center"><button type="submit" class="btn btn-info">Submit</button></div>

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
