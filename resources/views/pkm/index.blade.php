@extends('layouts.app')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h3 style="margin-left: 15px;">Data Program Kreativitas Mahasiswa</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('pkm.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

                        <!-- Form Pencarian -->
                        <form action="{{ route('pkm.index') }}" method="GET" class="mb-3 d-flex justify-content-end">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari Tahun..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary btn-sm ms-2">Cari</button>
                            </div>
                        </form>

                        <!-- Tabel PKM -->
                        <table class="table table-bordered datatable">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dosen & NIDN</th>
                                    <th>Judul</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pkm as $p_pkm)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td class="text-start">
                                        @php
                                            $namaDosen = explode(',', $p_pkm->nama_dosen);
                                            $nidnDosen = explode(',', $p_pkm->nidn ?? '');
                                        @endphp

                                        @foreach($namaDosen as $index => $nama)
                                            <div>
                                                {{ trim($nama) }}<br>
                                                <small class="text-muted">NIDN: {{ trim($nidnDosen[$index] ?? '-') }}</small>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td class="text-center">{{ $p_pkm->judul }}</td> 
                                    <td class="text-center">{{ $p_pkm->tahun }}</td> 
                                    <td class="text-center">
                                        @if($p_pkm->status == 'Dalam Proses')
                                            <span class="badge bg-primary">{{ $p_pkm->status }}</span>
                                        @elseif($p_pkm->status == 'Selesai')
                                            <span class="badge bg-success">{{ $p_pkm->status }}</span>
                                        @elseif($p_pkm->status == 'Dibatalkan')
                                            <span class="badge bg-danger">{{ $p_pkm->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $p_pkm->status }}</span>
                                        @endif
                                    </td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('pkm.show', $p_pkm->id_pkm) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pkm.edit', ['id' => $p_pkm->id_pkm]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/pkm/{{ $p_pkm->id_pkm }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>  
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection