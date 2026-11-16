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
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <!-- Kolom untuk tabel -->
            <div class="col-md-8">
                <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" title="{{ __('Affiliation Master Registration') }}">{{ __('Affiliation Master Registration') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('affiliation-information.index') }}" title="{{ __('Affiliation List') }}">{{ __('Affiliation List') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="{{ __('Affiliation Information Registration') }}">{{ __('Affiliation Information Registration') }}</li>
                    </ol>
                </nav>
                <div class="master-page__toolbar">
                    <input type="text" id="affiliationSearchBox" class="form-control master-page__search" placeholder="{{ __('Search table...') }}">
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#createAffiliationModal" title="{{ __('Add Affiliation') }}"><i class="fas fa-plus"></i> {{ __('Add Affiliation') }}</button><br><br>
                </div>
                <div class="card">
                    <div class="card-header" title="List of Affiliation" style="background-color: darkblue">
                        <b style="color: aliceblue">{{ __('Affiliation List') }}</b>
                    </div>
                    <!-- Button to open Affiliation Information Form Modal -->
                    
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="affiliationTable">
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
                                            <button type="button" class="btn btn-light me-2" title="Edit Affiliation" data-bs-toggle="modal" data-bs-target="#editAffiliationModal{{ $affiliation->affiliation_code }}">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </button>
                                            <button type="button" class="btn btn-dark me-2" title="Delete Affiliation" data-bs-toggle="modal" data-bs-target="#deleteAffiliationModal{{ $affiliation->affiliation_code }}">
                                                <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                                    <div class="form-group">
                                        <label for="company_name">{{ __('Company Name') }}: <b style="color: red">*</b></label>
                                        <select class="form-select" id="company_name" name="company_name" title="Company Name" required>
                                            <option value="" selected disabled title="{{ __('Select Company') }}">{{ __('Select Company') }}</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="affiliation_code">{{ __('Affiliation Code') }}: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" title="Affiliation Code" id="affiliation_code" name="affiliation_code" style="display: inline-block; width: 81%;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="affiliation_name">{{ __('Affiliation Name') }}: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" title="Affiliation Name" id="affiliation_name" name="affiliation_name" style="display: inline-block; width: 80%;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_order">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" title="Display Order" id="display_order" name="display_order" style="display: inline-block; width: 83%;">
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_type" title="{{ __('Organization Type') }}">{{ __('Organization Type') }}: <b style="color: red">*</b></label>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="organization_type" title="Main store equivalent" id="main_store_equivalent" value="Main store equivalent" required>
                                                    <label class="form-check-label" for="main_store_equivalent">{{ __('Main Office Equivalent') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" title="FC Store" name="organization_type" id="fc_store" value="FC Store" required>
                                                    <label class="form-check-label" for="fc_store">{{ __('Franchise Store') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div align="center">
                                        <button type="reset" title="{{ __('Reset') }}" class="btn btn-light"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary"><i class="fas fa-sent"></i> {{ __('Submit') }}</button>
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
                                    <div class="form-group">
                                        <label for="company_name_{{ $affiliation->affiliation_code }}">{{ __('Company Name') }}: <b style="color: red">*</b></label>
                                        <select class="form-select" id="company_name_{{ $affiliation->affiliation_code }}" name="company_name" title="Company Name" required>
                                            <option value="" selected disabled title="{{ __('Select Company') }}">{{ __('Select Company') }}</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->company_id }}" {{ $company->company_id == $affiliation->company_id ? 'selected' : '' }}>
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="affiliation_code_{{ $affiliation->affiliation_code }}">{{ __('Affiliation Code') }}: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" title="Affiliation Code" id="affiliation_code_{{ $affiliation->affiliation_code }}" name="affiliation_code" value="{{ $affiliation->affiliation_code }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="affiliation_name_{{ $affiliation->affiliation_code }}">{{ __('Affiliation Name') }}: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" title="Affiliation Name" id="affiliation_name_{{ $affiliation->affiliation_code }}" name="affiliation_name" value="{{ $affiliation->affiliation_name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="display_order_{{ $affiliation->affiliation_code }}">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" title="Display Order" id="display_order_{{ $affiliation->affiliation_code }}" name="display_order" value="{{ $affiliation->display_order }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_type_{{ $affiliation->affiliation_code }}" title="{{ __('Organization Type') }}">{{ __('Organization Type') }}: <b style="color: red">*</b></label>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="organization_type" title="Main store equivalent" id="main_store_equivalent_{{ $affiliation->affiliation_code }}" value="Main store equivalent" {{ $affiliation->organization_type == 'Main store equivalent' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="main_store_equivalent_{{ $affiliation->affiliation_code }}">{{ __('Main Office Equivalent') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" title="FC Store" name="organization_type" id="fc_store_{{ $affiliation->affiliation_code }}" value="FC Store" {{ $affiliation->organization_type == 'FC Store' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="fc_store_{{ $affiliation->affiliation_code }}">{{ __('Franchise Store') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div align="center">
                                        <button type="reset" title="{{ __('Reset') }}" class="btn btn-light"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Update') }}</button>
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
                                    <button type="button" class="btn btn-secondary" title="{{ __('Cancel') }}" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    <button type="submit" title="{{ __('Delete Affiliation') }}" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
            @endforeach


            </div>
        </div>
    <!-- </div> -->

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
