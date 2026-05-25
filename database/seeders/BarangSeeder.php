<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barang = [
            [
                'kode_barang'  => 'TV-0001',
                'nama_barang'  => 'Samsung Smart TV 43 Inch',
                'kategori'     => 'TV',
                'merk'         => 'Samsung',
                'harga'        => 4500000,
                'stok'         => 0,
                'stok_minimum' => 3,
                'metode'       => 'FIFO',
            ],
            [
                'kode_barang'  => 'AC-0001',
                'nama_barang'  => 'LG AC Split 1 PK',
                'kategori'     => 'AC',
                'merk'         => 'LG',
                'harga'        => 3800000,
                'stok'         => 0,
                'stok_minimum' => 3,
                'metode'       => 'FIFO',
            ],
            [
                'kode_barang'  => 'KUL-0001',
                'nama_barang'  => 'Sharp Kulkas 2 Pintu 315 Liter',
                'kategori'     => 'Kulkas',
                'merk'         => 'Sharp',
                'harga'        => 4200000,
                'stok'         => 0,
                'stok_minimum' => 2,
                'metode'       => 'FIFO',
            ],
            [
                'kode_barang'  => 'MES-0001',
                'nama_barang'  => 'Panasonic Mesin Cuci Front Loading 8 Kg',
                'kategori'     => 'Mesin Cuci',
                'merk'         => 'Panasonic',
                'harga'        => 5500000,
                'stok'         => 0,
                'stok_minimum' => 2,
                'metode'       => 'FIFO',
            ],
            [
                'kode_barang'  => 'DIS-0001',
                'nama_barang'  => 'Miyako Dispenser Galon Bawah',
                'kategori'     => 'Dispenser',
                'merk'         => 'Miyako',
                'harga'        => 350000,
                'stok'         => 0,
                'stok_minimum' => 5,
                'metode'       => 'FIFO',
            ],
        ];

        $now = now();
        foreach ($barang as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('barang')->insert($barang);

        $this->command->info('Barang seeder selesai: ' . count($barang) . ' barang berhasil ditambahkan.');
    }
}
