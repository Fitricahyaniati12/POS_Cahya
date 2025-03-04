<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Laptop',
                'harga_beli' => 7000000,
                'harga_jual' => 8500000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Smartphone',
                'harga_beli' => 4000000,
                'harga_jual' => 5000000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Kaos Polos',
                'harga_beli' => 50000,
                'harga_jual' => 75000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'BRG004',
                'barang_nama' => 'Celana Jeans',
                'harga_beli' => 150000,
                'harga_jual' => 250000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'BRG005',
                'barang_nama' => 'Susu UHT',
                'harga_beli' => 5000,
                'harga_jual' => 8000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'BRG006',
                'barang_nama' => 'Mie Instan',
                'harga_beli' => 2000,
                'harga_jual' => 3500,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'BRG007',
                'barang_nama' => 'Vitamin C',
                'harga_beli' => 10000,
                'harga_jual' => 25000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'BRG008',
                'barang_nama' => 'Masker Medis',
                'harga_beli' => 5000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'BRG009',
                'barang_nama' => 'Panci',
                'harga_beli' => 100000,
                'harga_jual' => 250000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'BRG010',
                'barang_nama' => 'Setrika',
                'harga_beli' => 200000,
                'harga_jual' => 450000,
            ],
        ];
        DB :: table('m_barang')->insert($data);
    }
}
