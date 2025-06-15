<?php

namespace App\Http\Livewire\DistribusiToko\Modal;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockOffice;

use function PHPUnit\Framework\isEmpty;

class Edit extends Component
{
    public $dist_toko;
    public $data = [
        'additional_data' => [
            'product_category' => [
                'id' => '',
                'name' => ''
            ],
            'group' => [
                'id' => '',
                'name' => ''
            ],
            'model' => [
                'id' => '',
                'name' => ''
            ],
            'code' => '',
            'certificate_id' => '',
            'no_certificate' => '',
            'accessories_weight' => 0,
            'tag_weight' => 0,
            'image' => ''
        ],
        'gold_weight' => 0,
        'total_weight' => 0,
        'karat_id' => ''
    ];

    public $isLogamMulia;
    public $logam_mulia_id;

    public $karat_logam_mulia;

    public $dataLabel;

    public $categories;

    public $dataKarat;

    public $temp_image = [];

    public $is_preview = true;

    public $total_weight_per_karat = [];

    protected $listeners = [
        'setData',
        'setAdditionalAttribute',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
    ];
    public function render(){
        return view("livewire.distribusi-toko.modal.edit");
    }

    public function handleWebcamCaptured($key,$data_uri){
        $this->temp_image[$key]['webcam_image'] = $data_uri;
    }

    public function handleWebcamReset($key){
        $this->temp_image[$key]['webcam_image'] = '';
    }

    public function cancelRetake($key){
        $this->is_preview = true;
        $this->emit('removePrev',$key);
    }

