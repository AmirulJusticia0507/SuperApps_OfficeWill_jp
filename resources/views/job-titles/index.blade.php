@extends('layouts.app')

@section('content')
<style>
    .job-titles-page { min-height: 100vh; background: #f4f6f9; }
    .job-titles-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .job-titles-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    html.dark-mode .job-titles-page { background: #0b1220; }
    html.dark-mode .job-titles-page .bg-white { background-color: #172235 !important; }
    html.dark-mode .job-titles-page .border-slate-200 { border-color: #334155 !important; }
    html.dark-mode .job-titles-page .text-slate-700,
    html.dark-mode .job-titles-page .text-slate-800 { color: #e2e8f0 !important; }
    html.dark-mode .job-titles-page .text-slate-500 { color: #a7b4c7 !important; }
    html.dark-mode .job-titles-page input { border-color: #475569; background: #172235; color: #e2e8f0; }
    html.dark-mode .job-titles-page table { color: #e2e8f0; }
    html.dark-mode .job-titles-page table thead th { border-color: #334155 !important; background: #10203a !important; color: #f1f5f9 !important; }
    html.dark-mode .job-titles-page table td { border-color: #334155 !important; }
    html.dark-mode .job-titles-page table tbody tr,
    html.dark-mode .job-titles-page table tbody tr:nth-child(odd) { background: #172235; }
    html.dark-mode .job-titles-page table tbody tr:hover { background: #243249; }
    html.dark-mode .job-titles-page .dataTables_wrapper,
    html.dark-mode .job-titles-page .dataTables_info,
    html.dark-mode .job-titles-page .dataTables_length,
    html.dark-mode .job-titles-page .dataTables_filter,
    html.dark-mode .job-titles-page .dataTables_paginate { color: #cbd5e1 !important; }
    html.dark-mode .job-titles-page .dataTables_wrapper select,
    html.dark-mode .job-titles-page .dataTables_wrapper input { border: 1px solid #475569; border-radius: .5rem; background: #172235; color: #e2e8f0; }
    html.dark-mode .job-titles-page .dataTables_wrapper .paginate_button { color: #cbd5e1 !important; }
    html.dark-mode .job-titles-page .dataTables_wrapper .paginate_button.current,
    html.dark-mode .job-titles-page .dataTables_wrapper .paginate_button.current:hover { border-color: #2563eb !important; background: #1d4ed8 !important; color: #fff !important; }
    html.dark-mode .job-titles-page .modal-content { border-color: #334155; background: #172235; color: #e2e8f0; }
    html.dark-mode .job-titles-page .modal-header,
    html.dark-mode .job-titles-page .modal-footer { border-color: #334155; }
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

@foreach($jobTitles as $jobTitle)
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

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    function initJobTitleSearch() {
        const searchBox = document.getElementById('jobTitleSearchBox');
        const tableElement = document.getElementById('jobTitleTable');
        let dataTable = null;

        if (window.jQuery && window.jQuery.fn.DataTable) {
            dataTable = window.jQuery('#jobTitleTable').DataTable({
                scrollX: true,
                searching: true,
                lengthMenu: [10, 25, 50, 100, 500],
                pageLength: 10,
                dom: 'lrtip'
            });
        }

        searchBox.addEventListener('input', function () {
            const query = this.value.trim().toLocaleLowerCase();
            if (dataTable) {
                dataTable.search(this.value).draw();
                return;
            }

            tableElement.querySelectorAll('tbody tr').forEach(function (row) {
                row.hidden = !row.textContent.toLocaleLowerCase().includes(query);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initJobTitleSearch);
    } else {
        initJobTitleSearch();
    }
</script>
@endpush
