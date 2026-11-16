@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Affiliation Information</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('affiliation-information.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="company_name">Company:</label>
                            <select class="form-control" id="company_name" name="company_name" required>
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="affiliation_code">Affiliation Code:</label>
                            <input type="number" min="0" max="999" class="form-control" id="affiliation_code" name="affiliation_code" required>
                        </div>
                        <div class="form-group">
                            <label for="affiliation_name">Affiliation Name:</label>
                            <input type="text" class="form-control" id="affiliation_name" name="affiliation_name">
                        </div>
                        <div class="form-group">
                            <label for="display_order">Display Order:</label>
                            <input type="number" min="0" max="999" class="form-control" id="display_order" name="display_order" required>
                        </div>
                        <div class="form-group">
                            <label for="organization_type">Organization Type:</label>
                            {{-- <input type="text" class="form-control" id="organization_type" name="organization_type"> --}}
                            <div class="col-md-3">
                                <input type="radio" name="organization_type" id="main_store_equivalent" value="Main store equivalent" required>
                                <label for="retest_availability"> Main store equivalent</label>
                            </div>
                            <div class="col-md-3">
                                <input type="radio" name="organization_type" id="fc_store" value="FC Store" required>
                                <label for="fc_store"> FC Store</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info"><i class="fas fa-sent"></i> Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
