@extends('layouts.app')

@section('content')
<style>
    .affil-form-page { min-height: 100vh; background: #f4f6f9; }
    .affil-form-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .affil-form-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .affil-form-page__content, body.sidebar-collapsed .affil-form-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="affil-form-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="affil-form-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Affiliation Information Registration') }}" class="hover:text-blue-600">{{ __('Affiliation Information Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('affiliation-information.index') }}" title="{{ __('Affiliation Information') }}" class="hover:text-blue-600">{{ __('Affiliation Information') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Create Affiliation Information') }}">{{ __('Create Affiliation Information') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Create Affiliation Information') }}">
                {{ __('Create Affiliation Information') }}
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('affiliation-information.store') }}" class="space-y-5">
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
                        <label for="company_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Company: <span class="text-rose-500">*</span></label>
                        <select class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm bg-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="company_name" name="company_name" required>
                            <option value="">Select Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="affiliation_code" class="block text-sm font-semibold text-slate-700 mb-1.5">Affiliation Code: <span class="text-rose-500">*</span></label>
                        <input type="number" min="0" max="999" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="affiliation_code" name="affiliation_code" required>
                    </div>

                    <div>
                        <label for="affiliation_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Affiliation Name:</label>
                        <input type="text" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="affiliation_name" name="affiliation_name">
                    </div>

                    <div>
                        <label for="display_order" class="block text-sm font-semibold text-slate-700 mb-1.5">Display Order: <span class="text-rose-500">*</span></label>
                        <input type="number" min="0" max="999" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Organization Type: <span class="text-rose-500">*</span></label>
                        <div class="flex gap-6 text-sm text-slate-700">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="organization_type" id="main_store_equivalent" value="Main store equivalent" class="text-blue-600 focus:ring-blue-500" required>
                                <span>Main store equivalent</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="organization_type" id="fc_store" value="FC Store" class="text-blue-600 focus:ring-blue-500" required>
                                <span>FC Store</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-5 flex justify-end gap-3 border-t border-slate-100">
                        <a href="{{ route('affiliation-information.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold transition hover:bg-slate-50">{{ __('Cancel') }}</a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold shadow-sm transition"><i class="fas fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection
