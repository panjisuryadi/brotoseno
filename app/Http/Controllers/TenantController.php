<?php


namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CentralUser;
use App\Models\Webcam;
use App\Models\Config;
use PDF;
use Auth;
use Yajra\DataTables\DataTables;

class TenantController extends Controller
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

    public function list() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $cc = Config::where('name', 'cc')->first();

        $webcam  = Webcam::latest()->first();

        return view(
            'tenant.list', // Path to your create view file
            compact(
                'webcam',
                'cc',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
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
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
             
        // $harga  = 1000000;
        $$module_name   = CentralUser::latest()->get();
        // $$module_name = Karat::where('type', 'GOLD')->where('status', 'A')->latest()->get();
        // $$module_name->each(function ($item) use ($harga) {
        //     $item->harga = $harga; // Add the harga attribute to the model
        // });
        
        $data = $$module_name;
        return Datatables::of($$module_name)
                    // ->addColumn('action', function ($data) {
                    //    $module_name = $this->module_name;
                    //     $module_model = $this->module_model;
                    //     $module_path = $this->module_path;
                    //     $harga = 1000000;
                    //     // return view($module_name.'::'.$module_path.'.includes.action',
                    //     return view('karats.action',
                    //     compact('module_name', 'data', 'module_model'));
                    //         })
                         
                    //     ->editColumn('karat', function($data){
                    //         // $output = '';
                    //         // if(is_null($data->parent_id)){
                    //         //     $output = "{$data->name} {$data->kode}";
                    //         // }else{
                    //         //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                    //         // }
                    //         return '<div class="items-center text-center">
                    //                         <h3 class="text-sm font-bold text-gray-800"> ' .$data->label . '</h3>
                    //                 </div>';
                    //          })  

            ->editColumn('type', function($data){
                        $output = '';
                        if(is_null($data->type)){
                $output = ($data->parent?->type == 'LM')?'<span class="text-sm font-medium text-yellow-700">Logam Mulia</span>':'<span class="text-sm font-medium text-green-700">Perhiasan</span>';
                        }else{
                $output = ($data->type == 'LM')?'<span class="text-sm font-medium text-yellow-700">Logam Mulia</span>':'<span class="text-sm font-medium text-green-700">Perhiasan</span>';
                        }
                    return '<div class="items-center text-center">' .$output . '</div>';
                    }) 
            ->editColumn('coef', function($data){
                $output = '';
                
            return '<div class="items-center text-center">
                                <span class="text-sm font-medium text-gray-800"> ' .$data->coef . '</span>
                        </div>';

            })   
            ->editColumn('margin', function($data){
                return ($data->persen.' %');
                // return '<div class="items-center text-center">
                //                 <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->margin) . '</h3>
                //         </div>';
                }) 
            
            ->editColumn('rekomendasi', function($data){
                return '<div class="items-center text-center">
                                <h3 class="text-sm font-bold text-gray-800"> ' .number_format(($data->coef*$data->harga)+(($data->coef*$data->persen*$data->harga)/100)) . '</h3>
                        </div>';
                })

            ->editColumn('asli', function($data){
                return '<div class="items-center text-center">
                                <h3 class="text-sm font-bold text-gray-800"> ' .number_format(($data->coef*$data->harga)) . '</h3>
                        </div>';
                })
            ->editColumn('ph', function($data){
                $output = '';
                
                return '<div class="items-center font-semibold text-center">
                    ' .rupiah(@$data->penentuanharga->harga_emas) . '
                    </div>';

            })
            ->editColumn('harga', function($data){
                // $output = '';
                $price  = $data->coef*@$data->harga;
                $rounded = ceil($price / 1000) * 1000;
                return '<div class="items-center font-semibold text-center">
                    ' .rupiah(@$rounded) . '
                    </div>';

            })
            ->addColumn('rounded', function($data){
                $har    = ceil($data->coef*$data->harga/1000)*1000;
                $price  = $har+(($data->coef*$data->persen*$data->harga)/100);
                $rounded = ceil($price / 1000) * 1000;
                
                return '<div class="items-center font-semibold text-center">
                    ' .rupiah($rounded) . '
                    </div>';

            })
            ->rawColumns(['karat', 'rekomendasi', 'asli', 'rounded', 'action','coef','type','ph', 'harga'])
            ->make(true);
    }

    public function update(Request $request){
        $value = $request->value;
        
        $webcam          = Webcam::where('id', 1)->firstOrFail();
        $webcam->value   = $value;
        $webcam->save();
        
        return redirect()->action([WebcamController::class, 'list']);
    }
}
