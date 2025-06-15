<?php

namespace App\Http\Livewire\PenjualanSale;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CustomerSales\Entities\CustomerSales;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\PenjualanSale\Events\PenjualanSaleDetailCreated;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\Stok\Models\PenerimaanLantakan;
use Modules\Stok\Models\PenjualanSalesPaymentDetail;
use Modules\Stok\Models\StockKroom;
use Modules\Stok\Models\StockRongsok;
use Modules\Stok\Models\StockSales;

class Create extends Component
{
    public $penjualan_sales = [
        'date' => '',
        'sales_id' => '',
        'invoice_no' => '',
        'store_name' => '',
        'total_weight' => 0,
        'total_nominal' => 0,
        'tipe_pembayaran' => '',
        'cicil' => '',
        'tgl_jatuh_tempo' => '',
        'konsumen_sales_id' => '',
        'total_jumlah' => 0
    ];

    public $penjualan_sales_details = [
        [
            'karat_id' => '',
            'sub_karat_id' => '',
            'weight' => 0,
            'harga' => 0,
            'type' => '',
            'nominal' => 0,
            'gold_price' => 0,
            'gold_type' => 0,
            'sub_karat_choice' => [],
            'harga_type' => 'persen',
            'jumlah' => 0
        ]
    ];

    public $dataSales = [];
    public $dataKarat = [];
    public $konsumenSales = [];
    public $cicil = '';
    public $tipe_pembayaran = '';
    public $detail_cicilan = [];
    public $tipe_setoran = '';
    public $isPersen = true;

    protected $listeners = [
        'beratChanged' => 'handleBeratChanged',
        'hargaChanged' => 'handleHargaChanged'
    ];

    public $hari_ini;

    public function add()
    {
        $this->penjualan_sales_details[] = [
            'karat_id' => '',
            'sub_karat_id' => '',
            'weight' => '',
            'nominal' => 0,
            'type' => '',
            'sub_karat_choice' => [],
            'harga_type' => $this->isPersen ? 'persen' : 'nominal',
            'jumlah' => 0,
        ];
        $this->setTotal();
    }

    private function resetPenjualanSales(){
        $this->penjualan_sales = [
            'date' => '',
            'sales_id' => '',
            'invoice_no' => '',
            'store_name' => '',
            'total_weight' => 0,
            'total_nominal' => 0,
            'total_jumlah' => 0
        ];
    }
    private function resetPenjualanSalesDetails(){
        $this->penjualan_sales_details = [
            [
                'karat_id' => '',
                'sub_karat_id' => '',
                'weight' => '',
                'nominal' => 0,
                'sub_karat_choice' => [],
                'harga_type' => 'persen',
                'jumlah' => 0
            ]
        ];
    }

    private function resetInputFields(){
        $this->resetPenjualanSales();
        $this->resetPenjualanSalesDetails();
    }

    private function resetTotal(){
        $this->penjualan_sales['total_weight'] = 0;
        $this->penjualan_sales['total_jumlah'] = 0;
    }

    public function render()
    {
        return view('livewire.penjualan-sale.create');
    }

