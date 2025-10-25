@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Pegawai: {{ $pegawai->nama_lengkap }}
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-primary btn-sm ms-2">Edit Pegawai</a>
                </h4>
                <p class="text-muted mb-3">Informasi lengkap mengenai pegawai dan riwayat jabatannya.</p>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="detail-tab" data-bs-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detail Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="riwayat-jabatan-tab" data-bs-toggle="tab" href="#riwayat-jabatan" role="tab" aria-controls="riwayat-jabatan" aria-selected="false">Riwayat Jabatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tambah-riwayat-jabatan-tab" data-bs-toggle="tab" href="#tambah-riwayat-jabatan" role="tab" aria-controls="tambah-riwayat-jabatan" aria-selected="false">Tambah Riwayat Jabatan</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $pegawai->foto_pegawai ? Storage::url($pegawai->foto_pegawai) : asset('assets/images/user/default.png') }}" class="img-fluid rounded" alt="Foto Pegawai">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr><th>NIP</th><td>{{ $pegawai->nip }}</td></tr>
                                    <tr><th>Nama Lengkap</th><td>{{ $pegawai->nama_lengkap }}</td></tr>
                                    <tr><th>Tempat, Tanggal Lahir</th><td>{{ $pegawai->tempat_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') }}</td></tr>
                                    <tr><th>Jenis Kelamin</th><td>{{ $pegawai->jenis_kelamin }}</td></tr>
                                    <tr><th>Agama</th><td>{{ $pegawai->agama }}</td></tr>
                                    <tr><th>Email</th><td>{{ $pegawai->email }}</td></tr>
                                    <tr><th>Handphone</th><td>{{ $pegawai->handphone }}</td></tr>
                                    <tr><th>Alamat</th><td>{{ $pegawai->alamat_lengkap }}, {{ $pegawai->kelurahan }}, {{ $pegawai->kecamatan }}, {{ $pegawai->kabupaten }}, {{ $pegawai->provinsi }}</td></tr>
                                    <!-- Add more details as needed -->
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="riwayat-jabatan" role="tabpanel" aria-labelledby="riwayat-jabatan-tab">
                        <h5 class="mb-3">Daftar Riwayat Jabatan</h5>
                        <div class="table-responsive">
                            <div class="table dataTable">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tambah-riwayat-jabatan" role="tabpanel" aria-labelledby="tambah-riwayat-jabatan-tab">
                        <h5 class="mb-3">Tambah Riwayat Jabatan Baru</h5>
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
                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
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
                                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/') }}assets/vendors/jquery/jquery.min.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net/dataTables.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
{{ $dataTable->scripts() }}
@endpush