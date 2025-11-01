@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Persetujuan Cuti</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cutis as $cuti)
            <tr>
                <td>{{ $cuti->pegawai->nama_lengkap }}</td>
                <td>{{ $cuti->start_date }}</td>
                <td>{{ $cuti->end_date }}</td>
                <td>{{ $cuti->reason }}</td>
                <td>
                    <form action="{{ route('cuti.approval.approve', $cuti) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Setuju</button>
                    </form>
                    <form action="{{ route('cuti.approval.reject', $cuti) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
