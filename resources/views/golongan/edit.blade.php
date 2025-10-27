@extends('layouts.app', ['title' => 'Edit Golongan'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Data Golongan</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk mengedit data golongan.</p>
                
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

                <form method="POST" action="{{ route('golongan.update', $golongan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="{{ $golongan->kode }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Golongan</label>
                        <input type="text" class="form-control" id="golongan" name="golongan" value="{{ $golongan->golongan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="pangkat" class="form-label">Pangkat</label>
                        <input type="text" class="form-control" id="pangkat" name="pangkat" value="{{ $golongan->pangkat }}" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update Data</button>
                        <a href="{{ route('golongan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
