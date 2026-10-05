<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infrastruktur extends Model
{
    protected $fillable = [
        'api_id',
        'kode',
        'jenis',
        'nama',
        'judul',
        'lokasi',
        'tahun',
        'nilai',
        'satuan',
        'kondisi',
        'sumber',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];
}