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
        'leave_type',
        'approver_1_id',
        'approval_1_date',
        'approval_1_status',
        'approver_2_id',
        'approval_2_date',
        'approval_2_status',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function approver1()
    {
        return $this->belongsTo(User::class, 'approver_1_id');
    }

    public function approver2()
    {
        return $this->belongsTo(User::class, 'approver_2_id');
    }
}
