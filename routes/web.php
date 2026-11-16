<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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

Route::redirect('/', '/login');
Route::get('/manifest.webmanifest', function () {
    return response()->file(public_path('manifest.webmanifest'), [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'public, max-age=3600',
    ]);
})->name('pwa.manifest');
Route::get('/service-worker.js', function () {
    return response()->file(public_path('service-worker.js'), [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache',
        'Service-Worker-Allowed' => '/',
    ]);
})->name('pwa.service-worker');
Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['ja', 'en'], true), 404);
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('locale.switch');

// Rute untuk menampilkan halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login/{company_id}', [LoginController::class, 'showLoginForm'])->name('login.employee');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Rute untuk menampilkan halaman forgot password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Rute untuk menampilkan halaman reset password
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth.any')->group(function () {

	// Rute untuk menampilkan halaman dashboard
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Rute untuk member registration
	Route::middleware('authority:employee_registration_authority')->group(function () {
		Route::resource('member-registration', MasterRegistrationController::class);
		Route::resource('employee-information', EmployeeInformationController::class);
		Route::get('/employees/search', [EmployeeInformationController::class, 'search'])->name('employees.search');
		Route::get('/employee-index', [EmployeeInformationController::class, 'index'])->name('employee.index');
		Route::get('/employeelist', [EmployeeInformationController::class, 'employeelist'])->name('employee-list');
		Route::get('/employee/filter', [EmployeeInformationController::class, 'filter'])->name('employee.filter');
		Route::get('/employee-inquiry', [EmployeeInformationController::class, 'employeeInquiry'])->name('employee-inquiry');
		Route::get('/employees/filter', [EmployeeInformationController::class, 'filter'])->name('employees.filter');
		Route::resource('employee-affiliation-information', EmployeeAffiliationInformationController::class);
		Route::resource('employee-attribute-dropdown-settings', EmployeeAttributeDropdownSettingsInformationController::class)->parameters([
			'employee-attribute-dropdown-settings' => 'attribute-dropdown-setting',
		]);
		Route::resource('employee-attribute-setting-information', EmployeeAttributeSettingInformationController::class)->parameters([
			'employee-attribute-setting-information' => 'attribute-setting',
		]);
	});

	// Rute untuk job titles
	Route::middleware('authority:system_administrator_privileges')->group(function () {
		Route::get('/employee-access-settings', [EmployeeInformationController::class, 'accessSettings'])->name('employee-access-settings.index');
		Route::put('/employee-access-settings/{id}', [EmployeeInformationController::class, 'updateAccessSettings'])->name('employee-access-settings.update');
		Route::resource('job-titles', JobTitleController::class);
		Route::resource('affiliation-information', AffiliationInformationController::class)->except(['destroy']);
		Route::post('/affiliation-information/reset', [AffiliationInformationController::class, 'resetForm'])->name('affiliation-information.reset');
		Route::delete('/affiliation-information/{id}', [AffiliationInformationController::class, 'destroy'])->name('affiliation-information.destroy');
		Route::resource('company-information', CompanyInformationController::class);
	});

	Route::middleware('authority:attendance_setting_authority')->group(function () {
		Route::get('/coursesettings', [AffiliationInformationController::class, 'showCourseSettings']);
		Route::resource('attendance', AttendanceTodoAnswerSelectionInformationController::class);
		Route::resource('attendance-item', AttendanceTodoItemAnswerInformationController::class);
		Route::resource('course-schedule-results', CourseScheduleResultsInformationController::class);
		Route::post('/questionnaire/store', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
	});

	// Rute untuk course attribute pulldown settings
	Route::middleware('authority:course_enrollment_privileges')->group(function () {
		Route::resource('course-attribute-pulldown', CourseAttributePulldownSettingsController::class);
		Route::resource('course-attribute-setting', CourseAttributeSettingInformationController::class);
		Route::resource('course-information', CourseInformationController::class);
		Route::resource('course-material-information', CourseMaterialInformationController::class);
		Route::resource('course-todo-item-information', CourseTodoItemInformationController::class);
		Route::resource('course-todo-items-choice', CourseTodoItemsChoiceInformationController::class);
		Route::get('/course-registration', [CourseInformationController::class, 'index'])->name('course-registration.index');
		Route::get('/course-registration/attribute/{attribute_id}', [CourseInformationController::class, 'attribute'])->name('course-registration.attribute');
		Route::get('/course-list', [CourseController::class, 'index'])->name('course-list');
		Route::get('/course/filter', [CourseController::class, 'filter'])->name('course.filter');
		Route::get('/course-inquiry', [CourseController::class, 'inquiry'])->name('course-inquiry');
		Route::get('/course-inquiry-search', [CourseController::class, 'search'])->name('course-inquiry-search');
		Route::get('/job/{id}', [CourseController::class, 'show'])->name('job.show');
		Route::get('/search-courses', [CourseController::class, 'search'])->name('search.courses');
		Route::get('/employee/filter', [CourseController::class, 'filter'])->name('employee.filter');
	});
	Route::middleware('authority:employee_registration_authority,course_enrollment_privileges')->group(function () {
		Route::resource('course-classifications', CourseClassificationInformationController::class)->except(['destroy']);
		Route::get('/course-classification', [CourseClassificationInformationController::class, 'index'])->name('course-classification.index');
		Route::post('/classifications', [CourseClassificationInformationController::class, 'store'])->name('classifications.store');
		Route::delete('/course-classifications/{id}', [CourseClassificationInformationController::class, 'destroy'])->name('course-classifications.destroy');
	});

	// Rute untuk course attribute setting information

	Route::middleware('authority:employee_registration_authority,course_enrollment_privileges')->group(function () {
		Route::resource('course-classification-details', CourseClassificationDetailInformationController::class)->except(['store', 'update', 'destroy']);
		Route::post('/course-classification-details', [CourseClassificationDetailInformationController::class, 'store'])->name('details.store');
		Route::put('/course-classification-details/{id}', [CourseClassificationDetailInformationController::class, 'update'])->name('course-classification-details.update');
		Route::delete('/course-classification-details/{id}', [CourseClassificationDetailInformationController::class, 'destroy'])->name('course-classification-details.destroy');
		Route::get('/details', [CourseClassificationDetailInformationController::class, 'index'])->name('details.index');
		Route::delete('/details/{id}', [CourseClassificationDetailInformationController::class, 'destroy'])->name('details.destroy');
	});

	// Rute untuk course classification information

	// Rute untuk konfirmasi kursus
	Route::get('/confirm-courses', [ConfirmCoursesController::class, 'index'])->name('confirm-courses.index');
	Route::get('/confirm-courses/{course_id}/attendence', [ConfirmCoursesController::class, 'attendence'])->name('confirm-courses.attendence');
	Route::get('/confirm-courses/{course_id}/todo-answer', [ConfirmCoursesController::class, 'todoAnswerForm'])->name('confirm-courses.todo-answer.index');
	Route::post('/confirm-courses/{course_id}/todo-answer', [ConfirmCoursesController::class, 'todoAnswerStore'])->name('confirm-courses.todo-answer.store');
	Route::get('/confirm-courses/{course_id}/todo-scoring', [ConfirmCoursesController::class, 'todoAnswerScoring'])->name('confirm-courses.todo-answer.scoring');

	// Rute untuk course list
	Route::middleware('authority:attendance_setting_authority')->group(function () {
		Route::get('/course-settings', [CourseController::class, 'settings'])->name('course-settings');
		Route::post('/course-settings', [CourseController::class, 'store'])->name('course-settings.store');
	});

	Route::middleware('authority:course_enrollment_privileges')->group(function () {
		Route::get('/materials', [CourseMaterialInformationController::class, 'index'])->name('materials.index');
		Route::get('/materials/create', [CourseMaterialInformationController::class, 'create'])->name('materials.create');
		Route::post('/materials', [CourseMaterialInformationController::class, 'store'])->name('materials.store');
		Route::get('/materials/{id}/edit', [CourseMaterialInformationController::class, 'edit'])->name('materials.edit');
		Route::put('/materials/{id}', [CourseMaterialInformationController::class, 'update'])->name('materials.update');
		Route::delete('/materials/{id}', [CourseMaterialInformationController::class, 'destroy'])->name('materials.destroy');
		Route::get('/materials/{id}', [CourseMaterialInformationController::class, 'show'])->name('materials.show');
	});


});
