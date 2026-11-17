@extends('layouts.app')

@section('content')
<style>
    .access-settings-page { min-height: 100vh; background: #f4f6f9; }
    .access-settings-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .access-settings-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    .access-settings-page table { min-width: 980px; }
    .access-settings-page .access-save-switch { display: inline-flex; align-items: center; gap: .5rem; cursor: pointer; }
    .access-settings-page .access-save-switch input { position: absolute; opacity: 0; pointer-events: none; }
    .access-settings-page .access-save-slider { position: relative; width: 3.25rem; height: 1.75rem; border-radius: 2rem; background: #adb5bd; transition: background-color .2s ease; }
    .access-settings-page .access-save-slider::after { content: ''; position: absolute; top: .2rem; left: .2rem; width: 1.35rem; height: 1.35rem; border-radius: 50%; background: #fff; box-shadow: 0 .1rem .2rem rgba(0,0,0,.2); transition: transform .2s ease; }
    .access-settings-page .access-save-switch input:checked + .access-save-slider { background: #16a34a; }
    .access-settings-page .access-save-switch input:checked + .access-save-slider::after { transform: translateX(1.5rem); }
    .access-settings-page .access-save-switch input:focus-visible + .access-save-slider { outline: 2px solid #2563eb; outline-offset: 2px; }
    .access-settings-page .access-save-status { color: #64748b; font-size: .85rem; }
    @media (max-width: 767.98px) {
        .access-settings-page__content, body.sidebar-collapsed .access-settings-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="access-settings-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="access-settings-page__content space-y-6">
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">{{ __('Dashboard') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page">{{ __('Access Rights Settings') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold">
                {{ __('Access Rights Settings') }}
            </div>
            <div class="p-5">
                @if (session('success'))
                    <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ $errors->first() }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="display table table-bordered table-striped align-middle w-full text-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Affiliation') }}</th>
                                <th>{{ __('Job Title') }}</th>
                                <th>{{ __('Access Rights') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employeeAffiliations as $employeeAffiliation)
                                <tr>
                                    <td>
                                        <div class="font-medium text-slate-900">{{ $employeeAffiliation->employee?->fullname }}</div>
                                        <div class="text-xs text-slate-500">{{ $employeeAffiliation->employee?->employee_code }}</div>
                                    </td>
                                    <td>{{ $employeeAffiliation->affiliation?->affiliation_name }}</td>
                                    <td>{{ $employeeAffiliation->job?->job_title }}</td>
                                    <td>
                                        <form id="access-form-{{ $employeeAffiliation->eai_id }}" method="POST" action="{{ route('employee-access-settings.update', $employeeAffiliation->eai_id) }}" class="space-y-2 py-1">
                                            @csrf
                                            @method('PUT')
                                            @foreach ([
                                                'system_administrator_privileges' => __('System Administrator Privileges'),
                                                'employee_registration_authority' => __('Employee Registration Authority'),
                                                'course_enrollment_privileges' => __('Course Enrollment Privileges'),
                                                'attendance_setting_authority' => __('Attendance Settings Authority'),
                                            ] as $field => $label)
                                                <div class="flex items-center gap-2">
                                                    <input type="hidden" name="{{ $field }}" value="0">
                                                    <input class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500" type="checkbox" id="{{ $field }}-{{ $employeeAffiliation->eai_id }}" name="{{ $field }}" value="1" @checked((bool) $employeeAffiliation->{$field})>
                                                    <label class="text-xs text-slate-700 font-medium" for="{{ $field }}-{{ $employeeAffiliation->eai_id }}">{{ $label }}</label>
                                                </div>
                                            @endforeach
                                            <hr class="border-slate-200 my-2">
                                            <div>
                                                <label class="block text-xs font-medium text-slate-600 mb-1" for="authority_validity_scope-{{ $employeeAffiliation->eai_id }}">{{ __('Authority Effective Affiliation') }}</label>
                                                <select class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="authority_validity_scope-{{ $employeeAffiliation->eai_id }}" name="authority_validity_scope" required>
                                                    <option value="1" @selected((string) $employeeAffiliation->authority_validity_scope === '1')>{{ __('Limited to affiliation') }}</option>
                                                    <option value="2" @selected((string) $employeeAffiliation->authority_validity_scope === '2')>{{ __('Below affiliation') }}</option>
                                                    <option value="3" @selected((string) $employeeAffiliation->authority_validity_scope === '3')>{{ __('All affiliations') }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-slate-600 mb-1" for="authority_validity_code-{{ $employeeAffiliation->eai_id }}">{{ __('Authority Affiliation Code') }}</label>
                                                <input class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500" id="authority_validity_code-{{ $employeeAffiliation->eai_id }}" name="authority_validity_code" value="{{ $employeeAffiliation->authority_validity_code }}" maxlength="255">
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <label class="access-save-switch" title="{{ __('Save') }}">
                                            <input type="checkbox" data-save-access-switch
                                                data-form-id="access-form-{{ $employeeAffiliation->eai_id }}"
                                                @checked(
                                                    (bool) $employeeAffiliation->system_administrator_privileges ||
                                                    (bool) $employeeAffiliation->employee_registration_authority ||
                                                    (bool) $employeeAffiliation->course_enrollment_privileges ||
                                                    (bool) $employeeAffiliation->attendance_setting_authority
                                                )
                                                aria-label="{{ __('Save') }}">
                                            <span class="access-save-slider"></span>
                                            <span class="access-save-status">{{ __('Save') }}</span>
                                        </label>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-slate-400 py-4">{{ __('No employees found.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
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
        document.querySelectorAll('[data-save-access-switch]').forEach(function (toggle) {
            toggle.addEventListener('change', function () {
                const form = document.getElementById(this.dataset.formId);
                const status = this.closest('.access-save-switch').querySelector('.access-save-status');
                status.textContent = @json(__('Saving...'));
                form.querySelectorAll('input[type="checkbox"][name]').forEach(function (permission) {
                    permission.checked = toggle.checked;
                });
                form.requestSubmit();
            });
        });
    </script>
@endsection
