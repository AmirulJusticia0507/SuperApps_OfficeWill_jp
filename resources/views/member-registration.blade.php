@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .sticky-list-group {
        position: sticky;
        top: 10px;
        /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
    }
    .member-registration-page { width: calc(100% - 16rem); max-width: none; margin-left: 16rem; margin-right: 0; padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    .member-registration-page > .col-md-3 { flex: 0 0 0; width: 0; max-width: 0; padding: 0; overflow: visible; }
    .member-registration-page > .col-md-6 { flex: 0 0 100%; width: 100%; max-width: 100%; padding: 0; }
    .member-registration-page > .col-md-2 { display: none; }
    body.sidebar-collapsed .member-registration-page { width: calc(100% - 4.5rem); margin-left: 4.5rem; }
    @media (max-width: 767.98px) {
        .member-registration-page, body.sidebar-collapsed .member-registration-page { width: 100%; margin-left: 0; padding: 1rem; }
    }
</style>

@section('content')
    <!-- Header -->
    @include('includes.header')

    {{-- <div class="container"> --}}
    <div class="row justify-content-center member-registration-page">
        <!-- Sidebar -->
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-6">
            <br><br><br>
            <!-- Create Classification Form -->
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('member-registration.create') }}"
                            title="{{ __('Employee Registration') }}">{{ __('Employee Registration') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="{{ __('Employee List') }}">{{ __('Employee List') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" title="{{ __('Employee Information Registration') }}">{{ __('Employee Information Registration') }}
                    </li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header" id="registration" style="background-color: darkblue" title="Employee Registration">
                    <b style="color:aliceblue">{{ __('Employee Registration') }}</b>
                </div>
                <div class="card-body">
                    <form action="{{ route('member-registration.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="row"> --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">{{ __('Full Name') }}: <span style="color: red">*</span></label>
                                <input type="text" name="fullname" id="fullname" title="Full Name" class="form-control"
                                    required style="display: inline-block; width: 72%;">
                            </div>
                            <div class="mb-3">
                                <label for="kananame" class="form-label">{{ __('Kana Name') }}: <span style="color: red">*</span></label>
                                <input type="text" name="kananame" id="kananame" title="Kana Name" class="form-control"
                                    required style="display: inline-block; width: 70%;">
                            </div>
                        </div>
                        <div id="affiliation-information" class="card-header" title="Affiliation information"
                            style="background-color: #92CDFC"><b style="color:aliceblue"> {{ __('Affiliation Information') }}</b></div><br>
                        <div class="mb-3">
                            <label for="application_startdate">{{ __('Affiliation Start Date') }}: <b style="color: red">*</b></label>
                            <input type="date" name="application_startdate" id="application_startdate"
                                title="Affiliation Start Date" class="form-control"
                                style="display: inline-block; width: 25%;">
                        </div>
                        <!-- <div class="mb-3">
                                                <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                                                <input type="text" name="affiliation_name" id="affiliation_name" class="form-control" style="width: 100%" required>
                                            </div> -->
                        <div class="mb-3">
                            <label for="affiliation">{{ __('Affiliation Name') }}: <b style="color: red">*</b></label>
                            <select name="affiliation" id="affiliation" class="form-control" title="Affiliation Name"
                                style="display: inline-block; width: 81%;" required>
                                <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                @foreach ($affiliations as $affiliation)
                                    <option value="{{ $affiliation->affiliation_code }}">
                                        {{ $affiliation->affiliation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                                                <label for="job_title">Job Title: <b style="color: red">*</b></label>
                                                <input type="text" name="job_title" id="job_title" class="form-control" style="width: 100%" required>
                                            </div> -->
                        <div class="mb-3">
                            <label for="job">{{ __('Job Title') }}: <b style="color: red">*</b></label>
                            <select name="job" title="Job Title" id="job" class="form-control"
                                style="display: inline-block; width: 88%;" required>
                                <option value="" title="{{ __('Select Job Title') }}">{{ __('Select Job Title') }}</option>
                                @foreach ($jobTitles as $jobTitle)
                                    <option value="{{ $jobTitle->job_id }}">{{ $jobTitle->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label title="{{ __('System Administrator Privileges') }}">{{ __('System Administrator Privileges') }}: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="system_administrator_privileges" title="With Permission"
                                    value="1" required>
                                <label class="checkbox-label">{{ __('With Permission') }}</label>
                                <input type="radio" name="system_administrator_privileges" title="Without Permission"
                                    value="0" required>
                                <label class="checkbox-label">{{ __('Without Permission') }}</label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label title="{{ __('Employee Registration Authority') }}">{{ __('Employee Registration Authority') }}: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="employee_registration_authority" value="1" required
                                    title="{{ __('With Permission') }}"><label class="checkbox-label">{{ __('With Permission') }}</label>
                                <input type="radio" name="employee_registration_authority" value="0" required
                                    title="{{ __('Without Permission') }}"><label class="checkbox-label">{{ __('Without Permission') }}</label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label title="{{ __('Course Enrollment Privileges') }}">{{ __('Course Enrollment Privileges') }}: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="course_enrollment_privileges" value="1"
                                    title="With Permission" required> <label class="checkbox-label">許可を得て</label>
                                <input type="radio" name="course_enrollment_privileges" value="0"
                                    title="Without Permission" required> <label class="checkbox-label">無許可での</label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label title="{{ __('Attendance Settings Authority') }}">{{ __('Attendance Settings Authority') }}: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="attendance_setting_authority" title="With Permission"
                                    value="1" required> <label class="checkbox-label">{{ __('With Permission') }}</label>
                                <input type="radio" name="attendance_setting_authority" title="Without Permission"
                                    value="0" required> <label class="checkbox-label">{{ __('Without Permission') }}</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="authority_validity_scope" title="{{ __('Authority Effective Affiliation') }}">{{ __('Authority Effective Affiliation') }}: <b
                                    style="color: red">*</b></label>
                            <div class="d-inline-block mb-3">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="authority_validity_scope_1"
                                        name="authority_validity_scope" title="Limited to affiliation" value="1"
                                        required>
                                    <label class="form-check-label" for="authority_validity_scope_1">{{ __('Limited to affiliation') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="authority_validity_scope_2"
                                        name="authority_validity_scope" title="Below affiliation" value="2"
                                        required>
                                    <label class="form-check-label" for="authority_validity_scope_2">{{ __('Below affiliation') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="authority_validity_scope_3"
                                        name="authority_validity_scope" title="All affiliations" value="3" required>
                                    <label class="form-check-label" for="authority_validity_scope_3">{{ __('All affiliations') }}
                                </div>
                            </div>
                            <select name="authority_validity_code" id="authority_validity_code" class="form-control"
                                style="display: inline-block; width: 81%;" required>
                                <option value="" title="{{ __('Select Affiliation') }}">{{ __('Select Affiliation') }}</option>
                                @foreach ($affiliations as $affiliation)
                                    <option value="{{ $affiliation->affiliation_name }}">
                                        {{ $affiliation->affiliation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Informasi Dasar -->
                        <div id="basic-information" class="card-header" style="background-color: #92CDFC"
                            title="{{ __('Basic Information') }}"><b style="color:aliceblue"> {{ __('Basic Information') }}</b></div>
                        <div class="mb-3">
                            <label for="email">{{ __('Email') }}: <b style="color: red">*</b></label>
                            <input type="email" title="Email Address" name="email" id="email"
                                class="form-control" required style="width: 100%">
                        </div>
                        <div class="mb-3">
                            <label for="email_confirmation">{{ __('Confirm Email') }}: <b style="color: red">*</b></label>
                            <input type="email" name="email_confirmation" id="email_confirmation"
                                title="Email Address Confirmation" class="form-control" required style="width: 100%">
                        </div>
                        <div class="mb-3">
                            <label for="contact_phonenumber">{{ __('Contact Phone Number') }}: <b style="color: red">*</b></label>
                            <input type="text" name="contact_phonenumber" id="contact_phonenumber"
                                title="Contact Phone Number" class="form-control" required style="width: 100%">
                        </div>
                        <div class="mb-3">
                            <label for="employee_code">{{ __('Employee Code') }}:</label>
                            <input type="text" name="employee_code" id="employee_code" class="form-control"
                                title="Employee Code" maxlength="10" required>
                        </div>
                        <div class="mb-3">
                            <div style="display: flex; align-items: center;">
                                <label for="sex" style="margin-right: 10px;" style="width: 100%"
                                     title="{{ __('Sex') }}">{{ __('Sex') }}: <b style="color: red">*</b></label>
                                <div style="display: flex;">
                                    <input type="radio" name="sex" id="male" value="male" title="Male"
                                        required>
                                    &nbsp;<label for="male" style="margin-right: 10px;"> {{ __('Male') }}</label>
                                    <input type="radio" name="sex" id="female" value="female" title="Female"
                                        required>
                                    &nbsp;<label for="female" style="margin-right: 10px;"> {{ __('Female') }}</label>
                                    <input type="radio" name="sex" id="other" title="Other" value="other"
                                        required>
                                    &nbsp;<label for="other"> {{ __('Other') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="dateofbirth" style="margin-right: 10px; flex-grow: 1;">{{ __('Date of Birth') }}: <b
                                    style="color: red">*</b></label>
                            <input type="date" name="dateofbirth" id="dateofbirth" class="form-control"
                                title="Date of Birth" min="1970-01-01" max="{{ date('Y-m-d') }}" style="width: 100%"
                                required>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="dateofjoining" style="margin-right: 10px; flex-grow: 1;">{{ __('Date of Joining') }}:</label>
                            <input type="date" name="dateofjoining" id="dateofjoining" class="form-control"
                                title="Date of Joining" min="2022-01-01" max="{{ date('Y-m-d') }}" style="width: 100%"
                                required>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="retirementdate" style="margin-right: 10px; flex-grow: 1;">{{ __('Retirement Date') }}:</label>
                            <input type="date" name="retirementdate" id="retirementdate" class="form-control"
                                title="Retirement Date" min="2022-01-01" max="2050-12-31">
                        </div>
                        <!-- Tambahkan input untuk atribut karyawan -->
                        @for ($i = 1; $i <= 5; $i++)
                            @php
                                $key_index = 'employee_attribute0' . $i . '_displayname';
                            @endphp
                            @if (isset($attribute->{$key_index}) && $attribute->{$key_index})
                                <div class="mb-3" style="display: flex; align-items: center;">
                                    <label for="employee_attribute0{{ $i }}_displayname"
                                        style="margin-right: 10px; flex-grow: 1;">
                                        {{ $attribute->{$key_index} ?? '' }}
                                    </label>
                                    <input type="text" name="employee_attribute0{{ $i }}"
                                        id="employee_attribute0{{ $i }}" class="form-control"
                                        title="employee attribute0">
                                </div>
                            @endif
                        @endfor

                        <div class="mb-3">
                            <label for="remarks">{{ __('Remarks') }}:</label>
                            <textarea name="remarks" id="remarks" title="Remarks" class="form-control" cols="5" rows="5"></textarea>
                        </div>
                        <div id="account-information" class="card-header" style="background-color: #92CDFC"
                            title="{{ __('Account Information') }}"><b style="color:aliceblue"> {{ __('Account Information') }}</b></div>
                        <br>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="password" style="margin-right: 10px;">{{ __('Password') }}:</label>
                            <input type="password" name="password" id="password" class="form-control"
                                style="width: 100%" title="Password" minlength="8" required>
                            <button type="button" id="togglePassword"
                                style="border: none; background: none; outline: none; margin-left: -30px;">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="account_status" style="margin-right: 10px;">{{ __('Account Status') }}:</label>
                            <select name="account_status" id="account_status" class="form-control" style="width: 100%"
                                title="Account Status">
                                <option value="enabled" selected title="{{ __('Account Enabled') }}">{{ __('Account Enabled') }}</option>
                                <option value="disabled" title="{{ __('Account Disabled') }}">{{ __('Account Disabled') }}</option>
                            </select>
                        </div>
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <label for="password_expiration" style="margin-right: 10px;">{{ __('Password Expiration Date') }}:</label>
                            <input type="date" name="password_expiration" id="password_expiration"
                                class="form-control" title="Password Expiration Date">
                        </div>


                        <div align="center">
                            <button type="submit" class="btn btn-primary" title="Register"><i
                                    class="fas fa-floppy-disk"></i> {{ __('Register') }}</button>
                            <button type="button" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i>
                                 {{ __('Clear') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- List of Links and Buttons -->
        <div class="col-md-2">
            <br><br><br><br><br>
            <div class="mt-2 sticky-list-group">
                <ul class="list-group rounded-6">
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a
                            href="{{ route('employee-list') }}" title="Employee list"><b style="color:aliceblue">
                                 {{ __('Employee List') }}</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a
                            href="{{ route('member-registration.create') }}" title="Employee registration"><b
                                 style="color:aliceblue"> {{ __('Employee Registration') }}</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a
                            href="#affiliation-information" title="Affiliation information"><b style="color:aliceblue">
                                 {{ __('Affiliation Information') }}</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#basic-information"
                             title="{{ __('Basic Information') }}"><b style="color:aliceblue"> {{ __('Basic Information') }}</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a
                            href="#account-information" title="Account information"><b style="color:aliceblue">
                                 {{ __('Account Information') }}</b></a></li>
                    <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#registration"
                             title="{{ __('Registration') }}"><b style="color:aliceblue"> {{ __('Registration') }}</b></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('includes.footer')
@endsection

<script>
    // Mendapatkan elemen input dateofbirth
    var dateOfBirthInput = document.getElementById('dateofbirth');
    // Mendapatkan elemen input dateofjoining
    var dateOfJoiningInput = document.getElementById('dateofjoining');

    // Batasi pilihan bulan untuk dateofbirth
    dateOfBirthInput.addEventListener('input', function() {
        var selectedDate = new Date(this.value);
        var maxDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();
        var currentDay = parseInt(dateOfBirthInput.value.split('-')[2]);
        if (currentDay > maxDay) {
            dateOfBirthInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1))
                .slice(-2) + '-' + maxDay;
        }
    });

    // Batasi pilihan bulan untuk dateofjoining
    dateOfJoiningInput.addEventListener('input', function() {
        var selectedDate = new Date(this.value);
        var maxDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();
        var currentDay = parseInt(dateOfJoiningInput.value.split('-')[2]);
        if (currentDay > maxDay) {
            dateOfJoiningInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1))
                .slice(-2) + '-' + maxDay;
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password");
        const passwordToggle = document.getElementById("togglePassword");
        const passwordToggleIcon = document.getElementById("passwordToggleIcon");

        // Tambahkan event listener untuk tombol toggle
        passwordToggle.addEventListener("click", function() {
            // Ubah tipe input password menjadi text atau sebaliknya
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
    });
</script>
