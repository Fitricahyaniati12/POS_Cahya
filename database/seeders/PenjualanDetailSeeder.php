<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $harga_barang = [10000, 15000, 20000, 25000, 30000]; // Contoh harga barang
        $jumlah_barang = [1, 2, 3, 4, 5]; // Contoh jumlah barang

        for ($penjualan_id = 1; $penjualan_id <= 10; $penjualan_id++) {
            for ($i = 1; $i <= 3; $i++) { // 3 item per transaksi
                $data[] = [
                    'detail_id' => ($penjualan_id - 1) * 3 + $i,
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => rand(1, 5), // Random barang_id antara 1-5
                    'harga' => $harga_barang[array_rand($harga_barang)], // Pilih harga acak
                    'jumlah' => $jumlah_barang[array_rand($jumlah_barang)], // Pilih jumlah acak
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}
