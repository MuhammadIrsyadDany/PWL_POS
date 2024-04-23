<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Stok Barang',
            'list' => ['Home', 'Stok Barang']
        ];

        $page = (object)[
            'title' => 'Daftar Stok Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; // Set menu yang sedang aktif

        $user = UserModel::all(); // ambil data level untuk filter level
        $barang = BarangModel::all();
        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('user')
            ->with('barang');

        // Filter data stok bedasarkan level_id
        if ($request->user_id) {
            $stoks->where('user_id', $request->user_id);
        } else if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nmaa kolom: DT_RowINdex)
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a>';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">' . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data 
                ini?\');">Hapus</button></form>';
                return $btn;
            })

            ->rawColumns(['aksi'])
            ->make(true);
    }



    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Stok baru'
        ];

        $user = UserModel::all(); // ambil data untuk filter 
        $barang = BarangModel::all();
        $activeMenu = 'stok'; //set menu yang sedang aktif

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_jumlah' => 'required'
        ]);

        // Periksa apakah barang dengan barang_id yang sama sudah ada
        $existingStok = StokModel::where('barang_id', $request->barang_id)->first();

        if ($existingStok) {
            // Jika sudah ada, tambahkan jumlah stok baru ke jumlah stok yang sudah ada
            $existingStok->stok_jumlah += $request->stok_jumlah;
            $existingStok->save();
        } else {
            // Jika belum ada, buat entri baru untuk barang tersebut
            StokModel::create([
                'barang_id' => $request->barang_id,
                'user_id' => $request->user_id,
                'stok_tanggal' => now(),
                'stok_jumlah' => $request->stok_jumlah
            ]);
        }

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }


    public function show(string $id)
    {
        $stok = StokModel::with(['user', 'barang'])->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Stok'
        ];

        $activeMenu = 'stok';
        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }


    public function edit(string $id)
    {
        $stok = StokModel::find($id);
        $user = UserModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Stok'
        ];

        $activeMenu = 'stok';
        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'stok_tanggal'  => 'required|date:t_stok,stok_tanggal,' . $id . ',stok_id',
            'stok_jumlah'   => 'required|integer',
            'barang_id'      => 'required|integer',
            'user_id'       => 'required|integer'
        ]);

        StokModel::find($id)->update([
            'stok_tanggal'    => $request->stok_tanggal,
            'stok_jumlah'     => $request->stok_jumlah,
            'barang_id'       => $request->barang_id,
            'user_id'         => $request->user_id,
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }
    public function destroy(string $id)
    {
        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            $stok->delete(); // Hapus data stok
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
