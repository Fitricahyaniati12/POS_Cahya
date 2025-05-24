<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Symfony\Component\HttpFoundation\Response;



class KategoriController extends Controller
{
    public function index()
    {
        return KategoriModel::all();
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_kategori' => 'required|string|max:255',
        'deskripsi' => 'nullable|string'
    ]);

    $kategori = KategoriModel::create($validated);

    return response()->json($kategori, Response::HTTP_CREATED);
}


       public function update(Request $request, $kategori_id)
    {
        $kategori = KategoriModel::where('kategori_id', $kategori_id)->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $kategori->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $kategori
        ]);
    }




   public function destroy($kategori_id)
{
    $kategori = KategoriModel::where('kategori_id', $kategori_id)->first();

    if (!$kategori) {
        return response()->json([
            'success' => false,
            'message' => 'Data not found'
        ], 404);
    }

    $kategori->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data deleted successfully'
    ]);
}
}