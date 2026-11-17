@extends('layouts.app')

@section('content')
<style>
    .course-edit-page { min-height: 100vh; background: #f4f6f9; }
    .course-edit-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-edit-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-edit-page__content, body.sidebar-collapsed .course-edit-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="course-edit-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-edit-page__content">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold">
                    {{ __('Edit Course Information') }}
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('course-information.update', $course->course_id) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="course_classification_id" class="block text-sm font-medium text-slate-700 mb-1">Classification: <span class="text-red-500">*</span></label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" required>
                                @foreach($classifications as $classification)
                                <option value="{{ $classification->id }}" {{ $course->course_classification_id == $classification->id ? 'selected' : '' }}>{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="course_classification_details_id" class="block text-sm font-medium text-slate-700 mb-1">Classification Detail: <span class="text-red-500">*</span></label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id" name="course_classification_details_id" required>
                                @foreach($details as $detail)
                                <option value="{{ $detail->course_classification_details_id }}" {{ $course->course_classification_details_id == $detail->course_classification_details_id ? 'selected' : '' }}>{{ $detail->course_classification_detailsname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <a href="{{ route('course-list') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition"><i class="fas fa-edit"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection
