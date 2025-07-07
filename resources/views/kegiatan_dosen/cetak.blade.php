<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan Dosen Di luar</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Data Kegiatan Dosen Di luar</h2>
    <table>
        <thead>
            <tr>
                <th>NIDN</th>
                <th>Nama Dosen</th>
                <th>Nomor SK</th>
                <th>Jenis Kegiatan</th>
                <th>Lokasi Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($kegiatan_dosen as $kds)
                                        <tr class="text-center">
                                            <td>{{ $kds->dosen?->nidn }}</td>
                                            <td>{{ $kds->dosen?->nama_dosen }}</td>
                                            <td>{{ $kds->nomor_sk }}</td>
                                            <td>{{ $kds->jenis_kegiatan }}</td>
                                            <td>{{ $kds->lokasi_kegiatan }}</td>
                                            <td>{{ date('d-m-Y', strtotime($kds->tgl_mulai)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($kds->tgl_selesai)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
