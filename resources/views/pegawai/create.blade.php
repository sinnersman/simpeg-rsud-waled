@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Data Pegawai</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk menambahkan data pegawai baru.</p>
                
                <div class="table-responsive">
                    <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                        @csrf
                        
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
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nip_lama" class="form-label">NIP Lama</label>
                                <input type="text" class="form-control" id="nip_lama" name="nip_lama">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">*Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gelar_depan" class="form-label">Gelar Depan</label>
                                <input type="text" class="form-control" id="gelar_depan" name="gelar_depan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                                <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">*Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select" id="agama" name="agama">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen Protestan">Kristen Protestan</option>
                                    <option value="Kristen Katolik">Kristen Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                <select class="form-select" id="golongan_darah" name="golongan_darah">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                <select class="form-select" id="status_perkawinan" name="status_perkawinan">
                                    <option value="">Pilih Status Perkawinan</option>
                                    <option value="Single">Single</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
                                <select class="form-select" id="status_kepegawaian" name="status_kepegawaian">
                                    <option value="">Pilih Status Kepegawaian</option>
                                    <option value="ASN">ASN</option>
                                    <option value="PNS">PNS</option>
                                    <option value="PPPK">PPPK</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Honorer">Honorer</option>
                                </select>
                            </div>
                        </div>
                        
                        <h5 class="mb-3 mt-4">Data Alamat Pegawai</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="suku" class="form-label">Suku</label>
                                <input type="text" class="form-control" id="suku" name="suku">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kebangsaan" class="form-label">Kebangsaan</label>
                                <input type="text" class="form-control" id="kebangsaan" name="kebangsaan" value="Indonesia">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rt" class="form-label">RT</label>
                                <input type="text" class="form-control" id="rt" name="rt">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rw" class="form-label">RW</label>
                                <input type="text" class="form-control" id="rw" name="rw">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="kode_pos" name="kode_pos">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fax" class="form-label">Fax</label>
                                <input type="text" class="form-control" id="fax" name="fax">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Telephone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="handphone" class="form-label">Handphone</label>
                            <input type="text" class="form-control" id="handphone" name="handphone">
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
                        
                        <h5 class="mb-3 mt-4">Keterangan Badan</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                <input type="number" class="form-control" id="berat_badan" name="berat_badan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan">
                            </div>
                        </div>
                        
                        <h5 class="mb-3 mt-4">Keterangan Tambahan</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_karpeg" class="form-label">No. KARPEG</label>
                                <input type="text" class="form-control" id="no_karpeg" name="no_karpeg">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_askes_bpjs" class="form-label">No. ASKES / BPJS</label>
                                <input type="text" class="form-control" id="no_askes_bpjs" name="no_askes_bpjs">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_taspen" class="form-label">No. TASPEN</label>
                                <input type="text" class="form-control" id="no_taspen" name="no_taspen">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_karis_karsu" class="form-label">No. KARIS/KARSU</label>
                                <input type="text" class="form-control" id="no_karis_karsu" name="no_karis_karsu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_npwp" class="form-label">No. NPWP</label>
                                <input type="text" class="form-control" id="no_npwp" name="no_npwp">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_korpri" class="form-label">No. KORPRI</label>
                                <input type="text" class="form-control" id="no_korpri" name="no_korpri">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('foto_pegawai').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('preview_foto_pegawai');
            preview.innerHTML = `<img src="${URL.createObjectURL(file)}" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">`;
        }
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
                    }
                });
            } else {
                $('#kelurahan').empty().append('<option value="">- Pilih Kelurahan -</option>');
            }
        });
    });
</script>
@endpush