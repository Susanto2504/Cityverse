<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SumberApiLingkungan extends Model
{
    protected $table = 'sumber_api_lingkungans';

    protected $fillable = [
        'kode',
        'nama',
        'penyedia',
        'endpoint',
        'sheet',
        'tahun',
        'tipe',
        'aktif',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'aktif' => 'boolean',
    ];

    public function dataLingkungans(): HasMany
    {
        return $this->hasMany(
            DataLingkungan::class,
            'sumber_api_id'
        );
    }
}