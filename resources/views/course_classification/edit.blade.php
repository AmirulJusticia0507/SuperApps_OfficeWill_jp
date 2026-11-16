@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Course Classification</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('course-classifications.update', $classification->course_classification_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="company_name">Company</label>
                            <select class="form-control" id="company_name" name="company_name" required>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->company_name }}" @selected($company->company_id == $classification->company_id)>{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="classification_name">Classification Name</label>
                            <input type="text" class="form-control" id="classification_name" name="classification_name" maxlength="10" value="{{ $classification->course_classification_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="icon_file_path">Icon File Path</label>
                            <input type="file" accept="image/*" class="form-control" id="icon_file_path" name="icon_file_path">
                            <img src="{{ $classification->icon_url ?? '' }}" alt="Current icon" style="max-width: 100px;">
                        </div>
                        <div class="form-group">
                            <label for="displayorder">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="{{ (int) $classification->displayorder }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
