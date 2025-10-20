<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use SoftDeletes;

    protected $table = 'unit_kerja';

    protected $fillable = [
        'induk_unit_kerja_id',
        'kode',
        'nama_unit_kerja',
    ];

    public function indukUnitKerja()
    {
        return $this->belongsTo(IndukUnitKerja::class);
    }
}
