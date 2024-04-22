<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        // Kita ambil data user lalu simpan pada variabel $user
        $user = Auth::user();

        // Kondisi jika user ada
        if ($user) {
            // Jika user memiliki level admin
            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            }
            // Jika user memiliki level manager
            elseif ($user->level == '2') {
                return redirect()->intended('manager');
            }
        }
        return view('login');
    }
    public function proses_login(Request $request)
    {
        // Kita buat validasi pada saat tombol login diklik
        // Validasi bahwa username & password wajib diisi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Ambil data request username & password saja
        $credential = $request->only('username', 'password');

        // Cek jika data username dan password valid dengan data yang ada
        if (Auth::attempt($credential)) {
            // Kalau berhasil, simpan data user di variabel $user
            $user = Auth::user();

            // Cek lagi jika level user admin maka arahkan ke halaman admin
            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            }
            // Jika level user nya user biasa maka arahkan ke halaman user
            else if ($user->level_id == '2') {
                return redirect()->intended('manager');
            }
            return redirect()->intended('/');
        }
        // Jika tidak ada data user yang valid, kembalikan lagi ke halaman login
        // Pastikan kirim pesan error juga kalau login gagal
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
    }

    public function register()
    {
        return view('register');
    }

    public function proses_register(Request $request)
    {
        // Kita buat validasi untuk proses register
        // Validasi bahwa semua field wajib diisi
        // Validasi bahwa username harus unique atau tidak boleh duplikat
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required'
        ]);

        // Jika validasi gagal, kembali ke halaman register dengan pesan error
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        // Jika berhasil, atur level dan hash password untuk keamanan
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);

        // Masukkan semua data pada request ke tabel user
        UserModel::create($request->all());

        // Jika berhasil, arahkan ke halaman login
        return redirect()->route('login');
    }

    public function Logout(Request $request)
    {
        // Logout menghapus session
        $request->session()->flush();

        // Jalankan fungsi logout pada auth
        Auth::logout();

        // Kembali ke halaman login
        return redirect('login');
    }
}
