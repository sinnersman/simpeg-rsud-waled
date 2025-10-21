<div class="d-grid gap-1">
    <a class="btn btn-info btn-sm" href="{{ route('pegawai.show', $pegawai->id) }}">Detail</a>
    <a class="btn btn-primary btn-sm" href="{{ route('pegawai.edit', $pegawai->id) }}">Edit</a>
    <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST">
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
    });">Hapus</button>
    </form>
</div>
