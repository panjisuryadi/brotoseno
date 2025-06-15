<?php

namespace Modules\Company\database\seeders;
//use Modules\Company\database\seeders\CompanyDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Company\Models\Company;
use Carbon\Carbon;
class CompanyDatabaseSeeder extends Seeder
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
         * Companies Seed
         * ------------------
         */

        // DB::table('companies')->truncate();
        // echo "Truncate: companies \n";

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
        //         $data = Company::create($row);

        //     }


        Company::factory()->count(20)->create();
        $rows = Company::all();
        echo " Insert: companies \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
