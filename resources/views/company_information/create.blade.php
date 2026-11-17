@extends('layouts.app')

@section('content')
<style>
    .company-page { min-height: 100vh; background: #f4f6f9; }
    .company-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .company-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .company-page__content, body.sidebar-collapsed .company-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="company-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="company-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Company Information') }}" class="hover:text-blue-600">{{ __('Company Information') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('company-information.index') }}" title="{{ __('Company Registration') }}" class="hover:text-blue-600">{{ __('Company Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Create Company') }}">{{ __('Create Company') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Create Company') }}">
                {{ __('Create Company') }}
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('company-information.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @if ($errors->any())
                        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                            <ul class="list-inside list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="company_name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            {{ __('Company Name') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" maxlength="20" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="company_username" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            {{ __('Login Screen URL') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="company_username" name="company_username" value="{{ old('company_username') }}" maxlength="150" required placeholder="username" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <input type="text" id="login_screen_url" readonly aria-label="{{ __('Generated login URL') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-500">
                    </div>

                    <div>
                        <label for="icon_storage_file_path" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            {{ __('Company Icon File') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="file" id="icon_storage_file_path" name="icon_storage_file_path" accept="image/*" required onchange="previewCompanyIcon(this)" class="block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-800 hover:file:bg-blue-100">
                        <img id="icon_preview" src="#" alt="{{ __('Icon preview') }}" class="mt-3 hidden max-h-24 rounded-lg border border-slate-200 object-contain p-1">
                    </div>

                    <div>
                        <label for="teaching_material_storage_file_path" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            {{ __('Teaching Materials Storage') }}
                        </label>
                        <input type="text" id="teaching_material_storage_file_path" readonly aria-label="{{ __('Teaching Materials Storage') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-500">
                    </div>

                    <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5">
                        <a href="{{ route('company-information.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800">
                            <i class="fas fa-plus" aria-hidden="true"></i> {{ __('Create Company') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')

<script>
    const companyUsername = document.getElementById('company_username');
    const loginUrl = document.getElementById('login_screen_url');
    const materialPath = document.getElementById('teaching_material_storage_file_path');
    const updateCompanyPaths = () => {
        const username = companyUsername.value.trim();
        loginUrl.value = username ? `${window.location.origin}/login/${username}` : '';
        materialPath.value = username ? `/storage/${username}` : '';
    };
    companyUsername.addEventListener('input', updateCompanyPaths);
    updateCompanyPaths();
    function previewCompanyIcon(input) {
        const preview = document.getElementById('icon_preview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        }
    }
</script>
@endsection
