<?php

namespace App\Http\Livewire\ReturSale;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\ReturSale\Events\ReturSaleDetailCreated;
use Modules\ReturSale\Models\ReturSale;
use Modules\ReturSale\Models\ReturSaleDetail;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockSales;

class Create extends Component
{
    public $retur_sales = [
        'date' => '',
        'sales_id' => '',
        'retur_no' => '',
        'total_weight' => 0,
    ];

    public $retur_sales_detail = [
        [
            'karat_id' => '',
            'weight' => '',
            'nominal' => 0,
            'pure_gold' => ''
        ]
    ];

    public $dataSales = [];
    public $dataKarat = [];

    public $hari_ini;



    public function add()
    {
        $this->retur_sales_detail[] = [
            'karat_id' => '',
            'weight' => '',
            'nominal' => 0,
            'pure_gold' => ''
        ];
    }

    private function resetReturSales(){
        $this->retur_sales = [
            'date' => '',
            'sales_id' => '',
            'retur_no' => '',
            'total_weight' => 0,
        ];
    }
    private function resetReturSalesDetails(){
        $this->retur_sales_detail = [
            [
                'karat_id' => '',
                'weight' => '',
                'nominal' => 0,
                'pure_gold' => ''
            ]
        ];
    }

    public function updatedReturSalesSalesId(){
        $this->resetReturSalesDetails();
        $this->resetTotal();
        $this->resetErrorBag();
    }

    private function resetTotal(){
        $this->retur_sales['total_weight'] = 0;
    }

    public function render()
    {
        $karatIds = StockSales::query()
                        ->where('sales_id',$this->retur_sales['sales_id'])
                        ->where('weight','>',0)
                        ->pluck('karat_id')
                        ->toArray();
        $this->dataKarat = Karat::find($karatIds);
        return view('livewire.retur-sale.create',[
            'dataKarat' => $this->dataKarat
        ]);
    }

    public function mount()
    {
        $this->retur_sales['retur_no'] = $this->generateInvoice();
        $this->dataSales = DataSale::all();
        $this->hari_ini = (new DateTime())->format('Y-m-d');
        $this->retur_sales['date'] = $this->hari_ini;
    }

