<?php

use App\Models\CourseInformation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;

beforeEach(function () {
	config([
		'database.default' => 'sqlite',
		'database.connections.sqlite.database' => ':memory:',
	]);

	DB::purge('sqlite');
	Schema::connection('sqlite')->create('course_information', function (Blueprint $table): void {
		$table->increments('course_id');
		$table->unsignedInteger('company_id');
		$table->softDeletes();
		$table->timestamps();
	});

	DB::table('course_information')->insert([
		['company_id' => 1],
		['company_id' => 2],
	]);

	request()->attributes->set('tenant.company_id', 1);
});

it('only reads course records belonging to the current company', function () {
	expect(CourseInformation::query()->pluck('company_id')->all())->toBe([1]);
	expect(CourseInformation::find(2))->toBeNull();
});

it('assigns the current company when creating a record', function () {
	$course = CourseInformation::create(['coursename' => 'Tenant course']);

	expect($course->company_id)->toBe(1);
});

it('rejects attempts to create a record for another company', function () {
	expect(fn () => CourseInformation::create([
		'company_id' => 2,
		'coursename' => 'Foreign course',
	]))->toThrow(HttpException::class);
});

it('rejects attempts to move an owned record to another company', function () {
	$course = CourseInformation::findOrFail(1);
	$course->company_id = 2;

	expect(fn () => $course->save())->toThrow(HttpException::class);
});
