@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
<style>
    .course-class-page { min-height: 100vh; background: #f4f6f9; }
    .course-class-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-class-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-class-page__content, body.sidebar-collapsed .course-class-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<div class="course-class-page">
<!-- Header -->
@include('includes.header')
@include('includes.sidebar')
<main class="course-class-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Course Classification Registration') }}" class="hover:text-blue-600">{{ __('Course Classification Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-classification.index') }}" title="{{ __('Course Classification') }}" class="hover:text-blue-600">{{ __('Course Classification') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Course Classification Registration') }}">{{ __('Course Classification Registration') }}</li>
            </ol>
        </nav>
        <!-- Button to Open Modal -->
        <div class="flex justify-between items-center gap-3 mb-4 flex-wrap">
            <input type="text" id="classificationSearchBox" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 max-w-xs" placeholder="{{ __('Search table...') }}">
            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition" data-bs-toggle="modal" data-bs-target="#createClassificationModal">{{ __('Create New Classification') }}</button>
        </div>
        <!-- Course Classifications Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Course Classifications Registration">
                {{ __('Course Classification Registration') }}
            </div>
            <div class="p-5 overflow-x-auto">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                        @forelse ($classifications as $classification)
                        <tr>
                            <td>{{ $classification->course_classification_id }}</td>
                            <td>
                                @if($classification->icon_file_path)
                                    <img src="{{ $classification->icon_url }}" alt="Icon" class="table-image-preview" data-bs-toggle="modal" data-bs-target="#imagePreviewModal" data-image-src="{{ $classification->icon_url }}" style="display: inline-block; width: 100px; height: 100px; object-fit: contain; cursor: pointer;">
                                @else
                                    <span class="text-muted">{{ __('No image') }}</span>
                                @endif
                            </td>
                            <td>{{ $classification->course_classification_name }}</td>
                            <td>{{ $classification->displayorder }}</td>
                            <td>
                                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition edit-btn" data-bs-toggle="modal" data-bs-target="#editClassificationModal{{ $classification->course_classification_id }}" title="Edit">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </button>
                                <form action="{{ route('course-classifications.destroy', $classification->course_classification_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition" onclick="return confirm(@json(__('Are you sure?')) )" title="{{ __('Delete') }}">
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
                                            <div class="mb-4">
                                                <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Name') }}:</label>
                                                <select class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white w-full" id="company_name" name="company_name" required>
                                                    <option value="" selected disabled>{{ __('Select Company') }}</option>
                                                    @foreach($companies as $company)
                                                    <option value="{{ $company->company_name }}" {{ $company->company_id == $classification->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="classification_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Classification Name') }}:</label>
                                                <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="classification_name" name="classification_name" value="{{ $classification->course_classification_name }}" required>
                                            </div>
                                            <div class="mb-4">
                                                <label for="icon_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Icon File') }}:</label>
                                                 <input type="file" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" name="icon_file_path" onchange="previewIcon(this)">
                                                 <img src="{{ $classification->icon_url ?? '' }}" alt="{{ __('Current Icon') }}" style="max-width: 100px;">
                                            </div>
                                            <div class="mb-4">
                                                <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }}:</label>
                                                 <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" value="{{ $classification->displayorder }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                    <button type="reset" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-power-off"></i> {{ __('Reset') }}</button>
                                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-pen"></i> {{ __('Update') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <tr><td colspan="5" class="text-center">{{ __('No classifications found.') }}</td></tr>
                        @endforelse
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
                                <div class="mb-4">
                                    <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Name') }}</label>
                                    <select class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white w-full" id="company_name" name="company_name" required>
                                        <option value="" selected disabled>{{ __('Select Company') }}</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="classification_name" class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Classification Name') }}">{{ __('Classification Name') }} <span style="color: red">*</span></label>
                                    <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="classification_name" name="classification_name" required>
                                </div>
                                <div class="mb-4">
                                    <label for="icon_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Icon File Path') }}</label>
                                    <input type="file" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="icon_file_path" name="icon_file_path" title="Icon File Path" required onchange="previewIcon(this)">
                                    <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                                </div>
                                <div class="mb-4">
                                    <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }} <span style="color: red">*</span></label>
                                    <input type="number" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition" title="{{ __('Reset') }}"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition" title="{{ __('Submit') }}"><i class="fas fa-send"></i> {{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">{{ __('Image Lightbox') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body text-center"><img id="imagePreviewTarget" src="" alt="{{ __('Image Lightbox') }}" class="img-fluid"></div></div></div>
</div>
        </div>
        <!-- Footer -->
        @include('includes.footer')
</main>
</div>

@endsection

@push('scripts')
@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => Swal.fire({
    icon: 'success', title: @json(__('Success')), text: @json(session('success')),
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
    timerProgressBar: true
}));
</script>
@endif
@endpush

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
