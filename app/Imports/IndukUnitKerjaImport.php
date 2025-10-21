<?php

namespace App\Imports;

use App\Models\IndukUnitKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class IndukUnitKerjaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new IndukUnitKerja([
            'kode' => $row['kode'],
            'nama_induk_unit_kerja' => $row['nama_induk_unit_kerja'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|unique:induk_unit_kerja,kode',
            'nama_induk_unit_kerja' => 'required|unique:induk_unit_kerja,nama_induk_unit_kerja',
        ];
    }
}
