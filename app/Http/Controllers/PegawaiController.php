<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Storage;
use App\DataTables\PegawaiDataTable;
use Indonesia;
use Barryvdh\DomPDF\Facade\Pdf;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(PegawaiDataTable $dataTable)
    {
        $title = 'Data Pegawai';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Data Pegawai', 'active' => true]
        ];
        return $dataTable->render('pegawai.index', compact('title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pegawai';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Data Pegawai', 'url' => route('pegawai.index')],
            ['name' => 'Tambah Pegawai', 'active' => true]
        ];
        return view('pegawai.create', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nip' => 'required|string|unique:pegawai,nip|max:255',
            'nip_lama' => 'nullable|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'gelar_depan' => 'nullable|string|max:255',
            'gelar_belakang' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'golongan_darah' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'status_kepegawaian' => 'nullable|string|max:255',
            'suku' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:pegawai,email|max:255',
            'fax' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'handphone' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:255',
            'rw' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kebangsaan' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|integer',
            'tinggi_badan' => 'nullable|integer',
            'no_karpeg' => 'nullable|string|max:255',
            'no_askes_bpjs' => 'nullable|string|max:255',
            'no_taspen' => 'nullable|string|max:255',
            'no_karis_karsu' => 'nullable|string|max:255',
            'no_npwp' => 'nullable|string|max:255',
            'no_korpri' => 'nullable|string|max:255',
        ]);

        // Convert IDs to names before saving
        if ($request->provinsi) {
            $validatedData['provinsi'] = Indonesia::findProvince($request->provinsi)->name;
        }
        if ($request->kabupaten) {
            $validatedData['kabupaten'] = Indonesia::findCity($request->kabupaten)->name;
        }
        if ($request->kecamatan) {
            $validatedData['kecamatan'] = Indonesia::findDistrict($request->kecamatan)->name;
        }
        if ($request->kelurahan) {
            $validatedData['kelurahan'] = Indonesia::findVillage($request->kelurahan)->name;
        }

        if ($request->hasFile('foto_pegawai')) {
            $path = $request->file('foto_pegawai')->store('public/foto_pegawai');
            $validatedData['foto_pegawai'] = $path;
        }

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $title = 'Detail Pegawai';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Data Pegawai', 'url' => route('pegawai.index')],
            ['name' => 'Detail Pegawai', 'active' => true]
        ];

        return view('pegawai.show', compact('pegawai', 'title', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $title = 'Edit Pegawai';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Data Pegawai', 'url' => route('pegawai.index')],
            ['name' => 'Edit Pegawai', 'active' => true]
        ];
        return view('pegawai.edit', compact('pegawai', 'title', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validatedData = $request->validate([
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nip' => 'required|string|unique:pegawai,nip,' . $id . '|max:255',
            'nip_lama' => 'nullable|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'gelar_depan' => 'nullable|string|max:255',
            'gelar_belakang' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'golongan_darah' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'status_kepegawaian' => 'nullable|string|max:255',
            'suku' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:pegawai,email,' . $id . '|max:255',
            'fax' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'handphone' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:255',
            'rw' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kebangsaan' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|integer',
            'tinggi_badan' => 'nullable|integer',
            'no_karpeg' => 'nullable|string|max:255',
            'no_askes_bpjs' => 'nullable|string|max:255',
            'no_taspen' => 'nullable|string|max:255',
            'no_karis_karsu' => 'nullable|string|max:255',
            'no_npwp' => 'nullable|string|max:255',
            'no_korpri' => 'nullable|string|max:255',
        ]);

        // Convert IDs to names before saving
        if ($request->provinsi) {
            $validatedData['provinsi'] = Indonesia::findProvince($request->provinsi)->name;
        }
        if ($request->kabupaten) {
            $validatedData['kabupaten'] = Indonesia::findCity($request->kabupaten)->name;
        }
        if ($request->kecamatan) {
            $validatedData['kecamatan'] = Indonesia::findDistrict($request->kecamatan)->name;
        }
        if ($request->kelurahan) {
            $validatedData['kelurahan'] = Indonesia::findVillage($request->kelurahan)->name;
        }

        if ($request->hasFile('foto_pegawai')) {
            // Delete old photo if exists
            if ($pegawai->foto_pegawai) {
                Storage::delete(str_replace('/storage', 'public', $pegawai->foto_pegawai));
            }
            $path = $request->file('foto_pegawai')->store('public/foto_pegawai');
            $validatedData['foto_pegawai'] = $path;
        }

        $pegawai->update($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Delete photo if exists
        if ($pegawai->foto_pegawai) {
            Storage::delete(str_replace('/storage', 'public', $pegawai->foto_pegawai));
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil dihapus!');
    }

    public function generatePDF(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pdf = Pdf::loadView('pegawai.pdf', compact('pegawai'));
        return $pdf->download('pegawai-' . $pegawai->nip . '.pdf');
    }
}
