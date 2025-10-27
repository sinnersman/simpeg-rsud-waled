<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jenjang;

class JenjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenjangs = [
            ['kode' => 'J1', 'nama' => 'Ahli Utama'],
            ['kode' => 'J2', 'nama' => 'Ahli Madya'],
            ['kode' => 'J3', 'nama' => 'Ahli Muda'],
            ['kode' => 'J4', 'nama' => 'Ahli Pertama'],
            ['kode' => 'J5', 'nama' => 'Penyelia'],
            ['kode' => 'J6', 'nama' => 'Mahir'],
            ['kode' => 'J7', 'nama' => 'Terampil'],
        ];

        foreach ($jenjangs as $jenjang) {
            Jenjang::firstOrCreate(['kode' => $jenjang['kode']], $jenjang);
        }
    }
}