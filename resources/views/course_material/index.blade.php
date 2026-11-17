@extends('layouts.app')

@section('content')
<style>
    .materials-page { min-height: 100vh; background: #f4f6f9; }
    .materials-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .materials-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .materials-page__content, body.sidebar-collapsed .materials-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="materials-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="materials-page__content pt-20">
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

        <!-- Material Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="bg-slate-900 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-book-open text-blue-400"></i>
                    Teaching Material Information
                </h2>
            </div>
            <div class="p-6">
                <form id="courseMaterialForm" enctype="multipart/form-data" method="POST" action="{{ route('materials.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="course_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="course_id" name="course_id" required>
                                <option value="" selected disabled>Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}">{{ $course->coursename }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                Display Order <span class="text-red-500">*</span>
                            </label>
                            <input type="number" min="1" max="999" value="1" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="display_order" name="display_order" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="teaching_material_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Teaching Material Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="teaching_material_name" name="teaching_material_name" required>
                        </div>

                        <div>
                            <label for="material_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Material Type <span class="text-red-500">*</span>
                            </label>
                            <select id="material_type" name="material_type" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" required>
                                <option value="">Select Material Type</option>
                                <option value="Video">Video</option>
                                <option value="Books">Books</option>
                            </select>
                        </div>
                    </div>

                    <div id="videoFields" style="display: none;">
                        <label for="youtube_video_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            Video URL
                        </label>
                        <input type="url" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="youtube_video_url" name="youtube_video_url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div id="booksFields" style="display: none;">
                        <label for="bookfile" class="block text-sm font-semibold text-gray-700 mb-2">
                            Book File
                        </label>
                        <input type="file" class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="bookfile" name="bookfile">
                    </div>

                    <div class="flex items-center justify-center gap-4 pt-4 border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button type="reset" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Material List Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-list text-blue-400"></i>
                    Teaching Material List
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full text-sm text-left text-gray-600" id="coursematerialsTable">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Teaching Material Name</th>
                            <th class="px-4 py-3">Material Type</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($materials as $material)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $material->material_id }}</td>
                            <td class="px-4 py-3">{{ $material->teaching_material_name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $material->material_type === 'Video' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $material->material_type }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('materials.edit', $material->material_id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded shadow-sm transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('materials.destroy', $material->material_id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded shadow-sm transition" onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#coursematerialsTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const materialTypeSelect = document.getElementById('material_type');
        const videoFields = document.getElementById('videoFields');
        const booksFields = document.getElementById('booksFields');

        const hideAllFields = () => {
            if (videoFields) videoFields.style.display = 'none';
            if (booksFields) booksFields.style.display = 'none';
        };

        hideAllFields();

        if (materialTypeSelect) {
            materialTypeSelect.addEventListener('change', function() {
                hideAllFields();
                if (this.value === 'Video') {
                    videoFields.style.display = 'block';
                } else if (this.value === 'Books') {
                    booksFields.style.display = 'block';
                }
            });
        }
    });
</script>
@endsection
