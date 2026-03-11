<?php

namespace App\Http\Controllers;

use App\Models\Pengeluarans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluarans::query();

        // Search by Description
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', "%{$request->search}%");
        }

        // Filter by Month/Year
        if ($request->filled('month')) {
            $query->whereMonth('tanggal', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('tanggal', $request->year);
        }

        $pengeluarans = $query->latest()->paginate(10)->withQueryString();
        
        return view('pengeluarans.index', compact('pengeluarans'));
    }

    public function create()
    {
        return view('pengeluarans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'bukti_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $path = $request->file('bukti_foto')->store('pengeluaran', 'public');
            $validated['bukti_foto'] = $path;
        }

        // pj_id could be auth()->id() if auth is set up
        $validated['pj_id'] = null;

        Pengeluarans::create($validated);

        return redirect()->route('pengeluarans.index')->with('success', 'Catatan pengeluaran berhasil disimpan!');
    }

    public function edit(Pengeluarans $pengeluaran)
    {
        return view('pengeluarans.edit', compact('pengeluaran'));
    }

    public function update(Request $request, Pengeluarans $pengeluaran)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'bukti_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti_foto')) {
            // Delete old photo if exists
            if ($pengeluaran->bukti_foto) {
                Storage::disk('public')->delete($pengeluaran->bukti_foto);
            }
            $path = $request->file('bukti_foto')->store('pengeluaran', 'public');
            $validated['bukti_foto'] = $path;
        }

        $pengeluaran->update($validated);

        return redirect()->route('pengeluarans.index')->with('success', 'Catatan pengeluaran berhasil diperbarui!');
    }

    public function destroy(Pengeluarans $pengeluaran)
    {
        if ($pengeluaran->bukti_foto) {
            Storage::disk('public')->delete($pengeluaran->bukti_foto);
        }
        $pengeluaran->delete();
        return redirect()->route('pengeluarans.index')->with('success', 'Catatan pengeluaran berhasil dihapus!');
    }
}
