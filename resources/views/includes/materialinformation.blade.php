@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@section('content')
<!-- Header -->
@include('includes.header')

{{-- <div class="container"> --}}
<div class="row justify-content-center">
    <!-- Sidebar -->
    <div class="col-md-3">
        @include('includes.sidebar')
    </div>
    <div class="col-md-4">
        <br><br><br>
        <!-- Create Classification Form -->
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Teaching Material Information</a></li>
                <li class="breadcrumb-item"><a href="{{ route('material-list') }}">Material List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Teaching Material Information</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Teaching MaterialInformation</b></div>
            <div class="card-body"></div>
            <div align="right"><br>
                <button type="button" class="btn btn-light" onclick="addMaterial()">Addition</button>
                <button type="button" class="btn btn-dark" onclick="removeMaterial()">Delete</button>
            </div><br>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Teaching Material Name" style="display: inline-block; width: 30%;">Teaching Material
                        Name :</label><b style="color: red">*</b>
                    <input type="text" name="teaching_material_name" id="teaching_material_name"
                        style="display: inline-block; width: 65%;" required class="form-control">
                </div>
                <div class="form-group">
                    <div style="display: flex; align-items: center;">
                        <label for="material_type" style="margin-right: 10px;" style="width: 100%">Material Type:<b
                                style="color: red">*</b></label>
                        <div style="display: flex;">
                            <input type="radio" name="material_type" id="video" value="Video" required>
                            <label for="video" style="margin-right: 10px;">&emsp;Video</label>
                            <input type="radio" name="material_type" id="books" value="Books" required>
                            <label for="books" style="margin-right: 10px;">&emsp;Books</label>
                        </div>
                    </div>
                </div>
                <div id="videoFields" style="display: none;">
                    <div class="form-group">
                        <label for="youtube_video_url">Video URL: <b style="color: red">*</b></label>
                        <input type="url" name="youtube_video_url" id="youtube_video_url" class="form-control" required>
                    </div>
                </div>

                <div id="booksFields" style="display: none;">
                    <div class="form-group">
                        <label for="book_file_path">Book File: <b style="color: red">*</b></label>
                        <input type="file" name="bookfile" id="bookfile" class="form-control" required>
                    </div>
                </div>
                <div align="center">
                    <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                    <button type="button" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Footer -->
@include('includes.footer')
@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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