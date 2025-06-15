<?php

namespace Modules\Karat\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Karat\Models\Karat;
use Carbon\Carbon;
class KaratDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Karats Seed
         * ------------------
         */

         DB::table('karats')->truncate();
        // echo "Truncate: karats \n";
        $data = [
            [
                'id'                 => 1,
                'name'               => 'Emas 18K',
                'description'        => 'kadar emas 75 persen',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'id'                 => 2,
                'name'               => 'Emas 21K',
                'description'        => 'kadar emas 87 persen',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ], [
                'id'                 => 3,
                'name'               => 'Emas 22K',
                'description'        => 'kadar emas 91 persen',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ], [
                'id'                 => 4,
                'name'               => 'Emas 23K',
                'description'        => 'kadar emas 95 persen',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
            [
                'id'                 => 5,
                'name'               => 'Emas 24K',
                'description'        => 'kadar emas 99 persen',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],

        ];

            foreach ($data as $row) {
                $data = Karat::create($row);

            }


        // Karat::factory()->count(20)->create();
        // $rows = Karat::all();
        echo " Insert: karats \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
