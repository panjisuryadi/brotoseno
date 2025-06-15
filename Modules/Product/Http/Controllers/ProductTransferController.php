<?php

namespace Modules\Product\Http\Controllers;
use Carbon\Carbon;
use Modules\Product\DataTables\ProductDataTable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Entities\ProductLocation;
use Modules\Locations\Entities\Locations;
use Modules\Product\Entities\TrackingProduct;
use Modules\Gudang\Models\Gudang;
use Modules\Upload\Entities\Upload;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Yajra\DataTables\DataTables;
use Image;
class ProductTransferController extends Controller
{


public function __construct()
    {
        // Page Title
        $this->module_title = 'Products';

        // module name
        $this->module_name = 'products';

        // directory path of the module
        $this->module_path = 'product';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Product\Entities\Product";
        $this->module_item = "Modules\Product\Entities\ProductItem";
        //$this->middleware(['permission:access_product_transfer'])->only('show', 'view');
        //$this->middleware(['permission:access_approve_product'])->only('ApproveProducts');
    }


 public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_product_transfer'), 403);
         return view('product::products.transfer.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }



    public function codeGenerate(Request $request)
    {
         $group = $request->group;
         if (!$group) {
           return response()->json(['code' => '0']);
         }
        //$string = Str::random(8); //
         $existingCode = true;
         $codeNumber = '';
         $cabang = 'CBR';
         while ($existingCode) {
                $date = now()->format('dmY');
                $randomNumber = mt_rand(100, 999);
                $codeNumber = $cabang .'-'. $group .'-'. $randomNumber .'-'. $date;
                $existingCode = Product::where('product_code', $codeNumber)->exists();
            }
          return response()->json(['code' => $codeNumber]);
    }




 public function getsalesProduct(Request $request){
        $product = Product::where('product_price','>',0);
        if(isset($request->cariproduk)){
            $product = $product->where('product_name','LIKE','%'.$request->cariproduk.'%')->orwhere('product_code','LIKE','%'.$request->cariproduk.'%');
        }
        $product = $product->get();
        $data = '';
        if(count($product) > 0){
            foreach($product as $product){
                $stock = ProductLocation::join('locations','locations.id','product_locations.location_id')
                ->where('type','storefront')->where('product_id',$product->id)->first();
                if (empty($stock)) {
                    $stock = 0;
                }else{
                    $stock = $stock->stock;
                }

            if($stock) {
                $data .= '<a class="pb-0" onclick="selectproduct('.$product->id.','.$stock.')" style="cursor:pointer;">
                   <div
                    class="relative overflow-hidden rounded-xl shadow-xl cursor-pointer m-0 dark:bg-gray-600 duration-300 ease-in-out transition-transform transform hover:-translate-y-2">
                    <img class="object-cover w-full h-48"
                      src="'.$product->getFirstMediaUrl('images').'"
                      alt="Flower and sky" />
                    <span
                      class="absolute top-0 left-0 flex flex-col items-center mt-1 ml-1 px-1 py-1 rounded-lg z-10 bg-yellow-500 text-sm font-medium">
                           <span class="small text-xs text-gray-200">'. $product->product_code .'</span>
                    </span>
                    <span
                      class="absolute top-0 right-0 items-center inline-flex mt-1 mr-1 px-1 py-1 rounded-lg z-10 bg-white text-sm font-medium text-white select-none">
                          <span class="small text-xs text-gray-500">Stock: '. $stock .'</span>
                    </span>
                    <div class="bg-gray-900 opacity-60 w-full absolute bottom-0 left-0 items-left py-2">
                      <div class="px-2 text-md font-bold text-white">'. $product->product_name .'</div>
                      <div class="px-2 text-xs text-white">'. format_currency($product->product_price) .'</div>
                    </div>


                  </div>
                  </a>';

               }
            }
        }else{
            $data .= '<div class="col-span-5 py-1 px-1">
                <div class="text-left text-gray-800">Produk Tidak Ditemukan</div>
            </div>
            ';
        }

        return response()->json($data);
    }







    public function index_data_table(ProductDataTable $dataTable) {
        abort_if(Gate::denies('access_approve_product'), 403);

        return $dataTable->render('product::products.index');
    }


    public function add_products_categories_single(Request $request ,$id) {
        abort_if(Gate::denies('access_product_transfer'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();
        $module_action = 'List';
         return view('product::products.add_product',
           compact('module_name',
            'category',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


 public function add_products_categories(Request $request ,$id) {
        abort_if(Gate::denies('access_product_transfer'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();
        $locations = Locations::where('name','LIKE','%Tempo%')->first();
        $code = Product::generateCode();
        $module_action = 'List';
          return view(''.$module_path.'::'.$module_name.'.popup.create',
           compact('module_name',
                    'module_title',
                    'category',
                    'locations',
                    'code',
                    'module_icon', 'module_model'));
    }



public function index_data(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

           $$module_name = $module_model::with('category','product_item')
         ->whereHas('product_location', function ($query) {
                $sortir = Locations::where('name','LIKE','%Pusat%')->first();
                 $query->where('location_id',$sortir->id);
            })
        ->latest()->get();


        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('product::products.transfer.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                    ->editColumn('product_name', function ($data) {
                         $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name ?? 'produk tidak ada' . '</h3>
                             <div style="font-size:0.6rem !important;" class="text-xs font-normal text-blue-600 dark:text-gray-400">
                            ' . $data->product_code . '</div>
                        </div>
                    </div>';
                return $tb;
            })


           ->addColumn('product_image', function ($data) {
            $url = $data->getFirstMediaUrl('images', 'thumb');
                return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
             })

           ->addColumn('product_price', function ($data) {
              return format_currency($data->product_price);
              })
           ->addColumn('product_quantity', function ($data) {
            return $data->product_quantity . ' ' . $data->product_unit;
             })

           ->editColumn('product_quantity', function ($data) {
            $tb = '<div class="items-center small text-center">
            <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' . $data->product_quantity . ' ' . $data->product_unit . '</span></div>';
                return $tb;
             })

           ->editColumn('weight', function ($data) {
              $berat = @$data->product_item[0]->berat_emas;
            if ($berat) {
                 $weight = @$data->product_item[0]->berat_emas;
            } else {
                $weight = '0';
            }

            $tb = '<div class="items-center small text-center">
            <span class="bg-yellow-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' .  $weight . '</span></div>';
                 return $tb;
              })

             // ->editColumn('status', function ($data) {
             //    $status = statusProduk($data->status);
             //   return $status;
             //  })

                 ->addColumn('change', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('product::products.transfer.change',
                            compact('module_name', 'data', 'module_model'));
                      })

                ->addColumn('status', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('product::products.transfer.approve',
                            compact('module_name', 'data', 'module_model'));
                      })

                ->addColumn('lokasi', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('product::products.transfer.lokasi',
                            compact('module_name', 'data', 'module_model'));
                      })

                 ->filter(function ($instance) use ($request) {
                         if (!empty($request->get('location_id'))) {
                            $locations = $request->get('location_id');
                      }

                    })

           ->rawColumns(['updated_at','product_image','weight','status','lokasi',
            'product_name','product_quantity','product_price', 'action'])
           ->make(true);
    }


    public function create() {
        abort_if(Gate::denies('access_product_transfer'), 403);
        return view('product::products.create');
    }


    public function createModal() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        abort_if(Gate::denies('access_product_transfer'), 403);
         return view(''.$module_path.'::'.$module_name.'.modal.index',
           compact('module_name',
                    'module_title',
                    'module_icon', 'module_model'));
    }


 public function approveModal(Request $request ,$id) {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $detail = $module_model::findOrFail($id);
        abort_if(Gate::denies('access_approve_product'), 403);
         return view(''.$module_path.'::'.$module_name.'.modal.approve',
           compact('module_name',
                    'module_title',
                    'detail',
                    'module_icon', 'module_model'));
    }



    public function add_products_modal_categories(Request $request ,$id) {
        abort_if(Gate::denies('access_product_transfer'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();
        $locations = Locations::where('name','LIKE','%Tempo%')->first();
        $code = Product::generateCode();
        $module_action = 'List';
          return view(''.$module_path.'::'.$module_name.'.modal.create',
           compact('module_name',
                    'module_title',
                    'category',
                    'locations',
                    'code',
                    'module_icon', 'module_model'));
    }




    public function webcam() {
        abort_if(Gate::denies('access_product_transfer'), 403);

        return view('product::products.webcam');
    }


    public function store(Request $request) {
         $params = $request->all();
         $params = $request->except('_token');
         dd($params);
        $product = Product::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }




//store ajax version

public function saveAjax(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(),[
             'product_code'     => 'required|max:255|unique:'.$module_model.',product_code',
             'category_id'      => 'required',
             'gold_kategori_id' => 'required',
             'product_name'     => 'required|max:255',
             'product_price'    => 'required|max:2147483647',
             'product_sale'     => 'required|max:2147483647',


        ]);

        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->except('_token');
        $input = $request->all();
        $input['product_price'] = preg_replace("/[^0-9]/", "", $input['product_price']);
        $input['product_cost'] = preg_replace("/[^0-9]/", "", $input['product_cost']);
        $input['product_sale'] = preg_replace("/[^0-9]/", "", $input['product_sale']);
        //dd($input);
          $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
          $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
          $product_sale = preg_replace("/[^0-9]/", "", $input['product_sale']);
          $$module_name_singular = $module_model::create([
            'category_id'                       => $input['category_id'],
            'product_stock_alert'               => $input['product_stock_alert'],
            'product_name'                      => $input['product_name'],
            'product_code'                      => $input['product_code'],
            'product_price'                     => $product_price,
            'product_quantity'                  => $input['product_quantity'],
            'product_barcode_symbology'         => $input['product_barcode_symbology'],
            'product_unit'                      => $input['product_unit'],
            'status'                            => 2,
            'product_cost'                      => $product_cost
             ]);

               if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('local')->put($file,$image_base64);
                $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))
                ->toMediaCollection('images');
                }

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
             $$module_name_singular->addMediaFromRequest('document')
             ->toMediaCollection('images');
        }

            $produk = $$module_name_singular->id;
            $this->_saveProductsItem($input ,$produk);
            return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
    }





