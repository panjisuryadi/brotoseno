<?php

namespace Modules\PenerimaanBarangLuarSale\Http\Controllers;
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
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuarIncentive;
use Modules\PenerimaanBarangLuarSale\Events\PenerimaanBarangLuarSaleCreated;
use Modules\PenerimaanBarangLuarSale\Models\PenerimaanBarangLuarSale;
use Modules\Stok\Models\StockRongsok;
use PDF;

class PenerimaanBarangLuarSalesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Penerimaan Barang Luar Sales';
        $this->module_name = 'penerimaanbarangluarsale';
        $this->module_path = 'penerimaanbarangluarsales';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\PenerimaanBarangLuarSale\Models\PenerimaanBarangLuarSale";

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
        //abort_if(Gate::denies('access_penerimaanbarangluarsales'), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }



  public function insentif() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.index_insentif',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


  public function tambah_insentif() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.tambah_insentif',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }

public function destroy_incentive(PenerimaanBarangLuarIncentive $incentive){
    $incentive->delete();
    toast('Insentif Berhasil dihapus', 'success');
    return redirect()->route('penerimaanbarangluarsale.insentif');
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

        $$module_name = $module_model::orderBy('updated_at','desc')->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                           $module_path = $this->module_path;
                            $module_model = $this->module_model;
                            return view($module_name.'::'.$module_path.'.includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                                ->editColumn('no_barang_luar', function ($data) {
                                    $tb = '<div class="text-xs flex flex-col gap-y-1 text-left">'; 
                                    $tb .= '<div class="text-gray-800">
                                           <strong>' . $data->no_barang_luar . '
                                          </strong></div>';
                                    $tb .= '<div class="text-gray-800">
                                            ' . tanggal($data->date) . '
                                           </div>';
                                    $tb .= '<div class="text-gray-800">
                                            Customer Sales : <strong>' . $data->customerSale->customer_name . '
                                           </strong></div>'; 
                                    $tb .= '</div>'; 
                                       return $tb;
                                     })
                                ->editColumn('sales', function ($data) {
                                $tb = '<div class="text-xs text-gray-800">
                                        <strong><br>' . $data->sales->name . '
                                        </strong></div>';               
                                    return $tb;
                                    })
                                ->addColumn('detail_produk', function ($data) {
                                    $tb = '<div class="text-xs justify items-left text-left">'; 
                                    
                                    $tb .= '<div class="text-gray-800">
                                            Produk :<strong> ' . $data->product_name . '
                                            </strong></div>'; 
                                    $tb .= '<div class="text-gray-800">
                                            Karat :<strong> ' . $data->karat->label . '
                                            </strong></div>';   

                                    $tb .= '<div class="text-gray-800">
                                            Berat :<strong> ' . $data->weight . '
                                            gr </strong></div>';               
                                    $tb .= '</div>'; 
                                        return $tb;
                                })
                                
                                ->editColumn('keterangan', function ($data) {
                                    $tb = '<div class="text-xs font-semibold items-center text-center">
                                            ' . $data->note . '
                                            </div>';
                                        return $tb;
                                })
                                ->addColumn('nilai_produk', function ($data) {
                                    $tb = '<div class="text-xs justify items-left text-left">'; 
                                  
                                    $tb .= '<div class="text-gray-800">
                                            Nilai Angkat :<strong> Rp.' . number_format($data->nilai_angkat) . '
                                           </strong></div>'; 
                                    $tb .= '<div class="text-gray-800">
                                            Nilai Tafsir :<strong> Rp.' . number_format($data->nilai_tafsir) . '
                                           </strong></div>';   
        
                                    $tb .= '<div class="text-gray-800">
                                            Nilai Selisih :<strong> Rp.' . number_format($data->nilai_selisih) . '
                                           </strong></div>';               
                                    $tb .= '</div>'; 
                                       return $tb;
                                })
                        ->rawColumns(['action','no_barang_luar','detail_produk','keterangan','nilai_produk','sales'])
                        ->make(true);
                     }



