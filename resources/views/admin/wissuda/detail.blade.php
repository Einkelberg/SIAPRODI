@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Detail Data Wisuda</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>NIM</th>
                    <td>{{ $wisuda->nim }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $wisuda->mahasiswa->nama_mahasiswa }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>{{ $wisuda->semester }}</td>
                </tr>
                <tr>
                    <th>Status Wisuda</th>
                    <td>{{ $wisuda->status_wisuda }}</td>
                </tr>
                <tr>
                    <th>Tahun Wisuda</th>
                    <td>{{ $wisuda->tahun_wisuda_id == 0 ? '-' : optional($wisuda->sk)->tahun_wisuda }}</td>
                </tr>
                <tr>
                    <th>SK Wisuda</th>
                    <td>
                        @if($wisuda->sk?->sk_wisuda && $wisuda->sk?->sk_wisuda !== '-')
                            <a href="{{ asset('storage/' . $wisuda->sk->sk_wisuda) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="nav-icon fas fa-file"></i> Lihat SK
                            </a>
                        @else
                            <span class="text-danger">Belum ada SK Wisuda</span>
                        @endif
                    </td>
                </tr>
            </table>
            <div class="mt-3">
            <a href="/wissuda" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
