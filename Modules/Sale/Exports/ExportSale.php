<?php

namespace Modules\Sale\Exports;
use Carbon\Carbon;
use App\Models\User;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;

class ExportSale implements FromView, WithTitle, ShouldAutoSize, WithEvents, WithStyles
{
      /**
     * @return Builder
     */

     
       protected $tanggal;
       protected $judul;
       protected $status;
       protected $type;
      
     public function  __construct($tanggal,$status,$type,$judul) {
              
                $this->tanggal =  $tanggal;
                $this->judul   =  $judul;
                $this->status   =  $status;
                $this->type   =  $type;


        }


    public function view(): View
        {

             $type = $this->type ?? '';
             $status = $this->status ?? '';
             $judul = $this->judul ?? '';
             //dd($status);
              if($type == null) {
                 $data_sale =  Sale::akses()->orderBy('created_at', 'desc')
                 ->get();            
                }else{
                  $data_sale = Sale::akses()->where('payment_method',$type)
                    ->orderBy('created_at', 'desc')->get();
                }
               $data = $data_sale;
               //dd($data);
               return view('sale::export_excel', [
                'data' => $data,
                'judul' =>$judul, 
                'status' =>$status, 
            ]);
        }



    /**
     * @return string
     */
    public function title(): string
    {
        return 'Penjualan | ' .$this->judul;
    }
 


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:G1');
                $event->sheet->getDelegate()->mergeCells('A2:G2');
                $event->sheet->getDefaultRowDimension()->setRowHeight(17);
              
            },
        ];



    }

 public function styles(Worksheet $sheet)
    {
        // Apply styles to the header row
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
          
        ]);

      $sheet->getStyle('A2:G2')->applyFromArray([
            'font' => [
                'bold' => false,
            ],
         
          ]);


    }








}


