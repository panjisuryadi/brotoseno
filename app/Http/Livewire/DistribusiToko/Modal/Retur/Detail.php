<?php

namespace App\Http\Livewire\DistribusiToko\Modal\Retur;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\Stok\Models\StockOffice;

class Detail extends Component
{
    public $dist_toko;
    public $data = [
        'additional_data' => [
            'product_category' => [
                'id' => '',
                'name' => ''
            ],
            'group' => [
                'id' => '',
                'name' => ''
            ],
            'model' => [
                'id' => '',
                'name' => ''
            ],
            'code' => '',
            'certificate_id' => '',
            'no_certificate' => '',
            'accessories_weight' => 0,
            'tag_weight' => 0,
            'image' => ''
        ],
        'gold_weight' => 0,
        'total_weight' => 0,
        'karat_id' => ''
    ];


    public function render(){
        return view("livewire.distribusi-toko.modal.retur.detail");
    }

    protected $listeners = [
        'setData',
    ];

    public function setData($data){
        $this->data = $data;
        $this->data["additional_data"] = json_decode($data['additional_data'],true)['product_information'];
    }

   

    public function mount(){
        
    }
}
