@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@section('content')
<!-- Header -->
@include('includes.header')

{{-- <div class="container"> --}}
<div class="row justify-content-center">
    <!-- Sidebar -->
    <div class="col-md-3">
        @include('includes.sidebar')
    </div>
    <div class="col-md-4">
        <br><br><br>
        <!-- Create Classification Form -->
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('member-registration.create') }}">Employee Registration</a></li>
                <li class="breadcrumb-item"><a href="{{ route('employee-list') }}">Employee List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Employee Information Registration</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Employee Registration</b></div>
            <div class="card-body">
                <form action="{{ route('member-registration.store') }}" method="POST">
                    @csrf
                    {{-- <div class="row"> --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name: <span
                                        style="color: red">*</span></label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="kana_name" class="form-label">Kana Name: <span
                                        style="color: red">*</span></label>
                                <input type="text" name="kana_name" id="kana_name" class="form-control" required style="width: 100%">
                            </div>
                        </div>
                        <div id="affiliation-information" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue"> Affiliation information</b></div>
                        <div class="mb-3">
                            <label for="affiliation_start_date">Affiliation Start Date: <b
                                    style="color: red">*</b></label>
                            <input type="date" name="affiliation_start_date" id="affiliation_start_date"
                                class="form-control" style="width: 100%">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                            <input type="text" name="affiliation_name" id="affiliation_name" class="form-control" style="width: 100%" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                            <select name="affiliation_name" id="affiliation_name" class="form-control" style="width: 100%" required>
                                <option value="">Select Affiliation</option>
                                @foreach($affiliations as $affiliation)
                                    <option value="{{ $affiliation->affiliation_name }}">{{ $affiliation->affiliation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="job_title">Job Title: <b style="color: red">*</b></label>
                            <input type="text" name="job_title" id="job_title" class="form-control" style="width: 100%" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="job_title">Job Title: <b style="color: red">*</b></label>
                            <select name="job_title" id="job_title" class="form-control" style="width: 100%" required>
                                <option value="">Select Job Title</option>
                                @foreach($jobTitles as $jobTitle)
                                    <option value="{{ $jobTitle->job_title }}">{{ $jobTitle->job_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label>System Administrator Privileges: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="system_admin_privileges" value="1" required>
                                <label class="checkbox-label">With Permission</label>
                                <input type="radio" name="system_admin_privileges" value="0" required>
                                <label class="checkbox-label">Without Permission</label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label>Employee Registration Authority: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="employee_registration_authority" value="1" required> <label class="checkbox-label">With Permission</label>
                                <input type="radio" name="employee_registration_authority" value="0" required> <label class="checkbox-label">Without Permission</label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label>Course Enrollment Privileges: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="course_enrollment_privileges" value="1" required> <label class="checkbox-label">With Permission</label>
                                <input type="radio" name="course_enrollment_privileges" value="0" required> <label class="checkbox-label">Without Permission</label>
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                            <label>Attendance Settings Authority: <b style="color: red">*</b></label>
                            <div>
                                <input type="radio" name="attendance_settings_authority" value="1" required> <label class="checkbox-label">With Permission</label>
                                <input type="radio" name="attendance_settings_authority" value="0" required> <label class="checkbox-label">Without Permission</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="authority_effective_affiliation">Authority Effective Affiliation: <b style="color: red">*</b></label>
                            <div class="d-inline-block">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="authority_effective_affiliation_1" name="authority_effective_affiliation" value="1" required>
                                    <label class="form-check-label" for="authority_effective_affiliation_1">Limited to affiliation</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="authority_effective_affiliation_2" name="authority_effective_affiliation" value="2" required>
                                    <label class="form-check-label" for="authority_effective_affiliation_2">Below affiliation</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="authority_effective_affiliation_3" name="authority_effective_affiliation" value="3" required>
                                    <label class="form-check-label" for="authority_effective_affiliation_3">All affiliations</label>
                                </div>
                            </div>
                        </div>
                    <!-- Informasi Dasar -->
                    <div id="basic-information" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue"> Basic information</b></div>
                            <div class="mb-3">
                                <label for="email_address">Email Address: <b style="color: red">*</b></label>
                                <input type="email" name="email_address" id="email_address" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="email_address_confirmation">Email Address Confirmation: <b style="color: red">*</b></label>
                                <input type="email" name="email_address_confirmation" id="email_address_confirmation" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="contact_phone_number">Contact Phone Number: <b style="color: red">*</b></label>
                                <input type="text" name="contact_phone_number" id="contact_phone_number" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="employee_code">Employee Code:</label>
                                <input type="text" name="employee_code" id="employee_code" class="form-control">
                            </div>
                            <div class="mb-3">
                                <div style="display: flex; align-items: center;">
                                    <label for="sex" style="margin-right: 10px;" style="width: 100%">Sex: <b style="color: red">*</b></label>
                                    <div style="display: flex;">
                                        <input type="radio" name="sex" id="male" value="male" required>
                                        &nbsp;<label for="male" style="margin-right: 10px;"> Male</label>
                                        <input type="radio" name="sex" id="female" value="female" required>
                                        &nbsp;<label for="female" style="margin-right: 10px;"> Female</label>
                                        <input type="radio" name="sex" id="other" value="other" required>
                                        &nbsp;<label for="other"> Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="date_of_birth" style="margin-right: 10px; flex-grow: 1;">Date of Birth: <b style="color: red">*</b></label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" min="1970-01-01" max="{{ date('Y-m-d') }}" style="width: 100%" required>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="date_of_joining" style="margin-right: 10px; flex-grow: 1;">Date of Joining:</label>
                                <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" min="2022-01-01" max="{{ date('Y-m-d') }}" style="width: 100%" required>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="retirement_date" style="margin-right: 10px; flex-grow: 1;">Retirement Date:</label>
                                <input type="date" name="retirement_date" id="retirement_date" class="form-control" min="2022-01-01" max="2050-12-31">
                            </div>
                            <!-- Tambahkan input untuk atribut karyawan -->
                            <div class="mb-3">
                                <label for="remarks">Remarks:</label>
                                <textarea name="remarks" id="remarks" class="form-control" cols="5" rows="5"></textarea>
                            </div>
                            <div id="account-information" class="card-header" style="background-color: #92CDFC"><b style="color:aliceblue"> Account information</b></div>
                            <br>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="encrypted_password" style="margin-right: 10px;">Password:</label>
                                <input type="password" name="encrypted_password" id="encrypted_password" class="form-control" style="width: 100%">
                                <button type="button" id="togglePassword" style="border: none; background: none; outline: none; margin-left: -30px;">
                                    <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="account_status" style="margin-right: 10px;">Account Status:</label>
                                <select name="account_status" id="account_status" class="form-control" style="width: 100%">
                                    <option value="enabled" selected>Account Enabled</option>
                                    <option value="disabled">Account Disabled</option>
                                </select>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="password_expiration_date" style="margin-right: 10px;">Password Expiration Date:</label>
                                <input type="date" name="password_expiration_date" id="password_expiration_date" class="form-control">
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="number_of_incorrect_passwords" style="margin-right: 10px;">Number of Incorrect Passwords:</label>
                                <input type="number" name="number_of_incorrect_passwords" id="number_of_incorrect_passwords" class="form-control">
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="account_lock_date_time" style="margin-right: 10px;">Account Lock Date and Time:</label>
                                <input type="datetime-local" name="account_lock_date_time" id="account_lock_date_time" class="form-control">
                            </div>
                        <div align="center">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Register</button>
                            <button type="button" class="btn btn-dark"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- List of Links and Buttons -->
    <div class="col-md-3">
        <br><br><br><br><br>
        <div class="mt-2">
            <ul class="list-group rounded-6">
                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-list') }}" title="Employee list"><b style="color:aliceblue"> 社員一覧</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('member-registration.create') }}" title="Employee registration"><b style="color:aliceblue">  社員登録トップ</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#affiliation-information" title="Affiliation information"><b style="color:aliceblue"> 所属情報</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#basic-information" title="Basic information"><b style="color:aliceblue"> 基本情報</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#account-information" title="Account information"><b style="color:aliceblue"> アカウント情報</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#" title="Registration"><b style="color:aliceblue"> 登録</b></a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection

<script>
    // Mendapatkan elemen input date_of_birth
    var dateOfBirthInput = document.getElementById('date_of_birth');
    // Mendapatkan elemen input date_of_joining
    var dateOfJoiningInput = document.getElementById('date_of_joining');

    // Batasi pilihan bulan untuk date_of_birth
    dateOfBirthInput.addEventListener('input', function() {
        var selectedDate = new Date(this.value);
        var maxDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();
        var currentDay = parseInt(dateOfBirthInput.value.split('-')[2]);
        if (currentDay > maxDay) {
            dateOfBirthInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + maxDay;
        }
    });

    // Batasi pilihan bulan untuk date_of_joining
    dateOfJoiningInput.addEventListener('input', function() {
        var selectedDate = new Date(this.value);
        var maxDay = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();
        var currentDay = parseInt(dateOfJoiningInput.value.split('-')[2]);
        if (currentDay > maxDay) {
            dateOfJoiningInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + maxDay;
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("encrypted_password");
        const passwordToggle = document.getElementById("togglePassword");
        const passwordToggleIcon = document.getElementById("passwordToggleIcon");

        // Tambahkan event listener untuk tombol toggle
        passwordToggle.addEventListener("click", function () {
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

