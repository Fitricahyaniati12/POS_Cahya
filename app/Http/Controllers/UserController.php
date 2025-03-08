<?php

namespace App\Http\Controllers;
use App\Models\UserModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);

        // Mengubah username
        $user->username = 'manager12';

        // Menyimpan perubahan ke database
        $user->save();

        // Mengecek apakah ada perubahan setelah disimpan
        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged(['username', 'level_id']); // true
        $user->wasChanged('nama'); // false

        // Menampilkan hasil perubahan
        dd($user->wasChanged(['nama', 'username'])); // true
    }
}