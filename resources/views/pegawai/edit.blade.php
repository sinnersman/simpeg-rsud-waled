@extends('layouts.app')

@section('content')
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
                        
                        <button type="submit" class="btn btn-primary me-2">Update Data</button>
                                                <a href="{{ auth()->user()->role === 'pegawai' ? route('dashboard.index') : route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
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
</script>
<script>
    $(document).ready(function () {
        // Populate provinces on page load
        $.ajax({
            url: "{{ route('provinces') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                $('#provinsi').empty().append('<option value="">- Pilih Provinsi -</option>');
                $.each(data, function (key, value) {
                    $('#provinsi').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                // Pre-select existing province
                var existingProvince = "{{ old('provinsi', $pegawai->provinsi) }}";
                if (existingProvince) {
                    $('#provinsi').val(existingProvince).trigger('change');
                }
            }
        });

        // Handle province change
        $('#provinsi').on('change', function () {
            var provinceID = $(this).val();
            if (provinceID) {
                $.ajax({
                    url: "{{ route('cities') }}",
                    type: "GET",
                    data: { id: provinceID },
                    dataType: "json",
                    success: function (data) {
                        $('#kabupaten').empty().append('<option value="">- Pilih Kabupaten -</option>');
                        $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>');
                        $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
                        $.each(data, function (key, value) {
                            $('#kabupaten').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Pre-select existing city
                        var existingCity = "{{ old('kabupaten', $pegawai->kabupaten) }}";
                        if (existingCity) {
                            $('#kabupaten').val(existingCity).trigger('change');
                        }
                    }
                });
            } else {
                $('#kabupaten').empty().append('<option value="">- Pilih Kabupaten -</option>');
                $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>');
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
            }
        });

        // Handle city change
        $('#kabupaten').on('change', function () {
            var cityID = $(this).val();
            if (cityID) {
                $.ajax({
                    url: "{{ route('districts') }}",
                    type: "GET",
                    data: { id: cityID },
                    dataType: "json",
                    success: function (data) {
                        $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>');
                        $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
                        $.each(data, function (key, value) {
                            $('#kecamatan').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Pre-select existing district
                        var existingDistrict = "{{ old('kecamatan', $pegawai->kecamatan) }}";
                        if (existingDistrict) {
                            $('#kecamatan').val(existingDistrict).trigger('change');
                        }
                    }
                });
            } else {
                $('#kecamatan').empty().append('<option value="">- Pilih Kecamatan -</option>');
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
            }
        });

        // Handle district change
        $('#kecamatan').on('change', function () {
            var districtID = $(this).val();
            if (districtID) {
                $.ajax({
                    url: "{{ route('villages') }}",
                    type: "GET",
                    data: { id: districtID },
                    dataType: "json",
                    success: function (data) {
                        $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
                        $.each(data, function (key, value) {
                            $('#kelurahan').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Pre-select existing village
                        var existingVillage = "{{ old('kelurahan', $pegawai->kelurahan) }}";
                        if (existingVillage) {
                            $('#kelurahan').val(existingVillage).trigger('change');
                        }
                    }
                });
            } else {
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
            }
        });

        // Pre-select existing values for static dropdowns
        $('#jenis_kelamin').val("{{ old('jenis_kelamin', $pegawai->jenis_kelamin) }}");
        $('#agama').val("{{ old('agama', $pegawai->agama) }}");
        $('#golongan_darah').val("{{ old('golongan_darah', $pegawai->golongan_darah) }}");
        $('#status_perkawinan').val("{{ old('status_perkawinan', $pegawai->status_perkawinan) }}");
        $('#pendidikan_terakhir').val("{{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) }}");
        $('#status_kepegawaian').val("{{ old('status_kepegawaian', $pegawai->status_kepegawaian) }}");

    });
</script>
@endpush