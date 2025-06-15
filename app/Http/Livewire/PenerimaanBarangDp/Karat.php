<?php

namespace App\Http\Livewire\PenerimaanBarangDp;

use Livewire\Component;
use Modules\Karat\Models\Karat as ModelsKarat;

class Karat extends Component {
    
    public $kadar = '';
    public $kode;
    public $berat;
    public $allKarat = [];

    public function mount(){
        $this->allKarat = ModelsKarat::all();
    }

    public function render()
    {
        return view('livewire.penerimaan-barang-dp.karat');
    }

    public function updateKarat(){
        $this->kode = ModelsKarat::find($this->kadar)->kode;
    }
}