@extends('layouts.app')

@section('content')
    <!-- Header -->
    @include('includes.header')

    <!-- <div class="container"> -->
        <div class="row justify-content-center">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>

            <!-- Kolom untuk tabel -->
            <div class="col-md-8">
                <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" title="Job Title/Position Master Registration">役職/ポジションマスター登録</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('job-titles.index') }}" title="Job/Position Master Registration">ジョブ/ポジションマスター登録</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="Job Title/Position Master Registration">役職/ポジションマスター登録</li>
                    </ol>
                </nav>
                <div align="right">
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#createJobTitleModal" title="Add Job Title"><i class="fas fa-plus"></i> 役職を追加する</button>&emsp;&emsp;
                    <br><br>
                </div>
                <div class="card">
                    <div class="card-header" title="List of Job Titles" style="background-color: darkblue">
                        <b style="color: aliceblue">ジョブタイトルのリスト</b>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="jobTitleTable">
                            <thead>
                                <tr>
                                    <th scope="col" title="Job ID">ジョブID</th>
                                    <th scope="col" title="Job Title">役職</th>
                                    <th scope="col" title="Actions">アクション</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobTitles as $jobTitle)
                                    <tr>
                                        <td>{{ $jobTitle->Job_id }}</td>
                                        <td>{{ $jobTitle->job_title }}</td>
                                        <td nowrap>
                                            <button type="button" class="btn btn-light me-2" title="Edit Job Title" data-bs-toggle="modal" data-bs-target="#editJobTitleModal{{ $jobTitle->Job_id }}">
                                                <i class="fas fa-edit"></i> 編集
                                            </button>
                                            <button type="button" class="btn btn-dark me-2" title="Delete Job Title" data-bs-toggle="modal" data-bs-target="#deleteJobTitleModal{{ $jobTitle->Job_id }}">
                                                <i class="fas fa-trash"></i> 削除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal for Create Job Title -->
            <div class="modal fade" id="createJobTitleModal" tabindex="-1" aria-labelledby="createJobTitleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createJobTitleModalLabel">役職情報フォーム</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('job-titles.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="job_title">役職: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="job_title" name="job_title" title="Job Title" required>
                                </div>
                                <div class="form-group">
                                    <label for="display_order">表示順: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="display_order" name="display_order" title="Display Order" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">提出する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($jobTitles as $jobTitle)
            <!-- Modal for Edit Job Title -->
            <div class="modal fade" id="editJobTitleModal{{ $jobTitle->Job_id }}" tabindex="-1" aria-labelledby="editJobTitleModalLabel{{ $jobTitle->Job_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editJobTitleModalLabel{{ $jobTitle->Job_id }}">役職情報の編集</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('job-titles.update', $jobTitle->Job_id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="job_title_{{ $jobTitle->Job_id }}">役職: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="job_title_{{ $jobTitle->Job_id }}" name="job_title" title="Job Title" value="{{ $jobTitle->job_title }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="display_order_{{ $jobTitle->Job_id }}">表示順: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="display_order_{{ $jobTitle->Job_id }}" name="display_order" title="Display Order" value="{{ $jobTitle->display_order }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">更新する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Delete Job Title -->
            <div class="modal fade" id="deleteJobTitleModal{{ $jobTitle->Job_id }}" tabindex="-1" aria-labelledby="deleteJobTitleModalLabel{{ $jobTitle->Job_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteJobTitleModalLabel{{ $jobTitle->Job_id }}">役職情報の削除</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>本当にこの役職情報を削除しますか？</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('job-titles.destroy', $jobTitle->Job_id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                <button type="submit" class="btn btn-danger">削除する</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    <!-- </div> -->

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
        $('#jobTitleTable').DataTable({
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
