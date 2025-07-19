<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\IpkController;
use App\Http\Controllers\KegiatanDosenController;
use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\MahasiswaSemesterPerpanjanganController;
use App\Http\Controllers\MbkmController;
use App\Http\Controllers\MouController;
use App\Http\Controllers\PemanggilanOrangtuaController;
use App\Http\Controllers\PenelitianDosenController;
use App\Http\Controllers\PkmController;
use App\Http\Controllers\PresMhsController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\MagangController;
use App\Http\Controllers\RKAController;
use App\Http\Controllers\SertikomController;
use App\Http\Controllers\SertMahController;
use App\Http\Controllers\TaController;
use App\Http\Controllers\TahunWisudaController;
use App\Http\Controllers\TorController;
use App\Http\Controllers\UndurDiriDoController;

use App\Http\Controllers\WisudaController;
use App\Http\Controllers\YudisiumController;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PenelitianDosen;
use App\Models\UndurDiriDo;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// CRUD User dengan Middleware Auth
// Route::middleware(['auth'])->group(function () {
    Route::get('/olahdata', [UserController::class, 'index'])->name('user.index');
    Route::get('/olahdata/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/olahdata', [UserController::class, 'store'])->name('user.store');
    Route::get('/olahdata/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/olahdata/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/olahdata/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/olahdata', [UserController::class, 'index'])->name('user.index');
// });

// UNDUR DIRI
Route::get('/undur_diri_do', [UndurDiriDoController::class, 'index'])->name('undur_diri_do.index');
Route::post('/undur-diri/store', [UndurDiriDoController::class, 'store'])->name('undur-diri.store');
Route::put('/undur-diri/{id}', [UndurDiriDoController::class, 'update'])->name('undur-diri.update');
Route::delete('/undur-diri/{id}', [UndurDiriDoController::class, 'destroy'])->name('undur-diri.destroy');
Route::get('/undur-diri/export', [UndurDiriDoController::class, 'exportUndurDiri'])->name('undur-diri.export');
// UNDUR DIRI

// MAHASISWA
Route::get('/mahasiswa', function () {
    $mahasiswas = Mahasiswa::all();
    $tahunAkademiks = TahunAkademik::all();
    return view('mahasiswa.index', compact('mahasiswas', 'tahunAkademiks'));
})->name('mahasiswa.index');

Route::get('/lihat_mahasiswa/{id_mahasiswa}', function ($id_mahasiswa) {
    $mahasiswa = Mahasiswa::where('id_mahasiswa', $id_mahasiswa)->firstOrFail();
    return view('mahasiswa.lihat', compact('mahasiswa'));
})->name('mahasiswa.lihat');


Route::post('/tambah_mahasiswa', [mahasiswaController::class, 'store'])->name('mahasiswa.store');

Route::post('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');

Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

Route::get('/mahasiswa/cari', [MahasiswaController::class, 'cari'])->name('mahasiswa.cari');

Route::get('/mahasiswa/filter', [MahasiswaController::class, 'filter'])->name('mahasiswa.filter');


// TA
Route::get('/tugas_akhir', [TaController::class, 'index'])->name('tugas_akhir.index');
Route::post('/tugas_akhir/store', [TaController::class, 'store'])->name('tugas_akhir.store');
Route::put('/tugas_akhir/{id_ta}', [TaController::class, 'update'])->name('tugas_akhir.update');
Route::delete('/tugas_akhir/{id_ta}', action: [TaController::class, 'destroy'])->name('tugas_akhir.destroy');
Route::get('/tugas_akhir/export', [TaController::class, 'export'])->name('tugas_akhir.export');
//TA

// sertifikat mahasiswa
Route::get('/sertifikat_mahasiswa', [SertMahController::class, 'index'])->name('sertifikat_mahasiswa.index');
Route::post('/sertifikat/store', [SertMahController::class, 'store'])->name('sertifikat_mahasiswa.store');
Route::get('/get-mahasiswa', [SertMahController::class, 'getMahasiswa'])->name('get_mahasiswa');
// Route::get('/sertifikat/{id}/edit', 'SertifikatMahasiswaController@edit')->name('sertifikat_mahasiswa.edit');
// Route::put('/sertifikat/{id}', 'SertifikatMahasiswaController@update')->name('sertifikat_mahasiswa.update');
Route::resource('sertifikat_mahasiswa', SertMahController::class);
// sertifikat mahasiswa

