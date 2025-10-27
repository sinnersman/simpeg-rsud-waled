<?php

namespace App\Imports;

use App\Models\Golongan;
use App\Models\IndukUnitKerja;
use App\Models\Jabatan;
use App\Models\JenisJabatan;
use App\Models\Jenjang;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class PegawaiImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row['nip']) || $row['nip'] == null) {
            return null;
        }
        $jabatan = null;
        if (isset($row['jabatan'])) {
            $jabatan_code = explode(' - ', $row['jabatan'])[0];
            $jabatan = Jabatan::where('kode_jabatan', $jabatan_code)->first();
        }

        $jenisJabatan = null;
        if (isset($row['jenis_jabatan'])) {
            $jenis_jabatan_code = explode(' - ', $row['jenis_jabatan'])[0];
            $jenisJabatan = JenisJabatan::where('id', $jenis_jabatan_code)->first();
        }

        $jenjang = null;
        if (isset($row['jenjang'])) {
            $jenjang_code = explode(' - ', $row['jenjang'])[0];
            $jenjang = Jenjang::where('id', $jenjang_code)->first();
        }

        $golongan = null;
        if (isset($row['golongan'])) {
            $golongan_code = explode(' - ', $row['golongan'])[0];
            $golongan = Golongan::where('id', $golongan_code)->first();
        }

        $unitKerja = null;
        if (isset($row['unit_kerja'])) {
            $unit_kerja_code = explode(' - ', $row['unit_kerja'])[0];
            $unitKerja = UnitKerja::where('id', $unit_kerja_code)->first();
        }

        $indukUnitKerja = null;
        if (isset($row['induk_unit_kerja'])) {
            $induk_unit_kerja_code = explode(' - ', $row['induk_unit_kerja'])[0];
            $indukUnitKerja = IndukUnitKerja::where('id', $induk_unit_kerja_code)->first();
        }

        $jenis_kelamin = $row['jenis_kelamin'];
        if ($jenis_kelamin == 'L') {
            $jenis_kelamin = 'Laki-laki';
        } elseif ($jenis_kelamin == 'P') {
            $jenis_kelamin = 'Perempuan';
        }

        return new Pegawai([
            'nip' => $row['nip'],
            'nip_lama' => $row['nip_lama'],
            'nama_lengkap' => $row['nama_lengkap'],
            'nama_panggilan' => $row['nama_panggilan'],
            'gelar_depan' => $row['gelar_depan'],
            'gelar_belakang' => $row['gelar_belakang'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => is_numeric($row['tanggal_lahir']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d') : $row['tanggal_lahir'],
            'jenis_kelamin' => $jenis_kelamin,
            'agama' => $row['agama'],
            'golongan_darah' => $row['golongan_darah'],
            'status_perkawinan' => $row['status_perkawinan'],
            'pendidikan_terakhir' => $row['pendidikan_terakhir'],
            'status_kepegawaian' => $row['status_kepegawaian'],
            'suku' => $row['suku'],
            'alamat_lengkap' => $row['alamat_lengkap'],
            'kode_pos' => $row['kode_pos'],
            'email' => $row['email'],
            'fax' => $row['fax'],
            'telephone' => $row['telephone'],
            'handphone' => $row['handphone'],
            'rt' => $row['rt'],
            'rw' => $row['rw'],
            'provinsi' => $row['provinsi'],
            'kabupaten' => $row['kabupaten'],
            'kecamatan' => $row['kecamatan'],
            'kelurahan' => $row['kelurahan'],
            'kebangsaan' => $row['kebangsaan'],
            'berat_badan' => $row['berat_badan'],
            'tinggi_badan' => $row['tinggi_badan'],
            'no_karpeg' => $row['no_karpeg'],
            'no_askes_bpjs' => $row['no_askes_bpjs'],
            'no_taspen' => $row['no_taspen'],
            'no_karis_karsu' => $row['no_karis_karsu'],
            'no_npwp' => $row['no_npwp'],
            'no_korpri' => $row['no_korpri'],
            'jabatan_id' => $jabatan ? $jabatan->id : null,
            'jenis_jabatan_id' => $jenisJabatan ? $jenisJabatan->id : null,
            'jenjang_id' => $jenjang ? $jenjang->id : null,
            'golongan_id' => $golongan ? $golongan->id : null,
            'unit_kerja_id' => $unitKerja ? $unitKerja->id : null,
            'induk_unit_kerja_id' => $indukUnitKerja ? $indukUnitKerja->id : null,
        ]);
    }
}
