<?php

namespace App\Http\Controllers;
use App\Models\UserModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //public function profile($id, $name) {
       // return view('user.profile')->with('id', $id)->with('name', $name);
    
       public function index()
       {
           // Update data user berdasarkan username
           $dataUpdate = [
               'nama' => 'Pelanggan Pertama',
           ];
   
           UserModel::where('username', 'customer-1')->update($dataUpdate);
   
           // Tambahkan data baru ke tabel m_user dengan level_id
           $dataInsert = [
               'username' => 'pelanggan_baru',
               'nama' => 'Pelanggan Baru',
               'password' => Hash::make('password123'), // Buat password terenkripsi
               'level_id' => 4, // Pastikan level_id ada
           ];
   
           UserModel::insert($dataInsert);
   
           // Ambil semua data dari tabel m_user
           $user = UserModel::all();
           return view('user', ['data' => $user]);
       }
   }