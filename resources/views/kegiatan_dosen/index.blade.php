@extends('layouts.app')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
    <h3 style="margin-left: 15px;">Data Kegiatan Dosen Di Luar</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Menu</a></li>
                <li class="breadcrumb-item active">Data Kegiatan Dosen Di Luar</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex">
                                <a href="{{ route('kegiatan_dosen.create') }}" class="btn btn-primary me-2">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </a>
                                <a href="/kegiatan_dosen/exportpdf" class="btn btn-danger">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                            
                            <form action="{{ route('kegiatan_dosen.search') }}" method="GET" class="d-flex gap-2">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama atau NIDN" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> 
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>Lokasi Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>File SK</th>
                                        <th>No SK</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kegiatan_dosen as $kds)
                                    <tr class="text-center">
                                        <td>{{ $kds->dosen?->nidn }}</td>
                                        <td>{{ $kds->dosen?->nama_dosen }}</td>
                                        <td>{{ $kds->jenis_kegiatan }}</td>
                                        <td>{{ $kds->lokasi_kegiatan }}</td>
                                        <td>{{ date('d-m-Y', strtotime($kds->tgl_mulai)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($kds->tgl_selesai)) }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $kds->file_sk) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-alt"></i> Lihat File
                                            </a>
                                        </td>
                                        <td>{{ $kds->nomor_sk }}</td>
                                        <td>{{ $kds->keterangan }}</td>
                                        <td>
                                            @php
                                            @endphp
                                            <div class="btn-group">
                                                <a href="{{ route('kegiatan_dosen.edit', $kds->id_kegiatan_dosen) }}" class="btn btn-sm btn-success" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button onclick="confirmDelete({{ $kds->id_kegiatan_dosen }}, '{{ $kds->kegiatan_dosen }}')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $kds->id_kegiatan_dosen }}" action="{{ route('kegiatan_dosen.destroy', $kds->id_kegiatan_dosen) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- End table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function confirmDelete(id, kegiatan_dosen) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>


@endsection
