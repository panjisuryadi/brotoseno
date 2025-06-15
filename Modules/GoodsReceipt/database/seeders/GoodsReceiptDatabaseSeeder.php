<?php

namespace Modules\GoodsReceipt\database\seeders;
//use Modules\GoodsReceipt\database\seeders\GoodsReceiptDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Carbon\Carbon;
class GoodsReceiptDatabaseSeeder extends Seeder
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
         * GoodsReceipts Seed
         * ------------------
         */

        // DB::table('goodsreceipts')->truncate();
        // echo "Truncate: goodsreceipts \n";

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
        //         $data = GoodsReceipt::create($row);

        //     }


        GoodsReceipt::factory()->count(20)->create();
        $rows = GoodsReceipt::all();
        echo " Insert: goodsreceipts \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
