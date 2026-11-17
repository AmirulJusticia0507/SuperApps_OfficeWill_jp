@extends('layouts.app')

@section('content')
<style>
    .todo-scoring-page { min-height: 100vh; background: #f4f6f9; }
    .todo-scoring-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .todo-scoring-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .todo-scoring-page__content, body.sidebar-collapsed .todo-scoring-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="todo-scoring-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="todo-scoring-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" class="hover:text-blue-600">{{ __('Course Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-list') }}" class="hover:text-blue-600">{{ __('Course List') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-inquiry') }}" class="hover:text-blue-600">{{ __('Attendance') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-inquiry') }}" class="hover:text-blue-600">{{ __('Post-course ToDo') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page">{{ __('Scoring') }}</li>
            </ol>
        </nav>

        <form action="{{ route('confirm-courses.todo-answer.store', $scheduleResultCourse->course->course_id) }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="course_id" value="{{ $scheduleResultCourse->course->course_id }}">
            <input type="hidden" name="attendance_settings_id" value="{{ $scheduleResultCourse->attendance_setting_id }}">
            <input type="hidden" name="todo_type" value="{{ $scheduleResultCourse->course->todo_type }}">

            <!-- Course Info & Scoring Results -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Course information">
                    {{ __('Course Information') }}
                </div>
                <div class="p-5 overflow-x-auto space-y-4">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%" id="confirmcoursesTable">
                        <thead>
                            <tr>
                                <th title="Course Name">{{ __('Course Name') }}</th>
                                <th title="Deadline for enrollment">{{ __('Deadline for enrollment') }}</th>
                                <th title="ToDo">ToDo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="space-y-0.5 mb-1">
                                        <div class="text-xs text-slate-500">{{ $scheduleResultCourse->course->classification->course_classification_name }}</div>
                                        <div class="text-xs text-slate-600 font-medium">{{ $scheduleResultCourse->course->classification_detail->course_classification_detailsname }}</div>
                                    </div>
                                    <a href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}" class="text-blue-600 hover:underline font-semibold">{{ $scheduleResultCourse->course->coursename }}</a>
                                </td>
                                <td>{{ $scheduleResultCourse->deadline_enrollment }}</td>
                                <td>{{ $scheduleResultCourse->todo_progress_text }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-3.5 bg-blue-100 text-blue-900 font-semibold border-t border-slate-200">
                    {{ __('Scoring results') }}
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Test pass/fail') }}</div>
                        <div class="md:col-span-8 font-semibold text-red-600">{{ __('failure') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Number of questions') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $scheduleResultCourse->number_test_conducted }} {{ __('questions') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('The number of correct answers') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $scheduleResultCourse->latest_test_number_correct_answer }} {{ __('questions') }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Correct answer rate') }}</div>
                        <div class="md:col-span-8 font-semibold text-slate-800">{{ $scheduleResultCourse->latest_test_accuracy_rate }}%</div>
                    </div>
                    <div class="pt-2">
                        <a class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg border border-slate-200 transition"
                            href="{{ route('confirm-courses.attendence', $scheduleResultCourse->course->course_id) }}"><i class="fas fa-arrow-left"></i> {{ __('Return to class') }}</a>
                    </div>
                </div>
            </div>

            <!-- Test explanation card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="px-5 py-3.5 bg-blue-100 text-blue-900 rounded-t-xl font-semibold">
                    {{ __('Test explanation') }}
                </div>
                <div class="p-5 space-y-6" x-data="{{ $dataTodoAnswer }}">
                    <template x-for="(todo, index) in todos" :key="index">
                        <div class="flex gap-4 p-4 rounded-lg border border-slate-100 bg-slate-50/50">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 text-sm" x-text="index+1"></div>
                            <div class="flex-1 space-y-3">
                                <div class="font-medium text-slate-800 text-sm" x-text="todo.question"></div>
                                <div>
                                    <input type="hidden" x-model="todo.todo_item_id" x-bind:name="`todo[${index}][todo_item_id]`">
                                    <input type="hidden" x-model="todo.answer_type" x-bind:name="`todo[${index}][answer_type]`">
                                    
                                    <template x-if="todo.answer_type == '1'">
                                        <textarea x-model="answer[index].text_answer" x-bind:name="`todo[${index}][choices_text]`" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                                    </template>

                                    <template x-if="todo.answer_type == '2'">
                                        <div class="space-y-2">
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                                    <input x-model="answer[index].choice" x-bind:name="`todo[${index}][choices]`" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500" type="radio" :value="choice.todo_option_id" required>
                                                    <span x-text="choice.choices"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="todo.answer_type == '3'">
                                        <div class="space-y-2">
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                                    <input x-model="answer[index].choice" x-bind:name="`todo[${index}][choices][]`" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500" type="checkbox" :value="choice.todo_option_id" required>
                                                    <span x-text="choice.choices"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="todo.answer_type == '4'">
                                        <select x-model="answer[index].choice" x-bind:name="`todo[${index}][choices]`" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">-</option>
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <option :value="choice.todo_option_id" x-text="choice.choices"></option>
                                            </template>
                                        </select>
                                    </template>
                                </div>
                                <template x-if="answer[index].choice && todo.choices.find((e) => e.todo_option_id == answer[index].choice)?.choices == 'others';">
                                    <textarea x-model="answer[index].text_answer" x-bind:name="`todo[${index}][text_answer]`" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" rows="2"></textarea>
                                </template>
                            </div>
                        </div>
                    </template>

                    <div class="flex justify-center items-center gap-4 pt-4 border-t border-slate-100">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition save-confirm" data-save="0"
                            data-confirm-title="Post-class To-Do"
                            data-confirm-html="The input information is temporarily saved.<br>is this good?"><i class="fas fa-redo"></i> {{ __('Retest') }}</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition save-confirm" data-save="0"
                            data-confirm-title="Post-class To-Do"
                            data-confirm-html="The input information is temporarily saved.<br>is this good?"><i class="fas fa-check"></i> {{ __('Complete') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection
