<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Wisuda;
use App\Models\skModel;
use App\Models\WisudaModel;
use Shuchkin\SimpleXLSXGen;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunWisudaModel;
use Illuminate\Support\Facades\DB;

class WisudaController extends Controller
{
    /**
     * Display a listing of the resource. (Dita)
     */
    public function index()
    {
        $wisuda = WisudaModel::with(['mahasiswa', 'sk'])->get();
        return view('admin.wissuda.index', compact('wisuda'));
    }

    public function preview()
    {
        session()->forget(['wisuda_data', 'rekapitulasi_data']);

        // Ambil data dan muat relasi sk
        $wisuda = WisudaModel::with('sk')->get();

        // Ambil tahun wisuda dari relasi sk
        $tahunList = $wisuda->map(function ($item) {
            return optional($item->sk)->tahun_wisuda;
        })->filter()->unique()->sort()->values(); // tambahkan sort & reset index

        $rekapitulasi = [];

        foreach ($tahunList as $tahun) {
            $sudahWisuda = $wisuda->filter(function ($item) use ($tahun) {
                return optional($item->sk)->tahun_wisuda === $tahun && $item->status_wisuda === 'Sudah Wisuda';
            })->count();

            $rekapitulasi[] = [
                'tahun_wisuda' => $tahun,
                'sudah_wisuda' => $sudahWisuda,
            ];
        }

        // Simpan ke session jika ingin digunakan kembali (misal: cetak PDF)
        session([
            'wisuda_data' => $wisuda,
            'rekapitulasi_data' => $rekapitulasi
        ]);

        return view('laporan.cetak', compact('wisuda', 'rekapitulasi'));
    }

    // fungsi untuk cari
    public function searchPreview(Request $request)
    {
        $search = $request->input('search');
        $rekapitulasi = [];

        if (!empty($search)) {
            $wisuda = WisudaModel::when($search, function ($query) use ($search) {
                $query->whereHas('sk', function ($q) use ($search) {
                    $q->where('tahun_wisuda', 'LIKE', '%' . $search . '%');
                });
            })->get();
        } else {
            $wisuda = WisudaModel::all();
        }

        foreach ($wisuda as $item) {
            $tahun = optional($item->sk)->tahun_wisuda ?? 'Tidak Diketahui';
            if (!isset($rekapitulasi[$tahun])) {
                $rekapitulasi[$tahun] = 0;
            }

            if ($item->status_wisuda === 'Sudah Wisuda') {
                $rekapitulasi[$tahun]++;
            }
        }

        $rekapitulasi = collect($rekapitulasi)->map(function ($count, $tahun) {
            return [
                'tahun_wisuda' => $tahun,
                'sudah_wisuda' => $count,
            ];
        })->values();

        // Simpan hasil filter ke session agar bisa dipakai di preview/download
        session([
            'wisuda_data' => $wisuda,
            'rekapitulasi_data' => $rekapitulasi,
        ]);

        return view('laporan.cetak', compact('wisuda', 'rekapitulasi'));
    }


    public function lihat()
    {
        $wisuda = session('wisuda_data', WisudaModel::all());
        $rekapitulasi = session('rekapitulasi_data', collect([]));

        return view('laporan.hasil', compact('wisuda', 'rekapitulasi'));
    }


    /**
     * Show the form for creating a new resource. (Dita)
     */
    public function create()
    {
        // Ambil semua NIM yang sudah ada di tabel wisuda
        $nimTerdaftar = WisudaModel::pluck('nim')->toArray();

        // Ambil mahasiswa yang belum ada di tabel wisuda
        $mahasiswa = MahasiswaModel::whereNotIn('nim', $nimTerdaftar)->get();

        // Ambil data tahun wisuda
        $tahun_wisuda = TahunWisudaModel::all();

        return view('admin.wissuda.create', compact('mahasiswa', 'tahun_wisuda'));
    }

    /**
     * Store a newly created resource in storage. (Dita)
     */

