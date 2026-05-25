<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        $akunData = [
            // ══════════════════════════════════════════
            // ASET LANCAR
            // ══════════════════════════════════════════
            [
                'kode_akun'     => '1101',
                'nama_akun'     => 'Kas',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 500000000,
                'deskripsi'     => 'Uang tunai yang tersedia di kasir',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '1102',
                'nama_akun'     => 'Bank',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Rekening bank perusahaan',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '1103',
                'nama_akun'     => 'Piutang Usaha',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Tagihan kepada pelanggan yang belum dibayar',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '1201',
                'nama_akun'     => 'Persediaan Barang',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Nilai persediaan barang dagangan (metode FIFO)',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '1301',
                'nama_akun'     => 'Perlengkapan Toko',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Perlengkapan operasional toko',
                'is_active'     => true,
            ],

            // ══════════════════════════════════════════
            // ASET TIDAK LANCAR
            // ══════════════════════════════════════════
            [
                'kode_akun'     => '1501',
                'nama_akun'     => 'Peralatan',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Tidak Lancar',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Peralatan dan inventaris toko',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '1502',
                'nama_akun'     => 'Akumulasi Penyusutan Peralatan',
                'tipe_akun'     => 'Aset',
                'kategori'      => 'Tidak Lancar',
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Akumulasi penyusutan peralatan toko',
                'is_active'     => true,
            ],

            // ══════════════════════════════════════════
            // LIABILITAS LANCAR
            // ══════════════════════════════════════════
            [
                'kode_akun'     => '2101',
                'nama_akun'     => 'Utang Usaha',
                'tipe_akun'     => 'Liabilitas',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Kewajiban kepada supplier yang belum dibayar',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '2102',
                'nama_akun'     => 'Utang Gaji',
                'tipe_akun'     => 'Liabilitas',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Gaji karyawan yang belum dibayarkan',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '2103',
                'nama_akun'     => 'Utang Pajak',
                'tipe_akun'     => 'Liabilitas',
                'kategori'      => 'Lancar',
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Kewajiban pajak yang belum dibayar',
                'is_active'     => true,
            ],

            // ══════════════════════════════════════════
            // EKUITAS
            // ══════════════════════════════════════════
            [
                'kode_akun'     => '3101',
                'nama_akun'     => 'Modal Pemilik',
                'tipe_akun'     => 'Ekuitas',
                'kategori'      => null,
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Modal yang disetor oleh pemilik',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '3201',
                'nama_akun'     => 'Laba Ditahan',
                'tipe_akun'     => 'Ekuitas',
                'kategori'      => null,
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Akumulasi laba yang tidak dibagikan',
                'is_active'     => true,
            ],

            // ══════════════════════════════════════════
            // PENDAPATAN
            // ══════════════════════════════════════════
            [
                'kode_akun'     => '4101',
                'nama_akun'     => 'Pendapatan Penjualan',
                'tipe_akun'     => 'Pendapatan',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Pendapatan dari penjualan barang elektronik',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '4201',
                'nama_akun'     => 'Pendapatan Lain-lain',
                'tipe_akun'     => 'Pendapatan',
                'kategori'      => 'Non-Operasional',
                'posisi_normal' => 'Kredit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Pendapatan di luar kegiatan usaha utama',
                'is_active'     => true,
            ],

            // ══════════════════════════════════════════
            // BEBAN
            // ══════════════════════════════════════════
            [
                'kode_akun'     => '5101',
                'nama_akun'     => 'Beban Pokok Penjualan (HPP)',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Harga pokok barang yang terjual (FIFO)',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '5201',
                'nama_akun'     => 'Beban Gaji Karyawan',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Beban gaji seluruh karyawan',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '5202',
                'nama_akun'     => 'Beban Sewa',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Beban sewa tempat usaha',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '5203',
                'nama_akun'     => 'Beban Listrik & Air',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Beban utilitas listrik dan air',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '5204',
                'nama_akun'     => 'Beban Perlengkapan',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Beban pemakaian perlengkapan toko',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '5205',
                'nama_akun'     => 'Beban Penyusutan Peralatan',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Beban penyusutan peralatan toko',
                'is_active'     => true,
            ],
            [
                'kode_akun'     => '5301',
                'nama_akun'     => 'Beban Lain-lain',
                'tipe_akun'     => 'Beban',
                'kategori'      => 'Non-Operasional',
                'posisi_normal' => 'Debit',
                'saldo_normal'  => 0,
                'deskripsi'     => 'Beban di luar kegiatan usaha utama',
                'is_active'     => true,
            ],
        ];

        $now = now();
        foreach ($akunData as &$item) {
            $item['parent_id']  = null;
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('akuns')->insert($akunData);

        $this->command->info('Akun seeder selesai: ' . count($akunData) . ' akun berhasil ditambahkan.');
    }
}
