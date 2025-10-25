<div class="d-grid gap-1">
    @if(request()->routeIs('jenjang.trash'))
        <a class="btn btn-success btn-sm" href="{{ route('jenjang.restore', $jenjang->id) }}">Restore</a>
        <form action="{{ route('jenjang.forceDelete', $jenjang->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="event.preventDefault(); Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus permanen!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.form.submit();
            }
        });">Force Delete</button>
        </form>
    @else
        <a class="btn btn-primary btn-sm" href="{{ route('jenjang.edit', $jenjang->id) }}">Edit</a>
        <form action="{{ route('jenjang.destroy', $jenjang->id) }}" method="POST">
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
    @endif
</div>