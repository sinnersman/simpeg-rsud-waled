@extends('layouts.app', ['title' => 'Tambah Jabatan'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Data Jabatan</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk menambahkan data jabatan baru.</p>
                
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

                <form method="POST" action="{{ route('jabatan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_jabatan" class="form-label">Kode Jabatan</label>
                        <input type="text" class="form-control" id="kode_jabatan" name="kode_jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection