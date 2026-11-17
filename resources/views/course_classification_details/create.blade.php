@extends('layouts.app')

@section('content')
<style>
    .class-detail-form-page { min-height: 100vh; background: #f4f6f9; }
    .class-detail-form-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .class-detail-form-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .class-detail-form-page__content, body.sidebar-collapsed .class-detail-form-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="class-detail-form-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="class-detail-form-page__content">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold">
                    {{ __('Create Course Classification Detail') }}
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('details.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="course_classification_id" class="block text-sm font-medium text-slate-700 mb-1">Classification ID: <span class="text-red-500">*</span></label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" required>
                                <option value="">Select Classification ID</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="course_classification_detailsname" class="block text-sm font-medium text-slate-700 mb-1">Classification Detail Name: <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_detailsname" name="course_classification_detailsname" required>
                        </div>
                        <div>
                            <label for="icon_file_path" class="block text-sm font-medium text-slate-700 mb-1">Icon File Path:</label>
                            <input type="file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" id="icon_file_path" name="icon_file_path">
                        </div>
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">Display Order: <span class="text-red-500">*</span></label>
                            <input type="number" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" required>
                        </div>
                        <div class="pt-4 flex justify-end gap-3">
                            <a href="{{ route('course-classification-details.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200">{{ __('Cancel') }}</a>
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
