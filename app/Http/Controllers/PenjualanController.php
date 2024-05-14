<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan'; // Set menu yang sedang aktif

        $user = UserModel::all(); // ambil data level untuk filter level
        $penjualan = PenjualanModel::all();
        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->with('user');

        // Filter data stok bedasarkan level_id
        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }





        return DataTables::of($penjualans)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nmaa kolom: DT_RowINdex)
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">' . csrf_field() . method_field('DELETE')
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
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Penjualan baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all(); // ambil data untuk filter 

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'penjualan_kode'   => 'required|string|min:4|unique:t_penjualan,penjualan_kode',
            'user_id'         => 'required|integer',
            'barang_id'        => 'required|integer',
            'penjualan_tanggal'    => 'required|date',
            'pembeli'     => 'required|string|max:100',
        ]);

        PenjualanModel::create([
            'penjualan_kode'        => $request->penjualan_kode,
            'user_id'               => $request->user_id,
            'barang_id'             => $request->barang_id,
            'penjualan_tanggal'     => $request->penjualan_tanggal,
            'pembeli'               => $request->pembeli,
        ]);

        return redirect('/penjualan')->with('success', 'Data pembeli berhasil disimpan');
    }


    public function show(string $id)
    {
        $penjualan = PenjualanModel::with('user')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Penjualan'
        ];

        $activeMenu = 'penjualan';
        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }


    // public function edit(string $id)
    // {
    //     $penjualan = PenjualanModel::find($id);
    //     $user = UserModel::all();

    //     $breadcrumb = (object)[
    //         'title' => 'Edit Penjualan',
    //         'list' => ['Home', 'Penjualan', 'Edit']
    //     ];

    //     $page = (object)[
    //         'title' => 'Edit Penjualan'
    //     ];

    //     $activeMenu = 'penjualan';
    //     return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'user' => $user, 'activeMenu' => $activeMenu]);
    // }

    public function edit(string $id)
    {
        $penjualan = PenjualanModel::with(['detail', 'user'])->find($id);

        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data Transaksi tidak ditemukan');
        }

        $users = UserModel::all();
        $barang = BarangModel::all();
        $activeMenu = 'penjualan';

        return view('penjualan.edit', [
            'penjualan' => $penjualan,
            'users' => $users,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'penjualan_kode' => 'required|string|max:255',
            'pembeli' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'user' => 'required|exists:m_user,user_id',
            'barang' => 'required|array',
            'barang.*.id' => 'exists:m_barang,barang_id',
            'barang.*.jumlah' => 'nullable|integer|min:1',
        ]);

        $penjualan = PenjualanModel::find($id);

        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data Transaksi tidak ditemukan');
        }

        $penjualan->penjualan_kode = $validatedData['penjualan_kode'];
        $penjualan->pembeli = $validatedData['pembeli'];
        $penjualan->penjualan_tanggal = $validatedData['tanggal'];
        $penjualan->user_id = $validatedData['user'];
        $penjualan->save();

        // Delete existing details
        $penjualan->detail()->delete();

        // Save new details
        foreach ($validatedData['barang'] as $item) {
            if (!empty($item['id'])) {
                $barang = BarangModel::find($item['id']);
                $detailPenjualan = new PenjualanModel();
                $detailPenjualan->penjualan_id = $penjualan->penjualan_id;
                $detailPenjualan->barang_id = $item['id'];
                $detailPenjualan->jumlah = isset($item['jumlah']) ? $item['jumlah'] : 0;
                $detailPenjualan->harga = $barang->harga_jual;
                $detailPenjualan->save();
            }
        }

        return redirect('/penjualan')->with('success', 'Data Transaksi berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        try {
            $penjualan = PenjualanModel::findOrFail($id);
            $penjualan->delete(); // Hapus data penjualan

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If the record is not found, return with an error message
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        } catch (\Illuminate\Database\QueryException $e) {
            // If an error occurs during deletion due to related records, return with an error message
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
