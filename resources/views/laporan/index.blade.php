@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title"><b>Data wisuda</b></h2>
        <br>
        {{-- <br>
        <button type="submit" class="btn btn-info" onclick="window.location.href='/jurusan/create';">Tambah Jurusan</button>
        <br> --}}

        <div class="card-tools">
          <form action="/wisuda/search" class="form-inline" method="get">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="search" class="form-control float-right" placeholder="cari tahun">
  
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Semester</th>
                <th>Status Wisuda</th>
                <th>Tahun Wisuda</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wisuda as $wis)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $wis->nim }}</td>
              <td>{{ $wis->tampilMahasiswa->nama_mahasiswa }}</td>
              <td>{{ $wis->semester }}</td>
              <td>{{ $wis->status_wisuda }}</td>
              <td>{{ $wis->tahun_wisuda }}</td>
              <td>{{ $wis->nim }}</td>
              <td>
                <a href="/wisuda/{{ $wis->id }}/delete" class="btn btn-danger" onclick="return confirm('Apakah yakin menghapus data ??')">Hapus</a>
                <a href="/wisuda/{{ $wis->id }}/edit" class="btn btn-warning">Edit</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        

            
          </tbody>
        </table>
      </div>
      
      <!-- /.card-body -->
    </div>
    <div >
    <div class="d-flex justify-content-start ">
        <a href="/wisuda/preview" class="btn btn-primary">Preview Laporan</a>
        <br>
    </div>
    <br>
    <!-- /.card -->
  </div>
</div>
</div>
@endsection
