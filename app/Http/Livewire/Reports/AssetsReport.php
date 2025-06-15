<?php

namespace App\Http\Livewire\Reports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Reports\Models\AssetReports;
use Modules\Sale\Entities\Sale;
use Modules\Stok\Models\StockKroom;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockRongsok;

class AssetsReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $start_date;
    public $end_date;
    public $date;
    public $periode_type = '';
    public $month = '';
    public $year = '';

    public $stock_office = [];
    public $stock_office_array = [];

    public $stock_office_lantakan = [];
    public $stock_office_lantakan_array = [];

    public $stock_office_rongsok = [];
    public $stock_office_rongsok_array = [];

    public $stock_office_pending;
    public $stock_office_pending_array = [];

    public $stock_office_ready;
    public $stock_office_ready_array = [];

    public $stock_cabang = [];
    public $stock_cabang_coef = [];
    public $stock_cabang_24 = [];
    public $stock_cabang_array = [];

    public $status_cabang = [
        ProductStatus::PENDING_CABANG,
        ProductStatus::READY,
        ProductStatus::DP,
    ];

    public $assets_report;
    public $view = 'livewire.reports.assets';
    public $is_report = false;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    protected $listeners = ['resetReport' => 'resetReport'];

    public function mount() {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');

        //** Blok untuk insert data baru per bulan */

        $this->getDataAssets();
        $this->getProductQueries();
        $this->setArrayForProductBase();
        
        // Generate default coef
        $this->generate_default_coef();
        $date = Carbon::now();
        $this->date = $date;
    }

    public function getDataAssets() {

        // Stok Office Gudang bahan baku
        $this->stock_office = StockOffice::all();
        $this->stock_office_array = $this->stock_office->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Lantakan Gudang bahan baku
        $this->stock_office_lantakan = StockKroom::get();
        $this->stock_office_lantakan_array = $this->stock_office_lantakan->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Rongsok Gudang bahan baku
        $this->stock_office_rongsok = StockRongsok::get();
        $this->stock_office_rongsok_array = $this->stock_office_rongsok->map(function($data){
                    return $data;
                })
                ->flatten()
                ->keyBy('karat_id')
                ->toArray();
        
    }

    public function getProductQueries(){

        // Stok Pending Office berupa product
        $this->stock_office_pending = Product::pendingOffice()
                                        ->select(
                                            DB::raw('sum(berat_emas) as berat_real'), 
                                            'products.karat_id',
                                        )
                                        ->groupBy('karat_id')->get();
        
        // Stok Ready Office berupa product
        $this->stock_office_ready = Product::readyOffice()
                                        ->select(
                                            DB::raw('sum(berat_emas) as berat_real'), 
                                            'products.karat_id',
                                        )
                                        ->groupBy('karat_id')->get();

        // Stok Ready Cabang berupa product
        $this->stock_cabang = Product::with('cabang', 'current_status')
                                    ->select(
                                        'berat_emas as berat_real', 
                                        'karat_id',
                                        'status_id',
                                        'cabang_id',
                                    )
                                    ->whereNotNull('cabang_id')
                                    ->whereIn('status_id', $this->status_cabang)->get();
    }

    public function setArrayForProductBase() {

        // Stok Pending Office berupa product
        $this->stock_office_pending_array = $this->stock_office_pending->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Ready Office berupa product
        $this->stock_office_ready_array = $this->stock_office_ready->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();

    }

    public function render() {
        $date = $this->date;
        $month = !empty($this->month) ? date('m', strtotime($this->month)) : $date->month;
        $year = !empty($this->year) ? date('Y', strtotime($this->month)) : $date->year;
        $datas = [];
        $this->assets_report = AssetReports::with('karat')
                            ->when($month, function ($query) use ($month) {
                                return $query->whereMonth('date', $month);
                            })
                            ->when($year, function ($query) use ($year) {
                                return $query->whereYear('date', $year);
                            })->get();
        $this->setIsReport();

        if(!$this->is_report) {
            $this->getProductQueries();
            $this->generate_array_stok_cabang();
        }else{
            $datas = $this->generateDataReport();
            $this->view = 'livewire.reports.assets-report';

        }

        return view($this->view, compact('datas'));
    } 

    public function generateReport() {
        $this->validate();
        $this->render();
        $this->is_report = true;
    }

    public function generate_default_coef(){
        if(!empty($this->stock_office)){
            foreach($this->stock_office as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_array[$item->karat_id]['pure_gold'] = $item->berat_real * ($coef/100); 
                $this->stock_office_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_lantakan)){
            foreach($this->stock_office_lantakan as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_lantakan_array[$item->karat_id]['pure_gold'] = $item->weight * ($coef/100); 
                $this->stock_office_lantakan_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_rongsok)){
            foreach($this->stock_office_rongsok as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_rongsok_array[$item->karat_id]['pure_gold'] = $item->weight * ($coef/100); 
                $this->stock_office_rongsok_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_pending)){
            foreach($this->stock_office_pending as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_pending_array[$item->karat_id]['pure_gold'] = $item->berat_real * ($coef/100); 
                $this->stock_office_pending_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_ready)){
            foreach($this->stock_office_ready as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_ready_array[$item->karat_id]['pure_gold'] = $item->berat_real * ($coef/100); 
                $this->stock_office_ready_array[$item->karat_id]['coef'] = $coef;
            }
        }

        $this->generate_coef_cabang();
        
    }

    public function generate_coef_cabang() {

        if(!empty($this->stock_cabang)){
            foreach($this->stock_cabang as $item){
                $berat_real = ($this->stock_cabang_array[$item->cabang?->name][$item->karat?->name]['berat_real'] ?? 0) + $item->berat_real;
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $item->coef = $coef;
                $item->berat_real = $berat_real;
                $pure_gold =  $item->berat_real * ($coef/100);
                $item->pure_gold = $pure_gold;
                $this->stock_cabang_coef[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $coef;
                $this->stock_cabang_24[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $pure_gold;
                $this->stock_cabang_array[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $item;
                
            }
        }
    }

    public function generate_array_stok_cabang(){
        if(!empty($this->stock_cabang)){
            foreach($this->stock_cabang as $item){
                $this->stock_cabang_array[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $item;
            }
        }
    }

    /**
     * Function ini digunakan untuk menghitung harga
     * @param $slug = slug untuk membedakan mau menghitung data yang mana 
     * @param $karat_id = berisi karat id
     * @param $karat_id = untuk case cabang, ini akan berisi array karena butuh beberapa parameter
     * @param $karat_id['karat_id] = karat id
     * @param string $karat_id['cabang] = berisi aray key cabang
     * @param string $karat_id['status] = berisi aray key status
     */
    
    public function hitungHarga($slug, $karat_id) {
        switch ($slug) {
            case "office":
                $result = (($this->stock_office_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_array[$karat_id]['pure_gold'] = $result; 
                break;
            case "office_lantakan":
                $result = (($this->stock_office_lantakan_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_lantakan_array[$karat_id]['weight'] ?? 0);
                $this->stock_office_lantakan_array[$karat_id]['pure_gold'] = $result;
                break;
            case "office_rongsok":
                $result = (($this->stock_office_rongsok_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_rongsok_array[$karat_id]['weight'] ?? 0);
                $this->stock_office_rongsok_array[$karat_id]['pure_gold'] = $result;
                break;
            case "office_pending":
                $result = (($this->stock_office_pending_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_pending_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_pending_array[$karat_id]['pure_gold'] = $result;
                break;
            case "office_ready":
                $result = (($this->stock_office_ready_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_ready_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_ready_array[$karat_id]['pure_gold'] = $result;
                break;
            case "cabang":
                $params = $karat_id;
                $karat_id = $params['karat_id'] ?? null;
                $cabang = $params['cabang'] ?? null;
                $status = $params['status'] ?? null;
                if(!empty($karat_id) && !empty($cabang) && !empty($status)) {
                    $coef = ($this->stock_cabang_coef[$cabang][$status][$karat_id]/100);
                    $result = $coef * ($this->stock_cabang_array[$cabang][$status][$karat_id]['berat_real'] ?? 0);
                    $this->stock_cabang_24[$cabang][$status][$karat_id] = $result;
                    $this->stock_cabang_array[$cabang][$status][$karat_id]['pure_gold'] = $result;
                    $this->stock_cabang_array[$cabang][$status][$karat_id]['coef'] = $coef;
                }
                break;
            default:
                return true;
        }
    }

    public function submit(){
        $data = [];
        DB::beginTransaction();
        try {

            $data = array_merge($this->collectData('office', $this->stock_office_array), $data);
            $data = array_merge($this->collectData('office_lantakan', $this->stock_office_lantakan_array), $data);
            $data = array_merge($this->collectData('office_rongsok', $this->stock_office_rongsok_array), $data);
            $data = array_merge($this->collectData('office_pending', $this->stock_office_pending_array), $data);
            $data = array_merge($this->collectData('office_ready', $this->stock_office_ready_array), $data);
            $data = array_merge($this->collectData('cabang', $this->stock_cabang_array), $data);

            if(!$this->assets_report->isEmpty()){
                toast('Report Asset Untuk Bulan ini sudah dibuat!', 'error');
            }else{
                AssetReports::insert($data);
                toast('Report asset berhasil dibuat!', 'success');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            toast($e->getMessage(), 'error');
        }
        return redirect()->route('laporanasset.index');

    }

    public function collectData($slug, $datas){
        $results = [];
        foreach($datas as $key => $items) {
            if($slug == 'cabang') {
                foreach ($items as $k => $rows) {
                    foreach ($rows as $value) {
                        $berat_real = ($value['berat_real'] ?? 0) ?? ($value['weight'] ?? 0);
                        $karat_id = $value['karat_id'] ?? null;
                        if(!empty($karat_id)) {
                            $results[] = [
                                'date' => date("Y-m-d H:i:s", strtotime($this->date)),
                                'slug' => $slug,
                                'karat_id' => $karat_id,
                                'status_id' => $value['status_id'] ?? null,
                                'cabang_id' => $value['cabang_id'] ?? null,
                                'berat_real' => $berat_real,
                                'coef' => $this->stock_cabang_coef[$key][$k][$karat_id] ?? null,
                                'pure_gold' => $this->stock_cabang_24[$key][$k][$karat_id] ?? null,
                                'created_by' => auth()->user()->id
                            ];
                        }
                    }
                }
            } else {
                $berat_real = !empty($items['berat_real']) ? $items['berat_real'] : (!empty($items['weight']) ? $items['weight'] : 0);
                if(!empty($items['karat_id'] )) {
                    $results[] = [
                        'date' => date("Y-m-d H:i:s", strtotime($this->date)),
                        'slug' => $slug,
                        'karat_id' => $items['karat_id'] ?? null,
                        'status_id' => $items['status_id'] ?? null,
                        'cabang_id' => $items['cabang_id'] ?? null,
                        'berat_real' => $berat_real,
                        'coef' => $items['coef'] ?? null,
                        'pure_gold' => $items['pure_gold'] ?? null,
                        'created_by' => auth()->user()->id,
                    ];
                }
            }
        }
        return $results;
    }

    public function generateDataReport(){
        
        $datas = [];
        if(!empty($this->assets_report)) {
            foreach($this->assets_report as $item) {

                switch ($item->slug) {
                    case "office":
                        $datas[$item->slug][] = $item; 
                        break;
                    case "office_lantakan":
                        $datas[$item->slug][] = $item;
                        break;
                    case "office_rongsok":
                        $datas[$item->slug][] = $item;
                        break;
                    case "office_pending":
                        $datas[$item->slug][] = $item;
                        break;
                    case "office_ready":
                        $datas[$item->slug][] = $item;
                        break;
                    case "cabang":
                        $datas[$item->slug][$item->cabang?->name][$item->current_status?->name][$item->karat_id] = $item;
                        break;
                    default:
                        return true;
                }
            }
        }
        return $datas;

        
        // dd(
        // $this->stock_office_array,
        // $this->stock_office_lantakan_array,
        // $this->stock_office_rongsok_array,
        // $this->stock_office_pending_array,
        // $this->stock_office_ready_array,
        // $this->stock_cabang_array
        // );
    }

    public function setIsReport(){
        if($this->assets_report->isEmpty() && (empty($this->year) || empty($this->month))){
            $this->is_report = false;
        }else{
            $this->is_report = true;
        }
    }

    public function resetReport(){
        DB::beginTransaction();
        try {
            $date = $this->date;
            $month = $date->month;
            $year = $date->year;
            $assets_report = AssetReports::with('karat')
                                ->when($month, function ($query) use ($month) {
                                    return $query->whereMonth('date', $month);
                                })
                                ->when($year, function ($query) use ($year) {
                                    return $query->whereYear('date', $year);
                                });
            $assets_report->delete();
            toast('Report asset berhasil dihapus!', 'success');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            toast($e->getMessage());
        }

        return redirect()->route('laporanasset.index');

    }
}
