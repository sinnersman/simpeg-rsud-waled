<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['kode_jabatan', 'nama_jabatan', 'jenis_jabatan_id', 'jenjang_id', 'parent_jabatan_id'];

    public function jenisJabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }

    public function parent()
    {
        return $this->belongsTo(Jabatan::class, 'parent_jabatan_id');
    }

    public function children()
    {
        return $this->hasMany(Jabatan::class, 'parent_jabatan_id');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function getDepthAttribute()
    {
        $depth = 0;
        $parent = $this->parent;
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        return $depth;
    }
}
