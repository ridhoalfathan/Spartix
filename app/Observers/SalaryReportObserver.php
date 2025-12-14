<?php

namespace App\Observers;

use App\Models\SalaryReport;
use App\Services\JurnalUmumService;

class SalaryReportObserver
{
    protected $jurnalService;

    public function __construct(JurnalUmumService $jurnalService)
    {
        $this->jurnalService = $jurnalService;
    }

    /**
     * Handle the SalaryReport "updated" event.
     */
    public function updated(SalaryReport $salaryReport)
    {
        // Jika status berubah menjadi paid, buat jurnal
        if ($salaryReport->isDirty('status') && $salaryReport->status === 'paid') {
            $this->jurnalService->generateFromSalaryReport($salaryReport);
        }
        
        // Jika salary yang sudah paid diupdate totalnya, update jurnal
        if ($salaryReport->status === 'paid' && $salaryReport->isDirty('total_gaji')) {
            $this->jurnalService->updateFromSource('salary_report', $salaryReport->id);
        }
    }

    /**
     * Handle the SalaryReport "deleted" event.
     */
    public function deleted(SalaryReport $salaryReport)
    {
        // Hapus jurnal terkait
        $this->jurnalService->deleteBySource('salary_report', $salaryReport->id);
    }
}