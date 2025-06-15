<?php

namespace App\Http\Livewire\StockOpname\PendingOffice;

use App\View\Components\toasr;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockPendingOffice;

class Create extends Component
{
    public $active_location;

    protected $listeners = [
        'save'
     ];

     public $adjustment_items = [];

     public $selected_items = [];

     public $note;
     public $date;
     public $reference;

     public function mount(){
        $this->date = new DateTime();
        $this->date = $this->date->format('Y-m-d');
        $this->reference = $this->getReference();
     }

     private function getReference()
    {
        $lastString = Adjustment::orderBy('id', 'desc')->value('reference');

        $numericPart = (int) substr($lastString, 4);

        $incrementedNumericPart = $numericPart + 1;

        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);

        $nextString = "ADJ-" . $nextNumericPart;

        return $nextString;
    }

     public function save($data){
        if(in_array($data['id'],$this->selected_items)){
            $this->emit('alreadySelected');
        }else{
            $this->selected_items[] = $data['id'];
            $this->adjustment_items[] = [
                "stock_pending_office_id" => $data['id'],
                "product_name" => $data['product_name'],
                "current_stock" => $data['current_stock'],
                "new_stock" => $data['new_stock']
            ];
        }
     }
    public function render(){
        return view('livewire.stock-opname.pending-office.create');
    }

    public function remove($index){
        unset($this->selected_items[$index]);
        unset($this->adjustment_items[$index]);
    }

    public function store(){
        DB::beginTransaction();
        try{
            $adjustment = Adjustment::create([
                'date' => $this->date,
                'reference' => $this->reference,
                'note' => $this->note
            ]);
            foreach($this->adjustment_items as $item){
                $adjustment->stockPendingOffice()->attach($item['stock_pending_office_id'],[
                    'weight_before'=>$item['current_stock'],
                    'weight_after' =>$item['new_stock']
                ]);
                StockPendingOffice::findOrFail($item['stock_pending_office_id'])->update(['weight'=>$item['new_stock']]);
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        AdjustmentSetting::stop();
        session()->flash('Stock Opname berhasil');
        return redirect()->route('adjustments.index');
    }

    
}
