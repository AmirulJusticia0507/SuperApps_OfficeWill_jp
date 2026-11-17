@extends('layouts.app')

@section('content')
<style>
    .course-create-page { min-height: 100vh; background: #f4f6f9; }
    .course-create-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-create-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-create-page__content, body.sidebar-collapsed .course-create-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="course-create-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-create-page__content">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold">
                    {{ __('Create Course Information') }}
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('course-information.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="px-4 py-2 bg-blue-50 text-blue-900 font-semibold rounded-lg text-sm">
                            {{ __('Basic Information') }}
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="course_classification_id" class="block text-sm font-medium text-slate-700 mb-1">Course Classification : <span class="text-red-500">*</span></label>
                                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" required>
                                    @foreach($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="course_classification_details_id" class="block text-sm font-medium text-slate-700 mb-1">Classification Detail : <span class="text-red-500">*</span></label>
                                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id" name="course_classification_details_id" required>
                                    @foreach($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="coursename" class="block text-sm font-medium text-slate-700 mb-1">Course Name : <span class="text-red-500">*</span></label>
                                <input id="coursename" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" name="coursename" required>
                            </div>

                            <div>
                                <label for="coursename_kana" class="block text-sm font-medium text-slate-700 mb-1">Course Name (Kana) :</label>
                                <input type="text" name="coursename_kana" id="coursename_kana" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="course_description" class="block text-sm font-medium text-slate-700 mb-1">Course Description : <span class="text-red-500">*</span></label>
                                <textarea name="course_description" id="course_description" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Retaking the course within deadline : <span class="text-red-500">*</span></label>
                                <div class="flex gap-6 text-sm text-slate-700">
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible" value="1" class="text-blue-600" required> Re-attendance possible</label>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="possible_retake_course_deadline" id="re_attendance_not_allowed" value="2" class="text-blue-600" required> Re-attendance not allowed</label>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-2 bg-blue-50 text-blue-900 font-semibold rounded-lg text-sm">
                            Teaching Material
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Material Name: <span class="text-red-500">*</span></label>
                                <input type="text" name="teaching_material[0][teaching_material_name]" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" maxlength="20" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Material Type: <span class="text-red-500">*</span></label>
                                <select name="teaching_material[0][material_type]" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="1">Video</option>
                                    <option value="2">Books</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Video URL:</label>
                                <input type="url" name="teaching_material[0][youtube_video_url]" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Book File:</label>
                                <input type="file" name="teaching_material[0][bookfile]" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            </div>
                        </div>

                        <div class="px-4 py-2 bg-blue-50 text-blue-900 font-semibold rounded-lg text-sm">
                            Post-course ToDo
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">ToDo type : <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-6 text-sm text-slate-700">
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="todo_type" id="survey_answers" value="1" class="text-blue-600" required> Survey answers</label>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="todo_type" id="tests" value="2" class="text-blue-600" required> Tests</label>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="todo_type" id="reports" value="3" class="text-blue-600" required> Reports</label>
                                </div>
                            </div>
                            <div>
                                <label for="todo_description" class="block text-sm font-medium text-slate-700 mb-1">ToDo Description : <span class="text-red-500">*</span></label>
                                <textarea name="todo_description" id="todo_description" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Retest availability : <span class="text-red-500">*</span></label>
                                <div class="flex gap-6 text-sm text-slate-700">
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="repeated_retest" id="retest_availability" value="1" class="text-blue-600" required> Retest availability</label>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="repeated_retest" id="no_retest_availability" value="2" class="text-blue-600" required> No retest availability</label>
                                </div>
                            </div>
                            <div>
                                <label for="test_passed_score" class="block text-sm font-medium text-slate-700 mb-1">Test Pass Threshold (%):</label>
                                <input type="number" min="0" max="100" name="test_passed_score" id="test_passed_score" class="w-full max-w-xs px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                            <a href="{{ route('course-list') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition"><i class="fas fa-paper-plane"></i> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection
