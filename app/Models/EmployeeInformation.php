<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EmployeeInformation extends Authenticatable
{
	use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'employee_information';

    protected $primaryKey = 'employee_id'; // Tambahkan primary key

    public $timestamps = false; // Tidak ada kolom created_at dan updated_at pada tabel

    protected $fillable = [
        'employee_id',
        'company_id',
        'fullname',
        'kananame',
		'email',
        'contact_phonenumber',
        'employee_code',
        'sex',
        'dateofbirth',
        'dateofjoining',
        'retirementdate',
        'remarks',
		'password',
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

	protected $hidden = [
		'password',
	];


	protected $casts = [
		'password' => 'hashed',
	];


	public function employee_affiliation()
	{
		return $this->hasOne(EmployeeAffiliationInformation::class, 'employee_id', 'employee_id');
	}

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

    // Metode untuk mendapatkan data yang akan ditampilkan di sidebar
    public static function getSidebarData()
    {
        // Anda dapat menyesuaikan data yang ingin ditampilkan di sidebar di sini
        return self::select('fullname', 'employee_code')->get();
    }
}
