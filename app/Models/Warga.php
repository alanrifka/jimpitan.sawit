<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'kepala_keluarga_id',
        'nama',
        'nik',
        'no_hp',
        'jenis_kelamin',
        'status_warga',
        'hubungan_keluarga',
        'is_active',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }

    public function anggotaKeluarga()
    {
        return $this->hasMany(Warga::class, 'kepala_keluarga_id');
    }

    public function rumahs()
    {
        return $this->hasMany(Rumah::class, 'kepala_keluarga_id');
    }

    public function jimpitans()
    {
        return $this->hasMany(Jimpitan::class);
    }
}
