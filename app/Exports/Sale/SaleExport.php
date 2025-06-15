<?php

namespace App\Exports\Sale;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Modules\Sale\Entities\Sale;

class SaleExport implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct(private $sales,private $cabang,private $period,private $total_nominal, private $filename) {}
    
    public function view(): View
    {
        return view('reports::sales.xlsx', [
            'sales' => $this->sales,
            'cabang' => $this->cabang,
            'period' => $this->period,
            'total_nominal' => $this->total_nominal,
            'filename' => $this->filename
        ]);
    }

    public function title(): string
    {
        return $this->filename;
    }
}