    public function mount()
    {
        $this->dataSales = DataSale::all();
        $this->konsumenSales = CustomerSales::all();
        $sales_id = $this->penjualan_sales['sales_id'] ?? '';
        $this->dataKarat = Karat::where(function($query) use ($sales_id){
            $query
                ->whereHas('children', function($query) use ($sales_id){
                    $query->whereHas('stockSales', function ($query) use ($sales_id) {
                        $query->where('weight', '>',0);
                        $query->when($sales_id, function ($query) use($sales_id) {
                            return $query->where('sales_id', $sales_id);
                        });
                    });
                });
        })->get();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $this->penjualan_sales['date'] = $this->hari_ini;
        $this->penjualan_sales['invoice_no'] = PenjualanSale::generateCode();
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->penjualan_sales_details[$key]);
        $this->penjualan_sales_details = array_values($this->penjualan_sales_details);
        // $this->calculateTotalBerat();
        // $this->calculateTotalJumlah();
        $this->setTotal();
    }


    public function rules()
    {
        $rules = [
            'penjualan_sales.invoice_no' => 'required|string|max:50',
            'penjualan_sales.konsumen_sales_id' => 'required',
            'penjualan_sales.store_name' => 'string',
            'penjualan_sales.total_weight' => 'required',
            'penjualan_sales.sales_id' => 'required',
            'penjualan_sales.date' => 'required',
            // 'penjualan_sales.tipe_pembayaran' => 'required',
            // 'penjualan_sales.cicil' => 'required_if:penjualan_sales.tipe_pembayaran,cicil',
            // 'penjualan_sales.tgl_jatuh_tempo' => [
            //     'required_if:penjualan_sales.tipe_pembayaran,jatuh_tempo',
            //     function ($attribute, $value, $fail) {
            //         $today = Carbon::today();
            //         $inputDate = Carbon::parse($value);

            //         if ($inputDate < $today) {
            //             $fail($attribute . ' harus tanggal hari ini atau setelahnya.');
            //         }
            //     }
            // ],

        ];
        $stok_terpakai = 0;
        $stok_karat_terpakai = [];
        foreach ($this->penjualan_sales_details as $key => $value) {
            $karat_id = $this->penjualan_sales_details[$key]['karat_id'] ?? 0;
            $stok_terpakai = $stok_karat_terpakai[$karat_id] ?? 0;

            $rules['penjualan_sales_details.'.$key.'.karat_id'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.weight'] = 'required|gt:0';
            $rules['penjualan_sales_details.'.$key.'.harga'] = 'required_if:harga_type,==,persen|gt:0';
            $rules['penjualan_sales_details.'.$key.'.gold_price'] = 'required_if:harga_type,==,nominal|gt:0';
            // $rules['penjualan_sales_details.'.$key.'.sub_karat_id'] = 'required';
            // $rules['penjualan_sales_details.'.$key.'.type'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.weight'] = [
                function ($attribute, $value, $fail) use ($key, $stok_terpakai) {
                    // $type = !empty($this->penjualan_sales_details[$key]['type']) ? $this->penjualan_sales_details[$key]['type'] : '';
                    // if(!empty($type) && $type == 1 && empty($value)) {
                    //     $fail("Berat wajib diisi ketika pilih tipe setor emas");
                    // }

                    /** ini dikomen karena seharusnya yang jadi validasi adalah jumlah yang udah dikonversi jadi 24k*/
                    // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_sales
                    $isKaratFilled = $this->penjualan_sales_details[$key]['karat_id'] != '';
                    $isSalesFilled = $this->penjualan_sales['sales_id'] != '';
                    if($isKaratFilled && $isSalesFilled){
                        $maxWeight = DB::table('stock_sales')
                            ->where('karat_id', $this->penjualan_sales_details[$key]['karat_id'])
                            ->where('sales_id', $this->penjualan_sales['sales_id'])
                            ->max('weight');
                        if ($value > ($maxWeight-$stok_terpakai)) {
                            $fail("Berat melebihi stok yang tersedia. Jumlah Stok (".formatBerat($maxWeight-$stok_terpakai) . ")");
                        }

                    }
                },
            ];
            $rules['penjualan_sales_details.'.$key.'.nominal'] = 'required_if:harga_type,==nominal|gt:-1';
            $rules['penjualan_sales_details.'.$key.'.jumlah'] = [
                'required_if:harga_type,==persen',
                'gt:-1',
            ];
            $stok_terpakai += !empty($this->penjualan_sales_details[$key]['weight']) ? $this->penjualan_sales_details[$key]['weight'] : 0;
            $stok_karat_terpakai[$karat_id] = $stok_terpakai;


        }

        return $rules;
    }

    public function calculateTotalBerat()
    {
        $this->penjualan_sales['total_weight'] = 0;
        foreach ($this->penjualan_sales_details as $index => $value) {
            $this->penjualan_sales['total_weight'] += floatval($this->penjualan_sales_details[$index]['weight']);
            $this->penjualan_sales['total_weight'] = number_format(round($this->penjualan_sales['total_weight'], 3), 3, '.', '');
            $this->penjualan_sales['total_weight'] = rtrim($this->penjualan_sales['total_weight'], '0');
            $this->penjualan_sales['total_weight'] = formatWeight($this->penjualan_sales['total_weight']);
        }
    }

    public function calculateTotalNominal()
    {
        $this->penjualan_sales['total_nominal'] = 0;
        foreach ($this->penjualan_sales_details as $index => $value) {
            $this->penjualan_sales['total_nominal'] += floatval($this->penjualan_sales_details[$index]['nominal']??0);
            $this->penjualan_sales['total_nominal'] = number_format(round($this->penjualan_sales['total_nominal'], 3), 3, '.', '');
            $this->penjualan_sales['total_nominal'] = rtrim($this->penjualan_sales['total_nominal'], '0');
            $this->penjualan_sales['total_nominal'] = formatWeight($this->penjualan_sales['total_nominal']);
        }
    }

    public function calculateTotalJumlah()
    {
        $this->penjualan_sales['total_jumlah'] = 0;
        if($this->hasSameHargaType()){
            foreach ($this->penjualan_sales_details as $index => $value) {
                $this->penjualan_sales['total_jumlah'] += floatval($this->penjualan_sales_details[$index]['jumlah']??0);
                $this->penjualan_sales['total_jumlah'] = $this->formatJumlah($this->penjualan_sales['total_jumlah']);
            }
        }
    }

    public function formatJumlah($item){
       $item = number_format(round($item, 3), 3, '.', '');
       $item = rtrim($item, '0');
       $item = formatWeight($item);
       return $item;
    }

    private function hasSameHargaType(){
        $harga_type_values = array_map(function($item) {
            return $item['harga_type'];
        }, $this->penjualan_sales_details);

        return !(in_array('persen', $harga_type_values) && in_array('nominal', $harga_type_values));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();
        // create penjualan sales

        DB::beginTransaction();
        try{
            $penjualan_sale = PenjualanSale::create([
                'sales_id' => $this->penjualan_sales['sales_id'],
                'date' => $this->penjualan_sales['date'],
                'invoice_no' => $this->penjualan_sales['invoice_no'],
                'total_weight' => $this->penjualan_sales['total_weight'],
                'konsumen_sales_id' => $this->penjualan_sales['konsumen_sales_id'],
                'total_jumlah' => $this->penjualan_sales['total_jumlah'],
                'total_nominal' => $this->penjualan_sales['total_nominal'],
                'harga_type' => $this->isPersen ? 'persen' : 'nominal',
                'created_by' => auth()->user()->name
            ]);
    
            $penjualan_sale_payment = $penjualan_sale->payment()->create([
                'tipe_pembayaran' => $this->penjualan_sales['tipe_pembayaran'],
                'jatuh_tempo'     => $this->penjualan_sales['tgl_jatuh_tempo'] ? $this->penjualan_sales['tgl_jatuh_tempo'] : null,
                'cicil'           => $this->penjualan_sales['cicil'] ? $this->penjualan_sales['cicil']:  0,
                'lunas'           => $this->penjualan_sales['tipe_pembayaran'] == 'lunas' ? 'lunas': null,
            ]);

            foreach($this->penjualan_sales_details as $key => $value) {
                $data = [
                    'karat_id' => $this->penjualan_sales_details[$key]['karat_id'],
                    'weight' => !empty($this->penjualan_sales_details[$key]['weight']) ? $this->penjualan_sales_details[$key]['weight'] : 0,
                    'nominal' => $this->penjualan_sales_details[$key]['nominal']??0,
                    'created_by' => auth()->user()->name,
                    'harga_type' => $this->penjualan_sales_details[$key]['harga_type'],
                    // 'type' => $this->penjualan_sales_details[$key]['type'],
                    'gold_type' => !empty($this->penjualan_sales_details[$key]['gold_type']) ? $this->penjualan_sales_details[$key]['gold_type'] : null,
                    'harga' => !empty($this->penjualan_sales_details[$key]['harga']) ? $this->penjualan_sales_details[$key]['harga'] : null,
                    'gold_price' => !empty($this->penjualan_sales_details[$key]['gold_price']) ? $this->penjualan_sales_details[$key]['gold_price'] : null,
                    'jumlah' => $this->penjualan_sales_details[$key]['jumlah']
                ];
                $penjualan_sale_detail = $penjualan_sale->detail()->create($data);
                // if(!empty($this->penjualan_sales_details[$key]['gold_type']) && $this->penjualan_sales_details[$key]['gold_type'] == 'lantakan') {
                //     $this->createLantakan($penjualan_sale_detail);
                // }
                // if(!empty($this->penjualan_sales_details[$key]['gold_type']) && $this->penjualan_sales_details[$key]['gold_type'] == 'rongsok') {
                //     $this->createRongsok($penjualan_sale_detail);
                // }
                $this->reduceStockSales($penjualan_sale_detail);
            }
            if(!empty($this->detail_cicilan)){
                if($this->penjualan_sales['tipe_pembayaran'] == 'cicil'){
                    foreach($this->detail_cicilan as $key => $value){
                        PenjualanSalesPaymentDetail::create([
                            'payment_id' => $penjualan_sale_payment->id,
                            'nomor_cicilan' => $key,
                            'tanggal_cicilan' => $this->detail_cicilan[$key]
                        ]);
                    }
                }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        $this->resetTotal();
        toast('Created Successfully','success');
        return redirect(route('penjualansale.index'));
    }

    /**
     * This function is deprecated
     */
    private function createLantakan($penjualan_sale_detail) {
        if($penjualan_sale_detail->karat_id) {
            
            $stok_lantakan = StockKroom::first();
            if($stok_lantakan) {
                $penjualan_sale_detail->stock_kroom()->attach($stok_lantakan->id,[
                    'karat_id'=> $stok_lantakan->karat_id,
                    'in' => true,
                    'berat_real' => $penjualan_sale_detail->weight,
                    'berat_kotor' => $penjualan_sale_detail->weight
                ]);

                $stok_lantakan->weight += $penjualan_sale_detail->weight;
                $stok_lantakan->save();
            }
        }
    }


    /**
     * This function is deprecated
     */
    private function createRongsok($penjualan_sale_detail) {
        if(!empty($penjualan_sale_detail->karat_id)) {
            $stock_rongsok = StockRongsok::firstOrCreate(['karat_id' => $penjualan_sale_detail->karat_id]);
            $penjualan_sale_detail->stock_rongsok()->attach($stock_rongsok->id,[
                    'karat_id'=>$penjualan_sale_detail->karat_id,
                    'sales_id' => $penjualan_sale_detail->penjualanSale->sales_id,
                    'weight' => $penjualan_sale_detail->weight,
            ]);
            $stok_rongsok = StockRongsok::where('karat_id', $penjualan_sale_detail->karat_id)->first();
            $stok_rongsok->weight += $penjualan_sale_detail->weight;
            $stok_rongsok->save();
        }
    }


    /**
     * This function is deprecated
     */
    private function reduceStockSales($penjualan_sale_detail){
        $sales_id = $penjualan_sale_detail->penjualanSale->sales_id;
        $stock_sales = StockSales::where([
            'karat_id' => $penjualan_sale_detail->karat_id,
            'sales_id' => $sales_id
        ])->firstOrFail();
        $penjualan_sale_detail->stock_sales()->attach($stock_sales->id,[
            'karat_id'=>$penjualan_sale_detail->karat_id,
            'sales_id' => $sales_id,
            'in' => false,
            'berat_real' => -1 * $penjualan_sale_detail->weight,
            'berat_kotor' => -1 * $penjualan_sale_detail->weight
        ]);
        // $berat_real = $stock_sales->history->sum('berat_real');
        // $stock_sales->update(['weight'=> $berat_real]);
        $stock_sales->weight -= $penjualan_sale_detail->weight;
        $stock_sales->save();
    }


    /**
     * This function is deprecated
     */
    public function updateKaratList(){
        // $this->dataKarat = Karat::where(function($query){
        //     $query
        //         ->where('parent_id',null)
        //         ->whereHas('children', function($query){
        //             $query->whereHas('stockSales', function ($query) {
        //                 $query->where('weight', '>',0);
        //                 $query->where('sales_id', $this->penjualan_sales['sales_id']);
        //             });
        //         });
        // })->get();
        
        $this->dataKarat = Karat::where(function($query){
            $query->whereHas('stockSales', function ($query) {
                    $query->where('weight', '>',0);
                    $query->where('sales_id', $this->penjualan_sales['sales_id']);
                });
        })->get();
        $this->resetPenjualanSalesDetails();
        $this->resetTotal();
        $this->resetDataSubKarat();
    }


    /**
     * This function is deprecated
     */
    public function clearWeight($key){
        $this->penjualan_sales_details[$key]['weight'] = '';
    }

    /**
     * This function is deprecated
     */
    public function changeParentKarat($key){
        $this->clearWeight($key);
        $karat = Karat::find($this->penjualan_sales_details[$key]['karat_id']);
        if(is_null($karat)){
            $this->penjualan_sales_details[$key]['sub_karat_choice'] = [];
        }else{
            $this->penjualan_sales_details[$key]['sub_karat_choice'] = 
            $karat->children()->whereHas('stockSales', fn ($query) => $query->where('weight','>',0)->where('sales_id', $this->penjualan_sales['sales_id']))->whereNotIn('id',$this->getUsedSubKaratIds())->get();
        }
    }

    /**
     * This function is deprecated
     */
    protected function resetDataSubKarat(){
        foreach ($this->penjualan_sales_details as $detail) {
            $detail['sub_karat_choice'] = [];
        }
    }

    protected function getUsedSubKaratIds(){
        $subKaratIds = [];
        foreach ($this->penjualan_sales_details as $detail) {
            if (isset($detail['sub_karat_id'])) {
                $subKaratIds[] = $detail['sub_karat_id'];
            }
        }
        return $subKaratIds;
    }

    public function updateMarketName(){
        $this->penjualan_sales['store_name'] = CustomerSales::find($this->penjualan_sales['konsumen_sales_id'])?->market;
    }

    public function clearHarga($key){
        $this->penjualan_sales_details[$key]['nominal'] = 0;
        $this->isPersen = $this->penjualan_sales_details[$key]['harga_type'] == 'persen' ? true : false;
        foreach($this->penjualan_sales_details as $k => $row) {
            /**
             * reset semua fields selain field yang ngereset
             */
            if($k != $key) {
                unset($this->penjualan_sales_details[$k]);
            }
        }
        $this->setTotal();
        // $this->calculateHarga($key);
        // $this->calculateTotalJumlah();
    }

    public function calculateHarga($key){
        $this->penjualan_sales_details[$key]['jumlah'] = $this->formatJumlah(floatval($this->penjualan_sales_details[$key]['weight']) * floatval($this->penjualan_sales_details[$key]['nominal']));
    }

    public function handleBeratChanged($key){
        $this->calculateHarga($key);
        $this->calculateTotalBerat();
        $this->calculateTotalJumlah();
    }

    public function handleHargaChanged($key){
        $this->calculateHarga($key);
        $this->calculateTotalJumlah();
    }

    /** Kanggo ngeset konversi emas
     * params $key => key of details
     */
    public function setJumlah($k) { 
        if(!empty($this->penjualan_sales_details[$k])) {
            $data = $this->penjualan_sales_details[$k];
            $nominal = !empty($data['nominal']) ? $data['nominal'] : 0;
            $gold_price = !empty($data['gold_price']) ? $data['gold_price'] : 0;
            $type = !empty($data['type']) ? $data['type'] : 0;
            if($type == 1) { 
                $this->penjualan_sales_details[$k]['jumlah'] = $nominal / $gold_price; 
            }
            $this->setTotal();
        }
    }

    public function setTotal(){
        $total_nominal = 0;
        $total_jumlah = 0;
        foreach ($this->penjualan_sales_details as $index => $value) {
            $total_nominal += !empty($value['nominal']) ? $value['nominal'] : 0;
            $total_jumlah += !empty($value['jumlah']) ? $value['jumlah'] : 0;
        }
        $this->penjualan_sales['total_jumlah'] = $total_jumlah;
        $this->penjualan_sales['total_nominal'] = $total_nominal;
    }

    public function setKonversiBerat($k) {
        $data = !empty($this->penjualan_sales_details[$k]) ? $this->penjualan_sales_details[$k] : [];
        if(!empty($data['weight']) && !empty($data['harga'])){
            $jumlah = $data['weight'] * ($data['harga']/100);
            $this->penjualan_sales_details[$k]['jumlah'] = $jumlah;
            $this->setTotal();
        }
    }

    public function clearNominal($k){
        $this->penjualan_sales_details[$k]['gold_price'] = 0;
        $this->penjualan_sales_details[$k]['jumlah'] = 0;
        $this->setTotal();
    }

    public function getMinCicilDate($key){
        if(in_array($key-1,array_keys($this->detail_cicilan))){
            $minCicilDate = new DateTime($this->detail_cicilan[$key-1]);
            return $minCicilDate->modify("+1 day")->format("Y-m-d");
        }else{
            return $this->hari_ini;
        }
    }

    public function resetDetailCicilanAfterwards($key){
        for ($i=$key+1; $i <= count($this->detail_cicilan) ; $i++) { 
            $this->detail_cicilan[$i] = "";
        }
    }

    public function setNominal($key) {
        $berat = $this->penjualan_sales_details[$key]['weight'] ?? 0;
        $gold_price = $this->penjualan_sales_details[$key]['gold_price'] ?? 0;
        if(!empty($berat) && !empty($gold_price)) {
            $nominal = $berat * $gold_price;
            $this->penjualan_sales_details[$key]['nominal'] = $nominal;
        }
        $this->setTotal();
    }

    // public function setTipeSetoran() {
    //     if(!empty($this->penjualan_sales_details)) {
    //         foreach($this->penjualan_sales_details as $key => $row) {
    //             $this->penjualan_sales_details[$key]['type'] = $this->tipe_setoran;
    //         }
    //     }
    //     if($this->tipe_setoran == 2) {
    //         $this->penjualan_sales['tipe_pembayaran'] = 'lunas';
    //     }
    // }
}
