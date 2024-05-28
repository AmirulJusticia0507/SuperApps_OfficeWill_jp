<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInformation extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'company_id';
    protected $fillable = ['company_id', 'company_name', 'login_screen_url', 'icon_storage_file_path', 'teaching_material_storage_file_path', 'created_at', 'updated_at'];

    // Fungsi CRUD

    // Create
    public static function createCompany($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCompanies()
    {
        return self::all();
    }

    public static function getCompanyById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCompany($id, $data)
    {
        $company = self::find($id);
        if ($company) {
            $company->update($data);
            return $company;
        }
        return null;
    }

    // Delete
    public static function deleteCompany($id)
    {
        $company = self::find($id);
        if ($company) {
            $company->delete();
            return true;
        }
        return false;
    }
}
