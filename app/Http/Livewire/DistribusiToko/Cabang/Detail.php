<?php

namespace App\Http\Livewire\DistribusiToko\Cabang;

use App\Models\LookUp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Stok\Models\StockCabang;

class Detail extends Component
{
    public $dist_toko;

    public $dist_toko_items;

    public $selectedItems = [];

    public $selectAll = false;

    public $note = '';

    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public $id_kategoriproduk_berlian;

    public function handleSelectAllItem($selectedItems){
        $this->selectedItems = $selectedItems;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function updatedSelectedItems(){
        if(count($this->selectedItems) == count($this->dist_toko_items)){
            $this->selectAll = true;
        }else{
            $this->selectAll = false;
        }
    }


    public function render()
    {
        return view("livewire.distribusi-toko.cabang.detail");
    }

    public function mount()
    {
        $this->dist_toko_items = $this->dist_toko->items;
    }

    public function rules()
    {
        $rules = [
            'note' => 'required_if:selectAll,false'
        ];
        return $rules;
    }

    public function messages(){
        return [
            'note.required_if' => 'Wajib di isi',
        ];
    }

    public function proses()
    {
        $this->dispatchBrowserEvent('summary:modal');
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }

    public function confirm(){
        $this->validate();
        $id_kategoriproduk_berlian = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');
        $this->id_kategoriproduk_berlian = $id_kategoriproduk_berlian;
        if($this->selectAll){
            DB::beginTransaction();
            try{
                $this->dist_toko->setAsCompleted();
                if(!empty($this->dist_toko->kategori_produk_id) && $this->dist_toko->kategori_produk_id == $id_kategoriproduk_berlian) {
                    $this->createProductsBerlian($this->selectedItems);
                }else{
                    $this->updateProducts($this->selectedItems);
                }
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
        }else{
            DB::beginTransaction();
            try{
                $this->dist_toko->setAsReturned($this->note);
                if(!empty($this->dist_toko->kategori_produk_id) && $this->dist_toko->kategori_produk_id == $id_kategoriproduk_berlian) {
                    $this->createProductsBerlian($this->selectedItems);
                }else{
                    $this->updateProducts($this->selectedItems);
                }
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
        }
        toast('Penerimaan Distribusi Berhasil dilakukan','success');
        return redirect(route('home'));
    }

    private function updateProducts($selected_items){
        foreach($this->dist_toko_items as $item){
            if(in_array($item->id, $selected_items)){
                $item->approved();
                $item->product->updateTracking(ProductStatus::READY,$this->dist_toko->cabang_id);
            }else{
                $item->returned();
            }
        }
    }

    private function createProducts($selected_items){
        foreach($this->dist_toko_items as $item){
            if(in_array($item->id, $selected_items)){
                $item->approved();
                $this->addStockCabang($item,$this->dist_toko->cabang_id);
                $additional_data = json_decode($item['additional_data'],true)['product_information'];
                $product = $item->product()->create([
                    'category_id'                => $additional_data['product_category']['id'],
                      'cabang_id'                  => $this->dist_toko->cabang_id,
                      'product_stock_alert'        => 5,
                        'product_name'              => $additional_data['group']['name'] .' '. $additional_data['model']['name'] ?? 'unknown',
                      'product_code'               => $additional_data['code'],
                      'product_barcode_symbology'  => 'C128',
                      'product_unit'               => 'Gram',
                      'images' => $additional_data['image']
                ]);
    
                $product->product_item()->create([
                    'karat_id'                    => $item->karat_id,
                    'certificate_id'              => empty($additional_data['certificate_id'])?null:$additional_data['certificate_id'],
                    'berat_emas'                  => $item->gold_weight,
                    'berat_label'                 => $additional_data['tag_weight'],
                    'berat_accessories'           => $additional_data['accessories_weight'],
                    'produk_model_id'             => $additional_data['model']['id'],
                    'berat_total'                 => $additional_data['total_weight'],
                ]);
            }else{
                $item->returned();
            }
        }
    }

    private function addStockCabang($item,$cabang_id){
        $stock_cabang = StockCabang::where(['karat_id' => $item->karat_id, 'cabang_id' => $cabang_id])->first();
        if(is_null($stock_cabang)){
            $stock_cabang = StockCabang::create(['karat_id' => $item->karat_id, 'cabang_id' => $cabang_id]);
        }
        $item->stock_cabang()->attach($stock_cabang->id,[
            'karat_id'=>$item->karat_id,
            'in' => true,
            'berat_real' =>$item->gold_weight,
            'berat_kotor' => $item->gold_weight
        ]);
        $berat_real = $stock_cabang->history->sum('berat_real');
        $berat_kotor = $stock_cabang->history->sum('berat_kotor');
        $stock_cabang->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
    }

    private function createProductsBerlian($selected_items){
        $category_id = Category::where('kategori_produk_id', $this->id_kategoriproduk_berlian)->value('id');
        $ids = [];
        foreach($this->dist_toko_items as $item){
            if(in_array($item->id, $selected_items)){
                $item->approved();
                $this->addStockCabang($item,$this->dist_toko->cabang_id);

                if (!empty($item->product_id)) {
                    $ids[] = $item->product_id;
                }
                // $additional_data = !empty($item['additional_data']) ? $item['additional_data'] : [];
                // $additional_data = json_decode($additional_data,true);
                // $produk_information = !empty($additional_data['product_information']) ? $additional_data['product_information'] : [];
                // $model = !empty($produk_information['model']['name']) ? $produk_information['model']['name'] : '';
                // $karat_name = !empty($produk_information['karatjadi']['name']) ? $produk_information['karatjadi']['name'] : '';
                // $product = $item->product()->create([
                //     'category_id'               => !empty($produk_information['product_category_id']) ? $produk_information['product_category_id'] : $category_id,
                //     'cabang_id'                 => $this->dist_toko->cabang_id,
                //     'product_stock_alert'       => 5,
                //     'product_name'              => $model. ' ' . $karat_name .' Berlian' ,
                //     'product_code'              => !empty($produk_information['code']) ? $produk_information['code'] : '',
                //     'product_price'             => !empty($produk_information['harga_jual']) ? (int)$produk_information['harga_jual'] : '',
                //     'product_barcode_symbology' => 'C128',
                //     'product_unit'              => 'Gram',
                //     'karat_id'                  => !empty($produk_information['karat_id']) ? $produk_information['karat_id'] : null,
                //     'berat_emas'                => !empty($produk_information['berat']) ? $produk_information['berat'] : 0,
                //     'total_karatberlians'       => !empty($produk_information['total_karatberlians']) ? $produk_information['total_karatberlians'] : 0,
                //     'diamond_certificate_id'    => !empty($produk_information['diamond_certificate_id']) ? $produk_information['diamond_certificate_id'] : null,
                //     'images'                    => !empty($produk_information['image']) ? $produk_information['image'] : '',
                // ]);
                
                // $produksi_items = !empty($produk_information['produksi_items']) ? $produk_information['produksi_items'] : [];
                // if(empty($produksi_items) && !empty($item->produksis_id)) { 
                //     $produksi_items = ProduksiItems::where('produksis_id', $item->produksis_id)->get();
                // }

                // if (!empty($produksi_items)) {
                //     $array_produksi_items = [];
                //     foreach($produksi_items as $val) {
                //         $array_produksi_items[] = [
                //             'product_id' => $product->id,
                //             'karatberlians' => !empty($val['karatberlians']) ? $val['karatberlians'] : 0,
                //             'shapeberlians_id' => !empty($val['shapeberlian_id']) ? $val['shapeberlian_id'] : null,
                //             'qty' => !empty($val['qty']) ? $val['qty'] : 0,
                //             'gia_report_number' => !empty($val['gia_report_number']) ? $val['gia_report_number'] : null
                //         ];
                //     }

                //     $insert = $product->product_item()->insert($array_produksi_items);

                // }
            }else{
                $item->returned();
            }
        }
        
        if(!empty($ids)) {
            Product::whereIn('id', $ids)->update(['status_id' => 1, 'cabang_id' => $this->dist_toko->cabang_id]);
        }
    }
}
