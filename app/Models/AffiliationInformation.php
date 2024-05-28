<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffiliationInformation extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'affiliation_code';
    public $timestamps = false;
	protected $keyType = 'string';

    protected $fillable = ['affiliation_code', 'company_id', 'affiliation_name', 'display_order', 'organization_type'];

	// Fungsi CRUD

    // Create
    public static function createAffiliation($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllAffiliations()
    {
        return self::all();
    }

    public static function getAffiliationById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateAffiliation($id, $data)
    {
        $affiliation = self::find($id);
        if ($affiliation) {
            $affiliation->update($data);
            return $affiliation;
        }
        return null;
    }

    // Delete
    public static function deleteAffiliation($id)
    {
        $affiliation = self::find($id);
        if ($affiliation) {
            $affiliation->delete();
            return true;
        }
        return false;
    }
}
