<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\IndukUnitKerja;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indukUnitKerjas = IndukUnitKerja::all()->pluck('id', 'nama_induk_unit_kerja')->toArray();

        $unitKerjaData = [
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

        foreach ($unitKerjaData as $key => $nama) {
            $indukUnitKerjaId = null;
            if (isset($indukUnitKerjas[$nama])) {
                $indukUnitKerjaId = $indukUnitKerjas[$nama];
            } else {
                // Find the best match
                $bestMatch = '';
                $bestMatchScore = 0;
                foreach ($indukUnitKerjas as $indukNama => $indukId) {
                    similar_text($nama, $indukNama, $score);
                    if ($score > $bestMatchScore) {
                        $bestMatchScore = $score;
                        $bestMatch = $indukId;
                    }
                }
                if ($bestMatchScore > 70) {
                    $indukUnitKerjaId = $bestMatch;
                } else {
                    $indukUnitKerjaId = 1; // Default to DIREKTUR
                }
            }

            DB::table('unit_kerja')->insert([
                'nama_unit_kerja' => $nama,
                'kode' => 'UK' . str_pad($key + 1, 3, '0', STR_PAD_LEFT),
                'induk_unit_kerja_id' => $indukUnitKerjaId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
