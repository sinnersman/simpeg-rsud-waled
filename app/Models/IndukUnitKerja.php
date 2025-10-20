<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndukUnitKerja extends Model
{
    use SoftDeletes;

    protected $table = 'induk_unit_kerja';

    protected $fillable = [
        'kode',
        'nama_induk_unit_kerja',
    ];
}
