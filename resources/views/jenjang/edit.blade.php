@extends('layouts.app', ['title' => 'Edit Jenjang'])

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Data Jenjang</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk mengedit data jenjang.</p>
                
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

                <form method="POST" action="{{ route('jenjang.update', $jenjang->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Jenjang</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="{{ $jenjang->kode }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jenjang</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $jenjang->nama }}" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update Data</button>
                        <a href="{{ route('jenjang.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection