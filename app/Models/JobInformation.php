<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobInformation extends Model
{
    use HasFactory, SoftDeletes;

    // Sesuaikan dengan nama tabel di database
    protected $table = 'job_information';

    // Sesuaikan dengan primary key di tabel
	protected $primaryKey = 'job_id';

    // Kolom yang dapat diisi (fillable) saat membuat atau memperbarui model
    protected $fillable = [
        'job_title',
        'display_order',
    ];

    // Jika tidak menggunakan kolom timestamps, atur menjadi false
    public $timestamps = false;
}
