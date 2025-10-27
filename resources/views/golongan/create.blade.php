@extends('layouts.app', ['title' => 'Tambah Golongan'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Data Golongan</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk menambahkan data golongan baru.</p>
                
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

                <form method="POST" action="{{ route('golongan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Golongan</label>
                        <input type="text" class="form-control" id="golongan" name="golongan" required>
                    </div>
                    <div class="mb-3">
                        <label for="pangkat" class="form-label">Pangkat</label>
                        <input type="text" class="form-control" id="pangkat" name="pangkat" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('golongan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
