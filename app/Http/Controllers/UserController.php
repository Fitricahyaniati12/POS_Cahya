<?php

namespace App\Http\Controllers;
use App\Models\UserModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
    }

     // Menampilkan form ubah pengguna
     public function ubah($id)
     {
         $user = UserModel::find($id);
         return view('user_ubah', ['data' => $user]);
     }
 
     // Menyimpan perubahan data pengguna
     public function ubahSimpan(Request $request, $id)
     {
         $user = UserModel::find($id);
         $user->update([
             'username' => $request->username,
             'nama' => $request->nama,
             'level_id' => $request->level_id
         ]);
 
         return redirect()->route('user');
     }
 
     // Menghapus pengguna
     public function hapus($id)
     {
         UserModel::find($id)->delete();
         return redirect()->route('user');
     }
     
}