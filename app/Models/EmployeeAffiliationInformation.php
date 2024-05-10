<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAffiliationInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'eai_id',
        'company_id',
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
