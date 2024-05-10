@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Company Information</div>

                <div class="card-body">
                    <!-- Form Create Company -->
                    <form method="POST" action="{{ route('company-information.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="company_name">Company Name:</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>

                        <div class="form-group">
                            <label for="login_screen_url">Login Screen URL:</label>
                            <input type="text" class="form-control" id="login_screen_url" name="login_screen_url" required>
                        </div>

                        <div class="form-group">
                            <label for="icon_storage_file_path">Icon Storage File:</label>
                            <input type="file" class="form-control" id="icon_storage_file_path" name="icon_storage_file_path" required onchange="previewIcon(this)">
                            <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                        </div>

                        <div class="form-group">
                            <label for="teaching_material_storage_file_path">Teaching Material Storage File:</label>
                            <input type="file" class="form-control" id="teaching_material_storage_file_path" name="teaching_material_storage_file_path" required onchange="previewMaterial(this)">
                            <img id="material_preview" src="#" alt="Preview Material" style="max-width: 100px; display: none;">
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-info"><i class="fas fa-sent"></i> Submit</button>
                            <button type="reset" class="btn btn-danger"><i class="fas fa-reset"></i> Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewIcon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#icon_preview').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMaterial(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#material_preview').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
