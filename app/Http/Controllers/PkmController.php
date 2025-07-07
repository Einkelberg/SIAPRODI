<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Dosen;
use App\Models\Pkm;
use App\Models\Mahasiswa;

use Illuminate\Http\Request;

class PkmController extends Controller
{
    // public function index()
    // {
    //     $pkm = Pkm::with('dosen')->get();
    //     return view('pkm.index', compact('pkm'));
    // }

    public function index(Request $request)
{
    $search = $request->input('search'); // Ambil input pencarian

   $pkm = DB::table('pkm')
    ->when($search, function ($query, $search) {
        return $query->where(function ($query) use ($search) {
            $query->where('nama_mahasiswa', 'like', "%$search%")
                ->orWhere('nama_dosen', 'like', "%$search%")
                ->orWhere('judul', 'like', "%$search%")
                ->orWhere('tahun', 'like', "%$search%");
        });
    })
    ->paginate(10);

    return view('pkm.index', compact('pkm'));
}
    

public function edit($id)
{
    $pkm = Pkm::findOrFail($id);

    return view('pkm.edit_pkm', compact('pkm'));
}

public function update(Request $request, $id)
{
   $pkm = Pkm::findOrFail($id);

    $pkm->update([
        'judul' => $request->input('judul'),
        'tahun' => $request->input('tahun'),
        'lokasi' => $request->input('lokasi'),
        'anggaran' => $request->input('anggaran'),
        'status' => $request->input('status'),
        'nama_dosen' => implode(',', $request->input('nama_dosen', [])),
        'nidn' => implode(',', $request->input('nidn', [])),
        'nama_mahasiswa' => implode(',', $request->input('nama_mahasiswa', [])),
        'nim' => implode(',', $request->input('nim', [])),
    ]);

    return redirect()->route('pkm.index')->with('success', 'Data PKM berhasil diupdate.');

}

    public function create()
{
    $dosen = Dosen::all();
    $mahasiswa = Mahasiswa::all(); // Ambil data mahasiswa dari database
    return view('pkm.tambah_pkm', compact('dosen', 'mahasiswa'));
}


public function destroy($id)
{
    $pkm = Pkm::find($id);
    if($pkm){
        $pkm->delete();

        return redirect()->route('pkm.index')->with('success', 'Data berhasil dihapus');
    }
}

public function show($id)
{
    $pkm = Pkm::findOrFail($id); // Atau model sesuai nama
    return view('pkm.show', compact('pkm'));
}


    // Menyimpan data mahasiswa
    public function store(Request $request)
{
    $request->validate([
        'nama_dosen' => 'required|array|min:1',
        'nama_dosen.*' => 'required|string|max:100',

        'nidn' => 'required|array|min:1',
        'nidn.*' => 'required|string|max:20',

        'nama_mahasiswa' => 'required|array|min:1',
        'nama_mahasiswa.*' => 'required|string|max:100',

        'nim' => 'required|array|min:1',
        'nim.*' => 'required|string|max:20',

        'judul' => 'required|string|max:255',
        'tahun' => 'required|integer|min:2000|max:' . date('Y'),
        'lokasi' => 'required|string|max:255',
        'anggaran' => 'required|numeric|min:0',
        'status' => 'required|in:Dalam Proses,Selesai,Dibatalkan',
    ]);

    Pkm::create([
        'judul' => $request->judul,
        'tahun' => $request->tahun,
        'lokasi' => $request->lokasi,
        'anggaran' => $request->anggaran,
        'status' => $request->status,
        'nama_dosen' => implode(', ', $request->nama_dosen),
        'nidn' => implode(', ', $request->nidn),
        'nama_mahasiswa' => implode(', ', $request->nama_mahasiswa),
        'nim' => implode(', ', $request->nim),
    ]);

    return redirect()->route('pkm.index')->with('success', 'PKM berhasil ditambahkan!');
}


}