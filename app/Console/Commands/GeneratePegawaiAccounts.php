<?php

namespace App\Console\Commands;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GeneratePegawaiAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pegawai:generate-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user accounts for pegawai and export to Excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pegawais = Pegawai::all();
        $users = User::all()->keyBy('username');

        $newAccounts = [];

        $bar = $this->output->createProgressBar($pegawais->count());
        $bar->start();

        foreach ($pegawais as $pegawai) {
            if (!$users->has($pegawai->nip)) {
                $password = Str::random(10);
                User::create([
                    'name' => $pegawai->nama_lengkap,
                    'username' => $pegawai->nip,
                    'email' => $pegawai->email,
                    'password' => Hash::make($password),
                    'role' => 'pegawai',
                ]);
                $newAccounts[] = ['username' => $pegawai->nip, 'password' => $password];
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info('\nAccount generation completed.');

        if (count($newAccounts) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Username');
            $sheet->setCellValue('B1', 'Password');

            $row = 2;
            foreach ($newAccounts as $account) {
                $sheet->setCellValueExplicit('A' . $row, $account['username'], DataType::TYPE_STRING);
                $sheet->setCellValue('B' . $row, $account['password']);
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $fileName = 'new_pegawai_accounts.xlsx';
            $filePath = storage_path('app/' . $fileName);
            $writer->save($filePath);

            $this->info('Generated accounts exported to: ' . $filePath);
        } else {
            $this->info('No new accounts to generate.');
        }
    }
}
