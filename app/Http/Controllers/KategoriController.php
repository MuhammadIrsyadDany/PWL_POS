<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // $data = [
        //     'kategori_code' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_code', 'SNK')->update(['kategori_nama' => 'Cemilan']);
        // return 'Update data berhasil. Jumlah data yang di update : ' . $row . ' baris';

        // $row = DB::table('m_kategori')->where('kategori_code', 'SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang di hapus : ' . $row . ' baris';

        $data = DB::select('select * from m_kategori');
        return view('kategori', ['data' => $data]);
    }
}
