<?php

namespace Modules\GoodsReceipt\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceipt\Models\KlasifikasiBerlian;

class KlasifikasiBerlianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $data = [
            [ 'name' => '0.0003 - 0.0008'],
            [ 'name' => '0.01 - 0.02'],
            [ 'name' => '0.025 - 0.07'],
            [ 'name' => '0.08 - 0.12'],
            [ 'name' => '0.125 - 0.17'],
            [ 'name' => '0.18 - 0.22'],
            [ 'name' => '0.23 - 0.27'],
        ];
        KlasifikasiBerlian::insert($data);
    }
}
