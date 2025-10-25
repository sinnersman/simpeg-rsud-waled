@extends('layouts.app', ['title' => 'Tambah Jenis Jabatan'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Data Jenis Jabatan</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk menambahkan data jenis jabatan baru.</p>
                
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

                <form method="POST" action="{{ route('jenis_jabatan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Jenis Jabatan</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="{{ old('kode') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jenis Jabatan</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('jenis_jabatan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection