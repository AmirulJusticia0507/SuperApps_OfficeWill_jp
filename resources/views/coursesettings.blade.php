@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
    <!-- Header -->
    @include('includes.header')

    <div class="row justify-content-center">
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-6">
            <br><br><br>
            <!-- Create Classification Form -->
            <div class="card">
                <h2 style="background-color: darkblue"><b style="color:aliceblue">Course Settings</b></h2>
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Choose your course</b></div>
                <form action="" method="get">
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
                    <div class="form-group">
                        <label for="course_name">Course Name:</label>
                        <input type="text" name="course_name" id="course_name" class="form-control" value="{{ isset($course) ? $course->coursename : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="course_attributes_01" style="display: inline-block; width: 30%;">(Course attribute 01) :</label>
                        <select name="course_attributes_01" id="course_attributes_01" style="display: inline-block; width: 60%;" class="form-control">
                            <option value="-"> </option>
                            <option value=""> </option>
                            <option value=""> </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="display: inline-block; width: 30%;"></label>
                        <div style="display: inline-block; width: 60%;">
                            <label class="radio-inline">
                                <input type="radio" name="search_option" value="exact_match"> Exact Match
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="search_option" value="range_search"> Range Search
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="search_option" value="or_more_search"> Or More Search
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="search_option" value="or_less_search"> Or Less Search
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Footer -->
    @include('includes.footer')
@endsection

@section('scripts')
    <!-- Script DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#confirmcoursesTable').DataTable({
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
