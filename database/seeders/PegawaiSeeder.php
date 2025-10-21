<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Faker\Factory as Faker; // Import the Pegawai model
use Illuminate\Database\Seeder; // Import Faker

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Use Indonesian locale for more realistic data

        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $statusPerkawinan = $faker->randomElement(['Single', 'Menikah', 'Cerai Hidup', 'Cerai Mati']);
            $pendidikanTerakhir = $faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']);
            $statusKepegawaian = $faker->randomElement(['ASN', 'PNS', 'PPPK', 'Kontrak', 'Honorer']);
            $golonganDarah = $faker->randomElement(['A', 'B', 'AB', 'O']);
            $agama = $faker->randomElement(['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu']);

            Pegawai::create([
                'foto_pegawai' => null, // No dummy photo for now, can be added later if needed
                'nip' => $faker->unique()->numerify('##################'), // 18 digits
                'nip_lama' => $faker->unique()->numerify('##################'),
                'nama_lengkap' => $faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                'nama_panggilan' => $faker->firstName($gender == 'Laki-laki' ? 'male' : 'female'),
                'gelar_depan' => $faker->optional()->title($gender == 'Laki-laki' ? 'male' : 'female'),
                'gelar_belakang' => $faker->optional()->suffix(),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
                'jenis_kelamin' => $gender,
                'agama' => $agama,
                'golongan_darah' => $golonganDarah,
                'status_perkawinan' => $statusPerkawinan,
                'pendidikan_terakhir' => $pendidikanTerakhir,
                'status_kepegawaian' => $statusKepegawaian,
                'suku' => $faker->randomElement(['Jawa', 'Sunda', 'Batak', 'Minang', 'Dayak']),
                'alamat_lengkap' => $faker->address,
                'kode_pos' => $faker->postcode,
                'email' => $faker->unique()->safeEmail,
                'fax' => $faker->optional()->phoneNumber,
                'telephone' => $faker->optional()->phoneNumber,
                'handphone' => $faker->phoneNumber,
                'rt' => $faker->numerify('###'),
                'rw' => $faker->numerify('###'),
                'provinsi' => $faker->state,
                'kabupaten' => $faker->city,
                'kecamatan' => $faker->city,
                'kelurahan' => $faker->streetName,
                'kebangsaan' => 'Indonesia',
                'berat_badan' => $faker->numberBetween(40, 100),
                'tinggi_badan' => $faker->numberBetween(150, 190),
                'no_karpeg' => $faker->optional()->numerify('##########'),
                'no_askes_bpjs' => $faker->optional()->numerify('#############'),
                'no_taspen' => $faker->optional()->numerify('##########'),
                'no_karis_karsu' => $faker->optional()->numerify('##########'),
                'no_npwp' => $faker->optional()->numerify('##.###.###.#-###.###'),
                'no_korpri' => $faker->optional()->numerify('##########'),
            ]);
        }
    }
}
