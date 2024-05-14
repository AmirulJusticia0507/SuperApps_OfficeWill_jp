@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
<!-- Header -->
@include('includes.header')

{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <!-- Kolom untuk tabel -->
        <div class="col md-4">
            <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Course Classification Details Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-classification-details.index') }}">Course Classification Details</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course Classification Details Registration</li>
                    </ol>
                </nav>
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Classification Details</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationdetailsTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Classification Name</th>
                                <th scope="col">Classification Detail Name</th>
                                {{-- <th scope="col">Icon File Path</th> --}}
                                {{-- <th scope="col">Display Order</th> --}}
                                {{-- <th scope="col">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @if($details->isNotEmpty())
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $detail->course_classification_details_id }}</td>
                                        <td>{{ $detail->classification->course_classification_name ?? '' }}</td>
                                        <td>{{ $detail->course_classification_detailsname }}</td>
                                        <!-- <td>
                                            <button type="button" class="btn btn-sm btn-info edit-btn" data-detail="{{ json_encode($detail) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('details.destroy', $detail->course_classification_details_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</button>
                                            </form>
                                        </td> -->
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom untuk form -->
        <div class="col md-2">
            <br><br><br><br><br>
            <div class="card">
                <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course Classification Detail</b> <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p></div>
                <div class="card-body">
                    <form id="classificationDetailsForm" action="{{ route('details.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company</label>
                            <input type="hidden" id="selectedCompanyId" name="company_id" value="{{ isset($editClassification) ? $editClassification->company_id : '' }}">
                            <select class="form-select" id="company_name" name="company_name" required>
                                <option value="" selected disabled>Select Company</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="course_classification_id" class="form-label">Course Classification</label>
                            <select class="form-select" id="course_classification_id" name="Course_classification_id" required>
                                <option value="" selected disabled>Select Course Classification</option>
                                @foreach($classifications as $classification)
                                <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="course_classification_detailsname" class="form-label">Classification Detail Name <b style="color: red">*</b></label>
                            <input type="text" class="form-control" id="course_classification_detailsname" name="course_classification_detailsname" required>
                        </div>
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Ranking <b style="color: red">*</b></label>
                            <input type="number" class="form-control" id="display_order" name="display_order" required>
                        </div>
                        <div class="mb-3">
                            <label for="icon_file_path" class="form-label">Course classification details icon </label>
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path">
                        </div><br><br>
                        <div align="center">
                            <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                            <button type="button" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i> Delete</button>
                        </div>
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

            // Fill Company Data
            $('#selectedCompanyId').val(detailData.company_id);
            $('#company_name').val(detailData.company_id);

            // Scroll to Form
            $('html, body').animate({
                scrollTop: $('#classificationDetailsForm').offset().top
            }, 500);

            // Show Form
            $('#classificationDetailsForm').show();
            $('#saveBtn').html('<i class="fas fa-save"></i> Save Changes');
        });
    });
</script>
@endsection
