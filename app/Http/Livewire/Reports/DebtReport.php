<?php

namespace App\Http\Livewire\Reports;

use App\Exports\Debt\DebtExport;
use App\Exports\Sale\SaleExport;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sale\Entities\Sale;
use PDF;
use Illuminate\Http\Response;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\People\Entities\Supplier;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DebtReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $start_date;
    public $end_date;
    public $month;
    public $year;

    public $customer_id;
    public $sale_status;
    public $payment_status;
    public $payment_type;
    public $sales_data;

    public $gr;
    public $period_type = '';
    public $suppliers;
    public $supplier;

    protected $rules = [
        'period_type' => 'required',
        'start_date' => 'required_if:period_type,custom',
        'end_date'   => 'required_if:period_type,custom',
        'month' => 'required_if:period_type,month',
        'year' => 'required_if:period_type,year'
    ];

    public function mount() {
        $this->payment_type = '';
        $this->suppliers = Supplier::all();
    }

    public function render() {
        $goodsreceipt = GoodsReceipt::debts()
            ->when($this->month, function ($query) {
                return $query->whereRaw('MONTH(date) = ? AND YEAR(date) = ?', [date('m', strtotime($this->month)), date('Y', strtotime($this->month))]);
            })
            ->when($this->year, function ($query) {
                return $query->whereYear('date',$this->year);
            })
            ->when($this->start_date, function ($query) {
                return $query->whereDate('date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('date', '<=', $this->end_date);
            })
            ->when($this->payment_type, function ($query) {
                return $query->whereRelation('pembelian', 'tipe_pembayaran',$this->payment_type);
            })
            ->when($this->supplier, function ($query) {
                return $query->where('supplier_id', $this->supplier);
            })
            ->orderBy('date', 'desc');
        
        $this->gr = $goodsreceipt->clone()->get();
        $debts = $this->gr->sum('total_emas');
        $this->gr->each(function($item) use ($debts){
            $debts -= $item->pembelian->total_paid;
        });
        return view('livewire.reports.debt-report', [
            'goodsreceipt' => $goodsreceipt->paginate(10),
            'debts' => $debts
        ]);
    }

    public function filterReport() {
        $this->validate();
        $this->render();
    }

    public function pdf(){
        $this->validate();
        $filename = "Laporan Penjualan " . $this->period_text . " (" . $this->supplier_text . ")";
        $gr = $this->gr;
        $total_debt = $gr->sum('total_emas');
        $supplier = $this->supplier_text;
        $period = $this->period_text;
        $payment = $this->payment_type_text;
        $pdf = PDF::loadView('reports::hutang.pdf',compact('gr','filename','supplier','period','payment','total_debt'))->setPaper('a4', 'landscape')->output();
        $base64Pdf = base64_encode($pdf);
        $dataUri = 'data:application/pdf;base64,' . $base64Pdf;
        $this->emit('openInNewTab', $dataUri);
    }

    public function export($format): BinaryFileResponse
    {
        $this->validate();
        abort_if(! in_array($format,['xlsx']), Response::HTTP_NOT_FOUND);
        $filename = "Laporan Penjualan " . $this->period_text . " (" . $this->supplier_text . ")";
        $gr = $this->gr;
        $total_debt = $gr->sum('total_emas');
        return Excel::download(new DebtExport($gr, $total_debt, $this->supplier_text, $this->period_text, $this->payment_type_text, $filename), $filename. '.' . $format);
    }

    public function updatedPeriodType(){
        $this->reset([
            'start_date',
            'end_date',
            'month',
            'year'
        ]);
    }

    public function getPeriodTextProperty(){
        if($this->period_type === 'month' && !empty($this->month)){
            return "Periode Bulan " . Carbon::parse($this->month)->locale('id_ID')->isoFormat('MMMM YYYY');
        }elseif($this->period_type === 'year' && !empty($this->year)){
            return "Periode Tahun " . $this->year;
        }elseif($this->period_type === 'custom' && !empty($this->start_date) && !empty($this->end_date)){
            return "Periode " . tanggal($this->start_date) . ' - ' . tanggal($this->end_date);
        }
    }

    public function getSupplierTextProperty(){
        if(!empty($this->supplier)){
            return ucwords($this->suppliers->find($this->supplier)->supplier_name);
        }else{
            return "Semua Supplier";
        }
    }

    public function getPaymentTypeTextProperty(){
        if(!empty($this->payment_type)){
            return ucwords($this->payment_type);
        }else{
            return "Semua Tipe Pembayaran (Cicil, Jatuh Tempo)";
        }
    }

    public function resetFilter(){
        $this->reset([
            'start_date',
            'end_date',
            'month',
            'year',
            'payment_type',
            'supplier'
        ]);
    }

    public function getMinDate(){
        if(!empty($this->start_date)){
            $minDate = new DateTime($this->start_date);
            return $minDate->modify("+1 day")->format("Y-m-d");
        }
    }

    public function resetEndDate(){
        $this->reset('end_date');
    }
}
