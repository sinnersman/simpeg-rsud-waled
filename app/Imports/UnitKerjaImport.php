<?php

namespace App\Imports;

use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UnitKerjaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new UnitKerja([
            'kode' => $row['kode'],
            'nama_unit_kerja' => $row['nama_unit_kerja'],
            'induk_unit_kerja_id' => $row['induk_unit_kerja_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|unique:unit_kerja,kode',
            'nama_unit_kerja' => 'required|unique:unit_kerja,nama_unit_kerja',
            'induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
        ];
    }
}
