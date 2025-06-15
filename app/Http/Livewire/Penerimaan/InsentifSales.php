<?php

namespace App\Http\Livewire\Penerimaan;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\PenerimaanBarangLuarSale\Models\PenerimaanBarangLuarSale;
use Modules\Cabang\Models\Cabang;
use Modules\DataSale\Models\DataSale;
use Modules\Status\Models\ProsesStatus;
use Livewire\Component;

class InsentifSales extends Component
{

   public $datasales;
   public $listsales;
   public $detailsales;
   public $id_sales = 0;
   public $data_sales = 0;
   public $selectedBulan = NULL;
   
    public function mount()
    {
        
        $this->datasales = collect();
    }

    public function render()
    {
        return view('livewire.penerimaan.insentif-sales');
    }


    public function getIdSales()
    {

        if (!is_null($this->id_sales)) {
            $this->detailsales = DataSale::where('id', $this->id_sales)->first();
        }
    } 

     public function getDataSales(){
          $this->listsales = DataSale::orderby('name','asc')
                          ->select('*')
                          ->where('id',$this->id_sales)
                          ->get();
          $this->data_sales = 0;
     }


}
