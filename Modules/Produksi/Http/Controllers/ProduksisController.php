<?php

namespace Modules\Produksi\Http\Controllers;

use App\Models\LookUp;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Produksi\Models\Produksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Lang;
use Image;
use Modules\Produksi\Models\DiamondCertificateAttribute;
use Modules\Produksi\Models\DiamondCertifikatT;
use Modules\Stok\Models\PenerimaanLantakan;
use Modules\Stok\Models\StockKroom;

class ProduksisController extends Controller
{

    public $module_title;
    public $module_name;
    public $module_path;
    public $module_icon;
    public $module_model;

    const IMG_PATH_PRD ='/';


    public function __construct()
    {
        // Page Title
        $this->module_title = 'Produksi';
        $this->module_name = 'produksi';
        $this->module_path = 'produksis';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Produksi\Models\Produksi";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index() 
    {
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
        $module_name = $this->module_name;
        $module_model = $this->module_model;

        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;

        $module_name = $module_model::with('karatasal', 'karatjadi', 'model', 'produksi_items.shape')->where('kategoriproduk_id', $id_kategoriproduk_berlian)->get();
        return Datatables::of($module_name)
                    ->editColumn('code', function ($data) {
                        $tb = '<div class="text-xs font-semibold">
                            ' .$data->code . '
                            </div>';
                        $tb .= '<div class="text-xs text-left">
                                ' .tanggal($data->tanggal) . '
                            </div>';   
                        return $tb;
                    })
                    ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                    })
                    ->addColumn('asal', function ($data) {
                        return label_case($data->source_kode) . ': ' . $data->karatasal?->name . ' ' . $data->berat_asal . ' gr ';
                    })
                    ->addColumn('hasil', function ($data) {
                        $berlian_info = '';
                        if (!empty($data->produksi_items)) {
                            foreach($data->produksi_items as $item) {
                                $shape_code = !empty($item->shape?->shape_code) ? $item->shape?->shape_code : '';
                                $shape_name = !empty($item->shape?->shape_name) ? $item->shape?->shape_name : '';
                                $shape = !empty($shape_code) ? $shape_code : $shape_name;
                                $berlian_info .= ' '.$shape . $item->qty . ': ' . (float)$item->karatberlians . ' ct ';
                            }
                        }
                        return $data->model?->name . ' ' . $data->karatjadi?->name . ' ' . $data->berat . ' gr <br> Berlian : ' . $berlian_info;
                    })
                    ->editColumn('image', function ($data) {
                        if ($data->image) {
                            $url = URL::to( imageUrl() . self::IMG_PATH_PRD . @$data->image);
                        } else {
                            $url = '';
                        }
                        return '<a href="'.$url.'" data-lightbox="'. @$data->image .' " b class="single_image">
                                    <img src="'.$url.'" order="0" width="100" class="img-thumbnail" align="center"/>
                                    </a>';
                    })
                    ->rawColumns(['action', 'code', 'hasil', 'image'])
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
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function proses()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Create';
        abort_if(Gate::denies('add_'.$module_name.''), 403);
            return view(''.$module_name.'::'.$module_path.'.partial.proses',
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
        abort_if(Gate::denies('create_produksi'), 403);
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
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];

