<?php

namespace App\Http\Controllers;

use App\Models\RiwayatJabatan;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\IndukUnitKerja;
use App\DataTables\RiwayatJabatanDataTable;
use Illuminate\Http\Request;

class EJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RiwayatJabatanDataTable $dataTable)
    {
        $title = 'Riwayat Jabatan';
        $breadcrumbs = [
            ['name' => 'E-Jabatan'],
            ['name' => 'Riwayat Jabatan', 'url' => route('e-jabatan.index')],
        ];

        return $dataTable->render('e_jabatan.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Riwayat Jabatan';
        $breadcrumbs = [
            ['name' => 'E-Jabatan', 'url' => route('e-jabatan.index')],
            ['name' => 'Tambah Riwayat Jabatan'],
        ];

        $pegawai = Pegawai::all();
        $jabatans = Jabatan::all();
        $unitKerja = UnitKerja::all();
        $indukUnitKerja = IndukUnitKerja::all();

        return view('e_jabatan.create', compact('title', 'breadcrumbs', 'pegawai', 'jabatans', 'unitKerja', 'indukUnitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
            'jenis_jabatan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tmt' => 'nullable|date',
            'jenis_pns' => 'nullable|string|max:255',
            'no_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'pejabat_penetap' => 'nullable|string|max:255',
            'status_sumpah' => 'nullable|string|max:255',
            'no_pelantikan' => 'nullable|string|max:255',
            'tanggal_pelantikan' => 'nullable|date',
        ]);

        RiwayatJabatan::create($request->all());

        return redirect()->route('e-jabatan.index')->with('success', 'Riwayat Jabatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not implemented for now, as per the request.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatJabatan $riwayatJabatan)
    {
        $title = 'Edit Riwayat Jabatan';
        $breadcrumbs = [
            ['name' => 'E-Jabatan', 'url' => route('e-jabatan.index')],
            ['name' => 'Edit Riwayat Jabatan'],
        ];

        $pegawai = Pegawai::all();
        $jabatans = Jabatan::all();
        $unitKerja = UnitKerja::all();
        $indukUnitKerja = IndukUnitKerja::all();

        return view('e_jabatan.edit', compact('title', 'breadcrumbs', 'riwayatJabatan', 'pegawai', 'jabatans', 'unitKerja', 'indukUnitKerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatJabatan $riwayatJabatan)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
            'jenis_jabatan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tmt' => 'nullable|date',
            'jenis_pns' => 'nullable|string|max:255',
            'no_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'pejabat_penetap' => 'nullable|string|max:255',
            'status_sumpah' => 'nullable|string|max:255',
            'no_pelantikan' => 'nullable|string|max:255',
            'tanggal_pelantikan' => 'nullable|date',
        ]);

        $riwayatJabatan->update($request->all());

        return redirect()->route('e-jabatan.index')->with('success', 'Riwayat Jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatJabatan $riwayatJabatan)
    {
        $riwayatJabatan->delete();

        return redirect()->route('e-jabatan.index')->with('success', 'Riwayat Jabatan berhasil dihapus.');
    }
}
