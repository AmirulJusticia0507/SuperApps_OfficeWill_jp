<?php

use App\Models\EmployeeInformation;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
	config([
		'database.default' => 'sqlite',
		'database.connections.sqlite.database' => ':memory:',
	]);

	DB::purge('sqlite');
	Schema::connection('sqlite')->create('employee_information', function (Blueprint $table): void {
		$table->increments('employee_id');
		$table->unsignedInteger('company_id');
		$table->string('fullname')->nullable();
		$table->string('email');
		$table->string('password')->nullable();
		$table->string('account_status')->nullable();
		$table->unsignedInteger('numberofincorrect_passwords')->nullable();
		$table->dateTime('account_lock_datetime')->nullable();
		$table->softDeletes();
	});

	Schema::connection('sqlite')->create('users', function (Blueprint $table): void {
		$table->id();
		$table->string('name');
		$table->string('email');
		$table->timestamp('email_verified_at')->nullable();
		$table->string('password');
		$table->string('remember_token')->nullable();
		$table->timestamps();
		$table->softDeletes();
	});

	foreach (['password_reset_tokens', 'employee_password_reset_tokens'] as $tableName) {
		Schema::connection('sqlite')->create($tableName, function (Blueprint $table): void {
			$table->string('email')->primary();
			$table->string('token');
			$table->timestamp('created_at')->nullable();
		});
	}
});

function createDuplicateEmailAccounts(): array
{
	$email = 'shared@example.test';
	$employee = EmployeeInformation::create([
		'company_id' => 1,
		'fullname' => 'Employee',
		'email' => $email,
		'password' => 'old-employee-password',
		'account_status' => 'enabled',
	]);
	$admin = User::create([
		'name' => 'Admin',
		'email' => $email,
		'password' => 'old-admin-password',
	]);

	return [$employee, $admin];
}

it('sends a reset link through the employee broker when emails exist in both account tables', function () {
	[$employee, $admin] = createDuplicateEmailAccounts();
	Notification::fake();

	$this->post('/forgot-password', ['email' => $employee->email])
		->assertRedirect();

	Notification::assertSentTo($employee, ResetPassword::class);
	Notification::assertNotSentTo($admin, ResetPassword::class);
	expect(DB::table('employee_password_reset_tokens')->where('email', $employee->email)->exists())->toBeTrue();
	expect(DB::table('password_reset_tokens')->where('email', $admin->email)->exists())->toBeFalse();
});

it('resets only the employee password using the employee broker token', function () {
	[$employee, $admin] = createDuplicateEmailAccounts();
	$token = Password::broker('employee')->createToken($employee);

	$this->post('/reset-password', [
		'email' => $employee->email,
		'token' => $token,
		'password' => 'new-employee-password',
		'password_confirmation' => 'new-employee-password',
	])->assertRedirect(route('login'));

	expect(Hash::check('new-employee-password', $employee->fresh()->password))->toBeTrue();
	expect(Hash::check('old-admin-password', $admin->fresh()->password))->toBeTrue();
});
