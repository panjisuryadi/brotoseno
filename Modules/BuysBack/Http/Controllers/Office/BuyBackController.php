<?php

namespace Modules\BuysBack\Http\Controllers\Office;
use Lang;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Modules\BuysBack\Models\BuyBackNota;

class BuyBackController extends Controller
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

  

public function index_data(Request $request)

    {
        $module_title = $this->module_title;
                         $module_name = $this->module_name;
                         $module_path = $this->module_path;
                         $module_icon = $this->module_icon;
                         $module_model = $this->module_model;
                         $module_name_singular = Str::singular($module_name);
                 
                         $module_action = 'List';
                         $$module_name = BuyBackNota::get();
                         return Datatables::of($$module_name)
                                         ->addColumn('action', function ($data) {
                                             $module_name = $this->module_name;
                                             $module_model = $this->module_model;
                                             $module_path = $this->module_path;
                                             return view(''.$module_name.'::'.$module_path.'.office.datatable.action',
                                             compact('module_name', 'data', 'module_model'));
                                                 })
                 
                                           ->editColumn('total_item', function ($data) {
                                                 $tb = '<div class="font-semibold items-center text-center">
                                                         ' . $data->items->count() . '
                                                        </div>';
                                                    return $tb;
                                                })
                                             ->editColumn('status', function ($data) {
                                             $tb = '<button class="btn bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">'. ($data->isSent()?'Menunggu Konfirmasi':'Processing') .'</button>';
                                                 return $tb;
                                             })
                                             ->editColumn('nota', function ($data) {
                                             $tb = '<div class="font-semibold items-center text-center">
                                                     ' . $data->invoice . '
                                                     </div>';
                                                 return $tb;
                                             })
        
                 
                                            ->editColumn('date', function ($data) {
                                                $tb = '<div class="font-semibold items-center text-center">
                                                ' . $data->date . '
                                                </div>';
                                            return $tb;
                                            })
                                            ->editColumn('cabang', function ($data) {
                                                $tb = '<div class="font-semibold items-center text-center">
                                                ' . $data->cabang->name . '
                                                </div>';
                                            return $tb;
                                            })
                                            ->rawColumns(['action','barang',
                                                    'total_item',
                                                    'status',
                                                    'nota',
                                                    'date',
                                                    'cabang'
                                                    ])
                                            ->make(true);
        
    }


    public function process(Request $request){
        try {
            if(!auth()->user()->isUserCabang()){
                $data = $request->input('data');
                if(empty($data) && isset($data)){
                    throw new \Exception('Data Kosong');
                }else{
                    $nota = BuyBackNota::find($data['id']);
                    $nota->process();
                }
            }else{
                throw new \Exception('You are not authorized');
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Nota Berhasil diproses',
                'redirectRoute' => route('buysback.show',$nota->id)
            ],200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }



}
