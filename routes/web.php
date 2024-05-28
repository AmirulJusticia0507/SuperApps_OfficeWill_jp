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
use App\Http\Controllers\QuestionnaireController;

// Rute untuk menampilkan halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login/{company_id}', [LoginController::class, 'showLoginForm'])->name('login.employee');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Rute untuk menampilkan halaman register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Rute untuk menampilkan halaman forgot password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Rute untuk menampilkan halaman reset password
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Route::group(['middleware' => 'auth:employee'], function () {

	// Rute untuk menampilkan halaman dashboard
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Rute untuk member registration
	Route::resource('member-registration', MasterRegistrationController::class);

	// Rute untuk job titles
	Route::resource('job-titles', JobTitleController::class);

	// Rute untuk affiliation information
	Route::resource('affiliation-information', AffiliationInformationController::class);
	Route::get('/coursesettings', [AffiliationInformationController::class, 'showCourseSettings']);
	Route::post('/affiliation-information/reset', [AffiliationInformationController::class, 'resetForm'])->name('affiliation-information.reset');
	Route::delete('/affiliation-information/{id}', [AffiliationInformationController::class, 'destroy'])->name('affiliation-information.destroy');

	// Rute untuk attendance todo answer selection information
	Route::resource('attendance', AttendanceTodoAnswerSelectionInformationController::class);

	// Rute untuk attendance todo item answer information
	Route::resource('attendance-item', AttendanceTodoItemAnswerInformationController::class);

	// Rute untuk company information
	Route::resource('company-information', CompanyInformationController::class);

	// Rute untuk course attribute pulldown settings
	Route::resource('course-attribute-pulldown', CourseAttributePulldownSettingsController::class);

	// Rute untuk course attribute setting information
	Route::resource('course-attribute-setting', CourseAttributeSettingInformationController::class);

	// Rute untuk course classification detail information
	Route::resource('course-classification-details', CourseClassificationDetailInformationController::class);
	Route::post('/course-classification-details', [CourseClassificationDetailInformationController::class, 'store'])->name('details.store');
	Route::resource('classifications', CourseClassificationDetailInformationController::class);
	Route::get('/course-classification-details/{id}/edit', [CourseClassificationDetailInformationController::class, 'edit'])->name('course-classification-details.edit');
	Route::put('/course-classification-details/{id}', [CourseClassificationDetailInformationController::class, 'update'])->name('course-classification-details.update');
	Route::delete('/course-classification-details/{id}', [CourseClassificationDetailInformationController::class, 'destroy'])->name('course-classification-details.destroy');
	Route::get('/details', [CourseClassificationDetailInformationController::class, 'index'])->name('details.index');
	Route::delete('/details/{id}', [CourseClassificationDetailInformationController::class, 'destroy'])->name('details.destroy');

	// Rute untuk course classification information
	Route::resource('course-classifications', CourseClassificationInformationController::class);
	Route::get('/course-classification', [CourseClassificationInformationController::class, 'index'])->name('course-classification.index');
	Route::post('/classifications', [CourseClassificationInformationController::class, 'store'])->name('classifications.store');
	Route::get('/course-classifications/{id}/edit', [CourseClassificationInformationController::class, 'edit'])->name('course-classifications.edit');
	Route::put('/course-classifications/{id}', [CourseClassificationInformationController::class, 'update'])->name('course-classifications.update');
	Route::delete('/course-classifications/{id}', [CourseClassificationInformationController::class, 'destroy'])->name('course-classifications.destroy');
	Route::put('/course-classification-details/{id}', [CourseClassificationDetailInformationController::class, 'update'])->name('details.update');


	// Rute untuk course information
	Route::resource('course-information', CourseInformationController::class);
	Route::get('/course-registration', [CourseInformationController::class, 'index'])->name('course-registration.index');
	Route::get('/course-registration/attribute/{attribute_id}', [CourseInformationController::class, 'attribute'])->name('course-registration.attribute');

	// Rute untuk course material information
	Route::resource('course-material-information', CourseMaterialInformationController::class);

	// Rute untuk course schedule results information
	Route::resource('course-schedule-results', CourseScheduleResultsInformationController::class);

	// Rute untuk course todo item information
	Route::resource('course-todo-item-information', CourseTodoItemInformationController::class);

	// Rute untuk course todo items choice information
	Route::resource('course-todo-items-choice', CourseTodoItemsChoiceInformationController::class);

	// Rute untuk employee affiliation information
	Route::resource('employee-affiliation-information', EmployeeAffiliationInformationController::class);

	// Rute untuk employee attribute dropdown settings information
	Route::resource('employee-attribute-dropdown-settings', EmployeeAttributeDropdownSettingsInformationController::class)->parameters([
		'employee-attribute-dropdown-settings' => 'attribute-dropdown-setting',
	]);

	// Rute untuk employee attribute setting information
	Route::resource('employee-attribute-setting-information', EmployeeAttributeSettingInformationController::class)->parameters([
		'employee-attribute-setting-information' => 'attribute-setting',
	]);

	// Rute untuk employee information
	Route::resource('employee-information', EmployeeInformationController::class);
	Route::get('/employees/search', [EmployeeInformationController::class, 'search'])->name('employees.search');
	Route::get('/employees/create', [EmployeeInformationController::class, 'create'])->name('employees.create');
	Route::get('/employee-index', [EmployeeInformationController::class, 'index'])->name('employee.index');
	Route::get('/employeelist', [EmployeeInformationController::class, 'employeelist'])->name('employee-list');
	Route::get('/employee/filter', [EmployeeInformationController::class, 'filter'])->name('employee.filter');
	Route::get('/employee-inquiry', [EmployeeInformationController::class, 'employeeInquiry'])->name('employee-inquiry');
	Route::get('/employees/filter', [EmployeeInformationController::class, 'filter'])->name('employees.filter');

	// Rute untuk konfirmasi kursus
	Route::get('/confirm-courses', [ConfirmCoursesController::class, 'index'])->name('confirm-courses.index');
	Route::get('/confirm-courses/{course_id}/attendence', [ConfirmCoursesController::class, 'attendence'])->name('confirm-courses.attendence');
	Route::get('/confirm-courses/{course_id}/todo-answer', [ConfirmCoursesController::class, 'todoAnswerForm'])->name('confirm-courses.todo-answer.index');
	Route::post('/confirm-courses/{course_id}/todo-answer', [ConfirmCoursesController::class, 'todoAnswerStore'])->name('confirm-courses.todo-answer.store');
	Route::get('/confirm-courses/{course_id}/todo-scoring', [ConfirmCoursesController::class, 'todoAnswerScoring'])->name('confirm-courses.todo-answer.scoring');

	// Rute untuk course list
	Route::get('/course-list', [CourseController::class, 'index'])->name('course-list');
	Route::get('/course/filter', [CourseController::class, 'filter'])->name('course.filter');
	Route::get('/course-settings', [CourseController::class, 'settings'])->name('course-settings');
	Route::post('/course-settings', [CourseController::class, 'store'])->name('course-settings.store');
	Route::get('/search-courses', [CourseController::class, 'search'])->name('search.courses');
	Route::get('/course-inquiry', [CourseController::class, 'inquiry'])->name('course-inquiry');
	Route::get('/course-inquiry-search', [CourseController::class, 'search'])->name('course-inquiry-search');
	Route::get('/job/{id}', [CourseController::class, 'show'])->name('job.show');
	Route::get('/employee/filter', [CourseController::class, 'filter'])->name('employee.filter');


	// Rute for questionnaire
	Route::post('/questionnaire/store', [QuestionnaireController::class, 'store'])->name('questionnaire.store');

	// Rute untuk menampilkan daftar semua materials
	Route::get('/materials', [CourseMaterialInformationController::class, 'index'])->name('materials.index');

	// Rute untuk menampilkan form untuk membuat course material baru
	Route::get('/materials/create', [CourseMaterialInformationController::class, 'create'])->name('materials.create');

	// Rute untuk menyimpan course material baru yang dibuat
	Route::post('/materials', [CourseMaterialInformationController::class, 'store'])->name('materials.store');

	// Rute untuk menampilkan form untuk mengedit course material
	Route::get('/materials/{id}/edit', [CourseMaterialInformationController::class, 'edit'])->name('materials.edit');

	// Rute untuk menyimpan perubahan pada course material yang sudah diedit
	Route::put('/materials/{id}', [CourseMaterialInformationController::class, 'update'])->name('materials.update');

	// Rute untuk menghapus course material
	Route::delete('/materials/{id}', [CourseMaterialInformationController::class, 'destroy'])->name('materials.destroy');

	// Rute untuk menampilkan detail course material
	Route::get('/materials/{id}', [CourseMaterialInformationController::class, 'show'])->name('materials.show');


// });