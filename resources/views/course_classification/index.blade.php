@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

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
            <!-- Course Classifications Table -->
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Classifications Registration</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Classification Name</th>
                                <th scope="col">Icon File Path</th>
                                <th scope="col">Display Order</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classifications as $classification)
                            <tr>
                                <td>{{ $classification->course_classification_id }}</td>
                                <td>{{ $classification->course_classification_name }}</td>
                                <td>{{ $classification->icon_file_path }}</td>
                                <td>{{ $classification->displayorder }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('classifications.edit', $classification->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <!-- Delete Form -->
                                    <form action="{{ route('classifications.destroy', $classification->course_classification_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <br><br><br>
            <!-- Create Classification Form -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Create / Edit Classification</b> <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p></div>
                <div class="card-body">
                    @if(isset($editClassification))
                    <!-- Form Edit Classification -->
                    <form method="POST" action="{{ route('classifications.update', $editClassification->course_classification_id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="classification_name" class="form-label">Classification Name</label>
                            <input type="text" class="form-control" id="classification_name" name="classification_name" value="{{ $editClassification->course_classification_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_id" class="form-label">Company</label>
                            <select class="form-control" id="company_id" name="company_id" required>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="icon_file_path" class="form-label">Icon File Path</label>
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" value="{{ $editClassification->icon_file_path }}">
                        </div>
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="{{ $editClassification->display_order }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </form>
                    @else
                    <!-- Form Create Classification -->
                    <form method="POST" action="{{ route('classifications.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="classification_name" class="form-label">Classification Name</label>
                            <input type="text" class="form-control" id="classification_name" name="classification_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="icon_file_path" class="form-label">Icon File Path</label>
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path">
                        </div>
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" required>
                        </div>
                        <div align="center">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Save</button>
                            <button type="reset" class="btn btn-danger"><i class="fas fa-power-off"></i> Reset</button>
                        </div>
                    </form>
                    @endif
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
