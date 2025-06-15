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
use Yajra\DataTables\DataTables;

class KaratController extends Controller
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
        $this->module_title = 'Karat';
        $this->module_name = 'karat';
        $this->module_path = 'karats';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Karat\Models\Karat";
    }
    
    public function insert(Request $request)
    {
        $product    = Harga::create([
            'tanggal'   => date('Y-m-d'),
            'harga'     => $request->harga,
            'user'      => 1,
        ]);

        return redirect()->action([KaratController::class, 'list']);
    }

    public function delete($id)
    {
        // echo $id;
        // echo $request->id;
        // exit();
        $karat = Karat::where('id', $id)->firstOrFail();
        $karat->status = 'D';
        $karat->save();

        return redirect()->action([KaratController::class, 'list']);
        // return redirect()->route('karats.list')->with('success', 'Deleted successfully');

    }

    public function update(Request $request)
    {
        $harga = Harga::where('tanggal', date('Y-m-d'))->firstOrFail();
        $harga->harga = $request->harga;
        $harga->save();

        return redirect()->action([KaratController::class, 'list']);
    }

    public function update_diskon(Request $request, Karat $data)
    {
        $validator = \Validator::make($request->all(),[
            'diskon' => 'required|numeric',
        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }
        $id = $request->input('id');
        $diskon = $request->input('diskon');
        $data = Karat::where('id', $id)->firstOrFail();
        $data->diskon = $diskon;
        $data->save();
        if(empty($data->parent_id)){
            $dataKarat = [
                'karat_id' => $data->parent_id,
                'user_id' => auth()->id(),
                'tgl_update' => now(),
                'harga_emas' => 0,
                'harga_modal' => 0,
                'margin' => 0,
                'harga_jual' => 0
            ];
        }
        return response()->json(['success'=>'Diskon Sukses diupdate.']);
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
            'karats.list', // Path to your create view file
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

    public function history(Request $request)
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
            'karats.history', // Path to your create view file
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

    public function list_diskon(Request $request)
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
            'karats.list_diskon', // Path to your create view file
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

    public function edit_diskon($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = Karat::findOrFail($id);
          return view('karats.modal_diskon',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));
    }

    public function index_diskon(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = Karat::latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        
        $data = $$module_name;
        return Datatables::of($$module_name)
                    ->addColumn('action', function ($data) {
                       $module_name = $this->module_name;
                        $module_model = $this->module_model;
                        $module_path = $this->module_path;
                        $harga = 1000000;
                        return view($module_name.'::'.$module_path.'.includes.diskon',
                        compact('module_name', 'data', 'module_model'));
                            })
                         
                        ->editColumn('karat', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .$data->label . '</h3>
                                    </div>';
                             })  

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
                            return number_format($data->margin);
                            // return '<div class="items-center text-center">
                            //                 <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->margin) . '</h3>
                            //         </div>';
                            }) 
                        
                        ->editColumn('rekomendasi', function($data){
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format(($data->coef*$data->harga)+$data->margin) . '</h3>
                                    </div>';
                            })

                        ->editColumn('diskon', function($data){
                            return number_format($data->diskon);
                            })
                      ->editColumn('ph', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->penentuanharga->harga_emas) . '
                             </div>';

                        })
                        ->editColumn('harga', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->coef*@$data->harga) . '
                             </div>';

                        })
                        ->rawColumns(['karat', 'rekomendasi', 'diskon', 'action','coef','type','ph', 'harga'])
                        ->make(true);
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
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = Karat::where('status', 'A')->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        
        $data = $$module_name;
        return Datatables::of($$module_name)
                    ->addColumn('action', function ($data) {
                       $module_name = $this->module_name;
                        $module_model = $this->module_model;
                        $module_path = $this->module_path;
                        $harga = 1000000;
                        // return view($module_name.'::'.$module_path.'.includes.action',
                        return view('karats.action',
                        compact('module_name', 'data', 'module_model'));
                            })
                         
                        ->editColumn('karat', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .$data->label . '</h3>
                                    </div>';
                             })  

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
                      ->editColumn('ph', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->penentuanharga->harga_emas) . '
                             </div>';

                        })
                        ->editColumn('harga', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->coef*@$data->harga) . '
                             </div>';

                        })
                        ->rawColumns(['karat', 'rekomendasi', 'action','coef','type','ph', 'harga'])
                        ->make(true);
    }

    public function history_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::where('tanggal', date('Y-m-d'))->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = Harga::with('user')->latest()->get();
        // echo $$module_name;        
        $data = $$module_name;
        return Datatables::of($data)
                    ->addColumn('action', function ($data) {
                       $module_name = $this->module_name;
                        $module_model = $this->module_model;
                        $module_path = $this->module_path;
                        return view($module_name.'::'.$module_path.'.includes.action',
                        compact('module_name', 'data', 'module_model'));
                            })
                         
                        ->editColumn('harga', function($data){
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->harga) . '</h3>
                                    </div>';
                             })  

                        ->editColumn('margin', function($data){
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->margin) . '</h3>
                                    </div>';
                            }) 
                        
                        ->editColumn('rekomendasi', function($data){
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->harga+$data->margin) . '</h3>
                                    </div>';
                            })

                      ->editColumn('tanggal', function($data){
                        $output = '';
                            
                       return '<div class="items-center text-center">' .($data->created_at) . '</div>';
                        }) 
                      ->editColumn('user', function($data){
                            $output = '';
                          
                        return '<div class="items-center text-center">
                                            <span class="text-sm font-medium text-gray-800"> ' .($data->user->name ?? 'Admin').'</span>
                                    </div>';

                        })   
                      
                        ->rawColumns(['harga', 'tanggal','user'])
                        ->make(true);
    }
}
