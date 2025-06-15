<?php

namespace App\Http\Livewire\GoodsReceiptBerlian;

use Livewire\Component;

class Webcam extends Component
{
    public $image;
    public $isCameraActive = false;

    public function render()
    {
        return view('livewire.goods-receipt-berlian.webcam', ['image'=> $this->image]);
    }

    public function configure(){
        $this->isCameraActive = true;
        $this->emit('configureCamera');
    }

    public function takeSnapshot(){
        $this->isCameraActive = false;
        $this->emit('takeSnapshot');
    }

    public function resetSnapshot(){
        $this->isCameraActive = false;
        $this->emit('removePrev');
    }
}
