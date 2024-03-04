<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_code' => 'KAT001',
                'kategori_nama' => 'Elektronik',
            ],
            [
                'kategori_id' => 2,
                'kategori_code' => 'KAT002',
                'kategori_nama' => 'Pakaian',
            ],
            [
                'kategori_id' => 3,
                'kategori_code' => 'KAT003',
                'kategori_nama' => 'Makanan',
            ],
            [
                'kategori_id' => 4,
                'kategori_code' => 'KAT004',
                'kategori_nama' => 'Minuman',
            ],
            [
                'kategori_id' => 5,
                'kategori_code' => 'KAT005',
                'kategori_nama' => 'Alat Tulis',
            ],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
