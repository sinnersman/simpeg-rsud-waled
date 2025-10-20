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
                <h4 class="card-title">Recycle Bin Unit Kerja</h4>
                <p class="text-muted mb-3">Berikut adalah daftar semua data unit kerja yang telah dihapus.</p>
                <a href="{{ route('unit_kerja.index') }}" class="btn btn-primary mb-3">Kembali ke Unit Kerja</a>
                
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Induk Unit Kerja</th>
                                <th>Kode</th>
                                <th>Nama Unit Kerja</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitKerjas as $unitKerja)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $unitKerja->indukUnitKerja->nama_induk_unit_kerja }}</td>
                                    <td>{{ $unitKerja->kode }}</td>
                                    <td>{{ $unitKerja->nama_unit_kerja }}</td>
                                    <td>
                                        <form action="{{ route('unit_kerja.forceDelete', $unitKerja->id) }}" method="POST">
                                            <a class="btn btn-success btn-sm" href="{{ route('unit_kerja.restore', $unitKerja->id) }}">Restore</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); Swal.fire({
    title: 'Apakah Anda yakin?',
    text: 'Data ini akan dihapus secara permanen dan tidak dapat dipulihkan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus permanen!',
    cancelButtonText: 'Tidak, batalkan'
}).then((result) => {
    if (result.isConfirmed) {
        event.target.form.submit();
    }
});">Delete Permanently</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{ asset('/') }}assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTableExample').DataTable();
    });
</script>
@endpush