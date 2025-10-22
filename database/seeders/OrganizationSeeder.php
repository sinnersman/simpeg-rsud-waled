<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IndukUnitKerja;
use App\Models\UnitKerja;
use App\Models\Jabatan;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to prevent duplicates on re-run
        Jabatan::query()->delete();
        UnitKerja::query()->delete();
        IndukUnitKerja::query()->delete();

        // 1. Create IndukUnitKerja (Top Level)
        $indukUnit1 = IndukUnitKerja::create([
            'kode' => '1',
            'nama_induk_unit_kerja' => 'Direktorat Utama',
        ]);
        $indukUnit2 = IndukUnitKerja::create([
            'kode' => '2',
            'nama_induk_unit_kerja' => 'Direktorat Pelayanan',
        ]);
        $indukUnit3 = IndukUnitKerja::create([
            'kode' => '3',
            'nama_induk_unit_kerja' => 'Direktorat Keuangan',
        ]);

        // 2. Create UnitKerja with Hierarchy
        // Level 1 UnitKerja under IndukUnitKerja 1
        $unit11 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit1->id,
            'kode' => '11',
            'nama_unit_kerja' => 'Bagian Umum',
            'parent_id' => null, // Top-level UnitKerja
        ]);
        $unit12 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit1->id,
            'kode' => '12',
            'nama_unit_kerja' => 'Bagian Kepegawaian',
            'parent_id' => null,
        ]);

        // Level 2 UnitKerja under UnitKerja 11
        $unit111 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit1->id,
            'kode' => '111',
            'nama_unit_kerja' => 'Sub Bagian Rumah Tangga',
            'parent_id' => $unit11->id,
        ]);
        $unit112 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit1->id,
            'kode' => '112',
            'nama_unit_kerja' => 'Sub Bagian Perlengkapan',
            'parent_id' => $unit11->id,
        ]);

        // Level 2 UnitKerja under UnitKerja 12
        $unit121 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit1->id,
            'kode' => '121',
            'nama_unit_kerja' => 'Sub Bagian Pengembangan SDM',
            'parent_id' => $unit12->id,
        ]);

        // UnitKerja under IndukUnitKerja 2
        $unit21 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit2->id,
            'kode' => '21',
            'nama_unit_kerja' => 'Instalasi Rawat Inap',
            'parent_id' => null,
        ]);
        $unit22 = UnitKerja::create([
            'induk_unit_kerja_id' => $indukUnit2->id,
            'kode' => '22',
            'nama_unit_kerja' => 'Instalasi Rawat Jalan',
            'parent_id' => null,
        ]);

        // 3. Create Jabatan
        Jabatan::create(['kode_jabatan' => 'DIRUT', 'nama_jabatan' => 'Direktur Utama']);
        Jabatan::create(['kode_jabatan' => 'DIRPEL', 'nama_jabatan' => 'Direktur Pelayanan']);
        Jabatan::create(['kode_jabatan' => 'DIRKEU', 'nama_jabatan' => 'Direktur Keuangan']);
        Jabatan::create(['kode_jabatan' => 'KABAGUM', 'nama_jabatan' => 'Kepala Bagian Umum']);
        Jabatan::create(['kode_jabatan' => 'KABAGPEG', 'nama_jabatan' => 'Kepala Bagian Kepegawaian']);
        Jabatan::create(['kode_jabatan' => 'KASUBRUM', 'nama_jabatan' => 'Kepala Sub Bagian Rumah Tangga']);
        Jabatan::create(['kode_jabatan' => 'KASUBPER', 'nama_jabatan' => 'Kepala Sub Bagian Perlengkapan']);
        Jabatan::create(['kode_jabatan' => 'KASUBPSDM', 'nama_jabatan' => 'Kepala Sub Bagian Pengembangan SDM']);
        Jabatan::create(['kode_jabatan' => 'KAIRINAP', 'nama_jabatan' => 'Kepala Instalasi Rawat Inap']);
        Jabatan::create(['kode_jabatan' => 'KAIRJAL', 'nama_jabatan' => 'Kepala Instalasi Rawat Jalan']);
        Jabatan::create(['kode_jabatan' => 'STAF', 'nama_jabatan' => 'Staf']);
    }
}
