@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">

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
        <!-- Tombol Create Company Modal -->
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
                                <a data-fancybox="gallery{{ $company->id }}"
                                    data-src="{{ asset($company->icon_storage_file_path) }}"
                                    data-caption="Company Icon">
                                    <img src="{{ asset($company->icon_storage_file_path) }}" alt="Company Icon"
                                    class="company-icon">
                                </a>
                            </td>
                            <td>{{ $company->teaching_material_storage_file_path }}</td>
                            <td>
                                <!-- Tombol Edit Company Modal -->
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



@foreach($companies as $company)
    <div class="modal fade" id="editCompanyModal{{ $company->company_id }}" tabindex="-1" aria-labelledby="editCompanyModalLabel{{ $company->company_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyModalLabel{{ $company->id }}">Edit Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Company -->
                <form method="POST" action="{{ route('company-information.update', $company->company_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Company Name:</label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="company_name" name="company_name" value="{{ $company->company_name }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="login_screen_url" class="block text-sm font-medium text-slate-700 mb-1">Login Screen URL:</label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="login_screen_url" value="{{ asset($company->login_screen_url) }}"  readonly>
                    </div>

                    <div class="mb-4">
                        <label for="icon_storage_file_path" class="block text-sm font-medium text-slate-700 mb-1">Icon Storage File:</label>
                        <input type="file" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="icon_storage_file_path" name="icon_storage_file_path" onchange="previewIcon(this)">
                        <img id="icon_preview" src="{{ asset($company->icon_storage_file_path) }}" alt="Current Icon" style="max-width: 100px;">
                    </div>

                    <div class="mb-4">
                        <label for="teaching_material_storage_file_path" class="block text-sm font-medium text-slate-700 mb-1">Teaching Material Storage File:</label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="teaching_material_storage_file_path" value="{{ asset($company->teaching_material_storage_file_path) }}" readonly>
                    </div>
                    <div class="flex justify-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-pen"></i> Update</button>
                        <button type="reset" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-power-off"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>

@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
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
    $(document).ready(function () {
        $("[data-fancybox]").fancybox({});
    });

</script>
@endsection

@section('scripts')
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
