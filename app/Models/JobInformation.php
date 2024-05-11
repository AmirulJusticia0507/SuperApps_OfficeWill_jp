<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobInformation extends Model
{
    // Sesuaikan dengan nama tabel di database
    protected $table = 'job_information';

    // Sesuaikan dengan primary key di tabel
    protected $primaryKey = 'Job_id';

    // Kolom yang dapat diisi (fillable) saat membuat atau memperbarui model
    protected $fillable = [
        'job_title',
        'display_order',
    ];

    // Jika tidak menggunakan kolom timestamps, atur menjadi false
    public $timestamps = false;
}
