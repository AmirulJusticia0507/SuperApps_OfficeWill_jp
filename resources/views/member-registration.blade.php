@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .sticky-list-group {
        position: sticky;
        top: 10px; /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
    }
</style>

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
                <li class="breadcrumb-item"><a href="{{ route('member-registration.create') }}" title="Employee Registration">従業員の登録</a></li>
                <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="Employee List">従業員リスト</a></li>
                <li class="breadcrumb-item active" aria-current="page" title="Employee Information Registration">従業員情報登録</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header" id="registration" style="background-color: darkblue" title="Employee Registration"><b style="color:aliceblue">従業員の登録</b></div>
            <div class="card-body">
                <form action="{{ isset($member) ? route('member-registration.update', ['id' => $member->employee_id]) : route('member-registration.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($member))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <input type="hidden" name="employee_id" value="{{ $member->employee_id ?? '' }}">
                        <div class="form-group">
                            <label for="company_id">Company:</label>
                            <select class="form-select" id="company_id" name="company_id" required>
                                <option value="" selected disabled>Select Company</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ isset($member) && $member->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="fullname" class="form-label">フルネーム: <span style="color: red">*</span></label>
                                <input type="text" name="fullname" id="fullname" title="Full Name" value="{{ $member->fullname ?? '' }}" class="form-control" required style="display: inline-block; width: 87%;">
                            </div>
                            <div class="form-group">
                                <label for="kananame" class="form-label">そのルール: <span style="color: red">*</span></label>
                                <input type="text" name="kananame" id="kananame" title="Kana Name" class="form-control" value="{{ $member->kananame ?? '' }}" required style="display: inline-block; width: 87%;">
                            </div>
                        </div>
                        <!-- Informasi Dasar -->
                        <div id="basic-information" class="card-header" style="background-color: #92CDFC" title="Basic information"><b style="color:aliceblue"> 基本情報</b></div>
                            <div class="mb-3">
                                <label for="email_address">電子メールアドレス: <b style="color: red">*</b></label>
                                <input type="email" title="Email Address" name="email_address" id="email_address" value="{{ $member->email_address ?? '' }}" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="email_address_confirmation">メールアドレスの確認: <b style="color: red">*</b></label>
                                <input type="email" name="email_address_confirmation" id="email_address_confirmation" value="{{ $member->email_address_confirmation ?? '' }}" title="Email Address Confirmation" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="contact_phonenumber">連絡先の電話番号: <b style="color: red">*</b></label>
                                <input type="text" name="contact_phonenumber" id="contact_phonenumber" title="Contact Phone Number" value="{{ $member->contact_phonenumber ?? '' }}" class="form-control" required style="width: 100%">
                            </div>
                            <div class="mb-3">
                                <label for="employee_code">従業員コード:</label>
                                <input type="text" name="employee_code" id="employee_code" class="form-control" value="{{ $member->employee_code ?? '' }}" title="Employee Code">
                            </div>
                            <div class="mb-3">
                                <div style="display: flex; align-items: center;">
                                    <label for="sex" style="margin-right: 10px;" style="width: 100%" title="Sex">セックス: <b style="color: red">*</b></label>
                                    <div style="display: flex;">
                                        <input type="radio" name="sex" id="male" value="male" title="Male" required {{ isset($member) && $member->sex == 'male' ? 'checked' : '' }}>
                                        &nbsp;<label for="male" style="margin-right: 10px;"> 男</label>
                                        
                                        <input type="radio" name="sex" id="female" value="female" title="Female" required {{ isset($member) && $member->sex == 'female' ? 'checked' : '' }}>
                                        &nbsp;<label for="female" style="margin-right: 10px;"> 女性</label>
                                        
                                        <input type="radio" name="sex" id="other" value="other" title="Other" required {{ isset($member) && $member->sex == 'other' ? 'checked' : '' }}>
                                        &nbsp;<label for="other"> 他の</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="dateofbirth" style="margin-right: 10px; flex-grow: 1;">生年月日: <b style="color: red">*</b></label>
                                <input type="date" name="dateofbirth" id="dateofbirth" class="form-control" title="Date of Birth" min="1970-01-01" max="{{ date('Y-m-d') }}" style="width: 100%" value="{{ $member->dateofbirth ?? '' }}" required>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="dateofjoining" style="margin-right: 10px; flex-grow: 1;">入社の日:</label>
                                <input type="date" name="dateofjoining" id="dateofjoining" class="form-control" title="Date of Joining" min="2022-01-01" max="{{ date('Y-m-d') }}" style="width: 100%" value="{{ $member->dateofjoining ?? '' }}" required>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="retirementdate" style="margin-right: 10px; flex-grow: 1;">退職日:</label>
                                <input type="date" name="retirementdate" id="retirementdate" class="form-control" title="Retirement Date" min="2022-01-01" max="2050-12-31" value="{{ $member->retirementdate ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="remarks">備考:</label>
                                <textarea name="remarks" id="remarks" title="Remarks" class="form-control" cols="5" rows="5">{{ $member->remarks ?? '' }}</textarea>
                            </div>
                            <div id="account-information" class="card-header" style="background-color: #92CDFC" title="Account information"><b style="color:aliceblue">口座情報</b></div>
                            <br>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="encrypted_password" style="margin-right: 10px;">パスワード:</label>
                                <input type="password" name="encrypted_password" id="encrypted_password" class="form-control" style="width: 100%" title="Password">
                                <button type="button" id="togglePassword" style="border: none; background: none; outline: none; margin-left: -30px;">
                                    <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="account_status" style="margin-right: 10px;">アカウントのステータス:</label>
                                <select name="account_status" id="account_status" class="form-control" style="width: 100%" title="Account Status">
                                    <option value="enabled" {{ (isset($member->account_status) && $member->account_status == 'enabled') ? 'selected' : '' }} title="Account Enabled">アカウントが有効になっています</option>
                                    <option value="disabled" {{ (isset($member->account_status) && $member->account_status == 'disabled') ? 'selected' : '' }} title="Account Disabled">アカウントが無効になっています</option>
                                </select>
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="password_expiration" style="margin-right: 10px;">パスワードの有効期限:</label>
                                <input type="date" name="password_expiration" id="password_expiration" class="form-control" title="Password Expiration Date" value="{{ $member->password_expiration ?? '' }}">
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="numberofincorrect_passwords" style="margin-right: 10px;">誤ったパスワードの数:</label>
                                <input type="number" name="numberofincorrect_passwords" id="numberofincorrect_passwords" title="Number of Incorrect Passwords" class="form-control" value="{{ $member->numberofincorrect_passwords ?? '' }}">
                            </div>
                            <div class="mb-3" style="display: flex; align-items: center;">
                                <label for="account_lock_datetime" style="margin-right: 10px;">アカウントロックの日付と時刻:</label>
                                <input type="datetime-local" name="account_lock_datetime" id="account_lock_datetime" title="Account Lock Date and Time" class="form-control" value="{{ isset($member->account_lock_datetime) ? date('Y-m-d\TH:i', strtotime($member->account_lock_datetime)) : '' }}">
                            </div>
                            <div id="affiliation-information" class="card-header" title="Affiliation information" style="background-color: #92CDFC"><b style="color:aliceblue"> 提携情報</b></div><br>
                            @if(isset($member))
                                <input type="hidden" name="employee_id" value="{{ $member->employee_id ?? '' }}">
                            @endif
                            <div class="mb-3">
                                <label for="affiliation_code" title="Affiliation Code">提携コード: <span style="color: red">*</span></label>
                                <input type="text" name="affiliation_code" id="affiliation_code" class="form-control" value="{{ $member->affiliation_code ?? '' }}" required style="display: inline-block; width: 81%;">
                            </div>
                            <div class="mb-3">
                                <label for="affiliation_start_date">所属開始日: <b style="color: red">*</b></label>
                                <input type="date" name="affiliation_start_date" id="affiliation_start_date" title="Affiliation Start Date" class="form-control" style="display: inline-block; width: 25%;">
                            </div>
                            <div class="mb-3">
                                <label for="affiliation_name">所属名: <b style="color: red">*</b></label>
                                <select name="affiliation_name" id="affiliation_name" class="form-control" title="Affiliation Name" style="display: inline-block; width: 81%;" required>
                                    <option value="" title="Select Affiliation<">提携を選択</option>
                                    @foreach($affiliations as $affiliation)
                                        <option value="{{ $affiliation->affiliation_name }}">{{ $affiliation->affiliation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="job_title">役職: <b style="color: red">*</b></label>
                                <select name="job_title" title="Job Title" id="job_title" class="form-control" style="display: inline-block; width: 88%;" required>
                                    <option value="" title="Select Job Title">役職を選択します</option>
                                    @foreach($jobTitles as $jobTitle)
                                        <option value="{{ $jobTitle->job_title }}">{{ $jobTitle->job_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                                <label title="System Administrator Privileges">システム管理者の特権: <b style="color: red">*</b></label>
                                <div>
                                    <input type="radio" name="system_administrator_privileges" title="With Permission" value="1" required>
                                    <label class="checkbox-label">許可を得て</label>
                                    <input type="radio" name="system_administrator_privileges" title="Without Permission" value="0" required>
                                    <label class="checkbox-label">無許可での</label>
                                </div>
                            </div>
                            <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                                <label title="Employee Registration Authority">従業員登録機関: <b style="color: red">*</b></label>
                                <div>
                                    <input type="radio" name="employee_registration_authority" value="1" required title="With Permission"><label class="checkbox-label">許可を得て</label>
                                    <input type="radio" name="employee_registration_authority" value="0" required title="Without Permission"><label class="checkbox-label">無許可での</label>
                                </div>
                            </div>
                            <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                                <label title="Course Enrollment Privileges">コース登録特権: <b style="color: red">*</b></label>
                                <div>
                                    <input type="radio" name="course_enrollment_privileges" value="1" title="With Permission" required> <label class="checkbox-label">許可を得て</label>
                                    <input type="radio" name="course_enrollment_privileges" value="0" title="Without Permission" required> <label class="checkbox-label">無許可での</label>
                                </div>
                            </div>
                            <div class="mb-3" style="display: grid; grid-template-columns: auto auto;">
                                <label title="Attendance Settings Authority">出席設定機関: <b style="color: red">*</b></label>
                                <div>
                                    <input type="radio" name="attendance_setting_authority" title="With Permission" value="1" required> <label class="checkbox-label">許可を得て</label>
                                    <input type="radio" name="attendance_setting_authority" title="Without Permission" value="0" required> <label class="checkbox-label">無許可での</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="authority_validity_scope" title="Authority Effective Affiliation">権限効果的な所属: <b style="color: red">*</b></label>
                                <div class="d-inline-block mb-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="authority_validity_scope_1" name="authority_validity_scope" title="Limited to affiliation" value="1" required>
                                        <label class="form-check-label" for="authority_validity_scope_1">所属に限定</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="authority_validity_scope_2" name="authority_validity_scope" title="Below affiliation" value="2" required>
                                        <label class="form-check-label" for="authority_validity_scope_2">提携の下</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="authority_validity_scope_3" name="authority_validity_scope" title="All affiliations" value="3" required>
                                        <label class="form-check-label" for="authority_validity_scope_3">すべての所属
                                    </div>
                                </div>
                                <select name="authority_validity_code" id="authority_validity_code" class="form-control" style="display: inline-block; width: 81%;" required>
                                    <option value="" title="Select Affiliation">所属を選択します</option>
                                    @foreach($affiliations as $affiliation)
                                        <option value="{{ $affiliation->affiliation_name }}">{{ $affiliation->affiliation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div align="center">
                            <button type="submit" class="btn btn-primary" title="Register"><i class="fas fa-floppy-disk"></i> 登録する</button>
                            <button type="button" class="btn btn-dark" title="Delete"><i class="fas fa-trash"></i> 消去</button>
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
                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('employee-list') }}" title="Employee list"><b style="color:aliceblue"> 社員一覧</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="{{ route('member-registration.create') }}" title="Employee registration"><b style="color:aliceblue">  社員登録トップ</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#affiliation-information" title="Affiliation information"><b style="color:aliceblue"> 所属情報</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#basic-information" title="Basic information"><b style="color:aliceblue"> 基本情報</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: #92CDFC"><a href="#account-information" title="Account information"><b style="color:aliceblue"> アカウント情報</b></a></li>
                <li class="list-group-item rounded-6" style="background-color: darkblue"><a href="#registration" title="Registration"><b style="color:aliceblue"> 登録</b></a></li>
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
            dateOfBirthInput.value = selectedDate.getFullYear() + '-' + ('0' + (selectedDate.getMonth() + 1)).slice(-2) + '-' + maxDay;
        }
    });

    // Batasi pilihan bulan untuk dateofjoining
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

