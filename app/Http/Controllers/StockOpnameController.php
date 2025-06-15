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
use App\Models\Baki;
use App\Models\StockOpname;
use App\Models\StockOpnameBaki;
use App\Models\StockOpnameProduct;
use App\Models\StockOpnameHistories;
use Modules\Product\Entities\Product;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class StockopnameController extends Controller
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
        $this->module_title = 'Baki';
        $this->module_name = 'baki';
        $this->module_path = 'bakis';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "App\Models";
    }
    
    public function insert(Request $request)
    {
        $baki    = Baki::create([
            'code'      => $request->code,
            'posisi'    => $request->posisi,
            'name'      => $request->name,
            'capacity'  => $request->capacity,
        ]);

        return redirect()->action([BakiController::class, 'list']);
    }

    public function update_new(Request $request)
    {
        $id = $request->id;
        $code = $request->code;

        $pro    = Product::where('product_code', $code)->firstOrFail();
        $product_id = $pro->id;
        $baki_id = $pro->baki_id;

        $stockopnamebaki    = StockOpnameBaki::where('id', $id)->latest()->first();
        $baki   = $stockopnamebaki->baki_id;
        $stockopname_id = $stockopnamebaki->stock_opname_id;
        if($baki !== $baki_id){
            $bak    = Baki::where('id', $baki_id)->first();
            $baki_name  = $bak->name;
            toast('Product ini seharusnya di '.$baki_name, 'error');
              
            return redirect()->back();   
        }

        // CHECK BAKI

        $stockopnameproduct = StockOpnameProduct::where('product_id', $product_id)->where('stock_opname_id', $stockopname_id)->firstOrFail();
        $stockopnameproduct->status = 'D';
        $stockopnameproduct->save();
        return redirect()->route('stock_opname.detail', ['id' => $id]);

        // return redirect()->action([StockOpnameController::class, 'detail', ['id' => $id]]);
    }

    public function update(Request $request)
    {
        // toast('Stock Opname sedang Aktif!', 'error');
        // return redirect()->back();
        $id = $request->id;
        $product = $request->product;
        $stockopnameproduct = StockOpnameProduct::where('id', $product)->firstOrFail();
        $stockopnameproduct->status = 'D';
        $stockopnameproduct->save();
        return redirect()->route('stock_opname.detail', ['id' => $id]);

        // return redirect()->action([StockOpnameController::class, 'detail', ['id' => $id]]);
    }

    public function done(Request $request)
    {
        $id = $request->id;
        $stockopname = StockOpname::where('id', $id)->firstOrFail();
        $stockopname->status = 'B';
        $stockopname->save();

        $baki   = Baki::where('status', 'O')->firstOrFail();
        $baki->status   = 'A';
        $baki->save();

        return redirect()->route('stock_opname.data');
    }

    public function data(Request $request)
    {
        $stockopname   = Stockopname::where('status', 'B')->latest()->first();
        $stockopname_id   = $stockopname->id;
        $status = $stockopname->status;

        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'stockopname.data', // Path to your create view file
            compact(
                'stockopname',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function riwayat(Request $request)
    {
        $stockopname   = Stockopname::where('status', 'B')->latest()->first();
        $stockopname_id   = $stockopname->id;
        $status = $stockopname->status;

        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'stockopname.riwayat', // Path to your create view file
            compact(
                'stockopname',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function hilang(Request $request)
    {
        // $stockopname   = Stockopname::where('status', 'B')->latest()->first();
        // $stockopname_id   = $stockopname->id;
        // $status = $stockopname->status;
        $id = $request->id;
        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'stockopname.hilang', // Path to your create view file
            compact(
                'id',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function history(Request $request)
    {
        // echo json_encode($request);
        // echo json_encode($_POST);
        // exit();
        $id         = $request->id;
        $status     = $request->status;
        $keterangan = $request->keterangan;

        if($status == 'H'){
            $stat   = 10;
        }elseif($status == 'R'){
            $stat   = 15;
        }

        $stockopnameproduct = StockOpnameProduct::where('id', $id)->firstOrFail();
        $stockopname_id     = $stockopnameproduct->stock_opname_id;
        $baki_id            = $stockopnameproduct->baki_id;
        $product_id         = $stockopnameproduct->product_id;
        $stockopnameproduct->status = $status;
        $stockopnameproduct->save();

        $products = Product::where('id', $product_id)->firstOrFail();
        $products->status = $stat;
        $products->status_id = $stat;
        $products->baki_id = 999;
        $products->save();

        $stockopnamehistories    = StockopnameHistories::create([
            'stock_opname_id'   => $stockopname_id,
            'baki_id'           => $baki_id,
            'product_id'        => $product_id,
            'status'            => $status,
            'keterangan'        => $keterangan,
        ]);
        return redirect()->back();

        // return redirect()->route('stock_opname.detail', ['id' => $id]);

        // return redirect()->action([StockOpnameController::class, 'detail', ['id' => $id]]);
    }

    public function baki(Request $request)
    {
        $id = $request->id;
        $stockopnamebaki = StockOpnameBaki::where('id', $id)->firstOrFail();
        $stockopname    = $stockopnamebaki->stock_opname_id;
        $stockopnamebaki->status = 'D';
        $stockopnamebaki->save();
        // return redirect()->route('stock_opname.list', ['id' => $id]);
        return redirect()->route('stock_opname.list');

        // return redirect()->action([StockOpnameController::class, 'detail', ['id' => $id]]);
    }

    public function list(Request $request)
    {
        $stockopname   = Stockopname::latest()->first();
        $stockopname_id   = $stockopname->id;
        $status = $stockopname->status;
        if($status !== 'A'){
            $stockopname    = Stockopname::create([
                'status'      => 'A',
            ]);
        }

        $button = '';
        $count  = StockOpnameBaki::where('stock_opname_id', $stockopname_id)->where('status', 'P')->count();
        if($count > 0){
            $button = 'disabled';
        }

        $stockopname_id = $stockopname->id;
        $baki   = Baki::latest()->get();
        if($status !== 'A'){
            foreach($baki as $b){
                $baki_id    = $b->id;
                $code       = $b->code;
                $name       = $b->name;
                $capacity   = $b->capacity;
                $posisi     = $b->posisi;
                $used       = Product::where('baki_id', $baki_id)->where('status_id', 1)->count();
    
                $stockopnamebaki    = StockopnameBaki::create([
                    'stock_opname_id'   => $stockopname_id,
                    'baki_id'           => $baki_id,
                    'name'              => $name,
                    'code'              => $code,
                    'used'              => $used,
                    'capacity'          => $capacity,
                    'posisi'            => $posisi,
                ]);
            }
        }
        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'stockopname.list', // Path to your create view file
            compact(
                'stockopname',
                'button',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function detail(Request $request)
    {
        $id     = $request->id;
        // $stockopnamebaki    = stockopnamebaki::where('id', $id)->first()->get();

        $stockopnamebaki    = stockopnamebaki::where('id', $id)->firstOrFail();
        $status             = $stockopnamebaki->status;
        $stockopname_id     = $stockopnamebaki->stock_opname_id;
        $baki_id            = $stockopnamebaki->baki_id;

        // UPDATE BAKI YANG OPNAME DISABLE
        Baki::where('id', $baki_id)->update(['status' => 'O']);

        StockOpnameBaki::where('stock_opname_id', $stockopname_id)
        ->where('id', '!=', $id)
        ->where('status', 'W')
        ->update(['status' => 'H']);

        if($status == 'W'){
            $stockopnamebaki->status = 'P';
            $stockopnamebaki->save();
            $product            = Product::where('baki_id', $baki_id)->latest()->get();
            foreach($product as $p){
                $product_id = $p->id;
                $stockopnameproduct    = StockopnameProduct::create([
                    'stock_opname_id'   => $stockopname_id,
                    'baki_id'           => $baki_id,
                    'product_id'        => $product_id,
                ]);
            }
        }

        $button = '';
        $count = StockOpnameProduct::
        where('stock_opname_id', $stockopname_id)
        ->where('baki_id', $baki_id)
        ->where('status', 'W')
        ->count();
        if($count > 0){
            $button = 'disabled';
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $baki   = StockOpnameBaki::findorFail($id);
        return view(
            'stockopname.detail', // Path to your create view file
            compact(
                'id',
                'button',
                'baki',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function index_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = StockOpnameBaki::where('stock_opname_id', $id)->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })
            ->editColumn('status', function ($data) {
                $stat   = 'Waiting';
                if($data->status == 'D'){
                    $stat   = 'Done';
                }elseif($data->status == 'H'){
                    $stat   = 'Hold';
                }elseif($data->status == 'P'){
                    $stat   = 'Proses';
                }
                return $stat;
            })
                
            ->rawColumns(['code', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }

    public function index_riwayat()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        // $$module_name = Karat::latest()->get();
        // $$module_name->each(function ($item) use ($harga) {
        //     $item->harga = $harga; // Add the harga attribute to the model
        // });

        $module_action = 'List';
        // $$module_name = StockOpname::
        // with('stock_opname_baki', 'stock_opname_product')->
        // whereHas('stock_opname_baki', function ($query) {
        //     $query->where('status', 'D');
        // })->
        // latest()->
        // get();

        $$module_name = StockOpname::
        join('stock_opname_baki', 'stock_opname_baki.stock_opname_id', '=', 'stock_opname.id')
        ->where('stock_opname_baki.status', 'D')
        ->orderBy('stock_opname.created_at', 'desc')
        ->select(
            'stock_opname.*',
            'stock_opname_baki.*',
            DB::raw('(SELECT COUNT(id) FROM stock_opname_histories WHERE stock_opname_id = stock_opname.id) as lost')
        )
        ->distinct()
        ->get();

        // echo json_encode($$module_name);

        $data   = array();
        // exit();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.view',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                // return (date('Y-m-d', strtotime($data->created_at)));
                return $data->created_at;
            })
            ->editColumn('baki', function ($data) {
                return $data->name;
            })
            ->editColumn('capacity', function ($data) {
                return $data->capacity;
            })
            ->editColumn('used', function ($data) {
                return $data->used-$data->lost;
            })
            ->editColumn('available', function ($data) {
                return ($data->capacity-$data->used+$data->lost);
            })
            ->editColumn('lost', function ($data) {
                return '<a href="/stockopname/hilang/'.$data->stock_opname_id.'">'.$data->lost.'</a>';
            })
            ->rawColumns(['lost', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }
    // <a href="/stock_opname/hilang/43">1</a>
    public function index_hilang(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $id = $request->id;
        // $$module_name = Karat::latest()->get();
        // $$module_name->each(function ($item) use ($harga) {
        //     $item->harga = $harga; // Add the harga attribute to the model
        // });

        $module_action = 'List';
        // $$module_name = StockOpname::
        // with('stock_opname_baki', 'stock_opname_product')->
        // whereHas('stock_opname_baki', function ($query) {
        //     $query->where('status', 'D');
        // })->
        // latest()->
        // get();

        $$module_name = StockOpnameHistories::
        with('baki', 'product')
        ->where('stock_opname_id', $id)
        ->latest()
        ->get();

        // echo json_encode($$module_name);

        $data   = array();
        // exit();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.view',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                // return (date('Y-m-d', strtotime($data->created_at)));
                return $data->created_at;
            })
            ->editColumn('baki', function ($data) {
                return $data->baki->name;
            })
            ->editColumn('product', function ($data) {
                return $data->product->product_name;
            })
            ->editColumn('code', function ($data) {
                return $data->product->product_code;
            })
            ->editColumn('berat', function ($data) {
                return ($data->product->berat_emas);
            })
            ->editColumn('keterangan', function ($data) {
                return ($data->keterangan);
            })
            ->rawColumns(['code', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }

    public function detail_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $stockopnamebaki    = StockOpnameBaki::where('id', $id)->first();
        $stockopname_id     = $stockopnamebaki->stock_opname_id;
        $baki_id            = $stockopnamebaki->baki_id;

        $module_action = 'List';
        $$module_name = StockOpnameProduct::
        with('product', 'baki')
        ->where('stock_opname_id', $stockopname_id)
        ->where('baki_id', $baki_id)
        ->where('status', 'W')
        ->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })
            ->editColumn('product_code', function ($data) {
                return ($data->product->product_code);
            })
            ->editColumn('product_name', function ($data) {
                return view('stockopname.image', compact('data'));
            })
            ->editColumn('baki', function ($data) {
                return ($data->baki->name);
            })
            ->editColumn('berat_emas', function ($data) {
                return ($data->product->berat_emas);
            })
            ->editColumn('status', function ($data) {
                $stat   = 'Waiting';
                if($data->status == 'D'){
                    $stat   = 'Done';
                }
                return $stat;
            })
                
            ->rawColumns(['product_name', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }

    public function opname_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $stockopnamebaki    = StockOpnameBaki::where('id', $id)->first();
        $stockopname_id     = $stockopnamebaki->stock_opname_id;
        $baki_id            = $stockopnamebaki->baki_id;

        $module_action = 'List';
        $$module_name = StockOpnameProduct::
        with('product', 'baki')
        ->where('stock_opname_id', $stockopname_id)
        ->where('baki_id', $baki_id)
        ->where('status', 'D')
        ->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })
            ->editColumn('product_code', function ($data) {
                return ($data->product->product_code);
            })
            ->editColumn('product_name', function ($data) {
                return view('stockopname.image', compact('data'));
            })
            ->editColumn('baki', function ($data) {
                return ($data->baki->name);
            })
            ->editColumn('berat_emas', function ($data) {
                return ($data->product->berat_emas);
            })
            ->editColumn('status', function ($data) {
                $stat   = 'Waiting';
                if($data->status == 'D'){
                    $stat   = 'Done';
                }
                return $stat;
            })
                
            ->rawColumns(['product_name', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }
}
