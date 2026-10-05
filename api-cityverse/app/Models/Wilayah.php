<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_wilayah',
        'nama_kelurahan',
        'nama_kecamatan',
        'nama_kota',
        'garis_lintang',
        'garis_bujur',
    ];

    public function prakiraanCuaca()
    {
        return $this->hasMany(PrakiraanCuaca::class, 'kode_wilayah', 'kode_wilayah');
    }
}
