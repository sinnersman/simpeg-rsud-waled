<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
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
    ];
}
