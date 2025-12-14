<?php

namespace App\Observers;

use App\Models\Pembelian;
use App\Services\JurnalUmumService;

class PembelianObserver
{
    protected $jurnalService;

    public function __construct(JurnalUmumService $jurnalService)
    {
        $this->jurnalService = $jurnalService;
    }

    /**
     * Handle the Pembelian "updated" event.
     */
    public function updated(Pembelian $pembelian)
    {
        // Jika status berubah menjadi complete, buat jurnal
        if ($pembelian->isDirty('status') && $pembelian->status === 'complete') {
            $this->jurnalService->generateFromPembelian($pembelian);
        }
        
        // Jika pembelian yang sudah complete diupdate totalnya, update jurnal
        if ($pembelian->status === 'complete' && $pembelian->isDirty('total_pembelian')) {
            $this->jurnalService->updateFromSource('pembelian', $pembelian->id);
        }
    }

    /**
     * Handle the Pembelian "deleted" event.
     */
    public function deleted(Pembelian $pembelian)
    {
        // Hapus jurnal terkait
        $this->jurnalService->deleteBySource('pembelian', $pembelian->id);
    }
}