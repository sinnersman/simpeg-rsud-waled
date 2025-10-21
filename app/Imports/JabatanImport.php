<?php

namespace App\Imports;

use App\Models\Jabatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JabatanImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Jabatan([
            'kode_jabatan' => $row['kode_jabatan'],
            'nama_jabatan' => $row['nama_jabatan'],
        ]);
    }
}
