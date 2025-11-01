<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiApprovalController extends Controller
{
    public function index()
    {
        $cutis = Cuti::where('status', 'pending')->get();
        return view('e-layanan.cuti-approval.index', compact('cutis'));
    }

    public function approve(Cuti $cuti)
    {
        $cuti->update([
            'status' => 'approved',
            'approver_id' => Auth::id(),
            'approval_date' => now(),
        ]);

        return redirect()->route('cuti.approval.index')->with('success', 'Pengajuan cuti disetujui.');
    }

    public function reject(Cuti $cuti)
    {
        $cuti->update([
            'status' => 'rejected',
            'approver_id' => Auth::id(),
            'approval_date' => now(),
        ]);

        return redirect()->route('cuti.approval.index')->with('success', 'Pengajuan cuti ditolak.');
    }
}
