<?php

namespace Modules\DiamondCertificate\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DiamondCertificate\Models\DiamondCertificate;
use Carbon\Carbon;
class DiamondCertificateDatabaseSeeder extends Seeder
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
         * DiamondCertificates Seed
         * ------------------
         */

        // DB::table('diamondcertificates')->truncate();
        // echo "Truncate: diamondcertificates \n";

        $data = [
            [
                'id'                 => 1,
                'name'               => 'Inclusive',
                'description'        => 'Diamond - Inclusive',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],[
                'id'                 => 2,
                'name'               => 'Exlusive',
                'description'        => 'Diamond - Exlusive',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],

            ];

            foreach ($data as $row) {
                $data = DiamondCertificate::create($row);

            }


        // DiamondCertificate::factory()->count(20)->create();
        // $rows = DiamondCertificate::all();
        echo " Insert: diamondcertificates \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