    private function generateInvoice()
    {
        $lastString = ReturSale::orderBy('id', 'desc')->value('retur_no');

        $numericPart = (int) substr($lastString, 11);
        $incrementedNumericPart = $numericPart + 1;
        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
        $nextString = "RETURSALES-" . $nextNumericPart;
        return $nextString;
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->retur_sales_detail[$key]);
        $this->retur_sales_detail = array_values($this->retur_sales_detail);
        $this->calculateTotalBerat();
    }


    public function rules()
    {
        $rules = [
            'retur_sales.retur_no' => 'required|string|max:50',
            'retur_sales.total_weight' => 'required',
            'retur_sales.sales_id' => 'required',
            'retur_sales.date' => [
                'required',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate < $today) {
                        $fail($attribute . ' harus tanggal hari ini atau setelahnya.');
                    }
                }
            ],

        ];

        foreach ($this->retur_sales_detail as $key => $value) {

            $rules['retur_sales_detail.'.$key.'.karat_id'] = 'required';
            $rules['retur_sales_detail.'.$key.'.weight'] = [
                'required',
                'gt:0',
                function ($attribute, $value, $fail) use ($key) {
                    // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_sales
                    $isSalesFilled = $this->retur_sales['sales_id'] != '';
                    if($isSalesFilled){
                        $maxWeight = DB::table('stock_sales')
                            ->where('karat_id', $this->retur_sales_detail[$key]['karat_id'])
                            ->where('sales_id', $this->retur_sales['sales_id'])
                            ->max('weight');
                        $total_input_weight_based_on_karat = $this->getTotalWeightBasedOnKarat($key,$this->retur_sales_detail[$key]['karat_id']);
                        if($total_input_weight_based_on_karat<$maxWeight){
                            $maxWeight = $maxWeight - $total_input_weight_based_on_karat;
                            if ($value > $maxWeight) {
                                $fail("Berat melebihi stok yang tersedia. Sisa Stok ($maxWeight).");
                            }
                        }else{
                            $fail("Stok telah habis digunakan");
                        }
                    }
    
                },
            
            ];
            $rules['retur_sales_detail.'.$key.'.nominal'] = 'gt:-1|max:100';
        }
        return $rules;
    }

    public function getTotalWeightBasedOnKarat($key,$karatId){
        $total = 0;
        foreach($this->retur_sales_detail as $index => $value){
            if($index == $key){
                continue;
            }
            if($this->retur_sales_detail[$index]['karat_id'] == $karatId){
                $total += floatval($this->retur_sales_detail[$index]['weight'])??0;
            }
        }
        return $total;
    }

    public function calculateTotalBerat()
    {
        $this->retur_sales['total_weight'] = 0;
        foreach ($this->retur_sales_detail as $key => $value) {
            $this->retur_sales['total_weight'] += floatval($this->retur_sales_detail[$key]['weight']);
            $this->retur_sales['total_weight'] = number_format(round($this->retur_sales['total_weight'], 3), 3, '.', '');
            $this->retur_sales['total_weight'] = rtrim($this->retur_sales['total_weight'], '0');
            $this->retur_sales['total_weight'] = formatWeight($this->retur_sales['total_weight']);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();
        DB::beginTransaction();
        try{
            // create retur sales
            $retur_sale = ReturSale::create([
                'sales_id' => $this->retur_sales['sales_id'],
                'date' => $this->retur_sales['date'],
                'retur_no' => $this->retur_sales['retur_no'],
                'total_weight' => $this->retur_sales['total_weight'],
                'created_by' => auth()->user()->name
            ]);
    
            foreach($this->retur_sales_detail as $key => $value) {
                $retur_sale_detail = $retur_sale->detail()->create([
                    'karat_id' => $this->retur_sales_detail[$key]['karat_id'],
                    'weight' => $this->retur_sales_detail[$key]['weight'],
                    'nominal' => !empty($this->retur_sales_detail[$key]['nominal'])?$this->retur_sales_detail[$key]['nominal']:null,
                    'pure_gold' => !empty($this->retur_sales_detail[$key]['pure_gold'])?$this->retur_sales_detail[$key]['pure_gold']:null,
                ]);
                $this->reduceStockSales($retur_sale_detail);
                $this->addStockOffice($retur_sale_detail);
            }

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        

        toast('Retur Sales Berhasil dibuat','success');
        return redirect(route('retursale.index'));
    }

    private function reduceStockSales($retur_sale_detail){
        $sales_id = $retur_sale_detail->retursales->sales_id;
        $stock_sales = StockSales::where([
            'karat_id' => $retur_sale_detail->karat_id,
            'sales_id' => $sales_id
        ])->firstOrFail();
        $retur_sale_detail->stock_sales()->attach($stock_sales->id,[
            'karat_id'=>$retur_sale_detail->karat_id,
            'sales_id' => $sales_id,
            'in' => false,
            'berat_real' => -1 * $retur_sale_detail->weight,
            'berat_kotor' => -1 * $retur_sale_detail->weight
        ]);
        $berat_real = $stock_sales->history->sum('berat_real');
        $stock_sales->update(['weight'=> $berat_real]);
    }

    private function addStockOffice($retur_sale_detail){
        $karat = Karat::findOrFail($retur_sale_detail->karat_id);
        $karat_id = (!empty($karat->parent_id))?$karat->parent_id:$retur_sale_detail->karat_id;
        $stock_office = StockOffice::firstOrCreate(['karat_id' => $karat_id]);
        $retur_sale_detail->stock_office()->attach($stock_office->id,[
            'karat_id'=>$karat_id,
            'in' => true,
            'berat_real' => $retur_sale_detail->weight,
            'berat_kotor' => $retur_sale_detail->weight
        ]);
        $berat_real = $stock_office->history->sum('berat_real');
        $berat_kotor = $stock_office->history->sum('berat_kotor');
        $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
    }

    public function clearWeight($key){
        $this->retur_sales_detail[$key]['weight'] = '';
    }

    protected function getUsedKaratIds(){
        $karatIds = [];
        foreach ($this->retur_sales_detail as $detail) {
            if (isset($detail['karat_id'])) {
                $karatIds[] = $detail['karat_id'];
            }
        }
        return $karatIds;
    }

    public function updateHarga(Karat $karat,$key){
        $this->retur_sales_detail[$key]['nominal'] = formatBerat($karat->harga);
    }

    public function weightUpdated($key){
        $this->calculateTotalBerat();
        $this->updateConverted($key);
    }

    public function hargaUpdated($key){
        $this->updateConverted($key);
    }

    public function updateConverted($key){
        if(!empty($this->retur_sales_detail[$key]['weight']) && !empty($this->retur_sales_detail[$key]['nominal'])){
            $this->retur_sales_detail[$key]['pure_gold'] = formatBerat($this->retur_sales_detail[$key]['weight'] * ($this->retur_sales_detail[$key]['nominal'] / 100));
        }
    }
}
