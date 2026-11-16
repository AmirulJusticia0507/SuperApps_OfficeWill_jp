@extends('layouts.app')

@section('content')
    <style>
        .access-settings-page { min-height: 100vh; background: #f4f6f9; }
        .access-settings-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
        body.sidebar-collapsed .access-settings-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
        .access-settings-page .card { border: 0; border-radius: .75rem; box-shadow: 0 .125rem .75rem rgba(0,0,0,.08); }
        .access-settings-page .card-body { overflow-x: auto; }
        .access-settings-page table { min-width: 980px; }
        @media (max-width: 767.98px) {
            .access-settings-page__content, body.sidebar-collapsed .access-settings-page__content { margin-left: 0; width: 100%; padding: 1rem; }
        }
    </style>
    <div class="access-settings-page">
    @include('includes.header')
    @include('includes.sidebar')
        <main class="access-settings-page__content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Access Rights Settings') }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header text-white" style="background-color: darkblue">
                    <strong>{{ __('Access Rights Settings') }}</strong>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
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
                                        <td>{{ $employeeAffiliation->employee?->fullname }}<br><small>{{ $employeeAffiliation->employee?->employee_code }}</small></td>
                                        <td>{{ $employeeAffiliation->affiliation?->affiliation_name }}</td>
                                        <td>{{ $employeeAffiliation->job?->job_title }}</td>
                                        <td>
                                            <form id="access-form-{{ $employeeAffiliation->eai_id }}" method="POST" action="{{ route('employee-access-settings.update', $employeeAffiliation->eai_id) }}">
                                                @csrf
                                                @method('PUT')
                                                @foreach ([
                                                    'system_administrator_privileges' => __('System Administrator Privileges'),
                                                    'employee_registration_authority' => __('Employee Registration Authority'),
                                                    'course_enrollment_privileges' => __('Course Enrollment Privileges'),
                                                    'attendance_setting_authority' => __('Attendance Settings Authority'),
                                                ] as $field => $label)
                                                    <div class="form-check">
                                                        <input type="hidden" name="{{ $field }}" value="0">
                                                        <input class="form-check-input" type="checkbox" id="{{ $field }}-{{ $employeeAffiliation->eai_id }}" name="{{ $field }}" value="1" @checked((bool) $employeeAffiliation->{$field})>
                                                        <label class="form-check-label" for="{{ $field }}-{{ $employeeAffiliation->eai_id }}">{{ $label }}</label>
                                                    </div>
                                                @endforeach
                                                <hr>
                                                <label class="form-label" for="authority_validity_scope-{{ $employeeAffiliation->eai_id }}">{{ __('Authority Effective Affiliation') }}</label>
                                                <select class="form-control" id="authority_validity_scope-{{ $employeeAffiliation->eai_id }}" name="authority_validity_scope" required>
                                                    <option value="1" @selected((string) $employeeAffiliation->authority_validity_scope === '1')>{{ __('Limited to affiliation') }}</option>
                                                    <option value="2" @selected((string) $employeeAffiliation->authority_validity_scope === '2')>{{ __('Below affiliation') }}</option>
                                                    <option value="3" @selected((string) $employeeAffiliation->authority_validity_scope === '3')>{{ __('All affiliations') }}</option>
                                                </select>
                                                <label class="form-label mt-2" for="authority_validity_code-{{ $employeeAffiliation->eai_id }}">{{ __('Authority Affiliation Code') }}</label>
                                                <input class="form-control" id="authority_validity_code-{{ $employeeAffiliation->eai_id }}" name="authority_validity_code" value="{{ $employeeAffiliation->authority_validity_code }}" maxlength="255">
                                            </form>
                                        </td>
                                        <td><button class="btn btn-primary" type="submit" form="access-form-{{ $employeeAffiliation->eai_id }}">{{ __('Save') }}</button></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">{{ __('No employees found.') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>
    @include('includes.footer')
@endsection
