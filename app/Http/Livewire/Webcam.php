<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Webcam extends Component
{
    public $key;
    public $isCameraActive = false;

    public function render()
    {
        return view('livewire.webcam');
    }

    public function configure($key){
        $this->isCameraActive = true;
        $this->emit('configureCamera',$key);
    }

    public function takeSnapshot($key){
        $this->isCameraActive = false;
        $this->emit('takeSnapshot',$key);
    }

    public function resetSnapshot($key){
        $this->isCameraActive = false;
        $this->emit('removePrev',$key);
    }
}
