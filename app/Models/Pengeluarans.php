<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluarans extends Model
{
    protected $fillable = [
        'tanggal',
        'jumlah',
        'keterangan',
        'pj_id',
        'bukti_foto',
    ];

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'pj_id');
    }
}
