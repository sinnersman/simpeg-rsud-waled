@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Data Unit Kerja</h4>
                <p class="text-muted mb-3">Isi semua kolom yang diperlukan untuk mengedit data unit kerja.</p>
                
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

                <form method="POST" action="{{ route('unit_kerja.update', $unitKerja->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="induk_unit_kerja_id" class="form-label">Induk Unit Kerja</label>
                        <select class="form-select" id="induk_unit_kerja_id" name="induk_unit_kerja_id" required>
                            <option value="">Pilih Induk Unit Kerja</option>
                            @foreach ($indukUnitKerjas as $indukUnitKerja)
                                <option value="{{ $indukUnitKerja->id }}" {{ $unitKerja->induk_unit_kerja_id == $indukUnitKerja->id ? 'selected' : '' }}>{{ $indukUnitKerja->nama_induk_unit_kerja }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="{{ $unitKerja->kode }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_unit_kerja" class="form-label">Nama Unit Kerja</label>
                        <input type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" value="{{ $unitKerja->nama_unit_kerja }}" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update Data</button>
                        <a href="{{ route('unit_kerja.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection