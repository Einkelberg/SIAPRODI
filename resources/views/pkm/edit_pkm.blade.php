@extends('layouts.app')
@section('content')

<div class="container">
    <h3 class="mb-3">Edit Data PKM</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pkm.update', $pkm->id_pkm) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        {{-- Dosen --}}
                        <div class="mb-3">
                            <label class="form-label">Dosen</label>
                            <div id="dosen-container">
                                @php
                                    $dosenList = isset($pkm) ? explode(',', $pkm->nama_dosen) : [''];
                                    $nidnList = isset($pkm) ? explode(',', $pkm->nidn) : [''];
                                @endphp
                                @foreach($dosenList as $i => $dosen)
                                    <div class="input-group mb-2">
                                        <input type="text" name="nama_dosen[]" class="form-control me-2" value="{{ old('nama_dosen.' . $i, trim($dosen)) }}" placeholder="Nama Dosen">
                                        <input type="text" name="nidn[]" class="form-control me-2" value="{{ old('nidn.' . $i, trim($nidnList[$i] ?? '')) }}" placeholder="NIDN">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusElemen(this)">❌</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahDosen()">+ Tambah Dosen</button>
                        </div>

                        {{-- Mahasiswa --}}
                        <div class="mb-3">
                            <label class="form-label">Mahasiswa</label>
                            <div id="mahasiswa-container">
                                @php
                                    $mhsList = isset($pkm) ? explode(',', $pkm->nama_mahasiswa) : [''];
                                    $nimList = isset($pkm) ? explode(',', $pkm->nim) : [''];
                                @endphp
                                @foreach($mhsList as $i => $mhs)
                                    <div class="input-group mb-2">
                                        <input type="text" name="nama_mahasiswa[]" class="form-control me-2" value="{{ old('nama_mahasiswa.' . $i, trim($mhs)) }}" placeholder="Nama Mahasiswa">
                                        <input type="text" name="nim[]" class="form-control me-2" value="{{ old('nim.' . $i, trim($nimList[$i] ?? '')) }}" placeholder="NIM">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusElemen(this)">❌</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahMahasiswa()">+ Tambah Mahasiswa</button>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ $pkm->judul }}" required>
                        </div>

                        {{-- Tahun --}}
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" min="2000" max="{{ date('Y') }}" value="{{ $pkm->tahun }}" required>
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ $pkm->lokasi }}" required>
                        </div>

                        {{-- Anggaran --}}
                        <div class="mb-3">
                            <label for="anggaran" class="form-label">Anggaran</label>
                            <input type="number" name="anggaran" class="form-control" min="0" step="1000" value="{{ $pkm->anggaran }}" required>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="Dalam Proses" {{ $pkm->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="Selesai" {{ $pkm->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ $pkm->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pkm.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Dinamis --}}
<script>
    function tambahDosen() {
        const container = document.getElementById('dosen-container');
        const inputHTML = `
            <div class="input-group mb-2">
                <input type="text" name="nama_dosen[]" class="form-control me-2" placeholder="Nama Dosen">
                <input type="text" name="nidn[]" class="form-control me-2" placeholder="NIDN">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusElemen(this)">❌</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', inputHTML);
    }

    function tambahMahasiswa() {
        const container = document.getElementById('mahasiswa-container');
        const inputHTML = `
            <div class="input-group mb-2">
                <input type="text" name="nama_mahasiswa[]" class="form-control me-2" placeholder="Nama Mahasiswa">
                <input type="text" name="nim[]" class="form-control me-2" placeholder="NIM">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusElemen(this)">❌</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', inputHTML);
    }

    function hapusElemen(button) {
        button.closest('.input-group').remove();
    }
</script>

@endsection