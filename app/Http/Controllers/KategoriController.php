<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar di sistem'
        ];

        $activeMenu = 'kategori';

        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $kategoris = KategoriModel::select('kategori_id', 'nama_kategori', 'deskripsi');
        
        if ($request->nama_kategori) {
            $kategoris->where('nama_kategori', $request->nama_kategori);
        }
        return DataTables::of($kategoris)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];
        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
        'nama_kategori' => 'required',
        'deskripsi' => 'required',
    ]);

    KategoriModel::create([
        'nama_kategori' => $request->nama_kategori,
        'deskripsi' => $request->deskripsi,
    ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

   

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.show', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];
        $page = (object) ['title' => 'Edit kategori'];
        $activeMenu = 'kategori';

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ]);
    
        $kategori = KategoriModel::find($id);
        if ($kategori) {
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
            ]);
            return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
        } else {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
    }
    
    public function destroy(String $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kategori' => 'required|string|min:3|unique:m_kategori,nama_kategori',
                'deskripsi' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            KategoriModel::create([
                'nama_kategori' => $request->nama_kategori, // ganti dari kategori_kode
                'deskripsi' => $request->deskripsi,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(String $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.edit_ajax', compact('kategori'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kategori' => 'required|string|min:3|unique:m_kategori,nama_kategori,' . $id . ',kategori_id',
                'deskripsi' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $check = KategoriModel::find($id);

            if ($check) {
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
        return redirect('/kategori');
    }

    public function show_ajax(String $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.show_ajax', compact('kategori'));
    }

    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                try {
                    $kategori->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data gagal dihapus! (terdapat tabel lain yang terkait dengan data ini)'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/kategori');
    }
}