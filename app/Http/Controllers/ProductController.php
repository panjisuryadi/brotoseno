<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Supplier;
use DateTime;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Category;
use Modules\Group\Models\Group;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Stok\Models\StockOffice;
use App\Models\Harga;
use App\Models\Baki;
use App\Models\StockOpname;
use Yajra\DataTables\DataTables;
use App\Models\ProductHistories;
use Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_categories;
    private $module_products;
    private $code;

    public function __construct()
    {
        // $opname = StockOpname::check_opname();
        // if($opname == 'A'){
        //     abort(403, 'Access denied during active stock opname.');
        // }
        $this->module_title = 'Products';
        $this->module_name = 'products';
        $this->module_path = 'product';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Product\Entities\Product";
        $this->module_item = "Modules\Product\Entities\ProductItem";
        $this->module_categories = "Modules\Product\Entities\Category";
        $this->module_pembelian = "Modules\GoodsReceipt\Models\GoodsReceipt";
        // $this->module_title = 'Product';
        // $this->module_name = 'Product';
        // $this->module_path = 'Products';
        // $this->module_icon = 'fas fa-sitemap';
        // $this->module_model = "Modules\Product\Models\Product";
    }
    
    public function insert(Request $request)
    {
        $i = 0;
        // echo json_encode($_POST);
        // exit();
        $group  = Group::where('id', $request->new_product_group_id)->first();
        $group_name = $group->name;
        $model  = ProdukModel::where('id', $request->new_product_model_id)->first();
        $model_name = $model->name;
        $product_name   = $group_name.' '.$model_name;
        $product    = Product::create([
            'category_id'       => $request->new_product_category_id,
            'product_code'       => $request->new_product_code_id,
            'product_name'       => $product_name,
            'product_barcode_symbology'       => 'C128',
            'product_unit'       => 'Gram',
            'product_stock_alert'       => 5,
            'status'       => 0,
            'images'       => 'jpg',
            'berat_emas'       => $request->new_product_gold_weight,
            'product_price'       => 0,
            'status_id'       => 11,
            'group_id'       => $request->new_product_group_id,
            'model_id'       => $request->new_product_model_id,
            'goodreceipt_item_id' => 0,
            'is_nota' => false,
        ]);

        $productItem    = ProductItem::create([
            'product_id'       => $product->id,
            'berat_total'       => $request->new_product_total_weight,
            'berat_emas'       => $request->new_product_gold_weight,
            'berat_accessories'       => $request->new_product_accessories_weight,
            'tag_label'       => 0,
            'berat_label'       => 0,
        ]);

        // $product    = Harga::create([
        //     'tanggal'   => date('Y-m-d'),
        //     'harga'     => $request->harga,
        //     'user'      => 1,
        // ]);

        return redirect()->action([ProductController::class, 'list']);
    }

    public function insert_luar(Request $request)
    {
        $doc    = isset($request['document'][0]) ? $request['document'][0] : '';
        if(empty($doc) && empty($request['webcam'])){
            toast('Image Required', 'error');
            return redirect()->back();
        }
        $gam                     = $this->getUploadedImage($request['webcam'], $doc);
        if(!empty($gam)){
            $gambar = $gam;
        }
        $i = 0;
        // echo json_encode($_POST);
        // exit();
        $group  = Group::where('id', $request->new_product_group_id)->first();
        $group_name = $group->name;
        $model  = ProdukModel::where('id', $request->new_product_model_id)->first();
        $model_name = $model->name;
        $product_name   = $group_name.' '.$model_name;
        $product    = Product::create([
            'category_id'       => $request->new_product_category_id,
            'product_code'       => $request->new_product_code_id,
            'product_name'       => $product_name,
            'product_price'       => $request->new_product_harga,
            'product_barcode_symbology'       => 'C128',
            'product_unit'       => 'Gram',
            'product_stock_alert'       => 5,
            'status'       => 3,
            'images'       => $gam,
            'berat_emas'       => $request->new_product_berat,
            'status_id'       => 3,
            'group_id'       => $request->new_product_group_id,
            'model_id'       => $request->new_product_model_id,
            'goodreceipt_item_id' => 0,
            'is_nota' => false,
        ]);

        $productItem    = ProductItem::create([
            'product_id'       => $product->id,
            'berat_total'       => $request->new_product_total_weight,
            'berat_emas'       => $request->new_product_gold_weight,
            'berat_accessories'       => $request->new_product_accessories_weight,
            'tag_label'       => 0,
            'berat_label'       => 0,
        ]);

        $product_history = ProductHistories::create([
            'product_id'    => $product->id,
            'status'        => 'P',
            'keterangan'    => $request->new_product_keterangan,
            'harga'         => $request->new_product_harga,
            'tanggal'       => date('Y-m-d'),
        ]);

        return redirect()->action([ProductController::class, 'list_luar']);
    }

    public function insert_nota(Request $request)
    {
        // echo $gam;
        // echo json_encode($_POST);
        // exit();
        $doc    = isset($request['document'][0]) ? $request['document'][0] : '';
        if(empty($doc) && empty($request['webcam'])){
            toast('Image Required', 'error');
            return redirect()->back();
        }
        $gam                     = $this->getUploadedImage($request['webcam'], $doc);
        if(!empty($gam)){
            $gambar = $gam;
        }
        
        $i = 0;
        $group  = Group::where('id', $request->new_product_group_id)->first();
        $group_name = $group->name;
        $model  = ProdukModel::where('id', $request->new_product_model_id)->first();
        $model_name = $model->name;
        $product_name   = $group_name.' '.$model_name;

        // IMAGE
        // if ($image = $request->file('image')) {
        //     $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
        //     $normal = Image::make($image)->resize(600, null, function ($constraint) {
        //                $constraint->aspectRatio();
        //                })->encode();
        //     $normalpath = 'uploads/' . $gambar;
        //     if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
        //     Storage::disk($storage)->put($normalpath, (string) $normal);
        //     // $params['image'] = "$gambar";
        //     $gambar = $gambar;
        // }else{
        //     $gambar = 'no_foto.png';
        //     // $params['image'] = 'no_foto.png';
        // }
        // $gambar = 'products_20250522095614.png';

        $berat  = str_replace(',', '.', $request->new_product_berat);

        $product    = Product::create([
            'category_id'       => $request->new_product_category_id,
            'product_code'       => $request->new_product_code_id,
            'product_name'       => $product_name,
            'product_price'       => 0,
            'product_barcode_symbology'       => 'C128',
            'product_unit'       => 'Gram',
            'karat_id'       => $request->new_product_karat_id,
            'product_stock_alert'       => 5,
            'status'       => 4, // brankas
            'images'       => $gambar,
            'berat_emas'       => $berat,
            'status_id'       => 4, // brankas
            'group_id'       => $request->new_product_group_id,
            'model_id'       => $request->new_product_model_id,
            'goodreceipt_item_id' => 0,
            'is_nota' => false,
        ]);

        $productItem    = ProductItem::create([
            'product_id'       => $product->id,
            'berat_total'       => $berat,
            // 'berat_emas'       => $request->new_product_gold_weight,
            'berat_emas'       => $berat,
            'berat_accessories'       => $request->new_product_accessories_weight,
            'tag_label'       => 0,
            'berat_label'       => 0,
        ]);

        $product_history = ProductHistories::create([
            'product_id'    => $product->id,
            'status'        => 'P',
            'keterangan'    => $request->new_product_keterangan,
            'harga'         => 0,
            'tanggal'       => date('Y-m-d'),
        ]);

        return redirect()->action([ProductController::class, 'list_nota']);
    }

    public function update(Request $request)
    {
        $harga = Harga::where('tanggal', date('Y-m-d'))->firstOrFail();
        $harga->harga = $request->harga;
        $harga->save();

        return redirect()->action([KaratController::class, 'list']);
    }

    public function update_pending(Request $request)
    {   
        // echo json_encode($_POST);
        // exit();
        $id = $request->id;
        // UPDATE STATUS PRODUCT
        $products   = Product::where('id', $id)->firstOrFail();
        $products->status_id   = $request->status;
        if($request->status == 1){
            $products->baki_id   = $request->baki;
        }
        $products->save();
        // INSERT HISTORY
        $stat[1] = 'O';
        $stat[2] = 'S';
        $stat[3] = 'P';
        $stat[4] = 'B';
        $stat[5] = 'C';
        $stat[6] = 'M';
        $stat[7] = 'K';
        $stat[8] = 'R';
        $stat[9] = '2';
        $stat[10] = 'L';
        $stat[11] = 'D';
        $stat[12] = 'W';
        $stat[13] = 'F';
        $stat[14] = 'N';
        $stat[15] = 'H';
        // $stat[1] = 'L';
        $product_history = ProductHistories::create([
            'product_id'    => $id,
            'status'        => $stat[$request->status],
            'keterangan'    => 'update dari pending',
            'harga'         => $request->harga ?? 0,
            'tanggal'       => date('Y-m-d'),
        ]);

        return redirect()->action([ProductController::class, 'list_pending']);
    }

    public function update_all(Request $request)
    {   
        // echo json_encode($_POST);
        // exit();
        $id = $request->id;
        // UPDATE STATUS PRODUCT
        $products   = Product::where('id', $id)->firstOrFail();
        $products->status_id   = $request->status;
        $products->baki_id   = $request->baki;
        $products->save();
        // INSERT HISTORY
        $stat[1] = 'O';
        $stat[8] = 'R';
        $stat[2] = 'S';
        $stat[15] = 'H';
        // $stat[1] = 'L';
        $product_history = ProductHistories::create([
            'product_id'    => $id,
            'status'        => $stat[$request->status],
            'keterangan'    => 'update dari all product',
            'harga'         => $request->harga ?? 0,
            'tanggal'       => date('Y-m-d'),
        ]);

        return redirect()->action([ProductController::class, 'list_all']);
    }

    public function update_status(Request $request)
    {   
        // echo json_encode($_POST);
        // exit();
        $id = $request->id;
        $product = $request->product;
        // UPDATE STATUS PRODUCT
        $products   = Product::where('id', $id)->firstOrFail();
        $products->status   = $request->status;
        $products->save();
        // INSERT HISTORY
        $stat[1] = 'O';
        $stat[8] = 'R';
        $stat[2] = 'S';
        $stat[15] = 'H';
        // $stat[1] = 'L';
        $product_history = ProductHistories::create([
            'product_id'    => $id,
            'status'        => $stat[$request->status],
            'keterangan'    => 'update dari '.$product,
            'harga'         => $request->harga ?? 0,
            'tanggal'       => date('Y-m-d'),
        ]);

        return redirect()->action([ProductController::class, 'list_'.$product]);
    }   

    public function list_luar(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'products.list_luar', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_nota(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'products.list_nota', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_pending(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'products.list_pending', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_reparasi(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'products.list_reparasi', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function list_cuci(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'products.list_cuci', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function update_baki(Request $request){
        $id     = $request->id;
        $product    = $request->product;
        // echo $id;
        // echo $product;
        // echo json_encode($_GET);
        // exit();

        // CEK KAPASITAS BAKI
        $stat   = 4;
        $baki   = Baki::where('id', $id)->firstOrFail();
        $posisi = $baki->posisi;
        $capacity = $baki->capacity;
        if($posisi == 'etalase'){
            $stat   = 1;
        }
        $product_count = Product::where('baki_id', $id)->where('status', 1)->where('status_id', 1)->count();

        if($capacity <= $product_count){
            toast('Kapasitas baki penuh', 'error');
            return redirect()->back();
            // return redirect()->route('products.baki', ['id' => $id])
            // ->with('error', 'Kapasitas Baki');
        }


        $products   = Product::where('id', $product)->firstOrFail();
        $products->baki_id   = $id;
        $products->status   = $stat;
        $products->status_id   = 1;
        $products->save();
        // INSERT HISTORY
       
        // $stat[1] = 'L';
        $product_history = ProductHistories::create([
            'product_id'    => $id,
            'status'        => 'X',
            'keterangan'    => 'update baki '.$id,
            'harga'         => $request->harga ?? 0,
            'tanggal'       => date('Y-m-d'),
        ]);
        return redirect()->route('products.baki', ['id' => $id]);

        // return redirect()->action([ProductController::class, 'list_baki'.$product]);
    }

    public function list_baki(Request $request)
    {
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $baki   = Baki::findorFail($id);
        return view(
            'products.list_baki', // Path to your create view file
            compact(
                'id',
                'baki',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function list_lebur(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'products.list_lebur', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function list_gudang(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'products.list_gudang', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function delete_product(Request $request)
    {
        $id = $request->id;
        $product = Product::where('id', $id)->first();

        if ($product) {
            $product->delete();
            return redirect()->action([ProductController::class, 'list_nota']);
        } else {
            return redirect()->action([ProductController::class, 'list_nota']);
        }
    }

    public function update_new(){

    }

    public function edit($id)
    {
        $detail = Product::findOrFail($id);
        return view('product'.'modal_edit',
            compact(
                'detail',
            )
        );
    }

    public function index_baki(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', 1);
        }
        
        $$module_name->where('status', $id)->get();
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; 
        });
        $data = $$module_name;

        $stat[8] = 'reparasi';
        $stat[5] = 'cuci';
        $stat[6] = 'lebur';
        $stat[4] = 'gudang';

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $id = $data->status_id;
                $stat[8] = 'reparasi';
                $stat[5] = 'cuci';
                $stat[6] = 'lebur';
                $stat[4] = 'gudang';
                return view(
                    'product::products.partials.'.$stat[$id],
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'berat_emas', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function index_datas(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item', 'baki');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        if($id == 0){

        }else{
            $$module_name->where('status_id', $id)->get();
        }
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; 
        });
        $data = $$module_name;
        // echo json_encode($data);
        // exit();

        $stat[8] = 'reparasi';
        $stat[5] = 'cuci';
        $stat[6] = 'lebur';
        $stat[4] = 'gudang';

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $id = $data->status_id;
                $stat[4] = 'gudang';
                $stat[4] = 'gudang';
                $stat[4] = 'gudang';
                $stat[4] = 'gudang';
                $stat[4] = 'gudang';
                $stat[5] = 'cuci';
                $stat[6] = 'lebur';
                $stat[8] = 'reparasi';
                return view(
                    'product::products.partials.'.$stat[8],
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->addColumn('baki', function ($data) {
                $baki   = !empty($data->baki->name) ? $data->baki->name : '-';
                return $baki;
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'berat_emas', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function list(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'products.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_all(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'products.list_all', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_emas(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'products.list_all', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function data_pending(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item');
        $$module_name = $$module_name->where('status_id', 3);
        // $$module_name->where('status', 3)->get();
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $baki   = Baki::latest()->get();
                return view(
                    'product::products.partials.pending',
                    compact('module_name', 'data', 'module_model', 'baki')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status_v2', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'berat_emas', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function dataluar(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item', 'product_history');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        if($id == 1){ // with nota
            $$module_name->where('is_nota', true)->get();
        }
        if($id == 2){ // without nota
            $$module_name->where('is_nota', false)->get();
        }
        $$module_name->where('product_price', '>', 0)->get();

        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('code', function ($data) {
                return $data->product_code;
            })
            ->editColumn('keterangan', function ($data) {
                return $data->product_history->keterangan ?? '';
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->editColumn('berat_emas', function ($data) {
                return $data->berat_emas;
            })
            ->rawColumns([
                'created_at', 'product_image', 'keterangan', 'code', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'berat_emas', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function datanota(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item', 'baki');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        if($id == 1){ // with nota
            $$module_name->where('is_nota', true)->get();
        }
        if($id == 2){ // without nota
            $$module_name->where('is_nota', false)->get();
        }
        $$module_name->where('product_price', '=', 0)->get();
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;
        // echo $data;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('delete', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.delete',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->addColumn('qr', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('code', function ($data) {
                return $data->product_code;
            })
            ->editColumn('keterangan', function ($data) {
                return $data->product_history->keterangan ?? '';
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->editColumn('berat_emas', function ($data) {
                return $data->berat_emas;
            })
            ->rawColumns([
                'created_at', 'product_image', 'keterangan', 'code', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'berat_emas', 'cabang', 'action'
            ])
            ->make(true);
        }

        private function getUploadedImage($image, $uploaded_image)
        {
            $folderPath = "uploads/";
            if (!empty($uploaded_image)) {
                Storage::disk('public')->move("temp/dropzone/{$uploaded_image}", "{$folderPath}{$uploaded_image}");
                return $uploaded_image;
            } elseif (!empty($image)) {
                $image_parts = explode(";base64,", $image);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'webcam_' . uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file, $image_base64);
                return $fileName;
            }
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
        $$module_name = $module_model::with('category', 'product_item');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        $$module_name = $$module_name->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }
}
