@extends('layouts.app')

@section('content')
<main id="main" class="main">
    <div class="container">
        <!-- Judul Halaman -->
        <div class="text-center my-4">
            <h3 class="fw-bold text-success"><i class="fas fa-user-plus me-2"></i> Tambah Mahasiswa Semester Perpanjangan</h3>
            <p class="text-muted">Silakan isi data mahasiswa yang melakukan perpanjangan semester.</p>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="card shadow-lg rounded-4 border-0">
                        <div class="card-body p-4">

                            <!-- Form Tambah Mahasiswa -->
                            <form action="{{ route('maspan.simpan') }}" method="POST">
                                @csrf

                                <!-- NIM -->
                                <div class="mb-4">
                                    <label for="nim" class="form-label fw-bold text-secondary">NIM</label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror rounded-3" id="nim" name="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM mahasiswa..." required>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Semester -->
                                <div class="mb-4">
                                    <label for="semester" class="form-label fw-bold text-secondary">Semester</label>
                                    <input type="text" class="form-control @error('semester') is-invalid @enderror rounded-3" id="semester" name="semester" value="{{ old('semester') }}" placeholder="Masukkan semester mahasiswa..." required>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alasan -->
                                <div class="mb-4">
                                    <label for="alasan" class="form-label fw-bold text-secondary">Alasan</label>
                                    <textarea class="form-control @error('alasan') is-invalid @enderror rounded-3" id="alasan" name="alasan" rows="3" placeholder="Masukkan alasan mahasiswa..." required>{{ old('alasan') }}</textarea>
                                    @error('alasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Solusi -->
                                <div class="mb-4">
                                    <label for="solusi" class="form-label fw-bold text-secondary">Solusi</label>
                                    <textarea class="form-control @error('solusi') is-invalid @enderror rounded-3" id="solusi" name="solusi" rows="3" placeholder="Masukkan solusi yang diberikan..." required>{{ old('solusi') }}</textarea>
                                    @error('solusi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Batas Waktu -->
                                <div class="mb-4">
                                    <label for="batas_waktu" class="form-label fw-bold text-secondary">Batas Waktu</label>
                                    <input type="text" class="form-control @error('batas_waktu') is-invalid @enderror rounded-3" id="batas_waktu" name="batas_waktu"
                                        value="{{ old('batas_waktu') }}" placeholder="Masukkan batas waktu..." required>
                                    @error('batas_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="d-flex justify-content-center mt-4 gap-3">
                                    <button type="submit" class="btn btn-success px-4 rounded-3 shadow">
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
