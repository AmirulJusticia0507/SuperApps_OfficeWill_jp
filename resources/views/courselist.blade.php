@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
@section('content')
    <!-- Header -->
    @include('includes.header')


    <!-- Main Content -->
    {{-- <div class="container"> --}}
        <div class="row justify-content-center">
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <div class="col-md-8">
                <br><br><br>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Registration</b></div>
                        <div class="card-body">
                            <!-- Form Filter -->
                            <form action="{{ route('course.filter') }}" method="GET">
                                <!-- Course Classification Filter -->
                                <div class="form-group">
                                    <label for="course_classification">Course Classification:</label>
                                    <select class="form-control" id="course_classification_id" name="Course_classification_id" required style="display: inline-block; width: 60%;">
                                        @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Course Classification Details Filter -->
                                <div class="form-group">
                                    <label for="course_classification_details">Course Classification Details:</label>
                                    <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required style="display: inline-block; width: 60%;">
                                        @foreach($details as $detail)
                                        <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Course Name Filter -->
                                <div class="form-group">
                                    <label for="course_name">Course Name:</label>
                                    <input type="text" name="course_name" id="course_name" class="form-control" value="{{ isset($course) ? $course->coursename : '' }}">
                                </div>

                                <!-- Search Button -->
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- DataTable -->
                        <table id="courseTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" >
                            <thead>
                                <tr>
                                    <th>Course Classification</th>
                                    <th>Course Classification Details</th>
                                    <th>Course Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}

    <!-- Footer -->
    @include('includes.footer')
@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Script for Modals -->
<script>
    $(document).ready(function () {
            var table = $('#courseTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip',
                buttons: ['copy', 'excel', 'pdf']
            });
        });
</script>
@endsection