    public function store(Request $request)
    {
        $isSudahWisuda = $request->status_wisuda === 'Sudah Wisuda';

        $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'semester' => 'required|numeric',
            'status_wisuda' => 'required|string|max:50',
            'tahun_wisuda_id' => $isSudahWisuda ? 'required|exists:tahun_wisuda,id' : 'nullable'
        ], [
            'nim.required' => 'Mahasiswa tidak boleh kosong.',
            'semester.required' => 'Semester tidak boleh kosong.',
            'semester.numeric' => 'Semester harus berupa angka.',
            'status_wisuda.required' => 'Status wisuda tidak boleh kosong.',
            'tahun_wisuda_id.required' => 'Tahun Wisuda tidak boleh kosong jika sudah wisuda.',
            'tahun_wisuda_id.exists' => 'Tahun Wisuda yang dipilih tidak valid.'
        ]);

        WisudaModel::create([
            'nim' => $request->nim,
            'semester' => $request->semester,
            'status_wisuda' => $request->status_wisuda,
            'tahun_wisuda_id' => $isSudahWisuda ? $request->tahun_wisuda_id : null,
        ]);
        DB::table('mahasiswa')->where('nim', $request->nim)->update([
            'status_aktif' => $isSudahWisuda ? 'Lulus' : 'Aktif'
        ]);

        session()->flash('success', 'Data wisuda berhasil ditambahkan.');
        return redirect('/wissuda');
    }



    /**
     * Display the specified resource.(Dita)
     */
    public function show(string $id)
    {
        // Cari data wisuda berdasarkan id_wisuda
        $wisuda = WisudaModel::findOrFail($id);

        // Cari data mahasiswa berdasarkan nim di tabel wisuda
        $mahasiswa = MahasiswaModel::where('nim', $wisuda->nim)->firstOrFail();



        return view('admin.wissuda.detail', compact('wisuda', 'mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource. (Dita)
     */
    public function edit($id)
    {
        $wisuda = WisudaModel::findOrFail($id);

        // Ambil semua mahasiswa (boleh semua atau sesuai kebutuhan)
        $mahasiswa = MahasiswaModel::all();

        // Ambil data tahun wisuda
        $tahun_wisuda = TahunWisudaModel::all();

        return view('admin.wissuda.edit', compact('wisuda', 'mahasiswa', 'tahun_wisuda'));
    }

    /**
     * Update the specified resource in storage.(Dita)
     */
    public function update(Request $request, string $id)
    {
        $wisuda = WisudaModel::findOrFail($id);

        $isSudahWisuda = $request->status_wisuda === 'Sudah Wisuda';

        $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'semester' => 'required|integer|min:1|max:14',
            'status_wisuda' => 'required|string|max:50',
            'tahun_wisuda_id' => $isSudahWisuda ? 'required|exists:tahun_wisuda,id' : 'nullable'
        ], [
            'nim.required' => 'Mahasiswa tidak boleh kosong.',
            'semester.required' => 'Semester tidak boleh kosong.',
            'semester.integer' => 'Semester harus berupa angka.',
            'status_wisuda.required' => 'Status wisuda tidak boleh kosong.',
            'tahun_wisuda_id.required' => 'Tahun Wisuda tidak boleh kosong jika sudah wisuda.',
            'tahun_wisuda_id.exists' => 'Tahun Wisuda yang dipilih tidak valid.'
        ]);

        $wisuda->update([
            'nim' => $request->nim,
            'semester' => $request->semester,
            'status_wisuda' => $request->status_wisuda,
            'tahun_wisuda_id' => $isSudahWisuda ? $request->tahun_wisuda_id : null,
        ]);

        // Update juga status mahasiswa
        DB::table('mahasiswa')->where('nim', $request->nim)->update([
            'status_aktif' => $isSudahWisuda ? 'Lulus' : 'Aktif'
        ]);

        session()->flash('success', 'Data wisuda berhasil diperbarui.');
        return redirect('/wissuda');
    }

    /**
     * Remove the specified resource from storage. (Dita)
     */
    public function destroy(string $id)
    {
        $wisuda = WisudaModel::find($id);

        if (!$wisuda) {
            return redirect('/wissuda')->with('error', 'Data tidak ditemukan.');
        }

        DB::table('mahasiswa')->where('nim', $wisuda->nim)->update([
            'status_aktif' => 'Aktif'
        ]);

        $wisuda->delete();
        return redirect('/wissuda')->with('success', 'Data wisuda berhasil dihapus.');
    }

    /**
     * Untuk search di index data wisuda. (Dita)
     */

    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!empty($search)) {
            $wisuda = WisudaModel::when($search, function ($query) use ($search) {
                $query->whereHas('sk', function ($q) use ($search) {
                    $q->where('tahun_wisuda', 'LIKE', '%' . $search . '%');
                })->orWhereHas('mahasiswa', function ($q) use ($search) {
                    $q->where('nama_mahasiswa', 'LIKE',  '%' . $search . '%');
                });
            })->paginate(10);
        } else {
            $wisuda = WisudaModel::all();
        }

        return view('admin.wissuda.index', compact('wisuda'));
    }

    /**
     * Untuk eksport data wisuda dalam bentuk excel. (Dita)
     */

    public function export()
    {
        $wisuda = WisudaModel::with('mahasiswa', 'sk')->get();

        // Data header
        $data = [
            ["No", "NIM", "Nama", "Status Wisuda", "Tahun Wisuda"]
        ];

        // Isi data dari database
        foreach ($wisuda as $index => $wsd) {
            $data[] = [
                $index + 1,
                $wsd->mahasiswa->nim,
                $wsd->mahasiswa->nama_mahasiswa,
                $wsd->status_wisuda,
                $wsd->sk ? $wsd->sk->tahun_wisuda : '-',
            ];
        }

        // Generate file Excel
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('data-wisuda.xlsx');
    }

    //fungsi cetak wisuda
    public function cetakWisuda()
    {
        $wisuda = session()->get('wisuda_data', Wisuda::all());
        $rekapitulasi = session()->get('rekapitulasi_data', []);

        // Jika session tidak ada, hitung rekapitulasi ulang
        if (empty($rekapitulasi)) {
            $sk = $wisuda->pluck('tahun_wisuda')->unique();
            foreach ($sk as $tahun) {
                $sudahWisuda = $wisuda->where('tahun_wisuda', $tahun)->where('status_wisuda', 'Sudah Wisuda')->count();
                $rekapitulasi[] = [
                    'tahun_wisuda' => $tahun,
                    'sudah_wisuda' => $sudahWisuda,
                ];
            }
        }

        return view('laporan.hasil', compact('wisuda', 'rekapitulasi'));
    }


    public function exportpdf()
    {
        // Ambil data dari session atau ambil semua jika tidak ada di session
        $wisuda = session()->get('wisuda_data', Wisuda::all());
        $rekapitulasi = session()->get('rekapitulasi_data', []);

        // Periksa apakah session kosong
        if (empty($rekapitulasi)) {
            // Buat rekapitulasi ulang jika tidak ada di session
            $sk = $wisuda->pluck('tahun_wisuda')->unique();
            foreach ($sk as $tahun) {
                $sudahWisuda = $wisuda->where('tahun_wisuda', $tahun)->where('status_wisuda', 'Sudah Wisuda')->count();
                $rekapitulasi[] = [
                    'tahun_wisuda' => $tahun,
                    'sudah_wisuda' => $sudahWisuda,
                ];
            }
        }

        // Load view dan generate PDF
        $pdf = PDF::loadView('laporan.hasil', compact('wisuda', 'rekapitulasi'));
        return $pdf->download('wisuda-' . Carbon::now()->timestamp . '.pdf');
    }
}
