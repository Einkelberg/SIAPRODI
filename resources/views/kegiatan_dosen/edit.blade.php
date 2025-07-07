@extends('layouts.app')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
    <h3 style="margin-left: 15px;">Edit Kegiatan Dosen</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Menu</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kegiatan_dosen.index') }}">Data Kegiatan Dosen</a></li>
                <li class="breadcrumb-item active">Edit Kegiatan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kegiatan_dosen.update', $kegiatan_dosen->id_kegiatan_dosen) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">Nama Dosen</label>
                                        <select name="nidn" id="nidn" class="form-control" required>
                                            <option value="">-- Pilih Dosen --</option>
                                            @foreach($dosen as $dsn)
                                                <option value="{{ $dsn->nidn }}" {{ $kegiatan_dosen->nidn == $dsn->nidn ? 'selected' : '' }}>
                                                    {{ $dsn->nidn }} - {{ $dsn->nama_dosen }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kegiatan</label>
                                        <input type="text" name="jenis_kegiatan" class="form-control" value="{{ $kegiatan_dosen->jenis_kegiatan }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Lokasi Kegiatan</label>
                                        <input type="text" name="lokasi_kegiatan" class="form-control" value="{{ $kegiatan_dosen->lokasi_kegiatan }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nomor SK</label>
                                        <input type="text" name="nomor_sk" class="form-control" value="{{ $kegiatan_dosen->nomor_sk }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <input type="date" name="tgl_mulai" class="form-control" value="{{ $kegiatan_dosen->tgl_mulai }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Selesai</label>
                                        <input type="date" name="tgl_selesai" class="form-control" value="{{ $kegiatan_dosen->tgl_selesai }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">File SK (Surat Keputusan)</label>
                                        <input type="file" name="file_sk" class="form-control">
                                        @if ($kegiatan_dosen->file_sk)
                                            <p class="mt-2">File saat ini:
                                                <a href="{{ asset('storage/' . $kegiatan_dosen->file_sk) }}" target="_blank">Lihat SK</a>
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="3">{{ $kegiatan_dosen->keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('kegiatan_dosen.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
