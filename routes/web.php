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
use App\Http\Controllers\ConfirmCoursesController;
use App\Http\Controllers\CourseController;

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

Route::get('/member-registration', [MasterRegistrationController::class, 'show'])->name('member-registration.create');
Route::post('/member-registration', [MasterRegistrationController::class, 'store'])->name('member-registration.store');

// Rute untuk job titles
Route::resource('job-titles', JobTitleController::class);

// Rute untuk Affiliation Information
Route::resource('affiliation-information', AffiliationInformationController::class);
Route::get('/coursesettings', 'AffiliationInformationController@showCourseSettings');
Route::post('/affiliation-information/reset', [AffiliationInformationController::class, 'resetForm'])->name('affiliation-information.reset');
Route::delete('/affiliation-information/{id}', [AffiliationInformationController::class, 'delete'])->name('affiliation-information.delete');


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
Route::resource('classifications', CourseClassificationDetailInformationController::class);


// Rute untuk Course Classification Information
Route::resource('course-classifications', CourseClassificationInformationController::class);
Route::get('/course-classification', [CourseClassificationInformationController::class, 'index'])->name('course-classification.index');
Route::post('/classifications', [CourseClassificationInformationController::class, 'store'])->name('classifications.store');

// Rute untuk Course Information
Route::resource('course-information', CourseInformationController::class);
// Rute untuk menampilkan halaman Course Registration
// Rute untuk menampilkan halaman Course Information (atau Course Registration)
Route::get('/course-registration', [CourseInformationController::class, 'index'])->name('course-registration.index');


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
Route::resource('employee-attribute-dropdown-settings', EmployeeAttributeDropdownSettingsInformationController::class)->parameters([
    'employee-attribute-dropdown-settings' => 'attribute-dropdown-setting',
]);


// Rute untuk Employee Attribute Setting Information
Route::resource('employee-attribute-setting-information', EmployeeAttributeSettingInformationController::class)->parameters([
    'employee-attribute-setting-information' => 'attribute-setting',
]);


// Rute untuk Employee Information
Route::resource('employee-information', EmployeeInformationController::class);
Route::get('/employees/search', [EmployeeInformationController::class, 'search'])->name('employees.search'); 
// Rute untuk membuat data karyawan baru
Route::get('/employees/create', [EmployeeInformationController::class, 'create'])->name('employees.create');

// Rute untuk menampilkan halaman index employee (employee.index)
Route::get('/employee-index', [EmployeeInformationController::class, 'index'])->name('employee.index');

// Rute untuk menampilkan halaman employeelist
Route::get('/employeelist', [EmployeeInformationController::class, 'employeelist'])->name('employee-list');


Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Rute untuk menampilkan halaman konfirmasi dan menghadiri kursus
Route::get('/confirm-courses', [ConfirmCoursesController::class, 'index'])->name('confirm-courses.index');
// Rute untuk menampilkan halaman Course List
Route::get('/course-list', function () {
    // Ambil data yang diperlukan dari model dan kirim ke view
    $classifications = App\Models\CourseClassificationInformation::all();
    $details = App\Models\CourseClassificationDetailInformation::all();
    return view('courselist', compact('classifications', 'details'));
})->name('course-list');

// Define the route for course filter
Route::get('/course/filter', [CourseController::class, 'filter'])->name('course.filter');
Route::get('/course-settings', [CourseController::class, 'settings'])->name('course-settings');
Route::get('/search-courses', [CourseController::class, 'search'])->name('search.courses'); // <-- Perbaikan nama rute
Route::get('/course-inquiry', [CourseController::class, 'inquiry'])->name('course-inquiry');

