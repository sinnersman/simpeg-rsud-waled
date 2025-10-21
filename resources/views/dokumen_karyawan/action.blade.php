<div class="d-flex">
    <a href="{{ route('dokumen-karyawan.edit', $row->id) }}" class="btn btn-sm btn-primary me-2">Edit</a>
    <form action="{{ route('dokumen-karyawan.destroy', $row->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.form.submit();
            }
        });">Hapus</button>
    </form>
</div>
