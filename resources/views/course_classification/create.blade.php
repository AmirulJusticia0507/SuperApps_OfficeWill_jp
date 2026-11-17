@extends('layouts.app')

@section('content')
<style>
    .course-class-form-page { min-height: 100vh; background: #f1f5f9; }
    .course-class-form-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-class-form-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    .dark-mode .course-class-form-page { background: #0b1220; }
    @media (max-width: 767.98px) {
        .course-class-form-page__content, body.sidebar-collapsed .course-class-form-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="course-class-form-page min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-class-form-page__content">
        <nav aria-label="breadcrumb" class="mb-6 text-sm text-slate-500">
            <a href="{{ route('course-classification.index') }}" class="hover:text-cyan-700">{{ __('Course Classification') }}</a>
            <span class="mx-2">/</span><span class="font-medium text-slate-700">{{ __('Create Course Classification') }}</span>
        </nav>

        <section class="mx-auto max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <header class="bg-blue-900 px-6 py-5 text-white">
                <h1 class="text-lg font-semibold">{{ __('Create Course Classification') }}</h1>
                <p class="mt-1 text-sm text-blue-100">{{ __('Enter the classification details below.') }}</p>
            </header>
            <form method="POST" action="{{ route('classifications.store') }}" enctype="multipart/form-data" class="space-y-5 p-6">
                @csrf
                @if ($errors->any())
                    <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700"><ul class="list-inside list-disc space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <div>
                    <label for="company_name" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">{{ __('Company') }} <span class="text-rose-500">*</span></label>
                    <select id="company_name" name="company_name" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                        <option value="">{{ __('Select Company') }}</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->company_name }}" @selected(old('company_name') === $company->company_name)>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="classification_name" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">{{ __('Classification Name') }} <span class="text-rose-500">*</span></label>
                    <input type="text" id="classification_name" name="classification_name" value="{{ old('classification_name') }}" maxlength="10" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div>
                    <label for="icon_file_path" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">{{ __('Icon File') }} <span class="text-rose-500">*</span></label>
                    <input type="file" id="icon_file_path" name="icon_file_path" accept="image/*" required onchange="previewClassificationIcon(this)" class="block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-cyan-50 file:px-4 file:py-2 file:font-semibold file:text-cyan-800 hover:file:bg-cyan-100 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <img id="icon_preview" src="#" alt="{{ __('Icon preview') }}" class="mt-3 hidden max-h-24 rounded-lg border border-slate-200 object-contain p-1 dark:border-slate-700">
                </div>
                <div>
                    <label for="display_order" class="mb-1.5 block text-sm font-semibold text-slate-700 dark:text-slate-200">{{ __('Display Order') }} <span class="text-rose-500">*</span></label>
                    <input type="number" id="display_order" name="display_order" value="{{ old('display_order') }}" min="0" max="999" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5 dark:border-slate-700">
                    <a href="{{ route('course-classification.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">{{ __('Cancel') }}</a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"><i class="fas fa-plus" aria-hidden="true"></i>{{ __('Create Classification') }}</button>
                </div>
            </form>
        </section>
    </main>
</div>
@include('includes.footer')
<script>
    function previewClassificationIcon(input) {
        const preview = document.getElementById('icon_preview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        }
    }
</script>
@endsection
