<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makassarList = [
            // 1. MARISO
            ['name' => 'Kel. Bontorannu', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1001'],
            ['name' => 'Kel. Kampung Buyang', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1002'],
            ['name' => 'Kel. Karang Anyar', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1003'],
            ['name' => 'Kel. Lette', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1004'],
            ['name' => 'Kel. Mariso', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1005'],
            ['name' => 'Kel. Mattoangin', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1006'],
            ['name' => 'Kel. Panambungan', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1007'],
            ['name' => 'Kel. Tamarunang', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1008'],
            ['name' => 'Kel. Kassi-Kassi', 'kecamatan' => 'Mariso', 'code' => '73.71.01.1009'],

            // 2. MAMAJANG
            ['name' => 'Kel. Baji Mappasunggu', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1001'],
            ['name' => 'Kel. Buntu Usu', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1002'],
            ['name' => 'Kel. Labuang Baji', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1003'],
            ['name' => 'Kel. Mamajang Dalam', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1004'],
            ['name' => 'Kel. Mamajang Luar', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1005'],
            ['name' => 'Kel. Mandala', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1006'],
            ['name' => 'Kel. Maricaya Selatan', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1007'],
            ['name' => 'Kel. Pa\'batang', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1008'],
            ['name' => 'Kel. Parang', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1009'],
            ['name' => 'Kel. Sambung Jawa', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1010'],
            ['name' => 'Kel. Tamparang Keke', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1011'],
            ['name' => 'Kel. Vehar/Karunrung', 'kecamatan' => 'Mamajang', 'code' => '73.71.02.1012'],

            // 3. MAKASSAR
            ['name' => 'Kel. Bara-Baraya', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1001'],
            ['name' => 'Kel. Bara-Baraya Selatan', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1002'],
            ['name' => 'Kel. Bara-Baraya Timur', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1003'],
            ['name' => 'Kel. Bara-Baraya Utara', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1004'],
            ['name' => 'Kel. Barana', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1005'],
            ['name' => 'Kel. Lariang Bangi', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1006'],
            ['name' => 'Kel. Maccini', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1007'],
            ['name' => 'Kel. Maccini Gusung', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1008'],
            ['name' => 'Kel. Maccini Parang', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1009'],
            ['name' => 'Kel. Maricaya', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1010'],
            ['name' => 'Kel. Maricaya Baru', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1011'],
            ['name' => 'Kel. Maradekaya', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1012'],
            ['name' => 'Kel. Maradekaya Selatan', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1013'],
            ['name' => 'Kel. Maradekaya Utara', 'kecamatan' => 'Makassar', 'code' => '73.71.03.1014'],

            // 4. UJUNG PANDANG
            ['name' => 'Kel. Baru', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1001'],
            ['name' => 'Kel. Bulogading', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1002'],
            ['name' => 'Kel. Lae-Lae', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1003'],
            ['name' => 'Kel. Lajangiru', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1004'],
            ['name' => 'Kel. Maloku', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1005'],
            ['name' => 'Kel. Mangkura', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1006'],
            ['name' => 'Kel. Pisang Selatan', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1007'],
            ['name' => 'Kel. Pisang Utara', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1008'],
            ['name' => 'Kel. Sawerigading', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1009'],
            ['name' => 'Kel. Timungan Lompoa', 'kecamatan' => 'Ujung Pandang', 'code' => '73.71.04.1010'],

            // 5. WAJO
            ['name' => 'Kel. Ende', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1001'],
            ['name' => 'Kel. Mampu', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1002'],
            ['name' => 'Kel. Melayu', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1003'],
            ['name' => 'Kel. Melayu Baru', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1004'],
            ['name' => 'Kel. Pattunuang', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1005'],
            ['name' => 'Kel. Malimongan', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1006'],
            ['name' => 'Kel. Ampang', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1007'],
            ['name' => 'Kel. Sarappo', 'kecamatan' => 'Wajo', 'code' => '73.71.05.1008'],

            // 6. BONTOALA
            ['name' => 'Kel. Baraya', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1001'],
            ['name' => 'Kel. Bontoala', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1002'],
            ['name' => 'Kel. Bontoala Parang', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1003'],
            ['name' => 'Kel. Bontoala Tua', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1004'],
            ['name' => 'Kel. Bunge Ejaya', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1005'],
            ['name' => 'Kel. Gaddong', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1006'],
            ['name' => 'Kel. Layang', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1007'],
            ['name' => 'Kel. Malimongan Baru', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1008'],
            ['name' => 'Kel. Parang Layang', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1009'],
            ['name' => 'Kel. Timungan Lompoa', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1010'],
            ['name' => 'Kel. Wajo Baru', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1011'],
            ['name' => 'Kel. Tompo Balang', 'kecamatan' => 'Bontoala', 'code' => '73.71.06.1012'],

            // 7. TALLO
            ['name' => 'Kel. Bunga Eja Beru', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1001'],
            ['name' => 'Kel. Kaluku Bodoa', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1002'],
            ['name' => 'Kel. Kalukuang', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1003'],
            ['name' => 'Kel. La\'latang', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1004'],
            ['name' => 'Kel. Lakkang', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1005'],
            ['name' => 'Kel. Lembo', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1006'],
            ['name' => 'Kel. Pannampu', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1007'],
            ['name' => 'Kel. Rappokalling', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1008'],
            ['name' => 'Kel. Rappokalling Barat', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1009'],
            ['name' => 'Kel. Suangga', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1010'],
            ['name' => 'Kel. Tallo', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1011'],
            ['name' => 'Kel. Tammua', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1012'],
            ['name' => 'Kel. Ujung Pandang Baru', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1013'],
            ['name' => 'Kel. Wala-Walaya', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1014'],
            ['name' => 'Kel. Buloa', 'kecamatan' => 'Tallo', 'code' => '73.71.07.1015'],

            // 8. UJUNG TANAH
            ['name' => 'Kel. Camba Berua', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1001'],
            ['name' => 'Kel. Cambaya', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1002'],
            ['name' => 'Kel. Guzang', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1003'],
            ['name' => 'Kel. Potingang', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1004'],
            ['name' => 'Kel. Tabaringan', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1005'],
            ['name' => 'Kel. Tamalabba', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1006'],
            ['name' => 'Kel. Totaka', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1007'],
            ['name' => 'Kel. Ujung Tanah', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1008'],
            ['name' => 'Kel. Buloa Barat', 'kecamatan' => 'Ujung Tanah', 'code' => '73.71.08.1009'],

            // 9. PANAKKUKANG
            ['name' => 'Kel. Karampuang', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1001'],
            ['name' => 'Kel. Masale', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1002'],
            ['name' => 'Kel. Pampang', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1003'],
            ['name' => 'Kel. Panaikang', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1004'],
            ['name' => 'Kel. Pandang', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1005'],
            ['name' => 'Kel. Paropo', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1006'],
            ['name' => 'Kel. Sinrijala', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1007'],
            ['name' => 'Kel. Tamamaung', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1008'],
            ['name' => 'Kel. Tello Baru', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1009'],
            ['name' => 'Kel. Karuwisi', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1010'],
            ['name' => 'Kel. Karuwisi Utara', 'kecamatan' => 'Panakkukang', 'code' => '73.71.09.1011'],

            // 10. TAMALATE
            ['name' => 'Kel. Barombong', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1001'],
            ['name' => 'Kel. Bongaiya', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1002'],
            ['name' => 'Kel. Jongaya', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1003'],
            ['name' => 'Kel. Mangasa', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1004'],
            ['name' => 'Kel. Mannuruki', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1005'],
            ['name' => 'Kel. Pa\'baeng-Baeng', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1006'],
            ['name' => 'Kel. Parang Tambung', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1007'],
            ['name' => 'Kel. Tanjung Merdeka', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1008'],
            ['name' => 'Kel. Maccini Sombala', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1009'],
            ['name' => 'Kel. Balang Baru', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1010'],
            ['name' => 'Kel. Maccini Sombala Barat', 'kecamatan' => 'Tamalate', 'code' => '73.71.10.1011'],

            // 11. BIRINGKANAYA
            ['name' => 'Kel. Bakung', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1001'],
            ['name' => 'Kel. Berua', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1002'],
            ['name' => 'Kel. Daya', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1003'],
            ['name' => 'Kel. Paccerakkang', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1004'],
            ['name' => 'Kel. Pai', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1005'],
            ['name' => 'Kel. Sudiang', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1006'],
            ['name' => 'Kel. Sudiang Raya', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1007'],
            ['name' => 'Kel. Untia', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1008'],
            ['name' => 'Kel. Bulurokeng', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1009'],
            ['name' => 'Kel. Katimbang', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1010'],
            ['name' => 'Kel. Laikang', 'kecamatan' => 'Biringkanaya', 'code' => '73.71.11.1011'],

            // 12. MANGGALA
            ['name' => 'Kel. Antang', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1001'],
            ['name' => 'Kel. Bangkala', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1002'],
            ['name' => 'Kel. Batua', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1003'],
            ['name' => 'Kel. Biring Romang', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1004'],
            ['name' => 'Kel. Bitoa', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1005'],
            ['name' => 'Kel. Borong', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1006'],
            ['name' => 'Kel. Manggala', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1007'],
            ['name' => 'Kel. Tamangapa', 'kecamatan' => 'Manggala', 'code' => '73.71.12.1008'],

            // 13. RAPPOCINI
            ['name' => 'Kel. Banta-Bantaeng', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1001'],
            ['name' => 'Kel. Bonto Makkio', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1002'],
            ['name' => 'Kel. Buakana', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1003'],
            ['name' => 'Kel. Gunung Sari', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1004'],
            ['name' => 'Kel. Karunrung', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1005'],
            ['name' => 'Kel. Kassi-Kassi', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1006'],
            ['name' => 'Kel. Mapala', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1007'],
            ['name' => 'Kel. Minasa Upa', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1008'],
            ['name' => 'Kel. Rappocini', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1009'],
            ['name' => 'Kel. Tidung', 'kecamatan' => 'Rappocini', 'code' => '73.71.13.1010'],

            // 14. TAMALANREA
            ['name' => 'Kel. Kapasa', 'kecamatan' => 'Tamalanrea', 'code' => '73.71.14.1001'],
            ['name' => 'Kel. Kapasa Raya', 'kecamatan' => 'Tamalanrea', 'code' => '73.71.14.1002'],
            ['name' => 'Kel. Buntusu', 'kecamatan' => 'Tamalanrea', 'code' => '73.71.14.1003'],
            ['name' => 'Kel. Tamalanrea', 'kecamatan' => 'Tamalanrea', 'code' => '73.71.14.1004'],
            ['name' => 'Kel. Tamalanrea Indah', 'kecamatan' => 'Tamalanrea', 'code' => '73.71.14.1005'],
            ['name' => 'Kel. Tamalanrea Jaya', 'kecamatan' => 'Tamalanrea', 'code' => '73.71.14.1006'],

            // 15. KEPULAUAN SANGKARRANG
            ['name' => 'Kel. Barrang Caddi', 'kecamatan' => 'Kepulauan Sangkarrang', 'code' => '73.71.15.1001'],
            ['name' => 'Kel. Barrang Lompo', 'kecamatan' => 'Kepulauan Sangkarrang', 'code' => '73.71.15.1002'],
            ['name' => 'Kel. Kodingareng', 'kecamatan' => 'Kepulauan Sangkarrang', 'code' => '73.71.15.1003'],
        ];

        foreach ($makassarList as $item) {
            Wilayah::updateOrCreate(
                ['kode_wilayah' => $item['code']],
                [
                    // Menghilangkan kata 'Kel. ' jika ingin nama bersih, atau biarkan utuh jika sesuai kebutuhan
                    'nama_kelurahan' => str_replace('Kel. ', '', $item['name']),
                    'nama_kecamatan' => $item['kecamatan'],
                    'nama_kota'      => 'Kota Makassar',
                    'garis_lintang'  => null,
                    'garis_bujur'    => null,
                ]
            );
        }
    }
}