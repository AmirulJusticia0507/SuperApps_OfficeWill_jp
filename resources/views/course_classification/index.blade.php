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
        <div class="col-md-2">
            @include('includes.sidebar')
        </div>
        <div class="col md-6">
            <br><br><br>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" title="Course Classification Registration">コース分類登録</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course-classification.index') }}" title="Course Classification">コース分類</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="Course Classification Registration">コース分類登録</li>
                </ol>
            </nav>
            <!-- Button to Open Modal -->
            <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#createClassificationModal">新しい分類を作成</button>
            <!-- Course Classifications Table -->
            <div class="card">
                <div class="card-header" title="Course Classifications Registration" style="background-color: darkblue">
                    <b style="color:aliceblue">コース分類登録</b>
                </div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationTable">
                        <thead>
                            <tr>
                                <th scope="col" title="ID">id</th>
                                <th scope="col" title="Icon">アイコン</th>
                                <th scope="col" title="Classification Name">分類名</th>
                                <th scope="col" title="Display Order">表示順</th>
                                <th scope="col" title="Actions">行動</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classifications as $classification)
                            <tr>
                                <td>{{ $classification->course_classification_id }}</td>
                                <td>
                                    <img src="{{ asset($classification->icon_file_path) }}" alt="Icon" style="max-width: 100px;">
                                </td>
                                <td>{{ $classification->course_classification_name }}</td>
                                <td>{{ $classification->displayorder }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-light edit-btn" data-bs-toggle="modal" data-bs-target="#editClassificationModal{{ $classification->course_classification_id }}" title="Edit">
                                        <i class="fas fa-edit"></i> 編集
                                    </button>
                                    <form action="{{ route('course-classifications.destroy', $classification->course_classification_id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-dark" onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="fas fa-trash"></i> 消去
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Classification Modal -->
                            <div class="modal fade" id="editClassificationModal{{ $classification->course_classification_id }}" tabindex="-1" aria-labelledby="editClassificationModalLabel{{ $classification->course_classification_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editClassificationModalLabel{{ $classification->course_classification_id }}">Edit Classification</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form Edit Classification -->
                                            <form method="POST" action="{{ route('course-classifications.update', $classification->course_classification_id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="company_name">Company:</label>
                                                    <select class="form-select" id="company_name" name="company_name" required>
                                                        <option value="" selected disabled>Select Company</option>
                                                        @foreach($companies as $company)
                                                        <option value="{{ $company->company_name }}" {{ $company->company_id == $classification->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="classification_name">Classification Name:</label>
                                                    <input type="text" class="form-control" id="classification_name" name="classification_name" value="{{ $classification->course_classification_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="icon_file_path">Icon Storage File:</label>
                                                    <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" onchange="previewIcon(this)">
                                                    <img id="icon_preview" src="{{ $classification->icon_file_path }}" alt="Current Icon" style="max-width: 100px;">
                                                </div>
                                                <div class="form-group">
                                                    <label for="display_order">Display Order:</label>
                                                    <input type="number" class="form-control" id="display_order" name="display_order" value="{{ $classification->displayorder }}" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-dark"><i class="fas fa-power-off"></i> Reset</button>
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-pen"></i> Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Create Classification Modal -->
                <div class="modal fade" id="createClassificationModal" tabindex="-1" aria-labelledby="createClassificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: darkblue">
                                <h5 class="modal-title" id="createClassificationModalLabel" style="color:aliceblue">分類を作成します</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Create Classification -->
                                <form method="POST" action="{{ route('classifications.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">会社</label>
                                        <select class="form-select" id="company_name" name="company_name" required>
                                            <option value="" selected disabled>Companyを選択します</option>
                                            @foreach($companies as $company)
                                            <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="classification_name" class="form-label" title="Classification Name">分類名 <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="classification_name" name="classification_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon_file_path" class="form-label">アイコンファイルパス</label>
                                        <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" title="Icon File Path" required onchange="previewIcon(this)">
                                        <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">表示順 <span style="color: red">*</span></label>
                                        <input type="number" class="form-control" id="display_order" name="display_order" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-light" title="Reset"><i class="fas fa-undo"></i> リセット</button>
                                        <button type="submit" class="btn btn-primary" title="Submit"><i class="fas fa-send"></i> 提出する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Footer -->
@include('includes.footer')

@endsection

@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#classificationTable').DataTable({
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
