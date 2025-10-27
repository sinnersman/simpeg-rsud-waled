<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('golongans')->insert([
            ['kode' => 'G1', 'golongan' => 'I/a', 'pangkat' => 'Juru Muda'],
            ['kode' => 'G2', 'golongan' => 'I/b', 'pangkat' => 'Juru Muda Tingkat I'],
            ['kode' => 'G3', 'golongan' => 'I/c', 'pangkat' => 'Juru'],
            ['kode' => 'G4', 'golongan' => 'I/d', 'pangkat' => 'Juru Tingkat I'],
            ['kode' => 'G5', 'golongan' => 'II/a', 'pangkat' => 'Pengatur Muda'],
            ['kode' => 'G6', 'golongan' => 'II/b', 'pangkat' => 'Pengatur Muda Tingkat I'],
            ['kode' => 'G7', 'golongan' => 'II/c', 'pangkat' => 'Pengatur'],
            ['kode' => 'G8', 'golongan' => 'II/d', 'pangkat' => 'Pengatur Tingkat I'],
            ['kode' => 'G9', 'golongan' => 'III/a', 'pangkat' => 'Penata Muda'],
            ['kode' => 'G10', 'golongan' => 'III/b', 'pangkat' => 'Penata Muda Tingkat I'],
            ['kode' => 'G11', 'golongan' => 'III/c', 'pangkat' => 'Penata'],
            ['kode' => 'G12', 'golongan' => 'III/d', 'pangkat' => 'Penata Tingkat I'],
            ['kode' => 'G13', 'golongan' => 'IV/a', 'pangkat' => 'Pembina'],
            ['kode' => 'G14', 'golongan' => 'IV/b', 'pangkat' => 'Pembina Tingkat I'],
            ['kode' => 'G15', 'golongan' => 'IV/c', 'pangkat' => 'Pembina Utama Muda'],
            ['kode' => 'G16', 'golongan' => 'IV/d', 'pangkat' => 'Pembina Utama Madya'],
            ['kode' => 'G17', 'golongan' => 'IV/e', 'pangkat' => 'Pembina Utama'],
            ['kode' => 'G18', 'golongan' => 'I', 'pangkat' => 'Juru Muda'],
            ['kode' => 'G19', 'golongan' => 'V', 'pangkat' => 'Pengatur Muda'],
            ['kode' => 'G20', 'golongan' => 'VII', 'pangkat' => 'Pengatur'],
            ['kode' => 'G21', 'golongan' => 'IX', 'pangkat' => 'Penata Muda'],
            ['kode' => 'G22', 'golongan' => 'X', 'pangkat' => 'Penata Muda Tingkat I'],
            ['kode' => 'G23', 'golongan' => 'XI', 'pangkat' => 'Penata'],
        ]);
    }
}
