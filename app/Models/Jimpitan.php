<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jimpitan extends Model
{
    protected $fillable = [
        'rumah_id',
        'warga_id',
        'petugas_id',
        'tanggal',
        'jumlah',
        'keterangan',
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
