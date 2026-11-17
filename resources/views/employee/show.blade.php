@extends('layouts.app')

@section('content')
<style>
    .employee-detail-page { min-height: 100vh; background: #f1f5f9; }
    .employee-detail-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .employee-detail-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    html.dark-mode .employee-detail-page { background: #0b1220; }
    @media (max-width: 767.98px) {
        .employee-detail-page__content, body.sidebar-collapsed .employee-detail-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="employee-detail-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="employee-detail-page__content space-y-6">
        <nav aria-label="breadcrumb" class="text-sm text-slate-500">
            <a href="{{ route('course-settings') }}" class="hover:text-blue-700">{{ __('Course Settings') }}</a>
            <span class="mx-2">/</span><span class="font-medium text-slate-700">{{ __('Employee Details') }}</span>
        </nav>

        <section class="mx-auto max-w-5xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <header class="flex flex-wrap items-center justify-between gap-3 bg-blue-900 px-5 py-4 text-white">
                <div>
                    <p class="text-sm text-blue-200">{{ __('Employee Details') }}</p>
                    <h1 class="text-xl font-semibold">{{ $employee->fullname }}</h1>
                </div>
                <a href="{{ route('course-settings') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/40 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>{{ __('Back to course settings') }}
                </a>
            </header>

            <div class="grid gap-6 p-5 md:grid-cols-2">
                <section class="rounded-xl border border-slate-200 p-5">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('Personal Information') }}</h2>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Full Name') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->fullname }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Employee Code') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->employee_code ?: 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Kana Name') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->kananame ?: 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Sex') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->sex ?: 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Date of Birth') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->dateofbirth ? \Carbon\Carbon::parse($employee->dateofbirth)->format('Y-m-d') : 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Date of Joining') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->dateofjoining ? \Carbon\Carbon::parse($employee->dateofjoining)->format('Y-m-d') : 'N/A' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-xl border border-slate-200 p-5">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('Contact and Position') }}</h2>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Email') }}</dt><dd class="mt-1 break-words text-sm text-slate-800">{{ $employee->email ?: 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Phone Number') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->contact_phonenumber ?: 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Affiliation') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->employee_affiliation?->affiliation?->affiliation_name ?? 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Job Title / Position') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->employee_affiliation?->job?->job_title ?? 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Account Status') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->account_status ?: 'N/A' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Retirement Date') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $employee->retirementdate ? \Carbon\Carbon::parse($employee->retirementdate)->format('Y-m-d') : 'N/A' }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Remarks') }}</dt><dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $employee->remarks ?: 'N/A' }}</dd></div>
                    </dl>
                </section>
            </div>
        </section>
    </main>
</div>
@include('includes.footer')
@endsection
