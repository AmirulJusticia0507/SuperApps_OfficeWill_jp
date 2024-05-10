@extends('layouts.app')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

@section('content')
    <div class="content-wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Include Header -->
            @include('includes.header')
        </nav>


        <!-- Include Sidebar -->
        @include('includes.sidebar')
        <div class="container">
            <div align="center">
                <h2>Member Registration</h2>
                <form action="{{ route('member-registration.store') }}" method="POST">
                    @csrf
                    <!-- Form untuk informasi pribadi -->
                    <div class="row">
                        <div class="col-md-6">
                            <h4> Employee information</h4>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name: <span style="color: red">*</span></label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="kana_name" class="form-label">Kana Name: <span style="color: red">*</span></label>
                                <input type="text" name="kana_name" id="kana_name" class="form-control" required>
                            </div>
                            <hr>
                        <h4> Affiliation information</h4>
                        <!-- Form untuk informasi keanggotaan -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="affiliation_start_date">Affiliation Start Date: <b style="color: red">*</b></label>
                                    <input type="date" name="affiliation_start_date" id="affiliation_start_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                                    <input type="text" name="affiliation_name" id="affiliation_name" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="job_title">Job Title: <b style="color: red">*</b></label>
                                    <input type="text" name="job_title" id="job_title" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>System Administrator Privileges: <b style="color: red">*</b></label>
                                    <div>
                                        <input type="checkbox" name="system_admin_privileges" value="1"> <label class="checkbox-label">With Permission</label>
                                        <input type="checkbox" name="system_admin_privileges" value="0"> <label class="checkbox-label">Without Permission</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Employee Registration Authority: <b style="color: red">*</b></label>
                                    <div>
                                        <input type="checkbox" name="employee_registration_authority" value="1"> <label class="checkbox-label">With Permission</label>
                                        <input type="checkbox" name="employee_registration_authority" value="0"> <label class="checkbox-label">Without Permission</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Course Enrollment Privileges: <b style="color: red">*</b></label>
                                    <div>
                                        <input type="checkbox" name="course_enrollment_privileges" value="1"> <label class="checkbox-label">With Permission</label>
                                        <input type="checkbox" name="course_enrollment_privileges" value="0"> <label class="checkbox-label">Without Permission</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Attendance Settings Authority: <b style="color: red">*</b></label>
                                    <div>
                                        <input type="checkbox" name="attendance_settings_authority" value="1"> <label class="checkbox-label">With Permission</label>
                                        <input type="checkbox" name="attendance_settings_authority" value="0"> <label class="checkbox-label">Without Permission</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="authority_effective_affiliation">Authority Effective Affiliation: <b style="color: red">*</b></label>
                                    <div>
                                        <input type="checkbox" name="authority_effective_affiliation" value="1"> <label class="checkbox-label">Limited to affiliation</label><br>
                                        <input type="checkbox" name="authority_effective_affiliation" value="2"> <label class="checkbox-label">Below affiliation</label><br>
                                        <input type="checkbox" name="authority_effective_affiliation" value="3"> <label class="checkbox-label">All affiliations</label>
                                    </div>
                                </div>
                            </div>
                        </div><br><hr>
                        <h4> basic information</h4>
                        <div class="mb-3">
                            <label for="email_address">Email Address:</label>
                            <input type="email" name="email_address" id="email_address" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email_address_confirmation">Email Address Confirmation:</label>
                            <input type="email" name="email_address_confirmation" id="email_address_confirmation" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone_number">Contact Phone Number:</label>
                            <input type="text" name="contact_phone_number" id="contact_phone_number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="employee_code">Employee Code:</label>
                            <input type="text" name="employee_code" id="employee_code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="sex">Sex:</label>
                            <div>
                                <input type="radio" name="sex" id="male" value="male"> <label for="male">Male</label>
                                <input type="radio" name="sex" id="female" value="female"> <label for="female">Female</label>
                                <input type="radio" name="sex" id="other" value="other"> <label for="other">Other</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth">Date of Birth:</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" min="1970-01-01" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="date_of_joining">Date of Joining:</label>
                            <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" min="2022-01-01" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="retirement_date">Retirement Date:</label>
                            <input type="date" name="retirement_date" id="retirement_date" class="form-control" min="2022-01-01" max="2050-12-31">
                        </div>
                        <!-- Tambahkan input untuk atribut karyawan -->
                        <div class="mb-3">
                            <label for="remarks">Remarks:</label>
                            <textarea name="remarks" id="remarks" class="form-control"></textarea>
                        </div>
                    </div>
                </div><br><hr>
                <h4> account information</h4>
                <!-- Form untuk informasi akun -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="account_status">Account Status:</label>
                            <select name="account_status" id="account_status" class="form-control">
                                <option value="enabled" selected>Account Enabled</option>
                                <option value="disabled">Account Disabled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password_expiration_date">Password Expiration Date:</label>
                            <input type="date" name="password_expiration_date" id="password_expiration_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="number_of_incorrect_passwords">Number of Incorrect Passwords:</label>
                            <input type="number" name="number_of_incorrect_passwords" id="number_of_incorrect_passwords" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="account_lock_date_time">Account Lock Date and Time:</label>
                            <input type="datetime-local" name="account_lock_date_time" id="account_lock_date_time" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Register</button>
                <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div><br><br><br>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.15/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tambahkan event click pada tombol pushmenu
            $('.nav-link[data-widget="pushmenu"]').on('click', function() {
                // Toggle class 'sidebar-collapse' pada elemen body
                $('body').toggleClass('sidebar-collapse');
            });
        });
    </script>
