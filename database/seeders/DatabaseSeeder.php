<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JenisJabatanSeeder::class,
            JenjangSeeder::class,
            GolonganSeeder::class,
            JabatanSeeder::class,
            IndukUnitKerjaSeeder::class,
            OrganizationHierarchySeeder::class,
            UserSeeder::class,
        ]);
    }
}