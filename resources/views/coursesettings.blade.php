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
        <div class="col-md-8">
            <br><br><br>
            <!-- Create Classification Form -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Settings -> Choose your course</b></div>
                <form action="" method="get">
                    <div class="form-group">
                        <label for="course_classification">&emsp;Course Classification:</label>
                        <select class="form-control" id="course_classification_id" name="Course_classification_id" required style="display: inline-block; width: 60%;">
                            @foreach($classifications as $classification)
                            <option value="{{ $classification->id }}">{{ $classification->course_classification_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Classification Details Filter -->
                    <div class="form-group">
                        <label for="course_classification_details">&emsp;Course Classification Details:</label>
                        <select class="form-control" id="course_classification_details_id" name="course_classification_details_id" required style="display: inline-block; width: 60%;">
                            @foreach($details as $detail)
                            <option value="{{ $detail->course_classification_details_id }}">{{ $detail->course_classification_detailsname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="course_name">&emsp;Course Name:</label>
                        &emsp;<input type="text" name="course_name" id="course_name" class="form-control" style="display: inline-block; width: 60%;" value="{{ isset($course) ? $course->coursename : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="course_attributes_01" style="display: inline-block; width: 30%;">&emsp;(Course attribute 01) :</label>
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
                    <div class="form-group">
                        <label for="course_attributes_02" style="display: inline-block; width: 30%;">&emsp;(Course attribute 02) :</label>
                        <input type="text" name="course_attributes_02" id="course_attributes_02" class="form-control" style="display: inline-block; width: 60%;">
                    </div>
                    <div class="form-group">
                        <label style="display: inline-block; width: 30%;"></label>
                        <div style="display: inline-block; width: 60%;">
                            <label class="radio-inline">
                                <input type="radio" name="search_option" value="partial_match"> Partial Match
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
                    <div class="form-group">
                        <label for="course_attributes_03" style="display: inline-block; width: 30%;">&emsp;(Course attribute 03) :</label>
                        <select name="course_attributes_03" id="course_attributes_03" style="display: inline-block; width: 60%;" class="form-control">
                            <option value="-"> </option>
                            <option value="Perfect matching">(Perfect matching)</option>
                            <option value=""> </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="course_attributes_04" style="display: inline-block; width: 30%;">&emsp;(Course attribute 04) :</label>
                        <input type="text" name="course_attributes_04" id="course_attributes_04" class="form-control" style="display: inline-block; width: 60%;">
                    </div>
                    <div class="form-group">
                        <label for="course_attributes_05" style="display: inline-block; width: 30%;">&emsp;(Course attribute 05) :</label>
                        <input type="text" name="course_attributes_05" id="course_attributes_05" class="form-control" style="display: inline-block; width: 60%;">
                    </div>
                    <div align="center">
                        <button type="submit" class="btn btn-info" style="color: white">search</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-header" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">Course List</b></div>
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
                            @foreach ($filteredCourses as $course)
                            <tr>
                                <td>{{ $course->classification->course_classification_name }}</td>
                                <td>{{ $course->detail->course_classification_detailsname }}</td>
                                <td>{{ $course->coursename }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    <script>
        $(document).ready(function () {
            // Fungsi untuk menangani pengiriman permintaan pencarian
            $('form').submit(function (e) {
                e.preventDefault(); // Mencegah form dari pengiriman langsung

                // Ambil nilai input dari form
                var classificationId = $('#course_classification_id').val();
                var detailId = $('#course_classification_details_id').val();
                var courseName = $('#course_name').val();

                // Lakukan pengiriman AJAX request
                $.ajax({
                    type: 'GET',
                    url: '{{ route("search_courses") }}',
                    data: {
                        classificationId: classificationId,
                        detailId: detailId,
                        courseName: courseName
                    },
                    success: function (response) {
                        // Tampilkan data yang ditemukan dalam tabel
                        $('#courseTable tbody').html(response);
                    }
                });
            });
        });
    </script>

@endsection
