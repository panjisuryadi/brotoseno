<?php

namespace App\Http\Livewire\Buysback\Nota;

use App\Models\LookUp;
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

class Create extends Component
{
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
        if(count($this->selectedItems) == count($this->buyback_items)){
            $this->selectAll = true;
        }else{
            $this->selectAll = false;
        }
    }


    public function render()
    {
        return view("livewire.buysback.nota.create");
    }

    public function mount()
    {
        $this->cabang = auth()->user()->namacabang();
        $this->invoice_series = $this->cabang->code;
        $this->generateInvoice();
        $this->today = (new DateTime())->format('Y-m-d');
        $this->date = $this->today;
        $this->buyback_items = BuyBackItem::where([
            'buyback_nota_id' => null,
            'status_id'=> ProsesStatus::STATUS['PENDING']
        ])->get();
        $this->buyback_items->load(['product','karat','customer']);
    }

    private function generateInvoice(){
        $this->invoice_number = (BuyBackNota::where('invoice_series', $this->invoice_series)->max('invoice_number') ?? 0) + 1;
        $this->invoice = 'BUYBACK-'. $this->invoice_series . '-' . str_pad($this->invoice_number, 5, '0', STR_PAD_LEFT);
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
                'status_id' => BuyBackNotaStatus::STATUS['CREATED'],
                'kategori_produk_id' => LookUp::where('kode','id_kategori_produk_emas')->value('value'),
                'pic_id' => auth()->id(),
                'invoice_number' => $this->invoice_number,
                'invoice_series' => $this->invoice_series,
                'invoice' => $this->invoice,
                'date' => $this->date,
                'note' => empty($this->note)?null:$this->note
            ];
            $buyback_nota = BuyBackNota::create($data);
            $buyback_nota->send();
            $this->attachBuyBackItems($buyback_nota, $this->selectedItems);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        toast('BuyBack Nota Berhasil dibuat','success');
        return redirect(route('buysback.index'));
    }

    private function attachBuyBackItems($buyback_nota, $selectedItems){
        foreach($this->buyback_items as $item){
            if(in_array($item->id, $selectedItems)){
                $item->update([
                    'buyback_nota_id' => $buyback_nota->id,
                    'status_id' => null
                ]);
                $item->reduceStockPending();
            }
        }
    }

    
}