  public function save(Request $request)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_item = $this->module_item;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        $input = $request->all();
        $input = $request->except(['document']);
        $input['product_price'] = preg_replace("/[^0-9]/", "", $input['product_price']);
        $input['product_cost'] = preg_replace("/[^0-9]/", "", $input['product_cost']);
         //dd($input);
          $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
          $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
          $$module_name_singular = $module_model::create([
            'category_id'                       => $input['category_id'],
            'product_stock_alert'               => $input['product_stock_alert'],
            'product_name'                      => $input['product_name'],
            'product_code'                      => $input['product_code'],
            'product_price'                     => $product_price,
            'product_quantity'                  => $input['product_quantity'],
            'product_barcode_symbology'         => $input['product_barcode_symbology'],
            'product_unit'                      => $input['product_unit'],
            'product_cost'                      =>  $product_cost
        ]);

            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('local')->put($file,$image_base64);
                $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))->toMediaCollection('images');
                    //$params['image'] = "$newFilename";
                }


              if ($request->has('document')) {
                    foreach ($request->input('document', []) as $file) {
                        $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                    }
                }

                 $produk = $$module_name_singular->id;
                 $this->_saveProductsItem($input ,$produk);
                 toast('Product Created!', 'success');

             return redirect()->route('products.index');
    }




    private function _saveProductsItem($input ,$produk)
    {

          $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
          $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
          $product_sale = preg_replace("/[^0-9]/", "", $input['product_sale']);
          $gudang = Gudang::latest()->limit(1)->first()->id;

       ProductItem::create([
            'product_id'                  => $produk,
            'location_id'                 => $input['location_id'] ?? null,
            'parameter_berlian_id'        => $input['parameter_berlian_id'] ?? null,
            'jenis_perhiasan_id'          => $input['jenis_perhiasan_id'] ?? null,
            'customer_id'                 => $input['customer_id'] ?? null,
            'karat_id'                    => $input['karat_id'] ?? null,
            'gold_kategori_id'            => $input['gold_kategori_id'] ?? null,
            'certificate_id'              => $input['certificate_id'] ?? null,
            'shape_id'                    => $input['shape_id'] ?? null,
            'round_id'                    => $input['round_id'] ?? null,
            'product_cost'                => $product_cost,
            'product_price'               => $product_price,
            'product_sale'                => $product_sale,
            'berat_emas'                  => $input['berat_emas'],
            'berat_label'                 => $input['berat_label'],
            'gudang_id'                   => $gudang ?? null,
            'supplier_id'                 => $input['supplier_id'] ?? null,
            'etalase_id'                  => $input['etalase_id'] ?? null,
            'baki_id'                     => $input['baki_id'] ?? null,
            'berat_total'                 => $input['berat_total']
        ]);
       //dd($input);
      }


    public function detail($id) {
        abort_if(Gate::denies('show_product_transfer'), 403);

        $product = Product::find($id);
        $stock = ProductLocation::join('locations','locations.id','product_locations.location_id')
                ->where('product_id',$id)->first();
        $tracking = TrackingProduct::with('products','location','user')
                ->where('product_id',$id)->get();
        return view('product::products.transfer.show', compact('product','stock','tracking'));
    }






