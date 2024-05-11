<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterRegistrationController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\AffiliationInformationController;
use App\Http\Controllers\AttendanceTodoAnswerSelectionInformationController;
use App\Http\Controllers\AttendanceTodoItemAnswerInformationController;
use App\Http\Controllers\CompanyInformationController;
use App\Http\Controllers\CourseAttributePulldownSettingsController;
use App\Http\Controllers\CourseAttributeSettingInformationController;
use App\Http\Controllers\CourseClassificationDetailInformationController;
use App\Http\Controllers\CourseClassificationInformationController;
use App\Http\Controllers\CourseInformationController;
use App\Http\Controllers\CourseMaterialInformationController;
use App\Http\Controllers\CourseScheduleResultsInformationController;
use App\Http\Controllers\CourseTodoItemInformationController;
use App\Http\Controllers\CourseTodoItemsChoiceInformationController;
use App\Http\Controllers\EmployeeAffiliationInformationController;
use App\Http\Controllers\EmployeeAttributeDropdownSettingsInformationController;
use App\Http\Controllers\EmployeeAttributeSettingInformationController;
use App\Http\Controllers\EmployeeInformationController;

// Rute untuk menampilkan halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rute untuk menampilkan halaman register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rute untuk menampilkan halaman forgot password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Rute untuk menampilkan halaman reset password
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Rute untuk menampilkan halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Menambahkan rute untuk dashboard

// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk menampilkan halaman registrasi anggota
Route::get('/master-registration', 'MasterRegistrationController@create')->name('master-registration.create');

Route::get('/master-registration', [MasterRegistrationController::class, 'show'])->name('master-registration.show');
Route::post('/member-registration', [MasterRegistrationController::class, 'store'])->name('member-registration.store');

// Rute untuk job titles
Route::resource('job-titles', JobTitleController::class);

// Rute untuk Affiliation Information
Route::resource('affiliation-information', AffiliationInformationController::class);

// Rute untuk Atendance Todo Answer Selection Information
Route::resource('attendance', AttendanceTodoAnswerSelectionInformationController::class);

// Rute untuk Attendance Todo Item Answer Information
Route::resource('attendance-item', AttendanceTodoItemAnswerInformationController::class);

// Rute untuk Company Information
Route::resource('company-information', CompanyInformationController::class);
Route::get('/company-information', [CompanyInformationController::class, 'index'])->name('company-information.index');

// Rute untuk Course Attribute Pulldown Settings
Route::resource('course-attribute-pulldown', CourseAttributePulldownSettingsController::class);

// Rute untuk Course Attribute Setting Information
Route::resource('course-attribute-setting', CourseAttributeSettingInformationController::class);

// Rute untuk Course Classification Detail Information
Route::resource('course-classification-details', CourseClassificationDetailInformationController::class);
Route::post('/course-classification-details', [CourseClassificationDetailInformationController::class, 'store'])->name('details.store');

// Rute untuk Course Classification Information
Route::resource('course-classifications', CourseClassificationInformationController::class);
Route::get('/course-classification', [CourseClassificationInformationController::class, 'index'])->name('course-classification.index');
Route::post('/classifications', [CourseClassificationInformationController::class, 'store'])->name('classifications.store');

// Rute untuk Course Information
Route::resource('course-information', CourseInformationController::class);

// Rute untuk Course Material Information
Route::resource('course-material-information', CourseMaterialInformationController::class);

// Rute untuk Course Schedule Results Information
Route::resource('course-schedule-results', CourseScheduleResultsInformationController::class);

// Rute untuk Course Todo Item Information
Route::resource('course-todo-item-information', CourseTodoItemInformationController::class);

// Rute untuk Course Todo Items Choice Information
Route::resource('course-todo-items-choice', CourseTodoItemsChoiceInformationController::class);

// Rute untuk Employee Affiliation Information
Route::resource('employee-affiliation-information', EmployeeAffiliationInformationController::class);

// Rute untuk Employee Attribute Dropdown Settings Information
Route::resource('employee-attribute-dropdown-settings', EmployeeAttributeDropdownSettingsInformationController::class);

// Rute untuk Employee Attribute Setting Information
Route::resource('employee-attribute-setting-information', EmployeeAttributeSettingInformationController::class);

// Rute untuk Employee Information
Route::resource('employee-information', EmployeeInformationController::class);

// Rute untuk membuat data karyawan baru
Route::get('/employees/create', [EmployeeInformationController::class, 'create'])->name('employees.create');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

?>
