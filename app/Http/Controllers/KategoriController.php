<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class KategoriController extends Controller
{
    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',
        ]);

        $validatedData = $request->validate([
            'title' => ['required', 'unique:posts', 'max:255'],
            'body' => ['required'],
        ]);

        // $validatedData = $request->validateWithBag('posts', [
        //     'title' => ['required', 'unique:posts', 'max:255'],
        //     'body' => ['required'],
        // ]);

        // $request->validate([
        //     'title' => 'bail|required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);

        return redirect('/kategori');
    }
    // public function index(KategoriDataTable $dataTable)
    // {
    //     return $dataTable->render('kategori.index');
    // }

    // public function create()
    // {
    //     return view('kategori.create');
    // }

    // public function store(Request $request)
    // {
    //     KategoriModel::create([
    //         'kategori_code' => $request->codekategori,
    //         'kategori_nama' => $request->namakategori,
    //     ]);

    //     return redirect('/kategori');
    // }

    // // Tugas nomer 3 js 5
    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori.edit', ['data' => $kategori]);
    // }

    // public function edit_simpan($id, Request $request)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $kategori->kategori_kode = $request->kodeKategori;
    //     $kategori->kategori_nama = $request->namaKategori;

    //     $kategori->save();
    //     return redirect('/kategori');
    // }

    // // Tugas nomer 4 js 5
    // public function hapus($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     $kategori->delete();

    //     return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori.edit', compact('kategori'));
    // }

    // public function update($id, Request $request)
    // {
    //     $kategori = KategoriModel::find($id);
    //     if (!$kategori) {
    //         return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    //     }

    //     $kategori->kategori_code = $request->codeKategori;
    //     $kategori->kategori_nama = $request->namaKategori;
    //     $kategori->save();

    //     return redirect('/kategori')->with('success', 'Kategori berhasil diperbarui.');
    // }


    // public function destroy($id)
    // {
    //     KategoriModel::destroy($id);
    //     return redirect('/kategori');
    // }
}
