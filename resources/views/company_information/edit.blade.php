@extends('layouts.app')

@section('content')
<style>
    .company-edit-page { min-height: 100vh; background: #f4f6f9; }
    .company-edit-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .company-edit-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .company-edit-page__content, body.sidebar-collapsed .company-edit-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="company-edit-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="company-edit-page__content">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold">
                    {{ __('Edit Company Information') }}
                </div>

                <div class="p-6">
                    <!-- Form Edit Company -->
                    <form method="POST" action="{{ route('company-information.update', $company->company_id) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Name') }}: <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="company_name" name="company_name" value="{{ $company->company_name }}" required>
                        </div>

                        <div>
                            <label for="login_screen_url" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Login Screen URL') }}:</label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-500 rounded-lg text-sm" id="login_screen_url" value="{{ $company->login_screen_url }}" readonly>
                        </div>

                        <div>
                            <label for="icon_storage_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Icon File') }}:</label>
                            <input type="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" id="icon_storage_file_path" name="icon_storage_file_path" onchange="previewIcon(this)">
                            @if ($company->icon_storage_file_path)
                                <img id="icon_preview" src="{{ asset($company->icon_storage_file_path) }}" alt="{{ __('Current Icon') }}" class="mt-2 max-w-[100px] rounded border border-slate-200">
                            @endif
                        </div>

                        <div>
                            <label for="teaching_material_storage_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Teaching Materials Storage') }}:</label>
                            @if ($company->teaching_material_storage_file_path)
                                <img id="material_preview" src="{{ asset($company->teaching_material_storage_file_path) }}" alt="{{ __('Current Material') }}" class="max-w-[100px] rounded border border-slate-200">
                            @endif
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <a href="{{ route('company-information.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition"><i class="fas fa-edit"></i> {{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection

@section('scripts')
<script>
    function previewIcon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#icon_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMaterial(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#material_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
