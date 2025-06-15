<?php

namespace App\Http\Livewire\Product;

use DateTime;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Modules\DataSale\Models\DataSale;
use Modules\DistribusiSale\Events\DistribusiSaleDetailCreated;
use Modules\DistribusiSale\Models\DistribusiSale;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockSales;

class Sales extends Component
{
    use WithFileUploads;

    public $distribusi_sales = [
        'date' => '',
        'sales_id' => '',
        'invoice_no' => '',
        'total_weight' => 0,
    ];

    public $distribusi_sales_details = [
        [
            'karat_id' => '',
            'sub_karat_id' => '',
            'kode' => '',
            'berat_bersih' => '',
            'harga' => '',
            'sub_karat_choice' => [],
            'pure_gold' => ''
        ]
    ];


    public $dataSales = [];
    public $dataKarat = [];


    public function add()
    {
        $this->distribusi_sales_details[] = [
            'karat_id' => '',
            'sub_karat_id' => '',
            'kode' => '',
            'berat_bersih' => '',
            'harga' => '',
            'sub_karat_choice' => [],
            'pure_gold' => ''
        ];
    }

    private function resetDistribusiSales()
    {
        $this->distribusi_sales = [
            'date' => '',
            'sales_id' => '',
            'invoice_no' => '',
            'total_weight' => 0,
        ];
    }
    private function resetDistribusiSalesDetails()
    {
        $this->distribusi_sales_details = [
            [
                'karat_id' => '',
                'sub_karat_id' => '',
                'kode' => '',
                'berat_bersih' => '',
                'harga' => '',
                'sub_karat_choice' => [],
                'pure_gold' => ''
            ]
        ];
    }

    private function resetInputFields()
    {
        $this->resetDistribusiSales();
        $this->resetDistribusiSalesDetails();
    }

