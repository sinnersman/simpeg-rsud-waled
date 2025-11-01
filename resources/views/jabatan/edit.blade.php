@extends('layouts.app', ['title' => 'Edit Jabatan'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Data Jabatan</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk mengedit data jabatan.</p>
                
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

                <form method="POST" action="{{ route('jabatan.update', $jabatan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kode_jabatan" class="form-label">Kode Jabatan</label>
                        <input type="text" class="form-control" id="kode_jabatan" name="kode_jabatan" value="{{ $jabatan->kode_jabatan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="{{ $jabatan->nama_jabatan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_jabatan_id" class="form-label">Jenis Jabatan</label>
                        <select class="form-select" id="jenis_jabatan_id" name="jenis_jabatan_id">
                            <option value="">Pilih Jenis Jabatan</option>
                            @foreach ($jenisJabatans as $jenisJabatan)
                                <option value="{{ $jenisJabatan->id }}" {{ $jabatan->jenis_jabatan_id == $jenisJabatan->id ? 'selected' : '' }}>{{ $jenisJabatan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenjang_id" class="form-label">Jenjang</label>
                        <select class="form-select" id="jenjang_id" name="jenjang_id">
                            <option value="">Pilih Jenjang</option>
                            @foreach ($jenjangs as $jenjang)
                                <option value="{{ $jenjang->id }}" {{ $jabatan->jenjang_id == $jenjang->id ? 'selected' : '' }}>{{ $jenjang->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="parent_jabatan_id" class="form-label">Atasan Langsung (Jabatan)</label>
                        <select class="form-select" id="parent_jabatan_id" name="parent_jabatan_id">
                            <option value="">Pilih Atasan Langsung</option>
                            @foreach ($jabatans as $parentJabatan)
                                <option value="{{ $parentJabatan->id }}" {{ $jabatan->parent_jabatan_id == $parentJabatan->id ? 'selected' : '' }}>{{ $parentJabatan->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update Data</button>
                        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection