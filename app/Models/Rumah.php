<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $fillable = [
        'no_rumah',
        'blok',
        'alamat',
        'kepala_keluarga_id',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }

    public function jimpitans()
    {
        return $this->hasMany(Jimpitan::class);
    }
}
