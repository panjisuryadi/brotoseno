<?php

namespace App\Exports\Distribusi;
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
use Modules\DistribusiToko\Models\DistribusiToko;

class EmasExportDetail implements FromView, WithTitle, ShouldAutoSize, WithEvents, WithStyles
{



/**
     * @return Builder
     */

       protected $dist_toko;
       protected $tanggal;
      
     public function  __construct($tanggal,$dist_toko) {
                $this->dist_toko =  $dist_toko;
                $this->tanggal =  $tanggal;


        }


public function view(): View
    {
        return view('distribusitoko::distribusitokos.cabang.cetak.view_excel', [
            'dist_toko' => DistribusiToko::where('id',$this->dist_toko)->first()
        ]);
    }



    /**
     * @return string
     */
    public function title(): string
    {
        return 'EXPORT DISTRIBUSI TOKO | EMAS';
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

      // $sheet->getStyle('A8:E8')->applyFromArray([
      //       'font' => [
      //           'bold' => true,
      //       ],
      //        'fill' => [
      //                       'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
      //                       'startColor' => [
      //                           'rgb' => 'dff0d8',
      //                        ]           
      //        ],

         
      //   ]);

 
    // $sheet->getStyle('A6:E6')->applyFromArray([
    //         'font' => [
    //             'bold' => true,
    //         ],
    //          'fill' => [
    //                         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //                         'startColor' => [
    //                             'rgb' => 'fdfdfd',
    //                          ]           
    //          ],

         
    //     ]);






        // $sheet->getStyle('A4:AMJ4')->applyFromArray(array(
        //     'fill' => array(
        //         'color' => array('rgb' => 'FF0000')
        //     )
        // ));








    }








}


