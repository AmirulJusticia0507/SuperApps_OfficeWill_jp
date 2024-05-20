@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('includes.header')

    <div class="container">
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
                        <li class="breadcrumb-item"><a href="#" title="Job Title/Position Master Registration">役職/ポジションマスター登録</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('job-titles.index') }}" title="Job/Position Master Registration">ジョブ/ポジションマスター登録</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="Job Title/Position Master Registration">役職/ポジションマスター登録</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" title="List of Job Titles" style="background-color: darkblue">
                        <b style="color: aliceblue">ジョブタイトルのリスト</b>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="jobTitleTable">
                            <thead>
                                <tr>
                                    <th scope="col" title="Job ID">ジョブID</th>
                                    {{-- <th scope="col">Company ID</th> --}}
                                    <th scope="col" title="Job Title">役職</th>
                                    {{-- <th scope="col">Display Order</th> --}}
                                    <!-- <th scope="col" nowrap>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobTitles as $jobTitle)
                                    <tr>
                                        <td>{{ $jobTitle->Job_id }}</td>
                                        {{-- <td>{{ $jobTitle->company_id }}</td> --}}
                                        <td>{{ $jobTitle->job_title }}</td>
                                        {{-- <td>{{ $jobTitle->display_order }}</td> --}}
                                        <!-- <td nowrap>
                                            <a href="{{ route('job-titles.show', $jobTitle->Job_id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                                            <a href="{{ route('job-titles.edit', $jobTitle->Job_id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                            <form action="{{ route('job-titles.destroy', $jobTitle->Job_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                            </form>
                                        </td> -->
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
                    <div class="card-header" title="Job Title Information Form" style="background-color: darkblue">
                        <b style="color: aliceblue">役職情報フォーム</b>
                        <b style="color: red">*</b><p style="color: aliceblue" title="This is a required field.">これは必要項目です。</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('job-titles.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="job_title">役職: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="job_title" name="job_title" title="Job Title" style="display: inline-block; width: 80%;" required>
                            </div>
                            <div class="form-group">
                                <label for="display_order">表示順: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" title="Display Order" id="display_order" name="display_order" style="display: inline-block; width: 71%;" required>
                            </div>
                            <div align="center">
                                <button type="reset" title="Reset" class="btn btn-light"><i class="fas fa-undo"></i> リセット</button>
                                <button type="submit" title="Submit" class="btn btn-primary"><i class="fas fa-sent"></i> 提出する</button>
                                <button type="button" title="Delete" class="btn btn-dark" id="deleteButton"><i class="fas fa-trash"></i> 消去</button>
                            </div>
                        </form>
                    </div>
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
<!-- Script for DataTables -->
<script>
    $(document).ready(function () {
        var table = $('#jobTitleTable').DataTable({
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
