@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
<style>
    .company-page { min-height: 100vh; background: #f4f6f9; }
    .company-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .company-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    .company-page table { min-width: 760px; }
    .company-page .company-icon { width: 5rem; height: 4rem; object-fit: contain; }
    @media (max-width: 767.98px) {
        .company-page__content, body.sidebar-collapsed .company-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<div class="company-page">
<!-- Header -->
@include('includes.header')
@include('includes.sidebar')
<main class="company-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Company Information') }}" class="hover:text-blue-600">{{ __('Company Information') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('company-information.index') }}" title="{{ __('Company Registration') }}" class="hover:text-blue-600">{{ __('Company Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Company Information') }}">{{ __('Company Information') }}</li>
            </ol>
        </nav>
        <!-- Tombol Create Company -->
        <div class="flex justify-between items-center gap-3 mb-4 flex-wrap">
            <input type="text" id="customSearchBox" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 max-w-xs" placeholder="{{ __('Search table...') }}">
            <a href="{{ route('company-information.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-plus"></i> {{ __('Add Company') }}</a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Company Information') }}">{{ __('Company Information') }}</div>
            <div class="p-5 overflow-x-auto">
            @if(count($companies) > 0)
                <table class="display table table-bordered table-striped table-hover responsive nowrap"
                    style="width:100%" id="companyTable">
                    <thead>
                        <tr>
                            <th scope="col" title="{{ __('Company Name') }}">{{ __('Company Name') }}</th>
                            <th scope="col" title="{{ __('Login Screen URL') }}">{{ __('Login Screen URL') }}</th>
                            <th scope="col" title="{{ __('Icon') }}">{{ __('Icon') }}</th>
                            <th scope="col" title="{{ __('Teaching Materials') }}">{{ __('Teaching Materials') }}</th>
                            <th scope="col" title="{{ __('Actions') }}">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ $company->company_name }}</td>
                            <td>{{ $company->login_screen_url }}</td>
                            <td>
                                @if($company->icon_storage_file_path)
                                    <img src="{{ asset($company->icon_storage_file_path) }}"
                                         alt="Company Icon"
                                         class="company-icon cursor-pointer hover:opacity-80 transition rounded"
                                         data-bs-toggle="modal"
                                         data-bs-target="#companyImageModal"
                                         data-image-src="{{ asset($company->icon_storage_file_path) }}"
                                         data-caption="{{ $company->company_name }}">
                                @else
                                    <span class="text-xs text-slate-400 italic">{{ __('No image') }}</span>
                                @endif
                            </td>
                            <td>{{ $company->teaching_material_storage_file_path }}</td>
                            <td>
                                <!-- Tombol Edit Company -->
                                <a href="{{ route('company-information.edit', $company->company_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition" title="{{ __('Edit') }}"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                                <!-- Form Delete Company -->
                                <form action="{{ route('company-information.destroy', $company->company_id) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition" title="{{ __('Delete') }}"><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>{{ __('No companies found.') }}</p>
                @endif
            </div>
        </div>
</main>


<!-- Footer -->
@include('includes.footer')

<!-- Company Image Lightbox Modal -->
<div class="modal fade" id="companyImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-xl border-0 overflow-hidden shadow-2xl">
            <div class="modal-header px-5 py-4 bg-blue-900 text-white">
                <h5 class="modal-title font-semibold text-white" id="companyImageModalTitle">Company Icon</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-6 bg-white text-center">
                <img id="companyImageTarget" src="" alt="Company Icon" class="max-w-full max-h-[70vh] mx-auto rounded-lg object-contain">
            </div>
        </div>
    </div>
</div>

</div>

@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Image Lightbox: set src via Bootstrap modal show event (relatedTarget)
    var companyImageModal = document.getElementById('companyImageModal');
    if (companyImageModal) {
        companyImageModal.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;
            var src = trigger ? trigger.getAttribute('data-image-src') : '';
            var caption = trigger ? trigger.getAttribute('data-caption') : 'Company Icon';
            document.getElementById('companyImageTarget').src = src || '';
            document.getElementById('companyImageModalTitle').textContent = caption || 'Company Icon';
        });
        companyImageModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('companyImageTarget').src = '';
        });
    }

    $(document).ready(function () {
        var table = $('#companyTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });

        // Custom search box
        $('#customSearchBox').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>

<script>
    function previewIcon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#icon_preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMaterial(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#material_preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
