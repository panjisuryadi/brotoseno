<?php

namespace Modules\KaratBerlian\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\KaratBerlian\Models\ShapeBerlian;
class ShapeSeederTableSeeder extends Seeder
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
                'id' => 1,
                'shape_name' => 'Round',
            ],
            [
                'id' => 2,
                'shape_name' => 'Princess',
            ],
            [
                'id' => 3,
                'shape_name' => 'Teardrop/Pear',
            ],
            [
                'id' => 4,
                'shape_name' => 'Marquise',
            ],
            [
                'id' => 5,
                'shape_name' => 'Heart',
            ],
            [
                'id' => 6,
                'shape_name' => 'Baguette',
            ],
            [
                'id' => 7,
                'shape_name' => 'Asscher',
            ],
            [
                'id' => 8,
                'shape_name' => 'Oval',
            ],
            [
                'id' => 9,
                'shape_name' => 'Trillion',
            ],
            [
                'id' => 10,
                'shape_name' => 'Emerald',
            ],
            [
                'id' => 11,
                'shape_name' => 'Cushion',
            ],
            [
                'id' => 12,
                'shape_name' => 'Radiant',
            ]
        ];

        ShapeBerlian::insert($data);

    }
}
