@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Pengajuan Cuti</h4>
                <p class="text-muted mb-3">Ubah kolom yang diperlukan untuk pengajuan cuti.</p>

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

                <form action="{{ route('cuti.update', $cuti->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="leave_type" class="form-label">Jenis Cuti</label>
                        <select name="leave_type" class="form-control" id="leave_type" required>
                            <option value="">Pilih Jenis Cuti</option>
                            <option value="LEAVE_TP_01" {{ $cuti->leave_type == 'LEAVE_TP_01' ? 'selected' : '' }}>Cuti tahunan</option>
                            <option value="LEAVE_TP_02" {{ $cuti->leave_type == 'LEAVE_TP_02' ? 'selected' : '' }}>Cuti sakit</option>
                            <option value="LEAVE_TP_03" {{ $cuti->leave_type == 'LEAVE_TP_03' ? 'selected' : '' }}>Cuti bersalin</option>
                            <option value="LEAVE_TP_04" {{ $cuti->leave_type == 'LEAVE_TP_04' ? 'selected' : '' }}>Cuti besar</option>
                            <option value="LEAVE_TP_05" {{ $cuti->leave_type == 'LEAVE_TP_05' ? 'selected' : '' }}>Cuti karena alasan penting</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $cuti->start_date }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $cuti->end_date }}" min="{{ $cuti->start_date }}" required>
                    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            endDateInput.min = startDateInput.value;
            if (endDateInput.value < startDateInput.value) {
                endDateInput.value = startDateInput.value;
            }
        });
    });
</script>
@endpush
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required>{{ $cuti->reason }}</textarea>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update Cuti</button>
                        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection