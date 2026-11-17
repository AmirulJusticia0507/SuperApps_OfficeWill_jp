@extends('layouts.app')

@section('content')
<style>
    .course-todo-ans-page { min-height: 100vh; background: #f4f6f9; }
    .course-todo-ans-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-todo-ans-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-todo-ans-page__content, body.sidebar-collapsed .course-todo-ans-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="course-todo-ans-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-todo-ans-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" class="hover:text-blue-600">コース登録</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-list') }}" class="hover:text-blue-600">コース一覧</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-inquiry') }}" class="hover:text-blue-600">コース固有の問い合わせ</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page">ToDo answer inquiry after taking the course</li>
            </ol>
        </nav>

        <form action="{{ route('confirm-courses.todo-answer.store', $course->course_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->course_id }}">

            <!-- Course Info -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white font-semibold">
                    {{ __('Course Information') }}
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Course Classification') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $course->classification->course_classification_name }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Course Classification Details') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $course->classification_detail->course_classification_detailsname }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Course Name') }}</div>
                        <div class="md:col-span-8 font-semibold text-slate-800">{{ $course->coursename }}</div>
                    </div>
                </div>
            </div>

            <!-- Employee Info -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white font-semibold">
                    {{ __('Employees Enrolled in Course') }}
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Affiliation') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $employee->employee_affiliation->affiliation->affiliation_name }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Job Title') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $employee->employee_affiliation->job->job_title }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2 border-b border-slate-100">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Full Name') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $employee->fullname }}</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 py-2">
                        <div class="md:col-span-4 font-medium text-slate-600">{{ __('Employee Code') }}</div>
                        <div class="md:col-span-8 text-slate-800">{{ $employee->employee_code }}</div>
                    </div>
                </div>
            </div>

            <!-- Survey Responses -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white font-semibold">
                    {{ __('Survey Responses') }}
                </div>
                <div class="p-5 space-y-6" x-data="{{ $dataTodoAnswer }}">
                    <template x-for="(todo, index) in todos" :key="index">
                        <div class="flex gap-4 p-4 rounded-lg border border-slate-100 bg-slate-50/50">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 text-sm" x-text="index+1"></div>
                            <div class="flex-1 space-y-3">
                                <div class="font-medium text-slate-800 text-sm" x-text="todo.question"></div>
                                <div>
                                    <template x-if="todo.answer_type == 1">
                                        <textarea class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                                    </template>
                                    <template x-if="todo.answer_type == 2">
                                        <div class="space-y-2">
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                                    <input x-model="answer[index].choice" x-bind:name="`todo[${index}][choices]`" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500" type="radio" :value="choice.choices == 'others' ? 'others' : choice.todo_option_id" required>
                                                    <span x-text="choice.choices"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="todo.answer_type == 3">
                                        <div class="space-y-2">
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                                    <input x-model="answer[index].choice" x-bind:name="`todo[${index}][choices]`" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500" type="checkbox" :value="choice.todo_option_id" required>
                                                    <span x-text="choice.choices"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="todo.answer_type == 4">
                                        <select x-model="answer[index].choice" x-bind:name="`todo[${index}][choices]`" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">-</option>
                                            <template x-for="(choice, choiceIndex) in todo.choices" :key="choiceIndex">
                                                <option :value="choice.todo_option_id" x-text="choice.choices"></option>
                                            </template>
                                        </select>
                                    </template>
                                </div>
                                <template x-if="answer[index].choice == 'others'">
                                    <textarea x-model="answer[index].choice_text" x-bind:name="`todo[${index}][choices_text]`" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" rows="2" placeholder="{{ __('Please specify') }}"></textarea>
                                </template>
                            </div>
                        </div>
                    </template>

                    <div class="flex justify-center pt-4 border-t border-slate-100">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition"><i class="fas fa-paper-plane"></i> Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection
