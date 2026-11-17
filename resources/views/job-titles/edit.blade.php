@extends('layouts.app')

@section('content')
<style>
    .job-titles-edit-page { min-height: 100vh; background: #f4f6f9; }
    .job-titles-edit-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .job-titles-edit-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .job-titles-edit-page__content, body.sidebar-collapsed .job-titles-edit-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="job-titles-edit-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="job-titles-edit-page__content pt-20">
        <!-- Breadcrumb -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-600">
                <li class="inline-flex items-center">
                    <a href="{{ route('job-titles.index') }}" class="text-blue-600 hover:text-blue-800">Job Title Master</a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-gray-500 font-medium">{{ isset($jobTitle) ? 'Edit Job Title' : 'Create Job Title' }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="max-w-2xl mx-auto space-y-8">
            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4">
                    <h1 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-briefcase text-blue-400"></i>
                        {{ isset($jobTitle) ? 'Edit Job Information' : 'New Job Information' }}
                    </h1>
                </div>

                <div class="p-6">
                    <form action="{{ isset($jobTitle) ? route('job-titles.update', $jobTitle->job_id) : route('job-titles.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($jobTitle))
                            @method('PUT')
                        @endif

                        <div>
                            <label for="job_title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Job Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="job_title" id="job_title" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" value="{{ isset($jobTitle) ? $jobTitle->job_title : old('job_title') }}" required>
                        </div>

                        <div>
                            <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                Display Order <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="display_order" id="display_order" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" value="{{ isset($jobTitle) ? $jobTitle->display_order : old('display_order', 1) }}" required>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('job-titles.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                                {{ isset($jobTitle) ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-list text-blue-400"></i>
                        Job Titles
                    </h2>
                    <a href="{{ route('job-titles.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition">
                        <i class="fas fa-plus"></i> Create New
                    </a>
                </div>

                <div class="p-6">
                    <table class="w-full text-sm text-left text-gray-600" id="jobtitleTable">
                        <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b">
                            <tr>
                                <th class="px-4 py-3">Job Title</th>
                                <th class="px-4 py-3">Display Order</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($jobTitles as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $item->job_title }}</td>
                                    <td class="px-4 py-3">{{ $item->display_order }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('job-titles.edit', $item->job_id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded shadow-sm transition">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('job-titles.destroy', $item->job_id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded shadow-sm transition" onclick="return confirm('Are you sure you want to delete this job title?')">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#jobtitleTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            pageLength: 10
        });
    });
</script>
@endsection
