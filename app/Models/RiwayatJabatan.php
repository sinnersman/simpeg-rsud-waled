<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_jabatan';

    protected $fillable = [
        'pegawai_id',
        'jabatan_id',
        'unit_kerja_id',
        'induk_unit_kerja_id',
        'jenis_jabatan_id', // Changed from 'jenis_jabatan'
        'jenjang_id',
        'golongan_id',
        'tanggal_masuk',
        'tanggal_keluar', // Added
        'tmt',
        'jenis_pns',
        'no_sk',
        'tanggal_sk',
        'pejabat_penetap',
        'status_sumpah',
        'no_pelantikan',
        'tanggal_pelantikan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date', // Added
        'tmt' => 'date',
        'tanggal_sk' => 'date',
        'tanggal_pelantikan' => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function indukUnitKerja()
    {
        return $this->belongsTo(IndukUnitKerja::class);
    }

    public function jenisJabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
