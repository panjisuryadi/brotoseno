<?php

namespace App\Http\Livewire\Reports\Piutang;

use App\Models\ProductCategory;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\Reports\Models\PiutangSalesReport;

class SalesReport extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.reports.piutang.sales', [
            'piutang_sales_report' => PiutangSalesReport::with('karat')->paginate(5)
        ]);
    }
}
