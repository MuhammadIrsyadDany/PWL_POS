<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
                'kategori_id' => 1,
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Laptop',
                'harga_beli' => 5000000,
                'harga_jual' => 7000000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Kemeja',
                'harga_beli' => 150000,
                'harga_jual' => 250000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Nasi Goreng',
                'harga_beli' => 20000,
                'harga_jual' => 30000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'BRG004',
                'barang_nama' => 'Air Mineral',
                'harga_beli' => 5000,
                'harga_jual' => 8000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'BRG005',
                'barang_nama' => 'Pensil',
                'harga_beli' => 2000,
                'harga_jual' => 3000,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BRG006',
                'barang_nama' => 'Smartphone',
                'harga_beli' => 3000000,
                'harga_jual' => 4000000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'BRG007',
                'barang_nama' => 'Jeans',
                'harga_beli' => 200000,
                'harga_jual' => 350000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'BRG008',
                'barang_nama' => 'Soto Ayam',
                'harga_beli' => 25000,
                'harga_jual' => 35000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'BRG009',
                'barang_nama' => 'Es Teh',
                'harga_beli' => 7000,
                'harga_jual' => 10000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'BRG010',
                'barang_nama' => 'Buku Tulis',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
