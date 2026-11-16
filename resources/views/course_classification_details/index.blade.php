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
                        <li class="breadcrumb-item"><a href="#" title="{{ __('Course Classification Details Registration') }}">{{ __('Course Classification Details Registration') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-classification-details.index') }}" title="{{ __('Course Classification Details') }}">{{ __('Course Classification Details') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="{{ __('Course Classification Details Registration') }}">{{ __('Course Classification Details Registration') }}</li>
                    </ol>
                </nav>
                <div class="master-page__toolbar">
                    <input type="text" id="classificationDetailsSearchBox" class="form-control master-page__search" placeholder="{{ __('Search table...') }}">
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#createDetailModal" title="{{ __('Create New Details') }}"><i class="fas fa-plus"></i> {{ __('Create New Details') }}</button>
                </div>
                <div class="card">
                    <div class="card-header" title="Course Classification Details" style="background-color: darkblue">
                        <b style="color:aliceblue">{{ __('Course Classification Details') }}</b>

                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationdetailsTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col" title="{{ __('Classification Name') }}">{{ __('Classification Name') }}</th>
                                    <th scope="col" title="{{ __('Classification Detail Name') }}">{{ __('Classification Detail Name') }}</th>
                                    <th scope="col" title="{{ __('Icon') }}">{{ __('Icon') }}</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($details->isNotEmpty())
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td>{{ $detail->course_classification_details_id }}</td>
                                            <td>{{ $detail->classification->course_classification_name ?? '' }}</td>
                                            <td>{{ $detail->course_classification_detailsname }}</td>
                                            <td>
                                                @if($detail->icon_url)
                                                     <img src="{{ $detail->icon_url }}" alt="Icon" class="table-image-preview" data-bs-toggle="modal" data-bs-target="#detailImagePreviewModal" data-image-src="{{ $detail->icon_url }}" style="max-width: 100px; cursor: pointer;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info edit-btn" title="Edit" data-bs-toggle="modal" data-bs-target="#editDetailModal{{ $detail->course_classification_details_id }}">
                                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                </button>
                                                <form action="{{ route('details.destroy', $detail->course_classification_details_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-dark" title="{{ __('Delete') }}" onclick="return confirm(@json(__('Are you sure?')))" ><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No data found') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
<!-- Footer -->
@include('includes.footer')
@endsection

                <!-- Create Detail Modal -->
                <div class="modal fade" id="createDetailModal" tabindex="-1" aria-labelledby="createDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createDetailModalLabel" title="{{ __('Create Course Classification Detail') }}">{{ __('Create Course Classification Detail') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="createDetailForm" action="{{ route('details.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="course_classification_id" class="form-label" title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</label>
                                        <select class="form-select" id="course_classification_id" name="course_classification_id" title="Select Course Classification" required>
                                            <option value="" selected disabled>{{ __('Select Course Classification') }}</option>
                                            @foreach($classifications as $classification)
                                            <option value="{{ $classification->course_classification_id }}">
                                                {{ $classification->course_classification_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_detailsname" class="form-label" title="{{ __('Classification Detail Name') }}">{{ __('Classification Detail Name') }}
                                            <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="course_classification_detailsname"
                                            name="course_classification_detailsname" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label" title="{{ __('Display Order') }}">{{ __('Display Order') }} <span
                                                style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label" title="{{ __('Course Classification Detail Icon') }}">{{ __('Course Classification Detail Icon') }}</label>
                                        <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" required onchange="previewIcon(this)">
                                        <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                                    </div><br><br>
                                    <div align="center">
                                        <button type="reset" class="btn btn-light" title="Reset" data-bs-dismiss="modal"><i
                                                class="fas fa-undo"></i> {{ __('Reset') }}</button>
                                        <button type="submit" class="btn btn-primary" title="{{ __('Submit') }}"><i class="fas fa-send"></i> {{ __('Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Detail Modals -->
                @foreach($details as $detail)
                <div class="modal fade" id="editDetailModal{{ $detail->course_classification_details_id }}" tabindex="-1" aria-labelledby="editDetailModalLabel{{ $detail->course_classification_details_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDetailModalLabel{{ $detail->course_classification_details_id }}" title="{{ __('Edit Course Classification Detail') }}">{{ __('Edit Course Classification Detail') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editDetailForm{{ $detail->course_classification_details_id }}" action="{{ route('course-classification-details.update', $detail->course_classification_details_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="course_classification_id" class="form-label" title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</label>
                                        <select class="form-select" id="course_classification_id" name="course_classification_id" title="Select Course Classification" required>
                                            <option value="" selected disabled>{{ __('Select Course Classification') }}</option>
                                            @foreach($classifications as $classification)
                                            <option value="{{ $classification->course_classification_id }}" {{ $detail->course_classification_id == $classification->course_classification_id ? 'selected' : '' }}>
                                                {{ $classification->course_classification_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_detailsname" class="form-label">{{ __('Classification Detail Name') }}
                                            <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="course_classification_detailsname" name="course_classification_detailsname" title="Classification Detail Name" value="{{ $detail->course_classification_detailsname }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">{{ __('Display Order') }} <span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" title="Display Order" value="{{ $detail->display_order }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label">{{ __('Course Classification Detail Icon') }}</label>
                                        <input type="file" class="form-control" title="Course Classification Detail Icon" id="icon_file_path" name="icon_file_path" onchange="previewIcon(this)">
                                        <img id="icon_preview" src="{{ $detail->icon_file_path ? asset('storage/' . $detail->icon_file_path) : '' }}" alt="Current Icon" style="max-width: 100px;">
                                    </div><br><br>
                                    <div align="center">
                                        <button type="submit" class="btn btn-info" title="{{ __('Update') }}"><i class="fas fa-pen"></i> {{ __('Update') }}</button>&emsp;
                                        <button type="reset" class="btn btn-dark" title="{{ __('Reset') }}"><i class="fas fa-power-off"></i> {{ __('Reset') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

<div class="modal fade" id="detailImagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">{{ __('Image Preview') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body text-center"><img id="detailImagePreviewTarget" src="" alt="{{ __('Image Preview') }}" class="img-fluid"></div></div></div>
</div>


@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.addEventListener('click', function (event) {
        const image = event.target.closest('.table-image-preview');
        if (image) document.getElementById('detailImagePreviewTarget').src = image.dataset.imageSrc;
    });
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
        $('#classificationDetailsSearchBox').on('keyup', function () { table.search(this.value).draw(); });
    });
</script>
<script>
    function previewIcon(input) {
        var preview = input.nextElementSibling;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
