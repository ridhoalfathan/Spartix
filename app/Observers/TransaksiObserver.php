<?php

namespace App\Observers;

use App\Models\Transaksi;
use App\Services\JurnalUmumService;

class TransaksiObserver
{
    protected $jurnalService;

    public function __construct(JurnalUmumService $jurnalService)
    {
        $this->jurnalService = $jurnalService;
    }

    /**
     * Handle the Transaksi "updated" event.
     */
    public function updated(Transaksi $transaksi)
    {
        // Jika status berubah menjadi sukses, buat jurnal
        if ($transaksi->isDirty('status') && $transaksi->status === 'sukses') {
            $this->jurnalService->generateFromTransaksi($transaksi);
        }
        
        // Jika transaksi yang sudah sukses diupdate totalnya, update jurnal
        if ($transaksi->status === 'sukses' && $transaksi->isDirty('total_transaksi')) {
            $this->jurnalService->updateFromSource('transaksi', $transaksi->id);
        }
    }

    /**
     * Handle the Transaksi "deleted" event.
     */
    public function deleted(Transaksi $transaksi)
    {
        // Hapus jurnal terkait
        $this->jurnalService->deleteBySource('transaksi', $transaksi->id);
    }
}