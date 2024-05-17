@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Teaching Material Information</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Material List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teaching Material Information</li>
                </ol>
            </nav>
            <!-- Material Form -->
            <div id="materialForm">
                <form id="courseMaterialForm" enctype="multipart/form-data" method="POST" action="{{ route('materials.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="company_id" class="form-label">Company</label>
                        <select class="form-select" id="company_id" name="company_id" required>
                            <option value="" selected disabled>Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teaching_material_name">Teaching Material Name: <b style="color: red">*</b></label>
                        <input type="text" class="form-control" id="teaching_material_name" name="teaching_material_name" required>
                    </div>
                    <div class="form-group">
                        <label for="material_type">Material Type:</label><br>
                        <select id="material_type" name="material_type" class="form-control" required>
                            <option value="">Select Material Type</option>
                            <option value="Video">Video</option>
                            <option value="Books">Books</option>
                        </select>
                    </div>
                    <div id="videoFields" >
                        <div class="form-group">
                            <label for="youtube_video_url">Video URL: </label>
                            <input type="url" class="form-control" id="youtube_video_url" name="youtube_video_url">
                        </div>
                    </div>
                    <div id="booksFields" >
                        <div class="form-group">
                            <label for="bookfile">Book File: </label>
                            <input type="file" class="form-control" id="bookfile" name="bookfile">
                        </div>
                    </div>
                    <div align="center">
                        <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Save</button>
                        <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                    </div>
                </form>
            </div>

            <!-- Material List -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color: aliceblue">Teaching Material Information</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="coursematerialsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Teaching Material Name</th>
                                <th>Material Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materials as $material)
                            <tr>
                                <td>{{ $material->material_id }}</td> <!-- Ubah $material->id menjadi $material->material_id -->
                                <td>{{ $material->teaching_material_name }}</td>
                                <td>{{ $material->material_type }}</td>
                                <td>
                                    <a href="{{ route('materials.edit', $material->material_id) }}" class="btn btn-primary btn-sm">Edit</a> <!-- Ubah $material->id menjadi $material->material_id -->
                                    <form action="{{ route('materials.destroy', $material->material_id) }}" method="POST" style="display: inline;"> <!-- Ubah $material->id menjadi $material->material_id -->
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
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
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#coursematerialsTable').DataTable({
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

        // Function to hide both video and books fields
        const hideAllFields = () => {
            videoFields.style.display = 'none';
            booksFields.style.display = 'none';
        };

        // Initially hide all fields
        hideAllFields();

        materialTypeSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            // Hide all fields first
            hideAllFields();
            // Show fields based on selected value
            if (selectedValue === 'Video') {
                videoFields.style.display = 'block';
            } else if (selectedValue === 'Books') {
                booksFields.style.display = 'block';
            }
        });

        // const materialFormElement = document.getElementById('courseMaterialForm');
        // materialFormElement.addEventListener('submit', function(event) {
        //     event.preventDefault();
        //     const formData = new FormData(this);
        //     fetch(this.action, {
        //         method: this.method,
        //         body: formData,
        //     })
        //     .then(response => {
        //         if (!response.ok) {
        //             throw new Error('Network response was not ok');
        //         }
        //         return response.json();
        //     })
        //     .then(data => {
        //         console.log(data);
        //         // Reset form after successful submission
        //         materialFormElement.reset();
        //         // Hide form after successful submission
        //         hideAllFields();
        //         // You may want to reload or update the table here
        //     })
        //     .catch(error => {
        //         console.error('There has been a problem with your fetch operation:', error);
        //     });
        // });
    });

</script>
@endsection

