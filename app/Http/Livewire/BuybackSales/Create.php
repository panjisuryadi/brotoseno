<?php

namespace App\Http\Livewire\BuybackSales;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\BuyBackSale\Models\BuyBackSale;
use Modules\CustomerSales\Entities\CustomerSales;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockRongsok;

class Create extends Component
{
    public BuyBackSale $buyback_sales;
    public $hari_ini;
    public $karats = [];
    public $customerSales = [];
    public $dataSales = [];

    public function render()
    {
        return view('livewire.buyback-sales.create');
    }

    public function __construct()
    {
        $this->buyback_sales = new BuyBackSale();
    }

    public function rules(){
        return [
            'buyback_sales.no_buy_back' => [
                'required'
            ],
            'buyback_sales.date' => ['required', 'date',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);
                    if ($inputDate > $today) {
                        $fail($attribute . ' harus tanggal hari ini atau sebelumnya.');
                    }
                }
            ],
            'buyback_sales.customer_sales_id' => ['required'],
            'buyback_sales.sales_id' => ['required'],
            'buyback_sales.product_name' => ['required'],
            'buyback_sales.weight' => ['required'],
            'buyback_sales.karat_id' => ['required'],
            'buyback_sales.nominal' => ['required','gt:0'],
            'buyback_sales.note' => [''],
        ];
    }

    public function mount(){
        $this->buyback_sales->no_buy_back = $this->generateInvoice();
        $this->hari_ini = (new DateTime())->format('Y-m-d');
        $this->buyback_sales->date = $this->hari_ini;
        $this->karats = Karat::karat()->get();
        $this->customerSales = CustomerSales::all();
        $this->dataSales = DataSale::all();
    }

    private function generateInvoice(){
        $lastString = BuyBackSale::orderBy('id', 'desc')->value('no_buy_back');

        $numericPart = (int) substr($lastString, 13);
        $incrementedNumericPart = $numericPart + 1;
        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
        $nextString = "BUYBACK-SALE-" . $nextNumericPart;
        return $nextString;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $this->buyback_sales->pic_id = auth()->id();
            $this->buyback_sales->save();
            $this->addStockRongsok($this->buyback_sales);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->reset();
        session()->flash('message', 'Berhasil disimpan.');
        return redirect(route('buybacksale.index'));

    }

    public function getNominalTextProperty()
    {
        return 'Rp. ' . number_format((intval($this->buyback_sales->nominal)), 0, ',', '.');
    }

    private function addStockRongsok($buyback_sales){
        $karat = Karat::find($buyback_sales->karat_id);
        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
        $stock_rongsok = StockRongsok::firstOrCreate(['karat_id' => $karat_id]);
        $buyback_sales->stock_rongsok()->attach($stock_rongsok->id,[
                'karat_id'=>$karat_id,
                'sales_id' => $buyback_sales->sales_id,
                'weight' => $buyback_sales->weight,
        ]);
        $weight = $stock_rongsok->history->sum('weight');
        $stock_rongsok->update(['weight'=> $weight]);
    }
}
