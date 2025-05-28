<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $barang = BarangModel::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $barang
        ], Response::HTTP_CREATED);
    }

   public function show($barang_kode)
{
    $barang = BarangModel::where('barang_kode', $barang_kode)->first();

    if (!$barang) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $barang
    ]);
}

     public function update(Request $request, $barang_id)
    {
        $barang = BarangModel::where('barang_id', $barang_id)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $barang
        ]);
    }


    public function destroy($barang_id)
    {
    
        $barang = BarangModel::find($barang_id); 

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }
   public function add_image(Request $request)
{
   // Validasi input
    $validator = Validator::make($request->all(), [
        'kategori_id' => 'required',
        'barang_kode' => 'required',
        'barang_nama' => 'required',
        'harga_beli' => 'required',
        'harga_jual' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // simpan file gambar
     $imagePath = $request->file('image')->store('barang', 'public');
    $imageName = basename($imagePath);

   // Simpan data ke database
    $barang = BarangModel::create([
        'kategori_id' => $request->kategori_id,
        'barang_kode' => $request->barang_kode,
        'barang_nama' => $request->barang_nama,
        'harga_beli' => $request->harga_beli,
        'harga_jual' => $request->harga_jual,
        'image' => $imagePath, // Disimpan hanya path-nya
    ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Data berhasil ditambahkan dengan gambar',
//         'data' => $barang
//     ], 201);
// }

     return response()->json([
        'success' => true,
        'message' => 'Data berhasil ditambahkan dengan gambar',
        'data' => [
            'kategori_id' => $barang->kategori_id,
            'barang_kode' => $barang->barang_kode,
            'barang_nama' => $barang->barang_nama,
            'harga_beli' => $barang->harga_beli,
            'harga_jual' => $barang->harga_jual,
            'image' => asset('storage/' . $barang->image), // 💡 Ini kunci agar tampil sebagai URL!
            'created_at' => $barang->created_at,
            'updated_at' => $barang->updated_at,
        ]
    ], 201);
}
    }
    
