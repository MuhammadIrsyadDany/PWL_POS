<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
                'stok_id' => 1,
                'barang_id' => 1,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 08:00:00',
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 2,
                'barang_id' => 2,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 09:30:00',
                'stok_jumlah' => 150,
            ],
            [
                'stok_id' => 3,
                'barang_id' => 3,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 10:45:00',
                'stok_jumlah' => 200,
            ],
            [
                'stok_id' => 4,
                'barang_id' => 4,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 12:20:00',
                'stok_jumlah' => 120,
            ],
            [
                'stok_id' => 5,
                'barang_id' => 5,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 14:15:00',
                'stok_jumlah' => 80,
            ],
            [
                'stok_id' => 6,
                'barang_id' => 6,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 15:30:00',
                'stok_jumlah' => 90,
            ],
            [
                'stok_id' => 7,
                'barang_id' => 7,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 16:45:00',
                'stok_jumlah' => 180,
            ],
            [
                'stok_id' => 8,
                'barang_id' => 8,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 17:55:00',
                'stok_jumlah' => 60,
            ],
            [
                'stok_id' => 9,
                'barang_id' => 9,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 18:30:00',
                'stok_jumlah' => 110,
            ],
            [
                'stok_id' => 10,
                'barang_id' => 10,
                'user_id' => 1,
                'stok_tanggal' => '2024-03-01 19:45:00',
                'stok_jumlah' => 130,
            ],
        ];

        DB::table('t_stok')->insert($data);
    }
}
