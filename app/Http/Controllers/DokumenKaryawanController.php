<?php

namespace App\Http\Controllers;

use App\DataTables\DokumenKaryawanDataTable;
use App\Models\DokumenKaryawan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenKaryawanController extends Controller
{
    public function index(DokumenKaryawanDataTable $dataTable)
    {
        $title = 'Dokumen Karyawan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Dokumen Karyawan', 'active' => true],
        ];

        return $dataTable->render('dokumen_karyawan.index', compact('title', 'breadcrumbs'));
    }

    public function create()
    {
        $title = 'Tambah Dokumen Karyawan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Dokumen Karyawan', 'url' => route('dokumen-karyawan.index')],
            ['name' => 'Tambah Dokumen', 'active' => true],
        ];

        $pegawais = Pegawai::all();

        return view('dokumen_karyawan.create', compact('title', 'breadcrumbs', 'pegawais'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required_if:auth()->user()->role,superadmin|exists:pegawai,id',
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if (auth()->user()->role === 'pegawai') {
            $pegawai = auth()->user()->pegawai;
            if (!$pegawai) {
                return redirect()->route('dokumen-karyawan.index')->with('error', 'Biodata Anda tidak ditemukan. Tidak dapat menambahkan dokumen.');
            }
            $validatedData['pegawai_id'] = $pegawai->id;
        }

        $path = $request->file('file')->store('public/dokumen_karyawan');
        $validatedData['file_path'] = $path;

        DokumenKaryawan::create($validatedData);

        return redirect()->route('dokumen-karyawan.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function edit(DokumenKaryawan $dokumenKaryawan)
    {
        $this->authorize('update', $dokumenKaryawan);

        $title = 'Edit Dokumen Karyawan';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Dokumen Karyawan', 'url' => route('dokumen-karyawan.index')],
            ['name' => 'Edit Dokumen', 'active' => true],
        ];

        $pegawais = Pegawai::all();

        return view('dokumen_karyawan.edit', compact('title', 'breadcrumbs', 'dokumenKaryawan', 'pegawais'));
    }

    public function update(Request $request, DokumenKaryawan $dokumenKaryawan)
    {
        $this->authorize('update', $dokumenKaryawan);

        $validatedData = $request->validate([
            'pegawai_id' => 'required_if:auth()->user()->role,superadmin|exists:pegawai,id',
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if (auth()->user()->role === 'pegawai') {
            $validatedData['pegawai_id'] = auth()->user()->pegawai->id;
        }

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::delete($dokumenKaryawan->file_path);
            $path = $request->file('file')->store('public/dokumen_karyawan');
            $validatedData['file_path'] = $path;
        }

        $dokumenKaryawan->update($validatedData);

        return redirect()->route('dokumen-karyawan.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(DokumenKaryawan $dokumenKaryawan)
    {
        $this->authorize('delete', $dokumenKaryawan);

        Storage::delete($dokumenKaryawan->file_path);
        $dokumenKaryawan->delete();

        return redirect()->route('dokumen-karyawan.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}
