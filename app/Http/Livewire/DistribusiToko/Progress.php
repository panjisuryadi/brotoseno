<?php

namespace App\Http\Livewire\DistribusiToko;

use Livewire\Component;

class Progress extends Component
{
    public $dist_toko;

    public $dist_toko_items;

    public function mount()
    {
        $this->dist_toko_items = $this->dist_toko->items;
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }
    public function render()
    {
        return view('livewire.distribusi-toko.progress');
    }
}
