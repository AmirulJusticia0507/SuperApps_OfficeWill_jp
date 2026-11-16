@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@section('content')
<!-- Header -->
@include('includes.header')

<!-- <div class="container"> -->
    <div class="row justify-content-center">
        <!-- Sidebar -->
        <div class="col-md-2">
            @include('includes.sidebar')
        </div>
        <div class="col md-6">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" title="{{ __('Course Classification Registration') }}">{{ __('Course Classification Registration') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-classification.index') }}" title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="{{ __('Course Classification Registration') }}">{{ __('Course Classification Registration') }}</li>
                </ol>
            </nav>
            <!-- Button to Open Modal -->
            <div class="master-page__toolbar">
                <input type="text" id="classificationSearchBox" class="form-control master-page__search" placeholder="{{ __('Search table...') }}">
                <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#createClassificationModal">{{ __('Create New Classification') }}</button>
            </div>
            <!-- Course Classifications Table -->
            <div class="card">
                <div class="card-header" title="Course Classifications Registration" style="background-color: darkblue">
                    <b style="color:aliceblue">{{ __('Course Classification Registration') }}</b>
                </div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationTable">
                        <thead>
                            <tr>
                                <th scope="col" title="ID">id</th>
                                <th scope="col" title="{{ __('Icon') }}">{{ __('Icon') }}</th>
                                <th scope="col" title="{{ __('Classification Name') }}">{{ __('Classification Name') }}</th>
                                <th scope="col" title="{{ __('Display Order') }}">{{ __('Display Order') }}</th>
                                <th scope="col" title="{{ __('Actions') }}">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classifications as $classification)
                            <tr>
                                <td>{{ $classification->course_classification_id }}</td>
                                <td>
                                    @if($classification->icon_file_path)
                                        <img src="{{ asset(str_starts_with($classification->icon_file_path, '/storage/') ? ltrim($classification->icon_file_path, '/') : 'storage/' . ltrim($classification->icon_file_path, '/')) }}" alt="Icon" class="table-image-preview" data-bs-toggle="modal" data-bs-target="#imagePreviewModal" data-image-src="{{ asset(str_starts_with($classification->icon_file_path, '/storage/') ? ltrim($classification->icon_file_path, '/') : 'storage/' . ltrim($classification->icon_file_path, '/')) }}" style="max-width: 100px; cursor: pointer;">
                                    @else
                                        <span class="text-muted">{{ __('No image') }}</span>
                                    @endif
                                </td>
                                <td>{{ $classification->course_classification_name }}</td>
                                <td>{{ $classification->displayorder }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-light edit-btn" data-bs-toggle="modal" data-bs-target="#editClassificationModal{{ $classification->course_classification_id }}" title="Edit">
                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                    </button>
                                    <form action="{{ route('course-classifications.destroy', $classification->course_classification_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-dark" onclick="return confirm(@json(__('Are you sure?')) )" title="{{ __('Delete') }}">
                                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Classification Modal -->
                            <div class="modal fade" id="editClassificationModal{{ $classification->course_classification_id }}" tabindex="-1" aria-labelledby="editClassificationModalLabel{{ $classification->course_classification_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editClassificationModalLabel{{ $classification->course_classification_id }}">{{ __('Edit Classification') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form Edit Classification -->
                                            <form method="POST" action="{{ route('course-classifications.update', $classification->course_classification_id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="company_name">{{ __('Company Name') }}:</label>
                                                    <select class="form-select" id="company_name" name="company_name" required>
                                                        <option value="" selected disabled>{{ __('Select Company') }}</option>
                                                        @foreach($companies as $company)
                                                        <option value="{{ $company->company_name }}" {{ $company->company_id == $classification->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="classification_name">{{ __('Classification Name') }}:</label>
                                                    <input type="text" class="form-control" id="classification_name" name="classification_name" value="{{ $classification->course_classification_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="icon_file_path">{{ __('Company Icon File') }}:</label>
                                                     <input type="file" class="form-control" name="icon_file_path" onchange="previewIcon(this)">
                                                     <img src="{{ $classification->icon_file_path ? asset(str_starts_with($classification->icon_file_path, '/storage/') ? ltrim($classification->icon_file_path, '/') : 'storage/' . ltrim($classification->icon_file_path, '/')) : '' }}" alt="{{ __('Current Icon') }}" style="max-width: 100px;">
                                                </div>
                                                <div class="form-group">
                                                    <label for="display_order">{{ __('Display Order') }}:</label>
                                                    <input type="number" class="form-control" id="display_order" name="display_order" value="{{ $classification->displayorder }}" required>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="reset" class="btn btn-dark"><i class="fas fa-power-off"></i> {{ __('Reset') }}</button>
                                                        <button type="submit" class="btn btn-info"><i class="fas fa-pen"></i> {{ __('Update') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Create Classification Modal -->
                <div class="modal fade" id="createClassificationModal" tabindex="-1" aria-labelledby="createClassificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: darkblue">
                                <h5 class="modal-title" id="createClassificationModalLabel" style="color:aliceblue">{{ __('Create Classification') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Create Classification -->
                                <form method="POST" action="{{ route('classifications.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                                        <select class="form-select" id="company_name" name="company_name" required>
                                            <option value="" selected disabled>{{ __('Select Company') }}</option>
                                            @foreach($companies as $company)
                                            <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="classification_name" class="form-label" title="{{ __('Classification Name') }}">{{ __('Classification Name') }} <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="classification_name" name="classification_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label">{{ __('Icon File Path') }}</label>
                                        <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" title="Icon File Path" required onchange="previewIcon(this)">
                                        <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">{{ __('Display Order') }} <span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-light" title="{{ __('Reset') }}"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                                        <button type="submit" class="btn btn-primary" title="{{ __('Submit') }}"><i class="fas fa-send"></i> {{ __('Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">{{ __('Image Preview') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body text-center"><img id="imagePreviewTarget" src="" alt="{{ __('Image Preview') }}" class="img-fluid"></div></div></div>
</div>
<!-- Footer -->
@include('includes.footer')

@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.addEventListener('click', function (event) {
        const image = event.target.closest('.table-image-preview');
        if (image) document.getElementById('imagePreviewTarget').src = image.dataset.imageSrc;
    });
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
        $('#classificationSearchBox').on('keyup', function () { table.search(this.value).draw(); });
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