//approve produts  masih error
// dari transfer ke gudang utama

public function ApproveProducts(Request $request, $id)
    {
        abort_if(Gate::denies('access_approve_product'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = Product::findOrFail($id);
        $tracking = TrackingProduct::where('product_id',$id)->first();
        $validator = \Validator::make($request->all(),[
             'status' => 'required',

        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        //$input = $request->all();
       // dd($input);
        $input = $request->except('_token');
        $input['status'] = $input['status'];
        $input['note']   = $input['note'];
        // $input['location_id']   = $input['location_id'];
         $$module_name_singular->update([
            'status'      =>  $input['status'],
          ]);
          $status   = pStatus($input['status']);
          $loc = ProductLocation::where('product_id', $$module_name_singular->id)->first();
         //Tracking Approve Products
             TrackingProduct::create([
                'location_id' =>  $loc->location_id,
                'product_id'  =>  $id,
                'username'    =>  auth()->user()->name,
                'user_id'     =>  auth()->user()->id,
                'status'      =>   $input['status'],
                'note'  =>   'Barang di <strong>'.$status.'</strong>  oleh '.auth()->user()->name.' '.$input['note'].' ',
              ]);

            return response()->json(['success'=>'  '.$module_title.' Sukses di Approve.']);

 }





    public function edit(Product $product) {
        abort_if(Gate::denies('edit_product_transfer'), 403);
        return view('product::products.edit', compact('product'));
    }


    public function update(Request $request, Product $product) {
        $product->update($request->except('document'));

        if ($request->has('document')) {
            if (count($product->getMedia('images')) > 0) {
                foreach ($product->getMedia('images') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $product->getMedia('images')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                }
            }
        }

        toast('Product Updated!', 'info');

        return redirect()->route('products.index');
    }


 public function getone($id){
        $product = Product::find($id);
        $stock = ProductLocation::join('locations','locations.id','product_locations.location_id')
                ->where('type','storefront')->where('product_id',$id)->first();
        return response()->json([
            'product' => $product,
            'stock' => $stock
        ]);
    }
          public function type(Request $request) {
                $type = $request->type;
                //dd($type);
                abort_if(Gate::denies('access_product_transfer'), 403);
                Cart::instance('purchase')->destroy();
                    if ($type == 'NonMember') {
                     return view('product::products.transfer.type.member');
                    }
                     elseif ($type == 'toko') {
                      return view('product::products.transfer.type.toko');
                    }
                    else {
                         return view('product::products.transfer.type.index');
                    }

            }


    public function destroy(Product $product) {
        abort_if(Gate::denies('access_product_transfer'), 403);
        $product->delete();
        toast('Product Deleted!', 'warning');
        return redirect()->route('products.index');
    }
}