// magang
Route::get('/magang', [MagangController::class, 'index'])->name('magang.index');
Route::resource('magang', MagangController::class);
Route::get('/magang/{id}/edit', [MagangController::class, 'edit'])->name('magang.edit');
Route::post('magang/{magang}/store-mahasiswa', [MagangController::class, 'storeMahasiswaMagang'])->name('magang.storeMahasiswaMagang');
Route::put('/magang/{magang}/mahasiswa/{mahasiswa}', [MagangController::class, 'updateMahasiswaMagang'])->name('magang.updateMahasiswaMagang');
Route::delete('/magang/{magang}/mahasiswa/{mahasiswa}', [MagangController::class, 'deleteMahasiswaMagang'])->name('magang.deleteMahasiswaMagang');
Route::get('/magang/{id}/search', [MagangController::class, 'searchMahasiswaMagang'])->name('magang.search');
Route::get('/magang/mahasiswa_magang', [MagangController::class, 'show'])->name('magang.mahasiswa_magang.show');
Route::post('/addmahasiswamagang', [MagangController::class, 'addmahasiswamagang'])->name('addmahasiswamagang');
// magang


//fajar
Route::get('/rka', [RKAController::class, 'index'])->name('rka.index');
Route::get('/rka/create', [RKAController::class, 'create'])->name('rka.create');
Route::post('/rka', [RKAController::class, 'store'])->name('rka.store');
Route::delete('/rka/delete/{id}', [RKAController::class, 'destroy'])->name('rka.destroy');
Route::get('/rka/edit/{id}', [RKAController::class, 'edit'])->name('rka.edit');
Route::put('rka/update/{id}', [RKAController::class, 'update'])->name('rka.update');

Route::get('/tor', [TorController::class, 'index'])->name('tor.index');
Route::delete('/tor/delete/{id}', [TorController::class, 'destroy'])->name('tor.destroy');
Route::post('/tor/edit', [TorController::class, 'update'])->name('tor.update');
Route::post('/tor', [TorController::class, 'store'])->name('tor.store');
//fajar


//Falah
Route::get('/ipk', [IpkController::class, 'index'])->name('ipk.index');
Route::post('/ipk/input', [IpkController::class, 'inputIpk'])->name('ipk.input');
Route::put('/ipk/{id}', [IpkController::class, 'updateIpk'])->name('ipk.update');
Route::get('/ipk/{id}/edit', [IpkController::class, 'editIpk'])->name('ipk.edit');
Route::delete('/ipk/{id}', [IpkController::class, 'deleteIpk'])->name('ipk.delete');
Route::post('/input-ipk', [IpkController::class, 'inputIpk']);
Route::get('/ipk/rekapitulasi', [IpkController::class, 'getRekapitulasi'])->name('ipk.rekapitulasi');
//Falah

//mei
Route::get('/mou', [MouController::class, 'index'])->name('mou.index');
Route::get('/mou/export', [MouController::class, 'exportExcel'])->name('mou.export');
Route::post('/mou/store', [MouController::class, 'store'])->name('mou.store');
Route::delete('/mou/{id_mou}', [MouController::class, 'destroy'])->name('mou.destroy');
Route::put('/mou/{id_mou}', [MouController::class, 'update'])->name('mou.update');
//mei


//afi
// Route Data Dosen Penelitian (CRUD)
Route::resource('penelitian-dosen', PenelitianDosenController::class);
// Route tambahan untuk menampilkan detail penelitian
Route::get('/penelitian-dosen/{id_penelitian}/detail', [PenelitianDosenController::class, 'detail'])->name('penelitian.detail');
//afi

//Diva
Route::get('/mbkm', [MbkmController::class, 'tampil'])->name('mbkm.tampil');
Route::get('/mbkm/tambah', [MbkmController::class, 'tambah'])->name('mbkm.tambah');
Route::post('/mbkm/submit', [MbkmController::class, 'submit'])->name('mbkm.submit');
// Ubah metode route dari POST ke PUT atau PATCH
Route::put('/mbkm/update/{id}', [MbkmController::class, 'update'])->name('mbkm.update');
Route::get('/mbkm/edit/{id}', [MbkmController::class, 'edit'])->name('mbkm.edit');
// Route::post('/mbkm/update/{id}', [MbkmController::class, 'update'])->name('mbkm.update');
Route::post('/mbkm/delete/{id}', [MbkmController::class, 'delete'])->name('mbkm.delete');
//Route::get('/mbkm', [MbkmController::class, 'cari'])->name('mbkm.cari');

