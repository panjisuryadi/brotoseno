<?php

namespace App\Http\Livewire\Penerimaan;

use Livewire\Component;

class Insentif extends Component
{

    public $post;
 
   
    public function render()
    {
        return view('livewire.penerimaan.insentif');
    }


     public function like()
    {
        $this->post;
    }


}
