@extends('layouts.app')
@section('content')

<div class="container">
    <h3 class="mb-3">Tambah Data PKM</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pkm.store') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        {{-- Dosen --}}
                        <div class="mb-3">
                            <label class="form-label">Dosen</label>
                            <div id="dosen-container">
                                <div class="input-group mb-2">
                                    <input type="text" name="nama_dosen[]" class="form-control me-2" placeholder="Nama Dosen">
                                    <input type="text" name="nidn[]" class="form-control me-2" placeholder="NIDN">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusElemen(this)">❌</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahDosen()">+ Tambah Dosen</button>
                        </div>

                        {{-- Mahasiswa --}}
                        <div class="mb-3">
                            <label class="form-label">Mahasiswa</label>
                            <div id="mahasiswa-container">
                                <div class="input-group mb-2">
                                    <input type="text" name="nama_mahasiswa[]" class="form-control me-2" placeholder="Nama Mahasiswa">
                                    <input type="text" name="nim[]" class="form-control me-2" placeholder="NIM">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusElemen(this)">❌</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahMahasiswa()">+ Tambah Mahasiswa</button>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        {{-- Tahun --}}
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" min="2000" max="{{ date('Y') }}" required>
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>

                        {{-- Anggaran --}}
                        <div class="mb-3">
                            <label for="anggaran" class="form-label">Anggaran</label>
                            <input type="number" name="anggaran" class="form-control" min="0" step="1000" required>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pkm.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript --}}
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