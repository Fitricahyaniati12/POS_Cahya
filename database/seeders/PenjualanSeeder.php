<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'Andi',
                'penjualan_kode' => 'PJ001',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 1,
                'pembeli' => 'Rudi',
                'penjualan_kode' => 'PJ002',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 2,
                'pembeli' => 'Widya',
                'penjualan_kode' => 'PJ003',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 2,
                'pembeli' => 'Fatma',
                'penjualan_kode' => 'PJ004',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli' => 'Dikin',
                'penjualan_kode' => 'PJ005',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Fajar',
                'penjualan_kode' => 'PJ006',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Risma',
                'penjualan_kode' => 'PJ007',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'Hanin',
                'penjualan_kode' => 'PJ008',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Indah',
                'penjualan_kode' => 'PJ009',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'Armansyah',
                'penjualan_kode' => 'PJ010',
                'penjualan_tanggal' => Carbon::now(),
            ],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
