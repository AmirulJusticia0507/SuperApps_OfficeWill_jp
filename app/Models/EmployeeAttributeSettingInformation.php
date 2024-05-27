<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAttributeSettingInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'easi_id',
        'company_id',
        'employee_attribute01_displayname',
        'employee_attribute01_displayorder',
        'employee_attribute01_screentype',
        'employee_attribute01_screencolumn_count',
        'employee_attribute01_courseselection',
        'employee_attribute02_displayname',
        'employee_attribute02_displayorder',
        'employee_attribute02_screentype',
        'employee_attribute02_screencolumn_count',
        'employee_attribute02_courseselection',
        'employee_attribute03_displayname',
        'employee_attribute03_displayorder',
        'employee_attribute03_screentype',
        'employee_attribute03_screencolumn_count',
        'employee_attribute03_courseselection',
        'employee_attribute04_displayname',
        'employee_attribute04_displayrank',
        'employee_attribute04_screentype',
        'employee_attribute04_screencolumn_count',
        'employee_attribute04_attendance_selection',
        'employee_attribute05_displayname',
        'employee_attribute05_displayrank',
        'employee_attribute05_screentype',
        'employee_attribute05_screencolumn_count',
        'employee_attribute05_courseselection'
    ];

    // Fungsi CRUD

    // Create
    public static function createEmployeeAttributeSetting($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllEmployeeAttributeSettings()
    {
        return self::all();
    }

    public static function getEmployeeAttributeSettingById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateEmployeeAttributeSetting($id, $data)
    {
        $employeeAttributeSetting = self::find($id);
        if ($employeeAttributeSetting) {
            $employeeAttributeSetting->update($data);
            return $employeeAttributeSetting;
        }
        return null;
    }

    // Delete
    public static function deleteEmployeeAttributeSetting($id)
    {
        $employeeAttributeSetting = self::find($id);
        if ($employeeAttributeSetting) {
            $employeeAttributeSetting->delete();
            return true;
        }
        return false;
    }
}
