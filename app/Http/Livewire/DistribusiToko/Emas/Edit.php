<?php

namespace App\Http\Livewire\DistribusiToko\Emas;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Cabang\Models\Cabang;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Stok\Models\StockOffice;

class Edit extends Component
{
    use WithPagination;
    public $dist_toko;

    public $cabangs;
    public $product_categories;
    public $groups;
    public $models;
    public $dataKarat = [];

    public $logam_mulia_id;
    public $karat_logam_mulia;

    public $kode_produk;

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'imageUploaded',
        'imageRemoved',
        'setAdditionalAttribute',
        'removeProduct' => 'handleRemoveProduct'
    ];

    public $search;

    public $isLogamMulia;

    public $new_product = [
        'product_category_id' => '',
        'group_id' => '',
        'model_id' => '',
        'code' => '',
        'karat_id' => '',
        'certificate_id' => '',
        'no_certificate' => '',
        'gold_weight' => 0,
        'total_weight' => 0,
        'accessories_weight' => 0,
        'tag_weight' => 0,
        'webcam_image' => '',
        'uploaded_image' => ''
    ];

    public function handleWebcamCaptured($data_uri){
        $this->new_product['webcam_image'] = $data_uri;
        $this->imageRemoved();
    }

    public function handleWebcamReset(){
        $this->new_product['webcam_image'] = '';
        $this->dispatchBrowserEvent('webcam-image:remove');
    }

    public function imageUploaded($fileName){
        $this->new_product['uploaded_image'] = $fileName;
        $this->handleWebcamReset();
    }

    public function imageRemoved($fileName = null){
        $this->new_product['uploaded_image'] = '';
        $this->dispatchBrowserEvent('uploaded-image:remove');
    }

    public function handleRemoveProduct(Product $product){
        DB::beginTransaction();
        try{
            $this->addStockOffice($product);
            $product->updateTracking(ProductStatus::REMOVED);
            $product->delete();
            $this->dispatchBrowserEvent('product:removed');
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
            $this->dispatchBrowserEvent('product:remove-failed');
        }
    }

    public function render()
    {
        $data = Product::orderBy('updated_at','desc')->with('product_item')
                ->whereIn('status_id',[ProductStatus::READY_OFFICE])
                ->whereRelation('category.kategoriproduk',fn($q) => $q->whereIn('slug',['gold','emas']));;
        
        if (!empty($this->search)) {
            $search = $this->search;
            $data->where(function($query) use ($search) {
                $query->where('product_code','like', '%'. $search . '%');
                $query->orWhere('product_name','like', '%'. $search . '%');
            });
        }
        $data = $data->paginate(5);
        return view('livewire.distribusi-toko.emas.edit',[
            'products' => $data,
        ]);
    }
    
    public function mount(DistribusiToko $dist_toko)
    {
        $this->dist_toko = $dist_toko;
        $this->cabangs = Cabang::all();
        $kategori = KategoriProduk::where('slug','gold')->orWhere('slug','emas')->firstOrFail();
        $this->product_categories = Category::where('kategori_produk_id',$kategori->id)->get();
        $this->groups = Group::all();
        $this->models = ProdukModel::all();

        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null)
                ->whereHas('stockOffice', function ($query) {
                    $query->where('berat_real', '>', 0);
                });
        })->get();
        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->firstOrFail()->id;
        $this->karat_logam_mulia = Karat::logam_mulia()->id;
    }

    public function updated($propertyName)
    {
        $this->resetErrorBag();
        $this->validateOnly($propertyName);
    }


    public function rules()
    {
        $rules = [
            'dist_toko.cabang_id' => 'required',
            'dist_toko.date' => 'required',
            'dist_toko.no_invoice' => 'required|string|max:70'
        ];
        return $rules;
    }

    public function submitBarcode()
    {
        if(!empty($this->kode_produk)){
            $data = Product::where('product_code',$this->kode_produk)->whereIn('status_id',[ProductStatus::READY_OFFICE]);
            $data = $data->first();
            if ($data) {
                $this->selectProduct($data);
                $this->kode_produk = '';
            }

        }

    }

    public function productCategoryChanged(){
        $this->clearKaratAndTotal();
        $this->isLogamMulia();
        if($this->new_product['product_category_id'] == $this->logam_mulia_id){
            $this->new_product['karat_id'] = $this->karat_logam_mulia;
        }
    }

    public function clearKaratAndTotal(){
        $this->new_product['karat_id'] = '';
        $this->new_product['accessories_weight'] = 0;
        $this->new_product['tag_weight'] = 0;
        $this->new_product['gold_weight'] = 0;
        $this->new_product['total_weight'] = 0;
        $this->new_product['certificate_id'] = '';
        $this->new_product['no_certificate'] = '';
    }

    private function isLogamMulia(){
        $this->isLogamMulia = $this->new_product['product_category_id'] == $this->logam_mulia_id;
    }

    public function generateCode(){
        $this->new_product["code"] = Product::generateCode();
    }

    private function product_rules(){
        return [
            'new_product.product_category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if($value == $this->logam_mulia_id){
                        $stock = StockOffice::where('karat_id',$this->karat_logam_mulia)->first();
                        if(is_null($stock) or $stock->berat_real <= 0){
                            $fail('Stok tidak tersedia');
                        }
                    }
                }
            ],
            'new_product.group_id' => 'required',
            'new_product.code' => 'required|max:255|unique:products,product_code',
            'new_product.karat_id' => 'required',
            'new_product.accessories_weight' => 'required_unless:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.tag_weight' => 'required_unless:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.gold_weight' => [
                'required',
                'gt:0',
                function ($attribute, $value, $fail) {
                    if(!empty($this->new_product['karat_id'])){
                        $karat = Karat::find($this->new_product['karat_id']);
                        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
                        $maxWeight = DB::table('stock_office')
                            ->where('karat_id', $karat_id)
                            ->max('berat_real');
                        if ($value > $maxWeight) {
                            $fail("Berat melebihi stok yang tersedia. Sisa Stok ($maxWeight gr)");
                        }
                    }
                },
            ],
            'new_product.total_weight' => 'required|gt:0',
            'new_product.certificate_id' => 'required_if:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.no_certificate' => 'required_if:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.webcam_image' => ['required_if:new_product.uploaded_image,']
        ];
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

    private function getUploadedImage(){
        $folderPath = "uploads/";
        if(!empty($this->new_product['uploaded_image'])){
            Storage::disk('public')->move("temp/dropzone/{$this->new_product['uploaded_image']}","{$folderPath}{$this->new_product['uploaded_image']}");
            return $this->new_product['uploaded_image'];  
        }
        elseif(!empty($this->new_product['webcam_image'])){
            $image_parts = explode(";base64,", $this->new_product['webcam_image']);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName ='webcam_'. uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('public')->put($file,$image_base64);
            return $fileName;
        }
    }

    public function add_new_product(){
        $this->validate($this->product_rules());
        DB::beginTransaction();
        try{
            // Create product first
            $product_data = [
                'category_id' => $this->new_product['product_category_id'],
                'product_stock_alert'        => 5,
                'group_id' => $this->new_product['group_id'],
                'model_id' => empty($this->new_product['model_id'])?null:$this->new_product['model_id'],
                'karat_id' => $this->new_product['karat_id'],
                'berat_emas' => $this->new_product['gold_weight'],
                'status_id' => ProductStatus::READY_OFFICE,
                'product_code'               => $this->new_product['code'],
                'product_barcode_symbology'  => 'C128',
                'product_unit'               => 'Gram',
                'images' => $this->getUploadedImage(),
            ];
            $product_data['product_name'] = $this->groups->find($this->new_product['group_id'])->name;
            if(!empty($this->new_product['model_id'])){
                $product_data['product_name'] = $product_data['product_name'] . ' ' . $this->models->find($this->new_product['model_id'])->name;
            }
            $product = Product::create($product_data);
            $this->reduceStockOffice($product);

            $product_item = $product->product_item()->create([
                'certificate_id'              => empty($this->new_product['certificate_id'])?null:$this->new_product['certificate_id'],
                'no_certificate'              => empty($this->new_product['no_certificate'])?null:$this->new_product['no_certificate'],
                'berat_label'                 => $this->new_product['tag_weight'],
                'berat_accessories'           => $this->new_product['accessories_weight'],
                'berat_total'                 => $this->new_product['total_weight'],
            ]);
            $product->statuses()->attach($product->status_id,['cabang_id' => $product->cabang_id, 'properties' => json_encode([
                'product' => $product,
                'product_additional_information' =>  $product_item
            ])]);

            $this->reset('new_product');
            $this->handleWebcamReset();
            $this->imageRemoved();
            $this->dispatchBrowserEvent('create-modal:close');

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
    }

    private function reduceStockOffice($product){
        $karat = Karat::find($product->karat_id);
        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
        $stock_office = StockOffice::where('karat_id', $karat_id)->first();
        $product->stock_office()->attach($stock_office->id,[
                'karat_id'=>$karat_id,
                'in' => false,
                'berat_real' => -1 * $product->berat_emas,
                'berat_kotor' => -1 * $product->berat_emas
        ]);
        $berat_real = $stock_office->history->sum('berat_real');
        $berat_kotor = $stock_office->history->sum('berat_kotor');
        $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
    }

    private function addStockOffice($product){
        $karat = Karat::find($product->karat_id);
        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
        $stock_office = StockOffice::firstOrCreate(['karat_id' => $karat_id]);
        $product->stock_office()->attach($stock_office->id,[
                'karat_id'=>$karat_id,
                'in' => true,
                'berat_real' => $product->berat_emas,
                'berat_kotor' => $product->berat_emas
        ]);
        $berat_real = $stock_office->history->sum('berat_real');
        $berat_kotor = $stock_office->history->sum('berat_kotor');
        $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
    }

    public function calculateTotalWeight(){
        $this->new_product['total_weight'] = 0;
        $this->new_product['total_weight'] += doubleval($this->new_product['gold_weight']);
        $this->new_product['total_weight'] += doubleval($this->new_product['accessories_weight']);
        $this->new_product['total_weight'] += doubleval($this->new_product['tag_weight']);
        $this->new_product['total_weight'] = round($this->new_product['total_weight'], 3);
    }

    public function remove(DistribusiTokoItem $item)
    {
        DB::beginTransaction();
        try{
            $item->product->updateTracking(ProductStatus::READY_OFFICE);
            $item->delete();
            $this->dist_toko->refresh();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
    }

    public function selectProduct(Product $product) {
        DB::beginTransaction();
        try{
            $additional_data = [
                "product_information" => [
                    "product_category" => [
                        "id" => $product->category_id,
                        "name" => $product->category->category_name
                    ],
                    "group" => [
                        'id' => $product->group_id,
                        'name' => $product->group->name
                    ],
                    "model" => [
                        'id' => $product->model_id,
                        'name' => $product->model?->name
                    ],
                    "code" => $product->product_code,
                    'certificate_id' => $product->product_item?->certificate_id,
                    'no_certificate' => $product->product_item?->no_certificate,
                    'accessories_weight' => $product->product_item?->berat_accessories,
                    'tag_weight' => $product->product_item?->berat_label,
                    'image' => $product->images,
                    'total_weight' => $product->product_item?->berat_total
                ]
            ];
            $item = $this->dist_toko->items()->create([
                'karat_id' => $product->karat_id,
                'gold_weight' => $product->berat_emas,
                'product_id' => $product->id,
                'additional_data' => json_encode($additional_data),
            ]);
            $product->updateTracking(ProductStatus::DRAFT);
            $this->dist_toko->refresh();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
    }


    public function store()
    {
        if(!count($this->dist_toko->items)){
            $this->dispatchBrowserEvent('not:selected');
        }else{
            $this->validate();
            DB::beginTransaction();
            try{
                $this->dist_toko->save();
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
            $this->resetExcept('dist_toko');
            toast('Saved to Draft Successfully','success');
            return redirect(route('distribusitoko.detail', $this->dist_toko));
        }
    }
}
