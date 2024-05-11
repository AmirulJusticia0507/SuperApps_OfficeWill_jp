@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">

@section('content')
    <!-- Header -->
    @include('includes.header')

    <div class="container">
        <div class="row justify-content-center">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>

            <!-- Tabel dan Form -->
            <div class="col-md-9">
                <br><br><br>
                <!-- Tabel Affiliation -->
                <div class="card">
                    <div class="card-header" style="background-color: darkblue">
                        <b style="color: aliceblue">List of Job Titles</b>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="jobTitleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Job Title</th>
                                    <th scope="col">Display Order</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobTitles as $jobTitle)
                                    <tr>
                                        <td>{{ $jobTitle->job_title }}</td>
                                        <td>{{ $jobTitle->display_order }}</td>
                                        <td>
                                            <a href="{{ route('job-titles.edit', $jobTitle->Job_id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                            <form action="{{ route('job-titles.destroy', $jobTitle->Job_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Form Create/Edit Job Title -->
                <div class="card">
                    <div class="card-header" style="background-color: darkblue">
                        <b style="color: aliceblue">Job Title Information Form</b>
                        <b style="color: red">*</b><p style="color: aliceblue">This is a required field.</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($editingId) ? route('job-titles.update', $editingId) : route('job-titles.store') }}">
                            @csrf
                            @if(isset($editingId))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="job_title">Job Title: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="job_title" name="job_title" value="{{ isset($jobTitle) ? $jobTitle->job_title : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="display_order">Display Order: <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="display_order" name="display_order" value="{{ isset($jobTitle) ? $jobTitle->display_order : '' }}">
                            </div>
                            <button type="submit" class="btn btn-info"><i class="fas fa-sent"></i> Submit</button>
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
