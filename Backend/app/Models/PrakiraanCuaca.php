<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrakiraanCuaca extends Model
{
    use HasFactory;
    const CREATED_AT = 'dibuat_pada';

    protected $fillable = [
        'kode_wilayah',
        'waktu_prakiraan',
        'suhu',
        'kelembapan',
        'kode_cuaca',
        'keterangan_cuaca',
        'kecepatan_angin',
        'arah_angin',
        'tutupan_awan',
        'jarak_pandang',
        'gambar_cuaca',
        'waktu_diambil',
        'dibuat_pada',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode_wilayah');
    }
}
