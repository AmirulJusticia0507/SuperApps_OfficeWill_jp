@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Course Classification Detail</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('details.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="course_classification_id">Classification ID</label>
                            <select class="form-control" id="course_classification_id" name="Course_classification_id" required>
                                <option value="">Select Classification ID</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_classification_detailsname">Classification Detail Name</label>
                            <input type="text" class="form-control" id="course_classification_detailsname" name="course_classification_detailsname" required>
                        </div>
                        <div class="form-group">
                            <label for="icon_file_path">Icon File Path</label>
                            <input type="text" class="form-control" id="icon_file_path" name="icon_file_path">
                        </div>
                        <div class="form-group">
                            <label for="display_order">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
