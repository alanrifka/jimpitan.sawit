<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;

class RumahController extends Controller
{
    public function index(Request $request)
    {
        $query = Rumah::with('kepalaKeluarga');

        // Search by House ID / Block
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_rumah', 'like', "%{$search}%")
                  ->orWhere('blok', 'like', "%{$search}%");
            });
        }

        // Filter by Residency Status (from related Warga)
        if ($request->filled('status')) {
            $query->whereHas('kepalaKeluarga', function($q) use ($request) {
                $q->where('status_warga', $request->status);
            });
        }

        $rumahs = $query->latest()->paginate(10)->withQueryString();
        return view('rumahs.index', compact('rumahs'));
    }

    public function create()
    {
        $wargas = Warga::where('is_active', true)->whereNull('kepala_keluarga_id')->orderBy('nama')->get();
        return view('rumahs.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rumah' => 'required|string|max:50',
            'blok' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'kepala_keluarga_id' => 'nullable|exists:wargas,id',
        ]);

        Rumah::create($validated);

        return redirect()->route('rumahs.index')->with('success', 'Data rumah berhasil ditambahkan!');
    }

    public function edit(Rumah $rumah)
    {
        $wargas = Warga::where('is_active', true)->whereNull('kepala_keluarga_id')->orderBy('nama')->get();
        return view('rumahs.edit', compact('rumah', 'wargas'));
    }

    public function update(Request $request, Rumah $rumah)
    {
        $validated = $request->validate([
            'no_rumah' => 'required|string|max:50',
            'blok' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'kepala_keluarga_id' => 'nullable|exists:wargas,id',
        ]);

        $rumah->update($validated);

        return redirect()->route('rumahs.index')->with('success', 'Data rumah berhasil diperbarui!');
    }

    public function destroy(Rumah $rumah)
    {
        $rumah->delete();
        return redirect()->route('rumahs.index')->with('success', 'Data rumah berhasil dihapus!');
    }
}
