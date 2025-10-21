@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                <form method="POST" action="{{ route('dokumen-karyawan.update', $dokumenKaryawan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if(auth()->user()->role === 'superadmin')
                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai</label>
                        <select class="form-select" id="pegawai_id" name="pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ $dokumenKaryawan->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->nama_lengkap }} ({{ $pegawai->nip }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                        <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" value="{{ $dokumenKaryawan->nama_dokumen }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File (Opsional)</label>
                        <input class="form-control" type="file" id="file" name="file">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah file. File saat ini: <a href="{{ Storage::url($dokumenKaryawan->file_path) }}" target="_blank">Lihat File</a></small>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Update</button>
                    <a href="{{ route('dokumen-karyawan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