@endpush


@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <!-- Include Header -->
        @include('includes.header')
    </nav>

    <!-- Include Sidebar -->
    @include('includes.sidebar')
    <div class="container">
        <div align="center">
            <h2>Employee Registration</h2>
            <form action="{{ route('member-registration.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h4>Employee Information</h4>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name: <span style="color: red">*</span></label>
                            <input type="text" name="full_name" id="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="kana_name" class="form-label">Kana Name: <span style="color: red">*</span></label>
                            <input type="text" name="kana_name" id="kana_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="affiliation_start_date">Affiliation Start Date: <b style="color: red">*</b></label>
                                <input type="date" name="affiliation_start_date" id="affiliation_start_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="affiliation_name">Affiliation Name: <b style="color: red">*</b></label>
                                <input type="text" name="affiliation_name" id="affiliation_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="job_title">Job Title: <b style="color: red">*</b></label>
                                <input type="text" name="job_title" id="job_title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>System Administrator Privileges: <b style="color: red">*</b></label>
                                <div>
                                    <input type="checkbox" name="system_admin_privileges" value="1"> <label class="checkbox-label">With Permission</label>
                                    <input type="checkbox" name="system_admin_privileges" value="0"> <label class="checkbox-label">Without Permission</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Employee Registration Authority: <b style="color: red">*</b></label>
                                <div>
                                    <input type="checkbox" name="employee_registration_authority" value="1"> <label class="checkbox-label">With Permission</label>
                                    <input type="checkbox" name="employee_registration_authority" value="0"> <label class="checkbox-label">Without Permission</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Course Enrollment Privileges: <b style="color: red">*</b></label>
                                <div>
                                    <input type="checkbox" name="course_enrollment_privileges" value="1"> <label class="checkbox-label">With Permission</label>
                                    <input type="checkbox" name="course_enrollment_privileges" value="0"> <label class="checkbox-label">Without Permission</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Attendance Settings Authority: <b style="color: red">*</b></label>
                                <div>
                                    <input type="checkbox" name="attendance_settings_authority" value="1"> <label class="checkbox-label">With Permission</label>
                                    <input type="checkbox" name="attendance_settings_authority" value="0"> <label class="checkbox-label">Without Permission</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="authority_effective_affiliation">Authority Effective Affiliation: <b style="color: red">*</b></label>
                                <div>
                                    <input type="checkbox" name="authority_effective_affiliation" value="1"> <label class="checkbox-label">Limited to affiliation</label><br>
                                    <input type="checkbox" name="authority_effective_affiliation" value="2"> <label class="checkbox-label">Below affiliation</label><br>
                                    <input type="checkbox" name="authority_effective_affiliation" value="3"> <label class="checkbox-label">All affiliations</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Informasi Dasar -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Basic Information</h4>
                        <!-- Tambahkan bagian informasi dasar -->
                        <div class="mb-3">
                            <label for="email_address">Email Address:</label>
                            <input type="email" name="email_address" id="email_address" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email_address_confirmation">Email Address Confirmation:</label>
                            <input type="email" name="email_address_confirmation" id="email_address_confirmation" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone_number">Contact Phone Number:</label>
                            <input type="text" name="contact_phone_number" id="contact_phone_number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="employee_code">Employee Code:</label>
                            <input type="text" name="employee_code" id="employee_code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="sex">Sex:</label>
                            <div>
                                <input type="radio" name="sex" id="male" value="male"> <label for="male">Male</label>
                                <input type="radio" name="sex" id="female" value="female"> <label for="female">Female</label>
                                <input type="radio" name="sex" id="other" value="other"> <label for="other">Other</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth">Date of Birth:</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" min="1970-01-01" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="date_of_joining">Date of Joining:</label>
                            <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" min="2022-01-01" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="retirement_date">Retirement Date:</label>
                            <input type="date" name="retirement_date" id="retirement_date" class="form-control" min="2022-01-01" max="2050-12-31">
                        </div>
                        <!-- Tambahkan input untuk atribut karyawan -->
                        <div class="mb-3">
                            <label for="remarks">Remarks:</label>
                            <textarea name="remarks" id="remarks" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Lanjutkan untuk bagian informasi dasar -->
                    </div>
                </div>
                <!-- Informasi Akun -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Account Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="account_status">Account Status:</label>
                                    <select name="account_status" id="account_status" class="form-control">
                                        <option value="enabled" selected>Account Enabled</option>
                                        <option value="disabled">Account Disabled</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password_expiration_date">Password Expiration Date:</label>
                                    <input type="date" name="password_expiration_date" id="password_expiration_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="number_of_incorrect_passwords">Number of Incorrect Passwords:</label>
                                    <input type="number" name="number_of_incorrect_passwords" id="number_of_incorrect_passwords" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="account_lock_date_time">Account Lock Date and Time:</label>
                                    <input type="datetime-local" name="account_lock_date_time" id="account_lock_date_time" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Lanjutkan untuk bagian informasi akun -->
                    </div>
                </div>
                <div align="center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Register</button>
                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
