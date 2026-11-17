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
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Edit Company Information') }}">{{ __('Edit Company Information') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Edit Company Information') }}">
                {{ __('Edit Company Information') }}
            </div>

            <div class="p-6">
                <!-- Form Edit Company -->
                <form method="POST" action="{{ route('company-information.update', $company->company_id) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

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
                        <label for="company_name" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ __('Company Name') }}: <span class="text-rose-500">*</span></label>
                        <input type="text" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="company_name" name="company_name" value="{{ $company->company_name }}" required>
                    </div>

                    <div>
                        <label for="login_screen_url" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ __('Login Screen URL') }}:</label>
                        <input type="text" class="w-full px-4 py-2.5 border border-slate-200 bg-slate-50 text-slate-500 rounded-xl text-sm" id="login_screen_url" value="{{ $company->login_screen_url }}" readonly>
                    </div>

                    <div>
                        <label for="icon_storage_file_path" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ __('Company Icon File') }}:</label>
                        <input type="file" class="block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-800 hover:file:bg-blue-100" id="icon_storage_file_path" name="icon_storage_file_path" onchange="previewIcon(this)">
                        @if ($company->icon_storage_file_path)
                            <img id="icon_preview" src="{{ asset($company->icon_storage_file_path) }}" alt="{{ __('Current Icon') }}" class="mt-3 max-w-[100px] rounded-lg border border-slate-200 object-contain p-1">
                        @else
                            <img id="icon_preview" src="#" alt="{{ __('Icon preview') }}" class="mt-3 hidden max-h-24 rounded-lg border border-slate-200 object-contain p-1">
                        @endif
                    </div>

                    <div>
                        <label for="teaching_material_storage_file_path" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ __('Teaching Materials Storage') }}:</label>
                        @if ($company->teaching_material_storage_file_path)
                            <div class="text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5">
                                {{ $company->teaching_material_storage_file_path }}
                            </div>
                        @else
                            <input type="text" readonly class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-500" value="—">
                        @endif
                    </div>

                    <div class="pt-5 flex justify-end gap-3 border-t border-slate-100">
                        <a href="{{ route('company-information.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold transition hover:bg-slate-50">{{ __('Cancel') }}</a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold shadow-sm transition"><i class="fas fa-edit"></i> {{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')

<script>
    function previewIcon(input) {
        const preview = document.getElementById('icon_preview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        }
    }
</script>
@endsection
