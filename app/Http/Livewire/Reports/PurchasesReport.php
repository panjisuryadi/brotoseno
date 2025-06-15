<?php

namespace App\Http\Livewire\Reports;

use App\Exports\Purchases\PurchasesExport;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PurchasesReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $suppliers;
    public $start_date;
    public $end_date;
    public $supplier_id;
    public $purchase_data;
    public $total_harga;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount($suppliers) {
        $this->suppliers = $suppliers;
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->supplier_id = '';
    }

    public function render() {

        $data = DB::table('goodsreceipts as gr')
                ->select(
                    'gr.date',
                    'gr.code',
                    'gr.no_invoice',
                    'gr.harga_beli',
                    'gr.total_emas',
                    'gr.total_karat',
                    'gr.tipe_pembayaran',
                    'gr.supplier_id',
                    'suppliers.supplier_name',
                    'tipe_pembelian.lunas',
                    'penerimaan_barang_cicilan.updated_at as tgl_bayar',
                    'penerimaan_barang_cicilan.jumlah_cicilan',
                    'penerimaan_barang_cicilan.nomor_cicilan',
                    'penerimaan_barang_cicilan.nominal',
                )
                ->leftJoin('suppliers', function($q) {
                    $q->on('supplier_id', 'suppliers.id');
                })
                ->leftJoin('tipe_pembelian', function($q){
                    $q->on('gr.id', 'tipe_pembelian.goodsreceipt_id');
                })
                ->leftJoin('penerimaan_barang_cicilan', function($q) {
                    $q->on('payment_id', 'tipe_pembelian.id');
                })
                ->whereDate('gr.date', '>=', $this->start_date)
                ->whereDate('gr.date', '<=', $this->end_date)
                ->when($this->supplier_id, function ($query) {
                    return $query->where('supplier_id', $this->supplier_id);
                })
                ->where(function($q){
                    $q->where('gr.tipe_pembayaran', 'lunas');
                    $q->orWhere('nominal', '>', '0');
                    $q->orWhere('jumlah_cicilan', '>', '0');
                })
                ->orderBy('tgl_bayar', 'desc');
        $this->purchase_data = $data->clone()->get();
        $total_harga = $total_emas = 0;
        foreach ($this->purchase_data as $row){
            $row_nominal = !empty( $row->nominal) ? $row->nominal : $row->harga_beli;
            $total_harga += $row_nominal;
            $total_emas += (empty($row_nominal) ? $row->jumlah_cicilan : 0);
        }
        $this->total_harga = $total_harga;

        return view('livewire.reports.purchases-report', [
            'datas' => $data->paginate(10),
            'total_harga' => $total_harga,
            'total_emas' => $total_emas,
        ]);
    }

    public function generateReport() {
        $this->validate();
        $this->render();
    }

    public function pdf(){
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Penjualan Periode " . $start_date . " - " . $end_date;
        $datas = $this->purchase_data;
        $total_harga = $this->total_harga;
        $pdf = PDF::loadView('reports::purchases.print',compact('start_date','filename','end_date','datas', 'total_harga'))->setPaper('a4', 'landscape')->output();
        $base64Pdf = base64_encode($pdf);
        $dataUri = 'data:application/pdf;base64,' . $base64Pdf;
        $this->emit('openInNewTab', $dataUri);
    }

    public function export($format): BinaryFileResponse
    {
        abort_if(! in_array($format,['csv','xlsx','pdf']), Response::HTTP_NOT_FOUND);
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Pembelian Periode " . $start_date . " - " . $end_date;
        return Excel::download(new PurchasesExport($this->purchase_data), $filename. '.' . $format);
    }

    public function resetFilter(){
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->supplier_id = '';
    }
}
