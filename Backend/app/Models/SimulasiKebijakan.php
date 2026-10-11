<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulasiKebijakan extends Model
{
    protected $table = 'simulasi_kebijakans';

    protected $fillable = [
        'judul',
        'jenis_kebijakan',
        'jenis_label',
        'skenario',
        'target',
        'ruas_awal_id',
        'ruas_target_id',
        'rekayasa_lalu_lintas',
        'baseline',
        'domains',
        'hasil_ai',
        'hasil_penerapan',
        'kesimpulan',
        'status',
    ];

    protected $casts = [
        'target' => 'array',
        'rekayasa_lalu_lintas' => 'array',
        'baseline' => 'array',
        'domains' => 'array',
        'hasil_ai' => 'array',
        'hasil_penerapan' => 'array',
    ];
}