         $module_name_singular = $module_model::create($params);
         toast(''. $module_title.' Created!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }

    public function store(Request $request)
    {

        try {
            
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);

            DB::beginTransaction();
            $input = $request->except('_token');

            $input['image'] = '';
            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/produksi/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $input['image'] = "$fileName";
            }

            $produksis = $this->module_model::create([
                'code' => !empty($input['code']) ? $input['code'] : null,
                'image' => !empty($input['image']) ? $input['image'] : null,
                'karatasal_id' => !empty($input['karatasal_id']) ? $input['karatasal_id'] : null,
                'source_kode' => !empty($input['source_kode']) ? $input['source_kode'] : null,
                'karat_id' => !empty($input['karat_id']) ? $input['karat_id'] : null,
                'model_id' => !empty($input['model_id']) ? $input['model_id'] : null,
                'berat_asal' => !empty($input['berat_asal']) ? $input['berat_asal'] : null,
                'berat' => !empty($input['berat']) ? $input['berat'] : null,
                'tanggal' => !empty($input['tanggal']) ? $input['tanggal'] : null,
                'created_by' => auth()->user()->id,
                'kategoriproduk_id' => !empty($input['kategoriproduk_id']) ? $input['kategoriproduk_id'] : null,
                'harga_jual' => !empty($input['harga_jual']) ? $input['harga_jual'] : 0,
            ]);
            $produksi_id = $produksis->id;

            $product_items = [];
            if(!empty($input['items'])){
                foreach($input['items'] as $val) {
                    $val['produksis_id'] = $produksi_id;
                    $val['shapeberlian_id'] = !empty($val['shapeberlian_id']) ? $val['shapeberlian_id'] : null;
                    $val['kategoriproduk_id'] = !empty($input['kategoriproduk_id']) ? $input['kategoriproduk_id'] : null;

                    $val['model_id'] = !empty($val['model_id']) ? $val['model_id'] : null;
                    $val['karat_id'] = !empty($val['karat_id']) ? $val['karat_id'] : null;
                    $val['berat_asal_item'] = !empty($val['berat_asal_item']) ? $val['berat_asal_item'] : null;
                    $val['berat'] = !empty($val['berat']) ? $val['berat'] : null;

                    if(!empty($val['karatberlians']) || (!empty($val['model_id'])) && !empty($val['berat']) ) {
                        $product_items[] = $val;
                    }
                }
            }

            if(!empty($product_items)) {
                $arraySertifikatAttributes = [];
                $hari_ini = new DateTime();
                $hari_ini = $hari_ini->format('Y-m-d');
                $arrayProdukItems = [];
                foreach($product_items as $val) {
                    $sertifikat = !empty($val['sertifikat']) ? $val['sertifikat'] : [];

                    /** Insert sertifikat per diamond. NOTE : (formnya di depan sudah ditakedown tapi fungsinya tetap ada, jaga jaga nanti akan dipakai)
                     * jika produk items sertifikatnya terisi
                     * maka insert sertifikat terlbih dahulu
                     * lalu id certifikatnya dicolect dan dimasukkan ke produk items
                     * array sertifikatnya diisi dari form sertifikat (yang sekarang sudah ditake down karena jsr itu satu perhiasan satu certifikat kecuali GIA)
                     * kolom gia certifikatnya sendiri sudah disediakan yaitu gia_report_number
                     * dimana hanya akan menyimpan kode sertifikatnya saja, detailnya bisa dilihat / dicek di website GIA nya.
                     */
                    if(!empty($sertifikat)) {
                        $attribute = !empty($sertifikat['attribute']) ? $sertifikat['attribute'] : [];
                        if(isset($sertifikat['attribute'])) {
                            unset($sertifikat['attribute']);
                        }
                        $sertifikat['tanggal'] = !empty($sertifikat['tanggal']) ? $sertifikat['tanggal'] : $hari_ini;
                        $sertifikat['code'] = !empty($sertifikat['code']) ? $sertifikat['code'] : '-';
                        $diamond_certificate = DiamondCertifikatT::create($sertifikat);
                        $arraySertifikatAttributes[$diamond_certificate->id] = $attribute;
                        $val['diamond_certificate_id'] = $diamond_certificate->id;
                    }
                    if(isset($val['sertifikat'])) {
                        unset($val['sertifikat']);
                    }
                    $arrayProdukItems[] = $val;
                }

                ProduksiItems::insert($arrayProdukItems);
                
                $dataInsertSertifikatAttribute = [];
                if(!empty($arraySertifikatAttributes)) {
                    foreach($arraySertifikatAttributes as $key => $val) { 
                        foreach($val as $k => $row){
                            $dataInsertSertifikatAttribute[] = [
                                'diamond_certificate_id' => $key,
                                'diamond_certificate_attributes_id' => $k,
                                'keterangan' => !empty($row['keterangan']) ? $row['keterangan'] : '',
                            ];
                        }
                    }
                }else{
                    $dataInsertSertifikatAttribute = !empty($input['sertifikat']['attribute']) ? $input['sertifikat']['attribute'] : [];
                    foreach($dataInsertSertifikatAttribute as $k => $row) {
                        $dataInsertSertifikatAttribute[$k]['diamond_certificate_id'] = $diamond_certificate->id;
                        $dataInsertSertifikatAttribute[$k]['diamond_certificate_attributes_id'] = $k;
                        $dataInsertSertifikatAttribute[$k]['keterangan'] = !empty($row['keterangan']) ? $row['keterangan'] : '';
                    }
                }

                DiamondCertificateAttribute::insert($dataInsertSertifikatAttribute);
            }

            $stok_lantakan = StockKroom::where('karat_id', $produksis->karatasal_id)->first();

            $produksis->stock_kroom()->attach($stok_lantakan->id,[
                'karat_id'=>$produksis->karatasal_id,
                'in' => false,
                'berat_real' => -1 * $produksis->berat_asal,
                'berat_kotor' => -1 * $produksis->berat_asal
            ]);

            $berat_real = $stok_lantakan->history->sum('berat_real');
            $berat_real = $stok_lantakan->weight - $produksis->berat_asal;
            $stok_lantakan->update(['weight'=> $berat_real]);

        } catch (\Throwable $th) {
            DB::rollBack();
            if(!empty($file)) {
                Storage::disk('public')->delete($file);
            }
            return $th->getMessage();
        }
        DB::commit();
        activity()->log(' '.auth()->user()->name.' input data pembuatan stok produksi ' . !empty($produksis->id) ? $produksis->id : '');
        toast(''. $this->module_title.' Berhasil dibuat!', 'success');
        return redirect()->route('stok.lantakan');

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
        $validator = FacadesValidator::make($request->all(),
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

            DB::beginTransaction();

            $module_name_singular = $module_model::findOrFail($id);
            $product_items = ProduksiItems::where('produksis_id', $id);

            $stok_lantakan = StockKroom::where('karat_id', $module_name_singular->karatasal_id)->first();

            $module_name_singular->stock_kroom()->attach($stok_lantakan->id,[
                'karat_id'=>$module_name_singular->karatasal_id,
                'in' => true,
                'berat_real' => $module_name_singular->berat_asal,
                'berat_kotor' => $module_name_singular->berat_asal
            ]);

            $berat_real = $stok_lantakan->history->sum('berat_real');
            $stok_lantakan->update(['weight'=> $berat_real]);

            $module_name_singular->delete();
            $product_items->delete();

            DB::commit();
            toast(''. $module_title.' Deleted!', 'success');
            return redirect()->route(''.$module_name.'.index');

        } catch (\Exception $e) {
            DB::rollBack();
            toast(''. $module_title.' error!', 'warning');
            return redirect()->back();
        }

    }

}
