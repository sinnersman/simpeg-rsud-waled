<div class="d-flex">
    <form action="{{ route('admin.approvals.approve', $changeRequest->id) }}" method="POST" class="d-inline me-2">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-sm btn-success" onclick="event.preventDefault(); Swal.fire({
            title: 'Setujui perubahan ini?',
            text: 'Perubahan akan diterapkan ke data pegawai.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Tidak, Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.form.submit();
            }
        });">Setujui</button>
    </form>

    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $changeRequest->id }}">Tolak</button>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal-{{ $changeRequest->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $changeRequest->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel-{{ $changeRequest->id }}">Tolak Permintaan Perubahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.approvals.reject', $changeRequest->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason-{{ $changeRequest->id }}" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="rejection_reason-{{ $changeRequest->id }}" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
