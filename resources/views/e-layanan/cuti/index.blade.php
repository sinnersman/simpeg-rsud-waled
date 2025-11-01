@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pengajuan Cuti</h1>
    <a href="{{ route('cuti.create') }}" class="btn btn-primary mb-3">Buat Pengajuan Cuti</a>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Alasan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cutis as $cuti)
            <tr>
                <td>{{ $cuti->start_date }}</td>
                <td>{{ $cuti->end_date }}</td>
                <td>{{ $cuti->reason }}</td>
                <td>{{ $cuti->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
