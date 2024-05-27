<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAttributeDropdownSettingsInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'eadsi_id',
        'company_id',
        'employee_attribute_number',
        'pulldown_list_1',
        'pulldown_list_2',
        'pulldown_list_3',
        'pulldown_list_4',
        'pulldown_list_5',
        'pulldown_list_6',
        'pulldown_list_7',
        'pulldown_list_8',
        'pulldown_list_9',
        'pulldown_list_10'
    ];

    // Fungsi CRUD

    // Create
    public static function createEmployeeAttributeDropdownSetting($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllEmployeeAttributeDropdownSettings()
    {
        return self::all();
    }

    public static function getEmployeeAttributeDropdownSettingById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateEmployeeAttributeDropdownSetting($id, $data)
    {
        $employeeAttributeDropdownSetting = self::find($id);
        if ($employeeAttributeDropdownSetting) {
            $employeeAttributeDropdownSetting->update($data);
            return $employeeAttributeDropdownSetting;
        }
        return null;
    }

    // Delete
    public static function deleteEmployeeAttributeDropdownSetting($id)
    {
        $employeeAttributeDropdownSetting = self::find($id);
        if ($employeeAttributeDropdownSetting) {
            $employeeAttributeDropdownSetting->delete();
            return true;
        }
        return false;
    }
}
