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
                        <li class="breadcrumb-item"><a href="#" title="{{ __('Job Title Master Registration') }}">{{ __('Job Title Master Registration') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('job-titles.index') }}" title="{{ __('Job Title Master Registration') }}">{{ __('Job Title Master Registration') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="{{ __('Job Title Master Registration') }}">{{ __('Job Title Master Registration') }}</li>
                    </ol>
                </nav>
                <div class="master-page__toolbar">
                    <input type="text" id="jobTitleSearchBox" class="form-control master-page__search" placeholder="{{ __('Search table...') }}">
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#createJobTitleModal" title="{{ __('Add Job Title') }}"><i class="fas fa-plus"></i> {{ __('Add Job Title') }}</button>
                    <br><br>
                </div>
                <div class="card">
                    <div class="card-header" title="List of Job Titles" style="background-color: darkblue">
                        <b style="color: aliceblue">{{ __('Job Title List') }}</b>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="jobTitleTable">
                            <thead>
                                <tr>
                                    <th scope="col" title="{{ __('Job ID') }}">{{ __('Job ID') }}</th>
                                    <th scope="col" title="{{ __('Job Title') }}">{{ __('Job Title') }}</th>
                                    <th scope="col" title="{{ __('Actions') }}">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobTitles as $jobTitle)
                                    <tr>
                                        <td>{{ $jobTitle->job_id }}</td>
                                        <td>{{ $jobTitle->job_title }}</td>
                                        <td nowrap>
                                            <button type="button" class="btn btn-light me-2" title="Edit Job Title" data-bs-toggle="modal" data-bs-target="#editJobTitleModal{{ $jobTitle->job_id }}">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </button>
                                            <button type="button" class="btn btn-dark me-2" title="Delete Job Title" data-bs-toggle="modal" data-bs-target="#deleteJobTitleModal{{ $jobTitle->job_id }}">
                                                <i class="fas fa-trash"></i> {{ __('Delete') }}
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
                            <h5 class="modal-title" id="createJobTitleModalLabel">{{ __('Job Title Information Form') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('job-titles.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="job_title">{{ __('Job Title') }}: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="job_title" name="job_title" title="Job Title" required>
                                </div>
                                <div class="form-group">
                                    <label for="display_order">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="display_order" name="display_order" title="Display Order" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($jobTitles as $jobTitle)
            <!-- Modal for Edit Job Title -->
            <div class="modal fade" id="editJobTitleModal{{ $jobTitle->job_id }}" tabindex="-1" aria-labelledby="editJobTitleModalLabel{{ $jobTitle->job_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editJobTitleModalLabel{{ $jobTitle->job_id }}">{{ __('Edit Job Title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('job-titles.update', $jobTitle->job_id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="job_title_{{ $jobTitle->job_id }}">{{ __('Job Title') }}: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="job_title_{{ $jobTitle->job_id }}" name="job_title" title="Job Title" value="{{ $jobTitle->job_title }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="display_order_{{ $jobTitle->job_id }}">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                                    <input type="text" class="form-control" id="display_order_{{ $jobTitle->job_id }}" name="display_order" title="Display Order" value="{{ $jobTitle->display_order }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Delete Job Title -->
            <div class="modal fade" id="deleteJobTitleModal{{ $jobTitle->job_id }}" tabindex="-1" aria-labelledby="deleteJobTitleModalLabel{{ $jobTitle->job_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteJobTitleModalLabel{{ $jobTitle->job_id }}">{{ __('Delete Job Title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ __('Are you sure you want to delete this job title?') }}</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('job-titles.destroy', $jobTitle->job_id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
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
        var table = $('#jobTitleTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });
        $('#jobTitleSearchBox').on('keyup', function () { table.search(this.value).draw(); });
    });
</script>
@endsection
