<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPengambilanCuaca extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_wilayah',
        'waktu_pengambilan',
        'status',
        'pesan',
        'jumlah_data',
    ];
}
