<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Unduh Mahasiswa Semester Perpanjangan</title>
</head>
<body>
    <h1 style="text-align: center;">Data Mahasiswa Semester Perpanjangan</h1>

    <table class="static" align="center" rules="all" border="1px" style="width: 95%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Tahun Akademik</th>
                <th>Status</th>
                <th>Semester</th>
                <th>Alasan</th>
                <th>Solusi</th>
                <th>Batas Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mhs_smstr_perpanjangan as $mhs_smstr_pj)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->nim }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->mahasiswa?->nama_mahasiswa }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->mahasiswa?->tahun_akademik }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->mahasiswa?->status_aktif }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->semester }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->alasan }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->solusi }}</td>
                    <td class="text-center">{{ $mhs_smstr_pj->batas_waktu }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
