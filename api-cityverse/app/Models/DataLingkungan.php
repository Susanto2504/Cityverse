<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataLingkungan extends Model
{
    protected $table = 'data_lingkungans';

    protected $fillable = [
        'sumber_api_id',
        'wilayah',
        'kode_wilayah',
        'parameter',
        'indikator',
        'nilai',
        'satuan',
        'tahun',
        'latitude',
        'longitude',
        'data_asli',
        'diambil_pada',
    ];

    protected $casts = [
        'nilai' => 'decimal:6',
        'tahun' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'data_asli' => 'array',
        'diambil_pada' => 'datetime',
    ];

    public function sumberApi(): BelongsTo
    {
        return $this->belongsTo(
            SumberApiLingkungan::class,
            'sumber_api_id'
        );
    }
}