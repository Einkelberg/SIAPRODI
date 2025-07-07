@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Unggah SK Wisuda</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/sk/store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="tahun_wisuda" class="form-label">Tahun Wisuda</label>
                    <input type="text" class="form-control" id="tahun_wisuda" name="tahun_wisuda" required>
                </div>

                <div class="mb-3">
                    <label for="sk_wisuda" class="form-label">Upload SK Wisuda</label>
                    <input type="file" class="form-control" id="sk_wisuda" name="sk_wisuda" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="/sk" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
