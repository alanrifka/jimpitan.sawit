<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KasMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = KasMasuk::query();

        if ($request->filled('search')) {
            $query->where('sumber', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('month')) {
            $query->whereMonth('tanggal', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('tanggal', $request->year);
        }

        $kasMasuks = $query->latest('tanggal')->paginate(15)->withQueryString();
        $totalKasMasuk = $query->sum('jumlah');

        return view('kas-masuks.index', compact('kasMasuks', 'totalKasMasuk'));
    }

    public function create()
    {
        $kategoris = ['Rutin', 'Donasi', 'Sumbangan', 'Subsidi Pemerintah', 'Iuran Wajib', 'Lain-lain'];
        return view('kas-masuks.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'sumber'     => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:1000',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->only(['tanggal', 'sumber', 'kategori', 'jumlah', 'keterangan']);

        if ($request->hasFile('bukti_foto')) {
            $data['bukti_foto'] = $request->file('bukti_foto')->store('kas-masuk-bukti', 'public');
        }

        KasMasuk::create($data);

        return redirect()->route('kas-masuks.index')->with('success', 'Data kas masuk berhasil disimpan.');
    }

    public function show(KasMasuk $kasMasuk)
    {
        return view('kas-masuks.show', compact('kasMasuk'));
    }

    public function edit(KasMasuk $kasMasuk)
    {
        $kategoris = ['Rutin', 'Donasi', 'Sumbangan', 'Subsidi Pemerintah', 'Iuran Wajib', 'Lain-lain'];
        return view('kas-masuks.edit', compact('kasMasuk', 'kategoris'));
    }

    public function update(Request $request, KasMasuk $kasMasuk)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'sumber'     => 'required|string|max:255',
            'kategori'   => 'required|string|max:100',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:1000',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->only(['tanggal', 'sumber', 'kategori', 'jumlah', 'keterangan']);

        if ($request->hasFile('bukti_foto')) {
            if ($kasMasuk->bukti_foto) {
                Storage::disk('public')->delete($kasMasuk->bukti_foto);
            }
            $data['bukti_foto'] = $request->file('bukti_foto')->store('kas-masuk-bukti', 'public');
        }

        $kasMasuk->update($data);

        return redirect()->route('kas-masuks.index')->with('success', 'Data kas masuk berhasil diperbarui.');
    }

    public function destroy(KasMasuk $kasMasuk)
    {
        if ($kasMasuk->bukti_foto) {
            Storage::disk('public')->delete($kasMasuk->bukti_foto);
        }

        $kasMasuk->delete();
        return redirect()->route('kas-masuks.index')->with('success', 'Data kas masuk berhasil dihapus.');
    }
}
