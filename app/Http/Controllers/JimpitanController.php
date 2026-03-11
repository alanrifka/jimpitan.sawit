<?php

namespace App\Http\Controllers;

use App\Models\Jimpitan;
use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;

class JimpitanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jimpitan::with(['rumah.kepalaKeluarga']);

        // Search by House ID, description, or Resident name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('rumah', function($rq) use ($search) {
                      $rq->where('no_rumah', 'like', "%{$search}%")
                         ->orWhereHas('kepalaKeluarga', function($wq) use ($search) {
                             $wq->where('nama', 'like', "%{$search}%");
                         });
                  });
            });
        }

        // Filter by Date Range (Bulan / Tahun)
        if ($request->filled('month')) {
            $query->whereMonth('tanggal', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('tanggal', $request->year);
        }

        $jimpitans = $query->latest()->paginate(15)->withQueryString();
        return view('jimpitans.index', compact('jimpitans'));
    }

    public function create()
    {
        $rumahs = Rumah::with('kepalaKeluarga')->orderBy('no_rumah')->get();
        return view('jimpitans.create', compact('rumahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rumah_id' => 'required|exists:rumahs,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Automatically set warga_id from the house's kepala keluarga
        $rumah = Rumah::find($request->rumah_id);
        $validated['warga_id'] = $rumah->kepala_keluarga_id;
        
        // In a real app, petugas_id would be auth()->id()
        // For now, let's keep it null or hardcode if users exist
        $validated['petugas_id'] = null; 

        Jimpitan::create($validated);

        return redirect()->route('jimpitans.index')->with('success', 'Iuran jimpitan berhasil dicatat!');
    }

    public function edit(Jimpitan $jimpitan)
    {
        $rumahs = Rumah::orderBy('no_rumah')->get();
        return view('jimpitans.edit', compact('jimpitan', 'rumahs'));
    }

    public function update(Request $request, Jimpitan $jimpitan)
    {
        $validated = $request->validate([
            'rumah_id' => 'required|exists:rumahs,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $rumah = Rumah::find($request->rumah_id);
        $validated['warga_id'] = $rumah->kepala_keluarga_id;

        $jimpitan->update($validated);

        return redirect()->route('jimpitans.index')->with('success', 'Data iuran berhasil diperbarui!');
    }

    public function destroy(Jimpitan $jimpitan)
    {
        $jimpitan->delete();
        return redirect()->route('jimpitans.index')->with('success', 'Data iuran berhasil dihapus!');
    }

    public function printCard(Request $request, Warga $warga)
    {
        $bulan = (int) $request->query('bulan', date('m'));
        $tahun = (int) $request->query('tahun', date('Y'));

        // Ambil data jimpitan warga ini (melalui rumah yang dikepalainya)
        $jimpitans = Jimpitan::whereHas('rumah', function($q) use ($warga) {
            $q->where('kepala_keluarga_id', $warga->id);
        })
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get()
        ->keyBy(function($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('j');
        });

        return view('jimpitans.print_card', compact('warga', 'jimpitans', 'bulan', 'tahun'));
    }
}
