@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Tambah Data Wisuda</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/wissuda/store') }}" method="post">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="nim" class="form-label">Mahasiswa</label>
                    <select class="form-control select2" id="nim" name="nim">
                        <option value="">Pilih Mahasiswa</option>
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->nim }}" {{ old('nim') == $mhs->nim ? 'selected' : '' }}>
                                {{ $mhs->nim }} - {{ $mhs->nama_mahasiswa }}
                            </option>
                        @endforeach
                    </select>
                    @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" class="form-control" id="semester" name="semester" value="{{ old('semester') }}" min="1" max="14" placeholder="Contoh: 6">
                    @error('semester')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Wisuda</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_wisuda" id="sudah_wisuda" value="Sudah Wisuda"
                        {{ old('status_wisuda') == 'Sudah Wisuda' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sudah_wisuda">
                            Sudah Wisuda
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_wisuda" id="akan_wisuda" value="Belum Wisuda"
                        {{ old('status_wisuda') == 'Belum Wisuda' ? 'checked' : '' }}>
                        <label class="form-check-label" for="akan_wisuda">
                            Belum Wisuda
                        </label>
                    </div>
                    @error('status_wisuda')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tahun_wisuda_id" class="form-label">Tahun Wisuda</label>
                    <select class="form-control select2" id="tahun_wisuda_id" name="tahun_wisuda_id">
                        <option value="">Pilih Tahun Wisuda</option>
                        @foreach ($tahun_wisuda as $tw)
                            <option value="{{ $tw->id }}" {{ old('tahun_wisuda_id') == $tw->id ? 'selected' : '' }}>
                                {{ $tw->tahun_wisuda }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_wisuda_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="/wissuda" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript untuk Status Wisuda --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const statusWisudaInputs = document.querySelectorAll('input[name="status_wisuda"]');
        const tahunWisudaInput = document.getElementById('tahun_wisuda_id');

        function toggleTahunWisuda() {
            tahunWisudaInput.disabled = document.getElementById('akan_wisuda').checked;
        }

        statusWisudaInputs.forEach(input => {
            input.addEventListener('change', toggleTahunWisuda);
        });

        toggleTahunWisuda();
    });
</script>

{{-- Select2 Initialization --}}
<script>
   $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Data",
            allowClear: true,
            width: '100%',
            minimumInputLength: 0
        });
    });
</script>

@endsection
