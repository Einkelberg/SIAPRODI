<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanDosenModels;
use App\Models\DosenModels;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class KegiatanDosenController extends Controller
{
    public function index(Request $request)
    {
        $kegiatan = KegiatanDosenModels::with('dosen')->get();
        return view('kegiatan_dosen.index', ['kegiatan_dosen' => $kegiatan]);
    }

    public function create()
    {
        $dosen = DosenModels::all();
        $kegiatan = KegiatanDosenModels::all();
        return view('kegiatan_dosen.create', compact('dosen', 'kegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|exists:dosen,nidn',
            'jenis_kegiatan' => 'required',
            'lokasi_kegiatan' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'nomor_sk' => 'required',
            'file_sk' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // File opsional, hanya PDF/DOC max 2MB
            'keterangan' => 'nullable',
        ]);

        $dokumenPath = null;
        if ($request->hasFile('file_sk')) {
            $dokumenPath = $request->file('file_sk')->store('upload_file_sk', 'public');
        }

        KegiatanDosenModels::create([
            'nidn' => $request->nidn,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'nomor_sk' => $request->nomor_sk,
            'file_sk' => $dokumenPath,
            'keterangan' => $request->keterangan ?? '-',
        ]);

        return redirect()->route('kegiatan_dosen.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id_kegiatan_dosen)
    {
        $dosen = DosenModels::all();
        $kegiatan = KegiatanDosenModels::Find($id_kegiatan_dosen);
        return view('kegiatan_dosen.edit', ['kegiatan_dosen' => $kegiatan], ['dosen' => $dosen]);
    }

    public function update(Request $request, $id_kegiatan_dosen)
    {
        $request->validate([
            'nidn' => 'required',
            'jenis_kegiatan' => 'required',
            'lokasi_kegiatan' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'nomor_sk' => 'required|regex:/^SK\/\d{3}\/[A-Z]{2}\/\d{4}$/', //ex. SK/123/TI/2025
            'file_sk' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'required',
        ]);

        $kegiatan = KegiatanDosenModels::find($id_kegiatan_dosen);
        $kegiatan->nidn = $request->nidn;
        $kegiatan->jenis_kegiatan = $request->jenis_kegiatan;
        $kegiatan->lokasi_kegiatan = $request->lokasi_kegiatan;
        $kegiatan->tgl_mulai = $request->tgl_mulai;
        $kegiatan->tgl_selesai = $request->tgl_selesai;
        $kegiatan->nomor_sk = $request->nomor_sk;
        $kegiatan->keterangan = $request->keterangan;
        $kegiatan->file_sk = $kegiatan->file_sk;

        // Cek apakah ada file yang diupload
        if ($request->hasFile('file_sk')) {

            // Simpan file baru ke storage
            $dokumenPath = $request->file('file_sk')->store('public/upload_file_sk');
            $kegiatan->file_sk = str_replace('public/', '', $dokumenPath);
        }

        $kegiatan->update([
            'nama_dosen' => $request->nama_dosen,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'nomor_sk' => $request->nomor_sk,
            'keterangan' => $request->keterangan,
            'file_sk' => $kegiatan->file_sk,
        ]);

        return redirect()->route('kegiatan_dosen.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id_kegiatan_dosen)
    {
        $kegiatan = KegiatanDosenModels::FindOrFail($id_kegiatan_dosen);
        $kegiatan->delete();

        return redirect()->route('kegiatan_dosen.index')->with('success', 'Data berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $kegiatan = KegiatanDosenModels::join('dosen', 'kegiatan_dosen.nidn', '=', 'dosen.nidn')
            ->where('dosen.nama_dosen', 'LIKE', "%$search%")
            ->orWhere('kegiatan_dosen.nidn', 'LIKE', "%$search%")
            ->select('kegiatan_dosen.*', 'dosen.nama_dosen')
            ->get();

        return view('kegiatan_dosen.index', [
            'kegiatan_dosen' => $kegiatan
        ]);
    }

    public function exportpdf()
    {
        try {
            $kegiatan = KegiatanDosenModels::all();
            $pdf = PDF::loadView('kegiatan_dosen.cetak', ['kegiatan_dosen' => $kegiatan]);

            // Unduh file PDF
            return $pdf->download('kegiatan-dosen-' . Carbon::now()->timestamp . '.pdf');

        } catch (\Exception $e) {
            // Tangani error dan kembalikan response dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat PDF: ' . $e->getMessage());
        }
    }
    public function cetakkegiatan()
    {
        $kegiatan = KegiatanDosenModels::all();
        return view('kegiatan_dosen.cetak', ['kegiatan_dosen' => $kegiatan]);
    }

}
