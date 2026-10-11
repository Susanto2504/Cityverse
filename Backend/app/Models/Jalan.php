<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jalan extends Model
{
    protected $table = 'jalans';

    protected $primaryKey = 'id_jalan';

    protected $fillable = [
        'nama_ruas_jalan',
        'panjang_m',
        'lebar_m',
        'tipe_jalan_detail',
    ];

    protected $casts = [
        'panjang_m' => 'decimal:2',
        'lebar_m' => 'decimal:2',
    ];

    public function segmenJalans(): HasMany
    {
        return $this->hasMany(SegmenJalan::class, 'jalan_id', 'id_jalan');
    }
}