<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'John Doe',
                'penjualan_kode' => 'PJN001',
                'penjualan_tanggal' => '2024-03-01 08:00:00',
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 1,
                'pembeli' => 'Jane Doe',
                'penjualan_kode' => 'PJN002',
                'penjualan_tanggal' => '2024-03-01 09:30:00',
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 1,
                'pembeli' => 'Alice Smith',
                'penjualan_kode' => 'PJN003',
                'penjualan_tanggal' => '2024-03-01 10:45:00',
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 1,
                'pembeli' => 'Bob Johnson',
                'penjualan_kode' => 'PJN004',
                'penjualan_tanggal' => '2024-03-01 12:20:00',
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 1,
                'pembeli' => 'Eva Green',
                'penjualan_kode' => 'PJN005',
                'penjualan_tanggal' => '2024-03-01 14:15:00',
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 1,
                'pembeli' => 'Michael Brown',
                'penjualan_kode' => 'PJN006',
                'penjualan_tanggal' => '2024-03-01 15:30:00',
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Olivia Wilson',
                'penjualan_kode' => 'PJN007',
                'penjualan_tanggal' => '2024-03-01 16:45:00',
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 1,
                'pembeli' => 'David Martinez',
                'penjualan_kode' => 'PJN008',
                'penjualan_tanggal' => '2024-03-01 17:55:00',
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 1,
                'pembeli' => 'Sophia Garcia',
                'penjualan_kode' => 'PJN009',
                'penjualan_tanggal' => '2024-03-01 18:30:00',
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'James Taylor',
                'penjualan_kode' => 'PJN010',
                'penjualan_tanggal' => '2024-03-01 19:45:00',
            ],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
