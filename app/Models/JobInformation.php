<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobInformation extends Model
{
    // Sesuaikan dengan nama tabel di database
    protected $table = 'jobinformation';

    // Sesuaikan dengan primary key di tabel
    protected $primaryKey = 'JobID';

    // Kolom yang dapat diisi (fillable) saat membuat atau memperbarui model
    protected $fillable = [
        'JobTitle',
        'DisplayOrder',
    ];

    // Jika tidak menggunakan kolom timestamps, atur menjadi false
    public $timestamps = false;
}
