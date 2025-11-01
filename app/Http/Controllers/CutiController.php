<?php

namespace App\Http\Controllers;

use App\Http\Requests\CutiRequest;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\CutiDataTable;
use App\Models\Pegawai;

class CutiController extends Controller
{
    public function index(CutiDataTable $dataTable)
    {
        return $dataTable->render('e-layanan.cuti.index', [
            'title' => 'Pengajuan Cuti',
            'breadcrumbs' => [
                [
                    'name' => 'E-Layanan',
                    'url' => route('cuti.index')
                ],
                [
                    'name' => 'Pengajuan Cuti',
                    'url' => route('cuti.index')
                ]
            ]
        ]);
    }

    public function create()
    {
        return view('e-layanan.cuti.create', [
            'title' => 'Pengajuan Cuti',
            'breadcrumbs' => [
                [
                    'name' => 'E-Layanan',
                    'url' => route('cuti.index')
                ],
                [
                    'name' => 'Pengajuan Cuti',
                    'url' => route('cuti.index')
                ],
                [
                    'name' => 'Buat Pengajuan Cuti',
                    'url' => route('cuti.create')
                ]
            ]
        ]);
    }

    public function store(CutiRequest $request)
    {
        $validated = $request->validated();
        $validated['pegawai_id'] = Auth::user()->pegawai->id;
        $validated['status'] = 'pending'; // Overall status
        $validated['approval_1_status'] = 'pending'; // Initial status for level 1
        $validated['approval_2_status'] = 'pending'; // Initial status for level 2

        // Determine Approver 1 (Direct Supervisor)
        $pegawai = Auth::user()->pegawai;
        $approver1Id = null;
        if ($pegawai && $pegawai->jabatan && $pegawai->jabatan->parent) {
            // Find the Pegawai who holds the parent jabatan
            $approver1Pegawai = \App\Models\Pegawai::where('jabatan_id', $pegawai->jabatan->parent->id)->first();
            if ($approver1Pegawai && $approver1Pegawai->user) {
                $approver1Id = $approver1Pegawai->user->id;
            }
        }
        $validated['approver_1_id'] = $approver1Id;

        // Determine Approver 2 (Head of Work Unit) - Placeholder for now
        // This logic needs to be defined based on how the head of a UnitKerja is identified.
        // For example, a specific jabatan within the unit, or a direct link in UnitKerja model.
        $approver2Id = null;
        // Example placeholder logic: If the parent jabatan also has a parent, that might be level 2
        if ($pegawai && $pegawai->jabatan && $pegawai->jabatan->parent && $pegawai->jabatan->parent->parent) {
            $approver2Pegawai = \App\Models\Pegawai::where('jabatan_id', $pegawai->jabatan->parent->parent->id)->first();
            if ($approver2Pegawai && $approver2Pegawai->user) {
                $approver2Id = $approver2Pegawai->user->id;
            }
        }
        $validated['approver_2_id'] = $approver2Id;

        Cuti::create($validated);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dibuat.');
    }

    public function edit(Cuti $cuti)
    {
        return view('e-layanan.cuti.edit', [
            'title' => 'Edit Pengajuan Cuti',
            'breadcrumbs' => [
                [
                    'name' => 'E-Layanan',
                    'url' => route('cuti.index')
                ],
                [
                    'name' => 'Pengajuan Cuti',
                    'url' => route('cuti.index')
                ],
                [
                    'name' => 'Edit Pengajuan Cuti',
                    'url' => route('cuti.edit', $cuti->id)
                ]
            ],
            'cuti' => $cuti
        ]);
    }

    public function update(CutiRequest $request, Cuti $cuti)
    {
        $validated = $request->validated();
        // Do not allow changing pegawai_id or status from here
        unset($validated['pegawai_id']);
        unset($validated['status']); // Status will be updated by approval process
        unset($validated['approval_1_status']);
        unset($validated['approval_2_status']);
        unset($validated['approver_1_id']);
        unset($validated['approver_2_id']);
        unset($validated['approval_1_date']);
        unset($validated['approval_2_date']);

        $cuti->update($validated);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil diperbarui.');
    }

    public function destroy(Cuti $cuti)
    {
        $cuti->delete();

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dihapus.');
    }
}
