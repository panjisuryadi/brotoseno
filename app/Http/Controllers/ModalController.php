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
use App\Models\Modal;
use App\Models\ModalData;
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

class ModalController extends Controller
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

        $modalData      = ModalData::where('modal_id', $id)->latest()->get();
        $buyback        = 0;
        $luar           = 0;
        foreach($modalData as $p){
            if($p->from == 'buyback'){
                $buyback    = $buyback+$p->nominal;
            }
            elseif($p->from == 'luar'){
                $luar    = $luar+$p->nominal;
            }
        }

        return view(
            'modal.detail', // Path to your create view file
            compact(
                'id',
                'modalData',
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
        $buyback        = 0;
        $luar           = 0;
        $pos            = 0;
        $status         = 'B';
        $modal_         = 0;
        $modal  = Modal::where('status', 'A')->latest()->first();
        if($modal){
            $status     = $modal->status;
            $modal_     = $modal->current;
            $id         = $modal->id;
    
            $modaldata  = ModalData::where('modal_id', $id)->latest()->get();
            foreach($modaldata as $p){
                if($p->type == 'buyback'){
                    $buyback    = $buyback+$p->nominal;
                }
                elseif($p->type == 'luar'){
                    $luar    = $luar+$p->nominal;
                }
                elseif($p->type == 'pos'){
                    $pos    = $pos+$p->nominal;
                }
            }
        }
        
        

        return view(
            'modal.list', // Path to your create view file
            compact(
                'modal_',
                'buyback',
                'luar',
                'pos',
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
        $$module_name = Modal::latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('modal.action',
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
        $$module_name = ModalData::where('modal_id', $id)->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            // ->addColumn('action', function ($data) {
            //     $module_name = $this->module_name;
            //     $module_model = $this->module_model;
            //     $module_path = $this->module_path;
            //     return view('petty_cash.action',
            //         compact('module_name', 'data', 'module_model'));
            // })

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

            // ->editColumn('current', function($data){
            //     return number_format($data->current);
            // })

            ->rawColumns(['harga', 'tanggal','user'])
            ->make(true);
    }

    public function insert(Request $request){
        $modal_ = $request->modal;
        
        $modal = Modal::create([
            'tanggal'   => date('Y-m-d'),
            'modal'     => $modal_,
            'current'   => $modal_,
            'cash_in'   => 0,
            'cash_out'  => 0,
            'status'    => 'A',
        ]);
        $id = $modal->id;
        $modalData  = ModalData::create([
            'modal_id' => $id,
            'type'  => 'modal',
            'nominal' => $modal_,
            'from' => 'admin'
        ]);
        return redirect()->action([ModalController::class, 'list']);
    }

    public function update(Request $request){
        // echo 'hello';
        // echo json_encode($_POST);
        $id = $request->id;
        $modal_ = $request->modal;
        
        $modal              = Modal::where('id', $id)->firstOrFail();
        $current_modal      = $modal->modal;
        $current_current    = $modal->current;
        $modal->modal   = $current_modal+$modal_;
        $modal->current = $current_current+$modal_;
        $modal->save();
        
        $modalData  = ModalData::create([
            'modal_id' => $id,
            'type'  => 'modal',
            'nominal' => $modal_,
            'from' => 'admin'
        ]);
        return redirect()->action([ModalController::class, 'list']);
    }

    public function close(Request $request){
        // $id = $request->id;
        $sisa = $request->sisa;
        $keterangan = $request->keterangan;
        
        $modal          = Modal::where('status', 'A')->latest()->first();
        $modal->final   = $sisa;
        $modal->keterangan = $keterangan;
        $modal->status = 'B';
        $modal->save();
        
        return redirect()->action([ModalController::class, 'list']);
    }

}
