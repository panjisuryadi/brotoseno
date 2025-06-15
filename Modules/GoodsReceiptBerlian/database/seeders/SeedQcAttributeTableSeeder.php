<?php

namespace Modules\GoodsReceiptBerlian\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceiptBerlian\Models\QcAttribute;
use Carbon\Carbon;

class SeedQcAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $data = [
            [   
                'attribute_name'     => 'Carat',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Potongan',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Warna',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Clarity',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Polish',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Simetry',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Flourescence',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Table Percentage',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Dept Percentage',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Girdle Thickness',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'attribute_name'     => 'Culet Size',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ]

        ];

        foreach ($data as $row) {
            $data = QcAttribute::create($row);
        }
    }
}
