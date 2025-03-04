<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Perangkat elektronik rumah tangga',
            ],
            [
                'kategori_id' => 2,
                'nama_kategori' => 'Pakaian',
                'deskripsi' => 'Berbagai jenis pakaian dan aksesori',
            ],
            [
                'kategori_id' => 3,
                'nama_kategori' => 'Makanan & Minuman',
                'deskripsi' => 'Produk makanan dan minuman',
            ],
            [
                'kategori_id' => 4,
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Produk kesehatan dan kecantikan',
            ],
            [
                'kategori_id' => 5,
                'nama_kategori' => 'Peralatan Rumah',
                'deskripsi' => 'Peralatan untuk kebutuhan rumah tangga',
            ],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
