@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Include Header -->
            @include('includes.header')
        </nav>

        <!-- Include Sidebar -->
        @include('includes.sidebar')

        <div class="content"><br><br>
            <div class="container mx-auto">
                <div class="flex justify-center">
                    <div class="w-full max-w-lg">
                        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                            <div class="mb-4">
                                <h1 class="text-center text-2xl font-semibold mb-8" style="color: #2564bc;">JOB INFORMATION</h1>
                                <form action="{{ isset($jobTitle) ? route('job-titles.update', $jobTitle->JobID) : route('job-titles.store') }}" method="POST">
                                    @csrf
                                    @if(isset($jobTitle))
                                        @method('PUT')
                                    @endif
                                    <div class="mb-4">
                                        <label for="job_title" class="block text-gray-700 text-sm font-bold mb-2">Job Title:</label>
                                        <input type="text" name="JobTitle" id="job_title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ isset($jobTitle) ? $jobTitle->JobTitle : '' }}" required>
                                    </div>
                                    <div class="mb-6">
                                        <label for="display_order" class="block text-gray-700 text-sm font-bold mb-2">Display Order:</label>
                                        <input type="number" name="DisplayOrder" id="display_order" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ isset($jobTitle) ? $jobTitle->DisplayOrder : '' }}" required>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
                                        <a href="{{ route('job-titles.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Daftar Job Title -->
                <div class="flex justify-center mt-8">
                    <div class="w-full max-w-lg">
                        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold">Job Titles</h2>
                                <a href="{{ route('job-titles.create') }}" class="text-blue-500 hover:text-blue-800">Create New Job Title</a>
                            </div>
                            <table class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%" id="jobtitleTable">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Job Title</th>
                                        <th class="px-4 py-2">Display Order</th>
                                        <th class="px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobTitles as $jobTitle)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $jobTitle->JobTitle }}</td>
                                            <td class="border px-4 py-2">{{ $jobTitle->DisplayOrder }}</td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('job-titles.edit', $jobTitle->JobID) }}" class="text-blue-500 hover:text-blue-800">Edit</a>
                                                <form action="{{ route('job-titles.destroy', $jobTitle->JobID) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-800 ml-2">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <!-- AdminLTE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- DataTables TailwindCSS -->
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.tailwindcss.js"></script>
    <!-- Toggle Sidebar -->
    <script>
        $(document).ready(function() {
            // Tambahkan event click pada tombol pushmenu
            $('.nav-link[data-widget="pushmenu"]').on('click', function() {
                // Toggle class 'sidebar-collapse' pada elemen body
                $('body').toggleClass('sidebar-collapse');
            });
        });
    </script>
    <script>
        new DataTable('#jobtitleTable');
    </script>
@endsection
