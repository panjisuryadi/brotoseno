<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\Nota;

use App\Models\LookUp;
use App\Models\TrackingStatus;
use DateTime;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\BuysBack\Models\BuyBackNota;
use Modules\BuysBack\Models\BuyBackNotaStatus;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockCabang;

use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar\GoodsReceiptItem;
use Modules\Product\Models\ProductStatus;

class Confirm extends Component
{
    public GoodsReceiptItem $item;
    public $nota;

    public $nota_items;

    public function __construct()
    {
        $this->item = new GoodsReceiptItem();
    }

    public function render()
    {
        return view("livewire.goods-receipt.toko.nota.confirm");
    }

    public function nominalText($value){
        return 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    public $selectedItems = [];

    public $selectAll = false;

    public $note = '';

    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public function handleSelectAllItem($selectedItems){
        $this->selectedItems = $selectedItems;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function updatedSelectedItems(){
        if(count($this->selectedItems) == count($this->nota_items)){
            $this->selectAll = true;
        }else{
            $this->selectAll = false;
        }
    }

    public function mount()
    {
        $this->nota_items = $this->nota->items;
    }

    public function updatedItemNilaiTafsir($value){
        if($this->item->nilai_tafsir != ''){
            $this->item->nilai_selisih = intval($this->item->nilai_tafsir) - $this->item->nominal;
        }else{
            $this->item->nilai_selisih = 0;
        }
    }

    public function rules()
    {
        $rules = [
            'note' => 'required_if:selectAll,false'
        ];
        $rules['item.nilai_tafsir'] = '';
        $rules['item.nilai_selisih'] = '';

        return $rules;
    }

    public function messages(){
        return [
            'note.required_if' => 'Wajib di isi',
        ];
    }

    public function proses()
    {
        $emptyTafsir = $this->nota_items
                        ->whereIn('id',$this->selectedItems)
                        ->where('type',2)
                        ->whereNull('nilai_tafsir')->first();
        if(!empty($emptyTafsir)){
            $this->dispatchBrowserEvent('barang-luar:empty-tafsir',[
                'message' => 'Nilai Tafsir Produk ' . $emptyTafsir->product->product_code . ' Belum ditentukan!'
            ]);
        }else{
            $this->dispatchBrowserEvent('approve:modal');
        }
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }

    public function submit(){
        $this->validate();
        DB::beginTransaction();
        try{
            $this->nota->updateTracking(TrackingStatus::APPROVED,null);
            $this->nota->updateTracking(TrackingStatus::COMPLETED,null);
            foreach($this->nota_items as $item){
                $product = $item->product;
                if(in_array($item->id, $this->selectedItems)){
                    $item->approve();
                    $product->updateTracking(ProductStatus::PENDING_OFFICE);
                }else{
                    $item->reject();
                    $product->updateTracking(ProductStatus::HILANG);
                }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        toast('Penerimaan Barang Berhasil dilakukan','success');
        return redirect(route('goodsreceipt.toko.buyback-barangluar.index'));
    }

    public function editTafsir(GoodsReceiptItem $item){
        $this->item = $item;
        $this->dispatchBrowserEvent('edit-tafsir:modal');
    }

    public function updateNilaiTafsir(){
        $this->validate([
            'item.nilai_tafsir' => 'required',
        ]);
        try{
            $this->item->save();
            DB::commit();
            $this->reset('item');
            $this->dispatchBrowserEvent('barang-luar:updated',[
                'message' => 'Nilai Tafsir Berhasil di Update'
            ]);
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
    }

}
