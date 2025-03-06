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
           $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'manager 3',
            'password' => hash::make('1234')
           ];
   
           UserModel::create($data);
   
           // Ambil semua data dari tabel m_user
           $user = UserModel::all();
           return view('user', ['data' => $user]);
       }
   }