<?php

namespace App\Http\Livewire\Locations;

use Modules\Locations\Entities\Locations;

use Livewire\Component;

class getlocation extends Component
{
     public $main,$parent, $locations;

     public $parent_id = 0;
     public $sub_location = 0;


    public function mount(){
          $this->main = Locations::where('parent_id',null)->orderby('name','asc')
                             ->select('*')
                             ->get();
       }

     public function getParentlocations(){
          $this->locations = Locations::orderby('name','asc')
                          ->select('*')
                          ->where('parent_id',$this->parent_id)
                          ->get();

          // Reset value
          $this->sub_location = 0;
     }

    public function render()
    {
        return view('livewire.locations.getlocation');
    }


}