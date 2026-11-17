@extends('layouts.app')

@section('content')
<style>
    .material-info-page { min-height: 100vh; background: #f4f6f9; }
    .material-info-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .material-info-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .material-info-page__content, body.sidebar-collapsed .material-info-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="material-info-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="material-info-page__content pt-20">
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
                        <span class="text-gray-500 font-medium">Teaching Material Information</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-book text-blue-400"></i>
                    Teaching Material Information
                </h2>
                <div class="flex items-center gap-2">
                    <button type="button" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition" onclick="addMaterial()">
                        <i class="fas fa-plus"></i> Addition
                    </button>
                    <button type="button" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition" onclick="removeMaterial()">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>

            <div class="p-6">
                <form method="post" action="" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="teaching_material_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Teaching Material Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="teaching_material_name" id="teaching_material_name" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Material Type <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="material_type" id="video" value="Video" required class="text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="text-sm text-gray-700">Video</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="material_type" id="books" value="Books" required class="text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="text-sm text-gray-700">Books</span>
                            </label>
                        </div>
                    </div>

                    <div id="videoFields" style="display: none;">
                        <label for="youtube_video_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            Video URL <span class="text-red-500">*</span>
                        </label>
                        <input type="url" name="youtube_video_url" id="youtube_video_url" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                    </div>

                    <div id="booksFields" style="display: none;">
                        <label for="bookfile" class="block text-sm font-semibold text-gray-700 mb-2">
                            Book File <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="bookfile" id="bookfile" class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    </div>

                    <div class="flex items-center justify-center gap-4 pt-4 border-t border-gray-100">
                        <button type="reset" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                            <i class="fas fa-paper-plane"></i> Submit
                        </button>
                        <button type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg shadow-sm transition" id="deleteButton">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const videoRadio = document.getElementById('video');
        const booksRadio = document.getElementById('books');
        const videoFields = document.getElementById('videoFields');
        const booksFields = document.getElementById('booksFields');

        const updateVisibility = () => {
            if (videoRadio && videoRadio.checked) {
                videoFields.style.display = 'block';
                booksFields.style.display = 'none';
            } else if (booksRadio && booksRadio.checked) {
                videoFields.style.display = 'none';
                booksFields.style.display = 'block';
            } else {
                videoFields.style.display = 'none';
                booksFields.style.display = 'none';
            }
        };

        if (videoRadio) videoRadio.addEventListener('change', updateVisibility);
        if (booksRadio) booksRadio.addEventListener('change', updateVisibility);
    });
</script>
@endsection
