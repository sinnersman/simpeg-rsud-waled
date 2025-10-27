<?php

namespace App\Http\Controllers;

use App\DataTables\PegawaiDataTable;
use App\Models\Pegawai;
use App\Models\PegawaiChangeRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Indonesia;
use App\DataTables\PegawaiChangeRequestDataTable;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\DataTables\RiwayatJabatanDataTable;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\IndukUnitKerja;
use App\Models\JenisJabatan;
use App\Models\Jenjang;
use App\Models\Golongan;
use App\Models\RiwayatJabatan;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Imports\PegawaiImport;

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
            ['name' => 'Data Pegawai', 'active' => true],
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
            ['name' => 'Tambah Pegawai', 'active' => true],
        ];

        $jabatans = Jabatan::all();
        $jenisJabatans = JenisJabatan::all();
        $jenjangs = Jenjang::all();
        $golongans = Golongan::all();
        $unitKerjas = UnitKerja::all();
        $indukUnitKerjas = IndukUnitKerja::all();

        return view('pegawai.create', compact('title', 'breadcrumbs', 'jabatans', 'jenisJabatans', 'jenjangs', 'golongans', 'unitKerjas', 'indukUnitKerjas'));
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
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'jenis_jabatan_id' => 'nullable|exists:jenis_jabatans,id',
            'jenjang_id' => 'nullable|exists:jenjangs,id',
            'golongan_id' => 'nullable|exists:golongans,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'induk_unit_kerja_id' => 'nullable|exists:induk_unit_kerja,id',
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
    public function show(Pegawai $pegawai, RiwayatJabatanDataTable $dataTable)
    {
        $title = 'Detail Pegawai';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Data Pegawai', 'url' => route('pegawai.index')],
            ['name' => 'Detail Pegawai', 'active' => true],
        ];

        $dataTable->pegawaiId = $pegawai->id; // Pass pegawaiId to the DataTable

        $jabatans = \App\Models\Jabatan::all();
        $unitKerja = \App\Models\UnitKerja::all();
        $indukUnitKerja = \App\Models\IndukUnitKerja::all();

        return $dataTable->render('pegawai.show', compact('pegawai', 'title', 'breadcrumbs', 'jabatans', 'unitKerja', 'indukUnitKerja'));
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
            ['name' => 'Edit Pegawai', 'active' => true],
        ];

        // Pass null for $dataTable when accessed by superadmin
        $dataTable = null;

        // Pass null for selected location IDs when accessed by superadmin
        $selectedProvinceId = null;
        $selectedCityId = null;
        $selectedDistrictId = null;
        $selectedVillageId = null;
        $jabatans = \App\Models\Jabatan::all();
        $jenisJabatans = \App\Models\JenisJabatan::all();
        $jenjangs = \App\Models\Jenjang::all();
        $golongans = \App\Models\Golongan::all();
        $unitKerjas = \App\Models\UnitKerja::all();
        $indukUnitKerjas = \App\Models\IndukUnitKerja::all();


        return view('pegawai.edit', compact(
            'pegawai',
            'title',
            'breadcrumbs',
            'dataTable',
            'selectedProvinceId',
            'selectedCityId',
            'selectedDistrictId',
            'selectedVillageId',
            'jabatans',
            'jenisJabatans',
            'jenjangs',
            'golongans',
            'unitKerjas',
            'indukUnitKerjas'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validatedData = $request->validate([
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nip' => 'required|string|unique:pegawai,nip,'.$id.'|max:255',
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
            'email' => 'nullable|email|unique:pegawai,email,'.$id.'|max:255',
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
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'jenis_jabatan_id' => 'nullable|exists:jenis_jabatans,id',
            'jenjang_id' => 'nullable|exists:jenjangs,id',
            'golongan_id' => 'nullable|exists:golongans,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'induk_unit_kerja_id' => 'nullable|exists:induk_unit_kerja,id',
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

        // Log::info('Updating Pegawai. Data to be updated:', $validatedData);
        $pegawai->fill($validatedData);
        $pegawai->save();

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

        return $pdf->download('pegawai-'.$pegawai->nip.'.pdf');
    }

    public function createAccount(Pegawai $pegawai)
    {
        // Generate a random password
        $password = Str::random(10);

        // Create user account
        User::create([
            'name' => $pegawai->nama_lengkap,
            'username' => $pegawai->nip,
            'email' => $pegawai->email, // Assuming email is optional and can be null
            'password' => Hash::make($password),
            'role' => 'pegawai',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuat.',
            'password' => $password,
        ]);
    }

    public function myBiodataEdit(PegawaiChangeRequestDataTable $dataTable) // Inject the DataTable
    {
        $pegawai = Pegawai::where('nip', auth()->user()->username)->first();

        if (!$pegawai) {
            // If biodata doesn't exist, show the creation form
            $title = 'Lengkapi Biodata Saya';
            $breadcrumbs = [
                ['name' => 'Dashboard', 'url' => route('dashboard.index')],
                ['name' => 'Lengkapi Biodata', 'active', true],
            ];
            // Pass an empty Pegawai object to the create view
            return view('pegawai.create', compact('title', 'breadcrumbs'));
        }

        // If biodata exists, show the edit form
        $title = 'Edit Biodata Saya';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard.index')],
            ['name' => 'Biodata Saya', 'active', true],
        ];

        // Pass the pegawaiId to the DataTable instance
        $dataTable->pegawaiId = $pegawai->id;

        // Pass null for selected location IDs when accessed by superadmin
        $selectedProvinceId = null;
        $selectedCityId = null;
        $selectedDistrictId = null;
        $selectedVillageId = null;

        $jabatans = Jabatan::all();
        $jenisJabatans = JenisJabatan::all();
        $jenjangs = Jenjang::all();
        $golongans = Golongan::all();
        $unitKerjas = UnitKerja::all();
        $indukUnitKerjas = IndukUnitKerja::all();

        return $dataTable->render('pegawai.edit', compact(
            'pegawai',
            'title',
            'breadcrumbs',
            'selectedProvinceId',
            'selectedCityId',
            'selectedDistrictId',
            'selectedVillageId',
            'jabatans',
            'jenisJabatans',
            'jenjangs',
            'golongans',
            'unitKerjas',
            'indukUnitKerjas'
        ));
    }

    public function myBiodataUpdate(Request $request)
    {
        $pegawai = Pegawai::where('nip', auth()->user()->username)->firstOrFail();

        $validatedData = $request->validate([
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nip' => 'required|string|unique:pegawai,nip,'.$pegawai->id.'|max:255',
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
            'email' => 'nullable|email|unique:pegawai,email,'.$pegawai->id.'|max:255',
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

        // Handle file upload separately as it's not a direct field update
        $newFotoPegawaiPath = null;
        if ($request->hasFile('foto_pegawai')) {
            $newFotoPegawaiPath = $request->file('foto_pegawai')->store('public/foto_pegawai');
        }

        $changesRequested = false;
        foreach ($validatedData as $field => $newValue) {
            $oldValue = $pegawai->$field;

            // Special handling for foto_pegawai
            if ($field === 'foto_pegawai') {
                if ($newFotoPegawaiPath && $newFotoPegawaiPath !== $oldValue) {
                    PegawaiChangeRequest::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => $field,
                        'old_value' => $oldValue,
                        'new_value' => $newFotoPegawaiPath,
                        'requested_by_user_id' => auth()->id(),
                        'status' => 'pending',
                    ]);
                    $changesRequested = true;
                }
            } else {
                // Normalize empty strings, null, and 0 to null for nullable fields before comparison
                $normalizedNewValue = ($newValue === '' || $newValue === null || $newValue === 0) ? null : (string)$newValue;
                $normalizedOldValue = ($oldValue === '' || $oldValue === null || $oldValue === 0) ? null : (string)$oldValue;

                if ($normalizedNewValue !== $normalizedOldValue) {
                    // Convert IDs to names for display in change request
                    if (in_array($field, ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan'])) {
                        $oldValueDisplay = $pegawai->$field; // Use current value for old_value display
                        if ($field === 'provinsi') {
                            $province = Indonesia::findProvince($newValue);
                            $newValue = $province ? $province->name : $newValue; // Use name if found, else keep ID
                        }
                        if ($field === 'kabupaten') {
                            $city = Indonesia::findCity($newValue);
                            $newValue = $city ? $city->name : $newValue; // Use name if found, else keep ID
                        }
                        if ($field === 'kecamatan') {
                            $district = Indonesia::findDistrict($newValue);
                            $newValue = $district ? $district->name : $newValue; // Use name if found, else keep ID
                        }
                        if ($field === 'kelurahan') {
                            $village = Indonesia::findVillage($newValue);
                            $newValue = $village ? $village->name : $newValue; // Use name if found, else keep ID
                        }
                        $oldValue = $oldValueDisplay; // Reassign old value for storage
                    }

                    Log::info('PegawaiChangeRequest created for field:', [
                        'field' => $field,
                        'oldValue' => $oldValue,
                        'newValue' => $newValue,
                        'normalizedOldValue' => $normalizedOldValue,
                        'normalizedNewValue' => $normalizedNewValue,
                    ]);
                    PegawaiChangeRequest::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => $field,
                        'old_value' => $oldValue,
                        'new_value' => $newValue,
                        'requested_by_user_id' => auth()->id(),
                        'status' => 'pending',
                    ]);
                    $changesRequested = true;
                }
            }
        }

        if ($changesRequested) {
            return redirect()->route('pegawai.myBiodataEdit')->with('success', 'Perubahan Anda telah diajukan dan menunggu persetujuan admin.');
        } else {
            return redirect()->route('pegawai.myBiodataEdit')->with('info', 'Tidak ada perubahan yang diajukan.');
        }
    }

    public function myBiodataStore(Request $request)
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
            'no_askes_bpjs' => 'nullable|string|max:2uniquetoken',
            'no_taspen' => 'nullable|string|max:255',
            'no_karis_karsu' => 'nullable|string|max:255',
            'no_npwp' => 'nullable|string|max:255',
            'no_korpri' => 'nullable|string|max:255',
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'jenis_jabatan_id' => 'nullable|exists:jenis_jabatans,id',
            'jenjang_id' => 'nullable|exists:jenjangs,id',
            'golongan_id' => 'nullable|exists:golongans,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
            'induk_unit_kerja_id' => 'nullable|exists:induk_unit_kerja,id',
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

        // Associate with the logged-in user
        $validatedData['user_id'] = auth()->id();

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.myBiodataEdit')->with('success', 'Biodata berhasil disimpan!');
    }

    public function updateJabatan(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'new_jabatan_id' => 'required|exists:jabatans,id',
            'new_jenis_jabatan_id' => 'required|exists:jenis_jabatans,id',
            'new_jenjang_id' => 'required|exists:jenjangs,id',
            'new_golongan_id' => 'required|exists:golongans,id',
            'new_unit_kerja_id' => 'required|exists:unit_kerja,id',
            'new_induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
            'tanggal_masuk_baru' => 'required|date',
            'new_tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk_baru', // Added validation
            'no_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'pejabat_penetap' => 'nullable|string|max:255',
        ]);

        // Find the currently active riwayat_jabatan record
        $currentRiwayat = $pegawai->riwayatJabatan()->whereNull('tanggal_keluar')->first();

        // If there's an active record, set its tanggal_keluar
        if ($currentRiwayat) {
            $currentRiwayat->tanggal_keluar = \Carbon\Carbon::parse($validatedData['tanggal_masuk_baru'])->subDay();
            $currentRiwayat->save();
        }

        // Update the pegawai's current position
        $pegawai->update([
            'jabatan_id' => $validatedData['new_jabatan_id'],
            'jenis_jabatan_id' => $validatedData['new_jenis_jabatan_id'],
            'jenjang_id' => $validatedData['new_jenjang_id'],
            'golongan_id' => $validatedData['new_golongan_id'],
            'unit_kerja_id' => $validatedData['new_unit_kerja_id'],
            'induk_unit_kerja_id' => $validatedData['new_induk_unit_kerja_id'],
        ]);

        // Create a new riwayat_jabatan record
        $pegawai->riwayatJabatan()->create([
            'jabatan_id' => $validatedData['new_jabatan_id'],
            'jenis_jabatan_id' => $validatedData['new_jenis_jabatan_id'],
            'jenjang_id' => $validatedData['new_jenjang_id'],
            'golongan_id' => $validatedData['new_golongan_id'],
            'unit_kerja_id' => $validatedData['new_unit_kerja_id'],
            'induk_unit_kerja_id' => $validatedData['new_induk_unit_kerja_id'],
            'tanggal_masuk' => $validatedData['tanggal_masuk_baru'],
            'tanggal_keluar' => $validatedData['new_tanggal_keluar'] ?? null, // Use the new tanggal_keluar if provided
            'no_sk' => $validatedData['no_sk'],
            'tanggal_sk' => $validatedData['tanggal_sk'],
            'pejabat_penetap' => $validatedData['pejabat_penetap'],
        ]);

        return redirect()->route('pegawai.edit', $pegawai->id)->with('success', 'Perubahan jabatan berhasil disimpan!');
    }

    public function updateRiwayatJabatan(Request $request, Pegawai $pegawai, RiwayatJabatan $riwayat_jabatan)
    {
        $validatedData = $request->validate([
            'jabatan_id' => 'required|exists:jabatans,id',
            'jenis_jabatan_id' => 'required|exists:jenis_jabatans,id',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'golongan_id' => 'required|exists:golongans,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'induk_unit_kerja_id' => 'required|exists:induk_unit_kerja,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'no_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'pejabat_penetap' => 'nullable|string|max:255',
        ]);

        $riwayat_jabatan->update($validatedData);

        return redirect()->route('pegawai.edit', $pegawai->id)->with('success', 'Riwayat jabatan berhasil diperbarui!');
    }

    public function destroyRiwayatJabatan(Pegawai $pegawai, RiwayatJabatan $riwayat_jabatan)
    {
        $riwayat_jabatan->delete(); // Soft delete

        return redirect()->route('pegawai.edit', $pegawai->id)->with('success', 'Riwayat jabatan berhasil dihapus!');
    }

    /**
     * Download Excel template for Pegawai.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet;

        // Create the main data sheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pegawai');
        $fillable = (new Pegawai)->getFillable();
        // remove foreign key ids and add name columns
        $fillable = array_diff($fillable, ['jabatan_id', 'jenis_jabatan_id', 'jenjang_id', 'golongan_id', 'unit_kerja_id', 'induk_unit_kerja_id']);
        $fillable[] = 'jabatan';
        $fillable[] = 'jenis_jabatan';
        $fillable[] = 'jenjang';
        $fillable[] = 'golongan';
        $fillable[] = 'unit_kerja';
        $fillable[] = 'induk_unit_kerja';

        $sheet->fromArray($fillable, null, 'A1');

        // Create master data sheets and add data validation
        $masters = [
            'jabatan' => ['model' => Jabatan::class, 'name_column' => 'nama_jabatan', 'code_column' => 'kode_jabatan'],
            'jenis_jabatan' => ['model' => JenisJabatan::class, 'name_column' => 'nama', 'code_column' => 'id'],
            'jenjang' => ['model' => Jenjang::class, 'name_column' => 'nama', 'code_column' => 'id'],
            'golongan' => ['model' => Golongan::class, 'name_column' => 'golongan', 'code_column' => 'id'],
            'unit_kerja' => ['model' => UnitKerja::class, 'name_column' => 'nama_unit_kerja', 'code_column' => 'id'],
            'induk_unit_kerja' => ['model' => IndukUnitKerja::class, 'name_column' => 'nama_induk_unit_kerja', 'code_column' => 'id'],
        ];

        foreach ($masters as $masterName => $masterData) {
            $masterSheet = $spreadsheet->createSheet();
            $masterSheet->setTitle($masterName);
            $masterModel = new $masterData['model'];
            $masterItems = $masterModel->all();
            $masterSheet->fromArray([['id', $masterData['name_column'], 'code_and_name']], null, 'A1');
            $masterItemsArray = [];
            foreach ($masterItems as $item) {
                $masterItemsArray[] = [$item->id, $item->{$masterData['name_column']}, $item->{$masterData['code_column']} . ' - ' . $item->{$masterData['name_column']}];
            }
            $masterSheet->fromArray($masterItemsArray, null, 'A2');

            $colIndex = array_search($masterName, array_values($fillable));
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            for ($i = 2; $i <= 1000; $i++) {
                $validation = $sheet->getCell($colLetter . $i)->getDataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1($masterName.'!$C$2:$C$'.($masterItems->count() + 1));
            }
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_pegawai.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Import Excel data for Pegawai.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PegawaiImport, $request->file('excel_file'));

        return redirect()->route('pegawai.index')
            ->with('success', 'Data Pegawai berhasil diimpor.');
    }
}
