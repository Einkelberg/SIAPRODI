@extends('layouts.app')
@section('content')

<div class="container">
    <h3 class="mb-3">Detail Program Kreativitas Mahasiswa</h3>

    <div class="card">
        <div class="card-body">

            {{-- Daftar Dosen --}}
            <div class="mb-3">
                <strong>Daftar Dosen:</strong>
                <ul>
                    @php
                        $namaDosen = explode(',', $pkm->nama_dosen);
                        $nidnDosen = explode(',', $pkm->nidn ?? '');
                    @endphp
                    @foreach($namaDosen as $index => $dosen)
                        <li>
                            {{ trim($dosen) }}
                            <br>
                            <small class="text-muted">NIDN: {{ trim($nidnDosen[$index] ?? '-') }}</small>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Daftar Mahasiswa --}}
            <div class="mb-3">
                <strong>Daftar Mahasiswa:</strong>
                <ul>
                    @php
                        $namaMahasiswa = explode(',', $pkm->nama_mahasiswa);
                        $nimMahasiswa = explode(',', $pkm->nim ?? '');
                    @endphp
                    @foreach($namaMahasiswa as $index => $mhs)
                        <li>
                            {{ trim($mhs) }}
                            <br>
                            <small class="text-muted">NIM: {{ trim($nimMahasiswa[$index] ?? '-') }}</small>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">
                <strong>Judul:</strong>
                <p>{{ $pkm->judul }}</p>
            </div>

            <div class="mb-3">
                <strong>Tahun:</strong>
                <p>{{ $pkm->tahun }}</p>
            </div>

            <div class="mb-3">
                <strong>Lokasi:</strong>
                <p>{{ $pkm->lokasi }}</p>
            </div>

            <div class="mb-3">
                <strong>Anggaran:</strong>
                <p>Rp {{ number_format($pkm->anggaran, 0, ',', '.') }}</p>
            </div>

            <div class="mb-3">
                <strong>Status:</strong>
                <p>
                    @if($pkm->status == 'Dalam Proses')
                        <span class="badge bg-primary">{{ $pkm->status }}</span>
                    @elseif($pkm->status == 'Selesai')
                        <span class="badge bg-success">{{ $pkm->status }}</span>
                    @elseif($pkm->status == 'Dibatalkan')
                        <span class="badge bg-danger">{{ $pkm->status }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $pkm->status }}</span>
                    @endif
                </p>
            </div>

            <a href="{{ route('pkm.index') }}" class="btn btn-secondary mb-3">Kembali</a>

        </div>
    </div>
</div>

@endsection