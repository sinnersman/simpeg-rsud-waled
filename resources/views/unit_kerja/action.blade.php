<form action="{{ route('unit_kerja.destroy', $unitKerja->id) }}" method="POST">
    <a class="btn btn-primary btn-sm" href="{{ route('unit_kerja.edit', $unitKerja->id) }}">Edit</a>
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); Swal.fire({
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
    });">Hapus</button>
</form>