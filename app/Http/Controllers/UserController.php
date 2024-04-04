<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // jobsheet 7
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdafatar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $detailBtn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-primary" style="width: 40px; height: 40px; margin-right: 5px;"><i class="fas fa-info-circle"></i></a>';
                $editBtn = '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning" style="width: 40px; height: 40px; margin-right: 5px;"><i class="fas fa-edit"></i></a>';
                $deleteBtn = '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger" style="width: 40px; height: 40px;" onclick="return confirm(\'Apakah Anda Yakin Menghapus Data Ini ? \');"><i class="fas fa-trash-alt"></i></button></form>';
                return $detailBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah User Baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer',
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User',
        ];

        $activeMenu = 'User';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            $user->delete();
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // class UserController extends Controller
    // {
    //     public function index()
    //     {
    //         $user = UserModel::with('level')->get();
    //         return view('user', ['data' => $user]);
    //     }

    //     public function tambah()
    //     {
    //         return view('user_tambah');
    //     }

    //     public function tambah_simpan(Request $request)
    //     {
    //         UserModel::create([
    //             'username' => $request->username,
    //             'nama' => $request->nama,
    //             'password' => Hash::make('$request->password'),
    //             'level_id' => $request->level_id
    //         ]);
    //         return redirect('/user');
    //     }

    //     public function ubah($id)
    //     {
    //         $user = UserModel::find($id);
    //         return view('user_ubah', ['data' => $user]);
    //     }

    //     public function ubah_simpan($id, Request $request)
    //     {
    //         $user = UserModel::find($id);
    //         if (!$user) {
    //             abort(404);
    //         }
    //         $user->username = $request->username;
    //         $user->nama = $request->nama;
    //         $user->password = Hash::make($request->password);
    //         $user->level_id = $request->level_id;
    //         $user->save();
    //         return redirect('/user');
    //     }

    //     public function hapus($id)
    //     {
    //         $user = UserModel::find($id);
    //         $user->delete();
    //         return redirect('/user');

    // $user->isDirty(); //true
    // $user->isDirty('username'); //true
    // $user->isDirty('nama'); //false
    // $user->isDirty('nama', 'username'); //true

    // $user->isClean(); //false
    // $user->isClean('username'); //false
    // $user->isClean('nama'); //true
    // $user->isClean('nama', 'username'); //false



    // $user->isDirty(); //false
    // $user->isClean(); //true

    // dd($user->isDirty());

    // coba akses model UserModel
    // $user = UserModel::all(); // ambil semua data dari tabel m_user
    // return view('user', ['data' => $user]);

    // // tambah data user dengan Eloquent Model
    // $data = [
    //     'username' => 'customer-1',
    //     'nama' => 'Pelanggan',
    //     'Password' => Hash::make('12345'),
    //     'level_id' => 4
    // ];
    // UserModel::insert($data); // tambahkan data ke tabel m_user

    // //coba akses mode UserModel
    // $user = UserModel::all(); //ambil semua data dari tabel m_user
    // return view('user', ['data' => $user]);

    // $data = [
    //     'nama'  => 'Pelanggan Pertama',
    // ];
    // UserModel::where('username', 'customer-1')->update($data);

    // $data = [
    //     'level_id' => 2,
    //     'username' => 'manager_tiga',
    //     'nama' => 'Manager 3',
    //     'password' => Hash::make('12345')
    // ];
    // UserModel::create($data);

    // $user = UserModel::find(1);
    // return view('user', ['data' => $user]);
}
