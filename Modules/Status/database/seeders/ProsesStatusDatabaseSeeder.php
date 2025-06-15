<?php

namespace Modules\Status\database\seeders;
//use Modules\Status\database\seeders\StatusDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Status\Models\ProsesStatus;
use Carbon\Carbon;
class ProsesStatusDatabaseSeeder extends Seeder
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

        ProsesStatus::create(['id' => 1,'name' => 'cuci']);
        ProsesStatus::create(['id' => 2,'name' => 'masak']);
        ProsesStatus::create(['id' => 3,'name' => 'rongsok']);
        ProsesStatus::create(['id' => 4,'name' => 'second']);
        ProsesStatus::create(['id' => 5,'name' => 'pending gudang']);

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