    public function mount(){
        $kategori = KategoriProduk::where('slug','gold')->orWhere('slug','emas')->firstOrFail();
        $this->categories = Category::where('kategori_produk_id',$kategori->id)->get();
        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null)
                ->whereHas('stockOffice', function ($query) {
                    $query->where('berat_real', '>', 0);
                });
        })->get();
        
        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->value('id');
        $this->karat_logam_mulia = Karat::logam_mulia()->id;
    }

    private function getTotalWeightBasedOnKarat(){
        foreach($this->dist_toko->items->groupBy('karat_id') as $karat_id => $items){
            $this->total_weight_per_karat[$karat_id] = $items->sum('gold_weight');
        }
    }

    public function setAdditionalAttribute($name,$selectedText){
        $this->data['additional_data'][$name]['name'] = $selectedText;
    }

    public function productCategoryChanged(){
        $this->clearKaratAndTotal();
        $this->isLogamMulia();
        if($this->data['additional_data']['product_category']['id'] == $this->logam_mulia_id){
            $this->data['karat_id'] = $this->karat_logam_mulia;
        }
    }

    public function clearKaratAndTotal(){
        $this->data['karat_id'] = '';
        $this->data['additional_data']['accessories_weight'] = 0;
        $this->data['additional_data']['tag_weight'] = 0;
        $this->data['gold_weight'] = 0;
        $this->data['total_weight'] = 0;
        $this->data['additional_data']['certificate_id'] = '';
        $this->data['additional_data']['no_certificate'] = '';
    }

    public function calculateTotalWeight(){
        $this->data['total_weight'] = 0;
        $this->data['total_weight'] += doubleval($this->data['gold_weight']);
        $this->data['total_weight'] += doubleval($this->data['additional_data']['accessories_weight']);
        $this->data['total_weight'] += doubleval($this->data['additional_data']['tag_weight']);
        $this->data['total_weight'] = round($this->data['total_weight'], 3);
    }


    public function setData($data){
        $this->data = $data;
        $this->data["additional_data"] = json_decode($data['additional_data'],true)['product_information'];
        $this->getTotalWeightBasedOnKarat();
        $this->total_weight_per_karat[$this->data['karat_id']] = $this->total_weight_per_karat[$this->data['karat_id']] - $this->data['gold_weight'];
        $this->calculateTotalWeight();
        $this->isLogamMulia();
        $this->resetErrorBag();

    }

    private function isLogamMulia(){
        $this->isLogamMulia = $this->data['additional_data']['product_category']['id'] == $this->logam_mulia_id;
    }

    public function generateCode(){
        $this->checkGroup();
        $namagroup = Group::where('id', $this->data["additional_data"]["group"]["id"])->first()->code;
        $existingCode = true;
        $codeNumber = '';
        $cabang = 'CBR';
        while ($existingCode) {
               $date = now()->format('dmY');
               $randomNumber = mt_rand(100, 999);
               $codeNumber = $cabang .'-'. $namagroup .'-'. $randomNumber .'-'. $date;
               $existingCode = Product::where('product_code', $codeNumber)->exists();
        }
        $this->data["additional_data"]["code"] = $codeNumber;
    }

    private function checkGroup(){
        $this->validateOnly("data.additional_data.group.id");
    }


    public function rules()
    {
        $rules = [
            // 'distribusi_toko.cabang_id' => 'required',
            // 'distribusi_toko.date' => 'required',
            // 'distribusi_toko.no_distribusi_toko' => 'required|string|max:70'
        ];


        $rules['data.additional_data.product_category.id'] = [
            'required',
            function ($attribute, $value, $fail) {
                if($value == $this->logam_mulia_id){
                    $stock = StockOffice::where('karat_id',$this->karat_logam_mulia)->first();
                    if(is_null($stock) or $stock->berat_real <= 0){
                        $fail('Stok tidak tersedia');
                    }
                }
            }
        ];
        $rules['data.additional_data.group.id'] = 'required';
        $rules['data.additional_data.code'] = 'required|max:255|unique:products,product_code';
        // $rules['distribusi_toko_details.'.$key.'.gold_category'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,4';
        $rules['data.karat_id'] = 'required';
        $rules['data.additional_data.accessories_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.tag_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.gold_weight'] = [
            'required',
            'gt:0',
            function ($attribute, $value, $fail) {
                // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_office berdasarkan nilai parent id nya
                $maxWeight = DB::table('stock_office')
                    ->where('karat_id', $this->data['karat_id'])
                    ->max('berat_real');
                $total_input_weight_based_on_karat = $this->total_weight_per_karat[$this->data['karat_id']]??0;
                if($total_input_weight_based_on_karat<$maxWeight){
                    $maxWeight = $maxWeight - $total_input_weight_based_on_karat;
                    if ($value > $maxWeight) {
                        $fail("Berat melebihi stok yang tersedia. Sisa Stok ($maxWeight gr)");
                    }
                }else{
                    $fail("Stok telah habis digunakan");
                }

            },
        ];
        $rules['data.total_weight'] = 'required|gt:0';
        $rules['data.additional_data.certificate_id'] = 'required_if:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.no_certificate'] = 'required_if:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        //     $rules['distribusi_toko_details.'.$key.'.webcam_image'] = 'required';

        return $rules;
    }

    public function update()
    {
        $this->validate();
        
        DB::beginTransaction();
        try{
            $additional_data = [
                "product_information" => [
                    "product_category" => [
                        "id" => $this->data['additional_data']['product_category']['id'],
                        "name" => $this->data['additional_data']['product_category']['name']
                    ],
                    "group" => [
                        'id' => $this->data['additional_data']['group']['id'],
                        'name' => $this->data['additional_data']['group']['name']
                    ],
                    "model" => [
                        'id' => $this->data['additional_data']['model']['id'],
                        'name' => $this->data['additional_data']['model']['name']
                    ],
                    "code" => $this->data['additional_data']['code'],
                    'certificate_id' => $this->data['additional_data']['certificate_id'],
                    'no_certificate' => $this->data['additional_data']['no_certificate'],
                    'accessories_weight' => $this->data['additional_data']['accessories_weight'],
                    'tag_weight' => $this->data['additional_data']['tag_weight'],
                    'image' => empty($this->temp_image[0]['webcam_image'])?$this->data['additional_data']['image']:$this->manageImage(),
                    'total_weight' => $this->data['total_weight']
                ]
            ];
            $item = DistribusiTokoItem::findOrFail($this->data['id']);
            
            $item->update([
                'karat_id' =>  $this->data['karat_id'],
                'gold_weight' => $this->data['gold_weight'],
                'additional_data' => json_encode($additional_data),
            ]);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->emit('reload-page-update');
    }

    private function manageImage(){
        $this->deletePreviousImage();
        return $this->uploadImage($this->temp_image[0]['webcam_image']);
    }

    private function deletePreviousImage(){
        $file_path = 'uploads/'.$this->data['additional_data']['image'];
        if (Storage::disk('public')->exists($file_path)) {
            Storage::disk('public')->delete($file_path);
        }
    }

    private function uploadImage($img){
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName ='webcam_'. uniqid() . '.jpg';
        $file = $folderPath . $fileName;
        Storage::disk('public')->put($file,$image_base64);
        return $fileName;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function messages(){
        return [
            'data.*.required' => 'Wajib di isi',
            'data.*.required_unless' => 'Wajib di isi',
            'data.*.gt' => 'Nilai harus lebih besar dari 0',
            'data.*.required_if' => 'Wajib di isi',    
            'data.*.*.required' => 'Wajib di isi',
            'data.*.*.required_unless' => 'Wajib di isi',
            'data.*.*.required_if' => 'Wajib di isi', 
            'data.*.*.*.required' => 'Wajib di isi',
            'data.*.*.*.required_if' => 'Wajib di isi',
            'data.*.*.*.required_unless' => 'Wajib di isi',
        ];
    }
}