Route::get('/mbkm/cetak/{id}', [MbkmController::class, 'cetakmbkm'])->name('mbkm.cetak');
Route::get('/mbkm/{id}', [MbkmController::class, 'detail'])->name('mbkm.detail');
//Diva

//Chinta
Route::get('/data-pemanggilan', [PemanggilanOrangtuaController::class, 'index'])->name('pemanggilan.index');
Route::get('/tambah-data', [PemanggilanOrangtuaController::class, 'tambah'])->name('pemanggilan.tambah');
Route::post('/simpan-data', [PemanggilanOrangtuaController::class, 'store'])->name('pemanggilan.store');
Route::get('/pemanggilan/{id}/edit', [PemanggilanOrangtuaController::class, 'edit'])->name('pemanggilan.edit');
Route::put('/pemanggilan/{id}', [PemanggilanOrangtuaController::class, 'update'])->name('pemanggilan.update');
Route::delete('/pemanggilan/{id}', [PemanggilanOrangtuaController::class, 'destroy'])->name('pemanggilan.destroy');
Route::get('/pemanggilan/pdf/{id}', [PemanggilanOrangtuaController::class, 'cetakPDF'])->name('pemanggilan.pdf');
Route::get('/pemanggilan/export-excel', [PemanggilanOrangtuaController::class, 'exportExcel'])->name('pemanggilan.exportExcel');
Route::post('/pemanggilan/cetak-range-pdf', [PemanggilanOrangtuaController::class, 'cetakRangePDF'])->name('pemanggilan.cetakRangePDF');
//Chinta

//Ais
Route::get('/kegiatan_dosen', [KegiatanDosenController::class, 'index'])->name('kegiatan_dosen.index');
Route::get('/kegiatan_dosen/tambah', [KegiatanDosenController::class, 'create'])->name('kegiatan_dosen.create');
Route::post('/kegiatan_dosen/store', [KegiatanDosenController::class, 'store'])->name('kegiatan_dosen.store');
Route::get('/kegiatan_dosen/edit/{id}', [KegiatanDosenController::class, 'edit'])->name('kegiatan_dosen.edit');
Route::put('/kegiatan_dosen/update/{id}', [KegiatanDosenController::class, 'update'])->name('kegiatan_dosen.update');
Route::delete('/kegiatan_dosen/{id}', [KegiatanDosenController::class, 'destroy'])->name('kegiatan_dosen.destroy');

Route::get('/kegiatan_dosen/search', [KegiatanDosenController::class, 'search'])->name('kegiatan_dosen.search');
Route::get('/kegiatan_dosen/exportpdf', [KegiatanDosenController::class, 'exportpdf']);
Route::get('/kegiatan_dosen/cetakkegiatan', [KegiatanDosenController::class, 'cetakkegiatan']);
//Ais

//Sheilya
Route::get('/prestasi', [PresMhsController::class, 'index']);
Route::get('/prestasi/create', [PresMhsController::class, 'create']);
Route::post('/prestasi/store', [PresMhsController::class, 'store']);
Route::get('/prestasi/{id}/edit', [PresMhsController::class, 'edit']);
Route::get('/prestasi/{id}/delete', [PresMhsController::class, 'destroy']);
Route::get('/prestasi/search', [PresMhsController::class, 'search']);
Route::put('/prestasi/{id}/update', [PresMhsController::class, 'update']);

route::get('prestasi/exportpdf', [PresMhsController::class, 'exportpdf']); //cetak pdf
route::get('prestasi/cetakprestasi', [PresMhsController::class, 'cetakprestasi']); //cetak pdf
//Sheilya

