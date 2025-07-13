<?php


namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Group\Models\Group;
use Modules\Product\Entities\Product;
use App\Models\PettyCash;
use App\Models\PettyCashData;
use App\Models\Harga;
use App\Models\ProductHistories;
use Modules\Product\Entities\ProductItem;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;
use Modules\Sale\Http\Requests\StorePosSaleRequest;
use PDF;
use Auth;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Product\Models\ProductStatus;
use Yajra\DataTables\DataTables;
use Modules\Karat\Models\Karat;
use Modules\ProdukModel\Models\ProdukModel;

class PettyCashController extends Controller
{

    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_detail;
    private $module_payment;
    private $module_product;

    public function __construct()
    {
        $this->module_title = 'Sale';

        $this->module_name = 'sales';

        $this->module_path = 'sale';

        $this->module_icon = 'fas fa-sitemap';

        $this->module_model = "Modules\Sale\Entities\Sale";
        $this->module_detail = "Modules\Sale\Entities\SaleDetails";
        $this->module_payment = "Modules\Sale\Entities\SalePayment";
        $this->module_product = "Modules\Product\Entities\Product";
    }

    public function detail($id) {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $pettycashdata  = PettyCashData::where('petty_cash_id', $id)->latest()->get();
        $buyback        = 0;
        $luar           = 0;
        foreach($pettycashdata as $p){
            if($p->from == 'buyback'){
                $buyback    = $buyback+$p->nominal;
            }
            elseif($p->from == 'luar'){
                $luar    = $luar+$p->nominal;
            }
        }

        return view(
            'petty_cash.detail', // Path to your create view file
            compact(
                'id',
                'pettycashdata',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function list() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $status = 'B';
        $current    = 0;
        $cash_out   = 0;
        
        $pettycash  = PettyCash::where('status', 'A')->latest()->first();
        if($pettycash){
            $status     = $pettycash->status;
            $id         = $pettycash->id;
            $current    = $pettycash->current;
            $cash_out   = $pettycash->cash_out;
        }

        return view(
            'petty_cash.list', // Path to your create view file
            compact(
                'pettycash',
                'current',
                'cash_out',
                'status',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
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
        $$module_name = PettyCash::latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('petty_cash.action',
                    compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('tanggal', function($data){
                return '<div class="items-center text-center">' .($data->tanggal) . '</div>';
            }) 

            ->editColumn('current', function($data){
                return number_format($data->current);
            })

            ->editColumn('final', function($data){
                return number_format($data->final);
            })

            ->editColumn('cash_in', function($data){
                return number_format($data->cash_in);
            })

            ->editColumn('cash_out', function($data){
                return number_format($data->cash_out);
            })
            ->editColumn('status', function($data){
                $stat   = 'Aktif';
                if($data->status == 'B'){
                    $stat   = 'Close';
                }
                return $stat;
            })
            
            ->rawColumns(['harga', 'tanggal','user'])
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

        $module_action = 'List';
        $$module_name = PettyCashData::where('petty_cash_id', $id)->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('petty_cash.action',
                    compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('tanggal', function($data){
                return '<div class="items-center text-center">' .($data->created_at) . '</div>';
            }) 

            ->editColumn('cash_in', function($data){
                return number_format($data->cash_in);
            })

            ->editColumn('cash_out', function($data){
                return number_format($data->cash_out);
            })

            ->rawColumns(['harga', 'tanggal','user'])
            ->make(true);
    }

    public function insert(Request $request){
        $pet    = PettyCash::where('status', 'A')->first();
        if($pet){
            toast('Ada Petty Cash Active', 'error');
            return redirect()->back();
        }
        $nominal = $request->nominal;
        
        $pettycash = PettyCash::create([
            'tanggal'   => date('Y-m-d'),
            'current'   => $nominal,
            'cash_in'   => $nominal,
            'cash_out'  => 0,
            'final'     => 0,
            'status'     => 'A',
            'keterangan'  => '',
        ]);
        $id = $pettycash->id;
        $pettycashdata  = PettycashData::create([
            'petty_cash_id' => $id,
            'cash_in' => $nominal,
            'cash_out' => 0,
            'keterangan' => 'modal',
        ]);
        return redirect()->action([PettyCashController::class, 'list']);
    }

    public function data(Request $request){
        $pettycash  = PettyCash::where('status', 'A')->first();
        $pettycash_id   = $pettycash->id;
        $pettycash->current     = $pettycash->current-$request->nominal;
        $pettycash->cash_out    = $pettycash->cash_out+$request->nominal;
        $pettycash->save();
        
        $pettycashdata  = PettycashData::create([
            'petty_cash_id' => $pettycash_id,
            'cash_in' => 0,
            'cash_out' => $request->nominal,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->action([PettyCashController::class, 'list']);
    }

    public function modal(Request $request){
        $pettycash          = PettyCash::where('status', 'A')->first();
        if($pettycash){
            $pettycash_id   = $pettycash->id;
            $pettycash->current = $pettycash->current+$request->nominal;
            $pettycash->cash_in = $pettycash->cash_in+$request->nominal;
            $pettycash->save();
        }
        
        $pettycashdata  = PettycashData::create([
            'petty_cash_id' => $pettycash_id,
            'cash_in' => $request->nominal,
            'cash_out' => 0,
            'keterangan' => 'modal'
        ]);
        return redirect()->action([PettyCashController::class, 'list']);
    }

    public function update(Request $request){
        // echo 'hello';
        // echo json_encode($_POST);
        $id = $request->id;
        $modal = $request->modal;
        
        $pettycash          = PettyCash::where('id', $id)->firstOrFail();
        $current_modal      = $pettycash->modal;
        $current_current    = $pettycash->current;
        $pettycash->modal   = $current_modal+$modal;
        $pettycash->current = $current_current+$modal;
        $pettycash->save();
        
        $pettycashdata  = PettycashData::create([
            'petty_cash_id' => $id,
            'type'  => 'modal',
            'nominal' => $modal,
            'from' => 'admin'
        ]);
        return redirect()->action([PettyCashController::class, 'list']);
    }

    public function close(Request $request){
        $id = $request->id;
        $sisa = $request->sisa;
        $keterangan = $request->keterangan;
        
        $pettycash          = PettyCash::where('status', 'A')->firstOrFail();
        $current_modal      = $pettycash->modal;
        $current_current    = $pettycash->current;
        $pettycash->final   = $sisa;
        $pettycash->keterangan = $keterangan;
        $pettycash->status = 'B';
        $pettycash->save();
        
        return redirect()->action([PettyCashController::class, 'list']);
    }

    public function updates(Request $request){
        $value['alamat'] = $request->alamat;
        $value['telp'] = $request->telp;
        $value['info'] = $request->info;
        $val    = json_encode($value);
        $config = Config::where('name', 'nota')->firstOrFail();
        $config->value = $val;
        $config->save();
        
        return redirect()->action([ConfigController::class, 'list']);
    }
}
