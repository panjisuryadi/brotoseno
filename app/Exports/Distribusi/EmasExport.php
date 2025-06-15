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
use Modules\DistribusiToko\Models\DistribusiToko;
class EmasExport implements FromQuery, WithTitle, withMapping, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{



/**
     * @return Builder
     */
    public function query()
    {

        return DistribusiToko::gold()
                 ->orderBy('id', 'desc');  

        }

    /**
     * @var Order $sale
     */
    public function map($sale): array
    {

        return [
            [
                tanggal($sale->date),
                $sale->no_invoice,
                $sale->cabang->name,
                $sale->current_status->name,

            ],
        ];
    }



    /**
     * @return string
     */
    public function title(): string
    {
        return 'EXPORT DISTRIBUSI TOKO | EMAS';
    }


public function headings(): array
    {
        return [
           ['EXPORT  DISTRIBUSI TOKO | EMAS'],
          [
            'TANGGAL',
            'INVOICE',
            'CABANG',
            'STATUS',

        ],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:E1');
              
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
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'E55353',
                ],
                'endColor' => [
                    'argb' => 'E55353',
                ],
            ],
        ]);



    }








}


