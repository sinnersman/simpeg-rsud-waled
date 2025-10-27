<?php

namespace App\Console\Commands;
use App\Models\Pegawai;
use Illuminate\Console\Command;

class PegawaiUpdateGender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pegawai:update-gender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update gender on Pegawai table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pegawais = Pegawai::all();
        $bar = $this->output->createProgressBar($pegawais->count());
        $bar->start();

        foreach ($pegawais as $pegawai) {
            if ($pegawai->jenis_kelamin == 'L') {
                $pegawai->jenis_kelamin = 'Laki-laki';
                $pegawai->save();
            } elseif ($pegawai->jenis_kelamin == 'P') {
                $pegawai->jenis_kelamin = 'Perempuan';
                $pegawai->save();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info('\nGender update completed.');
    }
}
