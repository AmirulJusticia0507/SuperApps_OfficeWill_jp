@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Course Classification</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('classifications.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="company_name">Company</label>
                            <select class="form-control" id="company_name" name="company_name" required>
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="classification_name">Classification Name</label>
                            <input type="text" maxlength="10" class="form-control" id="classification_name" name="classification_name" required>
                        </div>
                        <div class="form-group">
                            <label for="icon_file_path">Icon File Path</label>
                            <input type="file" accept="image/*" class="form-control" id="icon_file_path" name="icon_file_path" required>
                        </div>
                        <div class="form-group">
                            <label for="display_order">Display Order</label>
                            <input type="number" min="0" max="999" class="form-control" id="display_order" name="display_order" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sent"></i> Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
