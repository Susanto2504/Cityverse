<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatuDataSektoral extends Model
{
    protected $table = 'satu_data_sektorals';

    protected $fillable = [
        'sumber',
        'kode_sektor',
        'kode_data',
        'tahun',
        'data',
        'disinkronkan_pada',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'tahun' => 'integer',
            'disinkronkan_pada' => 'datetime',
        ];
    }
}
