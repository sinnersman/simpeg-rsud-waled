<?php

namespace App\Imports;

use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GolonganImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Golongan([
            'kode' => $row['kode'],
            'golongan' => $row['golongan'],
            'pangkat' => $row['pangkat'],
        ]);
    }
}
