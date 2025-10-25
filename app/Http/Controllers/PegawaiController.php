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

        return view('pegawai.edit', compact(
            'pegawai',
            'title',
            'breadcrumbs',
            'dataTable',
            'selectedProvinceId',
            'selectedCityId',
            'selectedDistrictId',
            'selectedVillageId'
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

        // Convert stored names to IDs for pre-selection in dropdowns
        $selectedProvinceId = null;
        $selectedCityId = null;
        $selectedDistrictId = null;
        $selectedVillageId = null;

        if ($pegawai->provinsi) {
            $provinceName = trim($pegawai->provinsi);
            $province = Province::whereRaw('LOWER(name) = ?', [strtolower($provinceName)])->first();
            if ($province) {
                $selectedProvinceId = $province->id;

                if ($pegawai->kabupaten) {
                    $cityName = trim($pegawai->kabupaten);
                    $city = City::where('province_code', $selectedProvinceId) // Changed from province_id to province_code
                                ->whereRaw('LOWER(name) = ?', [strtolower($cityName)])
                                ->first();
                    if ($city) {
                        $selectedCityId = $city->id;

                        if ($pegawai->kecamatan) {
                            $districtName = trim($pegawai->kecamatan);
                            $district = District::where('city_code', $selectedCityId) // Changed from city_id to city_code
                                                ->whereRaw('LOWER(name) = ?', [strtolower($districtName)])
                                                ->first();
                            if ($district) {
                                $selectedDistrictId = $district->id;

                                if ($pegawai->kelurahan) {
                                    $villageName = trim($pegawai->kelurahan);
                                    $village = Village::where('district_code', $selectedDistrictId) // Changed from district_id to district_code
                                                    ->whereRaw('LOWER(name) = ?', [strtolower($villageName)])
                                                    ->first();
                                    if ($village) {
                                        $selectedVillageId = $village->id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $dataTable->render('pegawai.edit', compact(
            'pegawai',
            'title',
            'breadcrumbs',
            'selectedProvinceId',
            'selectedCityId',
            'selectedDistrictId',
            'selectedVillageId'
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
}
