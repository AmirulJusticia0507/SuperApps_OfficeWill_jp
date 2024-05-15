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
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Course Classification Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-classification.index') }}">Course Classification</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Classification Registration</li>
                    </ol>
                </nav>
            <!-- Course Classifications Table -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Classifications Registration</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Classification Name</th>
                                <!-- <th scope="col">Icon File Path</th> -->
                                <th scope="col">Display Order</th>
                                <!-- <th scope="col">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($classifications as $classification)
                        <tr>
                            <td>{{ $classification->course_classification_id }}</td>
                            <td>{{ $classification->course_classification_name }}</td>
                            <!-- <td>
                                @if($classification->icon_file_path)
                                    <img src="{{ asset('storage/' . $classification->icon_file_path) }}" alt="Icon">
                                @else
                                    No Image
                                @endif
                            </td> -->
                            <td>{{ $classification->displayorder }}</td>
                            <!-- <td>
                                <a href="{{ route('classifications.edit', $classification->course_classification_id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('classifications.destroy', $classification->course_classification_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td> -->
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <br><br><br><br><br>
            <!-- Create/Edit Classification Form -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Create / Edit Classification</b> <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p></div>
                <div class="card-body">
                    <!-- Form Create/Edit Classification -->
                    <form method="POST" action="{{ isset($editClassification) ? route('classifications.update', $editClassification->course_classification_id) : route('classifications.store') }}">
                        @csrf
                        @if(isset($editClassification))
                        @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company</label>
                            <input type="hidden" id="selectedCompanyId" name="company_id" value="{{ isset($editClassification) ? $editClassification->company_id : '' }}">
                            <select class="form-select" id="company_name" name="company_name" required>
                                <option value="" selected disabled>Select Company</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="classification_name" class="form-label">Classification Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="classification_name" name="classification_name" value="{{ isset($editClassification) ? $editClassification->course_classification_name : '' }}" required style="display: inline-block; width: 79%;">
                        </div>
                        <div class="mb-3">
                            <label for="icon_file_path" class="form-label">Icon File Path</label>
                            <!-- Field untuk mengunggah file ikon -->
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" style="display: inline-block; width: 86%;">
                        </div>
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order <span style="color: red">*</span></label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="{{ isset($editClassification) ? $editClassification->display_order : '' }}" required style="display: inline-block; width: 84%;">
                        </div>
                        <div align="center">
                            <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                            @if(isset($editClassification))
                            <button type="button" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i> Delete</button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div><br><br><br><br><br><br><br><br><br><br><br><br>
{{-- </div> --}}

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
    // Function to show modal when the button is clicked
    const createClassificationModal = new bootstrap.Modal(document.getElementById('createClassificationModal'));
    $(document).ready(function () {
            var table = $('#classificationTable').DataTable({
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
