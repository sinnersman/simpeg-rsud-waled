<?php

namespace App\Console\Commands;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Console\Command;

class DeletePegawaiAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pegawai:delete-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete user accounts associated with Pegawai records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pegawaiNips = Pegawai::pluck('nip')->toArray();
        $usersToDelete = User::where('role', 'pegawai')
            ->whereIn('username', $pegawaiNips)
            ->get();

        if ($usersToDelete->isEmpty()) {
            $this->info('No Pegawai accounts to delete.');
            return;
        }

        $bar = $this->output->createProgressBar($usersToDelete->count());
        $bar->start();

        foreach ($usersToDelete as $user) {
            $user->delete();
            $bar->advance();
        }

        $bar->finish();
        $this->info('\nPegawai accounts deleted successfully.');
    }
}
