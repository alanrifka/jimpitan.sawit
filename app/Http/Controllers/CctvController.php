<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CctvController extends Controller
{
    public function index()
    {
        // Daftar kamera CCTV — sesuaikan URL stream dengan kamera nyata Anda.
        // Gunakan URL MJPEG stream, HLS (.m3u8), atau embed iframe jika pakai NVR berbasis web.
        $cameras = [
            [
                'id'       => 1,
                'nama'     => 'Kamera 1 – Gerbang Masuk',
                'lokasi'   => 'Jalan Masuk RT 02',
                'status'   => 'online',
                'stream'   => '192.168.165.253/video', // isi dengan URL stream jika tersedia
                'icon'     => '🎥',
            ],
            [
                'id'       => 2,
                'nama'     => 'Kamera 2 – Pos Jaga',
                'lokasi'   => 'Pos Keamanan',
                'status'   => 'online',
                'stream'   => null,
                'icon'     => '📷',
            ],
            [
                'id'       => 3,
                'nama'     => 'Kamera 3 – Lapangan',
                'lokasi'   => 'Area Lapangan Tengah',
                'status'   => 'offline',
                'stream'   => null,
                'icon'     => '📸',
            ],
            [
                'id'       => 4,
                'nama'     => 'Kamera 4 – Parkir',
                'lokasi'   => 'Area Parkir Selatan',
                'status'   => 'online',
                'stream'   => null,
                'icon'     => '🎬',
            ],
        ];

        return view('cctv.index', compact('cameras'));
    }
}
