<?php

namespace App\Http\Controllers;

use App\DataTables\AdminApprovalDataTable;
use App\Models\Pegawai;
use App\Models\PegawaiChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Indonesia;

class AdminApprovalController extends Controller
{
    public function index(AdminApprovalDataTable $dataTable)
    {
        $title = 'Permintaan Perubahan Biodata';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Persetujuan Admin', 'active' => true],
        ];

        return $dataTable->render('admin.approvals.index', compact('title', 'breadcrumbs'));
    }

    public function approve(Request $request, PegawaiChangeRequest $changeRequest)
    {
        if ($changeRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah tidak dalam status pending.');
        }

        DB::transaction(function () use ($changeRequest) {
            $pegawai = $changeRequest->pegawai;
            $field = $changeRequest->field_name;
            $newValue = $changeRequest->new_value;

            // Special handling for foto_pegawai to delete old file
            if ($field === 'foto_pegawai' && $pegawai->$field && $newValue) {
                Storage::delete(str_replace('/storage', 'public', $pegawai->$field));
            }

            $pegawai->$field = $newValue;
            $pegawai->save();

            $changeRequest->update([
                'status' => 'approved',
                'approved_by_user_id' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        return redirect()->route('admin.approvals.index')->with('success', 'Perubahan berhasil disetujui dan diterapkan.');
    }

    public function reject(Request $request, PegawaiChangeRequest $changeRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        if ($changeRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah tidak dalam status pending.');
        }

        $changeRequest->update([
            'status' => 'rejected',
            'approved_by_user_id' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.approvals.index')->with('success', 'Permintaan perubahan berhasil ditolak.');
    }
}