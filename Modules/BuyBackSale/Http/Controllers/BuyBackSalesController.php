<?php

namespace Modules\BuyBackSale\Http\Controllers;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\BuyBackSale\Events\BuyBackSaleCreated;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lang;
use Image;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\BuyBackSale\Models\BuyBackSale;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockRongsok;

class BuyBackSalesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'BuyBackSale';
        $this->module_name = 'buybacksale';
        $this->module_path = 'buybacksales';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\BuyBackSale\Models\BuyBackSale";

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
        abort_if(Gate::denies('access_buybacksales'), 403);
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
                           $module_path = $this->module_path;
                            $module_model = $this->module_model;
                            return view($module_name.'::'.$module_path.'.includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                                ->editColumn('invoice', function ($data) {
                                    $tb = '<div class="text-xs font-semibold">
                                        ' .$data->no_buy_back . '
                                       </div>';
                                     $tb .= '<div class="text-xs text-left">
                                        ' .tanggal($data->date) . '
                                       </div>'; 
                                        $tb .= '<div class="font-semibold text-xs text-left">
                                        Customer : ' . $data->customerSale->customer_name . '
                                       </div>';   
                                   return $tb;
                               })

                                   ->editColumn('product', function ($data) {
                                    $tb = '<div class="text-xs">
                                            Nama : ' .$data->product_name . '
                                        </div>';
                                        $tb .= '<div class="text-xs text-left">
                                        Karat : ' .$data->karat->label . '
                                        </div>'; 
                                        $tb .= '<div class="text-xs text-left">
                                        Berat : ' . formatBerat($data->weight) . ' gr
                                        </div>';   
                                    return $tb;
                                    })
                                    ->editColumn('nominal_beli', function ($data) {
                                    $tb = '<div class="text-xs">
                                            ' . format_uang($data->nominal) . '
                                            </div>';
                                        return $tb;
                                    })
                                    ->editColumn('keterangan', function ($data) {
                                        $tb = '<div class="text-xs text-left">
                                                ' . $data->note . '
                                                </div>';
                                            return $tb;
                                    })
                                    ->editColumn('sales', function ($data) {
                                        $tb = '<div class="text-xs">
                                                ' . $data->sales->name . '
                                                </div>';
                                            return $tb;
                                    })
                        ->rawColumns(['action','invoice','product','nominal_beli','keterangan','sales'])
                        ->make(true);
                     }







    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
        public function create()
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
            $module_action = 'Create';
           // abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
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
         abort_if(Gate::denies('create_buybacksale'), 403);
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
        $validated = $request->validate([
            'no_buy_back' => 'required',
            'date' => 'required',
            'customer_sales_id' => 'required',
            'sales_id' => 'required',
            'nama_product' => 'required',
            'kadar' => 'required',
            'berat' => 'required',
            'nominal' => 'required',
        ]);
        
        $buybackSale = BuyBackSale::create([
            'date' => $request->input('date'),
            'customer_sales_id' => $request->input('customer_sales_id'),
            'sales_id' => $request->input('sales_id'),
            'note' => $request->input('note')??null,
            'no_buy_back' => $request->input('no_buy_back'),
            'product_name' => $request->input('nama_product'),
            'karat_id' => $request->input('kadar'),
            'weight' => $request->input('berat'),
            'nominal' => $request->input('nominal'),
        ]);


        toast('Buy Back Sale Berhasil dibuat!', 'success');
        return redirect()->route('buybacksale.index');
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
        //abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
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
       // abort_if(Gate::denies('edit_'.$module_name.''), 403);
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
        DB::beginTransaction();
        try{
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);

            $module_action = 'Delete';

            $buyback_sales = $module_model::findOrFail($id);
            $this->reduceStockRongsok($buyback_sales);
            $buyback_sales->delete();
            DB::commit();
            toast(''. $module_title.' Deleted!', 'success');
            return redirect()->route(''.$module_name.'.index');
        }catch (\Exception $e) {
            DB::rollBack(); 
            toast($e->getMessage(), 'warning');
            return redirect()->back();
        }

    }

    private function reduceStockRongsok($buyback_sales){
        $karat = Karat::find($buyback_sales->karat_id);
        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
        $stock_rongsok = StockRongsok::where('karat_id', $karat_id)->first();
        if($stock_rongsok->weight < $buyback_sales->weight){
            throw new \Exception('Gagal menghapus data');
        }
        $buyback_sales->stock_rongsok()->attach($stock_rongsok->id,[
            'karat_id'=>$karat_id,
            'sales_id' => $buyback_sales->sales_id,
            'weight' => -1 * $buyback_sales->weight,
        ]);
        $weight = $stock_rongsok->history->sum('weight');
        $stock_rongsok->update(['weight'=> $weight]);
        
    }

}
