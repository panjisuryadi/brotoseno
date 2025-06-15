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
use Modules\ProdukModel\Models\ProdukModel;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Stok\Models\StockOffice;
use App\Models\Harga;
use App\Models\BuyBack;
use App\Models\PettyCash;
use App\Models\PettyCashData;
use Modules\Product\Entities\Product;
use Yajra\DataTables\DataTables;
use App\Models\ProductHistories;
use App\Models\SalesGold;
use App\Models\SalesItem;
use App\Models\StockOpname;
use PDF;

class BuybackController extends Controller
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
        $this->module_title = 'Karat';
        $this->module_name = 'karat';
        $this->module_path = 'karats';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Karat\Models\Karat";
    }

    public function print_struk($id)
    {
        $buyback = Buyback::where('id', $id)->with('product')->firstOrFail();
        $nota   = $buyback->nota;
        $payment   = $buyback->payment;
        $harga   = $buyback->harga;
        $product_name   = $buyback->product->product_name;
        $product_code   = $buyback->product->product_code;
        $berat   = $buyback->berat_emas;
        // echo $buyback;
        // exit();
        return view(
            'buyback.struk', // Path to your create view file
            compact(
                'buyback',
            )
        );
    }
    
    public function insert(Request $request)
    {   
        // echo json_encode($_POST);
        // exit();
        $product = $request->product;
        // $products = Product::where('id', $product)->first();
        // echo json_encode($products);
        // exit();
        // $id_product = $products;
        $buyback    = Buyback::create([
            'nota'   => $request->nota,
            'product_id'   => $product,
            'kondisi'   => $request->kondisi,
            'payment'   => $request->payment,
            'harga'   => $request->harga,
            'tanggal'   => date('Y-m-d'),
        ]);

        $id_buyback = $buyback->id;

        // UPDATE PRODUCT
        $product= Product::where('id', $product)->firstOrFail();
        $name   = $product->product_name;
        $name   = $product->product_name;
        $desc   = $product->product_code;
        $gram   = $product->berat_emas;
        $harga  = $request->harga;
        $product->status_id = 3; // pending
        $product->save();

        $id_product = $product->id;

        // HISTORY
        $product_history = ProductHistories::create([
            'product_id'    => $id_product,
            'status'        => 'B',
            'keterangan'    => $request->payment.' | '.$request->kondisi,
            'harga'         => $request->harga,
            'tanggal'       => date('Y-m-d'),
        ]);

        if($request->payment == 'cash'){
            $pettycash          = PettyCash::where('status', 'A')->latest()->firstOrFail();
            $id                 = $pettycash->id;
            $current_modal      = $pettycash->modal;
            $current_current    = $pettycash->current;
            $current_out        = $pettycash->out;
            $pettycash->current = $current_current-$request->harga;
            $pettycash->out     = $current_out+$request->harga;
            $pettycash->save();
            
            $pettycashdata  = PettycashData::create([
                'petty_cash_id' => $id,
                'type'  => 'buyback',
                'nominal' => $request->harga,
                'from' => 'kasir'
            ]);
        }
        return redirect()->route('buyback.print', ['id' => $buyback->id]);

        // return redirect()->action([BuyBackController::class, 'list']);
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // $harga = ProductHistories::where('tanggal', date('Y-m-d'))->first();  
        // if($harga == null){
        //     $harga  = 0;
        // }else{
        //     $harga = $harga->harga;
        // }     
        // $harga  = 1000000;
        $$module_name = Buyback::with('product')->latest()->get();
        // echo $$module_name;        
        $data = $$module_name;
        return Datatables::of($data)
                    ->addColumn('action', function ($data) {
                        return view('buyback.action',
                        compact('data'));
                            })

                      ->editColumn('tanggal', function($data){
                        $output = '';
                            
                       return '<div class="items-center text-center">' .($data->tanggal) . '</div>';
                        }) 
                        ->editColumn('harga', function($data){
                            $output = '';
                                
                           return number_format($data->harga);
                            }) 
                      ->editColumn('product', function($data){
                            $output = '';
                          
                        // return '<div class="items-center text-center">
                        //                      ' .($data->product->product_code ?? 'Admin').'
                        //             </div>';

                        return ($data->product->product_code ?? 'Admin');

                        })   
                      
                        ->rawColumns(['harga', 'tanggal','user'])
                        ->make(true);
    }

    public function update(Request $request)
    {
        $harga = Harga::where('tanggal', date('Y-m-d'))->firstOrFail();
        $harga->harga = $request->harga;
        $harga->save();

        return redirect()->action([KaratController::class, 'list']);
    }

    public function list(Request $request)
    {
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::latest()->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'buyback.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'dataKarat',
                'harga',
            )
        );
    }

    public function view_nota(Request $request){
        $id   = $request->id;
        $salesGold  = SalesItem::where('nomor', $id)->where('product', '!=', 0)->first();
        if ($salesGold) {
            $product    = $salesGold->product;
            $name       = $salesGold->name;
            $desc       = $salesGold->desc;
            $total      = $salesGold->total;
            $product    = Product::where('id', $product)->first();
            $status     = $product->status_id;
            if($status == 2){
                return response()->json([
                    'product' => $product->id,
                    'image' => $product->images,
                    'kode' => $product->product_code,
                    'jenis' => $product->product_name,
                    'berat' => $product->berat_emas,
                    'desc' => $desc,
                    'harga' => 'Rp '.number_format($total)
                ]);
            }
        }
    
        return response()->json([
            'product' => '',
            'image' => '',
            'kode' => '',
            'jenis' => '',
            'berat' => '',
            'desc' => '',
            'harga' => ''
        ]);
        // return response()->json([], 404);
        // return $salesGold;
        // $product    = 
    }

    public function index_data_2()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $$module_name = Buyback::with('product')->latest()->get();
        // echo $$module_name;        
        $data = $$module_name;
        return Datatables::of($data)
                    // ->addColumn('action', function ($data) {
                    //    $module_name = $this->module_name;
                    //     $module_model = $this->module_model;
                    //     $module_path = $this->module_path;
                    //     return view($module_name.'::'.$module_path.'.includes.action',
                    //     compact('module_name', 'data', 'module_model'));
                    //         })
                         
                        ->editColumn('harga', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->harga) . '</h3>
                                    </div>';
                             })  

                      ->editColumn('tanggal', function($data){
                        $output = '';
                            
                       return '<div class="items-center text-center">' .($data->tanggal) . '</div>';
                        }) 
                    //   ->editColumn('user', function($data){
                    //         $output = '';
                          
                    //     return '<div class="items-center text-center">
                    //                         <span class="text-sm font-medium text-gray-800"> ' .($data->user->name ?? 'Admin').'</span>
                    //                 </div>';

                    //     })   
                      
                        ->rawColumns(['harga', 'tanggal','user'])
                        ->make(true);
    }
}
