<?php

use App\Models\EmployeeInformation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
		$table->string('email')->unique();
		$table->string('password')->nullable();
		$table->string('account_status')->nullable();
		$table->unsignedInteger('numberofincorrect_passwords')->nullable();
		$table->dateTime('account_lock_datetime')->nullable();
		$table->softDeletes();
	});

	Schema::connection('sqlite')->create('users', function (Blueprint $table): void {
		$table->id();
		$table->string('name');
		$table->string('email')->unique();
		$table->timestamp('email_verified_at')->nullable();
		$table->string('password');
		$table->string('remember_token')->nullable();
		$table->timestamps();
		$table->softDeletes();
	});
});

function createLoginEmployee(array $attributes = []): EmployeeInformation
{
	return EmployeeInformation::create(array_merge([
		'company_id' => 1,
		'fullname' => 'Test Employee',
		'email' => 'employee@example.test',
		'password' => Hash::make('correct-password'),
		'account_status' => 'enabled',
		'numberofincorrect_passwords' => 0,
	], $attributes));
}

it('rejects disabled employees before authenticating them', function () {
	createLoginEmployee(['account_status' => 'disabled']);

	$this->post('/login', [
		'email' => 'employee@example.test',
		'password' => 'correct-password',
	])->assertRedirect(route('login'));

	$this->assertGuest('employee');
});

it('rejects employees while their lock date is in the future', function () {
	createLoginEmployee(['account_lock_datetime' => now()->addMinutes(10)]);

	$this->post('/login', [
		'email' => 'employee@example.test',
		'password' => 'correct-password',
	])->assertRedirect(route('login'));

	$this->assertGuest('employee');
});

it('locks an employee after five incorrect passwords', function () {
	$employee = createLoginEmployee();

	for ($attempt = 0; $attempt < 5; $attempt++) {
		$this->post('/login', [
			'email' => 'employee@example.test',
			'password' => 'wrong-password',
		])->assertRedirect(route('login'));
	}

	expect($employee->fresh()->numberofincorrect_passwords)->toBe(5);
	expect($employee->fresh()->account_lock_datetime)->not->toBeNull();
});
