@extends('layouts.app')

@section('content')
<style>
    .class-details-page { min-height: 100vh; background: #f4f6f9; }
    .class-details-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .class-details-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .class-details-page__content, body.sidebar-collapsed .class-details-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

<div class="class-details-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="class-details-page__content space-y-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Course Classification Details Registration') }}" class="hover:text-blue-600">{{ __('Course Classification Details Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-classification-details.index') }}" title="{{ __('Course Classification Details') }}" class="hover:text-blue-600">{{ __('Course Classification Details') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Course Classification Details Registration') }}">{{ __('Course Classification Details Registration') }}</li>
            </ol>
        </nav>

        <div class="flex justify-between items-center gap-3 mb-4 flex-wrap">
            <input type="text" id="classificationDetailsSearchBox" class="w-full max-w-xs px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ __('Search table...') }}">
            <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg shadow-sm transition" data-bs-toggle="modal" data-bs-target="#createDetailModal" title="{{ __('Create New Details') }}"><i class="fas fa-plus"></i> {{ __('Create New Details') }}</button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="Course Classification Details">
                {{ __('Course Classification Details') }}
            </div>
            <div class="p-5 overflow-x-auto">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                        <ul class="mb-0 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%" id="classificationdetailsTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" title="{{ __('Classification Name') }}">{{ __('Classification Name') }}</th>
                            <th scope="col" title="{{ __('Classification Detail Name') }}">{{ __('Classification Detail Name') }}</th>
                            <th scope="col" title="{{ __('Icon') }}">{{ __('Icon') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
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
                                             <img src="{{ $detail->icon_url }}" alt="Icon" class="table-image-preview w-12 h-12 object-contain rounded border border-slate-200 cursor-pointer" data-bs-toggle="modal" data-bs-target="#detailImagePreviewModal" data-image-src="{{ $detail->icon_url }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                             <span style="display: none;" class="text-xs text-slate-400 italic">{{ __('No Image') }}</span>
                                        @else
                                             <span class="text-xs text-slate-400 italic">{{ __('No Image') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-medium rounded-lg transition" title="Edit" data-bs-toggle="modal" data-bs-target="#editDetailModal{{ $detail->course_classification_details_id }}">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </button>
                                            <form action="{{ route('details.destroy', $detail->course_classification_details_id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition" title="{{ __('Delete') }}" onclick="return confirm(@json(__('Are you sure?')))"><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-slate-400 py-4">{{ __('No data found') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')

<!-- Create Detail Modal -->
<div class="modal fade" id="createDetailModal" tabindex="-1" aria-labelledby="createDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-xl border border-slate-200 overflow-hidden shadow-xl">
            <div class="modal-header px-5 py-4 bg-blue-900 text-white">
                <h5 class="modal-title font-semibold text-white" id="createDetailModalLabel" title="{{ __('Create Course Classification Detail') }}">{{ __('Create Course Classification Detail') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <form id="createDetailForm" action="{{ route('details.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="course_classification_id" class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</label>
                        <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" title="Select Course Classification" required>
                            <option value="" selected disabled>{{ __('Select Course Classification') }}</option>
                            @foreach($classifications as $classification)
                            <option value="{{ $classification->course_classification_id }}">
                                {{ $classification->course_classification_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="course_classification_detailsname" class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Classification Detail Name') }}">{{ __('Classification Detail Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_detailsname" name="course_classification_detailsname" required>
                    </div>
                    <div>
                        <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Display Order') }}">{{ __('Display Order') }} <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" required>
                    </div>
                    <div>
                        <label for="icon_file_path" class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Course Classification Detail Icon') }}">{{ __('Course Classification Detail Icon') }}</label>
                        <input type="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" id="icon_file_path" name="icon_file_path" required onchange="previewIcon(this)">
                        <img id="icon_preview" src="#" alt="Preview Icon" class="mt-2 max-w-[100px] rounded border border-slate-200" style="display: none;">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="reset" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200" data-bs-dismiss="modal"><i class="fas fa-undo mr-1"></i> {{ __('Reset') }}</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition"><i class="fas fa-paper-plane"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Detail Modals -->
@foreach($details as $detail)
<div class="modal fade" id="editDetailModal{{ $detail->course_classification_details_id }}" tabindex="-1" aria-labelledby="editDetailModalLabel{{ $detail->course_classification_details_id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-xl border border-slate-200 overflow-hidden shadow-xl">
            <div class="modal-header px-5 py-4 bg-blue-900 text-white">
                <h5 class="modal-title font-semibold text-white" id="editDetailModalLabel{{ $detail->course_classification_details_id }}" title="{{ __('Edit Course Classification Detail') }}">{{ __('Edit Course Classification Detail') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <form id="editDetailForm{{ $detail->course_classification_details_id }}" action="{{ route('course-classification-details.update', $detail->course_classification_details_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="course_classification_id" class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Course Classification') }}">{{ __('Course Classification') }}</label>
                        <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" title="Select Course Classification" required>
                            <option value="" selected disabled>{{ __('Select Course Classification') }}</option>
                            @foreach($classifications as $classification)
                             <option value="{{ $classification->course_classification_id }}" {{ $detail->Course_classification_id == $classification->course_classification_id ? 'selected' : '' }}>
                                {{ $classification->course_classification_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="course_classification_detailsname" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Classification Detail Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_detailsname" name="course_classification_detailsname" title="Classification Detail Name" value="{{ $detail->course_classification_detailsname }}" required>
                    </div>
                    <div>
                        <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }} <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" title="Display Order" value="{{ $detail->display_order }}" required>
                    </div>
                    <div>
                        <label for="icon_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Course Classification Detail Icon') }}</label>
                        <input type="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" title="Course Classification Detail Icon" id="icon_file_path" name="icon_file_path" onchange="previewIcon(this)">
                        <img id="icon_preview" src="{{ $detail->icon_url ?? '' }}" alt="Current Icon" class="mt-2 max-w-[100px] rounded border border-slate-200">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="reset" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200" title="{{ __('Reset') }}"><i class="fas fa-undo mr-1"></i> {{ __('Reset') }}</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="{{ __('Update') }}"><i class="fas fa-edit"></i> {{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="detailImagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-xl border border-slate-200 overflow-hidden shadow-xl">
            <div class="modal-header px-5 py-4 bg-blue-900 text-white">
                <h5 class="modal-title font-semibold text-white">{{ __('Image Lightbox') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-6 text-center">
                <img id="detailImagePreviewTarget" src="" alt="{{ __('Image Lightbox') }}" class="max-w-full max-h-[70vh] mx-auto rounded-lg object-contain">
            </div>
        </div>
    </div>
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