//indah
Route::get('/sertikomcrud', [SertikomController::class, 'index'])->name('index');
Route::get('/sertikom/tambah', [SertikomController::class, 'create'])->name('sertikom.create');
Route::post('/sertikom/tambah', [SertikomController::class, 'store'])->name('sertikom.store');
Route::get('/sertikom/{id_sertikom}/edit', [SertikomController::class, 'edit'])->name('sertikom.edit');
Route::put('/sertikom/{id_sertikom}', [SertikomController::class, 'update'])->name('sertikom.update');
Route::delete('/sertikom/{id_sertikom}', [SertikomController::class, 'destroy'])->name('sertikom.destroy');
//indah

// Adhe
// Perbaikan: Tambahkan nama 'dosen.index' agar bisa dipanggil di Blade
Route::get('/dosen', function () {
    $dosen = Dosen::all();
    return view('dosen.index', compact('dosen'));
})->name('dosen.index');
Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');

Route::get('/dosen/tambah', [DosenController::class, 'create'])->name('dosen.create');
Route::post('/dosen/store', [DosenController::class, 'store'])->name('dosen.store');
// Route::get('/dosen/{id}', [DosenController::class, 'show'])->name('dosen.show');
Route::get('/dosen/edit/{id_dosen}', [DosenController::class, 'edit'])->name('dosen.edit');
Route::put('/dosen/{id_dosen}', [DosenController::class, 'update'])->name('dosen.update');
Route::delete('/dosen/{id_dosen}', [DosenController::class, 'destroy'])->name('dosen.destroy');
Route::get('/dosen', [DosenController::class, 'cari'])->name('dosen.index');
//Adhe

//astrid
// route::get('/wisuda/laporan', [::class, 'index']);

Route::get('/wisuda', function () {
    return view('laporan.index');
});

Route::get('/wisuda/preview', function () {
    return view('laporan.cetak');
});
Route::get('/wisuda/preview/hasil', function () {
    return view('laporan.hasil');
});

route::get('wisuda/preview/cetak', [WisudaController::class, 'cetakWisuda']);
Route::get('/wisuda', [WisudaController::class, 'index']);
Route::get('/wisuda/preview', [WisudaController::class, 'preview']);
route::get('/wisuda/search', [WisudaController::class, 'searchPreview']);
route::get('wisuda/cetakWisuda', [WisudaController::class, 'cetakWisuda'])->name('wisuda.hasil');
route::get('wisuda/exportpdf', [WisudaController::class, 'exportpdf'])->name('wisuda.exportpdf');

//Route::get('/wisuda/lihat', [WisudaController::class, 'lihat'])->name('wisuda.hasil');
//astrid


//dita
Route::get('/wisuda', function () {
    return view('admin.wissuda.index');
});
Route::get('/wisuda/create', function () {
    return view('admin.wisuda.create');
});
Route::get('/wisuda/detail', function () {
    return view('admin.wisuda.detail');
});
Route::get('/wisuda/edit', function () {
    return view('admin.wisuda.edit');
});

Route::get('/wissuda', [WisudaController::class, 'index']);
Route::get('/wissuda/{id}/detail', [WisudaController::class, 'show']);
Route::get('/wissuda/create', [WisudaController::class, 'create']);
Route::post('/wissuda/store', [WisudaController::class, 'store']);
Route::get('/wissuda/{id}/edit', [WisudaController::class, 'edit']);
Route::put('/wissuda/{id}/update', [WisudaController::class, 'update']);
Route::get('/wissuda/{id}/delete', [WisudaController::class, 'destroy']);
Route::get('/wissuda/search', [WisudaController::class, 'search']);
Route::get('/wissuda/export', [WisudaController::class, 'export']);


Route::get('/sk', [TahunWisudaController::class, 'index']);
Route::get('/sk/create', [TahunWisudaController::class, 'create']);
Route::post('/sk/store', [TahunWisudaController::class, 'store']);
Route::get('/sk/{id}/edit', [TahunWisudaController::class, 'edit']);
Route::put('/sk/{id}/update', [TahunWisudaController::class, 'update']);
Route::get('/sk/{id}/delete', [TahunWisudaController::class, 'destroy']);
Route::get('/sk/search', [TahunWisudaController::class, 'search']);
//dita


