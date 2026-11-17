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
        <a href="{{ route('affiliation-information.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition ml-auto" title="{{ __('Add Affiliation') }}"><i class="fas fa-plus"></i> {{ __('Add Affiliation') }}</a>
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
                                <a href="{{ route('affiliation-information.edit', $affiliation->affiliation_code) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200 mr-2" title="Edit Affiliation">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
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
