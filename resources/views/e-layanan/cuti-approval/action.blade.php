<div class="d-grid gap-1">
    @if ($cuti->approval_1_status === 'pending')
        <form action="{{ route('cuti.approval.approve', $cuti) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success btn-sm w-100">Setuju Level 1</button>
        </form>
        <form action="{{ route('cuti.approval.reject', $cuti) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger btn-sm w-100">Tolak Level 1</button>
        </form>
    @elseif ($cuti->approval_1_status === 'approved' && $cuti->approval_2_status === 'pending')
        <form action="{{ route('cuti.approval.approve', $cuti) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success btn-sm w-100">Setuju Level 2</button>
        </form>
        <form action="{{ route('cuti.approval.reject', $cuti) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger btn-sm w-100">Tolak Level 2</button>
        </form>
    @else
        <span class="badge bg-secondary">Sudah Diproses</span>
    @endif
</div>