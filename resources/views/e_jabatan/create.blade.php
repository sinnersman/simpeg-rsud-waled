@extends('layouts.app', ['title' => 'Tambah Riwayat Jabatan'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Riwayat Jabatan Pegawai</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk menambahkan riwayat jabatan baru.</p>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('e-jabatan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai</label>
                        <select class="form-control" id="pegawai_id" name="pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan_id" class="form-label">Jabatan</label>
                        <select class="form-control" id="jabatan_id" name="jabatan_id" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="induk_unit_kerja_id" class="form-label">Induk Unit Kerja</label>
                        <select class="form-control" id="induk_unit_kerja_id" name="induk_unit_kerja_id" required>
                            <option value="">Pilih Induk Unit Kerja</option>
                            @foreach($indukUnitKerja as $iuk)
                                <option value="{{ $iuk->id }}">{{ $iuk->nama_induk_unit_kerja }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_kerja_id" class="form-label">Unit Kerja</label>
                        <select class="form-control" id="unit_kerja_id" name="unit_kerja_id" required>
                            <option value="">Pilih Unit Kerja</option>
                            @foreach($unitKerja as $uk)
                                <option value="{{ $uk->id }}">{{ $uk->nama_unit_kerja }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_jabatan" class="form-label">Jenis Jabatan</label>
                        <input type="text" class="form-control" id="jenis_jabatan" name="jenis_jabatan">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk">
                    </div>
                    <div class="mb-3">
                        <label for="tmt" class="form-label">TMT</label>
                        <input type="date" class="form-control" id="tmt" name="tmt">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pns" class="form-label">Jenis PNS</label>
                        <input type="text" class="form-control" id="jenis_pns" name="jenis_pns">
                    </div>
                    <div class="mb-3">
                        <label for="no_sk" class="form-label">No SK</label>
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
                    <div class="mb-3">
                        <label for="status_sumpah" class="form-label">Status Sumpah</label>
                        <input type="text" class="form-control" id="status_sumpah" name="status_sumpah">
                    </div>
                    <div class="mb-3">
                        <label for="no_pelantikan" class="form-label">No Pelantikan</label>
                        <input type="text" class="form-control" id="no_pelantikan" name="no_pelantikan">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pelantikan" class="form-label">Tanggal Pelantikan</label>
                        <input type="date" class="form-control" id="tanggal_pelantikan" name="tanggal_pelantikan">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('e-jabatan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection