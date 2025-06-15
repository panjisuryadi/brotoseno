<?php

namespace App\Http\Livewire\Reports;

use Illuminate\Support\Facades\DB;
use DateTime;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\PenjualanSale\Models\PenjualanSale;

class LaporanSales extends Component
{

    public $listSales;
    public $sales_id;
    public $dataSales = [
        'name'
    ];
    public $salesArray = [];

    public $period_type = '';
    public $month;
    public $year;
    public $start_date;
    public $end_date;

    public function mount(){
        $this->listSales = DataSale::all();
        $this->salesArray = $this->listSales->map(function($data){
                                    return $data;
                                })
                                ->flatten()
                                ->keyBy('id')
                                ->toArray();
    }

    public function render()
    {
        $data = $rekapan_nominal = $rekapan_emas =[];
        $piutang_emas = $dibayar_emas = $piutang_nominal = $dibayar_nominal = 0;
        if(!empty($this->sales_id)) {

            /** 
             * Agar data setoran dan data pembayaran terpisah row maka harus dibikin unionnya
             */
            $a = DB::table('penjualan_sales as ps')
            ->select(
                'ps.date',
                'ps.invoice_no',
                'ps.total_nominal',
                'ps.total_jumlah',
                'ps.harga_type',
                'ps.konsumen_sales_id',
                'ps.created_at as tgl_transaksi',
                'datasales.name',
                DB::raw("'' as lunas"),
                DB::raw("'0' as jumlah_cicilan"),
                DB::raw("'setoran' as tipe_emas"),
                DB::raw("'0' as nominal"),
                DB::raw("'' as karat_name"),
                DB::raw("'0' as berat"),
                'customer_sales.customer_name',
                'customer_sales.market',
            )
            ->leftJoin('datasales', function($q) {
                $q->on('sales_id', 'datasales.id');
            })
            ->leftJoin('customer_sales', function($q) {
                $q->on('customer_sales.id', 'ps.konsumen_sales_id');
            })
            ->when($this->sales_id, function ($query) {
                return $query->where('sales_id', $this->sales_id);
            })
            ->when($this->month, function ($query) {
                return $query->whereRaw('MONTH(ps.created_at) = ? AND YEAR(ps.created_at) = ?', [date('m', strtotime($this->month)), date('Y', strtotime($this->month))]);
            })
            ->when($this->year, function ($query) {
                return $query->whereYear('ps.created_at',$this->year);
            })
            ->when($this->start_date, function ($query) {
                return $query->whereDate('ps.created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('ps.created_at', '<=', $this->end_date);
            });

            $data = DB::table('penjualan_sales as ps')
            ->select(
                'ps.date',
                'ps.invoice_no',
                DB::raw("'0' as total_nominal"),
                DB::raw("'0' as total_jumlah"),
                'ps.harga_type',
                'ps.konsumen_sales_id',
                'penjualan_sales_payment_detail.created_at as tgl_transaksi',
                'datasales.name',
                'penjualan_sales_payment.lunas',
                'penjualan_sales_payment_detail.jumlah_cicilan',
                'penjualan_sales_payment_detail.tipe_emas',
                'penjualan_sales_payment_detail.nominal',
                'karats.name as karat_name',
                'penjualan_sales_payment_detail.berat',
                'customer_sales.customer_name',
                'customer_sales.market',
            )
            ->leftJoin('datasales', function($q) {
                $q->on('sales_id', 'datasales.id');
            })
            ->rightJoin('penjualan_sales_payment', function($q){
                $q->on('ps.id', 'penjualan_sales_payment.penjualan_sales_id');
            })
            ->rightJoin('penjualan_sales_payment_detail', function($q) {
                $q->on('penjualan_sales_payment_detail.payment_id', 'penjualan_sales_payment.id');
            })
            ->leftJoin('karats', function($q) {
                $q->on('penjualan_sales_payment_detail.karat_id', 'karats.id');
            })
            ->leftJoin('customer_sales', function($q) {
                $q->on('customer_sales.id', 'ps.konsumen_sales_id');
            })
            ->when($this->sales_id, function ($query) {
                return $query->where('sales_id', $this->sales_id);
            })
            ->when($this->month, function ($query) {
                return $query->whereRaw('MONTH(penjualan_sales_payment_detail.created_at) = ? AND YEAR(penjualan_sales_payment_detail.created_at) = ?', [date('m', strtotime($this->month)), date('Y', strtotime($this->month))]);
            })
            ->when($this->year, function ($query) {
                return $query->whereYear('penjualan_sales_payment_detail.created_at',$this->year);
            })
            ->when($this->start_date, function ($query) {
                return $query->whereDate('penjualan_sales_payment_detail.created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('penjualan_sales_payment_detail.created_at', '<=', $this->end_date);
            })
            ->union($a)
            ->orderBy('tgl_transaksi', 'ASC')
            ->get();
            foreach($data as $row) {
                if($row->harga_type == 'nominal') {
                    $dibayar_nominal += $row->nominal ?? 0;
                    $piutang_nominal += $row->total_nominal;
                    $rekapan_nominal[] = $row;
                }else{
                    $dibayar_emas += $row->jumlah_cicilan;
                    $piutang_emas += $row->total_jumlah;
                    $rekapan_emas[] = $row;
                }
            }
        }
        
        return view('livewire.reports.laporan-sales', [
            'data' => $data,
            'piutang_emas' => $piutang_emas,
            'dibayar_emas' => $dibayar_emas,
            'piutang_nominal' => $piutang_nominal,
            'dibayar_nominal' => $dibayar_nominal,
            'rekapan_nominal' => $rekapan_nominal,
            'rekapan_emas' => $rekapan_emas,
        ]);
    }

    public function resetFilter(){
        $this->reset([
            'start_date',
            'end_date',
            'month',
            'year',
            'sales_id'
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
