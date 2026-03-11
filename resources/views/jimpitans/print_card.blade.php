<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Jimpitan - {{ $warga->nama }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 14px; margin: 0; padding: 20px; }
        .card-container { width: 100%; max-width: 500px; margin: 0 auto; border: 2px solid #000; padding: 15px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .header h2 { margin: 5px 0; border-bottom: none; }
        .header h3 { margin: 5px 0; font-weight: normal; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 8px; text-align: center; height: 30px; }
        .main-table th { background: #eee; font-weight: bold; }
        
        .footer { margin-top: 20px; font-size: 12px; line-height: 1.6; border-top: 1px solid #000; padding-top: 10px; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .card-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 0.8rem 1.5rem; background: #000; color: #fff; border-radius: 5px; cursor: pointer;">🖨️ Cetak Kartu Sekarang</button>
    </div>

    <div class="card-container">
        <div class="header">
            <h2>KARTU JIMPITAN</h2>
            <h3 style="margin-bottom: 2px;">WARGA SAWIT RT 02</h3>
            <div style="font-size: 11px; margin-bottom: 8px;">Panggungharjo, Sewon, Bantul</div>
            <h3 style="margin-top: 5px;">TAHUN {{ $tahun }}</h3>
        </div>

        <table class="info-table">
            <tr>
                <td width="80">NAMA</td>
                <td width="10">:</td>
                <td style="font-weight: bold; border-bottom: 1px dotted #000;">{{ strtoupper($warga->nama) }}</td>
            </tr>
            <tr>
                <td>BULAN</td>
                <td>:</td>
                <td style="font-weight: bold; border-bottom: 1px dotted #000;">{{ strtoupper(\Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName) }}</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th width="40">TGL</th>
                    <th width="80">HARI</th>
                    <th width="120">IURAN (Rp)</th>
                    <th>PARAF</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $daysInMonth = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
                @endphp
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    @php
                        $dateObj = \Carbon\Carbon::createFromDate($tahun, $bulan, $i);
                        $hasPaid = isset($jimpitans[$i]);
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $dateObj->locale('id')->dayName }}</td>
                        <td>{{ $hasPaid ? number_format($jimpitans[$i]->jumlah, 0, ',', '.') : '' }}</td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="footer">
            <strong>Catatan:</strong><br>
            1. Petugas ronda wajib mengambil dan memberi paraf pada kartu jimpitan.<br>
            2. Besarnya uang jimpitan per rumah Rp 2.000,- (Disesuaikan)<br>
            3. Bila ada tunggakan ditutup di akhir bulan.
        </div>
    </div>
</body>
</html>
