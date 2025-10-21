@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                <form method="POST" action="{{ route('dokumen-karyawan.store') }}" enctype="multipart/form-data">
                    @csrf

                    @if(auth()->user()->role === 'superadmin')
                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai</label>
                        <select class="form-select" id="pegawai_id" name="pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }} ({{ $pegawai->nip }})</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                        <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File</label>
                        <input class="form-control" type="file" id="file" name="file" required>
                        <small class="text-muted">File dapat berupa: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 2MB.</small>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <a href="{{ route('dokumen-karyawan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
