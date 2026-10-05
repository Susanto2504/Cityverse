<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SumberApiLingkungan;

class SumberApiLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        SumberApiLingkungan::insert([
            [
                'kode' => 'iku',
                'nama' => 'Kualitas Udara',
                'penyedia' => 'KLH',
                'endpoint' => 'https://satudata.kemenlh.go.id/api/v1/datasets/dst_wx_2OH2_xHYe_ngNqAks9Q/table',
                'sheet' => 2024,
                'tahun' => 2024,
                'tipe' => 'table',
                'aktif' => true,
            ],

            [
                'kode' => 'ika',
                'nama' => 'Kualitas Air',
                'penyedia' => 'KLH',
                'endpoint' => 'https://satudata.kemenlh.go.id/api/v1/datasets/dst_Zv45L2moyvsJLv5-LCQGZg/table',
                'sheet' => 'Indeks_Kualitas_Air__IKA__Tahun',
                'tahun' => 2024,
                'tipe' => 'table',
                'aktif' => true,
            ],

            [
                'kode' => 'persampahan_data',
                'nama' => 'Persampahan - Data Sampah',
                'penyedia' => 'KLH',
                'endpoint' => 'https://satudata.kemenlh.go.id/api/v1/datasets/dst_W8kz-YUCuiKDEMUWhZlqPA/table',
                'sheet' => 'Data sampah',
                'tahun' => 2025,
                'tipe' => 'table',
                'aktif' => true,
            ],

            [
                'kode' => 'persampahan_capaian',
                'nama' => 'Persampahan - Capaian',
                'penyedia' => 'KLH',
                'endpoint' => 'https://satudata.kemenlh.go.id/api/v1/datasets/dst_Z2ILRdCMusYqgnMvCv0QeA/table',
                'sheet' => 'Capaian',
                'tahun' => 2025,
                'tipe' => 'table',
                'aktif' => true,
            ],

            [
                'kode' => 'persampahan_terkelola',
                'nama' => 'Persampahan - Persentase Terkelola',
                'penyedia' => 'KLH',
                'endpoint' => 'https://satudata.kemenlh.go.id/api/v1/datasets/dst_Y-0XykSr0looec-lRdI9cw/table',
                'sheet' => '% Terkelola',
                'tahun' => 2025,
                'tipe' => 'table',
                'aktif' => true,
            ],

            [
                'kode' => 'persampahan_komposisi',
                'nama' => 'Persampahan - Komposisi',
                'penyedia' => 'KLH',
                'endpoint' => 'https://satudata.kemenlh.go.id/api/v1/datasets/dst_HXvn7DrKb5NJZF_xZbge8w/table',
                'sheet' => 'Data',
                'tahun' => 2025,
                'tipe' => 'table',
                'aktif' => true,
            ],

            [
                'kode' => 'risiko_banjir',
                'nama' => 'Indeks Risiko Banjir',
                'penyedia' => 'BNPB',
                'endpoint' => 'https://gis.bnpb.go.id/server/rest/services/inarisk/layer_risiko_banjir/ImageServer/identify',
                'sheet' => 'Identify',
                'tahun' => null,
                'tipe' => 'identify',
                'aktif' => true,
            ],
        ]);
    }
}