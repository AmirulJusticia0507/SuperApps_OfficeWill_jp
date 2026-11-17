@extends('layouts.app')

@section('content')
<style>
    .job-titles-page { min-height: 100vh; background: #f4f6f9; }
    .job-titles-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .job-titles-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .job-titles-page__content, body.sidebar-collapsed .job-titles-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>
<div class="job-titles-page">
@include('includes.header')
@include('includes.sidebar')
<main class="job-titles-page__content">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
            <li><a href="#" title="{{ __('Job Title Master Registration') }}" class="hover:underline">{{ __('Job Title Master Registration') }}</a></li>
            <li class="before:content-['/'] before:mx-1"><a href="{{ route('job-titles.index') }}" title="{{ __('Job Title Master Registration') }}" class="hover:underline">{{ __('Job Title Master Registration') }}</a></li>
            <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Job Title Master Registration') }}">{{ __('Job Title Master Registration') }}</li>
        </ol>
    </nav>

    <div class="flex justify-between items-center gap-3 mb-4 flex-wrap">
        <input type="text" id="jobTitleSearchBox" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="{{ __('Search table...') }}" style="max-width: 320px;">
        <a href="{{ route('job-titles.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition ml-auto" title="{{ __('Add Job Title') }}"><i class="fas fa-plus"></i> {{ __('Add Job Title') }}</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="List of Job Titles">
            {{ __('Job Title List') }}
        </div>
        <div class="p-5 overflow-x-auto">
            <table class="display table table-bordered table-striped table-hover responsive nowrap w-full text-sm" style="width:100%" id="jobTitleTable">
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
                                <a href="{{ route('job-titles.edit', $jobTitle->job_id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200 mr-2" title="Edit Job Title">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition mr-2" title="Delete Job Title" data-bs-toggle="modal" data-bs-target="#deleteJobTitleModal{{ $jobTitle->job_id }}">
                                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>
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
                    <div class="mb-4">
                        <label for="job_title" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Job Title') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="job_title" name="job_title" title="Job Title" required>
                    </div>
                    <div class="mb-4">
                        <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="display_order" name="display_order" title="Display Order" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition">{{ __('Submit') }}</button>
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
                    <div class="mb-4">
                        <label for="job_title_{{ $jobTitle->job_id }}" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Job Title') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="job_title_{{ $jobTitle->job_id }}" name="job_title" title="Job Title" value="{{ $jobTitle->job_title }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="display_order_{{ $jobTitle->job_id }}" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Display Order') }}: <b style="color: red">*</b></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="display_order_{{ $jobTitle->job_id }}" name="display_order" title="Display Order" value="{{ $jobTitle->display_order }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition">{{ __('Update') }}</button>
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
                    <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

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
