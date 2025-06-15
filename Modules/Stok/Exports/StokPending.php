<?php

namespace Modules\Stok\Exports;
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
use Modules\Stok\Models\StockPending;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockKroom;

class StokPending implements FromView, WithTitle, ShouldAutoSize, WithEvents, WithStyles
{
      /**
     * @return Builder
     */

     
       protected $tanggal;
       protected $judul;
       protected $status;
      
     public function  __construct($tanggal,$status,$judul) {
              
                $this->tanggal =  $tanggal;
                $this->judul   =  $judul;
                $this->status   =  $status;


        }


    public function view(): View
        {

             $status = $this->status ?? '';
             $judul = $this->judul ?? '';
             //dd($status);

             if ($status == 'lantakan') {
                 $judul   =  'Lantakan';
                 $data_stok = StockKroom::get();
             }
              elseif($status == 'office'){
                 $judul   = 'Pending';
                 $data_stok = Product::pending()->get();

             }else{
                 $judul   = 'Pending';
                 $data_stok = Product::pending()->get();
             }
           
             return view('stok::stoks.export_excel', [
                'data_stok' => $data_stok,
                'judul' =>$judul, 
                'status' =>$status, 
            ]);
        }



    /**
     * @return string
     */
    public function title(): string
    {
        return 'STOK | ' .$this->judul;
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


