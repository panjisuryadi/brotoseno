<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Entities\ProductLocation;
use Livewire\WithFileUploads;
class Create extends Component
{
    use WithFileUploads;
       public $product_code;
       public $product_name;
       public $sale = '';
       public $price = '';
       public $product_sale= '';
       public $product_price = '';
       public $get_category;
       public $category;
       public $image;
       protected $listeners = ['resetInput'];

       protected function rules()
            {
               return [
                     'product_name' => 'required|max:191',
                     'get_category' => 'required',
                     'price' => 'required|max:191',
                     'sale' => 'required|max:191',
                     'image' => 'required|image|max:1024',

                ];
             }

       public function render()
       {

           $this->category = Category::all();
           $datas = Product::all();
           $code =  Product::generateCode();

           return view('livewire.product.create', compact('datas','code'));
       }


       public function mount()
            {
                $this->product_code = Product::generateCode();
            }



       public function store()
       {

        $input= $this->validate();
        $product_price = preg_replace("/[^0-9]/", "", $this->price);
            // dd($input);
        $create = Product::create([
            'category_id'                       => $this->get_category,
            'product_stock_alert'               => 5,
            'product_name'                      => $this->product_name,
            'product_code'                      => Product::generateCode(),
            'product_price'                     => $product_price,
            'product_quantity'                  => 0,
            'product_barcode_symbology'         => 'C128',
            'product_unit'                      => 'Gram',
            'product_cost'                      =>  $product_price,
            'status'                            =>  3,
       ]);

         $foto = $this->image;
        if(!empty($foto)){
            $create->addMedia($foto)->toMediaCollection('images');
           // dd($foto);
         }
        $produk = $create->id;
        $this->_saveProductsItem($input ,$produk);
        $this->resetInput();
        $this->emit('produkTemp');
       }

         public function resetInput()
            {
                $this->get_category = '';
                $this->product_code = '';
                $this->product_name = '';
                $this->price = '';
                $this->sale = '';
            }

        public function convertRupiah()
            {
                $this->product_price = 'Rp ' . number_format($this->price, 0, ',', '.');
            }


        private function _saveProductsItem($input ,$produk)
        {

           $product_price = preg_replace("/[^0-9]/", "", $this->price);
           ProductItem::create([
                'product_id'                  => $produk,
                'karat_id'                    => $input['karat_id'] ?? null,
                'gold_kategori_id'            => $input['gold_kategori_id'] ?? null,
                'certificate_id'              => $input['certificate_id'] ?? null,
                'shape_id'                    => $input['shape_id'] ?? null,
                'round_id'                    => $input['round_id'] ?? null,
                'product_cost'                => $product_price,
                'product_price'               => $product_price,
                'product_sale'                => $product_price,
                'berat_emas'                  => $input['berat_emas'] ?? 0,
                'berat_label'                 => $input['berat_label'] ?? 0,
                'gudang_id'                   => $input['gudang_id'] ?? 25,
                'supplier_id'                 => $input['supplier_id'] ?? null,
                'etalase_id'                  => $input['etalase_id'] ?? null,
                'baki_id'                     => $input['baki_id'] ?? null,
                'berat_total'                 => $input['berat_total'] ?? null
            ]);
           //dd($input);
          }




}
