<?php

namespace Modules\DistribusiToko\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Image;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Cabang\Models\Cabang;
use Modules\UserCabang\Models\UserCabang;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Stok\Models\StockOffice;
use App\Exports\Distribusi\EmasExport;
use App\Exports\Distribusi\EmasExportDetail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Exception;



class DistribusiTokosController extends Controller
{
    public $module_name;
    public $module_path;
    public $module_model;

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Distribusi Toko';
        $this->module_name = 'distribusitoko';
        $this->module_path = 'distribusitokos';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\DistribusiToko\Models\DistribusiToko";
        $this->module_kategori = "Modules\KategoriProduk\Models\KategoriProduk";

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

  public function index(Request $request) {
        abort(404);
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $status = $request->status ?? '';
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'status',
            'module_icon', 'module_model'));
    }


    public function detail(DistribusiToko $dist_toko){
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
       
         return view(''.$module_name.'::'.$module_path.'.detail',
           compact('module_name',
            'module_action',
            'module_title',
            'dist_toko',
            'module_icon', 'module_model'));

    }


public function view_excel(Request $request ,$dist_toko)
    {
         $tanggal = date('d-m-Y');
         // $to_date = $request->get('to_date') ??  date('d-m-Y');
         //dd($dist_toko);
         ob_end_clean();
         ob_start();
         return Excel::download(new EmasExportDetail($tanggal,$dist_toko),
            'backup-distribusi-excel'.$tanggal.'.xlsx');


    }






    public function cetak(DistribusiToko $dist_toko){
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

     // $pdf = PDF::loadView(''.$module_name.'::'.$module_path.'.includes.cetak',  compact('module_name',
     //        'module_action',
     //        'module_title',
     //        'dist_toko',
     //        'module_icon', 'module_model'))
     //  ->setPaper('A4', 'portrait');

     //      return $pdf->stream('distribusitoko.pdf');

         return view(''.$module_name.'::'.$module_path.'.includes.cetak',
           compact('module_name',
            'module_action',
            'module_title',
            'dist_toko',
            'module_icon', 'module_model'));

    }



