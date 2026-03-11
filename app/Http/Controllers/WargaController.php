<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::with(['anggotaKeluarga', 'rumahs'])->whereNull('kepala_keluarga_id');

        // Search by Name or NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status_warga', $request->status);
        }

        $wargas = $query->latest()->paginate(10)->withQueryString();
        
        return view('wargas.index', compact('wargas'));
    }

    public function show(Warga $warga)
    {
        $warga->load(['anggotaKeluarga', 'rumahs']);
        return view('wargas.show', compact('warga'));
    }

    public function create()
    {
        $kepalaKeluargas = Warga::where('is_active', true)->whereNull('kepala_keluarga_id')->orderBy('nama')->get();
        return view('wargas.create', compact('kepalaKeluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Head of Family Data
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:wargas,nik',
            'no_hp' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_warga' => 'required|in:Tetap,Kontrak,Kosong',
            
            // Optional Family Members
            'anggota' => 'nullable|array',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.nik' => 'nullable|string|unique:wargas,nik',
            'anggota.*.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'anggota.*.hubungan_keluarga' => 'required|string',
        ]);

        // 1. Save Head of Family
        $kepala = Warga::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'no_hp' => $validated['no_hp'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'status_warga' => $validated['status_warga'],
            'is_active' => true,
        ]);

        // 2. Save Family Members if any
        if ($request->has('anggota')) {
            foreach ($validated['anggota'] as $data) {
                Warga::create([
                    'kepala_keluarga_id' => $kepala->id,
                    'nama' => $data['nama'],
                    'nik' => $data['nik'] ?? null,
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'hubungan_keluarga' => $data['hubungan_keluarga'],
                    'status_warga' => $kepala->status_warga, // Same as KK
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('wargas.index')->with('success', 'Data keluarga berhasil disimpan!');
    }

    public function edit(Warga $warga)
    {
        $kepalaKeluargas = Warga::where('is_active', true)->whereNull('kepala_keluarga_id')->where('id', '!=', $warga->id)->orderBy('nama')->get();
        return view('wargas.edit', compact('warga', 'kepalaKeluargas'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:wargas,nik,' . $warga->id,
            'no_hp' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_warga' => 'required|in:Tetap,Kontrak,Kosong',
            'kepala_keluarga_id' => 'nullable|exists:wargas,id',
            'hubungan_keluarga' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $warga->update($validated);

        return redirect()->route('wargas.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('wargas.index')->with('success', 'Warga berhasil dihapus!');
    }
}
