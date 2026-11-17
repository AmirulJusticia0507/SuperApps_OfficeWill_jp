@extends('layouts.app')

@section('content')
<style>
    .member-reg-page { min-height: 100vh; background: #f4f6f9; }
    .member-reg-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .member-reg-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .member-reg-page__content, body.sidebar-collapsed .member-reg-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="member-reg-page">
    <!-- Header -->
    @include('includes.header')
    @include('includes.sidebar')

    <main class="member-reg-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('member-registration.create') }}" title="{{ __('Employee Registration') }}" class="hover:text-blue-600">{{ __('Employee Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('employee-list') }}" title="{{ __('Employee List') }}" class="hover:text-blue-600">{{ __('Employee List') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Employee Information Registration') }}">{{ __('Employee Information Registration') }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-9">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" id="registration" title="Employee Registration">
                        {{ __('Employee Registration') }}
                    </div>
                    <div class="p-6">
                        <form action="{{ route('member-registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Fullname & Kananame -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="fullname" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Full Name') }}: <span class="text-red-500">*</span></label>
                                    <input type="text" name="fullname" id="fullname" title="Full Name" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label for="kananame" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Kana Name') }}: <span class="text-red-500">*</span></label>
                                    <input type="text" name="kananame" id="kananame" title="Kana Name" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                            </div>

                            <!-- Affiliation Information Section -->
                            <div id="affiliation-information" class="px-4 py-2.5 bg-blue-100 text-blue-900 font-semibold rounded-lg text-sm" title="Affiliation information">
                                {{ __('Affiliation Information') }}
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="application_startdate" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation Start Date') }}: <span class="text-red-500">*</span></label>
                                    <input type="date" name="application_startdate" id="application_startdate" title="Affiliation Start Date" class="w-full max-w-xs px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>

                                <div>
                                    <label for="affiliation" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Affiliation Name') }}: <span class="text-red-500">*</span></label>
                                    <select name="affiliation" id="affiliation" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Affiliation Name" required>
                                        <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                        @foreach ($affiliations as $affiliation)
                                            <option value="{{ $affiliation->affiliation_code }}">{{ $affiliation->affiliation_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="job" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Job Title') }}: <span class="text-red-500">*</span></label>
                                    <select name="job" title="Job Title" id="job" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                                        @foreach ($jobTitles as $jobTitle)
                                            <option value="{{ $jobTitle->job_id }}">{{ $jobTitle->job_title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center py-2 border-b border-slate-100">
                                    <label class="md:col-span-5 text-sm font-medium text-slate-700">{{ __('System Administrator Privileges') }}: <span class="text-red-500">*</span></label>
                                    <div class="md:col-span-7 flex gap-4 text-sm text-slate-700">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="system_administrator_privileges" value="1" class="text-blue-600" required> {{ __('With Permission') }}</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="system_administrator_privileges" value="0" class="text-blue-600" required> {{ __('Without Permission') }}</label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center py-2 border-b border-slate-100">
                                    <label class="md:col-span-5 text-sm font-medium text-slate-700">{{ __('Employee Registration Authority') }}: <span class="text-red-500">*</span></label>
                                    <div class="md:col-span-7 flex gap-4 text-sm text-slate-700">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="employee_registration_authority" value="1" class="text-blue-600" required> {{ __('With Permission') }}</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="employee_registration_authority" value="0" class="text-blue-600" required> {{ __('Without Permission') }}</label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center py-2 border-b border-slate-100">
                                    <label class="md:col-span-5 text-sm font-medium text-slate-700">{{ __('Course Enrollment Privileges') }}: <span class="text-red-500">*</span></label>
                                    <div class="md:col-span-7 flex gap-4 text-sm text-slate-700">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="course_enrollment_privileges" value="1" class="text-blue-600" required> 許可を得て</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="course_enrollment_privileges" value="0" class="text-blue-600" required> 無許可での</label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center py-2 border-b border-slate-100">
                                    <label class="md:col-span-5 text-sm font-medium text-slate-700">{{ __('Attendance Settings Authority') }}: <span class="text-red-500">*</span></label>
                                    <div class="md:col-span-7 flex gap-4 text-sm text-slate-700">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="attendance_setting_authority" value="1" class="text-blue-600" required> {{ __('With Permission') }}</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="attendance_setting_authority" value="0" class="text-blue-600" required> {{ __('Without Permission') }}</label>
                                    </div>
                                </div>

                                <div>
                                    <label for="authority_validity_scope" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Authority Effective Affiliation') }}: <span class="text-red-500">*</span></label>
                                    <div class="flex flex-wrap gap-4 text-sm text-slate-700 mb-2">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" id="authority_validity_scope_1" name="authority_validity_scope" value="1" class="text-blue-600" required>
                                            {{ __('Limited to affiliation') }}
                                        </label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" id="authority_validity_scope_2" name="authority_validity_scope" value="2" class="text-blue-600" required>
                                            {{ __('Below affiliation') }}
                                        </label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" id="authority_validity_scope_3" name="authority_validity_scope" value="3" class="text-blue-600" required>
                                            {{ __('All affiliations') }}
                                        </label>
                                    </div>
                                    <select name="authority_validity_code" id="authority_validity_code" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                        @foreach ($affiliations as $affiliation)
                                            <option value="{{ $affiliation->affiliation_name }}">{{ $affiliation->affiliation_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Basic Information Section -->
                            <div id="basic-information" class="px-4 py-2.5 bg-blue-100 text-blue-900 font-semibold rounded-lg text-sm" title="{{ __('Basic Information') }}">
                                {{ __('Basic Information') }}
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Email') }}: <span class="text-red-500">*</span></label>
                                        <input type="email" title="Email Address" name="email" id="email" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label for="email_confirmation" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Confirm Email') }}: <span class="text-red-500">*</span></label>
                                        <input type="email" name="email_confirmation" id="email_confirmation" title="Email Address Confirmation" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="contact_phonenumber" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Contact Phone Number') }}: <span class="text-red-500">*</span></label>
                                        <input type="text" name="contact_phonenumber" id="contact_phonenumber" title="Contact Phone Number" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label for="employee_code" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Employee Code') }}: <span class="text-red-500">*</span></label>
                                        <input type="text" name="employee_code" id="employee_code" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Employee Code" maxlength="10" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Sex') }}: <span class="text-red-500">*</span></label>
                                    <div class="flex gap-6 text-sm text-slate-700">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sex" id="male" value="male" class="text-blue-600" required> {{ __('Male') }}</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sex" id="female" value="female" class="text-blue-600" required> {{ __('Female') }}</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sex" id="other" value="other" class="text-blue-600" required> {{ __('Other') }}</label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="dateofbirth" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Date of Birth') }}: <span class="text-red-500">*</span></label>
                                        <input type="date" name="dateofbirth" id="dateofbirth" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Date of Birth" min="1970-01-01" max="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div>
                                        <label for="dateofjoining" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Date of Joining') }}: <span class="text-red-500">*</span></label>
                                        <input type="date" name="dateofjoining" id="dateofjoining" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Date of Joining" min="2022-01-01" max="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div>
                                        <label for="retirementdate" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Retirement Date') }}:</label>
                                        <input type="date" name="retirementdate" id="retirementdate" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Retirement Date" min="2022-01-01" max="2050-12-31">
                                    </div>
                                </div>

                                @for ($i = 1; $i <= 5; $i++)
                                    @php $key_index = 'employee_attribute0' . $i . '_displayname'; @endphp
                                    @if (isset($attribute->{$key_index}) && $attribute->{$key_index})
                                        <div>
                                            <label for="employee_attribute0{{ $i }}" class="block text-sm font-medium text-slate-700 mb-1">{{ $attribute->{$key_index} ?? '' }}</label>
                                            <input type="text" name="employee_attribute0{{ $i }}" id="employee_attribute0{{ $i }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    @endif
                                @endfor

                                <div>
                                    <label for="remarks" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Remarks') }}:</label>
                                    <textarea name="remarks" id="remarks" title="Remarks" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <div id="account-information" class="px-4 py-2.5 bg-blue-100 text-blue-900 font-semibold rounded-lg text-sm" title="{{ __('Account Information') }}">
                                {{ __('Account Information') }}
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Password') }}: <span class="text-red-500">*</span></label>
                                    <div class="relative max-w-md">
                                        <input type="password" name="password" id="password" class="w-full pr-10 px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Password" minlength="8" required>
                                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label for="account_status" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Account Status') }}:</label>
                                    <select name="account_status" id="account_status" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="Account Status">
                                        <option value="enabled" selected title="{{ __('Account Enabled') }}">{{ __('Account Enabled') }}</option>
                                        <option value="disabled" title="{{ __('Account Disabled') }}">{{ __('Account Disabled') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="password_expiration" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Password Expiration Date') }}:</label>
                                    <input type="date" name="password_expiration" id="password_expiration" class="w-full max-w-xs px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" title="Password Expiration Date">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="pt-6 border-t border-slate-100 flex justify-center items-center gap-4">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="Register">
                                    <i class="fas fa-floppy-disk"></i> {{ __('Register') }}
                                </button>
                                <button type="reset" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium rounded-lg transition" title="Clear">
                                    <i class="fas fa-trash"></i> {{ __('Clear') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sticky Navigation Side Panel -->
            <div class="hidden lg:block lg:col-span-3 sticky top-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 space-y-2">
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Navigation</div>
                    <a href="{{ route('employee-list') }}" class="block px-3 py-2 rounded-lg bg-blue-900 text-white text-xs font-medium hover:bg-blue-800 transition">{{ __('Employee List') }}</a>
                    <a href="{{ route('member-registration.create') }}" class="block px-3 py-2 rounded-lg bg-blue-900 text-white text-xs font-medium hover:bg-blue-800 transition">{{ __('Employee Registration') }}</a>
                    <a href="#affiliation-information" class="block px-3 py-2 rounded-lg bg-blue-50 text-blue-900 text-xs font-medium hover:bg-blue-100 transition">{{ __('Affiliation Information') }}</a>
                    <a href="#basic-information" class="block px-3 py-2 rounded-lg bg-blue-50 text-blue-900 text-xs font-medium hover:bg-blue-100 transition">{{ __('Basic Information') }}</a>
                    <a href="#account-information" class="block px-3 py-2 rounded-lg bg-blue-50 text-blue-900 text-xs font-medium hover:bg-blue-100 transition">{{ __('Account Information') }}</a>
                    <a href="#registration" class="block px-3 py-2 rounded-lg bg-blue-900 text-white text-xs font-medium hover:bg-blue-800 transition">{{ __('Registration') }}</a>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection

@push('scripts')
<script>
    var dateOfBirthInput = document.getElementById('dateofbirth');
    var dateOfJoiningInput = document.getElementById('dateofjoining');

    if (dateOfBirthInput) {
        dateOfBirthInput.addEventListener('input', function() {
            var selectedDate = new Date(this.value);
            var maxDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();
            var currentDay = parseInt(dateOfBirthInput.value.split('-')[2]);
            if (currentDay > maxDay) {
                dateOfBirthInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + maxDay;
            }
        });
    }

    if (dateOfJoiningInput) {
        dateOfJoiningInput.addEventListener('input', function() {
            var selectedDate = new Date(this.value);
            var maxDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();
            var currentDay = parseInt(dateOfJoiningInput.value.split('-')[2]);
            if (currentDay > maxDay) {
                dateOfJoiningInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + maxDay;
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password");
        const passwordToggle = document.getElementById("togglePassword");
        const passwordToggleIcon = document.getElementById("passwordToggleIcon");

        if (passwordToggle && passwordInput) {
            passwordToggle.addEventListener("click", function() {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    passwordToggleIcon.classList.remove("fa-eye");
                    passwordToggleIcon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password";
                    passwordToggleIcon.classList.remove("fa-eye-slash");
                    passwordToggleIcon.classList.add("fa-eye");
                }
            });
        }
    });
</script>
@endpush
