<?php

namespace App\Exports\Debt;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class DebtExport implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct(private $gr,private $total_debt,private $supplier,private $period, private $payment_type, private $filename) {}
    
    public function view(): View
    {
        return view('reports::hutang.xlsx', [
            'gr' => $this->gr,
            'total_debt' => $this->total_debt,
            'period' => $this->period,
            'supplier' => $this->supplier,
            'payment_type' => $this->payment_type,
            'filename' => $this->filename
        ]);
    }

    public function title(): string
    {
        return $this->filename;
    }
}