public function cetak_pdf($id) {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $detail = $module_model::findOrFail($id);
        $title = 'Print Distribusi Toko';
        $pdf = PDF::loadView(''.$module_name.'::'.$module_path.'.includes.print', compact('detail','title'))
          ->setPaper('A4', 'portrait');

          return $pdf->stream('distribusitoko-'. $detail->id .'.pdf');

         // return view(''.$module_name.'::'.$module_path.'.includes.print',
         //   compact('module_name',
         //    'detail',
         //    'module_title',
         //    'module_icon', 'module_model'));




    }



    public function detail_distribusi(DistribusiToko $dist_toko){
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
        $distribusi = $dist_toko->items;
        abort_if(Gate::denies('approve_distribusi'), 403);
         return view(''.$module_name.'::'.$module_path.'.detail_distribusi',
           compact('module_name',
            'module_action',
            'module_title',
            'dist_toko',
            'distribusi',
            'module_icon', 'module_model'));

    }




    public function export_emas_detail(DistribusiToko $dist_toko){
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
        $distribusi = $dist_toko->items;
         return view(''.$module_name.'::'.$module_path.'.detail_distribusi_excel',
           compact('module_name',
            'module_action',
            'module_title',
            'dist_toko',
            'distribusi',
            'module_icon', 'module_model'));

    }



  public function view_excel_old(Request $request ,DistribusiToko $dist_toko) {
       
        $status = $request->status ?? '';
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.view_distribusi_excel',
           compact('module_name',
            'module_action',
            'module_title',
            'status',
            'module_icon', 'module_model'));
    }




    public function send(DistribusiToko $dist_toko){
        abort_if(Gate::denies('edit_distribusitoko'), 403);
        if(!$dist_toko->is_draft){
            return redirect()->back();
        }

        DB::beginTransaction();
        try{
            $dist_toko->update([
                'is_draft' => false
            ]);
            $this->createProducts($dist_toko->cabang_id,$dist_toko->items);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Produk Berhasil dibuat!', 'success');
        return redirect()->route('products.index');
    }

    private function createProducts($cabang_id,$items){
            foreach($items as $item){
                $this->reduceStockOffice($item);
                $additional_data = json_decode($item['additional_data'],true)['product_information'];
                $product = Product::create([
                  'category_id'                => $additional_data['product_category']['id'],
                  'cabang_id'                  => $cabang_id,
                  'product_stock_alert'        => 5,
                    'product_name'              => $additional_data['group']['name'] .' '. $additional_data['model']['name'] ?? 'unknown',
                  'product_code'               => $additional_data['code'],
                  'product_barcode_symbology'  => 'C128',
                  'product_unit'               => 'Gram',
                  'product_cost' => 0,
                  'product_price' => 0
                ]);
      
                  if (!empty($additional_data['image'])) {
                      $img = $additional_data['image'];
                      $folderPath = "uploads/";
                      $image_parts = explode(";base64,", $img);
                      $image_type_aux = explode("image/", $image_parts[0]);
                      $image_type = $image_type_aux[1];
                      $image_base64 = base64_decode($image_parts[1]);
                      $fileName ='webcam_'. uniqid() . '.jpg';
                      $file = $folderPath . $fileName;
                      Storage::disk('local')->put($file,$image_base64);
                      $product->addMedia(Storage::path('uploads/' . $fileName))->toMediaCollection('products');
                    }
      
      
                    // if ($request->has('document')) {
                    //       foreach ($request->input('document', []) as $file) {
                    //           $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                    //       }
                    //   }

                    $this->createProductDetail($product->id, $item, $additional_data);
                    
                }
            
    }

    private function reduceStockOffice($item){
        $stock_office = StockOffice::where('karat_id', $item['karat_id'])->first();
        if(is_null($stock_office)){
            $stock_office = StockOffice::create(['karat_id'=> $item['karat_id']]);
        }
        $item->stock_office()->attach($stock_office->id,[
                'karat_id'=>$item['karat_id'],
                'in' => false,
                'berat_real' => -1 * $item['gold_weight'],
                'berat_kotor' => -1 * $item['gold_weight']
        ]);
        $berat_real = $stock_office->history->sum('berat_real');
        $berat_kotor = $stock_office->history->sum('berat_kotor');
        $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
    }

    private function createProductDetail($product_id, $item, $additional_data){
        ProductItem::create([
            'product_id'                  => $product_id,
            'karat_id'                    => $item['karat_id'],
            'certificate_id'              => empty($additional_data['certificate_id'])?null:$additional_data['certificate_id'],
            'berat_emas'                  => $item['gold_weight'],
            'berat_label'                 => $additional_data['tag_weight'],
            'berat_accessories'           => $additional_data['accessories_weight'],
            'produk_model_id'             => $additional_data['model']['id'],
            'berat_total'                 => $additional_data['total_weight'],
            'product_cost'                => 0,
            'product_price'               => 0
        ]);
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

        $status = $request->status;
        $$module_name = $module_model::gold();
        if($status == 'inprogress') {
           $$module_name->inprogress();
           $$module_name->orderBy('created_at', 'desc');
         }
         else if($status == 'completed') {
           $$module_name->completed();
           $$module_name->orderBy('created_at', 'desc');
         }
         else if($status == 'retur') {
           $$module_name->retur();
           $$module_name->orderBy('created_at', 'desc');
         }else{
             $$module_name->orderBy('created_at', 'desc');
         }
        $$module_name->get();

         $data = $$module_name;


        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                        return view(''.$module_name.'::'.$module_path.
                            '.includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                        ->editColumn('date', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                    ' .  Carbon::parse($data->date)->format('d M, Y') . '</span>
                                    </div>';
                                return $tb;
                            })
                        ->editColumn('no_invoice', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <span class="font-semibold text-blue-500">
                                    ' .$data->no_invoice . '</span>
                                    </div>';
                                return $tb;
                            })
                          ->editColumn('cabang', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                     ' .$data->cabang->name . '</span>
                                    </div>';
                                return $tb;
                            })  

                            ->addColumn('status', function ($data) {
                                $module_name = $this->module_name;
                                $module_model = $this->module_model;
                                $module_path = $this->module_path;
                                return view(''.$module_name.'::'.$module_path.
                                '.includes.status_distribusi',
                                compact('module_name', 'data', 'module_model'));
                                    })
                           ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center">
                                    <h3 class="text-sm text-gray-600">
                                     Jenis Karat: <strong> ' .$data->items->groupBy('karat_id')->count() . ' buah </strong></h3>
                                    </div>
                                    <div class="items-center">
                                    <span class="text-xs text-blue-400">Total Berat Emas: <strong> '.$data->items->sum('gold_weight') .' Gram
                                    </strong></span>
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

                          // ->filter(function ($instance) use ($request) {
                          //   if (!empty($request->get('search'))) {
                          //        $instance->where(function($w) use($request){
                          //           $search = $request->get('search');
                          //              $w->orWhere('history_distribusi_toko.no_invoice', 'LIKE', "%$search%");
                          //            });
                          //         }
                          //     })



                        ->rawColumns(['updated_at', 
                                    'action',  'cabang','date', 'karat','status',
                                      'no_invoice'])
                        ->make(true);
                     }




