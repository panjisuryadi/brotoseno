<?php

namespace App\Http\Livewire\ReturPembelian;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockSales;
//modul baru Retur pembelian
use Modules\People\Entities\Supplier;
use Modules\ReturPembelian\Models\ReturPembelian;


class Create extends Component
{
    public $retur_sales = [
        'date' => '',
        'supplier_id' => '',
        'retur_no' => '',
        'total_weight' => 0,
    ];

    public $retur_sales_detail = [
        [
            'karat_id' => '',
            'weight' => '',
            'harga' => 0,
            'pure_gold' => ''
        ]
    ];

    public $dataSupplier = [];
    public $dataSales = [];
    public $dataKarat = [];

    public $hari_ini;



    public function add()
    {
        $this->retur_sales_detail[] = [
            'karat_id' => '',
            'weight' => '',
            'harga' => 0,
            'pure_gold' => ''
        ];
    }

    private function resetReturSales(){
        $this->retur_sales = [
            'date' => '',
            'supplier_id' => '',
            'retur_no' => '',
            'total_weight' => 0,
        ];
    }
    private function resetReturSalesDetails(){
        $this->retur_sales_detail = [
            [
                'karat_id' => '',
                'weight' => '',
                'harga' => 0,
                'pure_gold' => ''
            ]
        ];
    }

    private function resetTotal(){
        $this->retur_sales['total_weight'] = 0;
    }

    public function render()
    {
        $this->dataKarat = Karat::get()->all();

        return view('livewire.retur-pembelian.create',[
            'dataKarat' => $this->dataKarat
        ]);
    }

    public function mount()
    {
        $this->retur_sales['retur_no'] = ReturPembelian::generateCode();
        $this->dataSupplier = Supplier::all();
        $this->dataSales = DataSale::all();
        $this->hari_ini = (new DateTime())->format('Y-m-d');
        $this->retur_sales['date'] = $this->hari_ini;
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
            'retur_sales.supplier_id' => 'required',
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
                    if(!empty($this->retur_sales_detail[$key]['karat_id'])){
                        $maxWeight = DB::table('stock_office')
                            ->where('karat_id', $this->retur_sales_detail[$key]['karat_id'])
                            ->sum('berat_real');
                        $total_input_weight_based_on_karat = $this->getTotalWeightBasedOnKarat($key,$this->retur_sales_detail[$key]['karat_id']);
                        if($total_input_weight_based_on_karat<$maxWeight){
                            $maxWeight = $maxWeight - $total_input_weight_based_on_karat;
                            if ($value > $maxWeight) {
                                $fail("Berat melebihi stok yang tersedia. Sisa Stok ($maxWeight).");
                            }
                        }else{
                            $fail("Stok telah habis digunakan $maxWeight");
                        }
                    }else{
                        $fail("Karat belum diisi!");
                    }
    
                },
            
            ];
            $rules['retur_sales_detail.'.$key.'.harga'] = 'gt:-1|max:100';
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
            $retur_sale = ReturPembelian::create([
                'date' => $this->retur_sales['date'],
                'retur_no' => $this->retur_sales['retur_no'],
                'supplier_id' => $this->retur_sales['supplier_id'],
                'total_weight' => $this->retur_sales['total_weight'],
                'created_by' => auth()->user()->name
            ]);
    
            foreach($this->retur_sales_detail as $key => $value) {
                $retur = $retur_sale->detail()->create([
                    'karat_id' => $this->retur_sales_detail[$key]['karat_id'],
                    'weight' => $this->retur_sales_detail[$key]['weight'],
                    'harga' => !empty($this->retur_sales_detail[$key]['harga'])?$this->retur_sales_detail[$key]['harga']:null,
                    'pure_gold' => !empty($this->retur_sales_detail[$key]['pure_gold'])?$this->retur_sales_detail[$key]['pure_gold']:null,
                ]);
                $this->reduceStockOffice($retur);
            }

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        

        toast('Retur Sales Berhasil dibuat','success');
        return redirect(route('returpembelian.index'));
    }


    private function reduceStockOffice($retur){
        $karat = Karat::findOrFail($retur->karat_id);
        $karat_id = (!empty($karat->parent_id))?$karat->parent_id:$retur->karat_id;
        $stock_office = StockOffice::firstOrCreate(['karat_id' => $karat_id]);
        $retur->stock_office()->attach($stock_office->id,[
            'karat_id'=>$karat_id,
            'in' => true,
            'berat_real' => -1 * $retur->weight,
            'berat_kotor' => -1 * $retur->weight
        ]);
        
        $stock_office->berat_real -= $retur->weight;
        $stock_office->berat_kotor -= $retur->weight;
        $stock_office->save();
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
        $this->retur_sales_detail[$key]['harga'] = formatBerat($karat->harga);
    }

    public function weightUpdated($key){
        $this->calculateTotalBerat();
        $this->updateConverted($key);
    }

    public function hargaUpdated($key){
        $this->updateConverted($key);
    }

    public function updateConverted($key){
        if(!empty($this->retur_sales_detail[$key]['weight']) && !empty($this->retur_sales_detail[$key]['harga'])){
            $this->retur_sales_detail[$key]['pure_gold'] = formatBerat($this->retur_sales_detail[$key]['weight'] * ($this->retur_sales_detail[$key]['harga'] / 100));
        }
    }
}
