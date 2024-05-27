@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@section('content')
<!-- Header -->
@include('includes.header')
{{-- <div class="container"> --}}
<div class="row justify-content-center">
    <!-- Sidebar -->
    <div class="col-md-3">
        @include('includes.sidebar')
    </div>
    <div class="col-md-8">
    <br><br><br>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" title="Company Information">企業情報 </a></li>
                <li class="breadcrumb-item"><a href="{{ route('company-information.index') }}" title="Create Company">会社を作成します</a></li>
                <li class="breadcrumb-item active" aria-current="page" title="Company Information">企業情報</li>
            </ol>
        </nav>
        <!-- Tombol Create Company Modal -->
        <div class="text-right">
            <button class="btn btn-primary mb-3 open-modal" data-url="{{route('company-information.create')}}"><i class="fas fa-plus"></i> 会社を作成します</button>&emsp;
        </div>
        <div class="card">
            <div class="card-header" style="background-color: darkblue" title="Company Information"><b style="color:aliceblue">企業情報</b></div>
            <div class="card-body">
            @if(count($companies) > 0)
                <table class="display table table-bordered table-striped table-hover responsive nowrap"
                    style="width:100%" id="companyTable">
                    <thead>
                        <tr>
                            <th scope="col" title="Company Name">会社名</th>
                            <th scope="col" title="Login Screen URL">ログイン画面URL</th>
                            <th scope="col" title="Icon">アイコン</th>
                            <th scope="col" title="Teaching Material">教材</th>
                            <th scope="col" title="Actions">行動</th>
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
                                        style="max-width: 100px;">
                                </a>
                            </td>
                            <td>{{ $company->teaching_material_storage_file_path }}</td>
                            <td>
                                <!-- Tombol Edit Company Modal -->
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editCompanyModal{{ $company->company_id }}" title="Edit"><i class="fas fa-edit"></i> 編集</button>
                                <!-- Form Delete Company -->
                                <form action="{{ route('company-information.destroy', $company->company_id) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i> 消去</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>No companies found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- </div> --}}


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
                    <div class="form-group">
                        <label for="company_name">Company Name:</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $company->company_name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="login_screen_url">Login Screen URL:</label>
                        <input type="text" class="form-control" id="login_screen_url" value="{{ asset($company->login_screen_url) }}"  readonly>
                    </div>

                    <div class="form-group">
                        <label for="icon_storage_file_path">Icon Storage File:</label>
                        <input type="file" class="form-control" id="icon_storage_file_path" name="icon_storage_file_path" onchange="previewIcon(this)">
                        <img id="icon_preview" src="{{ asset($company->icon_storage_file_path) }}" alt="Current Icon" style="max-width: 100px;">
                    </div>

                    <div class="form-group">
                        <label for="teaching_material_storage_file_path">Teaching Material Storage File:</label>
                        <input type="text" class="form-control" id="teaching_material_storage_file_path" value="{{ asset($company->teaching_material_storage_file_path) }}" readonly>
                    </div>
                    <div align="center">
                        <button type="submit" class="btn btn-info"><i class="fas fa-pen"></i> Update</button>&emsp;
                        <button type="reset" class="btn btn-dark"><i class="fas fa-power-off"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<!-- Script for Modals -->
<script>
    // Function to show modal when the button is clicked
    const createCompanyModal = new bootstrap.Modal(document.getElementById('createCompanyModal'));
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
