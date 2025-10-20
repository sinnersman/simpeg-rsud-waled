@extends('layouts.app', compact('title', 'breadcrumbs'))
@php use Laravolt\Indonesia\Facade as Indonesia; @endphp

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Data Pegawai: {{ $pegawai->nama_lengkap }}</h4>
                <p class="text-muted mb-3">Informasi lengkap mengenai pegawai.</p>
                
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        @if ($pegawai->foto_pegawai)
                        <img src="{{ asset($pegawai->foto_pegawai) }}" alt="Foto Pegawai" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset('path/to/default/avatar.png') }}" alt="Default Avatar" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        @endif
                        <h5 class="mt-2">{{ $pegawai->nama_lengkap }}</h5>
                        <p class="text-muted">NIP: {{ $pegawai->nip }}</p>
                    </div>
                    <div class="col-md-8">
                        <h5 class="mb-3">Data Diri Pegawai</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>NIP Lama</th>
                                        <td>{{ $pegawai->nip_lama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Panggilan</th>
                                        <td>{{ $pegawai->nama_panggilan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gelar Depan</th>
                                        <td>{{ $pegawai->gelar_depan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gelar Belakang</th>
                                        <td>{{ $pegawai->gelar_belakang ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat, Tanggal Lahir</th>
                                        <td>{{ $pegawai->tempat_lahir ?? '-' }}, {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>{{ $pegawai->jenis_kelamin ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{ $pegawai->agama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Golongan Darah</th>
                                        <td>{{ $pegawai->golongan_darah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Perkawinan</th>
                                        <td>{{ $pegawai->status_perkawinan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan Terakhir</th>
                                        <td>{{ $pegawai->pendidikan_terakhir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Kepegawaian</th>
                                        <td>{{ $pegawai->status_kepegawaian ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <h5 class="mb-3 mt-4">Data Alamat Pegawai</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Suku</th>
                                <td>{{ $pegawai->suku ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>{{ $pegawai->alamat_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>RT/RW</th>
                                <td>{{ $pegawai->rt ?? '-' }}/{{ $pegawai->rw ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td>{{ $pegawai->kode_pos ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td>{{ $pegawai->provinsi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kabupaten</th>
                                <td>{{ $pegawai->kabupaten ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td>{{ $pegawai->kecamatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kelurahan</th>
                                <td>{{ $pegawai->kelurahan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kebangsaan</th>
                                <td>{{ $pegawai->kebangsaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $pegawai->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Fax</th>
                                <td>{{ $pegawai->fax ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Telephone</th>
                                <td>{{ $pegawai->telephone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Handphone</th>
                                <td>{{ $pegawai->handphone ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h5 class="mb-3 mt-4">Keterangan Badan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Berat Badan</th>
                                <td>{{ $pegawai->berat_badan ?? '-' }} kg</td>
                            </tr>
                            <tr>
                                <th>Tinggi Badan</th>
                                <td>{{ $pegawai->tinggi_badan ?? '-' }} cm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h5 class="mb-3 mt-4">Keterangan Tambahan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>No. KARPEG</th>
                                <td>{{ $pegawai->no_karpeg ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. ASKES / BPJS</th>
                                <td>{{ $pegawai->no_askes_bpjs ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. TASPEN</th>
                                <td>{{ $pegawai->no_taspen ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. KARIS/KARSU</th>
                                <td>{{ $pegawai->no_karis_karsu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. NPWP</th>
                                <td>{{ $pegawai->no_npwp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. KORPRI</th>
                                <td>{{ $pegawai->no_korpri ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning me-2">Edit Data</a>
                    <a href="{{ route('pegawai.pdf', $pegawai->id) }}" class="btn btn-success me-2">Export to PDF</a>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection