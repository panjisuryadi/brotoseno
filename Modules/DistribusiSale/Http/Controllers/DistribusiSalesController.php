<?php

namespace Modules\DistribusiSale\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lang;
use Image;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockSales;
use PDF;

class DistribusiSalesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Distribusi Sale';
        $this->module_name = 'distribusisale';
        $this->module_path = 'distribusisales';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\DistribusiSale\Models\DistribusiSale";

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
        abort_if(Gate::denies('access_distribusisales'), 403);
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

        $$module_name = $module_model::orderBy('updated_at', 'desc')->get();

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
                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return tanggal($data->updated_at);
                            }
                        })
                        ->editColumn('invoice_no', function ($data) {
                            $tb = '<div class="text-sm font-semibold">
                                     ' .$data->invoice_no . '
                                    </div>';
                                  $tb .= '<div class="text-sm text-left">
                                     ' .tanggal($data->date) . '
                                    </div>';   

                                  
                                return $tb;
                        })
                        ->editColumn('sales', function ($data) {
                            $tb = '<div class="items-center text-center">
                                   <h3 class="text-sm font-medium text-gray-800">
                                    ' .$data->sales->name . '</h3>
                                   </div>';
                               return $tb;
                           })
                        ->editColumn('jumlah_emas', function ($data) {
                        $tb = '<div class="items-center text-center">
                                <h3 class="text-sm font-medium text-gray-800">
                                ' .$data->detail->sum('berat_bersih') . ' gr</h3>
                                </div>';
                            return $tb;
                        })
                        ->rawColumns(['updated_at', 'action','invoice_no','sales','jumlah_emas'])
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
            abort_if(Gate::denies('add_'.$module_name.''), 403);
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
         abort_if(Gate::denies('create_distribusisale'), 403);
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
        abort_if(Gate::denies('show_'.$module_name.''), 403);
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

            $distribusi_sales = $module_model::findOrFail($id);
            $this->reduceStockSales($distribusi_sales);
            $this->addStockOffice($distribusi_sales);
            $distribusi_sales->delete();
            DB::commit();
            toast(''. $module_title.' Deleted!', 'success');
            return redirect()->route(''.$module_name.'.index');
        }catch (\Exception $e) {
            DB::rollBack(); 
            toast($e->getMessage(), 'warning');
            return redirect()->back();
        }

    }

    private function reduceStockSales($distribusi_sales){
        $dist_sum_weight = $distribusi_sales->detail->sum('berat_bersih');
        $stock_sales_sum = StockSales::where(['sales_id' => $distribusi_sales->sales_id])->sum('weight');
        if($stock_sales_sum < $dist_sum_weight){
            throw new \Exception('Gagal menghapus data');
        }
        foreach($distribusi_sales->detail as $detail){
            $stock_sales = StockSales::where(['karat_id' => $detail->karat_id, 'sales_id' => $distribusi_sales->sales_id])->first();
            $detail->stock_sales()->attach($stock_sales->id,[
                'karat_id'=>$detail->karat_id,
                'sales_id' => $distribusi_sales->sales_id,
                'in' => false,
                'berat_real' => -1 * $detail->berat_bersih,
                'berat_kotor' => -1 * $detail->berat_bersih,
            ]);
            $berat_real = $stock_sales->history->sum('berat_real');
            $stock_sales->update(['weight'=> $berat_real]);
        }
    }


    private function addStockOffice($distribusi_sales){
        foreach($distribusi_sales->detail as $detail){
            $karat = Karat::find($detail->karat_id);
            $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
            $stock_office = StockOffice::firstOrCreate(['karat_id' => $karat_id]);
            $detail->stock_office()->attach($stock_office->id,[
                    'karat_id'=>$karat_id,
                    'in' => true,
                    'berat_real' => $detail->berat_bersih,
                    'berat_kotor' => $detail->berat_bersih
            ]);
            $berat_real = $stock_office->history->sum('berat_real');
            $berat_kotor = $stock_office->history->sum('berat_kotor');
            $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
        }
    }

    public function cetak($id) {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $detail = $module_model::findOrFail($id);
        $title = 'Print Distribusi Sales';
        $pdf = PDF::loadView(''.$module_name.'::'.$module_path.'.includes.print', compact('detail','title'))
          ->setPaper('A4', 'portrait');
          return $pdf->stream('distribusi_sales-'. $detail->id .'.pdf');
         // return view(''.$module_name.'::'.$module_path.'.includes.print',
         //   compact('module_name',
         //    'detail',
         //    'module_title',
         //    'title',
         //    'module_icon', 'module_model'));




    }

}
