@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
<!-- Header -->
@include('includes.header')
{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <!-- Bagian Kiri: Tabel DataTables -->
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-6">
            <br><br><br>
            <div class="card">
                <div class="card-header">Course Classification Details</div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationdetailsTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Classification Name</th>
                                <th scope="col">Classification Detail Name</th>
                                <th scope="col">Icon File Path</th>
                                <th scope="col">Display Order</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                            <tr>
                                <td>{{ $detail->course_classification_details_id }}</td>
                                <td>{{ $detail->classification->course_classification_name }}</td>
                                <td>{{ $detail->course_classification_detailsname }}</td>
                                <td>{{ $detail->icon_file_path }}</td>
                                <td>{{ $detail->display_order }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-sm btn-info edit-btn" data-detail="{{ json_encode($detail) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('details.destroy', $detail->course_classification_details_id) }}" method="POST" class="d-inline">
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

        <!-- Bagian Kanan: Form Create/Edit -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Create / Edit Classification Detail</div>
                <div class="card-body">
                    <!-- Button for Create -->
                    <button type="button" class="btn btn-primary mb-3" id="createBtn"><i class="fas fa-plus"></i> Create New</button>

                    <!-- Form for Create/Edit -->
                    <form id="classificationDetailsForm" action="{{ route('details.store') }}" method="POST" style="display: none;">
                        @csrf
                        <!-- Your Form Fields Here -->
                        <div class="mb-3">
                            <label for="course_classification_detailsname" class="form-label">Classification Detail Name</label>
                            <input type="text" class="form-control" id="course_classification_detailsname" name="course_classification_detailsname" required>
                        </div>
                        <div class="mb-3">
                            <label for="icon_file_path" class="form-label">Icon File Path</label>
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path">
                        </div>
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn"><i class="fas fa-save"></i> Save</button>
                    </form>
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
<script>
    $(document).ready(function () {
        var table = $('#classificationdetailsTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });

        // Edit Button Click Event
        $('.edit-btn').click(function() {
            var detailData = $(this).data('detail');

            // Set Form Action and Method for Edit
            $('#classificationDetailsForm').attr('action', '/details/' + detailData.course_classification_details_id);
            $('#classificationDetailsForm').append('<input type="hidden" name="_method" value="PUT">');

            // Fill Form Fields with Data
            $('#course_classification_detailsname').val(detailData.course_classification_detailsname);
            $('#icon_file_path').val(detailData.icon_file_path);
            $('#display_order').val(detailData.display_order);

            // Show Form
            $('#classificationDetailsForm').show();
            $('#saveBtn').html('<i class="fas fa-save"></i> Save Changes');
        });

        // Create Button Click Event
        $('#createBtn').click(function() {
            // Reset Form Fields
            $('#classificationDetailsForm').trigger('reset');

            // Set Form Action and Method for Create
            $('#classificationDetailsForm').attr('action', '{{ route('details.store') }}');
            $('#classificationDetailsForm').find('input[name="_method"]').remove();

            // Show Form
            $('#classificationDetailsForm').show();
            $('#saveBtn').html('<i class="fas fa-save"></i> Save');
        });
    });
</script>
@endsection
