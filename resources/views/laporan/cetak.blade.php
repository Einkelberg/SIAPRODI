@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header ">
        <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="/wissuda" class="btn btn-secondary">Kembali</a>
                        <h1 class="card-title mx-auto"><b>Laporan Data Wisuda</b></h1>
                        <div style="width: 75px;"></div> <!-- spacer agar judul tetap di tengah -->
                    </div>
        
        <br>
        <div >
            <label for="id">Cetak berdasarkan tahun wisuda</label>
        <div class="d-flex">

            <form action="/wisuda/search" class="form-inline" method="get">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="search" class="form-control float-right" placeholder="masukan tahun wisuda">
    
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <a href="{{ route('wisuda.hasil') }}" class="btn btn-info mx-2" >Lihat</a>
            <a href="{{ route('wisuda.exportpdf') }}" class="btn btn-success" >
              <i class="fas fa-download"></i> Unduh</a>
        </div>
        

        <div class="card-tools">

        </div>
        <br>
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
            </tr>
          </thead>
          <tbody>
            @foreach($wisuda as $wis)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $wis->nim }}</td>
              <td>{{ $wis->mahasiswa->nama_mahasiswa ?? '-' }}</td>
              <td>{{ $wis->semester ?? '-' }}</td>
              <td>{{ $wis->status_wisuda }}</td>
              <td>{{ $wis->sk->tahun_wisuda ?? '-' }}</td>
            </tr>
            @endforeach
          </tbody>
        

            
          </tbody>
        </table>
        </table>
      </div>
      
      <!-- /.card-body -->
    </div>

  </div>
  <div>
    <div class="card-body">
        <!-- Rekapan Mahasiswa Per Tahun -->
        <div class="card-body table-responsive p-0">
          <h4><b>Rekapitulasi Wisuda</b></h4>
          @if(isset($rekapitulasi) && count($rekapitulasi) > 0)
          <table class="table table-bordered text-nowrap">
            <thead>
              <tr>
                <th>Tahun Wisuda</th>
                <th>Jumlah Mahasiswa</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rekapitulasi as $rekap)
            <tr>
                <td>{{ $rekap['tahun_wisuda'] }}</td>
                <td>{{ $rekap['sudah_wisuda'] }}</td>
            </tr>
            @endforeach

            </tbody>
          </table>
          @else
    <p class="text-center">Tidak ada data yang ditemukan.</p>
@endif
        </div>
  </div>
  </div>
</div>
  </div>
@endsection
