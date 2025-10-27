<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IndukUnitKerja;

class IndukUnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indukUnitKerjaData = [
            ['kode' => '095A00000000', 'nama_induk_unit_kerja' => 'DIREKTUR'],
            ['kode' => '095A00100000', 'nama_induk_unit_kerja' => 'WAKIL DIREKTUR UMUM DAN KEUANGAN'],
            ['kode' => '095A00100100', 'nama_induk_unit_kerja' => 'BAGIAN UMUM DAN KEPEGAWAIAN'],
            ['kode' => '095A00100101', 'nama_induk_unit_kerja' => 'SUBBAGIAN TATA USAHA DAN KEPEGAWAIAN'],
            ['kode' => '095A00100102', 'nama_induk_unit_kerja' => 'SUBBAGIAN PERLENGKAPAN DAN RUMAH TANGGA'],
            ['kode' => '095A00100200', 'nama_induk_unit_kerja' => 'BAGIAN PERENCANAAN, HUKUM DAN PENGEMBANGAN'],
            ['kode' => '095A00100300', 'nama_induk_unit_kerja' => 'BAGIAN KEUANGAN'],
            ['kode' => '095A00200000', 'nama_induk_unit_kerja' => 'WAKIL DIREKTUR PELAYANAN DAN PENDIDIKAN'],
            ['kode' => '095A00200100', 'nama_induk_unit_kerja' => 'BIDANG PELAYANAN MEDIS DAN PENGENDALIAN MUTU'],
            ['kode' => '095A00200200', 'nama_induk_unit_kerja' => 'BIDANG PELAYANAN KEPERAWATAN DAN PENGENDALIAN MUTU'],
            ['kode' => '095A00200300', 'nama_induk_unit_kerja' => 'BIDANG PELAYANAN PENUNJANG DAN PENDIDIKAN'],
        ];

        foreach ($indukUnitKerjaData as $data) {
            IndukUnitKerja::firstOrCreate(['kode' => $data['kode']], $data);
        }
    }
}
