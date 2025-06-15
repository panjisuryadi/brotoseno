<?php

namespace App\Http\Livewire;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\User;
class CariSales extends Component
{

     public $showdiv = false;
     public $search = "";
     public $records;
     public $search_results;
     public $salesDetails;
     public $showresult;



 public function mount() {
        $this->search = '';
       // $this->how_many = 5;
        $this->search_results = Collection::empty();
    }





     // Fetch records
     public function searchResult(){

         if(!empty($this->search)){

             $this->records = User::orderby('name','asc')
                       ->select('*')
                       ->where('name','like','%'.$this->search.'%')
                       ->orWhere('kode_user','like','%'.$this->search.'%')
                       ->limit(5)
                       ->get();
             $this->showdiv = true;
         }else{
             $this->showdiv = false;
         }
     }

     // Fetch record by ID
     public function fetchSalesDetail($id = 0){
         $record = User::select('*')
                     ->where('id',$id)
                     ->first();
         $this->search = $record->name;
         $this->salesDetails = $record;
         $this->showdiv = false;
     }
   public function resetQuery() {
        $this->search = '';
       // $this->how_many = 5;
        $this->search_results = Collection::empty();
        $this->showdiv = false;
    }
     public function render(){ 
         return view('livewire.cari-sales');
     }


}

