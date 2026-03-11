<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Rumah;
use App\Models\Jimpitan;
use App\Models\Pengeluarans;
use App\Models\KasMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWarga = Warga::count();
        $totalRumah = Rumah::count();

        // Pemasukan: jimpitan + kas masuk
        $totalJimpitan   = Jimpitan::sum('jumlah');
        $totalKasMasuk   = KasMasuk::sum('jumlah');
        $totalPemasukan  = $totalJimpitan + $totalKasMasuk;
        $totalPengeluaran = Pengeluarans::sum('jumlah');
        $saldoKas        = $totalPemasukan - $totalPengeluaran;

        $recentJimpitans   = Jimpitan::with('rumah')->latest()->take(5)->get();
        $recentPengeluarans = Pengeluarans::latest()->take(5)->get();
        $recentKasMasuks   = KasMasuk::latest()->take(5)->get();

        // Chart data: monthly breakdown for current year (last 12 months)
        $year = date('Y');
        $chartLabels = [];
        $chartJimpitan = [];
        $chartKasMasuk = [];
        $chartPengeluaran = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthName = \Carbon\Carbon::create($year, $m)->locale('id')->isoFormat('MMM');
            $chartLabels[] = $monthName;

            $chartJimpitan[]    = (float) Jimpitan::whereYear('tanggal', $year)->whereMonth('tanggal', $m)->sum('jumlah');
            $chartKasMasuk[]    = (float) KasMasuk::whereYear('tanggal', $year)->whereMonth('tanggal', $m)->sum('jumlah');
            $chartPengeluaran[] = (float) Pengeluarans::whereYear('tanggal', $year)->whereMonth('tanggal', $m)->sum('jumlah');
        }

        return view('dashboard', compact(
            'totalWarga',
            'totalRumah',
            'totalJimpitan',
            'totalKasMasuk',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoKas',
            'recentJimpitans',
            'recentPengeluarans',
            'recentKasMasuks',
            'chartLabels',
            'chartJimpitan',
            'chartKasMasuk',
            'chartPengeluaran'
        ));
    }
}
