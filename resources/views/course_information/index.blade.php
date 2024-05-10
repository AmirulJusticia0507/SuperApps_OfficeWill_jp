@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Course Information</div>
                <div class="card-body">
                    <a href="{{ route('course-information.create') }}" class="btn btn-primary mb-3">Create New</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Classification</th>
                                <th scope="col">Classification Detail</th>
                                <!-- Other table headers -->
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->course_id }}</td>
                                <td>{{ $course->classification->course_classification_name }}</td>
                                <td>{{ $course->detail->course_classification_detailsname }}</td>
                                <!-- Display other course information -->
                                <td>
                                    <a href="{{ route('course-information.edit', $course->course_id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('course-information.destroy', $course->course_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
