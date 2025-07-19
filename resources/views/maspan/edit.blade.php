@extends('layouts.app')

@section('content')
<main id="main" class="main">
    <div class="container">
        <!-- Judul Halaman -->
        <div class="text-center my-4">
            <h3 class="fw-bold text-primary"><i class="fas fa-user-edit me-2"></i> Edit Data Mahasiswa</h3>
            <p class="text-muted">Silakan perbarui informasi mahasiswa dengan benar.</p>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="card shadow-lg rounded-4 border-0">
                        <div class="card-body p-4">
                            

                            <!-- Form Edit Mahasiswa -->
                            <form action="{{ route('maspan.update', $mahasiswaPerpanjangan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Hidden Fields -->
                                <input type="hidden" name="nim" value="{{ old('nim', $mahasiswaPerpanjangan->nim) }}">
                                <input type="hidden" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $mahasiswaPerpanjangan->mahasiswa->nama_mahasiswa) }}">
                                <input type="hidden" name="angkatan" value="{{ old('angkatan', $mahasiswaPerpanjangan->mahasiswa->angkatan) }}">
                                <input type="hidden" name="status" value="{{ old('status', $mahasiswaPerpanjangan->mahasiswa->status) }}">

                                <!-- Semester -->
                                <div class="mb-4">
                                    <label for="semester" class="form-label fw-bold text-secondary">Semester</label>
                                    <textarea class="form-control @error('semester') is-invalid @enderror rounded-3" id="semester" name="semester" rows="3" placeholder="Masukkan semester mahasiswa..." required>{{ old('semester', $mahasiswaPerpanjangan->semester) }}</textarea>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alasan -->
                                <div class="mb-4">
                                    <label for="alasan" class="form-label fw-bold text-secondary">Alasan</label>
                                    <textarea class="form-control @error('alasan') is-invalid @enderror rounded-3" id="alasan" name="alasan" rows="3" placeholder="Masukkan alasan mahasiswa..." required>{{ old('alasan', $mahasiswaPerpanjangan->alasan) }}</textarea>
                                    @error('alasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Solusi -->
                                <div class="mb-4">
                                    <label for="solusi" class="form-label fw-bold text-secondary">Solusi</label>
                                    <textarea class="form-control @error('solusi') is-invalid @enderror rounded-3" id="solusi" name="solusi" rows="3" placeholder="Masukkan solusi yang diberikan..." required>{{ old('solusi', $mahasiswaPerpanjangan->solusi) }}</textarea>
                                    @error('solusi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Batas Waktu -->
                                <div class="mb-4">
                                    <label for="batas_waktu" class="form-label fw-bold text-secondary">Batas Waktu</label>
                                    <input type="text" class="form-control @error('batas_waktu') is-invalid @enderror rounded-3" id="batas_waktu" name="batas_waktu"
                                        value="{{ old('batas_waktu', $mahasiswaPerpanjangan->batas_waktu) }}" required>
                                    @error('batas_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="d-flex justify-content-center mt-4 gap-3">
                                    <button type="submit" class="btn btn-primary px-4 rounded-3 shadow">
                                        <i class="fas fa-save me-3"></i> Simpan
                                    </button>
                                    <a href="{{ route('maspan.index') }}" class="btn btn-secondary px-4 rounded-3 shadow">
                                        <i class="fas fa-arrow-left me-3"></i> Kembali
                                    </a>
                                </div>
                                
                            </form>
                        </div> <!-- End Card Body -->
                    </div> <!-- End Card -->
                </div> <!-- End Col -->
            </div> <!-- End Row -->
        </section>
    </div>
</main>
@endsection
