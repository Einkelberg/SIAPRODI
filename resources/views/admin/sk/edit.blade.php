@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Edit SK Wisuda</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/sk/' . $tahun_wisuda->id . '/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tahun_wisuda" class="form-label">Tahun Wisuda</label>
                    <input type="text" class="form-control" value="{{ $tahun_wisuda->tahun_wisuda }}" readonly>
                    <input type="hidden" name="tahun_wisuda" value="{{ $tahun_wisuda->tahun_wisuda }}">
                </div>
                
                <div class="mb-3">
                    <label for="sk_wisuda" class="form-label">Upload SK Wisuda</label>
                    <input type="file" class="form-control" id="sk_wisuda" name="sk_wisuda">
                    @error('sk_wisuda')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if (!empty($tahun_wisuda->sk_wisuda) && $tahun_wisuda->sk_wisuda !== '-')
                        <p class="mt-2">File Saat Ini: 
                            <a href="{{ asset('storage/' . $tahun_wisuda->sk_wisuda) }}" target="_blank">Lihat SK</a>
                        </p>
                    @endif
                </div>
                    <button type="submit" class="btn btn-warning px-4">Simpan</button>
                    <a href="{{ url('/sk') }}" class="btn btn-secondary px-4">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
