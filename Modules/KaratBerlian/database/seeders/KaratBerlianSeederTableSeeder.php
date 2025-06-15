<?php

namespace Modules\KaratBerlian\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\KaratBerlian\Models\KaratBerlian;

class KaratBerlianSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        $data = 
        $data = [
            [
                'karat' => 0.02,
                'size' => 1.7 ,
            ],
            [
                'karat' => 0.03,
                'size' => 2.0 ,
            ],
            [
                'karat' => 0.04,
                'size' => 2.2 ,
            ],
            [
                'karat' => 0.05,
                'size' =>  2.4,
            ],
            [
                'karat' => 0.10,
                'size' =>  3.0,
            ],
            [
                'karat' => 0.15,
                'size' =>  3.4,
            ],
            [
                'karat' => 0.20,
                'size' =>  3.8,
            ],
            [
                'karat' => 0.25,
                'size' =>  4.1,
            ],
            [
                'karat' => 0.33,
                'size' =>  4.4,
            ],
            [
                'karat' => 0.50,
                'size' =>  5.0,
            ],
            [
                'karat' => 0.60,
                'size' =>  5.3,
            ],
            [
                'karat' => 0.75,
                'size' =>  5.7,
            ],
            [
                'karat' => 0.90,
                'size' =>  6.2,
            ],
            [
                'karat' => 1.00,
                'size' =>  6.4,
            ],
            [
                'karat' => 1.25,
                'size' =>  6.9,
            ],
            [
                'karat' => 1.50,
                'size' =>  7.3,
            ],
            [
                'karat' => 1.75,
                'size' =>  7.7,
            ],
            [
                'karat' => 2.00,
                'size' =>  8.1,
            ],
            [
                'karat' => 2.25,
                'size' =>  8.5,
            ],
            [
                'karat' => 2.50,
                'size' =>  8.8,
            ],
            [
                'karat' => 2.75,
                'size' =>  9.1,
            ],
            [
                'karat' => 3.00,
                'size' =>  9.4,
            ],
            [
                'karat' => 3.50,
                'size' =>  10.00,
            ],
            [
                'karat' => 4.00,
                'size' =>  10.4,
            ],
            [
                'karat' => 4.50,
                'size' =>  10.8,
            ],
            [
                'karat' => 5.00,
                'size' =>  11.0,
            ],
            [
                'karat' => 5.50,
                'size' =>  11.3,
            ],
            [
                'karat' => 6.00,
                'size' =>  11.7,
            ],
            [
                'karat' => 7.00,
                'size' =>  12.4,
            ]
        ];

        KaratBerlian::insert($data);
    }
}
