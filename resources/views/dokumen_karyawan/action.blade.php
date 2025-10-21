<div class="d-flex">
    <a href="{{ route('dokumen-karyawan.edit', $row->id) }}" class="btn btn-sm btn-primary me-2">Edit</a>
    <form action="{{ route('dokumen-karyawan.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
    </form>
</div>
