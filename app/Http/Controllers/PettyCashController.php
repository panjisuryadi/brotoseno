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

        $pettycash  = PettyCash::latest()->first();
        $status     = $pettycash->status;
        $id         = $pettycash->id;

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
            'petty_cash.list', // Path to your create view file
            compact(
                'pettycash',
                'buyback',
                'luar',
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

            ->editColumn('modal', function($data){
                return number_format($data->modal);
            })
            
            ->editColumn('current', function($data){
                return number_format($data->current);
            })

            ->editColumn('final', function($data){
                return number_format($data->final);
            })

            ->editColumn('in', function($data){
                return number_format($data->in);
            })

            ->editColumn('out', function($data){
                return number_format($data->out);
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
                $cash_in    = 0;
                if($data->type == 'modal' || $data->type == 'pos'){
                    $cash_in = $data->nominal;
                }
                return number_format($cash_in);
            })

            ->editColumn('cash_out', function($data){
                $cash_out    = 0;
                if($data->type == 'buyback' || $data->type == 'luar'){
                    $cash_out = $data->nominal;
                }
                return number_format($cash_out);
            })

            ->rawColumns(['harga', 'tanggal','user'])
            ->make(true);
    }

    public function insert(Request $request){
        $modal = $request->modal;
        
        $pettycash = PettyCash::create([
            'tanggal'   => date('Y-m-d'),
            'modal'     => $modal,
            'current'   => $modal,
        ]);
        $id = $pettycash->id;
        $pettycashdata  = PettycashData::create([
            'petty_cash_id' => $id,
            'type'  => 'modal',
            'nominal' => $modal,
            'from' => 'admin'
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
        
        $pettycash          = PettyCash::where('id', $id)->firstOrFail();
        $current_modal      = $pettycash->modal;
        $current_current    = $pettycash->current;
        $pettycash->sisa   = $sisa;
        $pettycash->keterangan = $keterangan;
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
