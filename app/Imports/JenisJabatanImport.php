<?php

namespace App\Imports;

use App\Models\JenisJabatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisJabatanImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new JenisJabatan([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
        ]);
    }
}
