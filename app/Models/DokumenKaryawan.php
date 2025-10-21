<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenKaryawan extends Model
{

    protected $table = 'dokumen_karyawan';

    protected $fillable = [
        'pegawai_id',
        'nama_dokumen',
        'file_path',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
