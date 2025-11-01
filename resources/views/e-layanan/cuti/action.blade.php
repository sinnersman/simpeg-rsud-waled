<div class="d-grid gap-1">
    <a class="btn btn-primary btn-sm" href="{{ route('cuti.edit', $cuti->id) }}">Edit</a>
    <form action="{{ route('cuti.destroy', $cuti->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="event.preventDefault(); Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data ini tidak akan dapat dipulihkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Tidak, batalkan'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.form.submit();
        }
    });">Delete</button>
    </form>
</div>