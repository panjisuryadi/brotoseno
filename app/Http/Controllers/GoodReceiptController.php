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
use Yajra\DataTables\DataTables;

class GoodReceiptController extends Controller
{
    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_categories;
    private $module_products;
    private $code;
    //
    public function create()
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $code = $this->code;
        // $module_name_singular = Str::singular($module_name);
        // $code = $module_model::generateCode();
        $module_action = 'Create';
        abort_if(Gate::denies('create_goodsreceipts'), 403);
        $lastGoodsReceipt = GoodsReceipt::getLastInserted();
        $last_po    = $lastGoodsReceipt->code;
        $last_po    = explode('-', $last_po);
        $last_po    = (int)$last_po[1];
        $last_po    = $last_po+1;
        $count      = strlen($last_po);
        for ($i=0; $i < 5; $i++) { 
            if($count == 5){

            }else{
                $last_po  = '0'.$last_po;
            }
            $count++;
        }
        $last_po    = 'PO-'.$last_po;
        $dataSupplier = Supplier::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $inputs = [
            [
                'karat_id' => '',
                'berat_real' => 0,
                'berat_kotor' => 0
            ]
        ];
        $tipe_pembayaran    = 'lunas';
        return view(
            'goodsreceipts.creates', // Path to your create view file
            compact(
                'dataSupplier',
                'last_po',
                'hari_ini',
                'inputs',
                'dataKarat',
                'tipe_pembayaran',
                'module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function tambah()
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $code = $this->code;
        // $module_name_singular = Str::singular($module_name);
        // $code = $module_model::generateCode();
        $module_action = 'Tambah';
        abort_if(Gate::denies('tambah_goodsreceipts'), 403);

        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        $inputs = [
            [
                'karat_id' => '',
                'berat_real' => 0,
                'berat_kotor' => 0
            ]
        ];
        $tipe_pembayaran    = 'lunas';
        return view(
            'goodsreceipts.products', // Path to your create view file
            compact(
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                'inputs',
                'dataKarat',
                'tipe_pembayaran',
                'module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    private function _saveTipePembelian($input, $goodsreceipt)
    {
        $tipe_pembayaran = TipePembelian::create([
            'goodsreceipt_id'             => $goodsreceipt,
            'tipe_pembayaran'             => $input['tipe_pembayaran'] ?? null,
            'jatuh_tempo'                 => $input['tgl_jatuh_tempo'] ?? null,
            'cicil'                       => $input['cicil'] ?? 0,
            'lunas'                       => $input['lunas'] ?? null,
        ]);

        if ($tipe_pembayaran->isCicil()) {
            foreach ($input['detail_cicilan'] as $key => $value) {
                GoodsReceiptInstallment::create([
                    'payment_id' => $tipe_pembayaran->id,
                    'nomor_cicilan' => $key,
                    'tanggal_cicilan' => $input['detail_cicilan'][$key]
                ]);
            }
        }
    }

    private function _saveGoodsReceiptItem($items, $goodsreceipt, $kategori_produk_id)
    {
        foreach ($items as $i) {
            // echo $i->karat.PHP_EOL;
            // echo json_encode($i);
            $karat_id   = $i->karat;
            // echo $karat_id;
            // $coef       = Karat::where('id', $karat_id);
            $coef       = Karat::where('id', $karat_id)->first();

            // echo json_encode($coef);

            $item = GoodsReceiptItem::create([
                'goodsreceipt_id' => $goodsreceipt->id,
                'karat_id' => $i->karat,
                'kategoriproduk_id' => $kategori_produk_id,
                'qty' => $i->quantity,
                'karatberlians' => $coef->coef,
                'berat_real' => $i->real,
                'berat_kotor' => $i->kotor
            ]);
            $stock_office = StockOffice::where('karat_id', $item['karat_id'])->first();
            if (is_null($stock_office)) {
                $stock_office = StockOffice::create(['karat_id' => $item['karat_id']]);
            }
            $item->stock_office()->attach($stock_office->id, [
                'karat_id' => $item['karat_id'],
                'in' => true,
                'berat_real' => $i->real,
                'berat_kotor' => $i->kotor
            ]);
            $berat_real = $stock_office->history->sum('berat_real');
            $berat_kotor = $stock_office->history->sum('berat_kotor');
            $stock_office->update(['berat_real' => $berat_real, 'berat_kotor' => $berat_kotor]);
        }
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

    public function qr_data(Request $request)
    {
        $id     = $request->id;
        $goodsreceipt   = GoodsReceipt::where('id', $id)->first();
        $goodsreceipt_item   = GoodsReceiptItem::where('goodsreceipt_id', $id)->get();
        $array  = array();
        foreach($goodsreceipt_item as $g){
            $array[] = $g->id;
        }
        // echo json_encode($goodsreceipt_item);
        // echo json_encode($array);
        // exit();

        $module_title = 'Products';
        $module_name = 'products';
        $module_path = 'product';
        $module_icon = 'fas fa-sitemap';
        $module_model = 'Modules\Product\Entities\Product';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $data_product = $module_model::with('category', 'product_item');
        if ($request->get('status')) {
            $data_product = $data_product->where('status_id', $request->get('status'));
        }
        $data_product = $data_product->whereIn('goodreceipt_item_id', $array)->latest()->get();
        // $data_product = $data_product->latest()->get();
        // echo json_encode($data_product);
        // exit();
        $data = $data_product;

        return Datatables::of($data_product)
            ->addColumn('action', function ($data) {
                $module_name = 'products';
                $module_model = 'Modules\Product\Entities\Product';
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>

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

            ->editColumn('berat_emas', function ($data) {
                return number_format($data->berat_emas);
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

    public function qr(Request $request)
    {
        $id = $request->id;
        $goodsreceipt = GoodsReceipt::where('id', $id)->first();  
        $product_categories = Category::all();  
        $groups = Group::all();  
        $models = ProdukModel::all(); 
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'GoodsReceipts.qr', // Path to your create view file
            compact(
                'id',
                'goodsreceipt',
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

    public function detail(Request $request){
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $code = $this->code;
        // $module_name_singular = Str::singular($module_name);
        // $code = $module_model::generateCode();
        $module_action = 'Tambah';
        $id         = $request->id;
        abort_if(Gate::denies('tambah_goodsreceipts'), 403);
        $products   = GoodsReceiptItem::where('goodsreceipt_id', $request->id)->get();
        $input      = GoodsReceipt::where('id', $request->id)->first();
        $supplier   = Supplier::where('id', $input->supplier_id)->first();
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        
        $tipe_pembayaran    = 'lunas';

        return view(
            'goodsreceipts.products', // Path to your create view file
            compact(
                'id',
                'products',
                'supplier',
                'input',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                'dataKarat',
                'tipe_pembayaran',
                'module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function product_update(Request $request){
        $id = $request->id;
        $hitung     = count($request->category);
        for ($i=0; $i < $hitung; $i++) { 
            $group  = Group::where('id', $request->group[$i])->first();
            $group_name = $group->name;
            $model  = ProdukModel::where('id', $request->model[$i])->first();
            $model_name = $model->name;
            $product_name   = $group_name.' '.$model_name;

            $product    = Product::create([
                'category_id'       => $request->category[$i],
                'product_code'       => $request->code[$i],
                'product_name'       => $product_name,
                'product_barcode_symbology'       => 'C128',
                'product_unit'       => 'Gram',
                'product_stock_alert'       => 5,
                'status'       => 0,
                'images'       => 'jpg',
                'berat_emas'       => $request->total[$i],
                'product_price'       => 0,
                'status_id'       => 11,
                'group_id'       => $request->group[$i],
                'model_id'       => $request->model[$i],
                'goodreceipt_item_id' => $id
            ]);

            $productItem    = ProductItem::create([
                'product_id'       => $product->id,
                'berat_total'       => $request->total[$i],
                'berat_emas'       => $request->emas[$i],
                'berat_accessories'       => $request->acc[$i],
                'tag_label'       => $request->tag[$i],
                'berat_label'       => 0,
            ]);
        }
        
        $goodsReceiptItem = GoodsReceiptItem::findOrFail($id);
        $idnya  = $goodsReceiptItem['goodsreceipt_id'];
        $goodsReceiptItem->status = 2;
        $goodsReceiptItem->save();

        return redirect()->action([GoodReceiptController::class, 'detail'], ['id' => $idnya]);
    }

    public function products(Request $request){
        $id = $request->id;

        $products  = GoodsReceiptItem::where('id', $id)->get();
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $groups = Group::all();  // Assuming Supplier model is set up
        $karats = Karat::where('id', $products[0]->karat_id)->first();
        $nama   = $karats->name;
        return view(
            'goodsreceipts.detail', // Path to your create view file
            compact(
                'id',
                'products',
                'nama',
                // 'supplier',
                'product_categories',
                'groups',
                'models',
                // 'isLogamMulia',
                // 'hari_ini',
                'dataKarat',
                // 'tipe_pembayaran',
                // 'module_name',
                // 'module_action',
                // 'code',
                // 'module_title',
                // 'module_icon',
                // 'module_model'
            )
        );
    }

    public function insert(Request $request)
    {
        // echo json_encode($_POST);
        // echo json_encode($_FILES);
        // echo json_encode($_GET);
        // exit();
        $products = array();
        $hitung = count($_POST['karat_id']);
        for ($i = 0; $i < $hitung; $i++) {
            $products[$i] = (object)[
                'karat' => $_POST['karat_id'][$i],
                'kotor' => $_POST['berat_kotor'][$i],
                'real' => $_POST['berat_real'][$i],
                'quantity' => $_POST['quantity'][$i]
            ];
        }
        $kategori_produk_id = KategoriProduk::whereSlug('gold')->value('id');
        $input = $request->except('_token', 'document');
        // echo json_encode($input);
        $goodsreceipt = GoodsReceipt::create([
            'code'                       => $input['code'],
            'no_invoice'                 => $input['no_invoice'],
            'date'                       => $input['tanggal'],
            'status'                     => 0, // inputed need to input product to be 1
            'karat_id'                   => null,
            'tipe_pembayaran'            => $input['tipe_pembayaran'],
            'supplier_id'                => $input['supplier_id'],
            'user_id'                    => 1,
            // 'user_id'                    => $input['pic_id'],
            'total_berat_kotor'          => $input['total_berat_kotor'],
            'total_bayar'                => $input['yang_harus_dibayar'],
            'total_qty'                  => $input['total_qty'],
            'berat_timbangan'            => !empty($input['berat_timbangan']) ? $input['berat_timbangan'] : 0,
            'selisih'                    => $input['selisih'] ?? null,
            'total_emas'                 => $input['total_berat_real'],
            'note'                       => $input['catatan'],
            'harga_beli'                 => !empty($input['harga_beli']) ? $input['harga_beli'] : 0,
            'count'                      => 0,
            'qty'                        => '8',
            'kategoriproduk_id'          => $kategori_produk_id,
            'pengirim'                   => $input['pengirim'],
            'images'                     => 'jpg',
            // 'images'                     => $this->getUploadedImage($input['image'], $input['uploaded_image'])
        ]);
        $goodsreceipt_id = $goodsreceipt->id;
        $this->_saveTipePembelian($input, $goodsreceipt_id);
        $this->_saveGoodsReceiptItem($products, $goodsreceipt, $kategori_produk_id);
        return redirect('/goodsreceipt');
        // http://localhost:8000/goodsreceipt
        // return redirect()->action([GoodReceiptController::class, 'detail'], ['id' => $goodsreceipt_id]);
    }

    public function sukses($id){
        $goodsreceipt   = GoodsReceipt::where('id', $id)->firstOrFail();
        $goodsreceipt->status = 0;
        $goodsreceipt->save();
        return redirect()->action([ProductController::class, 'list_pembelian']);
    }

    public function insert_2(Request $request)
    {
        $kategori_produk_id = KategoriProduk::whereSlug('gold')->value('id');
        $input = $request->except('_token', 'document');
        // echo json_encode($input);
        $goodsreceipt = GoodsReceipt::create([
            'code'                       => $input['code'],
            'no_invoice'                 => $input['no_invoice'],
            'date'                       => $input['tanggal'],
            'status'                     => 0,
            'karat_id'                   => null,
            'tipe_pembayaran'            => $input['tipe_pembayaran'],
            'supplier_id'                => $input['supplier_id'],
            'user_id'                    => 1,
            // 'user_id'                    => $input['pic_id'],
            'total_berat_kotor'          => $input['total_berat_kotor'],
            'total_bayar'                => $input['yang_harus_dibayar'],
            'total_qty'                  => $input['total_qty'],
            'berat_timbangan'            => !empty($input['berat_timbangan']) ? $input['berat_timbangan'] : 0,
            'selisih'                    => $input['selisih'] ?? null,
            'total_emas'                 => $input['total_berat_real'],
            'note'                       => $input['catatan'],
            'harga_beli'                 => !empty($input['harga_beli']) ? $input['harga_beli'] : 0,
            'count'                      => 0,
            'qty'                        => '8',
            'kategoriproduk_id'          => $kategori_produk_id,
            'pengirim'                   => $input['pengirim'],
            'images'                     => 'jpg',
            // 'images' => $this->getUploadedImage($input['image'], $input['uploaded_image'])
        ]);
        $goodsreceipt_id = $goodsreceipt->id;
        $this->_saveTipePembelian($input, $goodsreceipt_id);
        // $this->_saveGoodsReceiptItem($input, $goodsreceipt, $kategori_produk_id);
        // exit();

        $products = array();
        $hitung = count($_POST['karat_id']);
        for ($i = 0; $i < $hitung; $i++) {
            $products[$i] = (object)[
                'karat' => $_POST['karat_id'][$i],
                'kotor' => $_POST['berat_kotor'][$i],
                'real' => $_POST['berat_real'][$i],
                'quantity' => $_POST['quantity'][$i]
            ];
        }

        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $code = $this->code;
        // $module_name_singular = Str::singular($module_name);
        // $code = $module_model::generateCode();
        $module_action = 'Tambah';
        abort_if(Gate::denies('tambah_goodsreceipts'), 403);

        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        
        $tipe_pembayaran    = 'lunas';
        return view(
            'goodsreceipts.products', // Path to your create view file
            compact(
                'products',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                'dataKarat',
                'tipe_pembayaran',
                'module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }
}
