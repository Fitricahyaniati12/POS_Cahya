<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //menampilkan  halaman awal user
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all();// ambil data level untuk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'level' => $level, 'activeMenu' => $activeMenu]);

    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');
        
            // Filter data user berdasarkan level_id
        if ($request->ajax()) {
            if ($request->level_id) {
                $users->where('level_id', $request->level_id);
            }
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
               /* $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';*/

                $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    //menampilkan halaman form
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah user baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'user';
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //menapilkan data user baru

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required | integer',
            'username' => 'required | string | min:3 | unique:m_user,username',
            'nama' => 'required | string | max:100',
            'password' => 'required | min:5'
        ]);

        UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/user')->with('success', 'Data user berhasil ditambahkan');
    }
    //menampilkan detail user

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail user'
        ];
        $user = UserModel::with('level')->find($id);
        $activeMenu = 'user';
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::with('level')->find($id);
    
        if (!$user) {
            return view('user.show_ajax')->with('user', null);
        }
    
        return view('user.show_ajax', ['user' => $user]);
    }
//menampilkan halaman form edit user
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

    public function update(Request $request, int $id)
    {
        $request->validate([
            'level_id' => 'required | integer',
            'username' => 'required | string | min:3 | unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required | string | max:100',
            'password' => 'nullable | min:5'
        ]);

        $user = UserModel::find($id);
        $user->level_id = $request->level_id;
        $user->username = $request->username;
        $user->nama = $request->nama;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }
    //menghapus data user
    public function destroy(int $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user tidak bisa dihapus karena masih terdapat data terkait');
        }
    }
    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
        ->with('level', $level);
    }
    public function store_ajax(Request $request)
{
    // Cek apakah request berupa AJAX atau JSON
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6'
        ];

        // Validasi data
        $validator = Validator::make($request->all(), $rules);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // Simpan data jika validasi berhasil
        UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
    }

    // Jika bukan request AJAX, kembalikan ke halaman awal
    return redirect('/user')->with('error', 'Permintaan tidak valid');
}
    // Menampilkan halaman form edit user ajax
public function edit_ajax(string $id)
{
    $user = UserModel::find($id);
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }
    public function update_ajax(Request $request, $id)
{
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ];

        // use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // respon json, true: berhasil, false: gagal 
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors() // menunjukkan field mana yang error
            ]);
        }

        $check = UserModel::find($id);
        if ($check) {
            if (!$request->filled('password')) { 
                // jika password tidak diisi, maka hapus dari request
                $request->request->remove('password');
            }

            $check->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    return redirect('/');
}
    public function confirm_ajax(string $id) {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
}
    public function delete_ajax(Request $request, $id)
{
    // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

    return redirect('/');
}

public function profile()
    {
        $user = auth()->user();
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $page = (object) [
            'title' => 'User Profile'
        ];

        $activeMenu = 'profile';
        return view('profile', compact('breadcrumb', 'page', 'user', 'activeMenu'));
    }

     public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $authUser = auth()->user();
        $user = UserModel::find($authUser->user_id);

        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = 'uploads/profile/';

        if (!file_exists(public_path($filePath))) {
            mkdir(public_path($filePath), 0777, true);
        }

        $file->move(public_path($filePath), $fileName);

        $user->image = $filePath . $fileName;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile picture updated successfully',
            'image_url' => $user->getProfilePictureUrl()
        ]);
    }
}