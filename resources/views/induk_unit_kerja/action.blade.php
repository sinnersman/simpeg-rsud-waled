<form action="{{ route('induk_unit_kerja.destroy', $indukUnitKerja->id) }}" method="POST">
    <a class="btn btn-primary btn-sm" href="{{ route('induk_unit_kerja.edit', $indukUnitKerja->id) }}">Edit</a>
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