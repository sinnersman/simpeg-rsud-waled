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
        'parent_id', // Add parent_id to fillable
        'kode',
        'nama_unit_kerja',
    ];

    public function indukUnitKerja()
    {
        return $this->belongsTo(IndukUnitKerja::class);
    }

    // Self-referencing relationship for parent
    public function parent()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_id');
    }

    // Self-referencing relationship for children
    public function children()
    {
        return $this->hasMany(UnitKerja::class, 'parent_id');
    }
}
