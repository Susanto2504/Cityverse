<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SegmenJalan extends Model
{
    protected $table = 'segmen_jalans';

    protected $primaryKey = 'id_segmen';

    protected $fillable = [
        'jalan_id',
        'osm_id',
        'koordinat_geometri',
        'panjang_m',
        'lebar_m',
        'tipe_jalan_detail',
        'kapasitas_jalan',
        'volume_kendaraan',
        'tingkat_kepadatan',
        'kondisi_jalan',
        'panjang_kondisi_m',
        'kondisi_lainnya',
    ];

    protected $casts = [
        'osm_id' => 'integer',
        'koordinat_geometri' => 'array',
        'panjang_m' => 'decimal:2',
        'lebar_m' => 'decimal:2',
        'panjang_kondisi_m' => 'decimal:2',
        'kapasitas_jalan' => 'integer',
        'volume_kendaraan' => 'integer',
    ];

    public function jalan(): BelongsTo
    {
        return $this->belongsTo(Jalan::class, 'jalan_id', 'id_jalan');
    }
}