@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Data Induk Unit Kerja</h4>
                <p class="text-muted mb-3">Berikut adalah daftar semua data induk unit kerja yang terdaftar.</p>
                <div class="text-end mb-3">
                    <a href="{{ route('induk_unit_kerja.create') }}" class="btn btn-primary">Tambah Induk Unit Kerja</a>
                    <a href="{{ route('induk_unit_kerja.trash') }}" class="btn btn-danger">Recycle Bin</a>
                </div>
                
                <div class="table dataTable">
                    {{ $dataTable->table() }}
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