<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['kode_jabatan', 'nama_jabatan', 'jenis_jabatan_id', 'jenjang_id'];

    public function jenisJabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
}
