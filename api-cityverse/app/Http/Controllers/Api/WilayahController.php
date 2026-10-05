<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Menampilkan daftar seluruh wilayah (kelurahan).
     */
    public function index()
    {
        $wilayah = Wilayah::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar wilayah berhasil diambil',
            'data'    => $wilayah
        ], 200);
    }
    
    public function show($kode_wilayah)
    {
        $wilayah = Wilayah::where('kode_wilayah', $kode_wilayah)->first();

        if (!$wilayah) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Wilayah tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail wilayah berhasil diambil',
            'data'    => $wilayah
        ], 200);
    }
}