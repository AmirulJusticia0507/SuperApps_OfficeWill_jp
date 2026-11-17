@extends('layouts.app')

@section('content')
<style>
    .materials-edit-page { min-height: 100vh; background: #f4f6f9; }
    .materials-edit-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .materials-edit-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .materials-edit-page__content, body.sidebar-collapsed .materials-edit-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="materials-edit-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="materials-edit-page__content pt-20">
        <!-- Breadcrumb -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-600">
                <li class="inline-flex items-center">
                    <span class="text-gray-500">Teaching Material Information</span>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <a href="{{ route('materials.index') }}" class="text-blue-600 hover:text-blue-800">Material List</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-gray-500 font-medium">Edit Teaching Material</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-900 px-6 py-4">
                <h1 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-edit text-blue-400"></i>
                    Edit Teaching Material
                </h1>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('materials.update', $material->material_id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="course_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="course_id" name="course_id" required>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->course_id }}" @selected((int) old('course_id', $material->course_id) === (int) $course->course_id)>
                                        {{ $course->coursename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                Display Order <span class="text-red-500">*</span>
                            </label>
                            <input type="number" min="1" max="999" id="display_order" name="display_order" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" value="{{ old('display_order', (int) $material->display_order) }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="teaching_material_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Teaching Material Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="teaching_material_name" name="teaching_material_name" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" maxlength="20" value="{{ old('teaching_material_name', $material->teaching_material_name) }}" required>
                        </div>

                        <div>
                            <label for="material_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Material Type <span class="text-red-500">*</span>
                            </label>
                            <select id="material_type" name="material_type" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" required>
                                @foreach (['Video', 'Books'] as $type)
                                    <option value="{{ $type }}" @selected(old('material_type', $material->material_type) === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="youtube_video_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            Video URL
                        </label>
                        <input type="url" id="youtube_video_url" name="youtube_video_url" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" value="{{ old('youtube_video_url', $material->youtube_video_url) }}">
                    </div>

                    @if ($material->book_file_path)
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200 text-sm text-blue-800 flex items-center justify-between">
                            <span>Current file: <strong>{{ basename($material->book_file_path) }}</strong></span>
                            <a href="{{ asset('storage/' . $material->book_file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium underline inline-flex items-center gap-1">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    @endif

                    <div>
                        <label for="bookfile" class="block text-sm font-semibold text-gray-700 mb-2">
                            Replace Book File
                        </label>
                        <input type="file" id="bookfile" name="bookfile" class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('materials.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')
@endsection
