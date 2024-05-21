@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
<!-- Header -->
@include('includes.header')

{{-- <div class="container"> --}}
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <!-- Kolom untuk tabel -->
        <div class="col md-4">
            <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" title="Course Classification Details Registration">コース分類の詳細登録</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-classification-details.index') }}" title="Course Classification Details">コース分類の詳細</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="Course Classification Details Registration">コース分類の詳細登録</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" title="Course Classification Details" style="background-color: darkblue">
                        <b style="color:aliceblue">コース分類の詳細</b>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createDetailModal" title="Create New Details"><i class="fas fa-plus"></i> 新しい詳細を作成します</button>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationdetailsTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col" title="Classification Name">分類名</th>
                                    <th scope="col" title="Classification Detail Name">分類詳細名</th>
                                    <th scope="col" title="Icon">アイコン</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($details->isNotEmpty())
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td>{{ $detail->course_classification_details_id }}</td>
                                            <td>{{ $detail->classification->course_classification_name ?? '' }}</td>
                                            <td>{{ $detail->course_classification_detailsname }}</td>
                                            <td>
                                                @if($detail->icon_file_path)
                                                    <img src="{{ asset('storage/' . $detail->icon_file_path) }}" alt="Icon" style="max-width: 100px;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info edit-btn" title="Edit" data-bs-toggle="modal" data-bs-target="#editDetailModal{{ $detail->course_classification_details_id }}">
                                                    <i class="fas fa-edit"></i> 編集
                                                </button>
                                                <form action="{{ route('details.destroy', $detail->course_classification_details_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> 消去</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No data found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
<!-- Footer -->
@include('includes.footer')
@endsection

                <!-- Create Detail Modal -->
                <div class="modal fade" id="createDetailModal" tabindex="-1" aria-labelledby="createDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createDetailModalLabel" title="Create Course Classification Detail">コース分類の詳細を作成します</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="createDetailForm" action="{{ route('details.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label" title="Company">会社</label>
                                        <input type="hidden" id="selectedCompanyId" name="company_id"
                                            value="{{ isset($editClassification) ? $editClassification->company_id : '' }}">
                                        <select class="form-select" id="company_name" name="company_id" title="Select Company" required>
                                            <option value="" selected disabled>Companyを選択します</option>
                                            @foreach($companies as $company)
                                            <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_id" class="form-label" title="Course Classification">コース分類</label>
                                        <select class="form-select" id="course_classification_id" name="Course_classification_id" title="Select Course Classification" required>
                                            <option value="" selected disabled>コース分類を選択します</option>
                                            @foreach($classifications as $classification)
                                            <option value="{{ $classification->course_classification_id }}">
                                                {{ $classification->course_classification_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_detailsname" class="form-label" title="Classification Detail Name">分類詳細名
                                            <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="course_classification_detailsname"
                                            name="course_classification_detailsname" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label" title="Display Order">表示順 <span
                                                style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label" title="Course Classification Detail Icon">コース分類の詳細アイコン</label>
                                        <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" required onchange="previewIcon(this)">
                                        <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                                    </div><br><br>
                                    <div align="center">
                                        <button type="reset" class="btn btn-light" title="Reset" data-bs-dismiss="modal"><i
                                                class="fas fa-undo"></i> リセット</button>
                                        <button type="submit" class="btn btn-primary" title="Submit"><i class="fas fa-send"></i> 提出する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Detail Modals -->
                @foreach($details as $detail)
                <div class="modal fade" id="editDetailModal{{ $detail->course_classification_details_id }}" tabindex="-1" aria-labelledby="editDetailModalLabel{{ $detail->course_classification_details_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDetailModalLabel{{ $detail->course_classification_details_id }}" title="Edit Course Classification Detail">コース分類の詳細を編集します</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editDetailForm{{ $detail->course_classification_details_id }}" action="{{ route('course-classification-details.update', $detail->course_classification_details_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label" title="Company">会社</label>
                                        <input type="hidden" id="selectedCompanyId" name="company_id" value="{{ isset($editClassification) ? $editClassification->company_id : '' }}">
                                        <select class="form-select" id="company_name" name="company_id" title="Select Company" required>
                                            <option value="" selected disabled>Companyを選択します</option>
                                            @foreach($companies as $company)
                                            <option value="{{ $company->company_id }}" {{ $detail->company_id == $company->company_id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_id" class="form-label" title="Course Classification">コース分類</label>
                                        <select class="form-select" id="course_classification_id" name="Course_classification_id" title="Select Course Classification" required>
                                            <option value="" selected disabled>コース分類を選択します</option>
                                            @foreach($classifications as $classification)
                                            <option value="{{ $classification->course_classification_id }}" {{ $detail->Course_classification_id == $classification->course_classification_id ? 'selected' : '' }}>
                                                {{ $classification->course_classification_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="course_classification_detailsname" class="form-label">分類詳細名
                                            <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="course_classification_detailsname" name="course_classification_detailsname" title="Classification Detail Name" value="{{ $detail->course_classification_detailsname }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">表示順 <span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" title="Display Order" value="{{ $detail->display_order }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label">コース分類の詳細アイコン</label>
                                        <input type="file" class="form-control" title="Course Classification Detail Icon" id="icon_file_path" name="icon_file_path" onchange="previewIcon(this)">
                                        <img id="icon_preview" src="{{ $detail->icon_file_path ? asset('storage/' . $detail->icon_file_path) : '' }}" alt="Current Icon" style="max-width: 100px;">
                                    </div><br><br>
                                    <div align="center">
                                        <button type="submit" class="btn btn-info" title="Update"><i class="fas fa-pen"></i> アップデート</button>&emsp;
                                        <button type="reset" class="btn btn-dark" title="Reset"><i class="fas fa-power-off"></i> リセット</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#classificationdetailsTable').DataTable({
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
    function previewIcon(input) {
        var preview = input.nextElementSibling;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
