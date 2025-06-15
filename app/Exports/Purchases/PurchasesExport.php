<?php

namespace App\Exports\Purchases;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Sale\Entities\Sale;

class PurchasesExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private $data) {}
    public function headings(): array
    {
        return [
            __('Transaction Date'),
            __('Transaction No'),
            __('Supplier'),
            __('Detail'),
            __('Total'),
        ];
    }

    public function map($data): array
    {
        $data = (object) $data;
        $detail = "";
        $detail .= "No. Surat Jalan / Invoice : $data->no_invoice \r\n";
                $tgl_bayar = !empty($data->tgl_bayar) ?  $data->tgl_bayar : $data->date;
        $detail .= "Tgl Bayar ". (!empty($data->nomor_cicilan) && $data->tipe_pembayaran == 'cicil'  ? '( Cicilan ke -' . $data->nomor_cicilan . ')' : '') . ":" . \Carbon\Carbon::parse($tgl_bayar)->format('d M, Y H:i:s') . " \r\n";
        if($data->tipe_pembayaran != 'lunas') { 
            $detail .= "Tipe Pembayaran : " .label_case($data->tipe_pembayaran) . " \r\n";
        }
        $detail .="Status Pembayaran : ". (!empty($data->lunas) ? label_case($data->lunas) : ($data->tipe_pembayaran =='lunas' ? 'Lunas' : 'Belum Lunas' )) . " \r\n";
        if(!empty($data->total_emas) && empty($data->total_karat)) { 
            $detail .= "Berat yang dibayar : ". floatval(!empty($data->jumlah_cicilan) ? $data->jumlah_cicilan :$data->total_emas) . " gr  \r\n";
        }elseif(empty($data->total_emas) && !empty($data->total_karat)) {
            $detail .= "Karat yang dibayar : $data->total_karat ct \r\n";
        }else{
            $detail .= "Berat yang dibayar: ".floatval(!empty($data->jumlah_cicilan) ? $data->jumlah_cicilan :$data->total_emas) . "gr  \r\n";
            $detail .= "Karat yang dibayar : $data->total_karat ct \r\n";
        }
        return [
            tanggal($data->date),
            $data->code,
            $data->supplier_name,
            $detail,
            number_format(!empty( $data->nominal) ? $data->nominal : $data->harga_beli),
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
}
