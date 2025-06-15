<?php

namespace App\Http\Livewire\Stoks;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Show extends Component
{
    public $details;
    public $selected_status_id;
    public $product_status = [];
    public $selectAll = false;
    public $selectedItems = [];
    public $totalWeight = 0;
    public $weightTarget;

    public function updatedWeightTarget($value)
    {
        $targetWeight = floatval($value);
        $currentWeight = 0;
        $this->selectedItems = [];

        foreach ($this->details as $detail) {
            if ($currentWeight + $detail->berat_emas <= $targetWeight) {
                $this->selectedItems[] = $detail->id;
                $currentWeight += $detail->berat_emas;
            } else {
                break;
            }
        }
        $this->calculateTotalWeight();
    }

    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public function handleSelectAllItem($value){
        $this->selectedItems = $value;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function updatedSelectedItems()
    {
        $this->calculateTotalWeight();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->details->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
        $this->calculateTotalWeight();
    }

    protected function calculateTotalWeight()
    {
        $this->totalWeight = $this->details->whereIn('id', $this->selectedItems)
            ->sum('berat_emas');
    }

    public function amount($details)
    {
        $this->$details = $details;
    }
    public function render()
    {
        $this->product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
        ]);
        return view('livewire.stoks.show');
    }

    public function proses()
    {
        if(count($this->selectedItems) == 0){
            $this->dispatchBrowserEvent('items:not-selected',[
                'message' => 'Pilih Barang Terlebih Dahulu'
            ]);
        }else{
            $this->dispatchBrowserEvent('confirm:modal');
        }
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            foreach ($this->selectedItems as $productId) {
                $product = Product::findOrFail($productId);

                $product->status_id = $this->selected_status_id;
                $product->save();
            }

            DB::commit();
            toast('Status Berhasil Diupdate','success');
            return redirect(route('stok.pending_office'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('updateError', $e->getMessage());
        }
    }
}
