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
            <a href="{{ route('course-classifications.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition">{{ __('Create New Classification') }}</a>
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
                                <a href="{{ route('course-classifications.edit', $classification->course_classification_id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition edit-btn" title="Edit">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <form action="{{ route('course-classifications.destroy', $classification->course_classification_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition" onclick="return confirm(@json(__('Are you sure?')) )" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                            <tr><td colspan="5" class="text-center">{{ __('No classifications found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
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