    private function resetTotal()
    {
        $this->distribusi_sales['total_weight'] = 0;
    }


    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->distribusi_sales_details[$key]);
        $this->distribusi_sales_details = array_values($this->distribusi_sales_details);
        $this->calculateTotalBerat();
    }


    public function rules()
    {
        $rules = [
            'distribusi_sales.invoice_no' => 'required|string|max:50',
            'distribusi_sales.total_weight' => 'required',
            'distribusi_sales.sales_id' => 'required',
            'distribusi_sales.date' => 'required',
        ];

        foreach ($this->distribusi_sales_details as $key => $value) {

            $rules['distribusi_sales_details.'.$key.'.karat_id'] = 'required';
            $rules['distribusi_sales_details.'.$key.'.sub_karat_id'] = 'required_if:'.'distribusi_sales_details.'.$key.'.karat_id,';
            $rules['distribusi_sales_details.'.$key.'.berat_bersih'] = [
                'required',
                'gt:0',
                function ($attribute, $value, $fail) use ($key) {
                    // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_office berdasarkan nilai parent id nya
                        $maxWeight = DB::table('stock_office')
                            ->where('karat_id', $this->distribusi_sales_details[$key]['karat_id'])
                            ->max('berat_real');
                        $total_input_weight_based_on_karat = $this->getTotalWeightBasedOnKarat($key,$this->distribusi_sales_details[$key]['karat_id']);
                        if($total_input_weight_based_on_karat<$maxWeight){
                            $maxWeight = $maxWeight - $total_input_weight_based_on_karat;
                            if ($value > $maxWeight) {
                                $fail("Berat melebihi stok yang tersedia. Sisa Stok ($maxWeight).");
                            }
                        }else{
                            $fail("Stok telah habis digunakan");
                        }
    
                },

            ];
            $rules['distribusi_sales_details.'.$key.'.harga'] = 'gt:-1|max:100';

        }
        return $rules;
    }

    public function calculateTotalBerat()
    {
        $this->distribusi_sales['total_weight'] = 0;
        foreach ($this->distribusi_sales_details as $key => $value) {
            $this->distribusi_sales['total_weight'] += floatval($this->distribusi_sales_details[$key]['berat_bersih']);
            $this->distribusi_sales['total_weight'] = number_format(round($this->distribusi_sales['total_weight'], 3), 3, '.', '');
            $this->distribusi_sales['total_weight'] = rtrim($this->distribusi_sales['total_weight'], '0');
            $this->distribusi_sales['total_weight'] = formatWeight($this->distribusi_sales['total_weight']);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.product.sales');
    }

    public function mount()
    {
        $this->distribusi_sales['invoice_no'] = $this->generateInvoice();
        $this->distribusi_sales['date'] = (new DateTime())->format('Y-m-d');  
        $this->dataSales = DataSale::all();
        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null)
                ->whereHas('stockOffice', function ($query) {
                    $query->where('berat_real', '>', 0);
                });
        })->get();
    }

    private function generateInvoice()
    {
        $lastString = DistribusiSale::orderBy('id', 'desc')->value('invoice_no');

        $numericPart = (int) substr($lastString, 10);
        $incrementedNumericPart = $numericPart + 1;
        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
        $nextString = "DISTSALES-" . $nextNumericPart;
        return $nextString;
    }

    public function store()
    {
        $this->validate();
        // create distribusi sales
        DB::beginTransaction();
        try{
            $dist_sale = DistribusiSale::create([
                'sales_id' => $this->distribusi_sales['sales_id'],
                'date' => $this->distribusi_sales['date'],
                'invoice_no' => $this->distribusi_sales['invoice_no'],
                'created_by' => auth()->user()->name
            ]);
    
            foreach($this->distribusi_sales_details as $key => $value) {
                $dist_sale_detail = $dist_sale->detail()->create([
                    'karat_id' => !empty($this->distribusi_sales_details[$key]['sub_karat_id'])?$this->distribusi_sales_details[$key]['sub_karat_id']:$this->distribusi_sales_details[$key]['karat_id'],
                    'berat_bersih' => $this->distribusi_sales_details[$key]['berat_bersih'],
                    'harga' => floatval($this->distribusi_sales_details[$key]['harga'])??0,
                    'pure_gold' => !empty($this->distribusi_sales_details[$key]['pure_gold'])?$this->distribusi_sales_details[$key]['pure_gold']:null,
                ]);
                $this->reduceStockOffice($dist_sale_detail);
                $this->addStockSales($dist_sale_detail);
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        $this->resetTotal();
        toast('Created Successfully','success');
        return redirect(route('distribusisale.index'));
    }

    private function reduceStockOffice($dist_sale_detail){
        $karat = Karat::findOrFail($dist_sale_detail->karat_id);
        $karat_id = (!empty($karat->parent_id))?$karat->parent_id:$dist_sale_detail->karat_id;
        $stock_office = StockOffice::where(['karat_id' => $karat_id])->firstOrFail();
        $dist_sale_detail->stock_office()->attach($stock_office->id,[
            'karat_id'=>$karat_id,
            'in' => false,
            'berat_real' => -1 * $dist_sale_detail->berat_bersih,
            'berat_kotor' => -1 * $dist_sale_detail->berat_bersih
        ]);
        $berat_real = $stock_office->history->sum('berat_real');
        $berat_kotor = $stock_office->history->sum('berat_kotor');
        $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
    }

    private function addStockSales($dist_sale_detail){
        $sales_id = $dist_sale_detail->distribusi_sales->sales_id;
        $stock_sales = StockSales::firstOrCreate([
            'karat_id' => $dist_sale_detail->karat_id,
            'sales_id' => $sales_id
        ]);
        $dist_sale_detail->stock_sales()->attach($stock_sales->id,[
            'karat_id'=>$dist_sale_detail->karat_id,
            'sales_id' => $sales_id,
            'in' => true,
            'berat_real' => $dist_sale_detail->berat_bersih,
            'berat_kotor' => $dist_sale_detail->berat_bersih
        ]);
        $berat_real = $stock_sales->history->sum('berat_real');
        $stock_sales->update(['weight'=> $berat_real]);
    }


    public function clearWeight($key){
        $this->distribusi_sales_details[$key]['berat_bersih'] = '';
    }

    public function changeParentKarat($key){
        $this->clearWeight($key);
        $karat = Karat::find($this->distribusi_sales_details[$key]['karat_id']);
        if(is_null($karat)){
            $this->distribusi_sales_details[$key]['sub_karat_choice'] = [];
        }else{
            $this->distribusi_sales_details[$key]['sub_karat_choice'] = $karat->children()->whereNotIn('id',$this->getUsedSubKaratIds())->get();
        }
        $this->distribusi_sales_details[$key]['sub_karat_id'] = '';

        $this->updateCode($karat,$key);
    }

    public function updateCode(Karat $karat,$key){
        $this->distribusi_sales_details[$key]['code'] = $karat->kode;
    }

    public function updateHarga(Karat $karat,$key){
        $this->distribusi_sales_details[$key]['harga'] = formatBerat($karat->harga);
    }

    public function updateCodeHarga(Karat $karat, $key){
        $this->updateCode($karat, $key);
        $this->updateHarga($karat, $key);
    }

    protected function getUsedSubKaratIds(){
        $subKaratIds = [];
        foreach ($this->distribusi_sales_details as $detail) {
            if (isset($detail['sub_karat_id'])) {
                $subKaratIds[] = $detail['sub_karat_id'];
            }
        }
        return $subKaratIds;
    }

    public function getTotalWeightBasedOnKarat($key,$karatId){
        $total = 0;
        foreach($this->distribusi_sales_details as $index => $value){
            if($index == $key){
                continue;
            }
            if($this->distribusi_sales_details[$index]['karat_id'] == $karatId){
                $total += floatval($this->distribusi_sales_details[$index]['berat_bersih'])??0;
            }
        }
        return $total;
    }

    public function weightUpdated($key){
        $this->calculateTotalBerat();
        $this->updateConverted($key);
    }

    public function hargaUpdated($key){
        $this->updateConverted($key);
    }

    public function updateConverted($key){
        if(!empty($this->distribusi_sales_details[$key]['berat_bersih']) && !empty($this->distribusi_sales_details[$key]['harga'])){
            $this->distribusi_sales_details[$key]['pure_gold'] = formatBerat($this->distribusi_sales_details[$key]['berat_bersih'] * ($this->distribusi_sales_details[$key]['harga'] / 100));
        }
    }
}
