<?php

namespace Modules\BuysBack\Http\Controllers;
use Lang;
use Auth;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\BuysBack\Events\BuysBackCreated;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\BuysBack\Models\BuysBack;
use Modules\BuysBack\Models\BuysBackDetails;
use Modules\People\Entities\Supplier;
use Modules\People\Entities\Customer;
use Modules\Cabang\Models\Cabang;
use Modules\BuysBack\Http\Requests\StoreBuyBackRequest;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Status\Models\ProsesStatus;

class BuysBackNotaController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Buys Back';
        $this->module_name =  'buysback';
        $this->module_path =  'buysbacks';
        $this->module_icon =  'fas fa-sitemap';
        $this->module_model = "Modules\BuysBack\Models\BuyBackNota";

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

  public function index() {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_buysback_nota'), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
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
        $$module_name = $module_model::get();
        $data = $$module_name;
        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                    
                          ->editColumn('date', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . tanggal2($data->date) . '
                                       </div>';
                                   return $tb;
                               })

                          ->editColumn('invoice', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->invoice . '
                                       </div>';
                                   return $tb;
                               })


                            ->editColumn('berat', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . $data->weight . '
                                     gram </div>';
                                return $tb;
                            })
                            ->editColumn('nominal_beli', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . format_uang($data->nominal) . '
                                    </div>';
                                return $tb;
                            })

                         ->addColumn('status', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.status',
                            compact('module_name', 'data', 'module_model'));
                                })
                            ->editColumn('cabang', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . @$data->cabang->name . '
                                        </div>';
                                    return $tb;
                            })

                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['action','nama_customer',
                               'invoice',
                               'date',
                               'kadar',
                               'berat',
                               'status',
                               'nominal_beli',
                               'updated_at','keterangan','cabang'])
                        ->make(true);
                     }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
 








private function randomPhone()
    {
        $countryCode = '+628'; // Change this to the desired country code
        $phone = $countryCode;
      // Generate random digits for the remaining 10 digits (excluding country code)
        for ($i = 0; $i < 10; $i++) {
            $phone .= rand(0, 9);
        }
        return $phone;
    }







}
