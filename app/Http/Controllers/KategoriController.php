<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        // Menyisipkan data ke dalam tabel m_kategori
       /* $data = [
            'nama_kategori' => 'Snack/Makanan Ringan',
            'deskripsi' => 'Makanan ringan seperti keripik, biskuit, dan permen',
            'created_at' => now()
        ];

        DB::table('m_kategori')->insert($data);
        return "Insert data baru berhasil";*/

         // Memperbarui data berdasarkan kategori_kode
       /* $row = DB::table('m_kategori')
        ->where('nama_kategori', 'Snack/Makanan Ringan') 
        ->update([
            'nama_kategori' => 'Camilan',
            'deskripsi' => 'Berbagai jenis camilan ringan',
            'updated_at' => now()
        ]);

        return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';*/

        // Menghapus data berdasarkan kategori_kode
       /* $row = DB::table('m_kategori')
        ->where('nama_kategori', 'Camilan')
        ->delete();

        return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';*/


        //menampilkan data dalam table 
        $data = DB::table('m_kategori')->get();
       return view('kategori', ['data' => $data]);




    }
}
