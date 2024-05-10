<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'company_id',
        'fullname',
        'kananame',
        'email_address',
        'contact_phonenumber',
        'employee_code',
        'sex',
        'dateofbirth',
        'dateofjoining',
        'retirementdate',
        'remarks',
        'encrypted_password',
        'account_status',
        'password_expiration',
        'numberofincorrect_passwords',
        'account_lock_datetime',
        'employee_attribute01',
        'employee_attribute02',
        'employee_attribute03',
        'employee_attribute04',
        'employee_attribute05'
    ];

    // Fungsi CRUD

    // Create
    public static function createEmployee($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllEmployees()
    {
        return self::all();
    }

    public static function getEmployeeById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateEmployee($id, $data)
    {
        $employee = self::find($id);
        if ($employee) {
            $employee->update($data);
            return $employee;
        }
        return null;
    }

    // Delete
    public static function deleteEmployee($id)
    {
        $employee = self::find($id);
        if ($employee) {
            $employee->delete();
            return true;
        }
        return false;
    }
}
