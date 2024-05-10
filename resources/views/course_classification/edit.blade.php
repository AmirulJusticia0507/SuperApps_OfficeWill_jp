@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Course Classification</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('classifications.update', $classification->course_classification_id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="course_classification_name">Classification Name</label>
                            <input type="text" class="form-control" id="course_classification_name" name="course_classification_name" value="{{ $classification->course_classification_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="icon_file_path">Icon File Path</label>
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" value="{{ $classification->icon_file_path }}">
                        </div>
                        <div class="form-group">
                            <label for="displayorder">Display Order</label>
                            <input type="number" class="form-control" id="displayorder" name="displayorder" value="{{ $classification->displayorder }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
