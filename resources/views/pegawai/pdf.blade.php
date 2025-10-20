<!DOCTYPE html>
<html>
<head>
    <title>Data Pegawai</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .mt-2 {
            margin-top: 0.5rem;
        }
        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="text-center mb-4">
        @if ($pegawai->foto_pegawai)
            <img src="{{ storage_path('app/' . $pegawai->foto_pegawai) }}" alt="Foto Pegawai" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
        @endif
        <h3 class="mt-2">{{ $pegawai->nama_lengkap }}</h3>
        <p>NIP: {{ $pegawai->nip }}</p>
    </div>

    <h4>Data Diri Pegawai</h4>
    <table class="table">
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

    <h4 class="mt-4">Data Alamat Pegawai</h4>
    <table class="table">
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

    <h4 class="mt-4">Keterangan Badan</h4>
    <table class="table">
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

    <h4 class="mt-4">Keterangan Tambahan</h4>
    <table class="table">
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

</body>
</html>