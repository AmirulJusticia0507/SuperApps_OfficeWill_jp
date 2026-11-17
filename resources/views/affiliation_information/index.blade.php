@extends('layouts.app')

@section('content')
<style>
    .affiliation-page { min-height: 100vh; background: #f4f6f9; }
    .affiliation-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .affiliation-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .affiliation-page__content, body.sidebar-collapsed .affiliation-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<div class="affiliation-page">
@include('includes.header')
@include('includes.sidebar')
<main class="affiliation-page__content">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
            <li><a href="#" title="{{ __('Affiliation Master Registration') }}" class="hover:underline">{{ __('Affiliation Master Registration') }}</a></li>
            <li class="before:content-['/'] before:mx-1"><a href="{{ route('affiliation-information.index') }}" title="{{ __('Affiliation List') }}" class="hover:underline">{{ __('Affiliation List') }}</a></li>
            <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Affiliation Information Registration') }}">{{ __('Affiliation Information Registration') }}</li>
        </ol>
    </nav>

    <div class="flex justify-between items-center gap-3 mb-4 flex-wrap">
        <input type="text" id="affiliationSearchBox" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="{{ __('Search table...') }}" style="max-width: 320px;">
        <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition ml-auto" data-bs-toggle="modal" data-bs-target="#createAffiliationModal" title="{{ __('Add Affiliation') }}"><i class="fas fa-plus"></i> {{ __('Add Affiliation') }}</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="List of Affiliation">
            {{ __('Affiliation List') }}
        </div>
        <div class="p-5 overflow-x-auto">
            <table class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%" id="affiliationTable">
                <thead>
                    <tr>
                        <th scope="col" title="{{ __('Affiliation Code') }}">{{ __('Affiliation Code') }}</th>
                        <th scope="col" title="{{ __('Affiliation Name') }}" nowrap>{{ __('Affiliation Name') }}</th>
                        <th scope="col" title="{{ __('Actions') }}">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($affiliations as $affiliation)
                        <tr>
                            <td>{{ $affiliation->affiliation_code }}</td>
                            <td nowrap>{{ $affiliation->affiliation_name }}</td>
                            <td>
                                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200 mr-2" title="Edit Affiliation" data-bs-toggle="modal" data-bs-target="#editAffiliationModal{{ $affiliation->affiliation_code }}">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </button>
                                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition mr-2" title="Delete Affiliation" data-bs-toggle="modal" data-bs-target="#deleteAffiliationModal{{ $affiliation->affiliation_code }}">
                                    <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>
</div>

<!-- Modal for Affiliation Information Form -->
<div class="modal fade" id="createAffiliationModal" tabindex="-1" aria-labelledby="createAffiliationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAffiliationModalLabel">{{ __('Affiliation Information Form') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('affiliation-information.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Name') }}: <b style="color: red">*</b></label>
                        <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" id="company_name" name="company_name" title="Company Name" required>
                            <option value="" selected disabled title="{{ __('Select Company') }}">{{ __('Select Company') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="affiliation_code" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation Code') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Affiliation Code" id="affiliation_code" name="affiliation_code" required>
                    </div>
                    <div class="mb-4">
                        <label for="affiliation_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation Name') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Affiliation Name" id="affiliation_name" name="affiliation_name" required>
                    </div>
                    <div class="mb-4">
                        <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Display Order" id="display_order" name="display_order">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Organization Type') }}">{{ __('Organization Type') }}: <b style="color: red">*</b></label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <input class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" type="radio" name="organization_type" title="Main store equivalent" id="main_store_equivalent" value="Main store equivalent" required>
                                    <label class="text-sm text-slate-700" for="main_store_equivalent">{{ __('Main Office Equivalent') }}</label>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <input class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" type="radio" title="FC Store" name="organization_type" id="fc_store" value="FC Store" required>
                                    <label class="text-sm text-slate-700" for="fc_store">{{ __('Franchise Store') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center flex justify-center gap-2">
                        <button type="reset" title="{{ __('Reset') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                        <button type="submit" title="{{ __('Submit') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-sent"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($affiliations as $affiliation)
<div class="modal fade" id="editAffiliationModal{{ $affiliation->affiliation_code }}" tabindex="-1" aria-labelledby="editAffiliationModalLabel{{ $affiliation->affiliation_code }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAffiliationModalLabel{{ $affiliation->affiliation_code }}">{{ __('Edit Affiliation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('affiliation-information.update', $affiliation->affiliation_code) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="company_name_{{ $affiliation->affiliation_code }}" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Name') }}: <b style="color: red">*</b></label>
                        <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" id="company_name_{{ $affiliation->affiliation_code }}" name="company_name" title="Company Name" required>
                            <option value="" selected disabled title="{{ __('Select Company') }}">{{ __('Select Company') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->company_id }}" {{ $company->company_id == $affiliation->company_id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="affiliation_code_{{ $affiliation->affiliation_code }}" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation Code') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Affiliation Code" id="affiliation_code_{{ $affiliation->affiliation_code }}" name="affiliation_code" value="{{ $affiliation->affiliation_code }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="affiliation_name_{{ $affiliation->affiliation_code }}" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation Name') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Affiliation Name" id="affiliation_name_{{ $affiliation->affiliation_code }}" name="affiliation_name" value="{{ $affiliation->affiliation_name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="display_order_{{ $affiliation->affiliation_code }}" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" title="Display Order" id="display_order_{{ $affiliation->affiliation_code }}" name="display_order" value="{{ $affiliation->display_order }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1" title="{{ __('Organization Type') }}">{{ __('Organization Type') }}: <b style="color: red">*</b></label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <input class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" type="radio" name="organization_type" title="Main store equivalent" id="main_store_equivalent_{{ $affiliation->affiliation_code }}" value="Main store equivalent" {{ $affiliation->organization_type == 'Main store equivalent' ? 'checked' : '' }} required>
                                    <label class="text-sm text-slate-700" for="main_store_equivalent_{{ $affiliation->affiliation_code }}">{{ __('Main Office Equivalent') }}</label>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <input class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" type="radio" title="FC Store" name="organization_type" id="fc_store_{{ $affiliation->affiliation_code }}" value="FC Store" {{ $affiliation->organization_type == 'FC Store' ? 'checked' : '' }} required>
                                    <label class="text-sm text-slate-700" for="fc_store_{{ $affiliation->affiliation_code }}">{{ __('Franchise Store') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center flex justify-center gap-2">
                        <button type="reset" title="{{ __('Reset') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                        <button type="submit" title="{{ __('Submit') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition"><i class="fas fa-save"></i> {{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($affiliations as $affiliation)
<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteAffiliationModal{{ $affiliation->affiliation_code }}" tabindex="-1" aria-labelledby="deleteAffiliationModalLabel{{ $affiliation->affiliation_code }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" title="{{ __('Delete Affiliation') }}" id="deleteAffiliationModalLabel{{ $affiliation->affiliation_code }}">{{ __('Delete Affiliation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p title="{{ __('Are you sure you want to delete this affiliation information?') }}">{{ __('Are you sure you want to delete this affiliation information?') }}</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('affiliation-information.destroy', $affiliation->affiliation_code) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition" title="{{ __('Cancel') }}" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" title="{{ __('Delete Affiliation') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include('includes.footer')

@endsection

@section('scripts')
    <!-- Script DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Script for Modals -->
    <script>
        $(document).ready(function () {
            var table = $('#affiliationTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip',
                buttons: ['copy', 'excel', 'pdf']
            });
            $('#affiliationSearchBox').on('keyup', function () { table.search(this.value).draw(); });
        });
    </script>
@endsection
