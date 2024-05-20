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
                <div class="card-header" title="Course Classification Details" style="background-color: darkblue"><b style="color:aliceblue">コース分類の詳細</b></div>
                <div class="card-body">
                    <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="classificationdetailsTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col" title="Classification Name">分類名</th>
                                <th scope="col" title="Classification Detail Name">分類詳細名</th>
                                {{-- <th scope="col">Icon File Path</th> --}}
                                {{-- <th scope="col">Display Order</th> --}}
                                {{-- <th scope="col">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @if($details->isNotEmpty())
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $detail->course_classification_details_id }}</td>
                                        <td>{{ $detail->classification->course_classification_name ?? '' }}</td>
                                        <td>{{ $detail->course_classification_detailsname }}</td>
                                        <!-- <td>
                                            <button type="button" class="btn btn-sm btn-info edit-btn" data-detail="{{ json_encode($detail) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('details.destroy', $detail->course_classification_details_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</button>
                                            </form>
                                        </td> -->
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

        <!-- Kolom untuk form -->
        <div class="col md-2">
            <br><br><br><br><br>
            <div class="card">
                <div class="card-header" style="background-color: darkblue" title="Course Classification Detail"><b style="color:aliceblue">コース分類の詳細</b> <b style="color: red">*</b><p style="color: aliceblue" title="This is a required field.">これは必要項目です。</p></div>
                <div class="card-body">
                    <form id="classificationDetailsForm" action="{{ route('details.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="company_name" class="form-label">会社</label>
                            <input type="hidden" id="selectedCompanyId" title="Company" name="company_id" value="{{ isset($editClassification) ? $editClassification->company_id : '' }}">
                            <select class="form-select" id="company_name" name="company_id" required>
                                <option value="" selected disabled title="Select Company">Companyを選択します</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->company_id }}" @if(isset($editClassification) && $editClassification->company_id == $company->company_id) selected @endif>{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="course_classification_id" class="form-label" title="Course Classification">コース分類</label>
                            <select class="form-select" id="course_classification_id" name="Course_classification_id" title="Select Course Classification" required>
                                <option value="" selected disabled>コース分類を選択します</option>
                                @foreach($classifications as $classification)
                                <option value="{{ $classification->course_classification_id }}">{{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="course_classification_detailsname" class="form-label">分類詳細名 <b style="color: red">*</b></label>
                            <input type="text" class="form-control" id="course_classification_detailsname" title="Classification Detail Name" name="course_classification_detailsname" required style="display: inline-block; width: 75%;">
                        </div>
                        <div class="mb-3">
                            <label for="display_order" class="form-label">ランキングを表示します <b style="color: red">*</b></label>
                            <input type="number" class="form-control" id="display_order" name="display_order" title="Display Ranking" required style="display: inline-block; width: 84%;">
                        </div>
                        <div class="mb-3">
                            <label for="icon_file_path" class="form-label">コース分類の詳細アイコン </label>
                            <input type="file" class="form-control" id="icon_file_path" name="icon_file_path" title="Course classification details icon" style="display: inline-block; width: 72%;">
                        </div><br><br>
                        <div align="center">
                            <button type="reset" class="btn btn-light" title="Reset"><i class="fas fa-undo"></i> リセット</button>
                            <button type="submit" class="btn btn-primary" title="Submit"><i class="fas fa-sent"></i> 提出する</button>
                            <button type="button" class="btn btn-dark" id="deleteButton" title="Delete"><i class="fas fa-trash"></i> 消去</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}

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
        var table = $('#classificationdetailsTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });

        // Edit Button Click Event
        $('.edit-btn').click(function() {
            var detailData = $(this).data('detail');

            // Set Form Action and Method for Edit
            $('#classificationDetailsForm').attr('action', '/details/' + detailData.course_classification_details_id);
            $('#classificationDetailsForm').append('<input type="hidden" name="_method" value="PUT">');

            // Fill Form Fields with Data
            $('#course_classification_detailsname').val(detailData.course_classification_detailsname);
            $('#icon_file_path').val(detailData.icon_file_path);
            $('#display_order').val(detailData.display_order);

            // Fill Company Data
            $('#selectedCompanyId').val(detailData.company_id);
            $('#company_name').val(detailData.company_id);

            // Scroll to Form
            $('html, body').animate({
                scrollTop: $('#classificationDetailsForm').offset().top
            }, 500);

            // Show Form
            $('#classificationDetailsForm').show();
            $('#saveBtn').html('<i class="fas fa-save"></i> Save Changes');
        });
    });
</script>
@endsection
