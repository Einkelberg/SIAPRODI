@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Edit Data Wisuda</h5>
        </div>
        <div class="card-body">
            <form action="/wissuda/{{ $wisuda->id }}/update" method="POST">
                {{ csrf_field() }}
                @method('PUT')

                <div class="mb-3">
                    <label for="nim" class="form-label">Mahasiswa</label>
                    <select class="form-control select2" id="nim" name="nim" disabled>
                        <option value="{{ $wisuda->nim }}" selected>
                            {{ $wisuda->nim }} - {{ $wisuda->mahasiswa->nama_mahasiswa }}
                        </option>
                    </select>
                    <input type="hidden" name="nim" value="{{ $wisuda->nim }}"> 
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" class="form-control" id="semester" name="semester"
                        value="{{ old('semester', $wisuda->semester) }}">
                    @error('semester')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Wisuda</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_wisuda" id="sudah_wisuda" value="Sudah Wisuda"
                        {{ $wisuda->status_wisuda == 'Sudah Wisuda' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sudah_wisuda">Sudah Wisuda</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_wisuda" id="belum_wisuda" value="Belum Wisuda"
                        {{ $wisuda->status_wisuda == 'Belum Wisuda' ? 'checked' : '' }}>
                        <label class="form-check-label" for="belum_wisuda">Belum Wisuda</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tahun_wisuda_id" class="form-label">Tahun Wisuda</label>
                    <select name="tahun_wisuda_id" id="tahun_wisuda_id" class="form-control">
                        <option value="">Pilih Tahun Wisuda</option>
                        @foreach($tahun_wisuda as $tahun)
                            <option value="{{ $tahun->id }}" 
                                {{ old('tahun_wisuda_id', $wisuda->tahun_wisuda_id) == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->tahun_wisuda }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_wisuda_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning text-white">Update</button>
                <a href="/wissuda" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusWisudaRadios = document.querySelectorAll('input[name="status_wisuda"]');
        const tahunWisudaDropdown = document.getElementById("tahun_wisuda_id");
        
        function toggleDropdown() {
            const isBelumWisuda = document.querySelector('input[name="status_wisuda"]:checked').value === "Belum Wisuda";
            
            if (isBelumWisuda) {
                // Simpan nilai lama di atribut data
                tahunWisudaDropdown.dataset.oldValue = tahunWisudaDropdown.value;
                tahunWisudaDropdown.value = ""; // Kosongkan tampilan dropdown
                tahunWisudaDropdown.disabled = true; // Matikan dropdown
            } else {
                // Kembalikan nilai lama jika sebelumnya disimpan
                tahunWisudaDropdown.disabled = false; // Aktifkan kembali dropdown
                if (tahunWisudaDropdown.dataset.oldValue) {
                    tahunWisudaDropdown.value = tahunWisudaDropdown.dataset.oldValue;
                }
            }
        }
    
        statusWisudaRadios.forEach(radio => {
            radio.addEventListener("change", toggleDropdown);
        });
    
        // Panggil fungsi saat halaman dimuat untuk set default
        toggleDropdown();
    });
</script>

@endsection
