@extends('layouts.app')

@section('content')

@push('styles')
<style>
    /* Styling untuk tabel */
    .table th {
        text-align: center;
        vertical-align: middle;
        background-color: #007bff;
        color: white;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Styling untuk badge status */
    .status-badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 20px;
    }

    /* Styling untuk tombol aksi */
    .aksi-buttons a, .aksi-buttons button {
        font-size: 0.85rem;
        padding: 8px 12px;
        transition: 0.3s ease-in-out;
    }

    .aksi-buttons a:hover, .aksi-buttons button:hover {
        transform: scale(1.05);
    }

    /* Styling untuk pencarian */
    .search-container {
        max-width: 500px;
        margin-bottom: 20px;
    }

    .search-container .input-group {
        border-radius: 30px;
        overflow: hidden;
    }

    .search-container input {
        border-radius: 30px 0 0 30px;
        padding: 10px;
    }

    .search-container button {
        border-radius: 0 30px 30px 0;
        padding: 10px 15px;
    }

    
</style>
@endpush

<main id="main" class="main">
    <div class="container"> 
        <div class="row">
            <div class="col-lg-12">
                <h3 class="bold">Data Mahasiswa Semester Perpanjangan</h3>
            </div>
        </div>
    </div>
</main>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body">
                        <!-- Menambahkan mt-4 agar ada jarak dari form pencarian -->

                   <!-- Form Pencarian -->
                    <div class="search-container mx-auto mb-4"> <!-- Menambahkan mb-4 untuk jarak -->
                        <form method="GET" action="{{ route('maspan.search') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIM atau Nama" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <a href="{{ route ('maspan.tambah') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah
                    </a>

                    <a href="/maspan/cetakmaspan" class="btn btn-warning mb-3" target="_blank">
                        <i class="fas fa-eye"></i> Lihat Cetak
                    </a>

                    <!-- Tombol Download -->
                    <a href="/maspan/exportpdf" class="btn btn-success mb-3" target="_blank">
                        <i class="fas fa-download"></i> Download
                    </a>

                    <!-- Menampilkan Tabel -->
                    <div class="table-responsive">
                            @if ($mahasiswaSemesterPerpanjangan->isNotEmpty())
                                <table class="table table-striped table-bordered">
                                    <thead class="text-center bg-primary text-white">
                                        <tr>
                                            <th>NO.</th> <!-- Tambahan kolom NO. -->
                                            <th>NIM</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Tahun Akademik</th>
                                            <th>Status</th>
                                            <th>Semester</th>
                                            <th>Alasan</th>
                                            <th>Solusi</th>
                                            <th>Batas Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($mahasiswaSemesterPerpanjangan as $data_mahasiswa)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td> <!-- Nomor urut -->
                                                <td class="text-center">{{ $data_mahasiswa->nim }}</td>
                                                <td>{{ $data_mahasiswa->mahasiswa?->nama_mahasiswa }}</td>
                                                <td class="text-center">{{ $data_mahasiswa->mahasiswa?->tahun_akademik }}</td>

                                                <!-- Status dengan Warna -->
                                                <td class="text-center">
                                                    @if ($data_mahasiswa->mahasiswa?->status_aktif === 'Aktif')
                                                        <span class="badge bg-success status-badge">Aktif</span>
                                                    @endif
                                                </td>

                                                <td>{{ $data_mahasiswa->semester }}</td>
                                                <td>{{ $data_mahasiswa->alasan }}</td>
                                                <td>{{ $data_mahasiswa->solusi }}</td>
                                                <td>{{ $data_mahasiswa->batas_waktu }}</td>
                                                <td>
                                                    <div class="aksi-buttons d-flex flex-column">
                                                        <a href="{{ route('maspan.edit', $data_mahasiswa->id) }}" class="btn btn-warning btn-sm mb-2">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <form action="{{ route('maspan.destroy', $data_mahasiswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center text-muted">Tidak ada data mahasiswa semester perpanjangan.</p>
                            @endif
                        </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
