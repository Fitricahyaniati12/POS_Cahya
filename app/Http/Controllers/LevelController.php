<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
   
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Level',
            'list' => ['Home', 'Level']
        ];
        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];
        $activeMenu = 'level';

        $level = LevelModel::all();
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
{
    $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

    if ($request->filled('kode_level')) {
        $levels->where('level_kode', $request->kode_level);
    }
        
        return DataTables::of($levels)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
                return $btn;
            })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
}

public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Level',
        'list' => [
            'Home',
            'Level',
            'Tambah'
        ]
    ];
    $page = (object) [
        'title' => 'Tambah level baru'
    ];
    $level = LevelModel::all();
    $activeMenu = 'level'; // set menu yang sedang aktif
    return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
}

public function create_ajax()
{
    return view('level.create_ajax');
}

public function store_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ]);
        }

        try {
            LevelModel::create([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error_detail' => $e->getMessage()
            ]);
        }
    }

    return response()->json([
        'status' => false,
        'message' => 'Request tidak valid'
    ]);
}

// Menyimpan data level baru
public function store(Request $request)
{
    $request->validate([
        'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
        'level_nama' => 'required|string|max: 100'
    ]);
    LevelModel::create([
        'level_kode' => $request->level_kode,
        'level_nama' => $request->level_nama
    ]);
    return redirect('/level')->with('success', 'Data level berhasil disimpan');
}



// Menampilkan detail level
public function show(string $id)
{
    $level = LevelModel::find($id);
    $breadcrumb = (object) [
        'title' => 'Detail Level',
        'list' => ['Home', 'Level', 'Detail']
    ];
    $page =
        (object) [
            'title' => 'Detail level'
        ];
    $activeMenu = 'level'; // set menu yang sedang aktif
    return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
}

public function show_ajax(string $id)
{
    $level = LevelModel::find($id);
    return view('level.show_ajax', ['level' => $level]);
}
// Menampilkan halaman form edit level
public function edit(string $id)
{
    $level = LevelModel::find($id);
    $breadcrumb = (object) [
        'title' => 'Edit Level',
        'list' => ['Home', 'Level', 'Edit']
    ];
    $page = (object) [
        'title' => 'Edit level'
    ];
    $activeMenu = 'level'; // set menu yang sedang aktif
    // Menyimpan perubahan data level
    return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
}
public function update(Request $request, string $id)
{
    $request->validate([
        'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
        'level_nama' => 'required|string|max:100',
    ]);

    LevelModel::find($id)->update([
        // level_id harus diisi dan berupa angka
        'level_kode' => $request->level_kode,
        'level_nama' => $request->level_nama
    ]);
    return redirect('/level')->with('success', 'Data level berhasil diubah');
}

public function edit_ajax(string $id)
{
    $level = LevelModel::find($id);
    return view('level.edit_ajax', ['level' => $level]);
}

public function update_ajax(Request $request, $id)
{
    // cek apakah request dari ajax 
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100'
        ];

        // use Illuminate\Support\Facades\Validator; 
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,    // respon json, true: berhasil, false: gagal 
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors()  // menunjukkan field mana yang error 
            ]);
        }
        $check = LevelModel::find($id);
        if ($check) {
            if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request 
                $request->request->remove('password');
            }
            $check->update($request->all());
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    redirect('/');
}

// Menghapus data level
public function destroy(string $id)
{
    $check =LevelModel::find($id);
    if (!$check) {
        // untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
        return redirect('/level')->with('error', 'Data level tidak ditemukan ');
    }
    try {
      LevelModel::destroy($id);
        // Hapus data level
        return redirect('/level')->with('success', 'Data level berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
}

public function confirm_ajax(string $id)
{
    $level =LevelModel::find($id);
    return view('level.confirm_ajax', ['level' => $level]);
}

public function delete_ajax(Request $request, $id)
{
    if($request->ajax() || $request->wantsJson()){
        $level =LevelModel::find($id);
        if($level){
            try {
              LevelModel::destroy($id);
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
                ]);
            }
        }else{
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
}
    redirect('/');
}
}
