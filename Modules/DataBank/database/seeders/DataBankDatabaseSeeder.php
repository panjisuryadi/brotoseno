<?php

namespace Modules\DataBank\database\seeders;
//use Modules\DataBank\database\seeders\DataBankDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DataBank\Models\DataBank;
use Carbon\Carbon;
class DataBankDatabaseSeeder extends Seeder
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
         * DataBanks Seed
         * ------------------
         */

        // DB::table('databanks')->truncate();
        // echo "Truncate: databanks \n";

        //  $data = [
        //     [
        //         'id'                 => 1,
        //         'name'               => 'Inclusive',
        //         'description'        => 'Diamond - Inclusive',
        //         'created_at'         => Carbon::now(),
        //         'updated_at'         => Carbon::now(),
        //     ],

        // ];

        //     foreach ($data as $row) {
        //         $data = DataBank::create($row);

        //     }


        DataBank::factory()->count(20)->create();
        $rows = DataBank::all();
        echo " Insert: databanks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
