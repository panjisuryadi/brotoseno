<?php

namespace Modules\Produksi\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\DiamondCertificate\Models\DiamondCertificate;
use Modules\Produksi\Models\DiamondCertificateAttributes;

class DiamondCertificateAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Jewelry Type'],
            [ 'name' => 'Metal Type'],
            [ 'name' => 'Metal Weight'],
            [ 'name' => 'Carat Weight'],
            [ 'name' => 'Clarity Grade'],
            [ 'name' => 'Colour Grade'],
            [ 'name' => 'Shape and cutting style'],
            [ 'name' => 'Measurement'],
            [ 'name' => 'Carat weight'],
            [ 'name' => 'Color grade'],
            [ 'name' => 'Cut grade'],
            [ 'name' => 'Polish'],
            [ 'name' => 'Symmentry'],
            [ 'name' => 'Fluroesence'],
            [ 'name' => 'Clarity charateristic'],
            [ 'name' => 'Proportion'],
            [ 'name' => 'Depth'],
            [ 'name' => 'Table diameter'],
            [ 'name' => 'Crown height'],
            [ 'name' => 'Pavilion depth'],
            [ 'name' => 'Gindle thikness']
        ];
        DiamondCertificateAttributes::insert($data);
    }
}