//buat dashboard manager

public function index_data_table(Request $request)

    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $status = $request->status;
        $$module_name = $module_model::query();
        if($status == 'inprogress') {
           $$module_name->inprogress();
           $$module_name->orderBy('created_at', 'desc');
         }
         else if($status == 'completed') {
           $$module_name->completed();
           $$module_name->orderBy('created_at', 'desc');
         }
         else if($status == 'retur') {
           $$module_name->retur();
           $$module_name->orderBy('created_at', 'desc');
         }else{
             $$module_name->orderBy('created_at', 'desc');
         }
         $$module_name->get();

         $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                        return view(''.$module_name.'::'.$module_path.
                            '.includes.aksi_distribusi',
                            compact('module_name', 'data', 'module_model'));
                                })
                        ->editColumn('date', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                    ' .  Carbon::parse($data->date)->format('d M, Y') . '</span>
                                    </div>';
                                return $tb;
                            })
                        ->editColumn('no_invoice', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                    ' .$data->no_invoice . '</span>
                                    </div>';
                                return $tb;
                            })
                          ->editColumn('cabang', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                     ' .$data->cabang->name . '</span>
                                    </div>';
                                return $tb;
                            })  

                           ->addColumn('status', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                             return view(''.$module_name.'::'.$module_path.
                            '.includes.status_distribusi',
                            compact('module_name', 'data', 'module_model'));
                                })
                           ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center">
                                    <h3 class="text-sm text-gray-600">
                                     Jenis Karat: <strong> ' .$data->items->groupBy('karat_id')->count() . ' buah </strong></h3>
                                    </div>
                                    <div class="items-center">
                                    <span class="text-sm text-gray-800">Total Berat Emas: <strong> '.$data->items->sum('gold_weight') .' Gram
                                    </strong></span>
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
                        ->rawColumns(['updated_at', 
                                    'action',  'cabang','date', 'karat','status',
                                      'no_invoice'])
                        ->make(true);
                     }





