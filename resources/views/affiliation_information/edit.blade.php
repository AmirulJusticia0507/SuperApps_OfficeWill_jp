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
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold">
                    {{ __('Edit Affiliation Information') }}
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('affiliation-information.update', $affiliation->affiliation_code) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Company: <span class="text-red-500">*</span></label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="company_name" name="company_name" required>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->company_id }}" @selected((int) $company->company_id === (int) $affiliation->company_id)>{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="affiliation_code" class="block text-sm font-medium text-slate-700 mb-1">Affiliation Code: <span class="text-red-500">*</span></label>
                            <input type="number" min="0" max="999" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="affiliation_code" name="affiliation_code" value="{{ $affiliation->affiliation_code }}" required>
                        </div>
                        <div>
                            <label for="affiliation_name" class="block text-sm font-medium text-slate-700 mb-1">Affiliation Name:</label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="affiliation_name" name="affiliation_name" value="{{ $affiliation->affiliation_name }}">
                        </div>
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-slate-700 mb-1">Display Order: <span class="text-red-500">*</span></label>
                            <input type="number" min="0" max="999" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" value="{{ (int) $affiliation->display_order }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Organization Type: <span class="text-red-500">*</span></label>
                            <div class="flex gap-6 text-sm text-slate-700">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="organization_type" id="main_store_equivalent" value="Main store equivalent" class="text-blue-600" {{ $affiliation->organization_type == 'Main store equivalent' ? 'checked' : '' }} required>
                                    Main store equivalent
                                </label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="organization_type" id="fc_store" value="FC Store" class="text-blue-600" {{ $affiliation->organization_type == 'FC Store' ? 'checked' : '' }} required>
                                    FC Store
                                </label>
                            </div>
                        </div>
                        <div class="pt-4 flex justify-end gap-3">
                            <a href="{{ route('affiliation-information.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition"><i class="fas fa-edit"></i> Update</button>
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
