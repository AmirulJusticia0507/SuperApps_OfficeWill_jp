@extends('layouts.app')

@section('content')
<style>
    .company-create-page { min-height: 100vh; background: #f1f5f9; }
    .company-create-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .company-create-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) { .company-create-page__content, body.sidebar-collapsed .company-create-page__content { margin-left: 0; width: 100%; padding: 1rem; } }
    .dark-mode .company-create-page { background: #0b1220; }
</style>
<div class="min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('includes.header')
    @include('includes.sidebar')
    <main class="company-create-page__content">
        <nav aria-label="breadcrumb" class="mb-6 text-sm text-slate-500">
            <a href="{{ route('company-information.index') }}" class="hover:text-cyan-700">{{ __('Company Information') }}</a>
            <span class="mx-2">/</span><span class="font-medium text-slate-700">{{ __('Add Company') }}</span>
        </nav>
        <section class="mx-auto max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <header class="bg-blue-900 px-6 py-5 text-white">
                <h1 class="text-lg font-semibold">{{ __('Create Company') }}</h1>
                <p class="mt-1 text-sm text-blue-100">{{ __('Enter the company details below.') }}</p>
            </header>
            <form method="POST" action="{{ route('company-information.store') }}" enctype="multipart/form-data" class="space-y-5 p-6">
                @csrf
                @if ($errors->any())
                    <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"><ul class="list-inside list-disc space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <div>
                    <label for="company_name" class="mb-1.5 block text-sm font-semibold text-slate-700">{{ __('Company Name') }} <span class="text-rose-500">*</span></label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" maxlength="20" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10">
                </div>
                <div>
                    <label for="company_username" class="mb-1.5 block text-sm font-semibold text-slate-700">{{ __('Login Screen URL') }} <span class="text-rose-500">*</span></label>
                    <input type="text" id="company_username" name="company_username" value="{{ old('company_username') }}" maxlength="150" required placeholder="username" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10">
                    <input type="text" id="login_screen_url" readonly aria-label="{{ __('Generated login URL') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                </div>
                <div>
                    <label for="icon_storage_file_path" class="mb-1.5 block text-sm font-semibold text-slate-700">{{ __('Company Icon File') }} <span class="text-rose-500">*</span></label>
                    <input type="file" id="icon_storage_file_path" name="icon_storage_file_path" accept="image/*" required onchange="previewCompanyIcon(this)" class="block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-cyan-50 file:px-4 file:py-2 file:font-semibold file:text-cyan-800 hover:file:bg-cyan-100">
                    <img id="icon_preview" src="#" alt="{{ __('Icon preview') }}" class="mt-3 hidden max-h-24 rounded-lg border border-slate-200 object-contain p-1">
                </div>
                <div>
                    <label for="teaching_material_storage_file_path" class="mb-1.5 block text-sm font-semibold text-slate-700">{{ __('Teaching Materials Storage') }}</label>
                    <input type="text" id="teaching_material_storage_file_path" readonly aria-label="{{ __('Teaching Materials Storage') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                </div>
                <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5">
                    <a href="{{ route('company-information.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">{{ __('Cancel') }}</a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"><i class="fas fa-plus" aria-hidden="true"></i>{{ __('Create Company') }}</button>
                </div>
            </form>
        </section>
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
