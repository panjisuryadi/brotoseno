<?php

namespace Modules\Iventory\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
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

use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Entities\TrackingProduct;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Group\Models\Group;


class IventoriesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Iventory';
        $this->module_name = 'iventory';
        $this->module_path = 'iventories';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Iventory\Models\Iventory";
        $this->module_pembelian = "Modules\GoodsReceipt\Models\GoodsReceipt";
        $this->module_products = "Modules\Product\Entities\Product";

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

  public function index() {
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
            'module_icon', 'module_model'));
    }




public function index_data(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_pembelian::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                 
                  ->addColumn('action', function ($data) {
                    $module_name = $this->module_name;
                    $module_model = $this->module_model;
                    $module_path = $this->module_path;
                    $module_pembelian = $this->module_pembelian;
                      return view(''.$module_name.'::'.$module_path.'.action',
                    compact('module_name', 'data', 'module_model'));
                        })

                   ->addColumn('distribusi', function ($data) {
                    $module_name = $this->module_name;
                    $module_model = $this->module_model;
                    $module_path = $this->module_path;
                    $module_pembelian = $this->module_pembelian;
                      return view(''.$module_name.'::'.$module_path.'.dropdown',
                    compact('module_name', 'data', 'module_model'));
                        })

                         ->editColumn('date', function ($data) {
                             $tb = '<div class="items-left text-left">';
                             $tb .= '<div class="text-xs font-semibold text-gray-600">
                                     ' .$data->code . '
                                    </div>'; 
                             $tb .= '<div class="text-xs text-gray-800">
                                     ' .tanggal2($data->date) . '
                                    </div>';

                                 $tb .= '</div>';

                                return $tb;
                            })

                             ->editColumn('stok_awal', function ($data) {
                             $tb = '<div class="items-center text-center">';
                             $tb .= '<div class="text-xs font-semibold text-gray-600">
                                     ' .$data->goodsreceiptitem->sum('qty') . '
                                    </div>'; 
                        
                                 $tb .= '</div>';

                                return $tb;
                            })


                        ->rawColumns(['updated_at',
                                  'date', 
                                  'action', 
                                  'stok_awal', 
                                  'distribusi',
                                   'name'])
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
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_iventory'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';
        $request->validate([
             'category' => 'required|min:1|max:3',
             'group_id' => 'required|min:1|max:3',
                 'cabang_id' => 'required',
             'produk_model' => 'required',
             'berat_accessories' => 'required|numeric',
          
         ]);
        $input = $request->except('_token');
        $input = $request->all();
        //dd($input);
    
        $model = ProdukModel::where('id', $input['produk_model'])->first();
      
        $group = Group::where('id', $input['group_id'])->first();
        $totalberat = $input['berat_total'] ?? $input['berat_emas'];
        $berat = number_format((float)($totalberat), 5);
       
          $$module_name_singular = $module_products::create([
            'category_id'                       => $input['category'],
            'goodsreceipt_id'                   => null,
            'kode_pembelian'                    => null,
            'product_stock_alert'               => $input['product_stock_alert'],
            'product_name'                      => $group->name .' '. $model->name ?? 'unknown',
            'product_code'                      => $input['product_code'],
            'product_price'                     => '0',
            'product_quantity'                  => $input['product_quantity'],
            'product_barcode_symbology'         => $input['product_barcode_symbology'],
            'product_unit'                      => $input['product_unit'],
            'status'                            => 0, //status Purchase 
            'product_cost'                      => 0
        ]);

         if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('local')->put($file,$image_base64);
                $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))
                ->toMediaCollection('images');
                }

            if ($request->hasFile('document') && $request->file('document')->isValid()) {
                 $$module_name_singular->addMediaFromRequest('document')
                 ->toMediaCollection('images');
            }

            $produk = $$module_name_singular->id;
            // $module_pembelian::countProduk($$module_name_singular->kode_pembelian);
            $this->_saveProductsItem($input ,$produk);

             activity()->log(' '.auth()->user()->name.' Input data pembelian');

            //$$module_name_singular = $module_model::create($params);
             toast(''. $module_title.' Created!', 'success');
             return redirect()->route(''.$module_name.'.index');


    }





   private function _saveProductsItem($input ,$produk)
    {

       ProductItem::create([
                'product_id'                  => $produk,
                'location_id'                 => $input['location_id'] ?? null,
                'parameter_berlian_id'        => $input['parameter_berlian_id'] ?? null,
                'jenis_perhiasan_id'          => $input['jenis_perhiasan_id'] ?? null,
                'customer_id'                 => $input['customer_id'] ?? null,
                'karat_id'                    => $input['karat_id'] ?? null,
                'gold_kategori_id'            => $input['gold_kategori_id'] ?? null,
                'certificate_id'              => $input['certificate_id'] ?? null,
                'shape_id'                    => $input['shape_id'] ?? null,
                'round_id'                    => $input['round_id'] ?? null,
                'round_id'                    => $input['round_id'] ?? null,
                'berat_accessories'           => $input['berat_accessories'] ?? 0,
                'tag_label'                   => $input['berat_tag'] ?? 0,
                'berat_total'                 => $input['berat_total'] ?? 0,
                'product_cost'                => '0',
                'product_price'               => '0',
                'product_sale'                => '0',
                'berat_emas'                  => $input['berat_emas'],
                'berat_label'                 => '0',
                'gudang_id'                   => $gudang ?? null,
                'supplier_id'                 => $input['supplier_id'] ?? null,
                'etalase_id'                  => $input['etalase_id'] ?? null,
                'baki_id'                     => $input['baki_id'] ?? null,
                'produk_model_id'             => $input['produk_model'] ?? null,
                'berat_total'                 => $input['berat_total']
            ]);


}













//store ajax version

public function store_ajax(Request $request)
    {
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



     public function type(Request $request, $type) {
        $id_kategori =  $request->kategori;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);
        $mainkategori = KategoriProduk::findOrFail($id_kategori);
        $categories = Category::where('kategori_produk_id',$mainkategori->id)->get();
        $pembelian = GoodsReceipt::where('kategoriproduk_id',$mainkategori->id)->first();
        $kasir = User::role('Kasir')->orderBy('name')->get();
        $module_action = 'List';
   
         return view(''.$module_name.'::'.$module_path.'.'.$type.'.type',
           compact('module_name',
            'module_action',
            'module_title',
            'mainkategori',
            'pembelian',
            'kasir',
            'type',
            'categories',
            'module_icon', 'module_model'));
        }




public function kategori(Request $request, $id) {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        $kategori = KategoriProduk::findOrFail($id);
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.kategori',
           compact('module_name',
            'module_action',
            'module_title',
            'kategori',
            'module_icon', 
            'module_model'));
          }



     public function distribusi(Request $request, $distribusi) {
        $iddata =  $request->id;
        $id = decode_id($iddata);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        $detail = $module_pembelian::findOrFail($id);
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.'.$distribusi.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'distribusi',
            'detail',
            'module_icon', 'module_model'));
        }








    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
       $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
       
          return view(''.$module_name.'::'.$module_path.'.edit',
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
public function update_ajax(Request $request, $id)
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

}
