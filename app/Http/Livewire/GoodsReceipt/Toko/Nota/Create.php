<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\Nota;

use App\Models\LookUp;
use App\Models\TrackingStatus;
use DateTime;
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
use Modules\Product\Models\ProductStatus;

class Create extends Component
{
    public $goodsreceipt_items;
    public $today;
    public $cabang;
    public $date;
    public $invoice;
    public $invoice_number;
    public $invoice_series;

    public $buyback_items;

    public $dist_toko;

    public $dist_toko_items;

    public $selectedItems = [];

    public $selectAll = false;

    public $note = '';

    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public $id_kategoriproduk_berlian;

    public function handleSelectAllItem($selectedItems){
        $this->selectedItems = $selectedItems;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function updatedSelectedItems(){
        if(count($this->selectedItems) == count($this->goodsreceipt_items)){
            $this->selectAll = true;
        }else{
            $this->selectAll = false;
        }
    }


    public function render()
    {
        return view("livewire.goods-receipt.toko.nota.create");
    }

    public function mount()
    {
        $this->cabang = auth()->user()->namacabang();
        $this->invoice_series = $this->cabang->code;
        $this->generateInvoice();
        $this->today = (new DateTime())->format('Y-m-d');
        $this->date = $this->today;
        $this->goodsreceipt_items = BuyBackBarangLuar\GoodsReceiptItem::pending()->with('product')->where('goodsreceipt_toko_nota_id',null)->get();
        $this->goodsreceipt_items->load(['product']);
    }

    private function generateInvoice(){
        $this->invoice_number = (BuyBackBarangLuar\GoodsReceiptNota::where('invoice_series', $this->invoice_series)->max('invoice_number') ?? 0) + 1;
        $this->invoice = 'GOODRECEIPT-'. $this->invoice_series . '-' . str_pad($this->invoice_number, 5, '0', STR_PAD_LEFT);
    }

    public function nominalText($value){
        return 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    public function messages(){
        return [
            'note.required_if' => 'Wajib di isi',
        ];
    }

    public function proses()
    {
        if(count($this->selectedItems) == 0){
            $this->dispatchBrowserEvent('items:not-selected',[
                'message' => 'Pilih Barang Terlebih Dahulu'
            ]);
        }else{
            $this->dispatchBrowserEvent('summary:modal');
        }
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }

    public function send(){
        DB::beginTransaction();
        try{
            $data = [
                'cabang_id' => $this->cabang->id,
                'status_id' => TrackingStatus::CREATED,
                'kategori_produk_id' => LookUp::where('kode','id_kategori_produk_emas')->value('value'),
                'pic_id' => auth()->id(),
                'invoice_number' => $this->invoice_number,
                'invoice_series' => $this->invoice_series,
                'invoice' => $this->invoice,
                'date' => $this->date,
                'note' => empty($this->note)?null:$this->note
            ];
            $goodsreceipt_nota = BuyBackBarangLuar\GoodsReceiptNota::create($data);
            $goodsreceipt_nota->send();
            $this->attachItems($goodsreceipt_nota, $this->selectedItems);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        toast('Nota Pengiriman Berhasil dibuat','success');
        return redirect(route('stok.pending'));
    }

    private function attachItems($goodsreceipt_nota, $selectedItems){
        foreach($this->goodsreceipt_items as $item){
            if(in_array($item->id, $selectedItems)){
                $item->update([
                    'goodsreceipt_toko_nota_id' => $goodsreceipt_nota->id,
                ]);
                $item->product->updateTracking(ProductStatus::OTW);
            }
        }
    }


}
