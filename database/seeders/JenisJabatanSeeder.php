<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisJabatan;

class JenisJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisJabatans = [
            ['kode' => 'JJ1', 'nama' => 'MEDIS'],
            ['kode' => 'JJ2', 'nama' => 'PARAMEDIS'],
            ['kode' => 'JJ3', 'nama' => 'PELAKSANA'],
            ['kode' => 'JJ4', 'nama' => 'PENUNJANG MEDIS'],
            ['kode' => 'JJ5', 'nama' => 'STRUKTURAL'],
            ['kode' => 'JJ6', 'nama' => 'SUB KOORDINATOR'],
        ];

        foreach ($jenisJabatans as $jenisJabatan) {
            JenisJabatan::firstOrCreate(['kode' => $jenisJabatan['kode']], $jenisJabatan);
        }
    }
}