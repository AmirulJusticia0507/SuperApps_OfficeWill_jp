@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Course Information</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('course-information.update', $course->course_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="course_classification_id">Classification</label>
                            <select class="form-control" id="course_classification_id" name="course_classification_id" required>
                                @foreach($classifications as $classification)
                                <option value="{{ $classification->id }}" {{ $course->course_classification_id == $classification->id ? 'selected' : '' }}>{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course_classification_details_id">Classification Detail</label>
                            <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required>
                                @foreach($details as $detail)
                                <option value="{{ $detail->course_classification_details_id }}" {{ $course->course_classification_details_id == $detail->course_classification_details_id ? 'selected' : '' }}>{{ $detail->course_classification_detailsname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Other input fields for course information -->

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
