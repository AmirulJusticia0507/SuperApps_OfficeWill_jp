<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAffiliationInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'eai_id';
    protected $fillable = [
        'eai_id',
        'company_id',
		'employee_id',
        'affiliation_code',
        'job_id',
        'application_startdate',
        'enddate_of_application',
        'system_administrator_privileges',
        'employee_registration_authority',
        'course_enrollment_privileges',
        'attendance_setting_authority',
        'authority_validity_scope',
        'authority_validity_code'
    ];

	protected $casts = ['affiliation_code' => 'string'];


	protected function getAffiliationCodeAttribute($value)
	{
		return str_pad($value, 3, '0', STR_PAD_LEFT);
	}

	public function affiliation()
	{
		return $this->hasOne(AffiliationInformation::class, 'affiliation_code', 'affiliation_code');
	}

	public function job()
	{
		return $this->hasOne(JobInformation::class, 'job_id', 'job_id');
	}
	// Fungsi CRUD

    // Create
    public static function createEmployeeAffiliation($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllEmployeeAffiliations()
    {
        return self::all();
    }

    public static function getEmployeeAffiliationById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateEmployeeAffiliation($id, $data)
    {
        $employeeAffiliation = self::find($id);
        if ($employeeAffiliation) {
            $employeeAffiliation->update($data);
            return $employeeAffiliation;
        }
        return null;
    }

    // Delete
    public static function deleteEmployeeAffiliation($id)
    {
        $employeeAffiliation = self::find($id);
        if ($employeeAffiliation) {
            $employeeAffiliation->delete();
            return true;
        }
        return false;
    }
}
