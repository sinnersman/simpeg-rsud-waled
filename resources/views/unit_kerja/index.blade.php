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
                <h4 class="card-title">Daftar Data Unit Kerja</h4>
                <p class="text-muted mb-3">Berikut adalah daftar semua data unit kerja yang terdaftar.</p>
                <div class="text-end mb-3">
                    <a href="{{ route('unit_kerja.create') }}" class="btn btn-primary">Tambah Unit Kerja</a>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                        Import Excel
                    </button>
                    <a href="{{ route('unit_kerja.downloadTemplate') }}" class="btn btn-info">Download Template</a>
                    <a href="{{ route('unit_kerja.trash') }}" class="btn btn-danger">Recycle Bin</a>
                </div>

                <!-- Import Excel Modal -->
                <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importExcelModalLabel">Import Unit Kerja from Excel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('unit_kerja.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Choose Excel File</label>
                                        <input class="form-control" type="file" id="file" name="file" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <div class="table dataTable">
                        {{ $dataTable->table() }}
                    </div>
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