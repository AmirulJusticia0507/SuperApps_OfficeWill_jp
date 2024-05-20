@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
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
        <div class="col-md-3">
            <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" title="Course Classification Registration">コース分類登録</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-classification.index') }}" title="Course Classification">コース分類</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="Course Classification Registration">コース分類登録</li>
                    </ol>
                </nav>
            <!-- Course Classifications Table -->
            <div class="card">
                <div class="card-header" title="Course Classifications Registration" style="background-color: darkblue"><b style="color:aliceblue">コース分類登録</b></div>
                <div class="card-body">
                <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationTable">
                                <thead>
                                    <tr>
                                        <th scope="col" title="ID">id</th>
                                        <th scope="col" title="Classification Name">分類名</th>
                                        <th scope="col" title="Display Order">表示順</th>
                                        {{-- <th scope="col">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($classifications as $classification)
                                <tr>
                                    <td>{{ $classification->course_classification_id }}</td>
                                    <td>{{ $classification->course_classification_name }}</td>
                                    <td>{{ $classification->displayorder }}</td>
                                    {{-- <td>
                                        <a href="{{ route('classifications.edit', $classification->course_classification_id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    </td> --}}
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <br><br><br><br><br>
            <!-- Create/Edit Classification Form -->
            <div class="card mb-5">
                <div class="card-header" style="background-color: darkblue" title="Create / Edit Classification"><b style="color:aliceblue">分類を作成 /編集します</b> <b style="color: red">*</b><p style="color: aliceblue" title="This is a required field.">これは必要項目です。</p></div>
                    <div class="card-body">
                        <!-- Form Create/Edit Classification -->
                        <form method="POST" action="{{ isset($editClassification) ? route('classifications.update', $editClassification->course_classification_id) : route('classifications.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if(isset($editClassification))
                                @method('PUT')
                                @endif
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">会社</label>
                                    <input type="hidden" id="selectedCompanyId" name="company_id" value="{{ isset($editClassification) ? $editClassification->company_id : '' }}" title="Company">
                                    <select class="form-select" id="company_name" name="company_name" required>
                                        <option value="" selected disabled title="Select Company">Companyを選択します</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->company_name }}" {{ isset($editClassification) && $editClassification->company_id == $company->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="classification_name" class="form-label" title="Classification Name">分類名 <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="classification_name" name="classification_name" value="{{ isset($editClassification) ? $editClassification->course_classification_name : '' }}" required style="display: inline-block; width: 79%;">
                                </div>
                                <div class="mb-3">
                                    <label for="icon_file_path" class="form-label">アイコンファイルパス</label>
                                    <!-- Field untuk mengunggah file ikon -->
                                    <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" style="display: inline-block; width: 86%;" title="Icon File Path">
                                </div>
                                <div class="mb-3">
                                    <label for="display_order" class="form-label">表示順 <span style="color: red">*</span></label>
                                    <input type="number" class="form-control" id="display_order" name="display_order" value="{{ isset($editClassification) ? $editClassification->displayorder : '' }}" required style="display: inline-block; width: 84%;" title="Display Order">
                                </div>
                                <div align="center">
                                    <button type="reset" class="btn btn-light" title="Reset"><i class="fas fa-undo"></i> リセット</button>
                                    <button type="submit" class="btn btn-primary" title="Submit"><i class="fas fa-send"></i> 提出する</button>
                                    @if(isset($editClassification))
                                    <button type="button" class="btn btn-dark" title="Delete" id="deleteButton"><i class="fas fa-trash"></i> 消去</button>
                                    @endif
                                </div>
                            </form>
                    </div>
                </div>
        </div>


    </div><br><br><br><br><br><br><br><br><br><br><br><br>
{{-- </div> --}}

<!-- Footer -->
@include('includes.footer')

@endsection


@section('scripts')
<!-- Script DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Script for Modals -->
<script>
    // Function to show modal when the button is clicked
    // const createClassificationModal = new bootstrap.Modal(document.getElementById('createClassificationModal'));
    $(document).ready(function () {
            var table = $('#classificationTable').DataTable({
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
