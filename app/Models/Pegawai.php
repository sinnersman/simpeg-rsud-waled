<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;

    protected $table = 'pegawai';

    protected $fillable = [
        'foto_pegawai',
        'nip',
        'nip_lama',
        'nama_lengkap',
        'nama_panggilan',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'golongan_darah',
        'status_perkawinan',
        'pendidikan_terakhir',
        'status_kepegawaian',
        'suku',
        'alamat_lengkap',
        'kode_pos',
        'email',
        'fax',
        'telephone',
        'handphone',
        'rt',
        'rw',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'kebangsaan',
        'berat_badan',
        'tinggi_badan',
        'no_karpeg',
        'no_askes_bpjs',
        'no_taspen',
        'no_karis_karsu',
        'no_npwp',
        'no_korpri',
        'jabatan_id',
        'jenis_jabatan_id',
        'jenjang_id',
        'golongan_id',
        'unit_kerja_id',
        'induk_unit_kerja_id',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
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

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function indukUnitKerja()
    {
        return $this->belongsTo(IndukUnitKerja::class, 'induk_unit_kerja_id');
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class);
    }
}
