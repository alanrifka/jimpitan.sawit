<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    protected $fillable = [
        'tanggal',
        'sumber',
        'kategori',
        'jumlah',
        'keterangan',
        'bukti_foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];
}
