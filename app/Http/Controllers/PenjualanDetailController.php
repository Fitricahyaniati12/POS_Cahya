<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan Detail',
            'list' => ['Home', 'Penjualan Detail']
        ];

        $page = (object) [
            'title' => 'Daftar penjualan detail yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan_detail';

        $penjualan_detail = PenjualanDetailModel::all();
        
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        return view('penjualan_detail.index', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'penjualan_detail', 'barang'));
    }

    public function list(Request $request)
    {
        $detail = PenjualanDetailModel::with(['penjualan', 'barang'])->select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah');


        if ($request->penjualan_id) {
            $detail->where('penjualan_id', $request->penjualan_id);
        }

        if ($request->barang_id) {
            $detail->where('barang_id', $request->barang_id);
        }
        return DataTables::of($detail->get())
        ->addIndexColumn()
        ->addColumn('penjualan_kode', function ($penjualan_detail) {
            return $penjualan_detail->penjualan->penjualan_kode ?? '-';
        })
        ->addColumn('barang_id', function ($penjualan_detail) {
            return $penjualan_detail->barang->barang_kode ?? '-';
        })
        ->addColumn('subtotal', fn($penjualan_detail) => $penjualan_detail->jumlah * $penjualan_detail->harga)
        ->addColumn('aksi', function ($penjualan_detail) {
            $btn  = '<button onclick="modalAction(\'' . url('/penjualan_detail/' . $penjualan_detail->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan_detail/' . $penjualan_detail->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan_detail/' . $penjualan_detail->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    
    
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan Detail',
            'list' => ['Home', 'Penjualan Detail', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data penjualan detail baru'
        ];

        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        $activeMenu = 'penjualan_detail';

        return view('penjualan_detail.create', compact('breadcrumb', 'page', 'penjualan', 'barang', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|int',
            'jumlah' => 'required|int'
        ]);

        PenjualanDetailModel::create($request->all());

        return redirect('/penjualan_detail')->with('success', 'Data penjualan detail berhasil disimpan');
    }

    public function show(string $id)
    {
        $penjualan_detail = PenjualanDetailModel::with(['penjualan', 'barang'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Data Penjualan Detail',
            'list' => ['Home', 'Penjualan Detail', 'Detail']
        ];

        $page = (object) [
            'title' => 'Data penjualan detail'
        ];

        $activeMenu = 'penjualan_detail';

        return view('penjualan_detail.show', compact('breadcrumb', 'page', 'penjualan_detail', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $penjualan_detail = PenjualanDetailModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Penjualan Detail',
            'list' => ['Home', 'Penjualan Detail', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit penjualan detail'
        ];

        $activeMenu = 'penjualan_detail';

        return view('penjualan_detail.edit', compact('breadcrumb', 'page', 'penjualan_detail', 'penjualan', 'barang', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|int',
            'jumlah' => 'required|int'
        ]);

        PenjualanDetailModel::find($id)->update($request->only(['penjualan_id', 'barang_id', 'harga', 'jumlah']));

        return redirect('/penjualan_detail')->with('success', 'Data penjualan detail berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = PenjualanDetailModel::find($id);
        if (!$check) {
            return redirect('/penjualan_detail')->with('error', 'Data penjualan detail tidak ditemukan');
        }

        try {
            PenjualanDetailModel::destroy($id);
            return redirect('/penjualan_detail')->with('success', 'Data penjualan detail berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan_detail')->with('error', 'Data gagal dihapus karena terkait dengan data lain');
        }
    }

    public function create_ajax()
{
    $penjualan = PenjualanModel::all();
    $barang = BarangModel::all();
    return view('penjualan_detail.create_ajax', compact('penjualan', 'barang'));
}


    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'harga' => 'required|int',
                'jumlah' => 'required|int'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            PenjualanDetailModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan detail berhasil disimpan'
            ]);
        }

        return redirect('/');
    }
    public function show_ajax(string $id)
{
    $penjualan_detail = PenjualanDetailModel::with(['penjualan', 'barang'])->findOrFail($id);
    return view('penjualan_detail.show_ajax', compact('penjualan_detail'));
}

    

    public function edit_ajax(string $id)
    {
        $penjualan_detail = PenjualanDetailModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        return view('penjualan_detail.edit_ajax', compact('penjualan_detail', 'penjualan', 'barang'));
    }

    public function update_ajax(Request $request, string $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|numeric',  // bisa menggunakan numeric untuk harga
            'jumlah' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // Mencari data berdasarkan ID
        $penjualan_detail = PenjualanDetailModel::find($id);
        if ($penjualan_detail) {
            try {
                // Mengupdate data dengan memfilter kolom yang diizinkan
                $penjualan_detail->penjualan_id = $request->penjualan_id;
                $penjualan_detail->barang_id = $request->barang_id;
                $penjualan_detail->harga = $request->harga;
                $penjualan_detail->jumlah = $request->jumlah;
                $penjualan_detail->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal memperbarui data. Error: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    return redirect('/');
}


    public function confirm_ajax(string $id)
    {
        $penjualan_detail = PenjualanDetailModel::find($id);
        return view('penjualan_detail.confirm_ajax', compact('penjualan_detail'));
    }

    public function delete_ajax(Request $request, $id)
{
    if (!$request->ajax()) {
        return redirect('/');
    }

    $detail = PenjualanDetailModel::find($id);

    if (!$detail) {
        return response()->json([
            'status'  => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    try {
        $detail->delete(); // atau PenjualanDetailModel::destroy($id);
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus'
        ]);
    } catch (\Illuminate\Database\QueryException $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Data gagal dihapus karena terkait dengan data lain'
        ]);
    }
}
}