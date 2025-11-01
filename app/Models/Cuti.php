<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approver_id',
        'approval_date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
