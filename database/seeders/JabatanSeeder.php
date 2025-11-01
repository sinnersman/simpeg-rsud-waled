<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;
use App\Models\JenisJabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to prevent duplicates on re-seeding
        Jabatan::truncate();

        $jenisJabatanMap = [
            'ST' => 'STRUKTURAL',
            'JF' => 'MEDIS', // Assumption, can be refined
            'JP' => 'PELAKSANA',
        ];

        $jabatansData = [
            ['kode_jabatan' => 'ST1', 'nama_jabatan' => 'Direktur', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST2', 'nama_jabatan' => 'Wakil Direktur Pelayanan dan Pendidikan', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST3', 'nama_jabatan' => 'Wakil Direktur Umum dan Keuangan', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST4', 'nama_jabatan' => 'Kepala Bagian Keuangan', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST5', 'nama_jabatan' => 'Kepala Bagian Perencanaan, Hukum dan Pengembangan', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST6', 'nama_jabatan' => 'Kepala Bagian Umum dan Kepegawaian', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST7', 'nama_jabatan' => 'Kepala Bidang Pelayanan Keperawatan dan Pengendalian Mutu', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST8', 'nama_jabatan' => 'Kepala Bidang Pelayanan Medis dan Pengendalian Mutu', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST9', 'nama_jabatan' => 'Kepala Bidang Pelayanan Penunjang dan Pendidikan', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST10', 'nama_jabatan' => 'Kepala Subbagian Perlengkapan dan Rumah Tangga', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'ST11', 'nama_jabatan' => 'Kepala Subbagian Tata Usaha dan Kepegawaian', 'jenis_jabatan_code' => 'ST'],
            ['kode_jabatan' => 'JF1', 'nama_jabatan' => 'Administrator Kesehatan', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF2', 'nama_jabatan' => 'Analis Keuangan Pusat dan Daerah', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF3', 'nama_jabatan' => 'Analis Pengembangan Kompetensi ASN', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF4', 'nama_jabatan' => 'Apoteker', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF5', 'nama_jabatan' => 'Arsiparis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF6', 'nama_jabatan' => 'Asisten Apoteker', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF7', 'nama_jabatan' => 'Bidan', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF8', 'nama_jabatan' => 'Dokter', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF9', 'nama_jabatan' => 'Dokter Spesialis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF10', 'nama_jabatan' => 'Dokter Sub Spesialis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF11', 'nama_jabatan' => 'Dokter Gigi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF12', 'nama_jabatan' => 'Dokter Gigi Spesialis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF13', 'nama_jabatan' => 'Dokter Gigi Sub Spesialis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF14', 'nama_jabatan' => 'Dokter Gigi Spesialis Bedah Mulut dan Maksilofasial', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF15', 'nama_jabatan' => 'Dokter Gigi Spesialis Konservasi Gigi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF16', 'nama_jabatan' => 'Dokter Gigi Spesialis Periodonsia', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF17', 'nama_jabatan' => 'Dokter Spesialis Anak', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF18', 'nama_jabatan' => 'Dokter Spesialis Anestesiologi dan Terapi Intensif', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF19', 'nama_jabatan' => 'Dokter Spesialis Bedah', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF20', 'nama_jabatan' => 'Dokter Spesialis Bedah Anak', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF21', 'nama_jabatan' => 'Dokter Spesialis Bedah Saraf', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF22', 'nama_jabatan' => 'Dokter Spesialis Bedah Toraks Kardiovaskular', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF23', 'nama_jabatan' => 'Dokter Spesialis Dermatologi dan Venereologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF24', 'nama_jabatan' => 'Dokter Spesialis Gizi Klinik', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF25', 'nama_jabatan' => 'Dokter Spesialis Jantung dan Pembuluh Darah', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF26', 'nama_jabatan' => 'Dokter Spesialis Kedokteran Fisik dan Rehabilitasi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF27', 'nama_jabatan' => 'Dokter Spesialis Kedokteran Forensik dan Medikolegal', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF28', 'nama_jabatan' => 'Dokter Spesialis Kedokteran Jiwa atau Psikiatri', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF29', 'nama_jabatan' => 'Dokter Spesialis Mata', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF30', 'nama_jabatan' => 'Dokter Spesialis Mikrobiologi Klinik', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF31', 'nama_jabatan' => 'Dokter Spesialis Neurologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF32', 'nama_jabatan' => 'Dokter Spesialis Obstetri dan Ginekologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF33', 'nama_jabatan' => 'Dokter Spesialis Onkologi Radiasi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF34', 'nama_jabatan' => 'Dokter Spesialis Orthopaedi dan Traumatologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF35', 'nama_jabatan' => 'Dokter Spesialis Patologi Anatomi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF36', 'nama_jabatan' => 'Dokter Spesialis Patologi Klinik', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF37', 'nama_jabatan' => 'Dokter Spesialis Penyakit Dalam', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF38', 'nama_jabatan' => 'Dokter Spesialis Pulmonologi dan Kedokteran Respirasi (Paru)', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF39', 'nama_jabatan' => 'Dokter Spesialis Radiologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF40', 'nama_jabatan' => 'Dokter Spesialis Telinga Hidung Tenggorok - Bedah Kepala dan Leher', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF41', 'nama_jabatan' => 'Dokter Spesialis Urologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF42', 'nama_jabatan' => 'Dokter Sub Spesialis Anak Neonatologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF43', 'nama_jabatan' => 'Dokter Sub Spesialis Anestesi Intensif Care/ICU', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF44', 'nama_jabatan' => 'Dokter Sub Spesialis Bedah Saraf Neurospine', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF45', 'nama_jabatan' => 'Dokter Sub Spesialis Neurologi Neurorestorasi dan Neuroengineering', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF46', 'nama_jabatan' => 'Dokter Sub Spesialis Obgyn Fertilitas Endokrinologi Reproduksi (KFER)', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF47', 'nama_jabatan' => 'Dokter Sub Spesialis Obgyn Fetomaternal (KFM)', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF48', 'nama_jabatan' => 'Dokter Sub Spesialis Obgyn Obstetri Ginekologi Sosial', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF49', 'nama_jabatan' => 'Dokter Sub Spesialis Patologi Klinik Hematologi', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF50', 'nama_jabatan' => 'Dokter Sub Spesialis Penyakit Dalam Hematologi Onkologi Medik', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF51', 'nama_jabatan' => 'Dokter Sub Spesialis THT - Onkologi Kepala Leher', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF52', 'nama_jabatan' => 'Epidemiolog Kesehatan', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF53', 'nama_jabatan' => 'Fisikawan Medis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF54', 'nama_jabatan' => 'Fisioterapis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF55', 'nama_jabatan' => 'Nutrisionis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF56', 'nama_jabatan' => 'Pekerja Sosial', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF57', 'nama_jabatan' => 'Pembimbing Kesehatan Kerja', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF58', 'nama_jabatan' => 'Penyuluh Sosial', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF59', 'nama_jabatan' => 'Perawat', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF60', 'nama_jabatan' => 'Terapis Gigi dan Mulut', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF61', 'nama_jabatan' => 'Perawat', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF62', 'nama_jabatan' => 'Perekam Medis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF63', 'nama_jabatan' => 'Perencana', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF64', 'nama_jabatan' => 'Pranata Komputer', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF65', 'nama_jabatan' => 'Pranata Hubungan Masyarakat', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF66', 'nama_jabatan' => 'Pranata Laboratorium Kesehatan', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF67', 'nama_jabatan' => 'Promosi Kesehatan dan Ilmu Perilaku', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF68', 'nama_jabatan' => 'Radiografer', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF69', 'nama_jabatan' => 'Refraksionis Optisien', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF70', 'nama_jabatan' => 'Tenaga Sanitasi Lingkungan', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF71', 'nama_jabatan' => 'Teknisi Elektromedis', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF72', 'nama_jabatan' => 'Teknisi Transfusi Darah', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JF73', 'nama_jabatan' => 'Terapis Wicara', 'jenis_jabatan_code' => 'JF'],
            ['kode_jabatan' => 'JP1', 'nama_jabatan' => 'Administrasi Umum', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP2', 'nama_jabatan' => 'Operator Layanan Kesehatan', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP3', 'nama_jabatan' => 'Operator Layanan Operasional', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP4', 'nama_jabatan' => 'Penata Kelola layanan kesehatan', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP5', 'nama_jabatan' => 'Penata kelola sistem dan Teknologi informasi', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP6', 'nama_jabatan' => 'Penata Layanan Operasional', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP7', 'nama_jabatan' => 'Penelaah Teknis kebijakan', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP8', 'nama_jabatan' => 'Pengadministrasi Perkantoran', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP9', 'nama_jabatan' => 'Pengelola Layanan Kesehatan', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP10', 'nama_jabatan' => 'Pengelola Layanan Operasional', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP11', 'nama_jabatan' => 'Pengelola Layanan Pengadaan', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP12', 'nama_jabatan' => 'Pengelola Umum Operasional', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP13', 'nama_jabatan' => 'Pengolah Data dan Informasi', 'jenis_jabatan_code' => 'JP'],
            ['kode_jabatan' => 'JP14', 'nama_jabatan' => 'Teknisi Sarana dan Prasarana', 'jenis_jabatan_code' => 'JP'],
        ];

        // First pass: Create Jabatan records without parent_jabatan_id
        foreach ($jabatansData as $jabatanData) {
            $jenisJabatanName = $jenisJabatanMap[$jabatanData['jenis_jabatan_code']];
            $jenisJabatan = JenisJabatan::where('nama', $jenisJabatanName)->first();

            Jabatan::create([
                'kode_jabatan' => $jabatanData['kode_jabatan'],
                'nama_jabatan' => $jabatanData['nama_jabatan'],
                'jenis_jabatan_id' => $jenisJabatan->id ?? null,
                'jenjang_id' => null,
            ]);
        }

        // Second pass: Define hierarchy by setting parent_jabatan_id
        // This is a simplified example. A more robust solution might involve a separate configuration or more complex logic.

        // Get all created jabatans to easily find them by name or code
        $jabatans = Jabatan::all()->keyBy('kode_jabatan');

        // Define hierarchy relationships
        $hierarchy = [
            'ST2' => 'ST1', // Wakil Direktur Pelayanan dan Pendidikan reports to Direktur
            'ST3' => 'ST1', // Wakil Direktur Umum dan Keuangan reports to Direktur

            'ST4' => 'ST3', // Kepala Bagian Keuangan reports to Wakil Direktur Umum dan Keuangan
            'ST5' => 'ST3', // Kepala Bagian Perencanaan, Hukum dan Pengembangan reports to Wakil Direktur Umum dan Keuangan
            'ST6' => 'ST3', // Kepala Bagian Umum dan Kepegawaian reports to Wakil Direktur Umum dan Keuangan

            'ST7' => 'ST2', // Kepala Bidang Pelayanan Keperawatan dan Pengendalian Mutu reports to Wakil Direktur Pelayanan dan Pendidikan
            'ST8' => 'ST2', // Kepala Bidang Pelayanan Medis dan Pengendalian Mutu reports to Wakil Direktur Pelayanan dan Pendidikan
            'ST9' => 'ST2', // Kepala Bidang Pelayanan Penunjang dan Pendidikan reports to Wakil Direktur Pelayanan dan Pendidikan

            'ST10' => 'ST6', // Kepala Subbagian Perlengkapan dan Rumah Tangga reports to Kepala Bagian Umum dan Kepegawaian
            'ST11' => 'ST6', // Kepala Subbagian Tata Usaha dan Kepegawaian reports to Kepala Bagian Umum dan Kepegawaian

            // Example for Fungsional (JF) reporting to a Kepala Bidang
            'JF1' => 'ST7', // Administrator Kesehatan reports to Kepala Bidang Pelayanan Keperawatan
            'JF8' => 'ST8', // Dokter reports to Kepala Bidang Pelayanan Medis

            // Example for Pelaksana (JP) reporting to a Kepala Subbagian
            'JP1' => 'ST11', // Administrasi Umum reports to Kepala Subbagian Tata Usaha
        ];

        foreach ($hierarchy as $childKode => $parentKode) {
            $childJabatan = $jabatans->get($childKode);
            $parentJabatan = $jabatans->get($parentKode);

            if ($childJabatan && $parentJabatan) {
                $childJabatan->update(['parent_jabatan_id' => $parentJabatan->id]);
            }
        }

        // Third pass: Assign default parents for remaining unassigned Jabatans (JF and JP types)
        // This assumes JF and JP types generally report to a structural position.
        // For simplicity, we can make them report to a relevant Kepala Bidang or Kepala Subbagian.
        // Or, if no specific structural parent is found, they can report directly to the Direktur.

        $direktur = $jabatans->get('ST1'); // Direktur
        $kepalaBidangPelayananKeperawatan = $jabatans->get('ST7'); // Kepala Bidang Pelayanan Keperawatan
        $kepalaBidangPelayananMedis = $jabatans->get('ST8'); // Kepala Bidang Pelayanan Medis
        $kepalaSubbagianTataUsaha = $jabatans->get('ST11'); // Kepala Subbagian Tata Usaha

        foreach ($jabatans as $jabatan) {
            if (is_null($jabatan->parent_jabatan_id)) {
                if ($jabatan->jenisJabatan->nama === 'MEDIS' && $kepalaBidangPelayananMedis) {
                    $jabatan->update(['parent_jabatan_id' => $kepalaBidangPelayananMedis->id]);
                } elseif ($jabatan->jenisJabatan->nama === 'PELAKSANA' && $kepalaSubbagianTataUsaha) {
                    $jabatan->update(['parent_jabatan_id' => $kepalaSubbagianTataUsaha->id]);
                } elseif ($direktur) {
                    // Default to Direktur if no specific parent found
                    $jabatan->update(['parent_jabatan_id' => $direktur->id]);
                }
            }
        }
    }
}