public function index_data_insentif(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = PenerimaanBarangLuarIncentive::whereNotNull('sales_id')->get();
        $data = $$module_name;
        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.incentive.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                            ->editColumn('bulan', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                    ' . \Carbon\Carbon::parse($data->date)->format('F Y') . '
                                    </div>';
                                return $tb;
                            })

                            ->editColumn('incentive', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">Rp.
                                        ' . number_format($data->incentive) . '
                                        </div>';
                                    return $tb;
                                })
    
                                ->editColumn('sales', function ($data) {
                                    $tb = '<div class="font-semibold items-center text-center">
                                            ' . $data->sales->name . '
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
                        ->rawColumns(['action',
                               'bulan',
                               'updated_at',
                               'sales',
                               'incentive'
                               ])
                        ->make(true);
                     }
public function print_incentive(PenerimaanBarangLuarIncentive $incentive){
    $month = Carbon::parse($incentive->date)->format('F Y');
    $filename = "Insentif ". $incentive->sales->name . " " .$month;
    $pdf = PDF::loadView('penerimaanbarangluarsale::penerimaanbarangluarsales.incentive.print',compact('incentive','month'));
    return $pdf->stream($filename.'.pdf');
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
            //abort_if(Gate::denies('add_'.$module_name.''), 403);
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
         abort_if(Gate::denies('create_penerimaanbarangluarsale'), 403);
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
        $request->validate([
            'no_barang_luar' => 'required',
            'date' => 'required',
            'customer_sales_id' => 'required',
            'sales_id' => 'required',
            'nama_product' => 'required',
            'kadar' => 'required',
            'berat' => 'required',
            'nilai_angkat' => 'required',
            'nilai_tafsir' => 'required',
            'nilai_selisih' => 'required'
        ]);

        DB::beginTransaction();
        try{
            $penerimaanBarangLuar = PenerimaanBarangLuarSale::create([
                'date' => $request->input('date'),
                'customer_sales_id' => $request->input('customer_sales_id'),
                'sales_id' => $request->input('sales_id'),
                'note' => $request->input('note')??null,
                'no_barang_luar' => $request->input('no_barang_luar'),
                'product_name' => $request->input('nama_product'),
                'karat_id' => $request->input('kadar'),
                'weight' => $request->input('berat'),
                'nilai_angkat' => $request->input('nilai_angkat'),
                'nilai_tafsir' => $request->input('nilai_tafsir'),
                'nilai_selisih' => $request->input('nilai_selisih'),
                'pic_id' => auth()->id()
            ]);
            $this->addStockRongsok($penerimaanBarangLuar);
            DB::commit();
            toast($this->module_title, 'success');
            return redirect()->route('penerimaanbarangluarsale.index');
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
    }

    private function addStockRongsok($penerimaanBarangLuar){
        $karat = Karat::find($penerimaanBarangLuar->karat_id);
        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
        $stock_rongsok = StockRongsok::firstOrCreate(['karat_id' => $karat_id]);
        $penerimaanBarangLuar->stock_rongsok()->attach($stock_rongsok->id,[
                'karat_id'=>$karat_id,
                'sales_id' => $penerimaanBarangLuar->sales_id,
                'weight' => $penerimaanBarangLuar->weight,
        ]);
        $weight = $stock_rongsok->history->sum('weight');
        $stock_rongsok->update(['weight'=> $weight]);
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

            $barangluarsales = $module_model::findOrFail($id);
            $this->reduceStockRongsok($barangluarsales);
            $barangluarsales->delete();
            DB::commit();
            toast(''. $module_title.' Deleted!', 'success');
            return redirect()->route(''.$module_name.'.index');
        }catch (\Exception $e) {
            DB::rollBack(); 
            toast($e->getMessage(), 'warning');
            return redirect()->back();
        }

    }

    private function reduceStockRongsok($barangluarsales){
        $karat = Karat::find($barangluarsales->karat_id);
        $karat_id = empty($karat->parent_id)?$karat->id:$karat->parent_id;
        $stock_rongsok = StockRongsok::where('karat_id', $karat_id)->first();
        if($stock_rongsok->weight < $barangluarsales->weight){
            throw new \Exception('Gagal menghapus data');
        }
        $barangluarsales->stock_rongsok()->attach($stock_rongsok->id,[
            'karat_id'=>$karat_id,
            'sales_id' => $barangluarsales->sales_id,
            'weight' => -1 * $barangluarsales->weight,
        ]);
        $weight = $stock_rongsok->history->sum('weight');
        $stock_rongsok->update(['weight'=> $weight]);
    }

    public function generate_invoice(){
        $lastString = PenerimaanBarangLuarSale::orderBy('id', 'desc')->value('no_barang_luar');

        $numericPart = (int) substr($lastString, 17);
        $incrementedNumericPart = $numericPart + 1;
        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
        $nextString = "BARANGLUAR-SALES-" . $nextNumericPart;
        return response()->json([
            'data' => $nextString,
        ]);
    }

}
