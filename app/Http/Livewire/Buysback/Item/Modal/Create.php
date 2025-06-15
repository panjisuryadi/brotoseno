<?php

namespace App\Http\Livewire\Buysback\Item\Modal;

use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class Create extends Component
{
    public $code;
    public $date;
    public $product;
    public $nominal_text = '';

    public $customer_id = '';
    public $customers;
    public $nominal = 0;

    public $note = '';
    public function mount() {
        $this->date = (new DateTime())->format('Y-m-d');
        $this->customers = Customer::all();
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $product = Product::where(['product_code' => $value])->first();
                    if(is_null($product)){
                        $fail('Produk tidak ditemukan');
                    }else{
                        $is_exist = BuyBackItem::where('product_id',$product->id)->exists();
                        if($is_exist){
                            $fail('Produk yang sama telah ditambahkan');
                        }else{
                            if($product->status == 0){
                                $fail('Produk belum terjual');
                            }
                        }
                    }
                }
            ],
            'customer_id' => 'required',
            'date' => 'required',
            'nominal' => 'required|gt:0'
        ];
    }

    public function render() {
        return view('livewire.buysback.item.modal.create', [
            'product' => $this->product
        ]);
    }

    public function findProduct(){
        $this->validateOnly('code');
        $this->setProduct();
    }

    private function setProduct(){
        $this->product = Product::with('karat')->where(['product_code' => $this->code])->first();
    }

    public function store(){
        $this->validate();

        DB::beginTransaction();
        try{
            $data = [
                'product_id' => $this->product->id,
                'cabang_id' => auth()->user()->namacabang()->id,
                'customer_id' => $this->customer_id,
                'status_id' => ProsesStatus::STATUS['PENDING'],
                'karat_id' => $this->product->karat_id,
                'pic_id' => auth()->id(),
                'nominal' => $this->nominal,
                'note' => empty($this->note)?null:$this->note,
                'weight' => $this->product->berat_emas,
                'date' => $this->date
            ];

            $item = BuyBackItem::create($data);
            $this->addStockPending($item);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Berhasil Menyimpan Barang Buy Back','success');
        return redirect(route('buysback.index'));
        
    }

    public function updatedNominal($value){
        $this->nominal_text = 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    private function addStockPending($item){
        $stock_pending = StockPending::firstOrCreate(
            ['karat_id' => $item->karat_id, 'cabang_id' => $item->cabang_id]
        );
        $item->stock_pending()->attach($stock_pending->id,[
            'karat_id'=>$item->karat_id,
            'cabang_id' => $item->cabang_id,
            'in' => true,
            'berat_real' =>$item->weight,
            'berat_kotor' => $item->weight
        ]);
        $berat_real = $stock_pending->history->sum('berat_real');
        $berat_kotor = $stock_pending->history->sum('berat_kotor');
        $stock_pending->update(['weight'=> $berat_real]);
    }

}
