<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabahs';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'job_id',
        'desa_id', // Foreign key for dropdown
        'alamat',
        'nominal_setor',
        'approve',
    ];

    // Define relationship with Desa model
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function job()
    {
        return $this->belongsTo(job::class);
    }
}
