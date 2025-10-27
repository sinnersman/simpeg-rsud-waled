<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\IndukUnitKerja;
use App\Models\UnitKerja;

class OrganizationHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the unit_kerja table for a clean slate
        DB::table('unit_kerja')->truncate();

        // Get all IndukUnitKerja records
        $indukUnitKerjas = IndukUnitKerja::all();
        $indukUnitKerjaMap = $indukUnitKerjas->pluck('id', 'nama_induk_unit_kerja')->toArray();

        // Define the raw unit kerja names from user input
        $unitKerjaNames = [
            'DIREKTUR',
            'WAKIL DIREKTUR UMUM DAN KEUANGAN',
            'KEPALA BIDANG PELAYANAN MEDIS DAN PENGENDALIAN MUTU',
            'KEPALA BIDANG PELAYANAN KEPERAWATAN DAN PENGENDALIAN MUTU',
            'KEPALA BIDANG PELAYANAN PENUNJANG DAN PENDIDIKAN',
            'KEPALA BAGIAN PERENCANAAN, HUKUM DAN PENGEMBANGAN',
            'KEPALA BAGIAN UMUM DAN KEPEGAWAIAN',
            'KEPALA BAGIAN KEUANGAN',
            'KEPALA SUBBAGIAN PERLENGKAPAN DAN RUMAH TANGGA',
            'KEPALA SUBBAGIAN TATA USAHA DAN KEPEGAWAIAN',
            'BAGIAN KEUANGAN',
            'BIDANG PELAYANAN MEDIS DAN PENGENDALIAN MUTU',
            'BAGIAN PERENCANAAN, HUKUM DAN PENGEMBANGAN',
            'BIDANG PELAYANAN KEPERAWATAN DAN PENGENDALIAN MUTU',
            'BIDANG PELAYANAN PENUNJANG DAN PENDIDIKAN',
            'DOKTER SPESIALIS',
            'DOKTER UMUM',
            'DELIMA',
            'IPSRS',
            'POLI KLINIK',
            'PPI',
            'INSTALASI BEDAH SENTRAL',
            'MAWAR',
            'CSSD',
            'MOD',
            'KOMITE KEPERAWATAN',
            'NICU',
            'FARMASI',
            'RADIOLOGI',
            'ANGGREK',
            'ICU',
            'IGD UMUM',
            'SERUNI',
            'SEROJA',
            'HEMODIALISA',
            'GIZI',
            'LABORATORIUM',
            'ENDOSCOPY',
            'ADMIN POLI KLINIK',
            'KAMAR JENAZAH',
            'SUB BAGIAN TATA USAHA DAN KEPEGAWAIAN',
            'REHABILITASI MEDIK',
            'MCU',
            'PEREKAM MEDIS',
            'TERATAI',
            'BOUGENVILE',
            'KEMUNING',
            'PERINATOLOGI',
            'NUSA INDAH',
            'ANYELIR',
            'KLAIM DAN CASEMIX',
            'PKRS',
            'DAHLIA',
            'SOKA',
            'KEMOTERAPI/THALASEMI',
            'HUMAS',
            'KOMITE K3',
            'BANK DARAH',
            'LOKET',
            'ADMIN POLI JIWA',
            'ADMIN POLI MATA',
            'ADMIN MCU',
            'AMBULANCE',
            'ADMIN BOUGENVILE',
            'ADMIN ICU',
            'ADMIN POLI BEDAH',
            'ADMIN NICU',
            'LAUNDRY',
            'SEKSI KPMPK',
            'SATPAM',
            'ADMIN LABORATORIUM',
            'ADMIN POLI JANTUNG',
            'ADMIN PERINATOLOGI',
            'ADMIN DAHLIA 2',
            'ADMIN POLI DALAM',
            'ADMIN SYARAF',
            'ADMIN NUSA INDAH',
            'ADMIN IGD IBU DAN ANAK',
            'PORTIR',
            'ADMIN DAHLIA',
            'ADMIN MAWAR',
            'DRIVER',
            'ADMIN KEMUNING',
            'ADMIN POLI ORTHOPAEDI',
            'SIRS SYSTEM',
            'LABORATORIUM PA',
            'AKREDITASI',
            'PELAYANAN MEDIS',
            'ADMIN INSTALASI BEDAH SENTRAL',
            'ADMIN SERUNI',
            'ADMIN KAMAR JENAZAH',
            'ADMIN SOKA',
            'ADMIN ANYELIR',
            'ADMIN DELIMA',
            'ADMIN BEDAH BTKV',
            'ADMIN POLI OBGYN',
            'ADMIN IGD UMUM',
            'ADMIN ANGGREK',
            'ADMIN LABORATORIUM PA',
            'ADMIN HD',
            'ADMIN POLI YASMIN',
            'PROMKES',
            'ADMIN RADIOLOGI',
            'ADMIN PARU',
        ];

        $createdUnitKerjas = []; // To store created UnitKerja models for parent_id lookup

        // First pass: Create top-level units and explicitly defined hierarchy
        foreach ($unitKerjaNames as $key => $namaUnitKerja) {
            $indukUnitKerjaId = null;
            $parentId = null;

            // Explicitly assign IndukUnitKerja based on exact match
            if (isset($indukUnitKerjaMap[$namaUnitKerja])) {
                $indukUnitKerjaId = $indukUnitKerjaMap[$namaUnitKerja];
            }

            // Handle specific hierarchical assignments based on user feedback
            if ($namaUnitKerja === 'DIREKTUR') {
                // DIREKTUR is top-level, no parent
                $indukUnitKerjaId = $indukUnitKerjaMap['DIREKTUR'] ?? null;
            } elseif ($namaUnitKerja === 'WAKIL DIREKTUR UMUM DAN KEUANGAN') {
                // WADIR reports to DIREKTUR
                $direktur = UnitKerja::where('nama_unit_kerja', 'DIREKTUR')->first();
                $parentId = $direktur->id ?? null;
                $indukUnitKerjaId = $indukUnitKerjaMap['WAKIL DIREKTUR UMUM DAN KEUANGAN'] ?? null;
            } elseif ($namaUnitKerja === 'KEPALA BAGIAN UMUM DAN KEPEGAWAIAN') {
                // KEPALA BAGIAN UMUM reports to WAKIL DIREKTUR UMUM DAN KEUANGAN
                $wadir = UnitKerja::where('nama_unit_kerja', 'WAKIL DIREKTUR UMUM DAN KEUANGAN')->first();
                $parentId = $wadir->id ?? null;
                $indukUnitKerjaId = $indukUnitKerjaMap['BAGIAN UMUM DAN KEPEGAWAIAN'] ?? null;
            } elseif ($namaUnitKerja === 'KEPALA SUBBAGIAN TATA USAHA DAN KEPEGAWAIAN') {
                // KEPALA SUBBAGIAN TATA USAHA reports to KEPALA BAGIAN UMUM DAN KEPEGAWAIAN
                $bagianUmum = UnitKerja::where('nama_unit_kerja', 'KEPALA BAGIAN UMUM DAN KEPEGAWAIAN')->first();
                $parentId = $bagianUmum->id ?? null;
                $indukUnitKerjaId = $indukUnitKerjaMap['SUBBAGIAN TATA USAHA DAN KEPEGAWAIAN'] ?? null;
            } elseif ($namaUnitKerja === 'KEPALA SUBBAGIAN PERLENGKAPAN DAN RUMAH TANGGA') {
                // KEPALA SUBBAGIAN PERLENGKAPAN reports to KEPALA BAGIAN UMUM DAN KEPEGAWAIAN
                $bagianUmum = UnitKerja::where('nama_unit_kerja', 'KEPALA BAGIAN UMUM DAN KEPEGAWAIAN')->first();
                $parentId = $bagianUmum->id ?? null;
                $indukUnitKerjaId = $indukUnitKerjaMap['SUBBAGIAN PERLENGKAPAN DAN RUMAH TANGGA'] ?? null;
            }

            // For other units, try to find a parent based on keywords or existing created units
            if (is_null($parentId) && is_null($indukUnitKerjaId)) {
                // Try to find a parent from already created UnitKerja based on name inclusion
                foreach ($createdUnitKerjas as $existingUnit) {
                    if (str_contains($namaUnitKerja, $existingUnit->nama_unit_kerja) && $namaUnitKerja !== $existingUnit->nama_unit_kerja) {
                        $parentId = $existingUnit->id;
                        break;
                    }
                }
            }

            // If still no IndukUnitKerjaId, assign to a default (e.g., DIREKTUR's IndukUnitKerja)
            if (is_null($indukUnitKerjaId)) {
                $indukUnitKerjaId = $indukUnitKerjaMap['DIREKTUR'] ?? ($indukUnitKerjas->first()->id ?? null);
            }

            $unitKerja = UnitKerja::create([
                'nama_unit_kerja' => $namaUnitKerja,
                'kode' => 'UK' . str_pad($key + 1, 3, '0', STR_PAD_LEFT),
                'induk_unit_kerja_id' => $indukUnitKerjaId,
                'parent_id' => $parentId,
            ]);
            $createdUnitKerjas[] = $unitKerja;
        }
    }
}
