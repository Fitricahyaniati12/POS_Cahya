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
            // ambil model pertama yang cocok dengan batasan queri
           //$user = UserModel::where('level_id',2)->first();

            // alternatif untuk mengambil mode pertama yang cocok dengan batasan queri
           //$user = UserModel::firstWhere('level_id', 3);

           $user = UserModel::findOr(20, ['username', 'nama'], function () {
            abort(404);
        });
           return view('user', ['data' => $user]);
       }
   }