@extends('layouts.app')

@section('content')
    @include('includes.header')
    <div class="row justify-content-center">
        <div class="col-md-3">@include('includes.sidebar')</div>
        <main class="col-md-8 py-4">
            <h1>Edit Teaching Material</h1>
            <form method="POST" action="{{ route('materials.update', $material->material_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select" id="course_id" name="course_id" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->course_id }}" @selected((int) old('course_id', $material->course_id) === (int) $course->course_id)>
                                {{ $course->coursename }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" min="1" max="999" id="display_order" name="display_order" class="form-control" value="{{ old('display_order', (int) $material->display_order) }}" required>
                </div>
                <div class="mb-3">
                    <label for="teaching_material_name" class="form-label">Teaching Material Name</label>
                    <input type="text" id="teaching_material_name" name="teaching_material_name" class="form-control" maxlength="20" value="{{ old('teaching_material_name', $material->teaching_material_name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="material_type" class="form-label">Material Type</label>
                    <select id="material_type" name="material_type" class="form-select" required>
                        @foreach (['Video', 'Books'] as $type)
                            <option value="{{ $type }}" @selected(old('material_type', $material->material_type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="youtube_video_url" class="form-label">Video URL</label>
                    <input type="url" id="youtube_video_url" name="youtube_video_url" class="form-control" value="{{ old('youtube_video_url', $material->youtube_video_url) }}">
                </div>
                @if ($material->book_file_path)
                    <p>Current file: <a href="{{ asset('storage/' . $material->book_file_path) }}">Download</a></p>
                @endif
                <div class="mb-3">
                    <label for="bookfile" class="form-label">Replace Book File</label>
                    <input type="file" id="bookfile" name="bookfile" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('materials.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </main>
    </div>
@endsection