//irma
  Route::get('/', [MahasiswaSemesterPerpanjanganController::class, 'tampil_mahasiswa_perpanjangan'])
        ->name('index');

    Route::get('/maspan', [MahasiswaSemesterPerpanjanganController::class, 'tampil_mahasiswa_perpanjangan'])
    ->name('maspan.index');

    Route::get('/search', [MahasiswaSemesterPerpanjanganController::class, 'search'])
        ->name('maspan.search');

    Route::get('/maspan/tambah', [MahasiswaSemesterPerpanjanganController::class, 'tampiltambah']) 
    -> name ('maspan.tambah');

     Route::post('/maspan/simpan', [MahasiswaSemesterPerpanjanganController::class, 'store']) 
    -> name ('maspan.simpan');
  
    Route::get('/maspan/{id}/edit', [MahasiswaSemesterPerpanjanganController::class, 'edit'])
        ->name('maspan.edit'); // Sesuai dengan yang dipakai di Blade

    Route::put('/{id}', [MahasiswaSemesterPerpanjanganController::class, 'update'])
        ->name('amspan.update');
    
    Route::delete('/{id}', [MahasiswaSemesterPerpanjanganController::class, 'destroy'])
        ->name('maspan.destroy');

   
    Route::put('/maspan/{id}', [MahasiswaSemesterPerpanjanganController::class, 'update'])->name('maspan.update'); // Untuk menyimpan perubahan

    Route::get('maspan/exportpdf', [MahasiswaSemesterPerpanjanganController::class, 'exportpdf']); //cetak pdf
    Route::get('maspan/cetakmaspan', [MahasiswaSemesterPerpanjanganController::class, 'cetakdata']); //cetak pdf

// ✅ Gunakan prefix 'maspan' untuk mengelompokkan route
    Route::prefix('maspan')->name('maspan.')->group(function () {
        

});
//irma

//yuni
// Route::get('/pkm', function () {
//     return view('pkm.index');
// });

Route::get('/pkm', [PkmController::class, 'index'])->name('index');
Route::get('/pkm/tambah', [PkmController::class, 'create'])->name('pkm.create');
Route::post('/pkm/tambah', [PkmController::class, 'store'])->name('pkm.store');
// Route::post('/pkm/edit', [PkmController::class, 'store'])->name('pkm.edit');
Route::delete('/pkm/{id}', [PkmController::class, 'destroy'])->name('pkm.destroy');
Route::get('/pkm', [PkmController::class, 'index'])->name('pkm.index');
Route::get('/pkm/{id}/edit', [PkmController::class, 'edit'])->name('pkm.edit');
Route::put('/pkm/{id}', [PkmController::class, 'update'])->name('pkm.update');
Route::get('/pkm/{id}', [PkmController::class, 'show'])->name('pkm.show');
// Route::delete('/pkm/{id_pkm}', [PkmController::class, 'destroy'])->name('pkm.destroy');
//

//isna
Route::get('/yudisium', [YudisiumController::class, 'index'])->name('yudisium.index'); // Halaman utama
Route::get('/yudisium/create', [YudisiumController::class, 'create']); // Form tambah data
Route::post('/yudisium/store', [YudisiumController::class, 'store']); //name('yudisium.store');

// Route::post('yudisium/store', [YudisiumController::class, 'store']); // Simpan data
Route::get('/yudisium/{id}/edit', [YudisiumController::class, 'edit'])->name('yudisium.edit');
Route::put('/yudisium/{id}', [YudisiumController::class, 'update'])->name('yudisium.update');
Route::delete('/yudisium/{id}', [YudisiumController::class, 'destroy'])->name('yudisium.destroy');
// Route::get('/yudisium/ganjil', [YudisiumController::class, 'ganjil'])->name('yudisium.ganjil');
// Route::get('/yudisium/genap', [YudisiumController::class, 'genap'])->name('yudisium.genap');
Route::get('yudisium/search', [YudisiumController::class, 'search']);
Route::resource('mahasiswa', MahasiswaController::class);

route::get('/yudisium/exportpdf', [YudisiumController::class, 'exportpdf']); //cetak pdf
route::get('/yudisium/cetakyudisium', [YudisiumController::class, 'cetakyudisium']); //cetak pdf
//isna
// require __DIR__ . '/auth.php';
Route::get('{route}', function ($route) {
    return response("<h1>{$route} Not Found</h1>", 200)
           ->header('Content-Type', 'text/html');
});
