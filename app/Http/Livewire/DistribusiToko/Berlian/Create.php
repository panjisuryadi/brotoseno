<?php

namespace App\Http\Livewire\DistribusiToko\Berlian;

use App\Models\LookUp;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Produksi\Models\Produksi;
use Modules\Stok\Models\StockOffice;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{

    public $categories;
    public $product_category;

    public $cabang;

    public $kategori;

    public $logam_mulia_id;

    public $karat_logam_mulia;

    public $distribusi_toko = [
        'no_distribusi_toko' =>'',
        'date' => '',
        'cabang_id' => ''
    ];

    public $dataKarat = [];

    public $distribusi_toko_details = [];

    public $used_stock = [];

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'setAdditionalAttribute'
    ];

    public $exceptProduksiId = [];

    public $produksis_id;

    public $search;

    public $kode_produk;

    public function handleWebcamCaptured($key,$data_uri){
        $this->distribusi_toko_details[$key]['webcam_image'] = $data_uri;
    }

    public function handleWebcamReset($key){
        $this->distribusi_toko_details[$key]['webcam_image'] = '';
    }

    public function setAdditionalAttribute($key,$name,$selectedText){
        $this->distribusi_toko_details[$key][$name] = $selectedText;
    }

    private function resetDistribusiToko()
    {
        $this->distribusi_toko = [
            'date' => '',
            'cabang_id' => ''
        ];
    }
    private function resetDistribusiTokoDetails()
    {
        $this->distribusi_toko_details = [
            [
                'product_category' => '',
                'group' => '',
                'model' => '',
                'gold_category' => '',
                'karat' => '',
                'accessoris_weight' => 0,
                'label_weight' => 0,
                'gold_weight' => 0,
                'total_weight' => 0,
                'code' => '',
                'file' => '',
                'certificate_id' => '',
                'no_certificate' => '',
                'webcam_image' => '',
                'product_category_name' => '',
                'group_name' => '',
                'model_name' => '',
            ]
        ];
    }

    public function render(){
        $this->exceptProduksiId = array_merge($this->exceptProduksiId, $this->produksis_id);
        $data = Product::with('karat', 'group',)->where('status_id',ProductStatus::READY_OFFICE);
        if (!empty($this->exceptProduksiId)) {
                $data = $data->whereNotIn('id', $this->exceptProduksiId);
            }
            if (!empty($this->search)) {
                $search = $this->search;
                $data->where(function($query) use ($search) {
                        $query->where('code','like', '%'. $search . '%');
                        $query->orWhere('berat','like', '%'. $search . '%');
                    });
            }
        $data = $data->paginate(5);
        return view("livewire.distribusi-toko.berlian.create",[
            'products' => $data
        ]);
    }

    private function resetInputFields()
    {
        $this->resetDistribusiToko();
        $this->resetDistribusiTokoDetails();
    }


    public function rules()
    {
        $rules = [
            'distribusi_toko.cabang_id' => 'required',
            'distribusi_toko.date' => 'required',
            'distribusi_toko.no_distribusi_toko' => 'required|string|max:70'
        ];

        return $rules;
    }

    public function updated($propertyName)
    {
        $this->resetErrorBag();
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null)
                ->whereHas('stockOffice', function ($query) {
                    $query->where('berat_real', '>', 0);
                });
        })->get();
        $this->distribusi_toko['no_distribusi_toko'] = $this->generateInvoice();
        $this->distribusi_toko['date'] = (new DateTime())->format('Y-m-d');

        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->firstOrFail()->id;
        $this->karat_logam_mulia = Karat::logam_mulia()->id;
    }

    private function generateInvoice(){
        $lastString = DistribusiToko::orderBy('id', 'desc')->value('no_invoice');

        $numericPart = (int) substr($lastString, 10);
        $incrementedNumericPart = $numericPart + 1;
        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
        $nextString = "DIST-TOKO-" . $nextNumericPart;
        return $nextString;
    }

    public function store()
    {
        $this->validate();
        $kategoriproduk_id = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');

        DB::beginTransaction();
        try{
            $distribusi_toko = DistribusiToko::create([
                'cabang_id'                   => $this->distribusi_toko['cabang_id'],
                'date'                        => $this->distribusi_toko['date'],
                'no_invoice'                  => $this->distribusi_toko['no_distribusi_toko'],
                'kategori_produk_id'          => $kategoriproduk_id,
                'created_by'                  => auth()->user()->name,
            ]);

            $ids = [];
            foreach($this->distribusi_toko_details as $key => $value) {
                $additional_data = [
                    "product_information" => $value
                ];
                $distribusi_toko->items()->create([
                    'karat_id' => !empty($value['karat_id']) ? $value['karat_id'] : 1,
                    'gold_weight' => !empty($value['berat_emas']) ? $value['berat_emas'] : 0,
                    'product_id' => !empty($value['id']) ? $value['id'] : null,
                    'additional_data' => json_encode($additional_data),
                ]);

                if (!empty($value['id'])) {
                    $ids[] = $value['id'];
                }
            }
            if(!empty($ids)) {
                $product_insert = Product::whereIn('id', $ids)->update(['status_id' => ProductStatus::OTW, 'cabang_id' => $distribusi_toko->cabang_id]);

            }
            $distribusi_toko->setAsDraft();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        toast('Saved to Draft Successfully','success');
        return redirect(route('distribusitoko.detail', $distribusi_toko));
    }

    public function messages(){
        return [];
    }

    public function generateCode($key){
        $this->checkGroup($key);

        $namagroup = Group::where('id', $this->distribusi_toko_details[$key]['group'])->first()->code;

        $cb = Cabang::where('id', $this->distribusi_toko['cabang_id'])->first()?->code;
         $existingCode = true;
         $codeNumber = '';
         $cabang = $cb ?? 'JSR';
        while ($existingCode) {
               $date = now()->format('dmY');
               $randomNumber = mt_rand(100, 999);
               $codeNumber = $cabang .'-'. $namagroup .'-'. $randomNumber .'-'. $date;
               $existingCode = Product::where('product_code', $codeNumber)->exists();
        }
        $this->distribusi_toko_details[$key]['code'] = $codeNumber;
    }

    private function checkGroup($key){
        $this->validateOnly('distribusi_toko_details.'.$key.'.group');
    }

    public function selectProduct($val) {
        $val = json_decode($val);
        $this->exceptProduksiId[] = $val->id;
        $val = (array)$val;
        $val['group'] = (array)$val['group'];
        $val['karat'] = (array)$val['karat'];
        $this->distribusi_toko_details[] = $val;
        
    }

    public function remove($index)
    {
        $data = $this->distribusi_toko_details[$index];
        unset($this->distribusi_toko_details[$index]);
        $produksis_id = !empty($data['id']) ? $data['id'] : '';
        if (!empty($produksis_id)) {
            if(($key = array_search($produksis_id, $this->exceptProduksiId)) != false) {
                unset($this->exceptProduksiId[$key]);
            }
        }
    }

    public function submitBarcode()
    {
        $this->kode_produk;
        if(!empty($this->kode_produk)){
            $data = Product::with('karat', 'group')->where('product_code',$this->kode_produk);
            if (!empty($this->exceptProduksiId)) {
                $data = $data->whereNotIn('id', $this->exceptProduksiId);
            }
            $data = $data->first();
            if ($data) {
                $this->selectProduct($data);
                $this->kode_produk = '';
            }

        }

    }
}
