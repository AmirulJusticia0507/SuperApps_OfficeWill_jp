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
            <div class="col-md-4">
                <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Affiliation Master Registration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('affiliation-information.index') }}">Affiliation List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Affiliation Information Registration</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue">
                        <b style="color: aliceblue">List of Affiliation</b>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="affiliationTable">
                            <thead>
                                <tr>
                                    <th scope="col">Affiliation Code</th>
                                    <th scope="col" nowrap>Affiliation Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($affiliations as $affiliation)
                                    <tr>
                                        <td>{{ $affiliation->affiliation_code }}</td>
                                        <td nowrap>{{ $affiliation->affiliation_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kolom untuk form -->
            <div class="col-md-4">
                <br><br><br>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue">
                        <b style="color: aliceblue">Affiliation Information Form</b>
                        <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('affiliation-information.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="company_name">Company Name: <b style="color: red">*</b></label>
                                <select class="form-select" id="company_name" name="company_name" required>
                                    <option value="" selected disabled>Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="affiliation_code">Affiliation Code: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="affiliation_code" name="affiliation_code">
                            </div>
                            <!-- <div class="form-group">
                                <label for="company_id">Company ID:</label>
                                <input type="text" class="form-control" id="company_id" name="company_id">
                            </div> -->
                            <div class="form-group">
                                <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="affiliation_name" name="affiliation_name">
                            </div>
                            <div class="form-group">
                                <label for="display_order">Display Order: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="display_order" name="display_order">
                            </div>
                            <div class="form-group">
                                <label for="organization_type">Organization Type: <b style="color: red">*</b></label>
                                <div class="row">
                                    <div class="form-check">
                                        &emsp;<input class="form-check-input" type="radio" name="organization_type" id="main_store_equivalent" value="Main store equivalent" required>
                                        <label class="form-check-label" for="main_store_equivalent"> Main store equivalent</label>
                                    {{-- </div>
                                    <div class="form-check"> --}}
                                        &emsp;&emsp;<input class="form-check-input" type="radio" name="organization_type" id="fc_store" value="FC Store" required>
                                        <label class="form-check-label" for="fc_store">FC Store</label>
                                    </div>
                                </div>
                            </div>
                            <div align="center">
                                <button type="reset" class="btn btn-light"><i class="fas fa-undo"></i> Reset</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                                <button type="button" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->

    <!-- Footer -->
    @include('includes.footer')

@endsection

@section('scripts')
<!-- Script DataTables -->
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
    });

</script>
@endsection
