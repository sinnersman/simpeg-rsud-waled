<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\CutiApprovalDataTable;

class CutiApprovalController extends Controller
{
    public function index(CutiApprovalDataTable $dataTable)
    {
        return $dataTable->render('e-layanan.cuti-approval.index', [
            'title' => 'Persetujuan Cuti',
            'breadcrumbs' => [
                [
                    'name' => 'E-Layanan',
                    'url' => route('cuti.index')
                ],
                [
                    'name' => 'Persetujuan Cuti',
                    'url' => route('cuti.approval.index')
                ]
            ]
        ]);
    }

    public function approve(Cuti $cuti)
    {
        if ($cuti->approval_1_status === 'pending') {
            $cuti->update([
                'approver_1_id' => Auth::id(),
                'approval_1_date' => now(),
                'approval_1_status' => 'approved',
            ]);
            // If there's no second approver or it's already approved, set overall status to approved
            if (!$cuti->approver_2_id || $cuti->approval_2_status === 'approved') {
                $cuti->update(['status' => 'approved']);
            } else {
                $cuti->update(['status' => 'pending_level_2']); // Custom status for pending second approval
            }
            $message = 'Pengajuan cuti disetujui di level 1.';
        } elseif ($cuti->approval_1_status === 'approved' && $cuti->approval_2_status === 'pending') {
            $cuti->update([
                'approver_2_id' => Auth::id(),
                'approval_2_date' => now(),
                'approval_2_status' => 'approved',
                'status' => 'approved', // Final approval
            ]);
            $message = 'Pengajuan cuti disetujui di level 2.';
        } else {
            $message = 'Pengajuan cuti sudah tidak dalam status pending persetujuan.';
        }

        return redirect()->route('cuti.approval.index')->with('success', $message);
    }

    public function reject(Cuti $cuti)
    {
        if ($cuti->approval_1_status === 'pending') {
            $cuti->update([
                'approver_1_id' => Auth::id(),
                'approval_1_date' => now(),
                'approval_1_status' => 'rejected',
                'status' => 'rejected', // Final rejection
            ]);
            $message = 'Pengajuan cuti ditolak di level 1.';
        } elseif ($cuti->approval_1_status === 'approved' && $cuti->approval_2_status === 'pending') {
            $cuti->update([
                'approver_2_id' => Auth::id(),
                'approval_2_date' => now(),
                'approval_2_status' => 'rejected',
                'status' => 'rejected', // Final rejection
            ]);
            $message = 'Pengajuan cuti ditolak di level 2.';
        } else {
            $message = 'Pengajuan cuti sudah tidak dalam status pending persetujuan.';
        }

        return redirect()->route('cuti.approval.index')->with('success', $message);
    }
}