public function index_data_complete(Request $request)

    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        
        $$module_name = $module_model::completed()->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                             return view(''.$module_name.'::'.$module_path.
                            '.includes.aksi_distribusi',
                            compact('module_name', 'data', 'module_model'));
                                })

                        ->editColumn('date', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                    ' .  Carbon::parse($data->date)->format('d M, Y') . '</span>
                                    </div>';
                                return $tb;
                            })
                        ->editColumn('no_invoice', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                    ' .$data->no_invoice . '</span>
                                    </div>';
                                return $tb;
                            })
                          ->editColumn('cabang', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <span class="text-gray-600">
                                     ' .$data->cabang->name . '</span>
                                    </div>';
                                return $tb;
                            })  

                            //  ->editColumn('status', function ($data) {
                            //  $tb = '<div class="items-center justify-center text-center btn btn-sm text-xs btn-outline-warning">
                            //          ' . $data->current_status->name . '
                            //         </div>';
                            //     return $tb;
                            // })

                        ->addColumn('status', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                             return view(''.$module_name.'::'.$module_path.
                            '.includes.status_distribusi',
                            compact('module_name', 'data', 'module_model'));
                                })


                           ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center">
                                    <span class="text-sm text-gray-600">
                                     Jenis Karat: <strong> ' .$data->items->groupBy('karat_id')->count() . ' buah </strong></span>
                                    </div>
                                    <div class="items-center">
                                    <span class="text-sm text-gray-800">Total Berat: <strong> '.$data->items->sum('gold_weight') .' Gram
                                    </strong></span>
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
                        ->rawColumns(['updated_at', 
                                    'action',  'cabang','date', 'karat','status',
                                      'no_invoice'])
                        ->make(true);
                     }




    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
        public function create()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.modal.create',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_default(Request $request)
    {
         abort_if(Gate::denies('create_distribusitoko'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $request->validate([
             'name' => 'required|min:3|max:191',
             'description' => 'required|min:3|max:191',
         ]);
       // $params = $request->all();
        //dd($params);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];
        //  if ($image = $request->file('image')) {
        //  $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
        //  $normal = Image::make($image)->resize(600, null, function ($constraint) {
        //             $constraint->aspectRatio();
        //             })->encode();
        //  $normalpath = 'uploads/' . $gambar;
        //  if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
        //  Storage::disk($storage)->put($normalpath, (string) $normal);
        //  $params['image'] = "$gambar";
        // }else{
        //    $params['image'] = 'no_foto.png';
        // }


         $$module_name_singular = $module_model::create($params);
         toast(''. $module_title.' Created!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }



//store ajax version

public function store(Request $request)
    {
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
        $validator = \Validator::make($request->all(),[
             'code' => 'required|max:191|unique:'.$module_model.',code',
             'name' => 'required|max:191',

        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $input['code'] = $input['code'];
        $input['name'] = $input['name'];
        $$module_name_singular = $module_model::create($input);

        return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
public function show($id)
    {

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
        $module_action = 'Show';
        abort_if(Gate::denies('show_buybacktoko'), 403);
        $detail = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.modal.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }




public function show_distribusi($id)
    {

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
        $module_action = 'Show';
        abort_if(Gate::denies('show_buybacktoko'), 403);

        $detail = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.modal.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }



public function view_distribusi($id)
    {
        dd($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
       // abort_if(Gate::denies('show_buybacktoko'), 403);
          $detail = $module_model::findOrFail($id);
         $detail = DistribusiToko::where('id', $id)->first();
       
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }








 public function tracking(DistribusiToko $dist_toko){
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
        $distribusi = $dist_toko->items;
       
         return view(''.$module_name.'::'.$module_path.'.modal.tracking',
           compact('module_name',
            'module_action',
            'module_title',
            'dist_toko',
            'distribusi',
            'module_icon', 'module_model'));

    }








public function kategori($slug)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_kategori = $this->module_kategori;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
       
        $kategori = $module_kategori::where('slug',$slug)->first();
        $categories = \Modules\Product\Entities\Category::where('kategori_produk_id',$kategori->id)->get();
        $cabang = null;
        if(auth()->user()->isUserCabang()){
            $cabang = Cabang::where('id',Auth::user()->namacabang()->id)->get();
        }else{
            $cabang = Cabang::all();
        }
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.kategori',
           compact('module_name',
            'module_action',
            'kategori',
            'module_title',
            'categories',
            'cabang',
            'module_icon', 'module_model'));

    }






    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
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
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.modal.edit',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update_default(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $request->validate([
            'name' => 'required|min:3|max:191',
                 ]);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];

       // if ($image = $request->file('image')) {
       //                if ($$module_name_singular->image !== 'no_foto.png') {
       //                    @unlink(imageUrl() . $$module_name_singular->image);
       //                  }
       //   $gambar = 'category_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
       //   $normal = Image::make($image)->resize(1000, null, function ($constraint) {
       //              $constraint->aspectRatio();
       //              })->encode();
       //   $normalpath = 'uploads/' . $gambar;
       //  if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
       //   Storage::disk($storage)->put($normalpath, (string) $normal);
       //   $params['image'] = "$gambar";
       //  }else{
       //      unset($params['image']);
       //  }
        $$module_name_singular->update($params);
         toast(''. $module_title.' Updated!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }




//update ajax version
public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make($request->all(),
            [
            'code' => [
                'required',
                'unique:'.$module_model.',code,'.$id
            ],
            'name' => 'required|max:191',


        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $params['code'] = $params['code'];
        $params['name'] = $params['name'];
        $$module_name_singular->update($params);
        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

 }






//update ajax version
public function approve_distribusi(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $params = $request->all();
        $params = $request->except('_token');
        $params['selected_items'] = $params['selected_items'];

        $dist_toko = $params['selected_items'];

        if (is_array($dist_toko) && count($dist_toko) > 0) {
         foreach ($dist_toko as $itemId) {
                      dd($itemId);
            }

         }

         //  $$module_name_singular->update($params);
         // toast(''. $module_title.' Updated!', 'success');
         // return redirect()->route(''.$module_name.'.index');

 }





    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        try {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Delete';

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();
         toast(''. $module_title.' Deleted!', 'success');
         return redirect()->route(''.$module_name.'.index');

          } catch (\Exception $e) {
           // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

    }

    public function index_emas()
    {
        
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
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.emas.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }




 public function export_emas()
    {
        ob_end_clean();
        ob_start();
        $tgl = date('d-m-Y');
        $module_model = $this->module_model;
        $test = $module_model::gold();
       // dd($test->items);

        return Excel::download(new EmasExport, 'export-distribusi-emas_'.$tgl.'.xlsx');

    }



    

    public function index_data_emas(Request $request)
    {
        // $module_name = $this->module_model::gold()->latest()
        // ->orderBy('created_ats','desc')->get();

         $module_name = $this->module_model::latest()->get();

        return Datatables::of($module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
            return view(''.$module_name.'::'.$module_path.
                '.includes.action',
                compact('module_name', 'data', 'module_model'));
                    })
            ->editColumn('no_invoice', function ($data) {
                $tb = '<div class="items-center text-left text-xs">
                <span class="text-blue-600">
                ' .  tanggal($data->date) . '</span>
                </div>
                <div class="items-center text-left text-xs">
                        <span class="text-gray-600 font-bold">
                        ' .$data->no_invoice . '</span>
                        </div>';
                    return $tb;
                })
                ->editColumn('cabang', function ($data) {
                    $tb = '<div class="items-center text-center text-xs">
                        <span class="text-gray-600">
                            ' .$data->cabang->name . '</span>
                        </div>';
                    return $tb;
                })  

              // ->editColumn('status', function ($data) {
              //       $tb = '<div class="items-center justify-center text-center btn btn-sm text-xs btn-outline-warning">
              //               ' . $data->current_status->name . '
              //           </div>';
              //       return $tb;
              //   })

                 ->addColumn('status', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(''.$module_name.'::'.$module_path.
                '.includes.status_distribusi',
                compact('module_name', 'data', 'module_model'));
                    })

                ->editColumn('karat', function ($data) {
                    $tb = '<div class="items-center">
                        <span class="text-xs text-gray-600">
                            Jenis Karat: <strong> ' .$data->items->groupBy('karat_id')->count() . ' buah </strong></span>
                        </div>
                        <div class="items-center">
                        <span class="text-xs text-gray-800">Total Berat Emas: <strong> '.$data->items->sum('gold_weight') .' Gram
                        </strong></span>
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
            ->rawColumns(['updated_at',
                        'action',
                        'cabang',
                        'karat',
                        'status',
                        'no_invoice'])
            ->make(true);
    }


    public function create_emas()
    {
        return view(''.$this->module_name.'::'.$this->module_path.'.emas.create');
    }

    public function edit_emas(DistribusiToko $dist_toko){
        abort_if(!$dist_toko->isDraft(),403);
        return view(''.$this->module_name.'::'.$this->module_path.'.emas.edit', compact('dist_toko'));
    }

    public function index_berlian()
    {
        
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
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.berlian.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }

    public function create_berlian()
    {
        $cabang = [];
        if(auth()->user()->isUserCabang()){
            $cabang = Cabang::where('id',Auth::user()->namacabang()->id)->get();
        }else{
            $cabang = Cabang::all();
        }
        $produksis_id = DistribusiTokoItem::whereNotNull('produksis_id')->pluck('produksis_id')->toArray();

        return view(''.$this->module_name.'::'.$this->module_path.'.berlian.create',
            compact(
                'cabang',
                'produksis_id'
            )
        );
    }

    public function index_data_berlian(Request $request)
    {
        $module_name = $this->module_model::diamond()->get();

        return Datatables::of($module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
            return view(''.$module_name.'::'.$module_path.
                '.includes.action',
                compact('module_name', 'data', 'module_model'));
                    })
            ->editColumn('date', function ($data) {
                $tb = '<div class="items-center text-center">
                        <span class="text-gray-600">
                        ' .  Carbon::parse($data->date)->format('d M, Y') . '</span>
                        </div>';
                    return $tb;
                })
            ->editColumn('no_invoice', function ($data) {
                $tb = '<div class="items-center text-center">
                        <span class="text-gray-600">
                        ' .$data->no_invoice . '</span>
                        </div>';
                    return $tb;
                })
                ->editColumn('cabang', function ($data) {
                    $tb = '<div class="items-center text-center">
                        <span class="text-gray-600">
                            ' .$data->cabang->name . '</span>
                        </div>';
                    return $tb;
                })  

                    ->editColumn('status', function ($data) {
                    $tb = '<div class="items-center justify-center text-center btn btn-sm text-xs btn-outline-warning">
                            ' . $data->current_status->name . '
                        </div>';
                    return $tb;
                })
                ->editColumn('karat', function ($data) {
                    $tb = '<div class="items-center">
                        <h3 class="text-sm text-gray-600">
                            Jenis Karat: <strong> ' .$data->items->groupBy('karat_id')->count() . ' buah </strong></h3>
                        </div>
                        <div class="items-center">
                        <span class="text-sm text-gray-800">Total Berat Emas: <strong> '.$data->items->sum('gold_weight') .' Gram
                        </strong></span>
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
            ->rawColumns(['updated_at',
                        'action',
                        'cabang',
                        'date',
                        'karat',
                        'status',
                        'no_invoice'])
            ->make(true);
    }


}
