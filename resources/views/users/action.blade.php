<div class="d-grid gap-1">
    <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>

    @if (auth()->user()->hasRole('superadmin') && auth()->user()->id !== $user->id)
        <a class="btn btn-info btn-sm" href="{{ route('users.impersonate', $user->id) }}">Impersonate</a>
    @endif

    @if ($user->is_active)
        <button type="button" class="btn btn-warning btn-sm w-100" onclick="event.preventDefault(); Swal.fire({
            title: 'Nonaktifkan Pengguna?',
            text: 'Pengguna ini akan dinonaktifkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Nonaktifkan!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deactivate-form-{{ $user->id }}').submit();
            }
        });">Nonaktifkan</button>
        <form id="deactivate-form-{{ $user->id }}" action="{{ route('users.deactivate', $user->id) }}" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
        </form>
    @else
        <button type="button" class="btn btn-success btn-sm w-100" onclick="event.preventDefault(); Swal.fire({
            title: 'Aktifkan Pengguna?',
            text: 'Pengguna ini akan diaktifkan kembali.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('activate-form-{{ $user->id }}').submit();
            }
        });">Aktifkan</button>
        <form id="activate-form-{{ $user->id }}" action="{{ route('users.activate', $user->id) }}" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
        </form>
    @endif

    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
