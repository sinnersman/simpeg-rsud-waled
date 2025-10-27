@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ session('info') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Data Pegawai</h4>
                <p class="text-muted mb-3">Ubah semua kolom yang diperlukan untuk memperbarui data pegawai.</p>
                
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Data Diri Pegawai</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Data Alamat Pegawai</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Keterangan Badan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Keterangan Tambahan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="riwayat-jabatan-tab" data-bs-toggle="tab" data-bs-target="#riwayat-jabatan" type="button" role="tab" aria-controls="riwayat-jabatan" aria-selected="false">Riwayat Jabatan</button>
                    </li>
                    @if(auth()->user()->role === 'pegawai')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">Riwayat Pengajuan Perubahan</button>
                    </li>
                    @endif
                </ul>

                <form method="POST" action="{{ auth()->user()->role === 'pegawai' ? route('pegawai.myBiodataUpdate') : route('pegawai.update', $pegawai->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="tab-content" id="myTabContent">
                        {{-- Data Diri Pegawai Tab --}}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            {{-- Foto Pegawai --}}
                            <div class="mb-3">
                                <label for="foto_pegawai" class="form-label">Foto Pegawai</label>
                                <input class="form-control" type="file" id="foto_pegawai" name="foto_pegawai">
                                <small class="text-muted">Preview Gambar</small>
                                <div id="preview_foto_pegawai" class="mt-2">
                                    {{-- Image preview will be displayed here --}}
                                </div>
                            </div>
                            
                            <h5 class="mb-3 mt-4">Data Diri Pegawai</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nip" class="form-label">*NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $pegawai->nip) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nip_lama" class="form-label">NIP Lama</label>
                                    <input type="text" class="form-control" id="nip_lama" name="nip_lama" value="{{ old('nip_lama', $pegawai->nip_lama) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label">*Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                    <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="{{ old('nama_panggilan', $pegawai->nama_panggilan) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gelar_depan" class="form-label">Gelar Depan</label>
                                    <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" value="{{ old('gelar_depan', $pegawai->gelar_depan) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                                    <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang', $pegawai->gelar_belakang) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">*Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <select class="form-select" id="agama" name="agama">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama', $pegawai->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen Protestan" {{ old('agama', $pegawai->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                        <option value="Kristen Katolik" {{ old('agama', $pegawai->agama) == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                        <option value="Hindu" {{ old('agama', $pegawai->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama', $pegawai->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama', $pegawai->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                    <select class="form-select" id="golongan_darah" name="golongan_darah">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A" {{ old('golongan_darah', $pegawai->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('golongan_darah', $pegawai->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('golongan_darah', $pegawai->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('golongan_darah', $pegawai->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                    <select class="form-select" id="status_perkawinan" name="status_perkawinan">
                                        <option value="">Pilih Status Perkawinan</option>
                                        <option value="Single" {{ old('status_perkawinan', $pegawai->status_perkawinan) == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Menikah" {{ old('status_perkawinan', $pegawai->status_perkawinan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                        <option value="Cerai Hidup" {{ old('status_perkawinan', $pegawai->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_perkawinan', $pegawai->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                    <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                        <option value="">Pilih Pendidikan Terakhir</option>
                                        <option value="SD" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="D1" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'D1' ? 'selected' : '' }}>D1</option>
                                        <option value="D2" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'D2' ? 'selected' : '' }}>D2</option>
                                        <option value="D3" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="D4" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'D4' ? 'selected' : '' }}>D4</option>
                                        <option value="S1" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
                                    <select class="form-select" id="status_kepegawaian" name="status_kepegawaian">
                                        <option value="">Pilih Status Kepegawaian</option>
                                        <option value="ASN" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'ASN' ? 'selected' : '' }}>ASN</option>
                                        <option value="PNS" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="PPPK" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                        <option value="Kontrak" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                        <option value="Honorer" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jabatan_id" class="form-label">Jabatan</label>
                                    <select class="form-select" id="jabatan_id" name="jabatan_id">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}" {{ old('jabatan_id', $pegawai->jabatan_id) == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_jabatan_id" class="form-label">Jenis Jabatan</label>
                                    <select class="form-select" id="jenis_jabatan_id" name="jenis_jabatan_id">
                                        <option value="">Pilih Jenis Jabatan</option>
                                        @foreach ($jenisJabatans as $jenisJabatan)
                                            <option value="{{ $jenisJabatan->id }}" {{ old('jenis_jabatan_id', $pegawai->jenis_jabatan_id) == $jenisJabatan->id ? 'selected' : '' }}>{{ $jenisJabatan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenjang_id" class="form-label">Jenjang</label>
                                    <select class="form-select" id="jenjang_id" name="jenjang_id">
                                        <option value="">Pilih Jenjang</option>
                                        @foreach ($jenjangs as $jenjang)
                                            <option value="{{ $jenjang->id }}" {{ old('jenjang_id', $pegawai->jenjang_id) == $jenjang->id ? 'selected' : '' }}>{{ $jenjang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="golongan_id" class="form-label">Golongan</label>
                                    <select class="form-select" id="golongan_id" name="golongan_id">
                                        <option value="">Pilih Golongan</option>
                                        @foreach ($golongans as $golongan)
                                            <option value="{{ $golongan->id }}" {{ old('golongan_id', $pegawai->golongan_id) == $golongan->id ? 'selected' : '' }}>{{ $golongan->golongan }} - {{ $golongan->pangkat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="unit_kerja_id" class="form-label">Unit Kerja</label>
                                    <select class="form-select" id="unit_kerja_id" name="unit_kerja_id">
                                        <option value="">Pilih Unit Kerja</option>
                                        @foreach ($unitKerjas as $unitKerja)
                                            <option value="{{ $unitKerja->id }}" {{ old('unit_kerja_id', $pegawai->unit_kerja_id) == $unitKerja->id ? 'selected' : '' }}>{{ $unitKerja->nama_unit_kerja }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="induk_unit_kerja_id" class="form-label">Induk Unit Kerja</label>
                                    <select class="form-select" id="induk_unit_kerja_id" name="induk_unit_kerja_id">
                                        <option value="">Pilih Induk Unit Kerja</option>
                                        @foreach ($indukUnitKerjas as $indukUnitKerja)
                                            <option value="{{ $indukUnitKerja->id }}" {{ old('induk_unit_kerja_id', $pegawai->induk_unit_kerja_id) == $indukUnitKerja->id ? 'selected' : '' }}>{{ $indukUnitKerja->nama_induk_unit_kerja }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Data Alamat Pegawai Tab --}}
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <h5 class="mb-3 mt-4">Data Alamat Pegawai</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="suku" class="form-label">Suku</label>
                                    <input type="text" class="form-control" id="suku" name="suku" value="{{ old('suku', $pegawai->suku) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kebangsaan" class="form-label">Kebangsaan</label>
                                    <input type="text" class="form-control" id="kebangsaan" name="kebangsaan" value="{{ old('kebangsaan', $pegawai->kebangsaan) }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3">{{ old('alamat_lengkap', $pegawai->alamat_lengkap) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rt" class="form-label">RT</label>
                                    <input type="text" class="form-control" id="rt" name="rt" value="{{ old('rt', $pegawai->rt) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rw" class="form-label">RW</label>
                                    <input type="text" class="form-control" id="rw" name="rw" value="{{ old('rw', $pegawai->rw) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $pegawai->kode_pos) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $pegawai->email) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fax" class="form-label">Fax</label>
                                    <input type="text" class="form-control" id="fax" name="fax" value="{{ old('fax', $pegawai->fax) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telephone" class="form-label">Telephone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $pegawai->telephone) }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="handphone" class="form-label">Handphone</label>
                                <input type="text" class="form-control" id="handphone" name="handphone" value="{{ old('handphone', $pegawai->handphone) }}">
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select class="form-select" id="provinsi" name="provinsi">
                                        <option value="">- Pilih Provinsi -</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten</label>
                                    <select class="form-select" id="kabupaten" name="kabupaten">
                                        <option value="">- Pilih Kabupaten -</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select class="form-select" id="kecamatan" name="kecamatan">
                                        <option value="">- Pilih Kecamatan -</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <select class="form-select" id="kelurahan" name="kelurahan">
                                        <option value="">- Pilih Kelurahan -</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Keterangan Badan Tab --}}
                        <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                            <h5 class="mb-3 mt-4">Keterangan Badan</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                    <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan', $pegawai->berat_badan) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                    <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan', $pegawai->tinggi_badan) }}">
                                </div>
                            </div>
                        </div>
                        
                        {{-- Keterangan Tambahan Tab --}}
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <h5 class="mb-3 mt-4">Keterangan Tambahan</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_karpeg" class="form-label">No. KARPEG</label>
                                    <input type="text" class="form-control" id="no_karpeg" name="no_karpeg" value="{{ old('no_karpeg', $pegawai->no_karpeg) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_askes_bpjs" class="form-label">No. ASKES / BPJS</label>
                                    <input type="text" class="form-control" id="no_askes_bpjs" name="no_askes_bpjs" value="{{ old('no_askes_bpjs', $pegawai->no_askes_bpjs) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_taspen" class="form-label">No. TASPEN</label>
                                    <input type="text" class="form-control" id="no_taspen" name="no_taspen" value="{{ old('no_taspen', $pegawai->no_taspen) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_karis_karsu" class="form-label">No. KARIS/KARSU</label>
                                    <input type="text" class="form-control" id="no_karis_karsu" name="no_karis_karsu" value="{{ old('no_karis_karsu', $pegawai->no_karis_karsu) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_npwp" class="form-label">No. NPWP</label>
                                    <input type="text" class="form-control" id="no_npwp" name="no_npwp" value="{{ old('no_npwp', $pegawai->no_npwp) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_korpri" class="form-label">No. KORPRI</label>
                                    <input type="text" class="form-control" id="no_korpri" name="no_korpri" value="{{ old('no_korpri', $pegawai->no_korpri) }}">
                                </div>
                            </div>
                        </div>
                        {{-- Riwayat Jabatan Tab --}}
                        <div class="tab-pane fade" id="riwayat-jabatan" role="tabpanel" aria-labelledby="riwayat-jabatan-tab">
                            <h5 class="mb-3 mt-4">Riwayat Jabatan Pegawai</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Jabatan</th>
                                            <th>Jenis Jabatan</th>
                                            <th>Jenjang</th>
                                            <th>Golongan</th>
                                            <th>Unit Kerja</th>
                                            <th>Induk Unit Kerja</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                            <th>No. SK</th>
                                            <th>Pejabat Penetap</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pegawai->riwayatJabatan as $riwayat)
                                            <tr>
                                                <td>{{ $riwayat->jabatan->nama_jabatan ?? '-' }}</td>
                                                <td>{{ $riwayat->jenisJabatan->nama ?? '-' }}</td>
                                                <td>{{ $riwayat->jenjang->nama ?? '-' }}</td>
                                                <td>{{ ($riwayat->golongan->golongan ?? '-') . ' - ' . ($riwayat->golongan->pangkat ?? '-') }}</td>
                                                <td>{{ $riwayat->unitKerja->nama_unit_kerja ?? '-' }}</td>
                                                <td>{{ $riwayat->indukUnitKerja->nama_induk_unit_kerja ?? '-' }}</td>
                                                <td>{{ $riwayat->tanggal_masuk ? \Carbon\Carbon::parse($riwayat->tanggal_masuk)->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $riwayat->tanggal_keluar ? \Carbon\Carbon::parse($riwayat->tanggal_keluar)->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $riwayat->no_sk ?? '-' }}</td>
                                                <td>{{ $riwayat->pejabat_penetap ?? '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm edit-riwayat-jabatan"
                                                            data-bs-toggle="modal" data-bs-target="#editRiwayatJabatanModal"
                                                            data-id="{{ $riwayat->id }}"
                                                            data-jabatan_id="{{ $riwayat->jabatan_id }}"
                                                            data-jenis_jabatan_id="{{ $riwayat->jenis_jabatan_id }}"
                                                            data-jenjang_id="{{ $riwayat->jenjang_id }}"
                                                            data-golongan_id="{{ $riwayat->golongan_id }}"
                                                            data-unit_kerja_id="{{ $riwayat->unit_kerja_id }}"
                                                            data-induk_unit_kerja_id="{{ $riwayat->induk_unit_kerja_id }}"
                                                            data-tanggal_masuk="{{ $riwayat->tanggal_masuk ? \Carbon\Carbon::parse($riwayat->tanggal_masuk)->format('Y-m-d') : '' }}"
                                                            data-tanggal_keluar="{{ $riwayat->tanggal_keluar ? \Carbon\Carbon::parse($riwayat->tanggal_keluar)->format('Y-m-d') : '' }}"
                                                            data-no_sk="{{ $riwayat->no_sk }}"
                                                            data-tanggal_sk="{{ $riwayat->tanggal_sk ? \Carbon\Carbon::parse($riwayat->tanggal_sk)->format('Y-m-d') : '' }}"
                                                            data-pejabat_penetap="{{ $riwayat->pejabat_penetap }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('pegawai.destroyRiwayatJabatan', ['pegawai' => $pegawai->id, 'riwayat_jabatan' => $riwayat->id]) }}" method="POST" style="display:inline-block;" id="deleteRiwayatJabatanForm_{{ $riwayat->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-riwayat-jabatan-btn" data-id="{{ $riwayat->id }}">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada riwayat jabatan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        @if(auth()->user()->role === 'pegawai')
                        {{-- Riwayat Pengajuan Perubahan Tab --}}
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <h5 class="mb-3 mt-4">Riwayat Pengajuan Perubahan Biodata</h5>
                            <div class="table-responsive">
                                <div class="table dataTable">
                                    {{ $dataTable->table() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <button type="submit" class="btn btn-primary me-2">Update Data</button>
                        <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#promotionDemotionModal">Promosi / Demosi</button>
                        <a href="{{ auth()->user()->role === 'pegawai' ? route('dashboard.index') : route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Promotion/Demotion Modal -->
<div class="modal fade" id="promotionDemotionModal" tabindex="-1" aria-labelledby="promotionDemotionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promotionDemotionModalLabel">Promosi / Demosi Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('pegawai.updateJabatan', $pegawai->id) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_jabatan_id" class="form-label">Jabatan Baru</label>
                            <select class="form-select" id="new_jabatan_id" name="new_jabatan_id" data-placeholder="Pilih Jabatan Baru">
                                <option value="">Pilih Jabatan Baru</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_jenis_jabatan_id" class="form-label">Jenis Jabatan Baru</label>
                            <select class="form-select" id="new_jenis_jabatan_id" name="new_jenis_jabatan_id" data-placeholder="Pilih Jenis Jabatan Baru">
                                <option value="">Pilih Jenis Jabatan Baru</option>
                                @foreach ($jenisJabatans as $jenisJabatan)
                                    <option value="{{ $jenisJabatan->id }}">{{ $jenisJabatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_jenjang_id" class="form-label">Jenjang Baru</label>
                            <select class="form-select" id="new_jenjang_id" name="new_jenjang_id" data-placeholder="Pilih Jenjang Baru">
                                <option value="">Pilih Jenjang Baru</option>
                                @foreach ($jenjangs as $jenjang)
                                    <option value="{{ $jenjang->id }}">{{ $jenjang->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_golongan_id" class="form-label">Golongan Baru</label>
                            <select class="form-select" id="new_golongan_id" name="new_golongan_id" data-placeholder="Pilih Golongan Baru">
                                <option value="">Pilih Golongan Baru</option>
                                @foreach ($golongans as $golongan)
                                    <option value="{{ $golongan->id }}">{{ $golongan->golongan }} - {{ $golongan->pangkat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_unit_kerja_id" class="form-label">Unit Kerja Baru</label>
                            <select class="form-select" id="new_unit_kerja_id" name="new_unit_kerja_id" data-placeholder="Pilih Unit Kerja Baru">
                                <option value="">Pilih Unit Kerja Baru</option>
                                @foreach ($unitKerjas as $unitKerja)
                                    <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama_unit_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_induk_unit_kerja_id" class="form-label">Induk Unit Kerja Baru</label>
                            <select class="form-select" id="new_induk_unit_kerja_id" name="new_induk_unit_kerja_id" data-placeholder="Pilih Induk Unit Kerja Baru">
                                <option value="">Pilih Induk Unit Kerja Baru</option>
                                @foreach ($indukUnitKerjas as $indukUnitKerja)
                                    <option value="{{ $indukUnitKerja->id }}">{{ $indukUnitKerja->nama_induk_unit_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_masuk_baru" class="form-label">Tanggal Mulai Jabatan Baru</label>
                        <input type="date" class="form-control" id="tanggal_masuk_baru" name="tanggal_masuk_baru" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_tanggal_keluar" class="form-label">Tanggal Selesai Jabatan (Opsional)</label>
                        <input type="date" class="form-control" id="new_tanggal_keluar" name="new_tanggal_keluar">
                    </div>
                    <div class="mb-3">
                        <label for="no_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="no_sk" name="no_sk">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_sk" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="tanggal_sk" name="tanggal_sk">
                    </div>
                    <div class="mb-3">
                        <label for="pejabat_penetap" class="form-label">Pejabat Penetap</label>
                        <input type="text" class="form-control" id="pejabat_penetap" name="pejabat_penetap">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan Jabatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Riwayat Jabatan Modal -->
<div class="modal fade" id="editRiwayatJabatanModal" tabindex="-1" aria-labelledby="editRiwayatJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRiwayatJabatanModalLabel">Edit Riwayat Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editRiwayatJabatanForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="riwayat_jabatan_id" id="edit_riwayat_jabatan_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_jabatan_id" class="form-label">Jabatan</label>
                            <select class="form-select" id="edit_jabatan_id" name="jabatan_id" data-placeholder="Pilih Jabatan">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_jenis_jabatan_id" class="form-label">Jenis Jabatan</label>
                            <select class="form-select" id="edit_jenis_jabatan_id" name="jenis_jabatan_id" data-placeholder="Pilih Jenis Jabatan">
                                <option value="">Pilih Jenis Jabatan</option>
                                @foreach ($jenisJabatans as $jenisJabatan)
                                    <option value="{{ $jenisJabatan->id }}">{{ $jenisJabatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_jenjang_id" class="form-label">Jenjang</label>
                            <select class="form-select" id="edit_jenjang_id" name="jenjang_id" data-placeholder="Pilih Jenjang">
                                <option value="">Pilih Jenjang</option>
                                @foreach ($jenjangs as $jenjang)
                                    <option value="{{ $jenjang->id }}">{{ $jenjang->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_golongan_id" class="form-label">Golongan</label>
                            <select class="form-select" id="edit_golongan_id" name="golongan_id" data-placeholder="Pilih Golongan">
                                <option value="">Pilih Golongan</option>
                                @foreach ($golongans as $golongan)
                                    <option value="{{ $golongan->id }}">{{ $golongan->golongan }} - {{ $golongan->pangkat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_unit_kerja_id" class="form-label">Unit Kerja</label>
                            <select class="form-select" id="edit_unit_kerja_id" name="unit_kerja_id" data-placeholder="Pilih Unit Kerja">
                                <option value="">Pilih Unit Kerja</option>
                                @foreach ($unitKerjas as $unitKerja)
                                    <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama_unit_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_induk_unit_kerja_id" class="form-label">Induk Unit Kerja</label>
                            <select class="form-select" id="edit_induk_unit_kerja_id" name="induk_unit_kerja_id" data-placeholder="Pilih Induk Unit Kerja">
                                <option value="">Pilih Induk Unit Kerja</option>
                                @foreach ($indukUnitKerjas as $indukUnitKerja)
                                    <option value="{{ $indukUnitKerja->id }}">{{ $indukUnitKerja->nama_induk_unit_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="edit_tanggal_masuk" name="tanggal_masuk" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="edit_tanggal_keluar" name="tanggal_keluar">
                    </div>
                    <div class="mb-3">
                        <label for="edit_no_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="edit_no_sk" name="no_sk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_sk" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="edit_tanggal_sk" name="tanggal_sk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_pejabat_penetap" class="form-label">Pejabat Penetap</label>
                        <input type="text" class="form-control" id="edit_pejabat_penetap" name="pejabat_penetap">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Riwayat Jabatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Reason Modal -->
<div class="modal fade" id="rejectionReasonModal" tabindex="-1" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionReasonModalLabel">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalRejectionReason"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .tab-pane { display: none; }
    .tab-pane.active.show { display: block; }
    .tab-content { min-height: auto !important; }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/') }}assets/vendors/jquery/jquery.min.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net/dataTables.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>

{{-- Explicitly load Select2 JS here to ensure it's available --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoPegawaiInput = document.getElementById('foto_pegawai');
        const previewFotoPegawai = document.getElementById('preview_foto_pegawai');

        // Function to update the image preview
        function updateImagePreview(src) {
            if (src) {
                previewFotoPegawai.innerHTML = `<img src="${src}" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">`;
            } else {
                previewFotoPegawai.innerHTML = ''; // Clear preview if no src
            }
        }

        // Display existing image on load
        @if ($pegawai->foto_pegawai)
            updateImagePreview("{{ Storage::url($pegawai->foto_pegawai) }}");
        @endif

        // Handle new image selection
        fotoPegawaiInput.addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                updateImagePreview(URL.createObjectURL(file));
            } else {
                // If no new file selected, revert to existing photo or clear
                @if ($pegawai->foto_pegawai)
                    updateImagePreview("{{ Storage::url($pegawai->foto_pegawai) }}");
                @else
                    updateImagePreview(null);
                @endif
            }
        });
    });

    $(document).ready(function () {
        // Allow Select2 search input to be typeable in Bootstrap modals
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
        // Initialize Select2 for all relevant dropdowns on the main page
        $('#provinsi, #kabupaten, #kecamatan, #kelurahan, #jenis_kelamin, #agama, #golongan_darah, #status_perkawinan, #pendidikan_terakhir, #status_kepegawaian, #jabatan_id, #jenis_jabatan_id, #jenjang_id, #golongan_id, #unit_kerja_id, #induk_unit_kerja_id').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        });

        // Initialize Select2 for dropdowns inside the modal when the modal is shown
        $('#promotionDemotionModal').on('shown.bs.modal', function () {
            $('#new_jabatan_id, #new_jenis_jabatan_id, #new_jenjang_id, #new_golongan_id, #new_unit_kerja_id, #new_induk_unit_kerja_id').each(function() {
                $(this).select2({
                    theme: "bootstrap-5",
                    width: '100%', // Set a fixed width for consistency
                    placeholder: "Pilih...", // Generic placeholder
                    allowClear: true, // Allows clearing the selection
                    minimumResultsForSearch: 0, // Always show search input
                    dropdownParent: $('#promotionDemotionModal') // Append dropdown to the modal
                }).on('select2:open', function (e) {
                    // Ensure the search input within Select2 gets focus
                    $('.select2-search__field').focus();
                });
            });
        });

        // Function to load cities based on province
        function loadCities(provinceID, existingCity = null) {
            return $.ajax({
                url: "{{ route('cities') }}",
                type: "GET",
                data: { id: provinceID },
                dataType: "json",
                success: function (data) {
                    $('#kabupaten').empty().append('<option value="">- Pilih Kabupaten -</option>');
                    $.each(data, function (key, value) {
                        $('#kabupaten').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    if (existingCity) {
                        $('#kabupaten').val(existingCity);
                    }
                    $('#kabupaten').trigger('change.select2');
                }
            });
        }

        // Function to load districts based on city
        function loadDistricts(cityID, existingDistrict = null) {
            return $.ajax({
                url: "{{ route('districts') }}",
                type: "GET",
                data: { id: cityID },
                dataType: "json",
                success: function (data) {
                    $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>');
                    $.each(data, function (key, value) {
                        $('#kecamatan').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    if (existingDistrict) {
                        $('#kecamatan').val(existingDistrict);
                    }
                    $('#kecamatan').trigger('change.select2');
                }
            });
        }

        // Function to load villages based on district
        function loadVillages(districtID, existingVillage = null) {
            return $.ajax({
                url: "{{ route('villages') }}",
                type: "GET",
                data: { id: districtID },
                dataType: "json",
                success: function (data) {
                    $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
                    $.each(data, function (key, value) {
                        $('#kelurahan').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    if (existingVillage) {
                        $('#kelurahan').val(existingVillage);
                    }
                    $('#kelurahan').trigger('change.select2');
                }
            });
        }

        // Initial load for provinces and cascading selection
        $.ajax({
            url: "{{ route('provinces') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                $('#provinsi').empty().append('<option value="">- Pilih Provinsi -</option>');
                $.each(data, function (key, value) {
                    $('#provinsi').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                var selectedProvinceId = "{{ $selectedProvinceId }}"; // Use the ID from the controller
                if (selectedProvinceId) {
                    $('#provinsi').val(selectedProvinceId);
                    $('#provinsi').trigger('change.select2'); // Trigger Select2 update
                    
                    // Chain the next AJAX call
                    loadCities(selectedProvinceId, "{{ $selectedCityId }}") // Pass ID for city
                        .done(function() {
                            var selectedCityId = "{{ $selectedCityId }}";
                            if (selectedCityId) {
                                loadDistricts(selectedCityId, "{{ $selectedDistrictId }}") // Pass ID for district
                                    .done(function() {
                                        var selectedDistrictId = "{{ $selectedDistrictId }}";
                                        if (selectedDistrictId) {
                                            loadVillages(selectedDistrictId, "{{ $selectedVillageId }}"); // Pass ID for village
                                        }
                                    });
                            }
                        });
                } else {
                    $('#provinsi').trigger('change.select2'); // Trigger Select2 update even if no existing province
                }
            }
        });

        // Event listeners for changes
        $('#provinsi').on('change', function () {
            var provinceID = $(this).val();
            if (provinceID) {
                loadCities(provinceID);
            } else {
                $('#kabupaten').empty().append('<option value="">- Pilih Kabupaten -</option>').trigger('change.select2');
                $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>').trigger('change.select2');
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>').trigger('change.select2');
            }
        });

        $('#kabupaten').on('change', function () {
            var cityID = $(this).val();
            if (cityID) {
                loadDistricts(cityID);
            } else {
                $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>').trigger('change.select2');
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>').trigger('change.select2');
            }
        });

        $('#kecamatan').on('change', function () {
            var districtID = $(this).val();
            if (districtID) {
                loadVillages(districtID);
            } else {
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>').trigger('change.select2');
            }
        });

        // Pre-select existing values for static dropdowns and trigger Select2 update
        $('#jenis_kelamin').val("{{ old('jenis_kelamin', $pegawai->jenis_kelamin) }}").trigger('change.select2');
        $('#agama').val("{{ old('agama', $pegawai->agama) }}").trigger('change.select2');
        $('#golongan_darah').val("{{ old('golongan_darah', $pegawai->golongan_darah) }}").trigger('change.select2');
        $('#status_perkawinan').val("{{ old('status_perkawinan', $pegawai->status_perkawinan) }}").trigger('change.select2');
        $('#pendidikan_terakhir').val("{{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) }}").trigger('change.select2');
        $('#status_kepegawaian').val("{{ old('status_kepegawaian', $pegawai->status_kepegawaian) }}").trigger('change.select2');

        // Handle Edit Riwayat Jabatan Modal
        $('#editRiwayatJabatanModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var riwayatId = button.data('id');
            var jabatanId = button.data('jabatan_id');
            var jenisJabatanId = button.data('jenis_jabatan_id');
            var jenjangId = button.data('jenjang_id');
            var golonganId = button.data('golongan_id');
            var unitKerjaId = button.data('unit_kerja_id');
            var indukUnitKerjaId = button.data('induk_unit_kerja_id');
            var tanggalMasuk = button.data('tanggal_masuk');
            var tanggalKeluar = button.data('tanggal_keluar');
            var noSk = button.data('no_sk');
            var tanggalSk = button.data('tanggal_sk');
            var pejabatPenetap = button.data('pejabat_penetap');

            var modal = $(this);
            modal.find('#edit_riwayat_jabatan_id').val(riwayatId);
            modal.find('#edit_tanggal_masuk').val(tanggalMasuk);
            modal.find('#edit_tanggal_keluar').val(tanggalKeluar);
            modal.find('#edit_no_sk').val(noSk);
            modal.find('#edit_tanggal_sk').val(tanggalSk);
            modal.find('#edit_pejabat_penetap').val(pejabatPenetap);

            // Set form action
            var form = modal.find('#editRiwayatJabatanForm');
            form.attr('action', '{{ route('pegawai.updateRiwayatJabatan', ['pegawai' => $pegawai->id, 'riwayat_jabatan' => ':riwayat_jabatan_id']) }}'.replace(':riwayat_jabatan_id', riwayatId));

            // Initialize Select2 for modal dropdowns and set selected values
            modal.find('#edit_jabatan_id').val(jabatanId).trigger('change');
            modal.find('#edit_jenis_jabatan_id').val(jenisJabatanId).trigger('change');
            modal.find('#edit_jenjang_id').val(jenjangId).trigger('change');
            modal.find('#edit_golongan_id').val(golonganId).trigger('change');
            modal.find('#edit_unit_kerja_id').val(unitKerjaId).trigger('change');
            modal.find('#edit_induk_unit_kerja_id').val(indukUnitKerjaId).trigger('change');

            // Re-initialize select2 for the modal dropdowns
            modal.find('#edit_jabatan_id, #edit_jenis_jabatan_id, #edit_jenjang_id, #edit_golongan_id, #edit_unit_kerja_id, #edit_induk_unit_kerja_id').each(function() {
                $(this).select2({
                    theme: "bootstrap-5",
                    width: '100%',
                    placeholder: $(this).data('placeholder'),
                    allowClear: true,
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editRiwayatJabatanModal')
                }).on('select2:open', function (e) {
                    $('.select2-search__field').focus();
                });
            });
        });

        $('#rejectionReasonModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var reason = button.data('reason'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#modalRejectionReason').text(reason);
        });

        // Handle delete confirmation with SweetAlert2
        $(document).on('click', '.delete-riwayat-jabatan-btn', function (e) {
            e.preventDefault();
            var riwayatId = $(this).data('id');
            var form = $('#deleteRiwayatJabatanForm_' + riwayatId);

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@if(auth()->user()->role === 'pegawai')
{{ $dataTable->scripts() }}
@endif
@endpush