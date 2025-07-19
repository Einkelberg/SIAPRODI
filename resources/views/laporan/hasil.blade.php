
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header ">
        <br>
        <!-- Kop Surat -->
<table width="100%">
  <tr>
      <td width="15%" align="center">
          <img src="{{ public_path('dist/img/logo_pnc.png') }}" alt="Logo PNC" style="width: 100px; height: auto;">
      </td>
      <td width="85%" align="center">
          <h2 style="margin: 0;">POLITEKNIK NEGERI CILACAP</h2>
          <h3 style="margin: 0;">JURUSAN KOMPUTER DAN BISNIS</h3>
          <h4 style="margin: 0;">PROGRAM STUDI D-III TEKNIK INFORMATIKA</h4>
          <p style="margin: 0;">Jalan Dr. Soetomo No.1, Sidakaya - Cilacap 53212 Jawa Tengah</p>
          <p style="margin: 0;">Telepon: (0282) 533329 | Email: sekretariat@pnc.ac.id</p>
      </td>
  </tr>
</table>
<hr style="border: 2px solid black;">


        <div class="card-header d-flex justify-content-center" style="text-align: center;">
            <h1 class="card-title "><b>Laporan Data wisuda</b></h1>
        </div>
      
            
        <div class="d-flex">
      

        <div class="card-tools">
         
            </div>
          </form>
        </div>
        <br>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="static" align="center" rules="all" border="1px" style="width: 90%;">
          <thead >
            <tr style="text-align: center;">
                <th>No</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
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
                <td>{{ $wis->mahasiswa->nama_mahasiswa }}</td>
                <td>{{ $wis->semester }}</td>
                <td>{{ $wis->status_wisuda }}</td>
                {{-- <td>{{ $wis->sk->tahun_wisuda }}</td> --}}
                <td>{{ $wis->sk?->tahun_wisuda ?? '-' }}</td>
              </tr>
              @endforeach
            
          </tbody>
        </table>
      </div>
      
      <!-- /.card-body -->
    </div>
    <div class="card-body">
        <!-- Rekapan Mahasiswa Per Tahun -->
        <div style="width: 50%; margin-left: 70px;" class="mb-4">
          <h4><b>Rekapitulasi Wisuda</b></h4>
          @if($wisuda->isEmpty())
    <p>Tidak ada data yang ditemukan.</p>
@else

@endif
          @if(isset($rekapitulasi) && count($rekapitulasi) > 0)
          <table class="static width: 90%;" rules="all" border="1px" >
            <thead  >
              <tr style="text-align: center;">
                <th>Tahun Wisuda</th>
                <th>Jumlah Mahasiswa</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rekapitulasi as $rekap)
            <tr style="text-align: center;">
                <td>{{ $rekap['tahun_wisuda'] }}</td>
                <td>{{ $rekap['sudah_wisuda'] }}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
          @else
        </div>
        @endif
    </div>
    <!-- Tanda Tangan -->
<br><br>
<table width="100%">
    <tr>
        <td width="50%"></td> <!-- Kosongkan kolom kiri -->
        <td width="50%" align="center">
            <p>Cilacap, ..........................................</p>
            <p><b>Koordinator Program Studi</b></p>
            <br><br><br> <!-- Jarak untuk tanda tangan -->
            <p><b><u>Cahya Vikasari, S.T., M.Eng.</u></b></p>
            <p>NIP: 198412012018032001</p>
        </td>
    </tr>
</table>

  </div>

</div>
