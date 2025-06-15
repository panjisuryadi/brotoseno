<?php

namespace Modules\PenerimaanBarangDP\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
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
use Modules\PenerimaanBarangDP\Models\PaymentDetail;
use Modules\PenerimaanBarangDP\Models\PenerimaanBarangDP;
use Modules\PenerimaanBarangDP\Models\PenerimaanBarangDPPayment;
use PDF;

class PenerimaanBarangDPsController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'PenerimaanBarangDP';
        $this->module_name = 'penerimaanbarangdp';
        $this->module_path = 'penerimaanbarangdps';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\PenerimaanBarangDP\Models\PenerimaanBarangDP";

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
        abort_if(Gate::denies('access_'.$module_name.'s'), 403);
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

        $$module_name = $module_model::orderBy('updated_at','desc')->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view($module_name.'::'.$module_path.'.includes.action',
                            compact('module_name', 'data', 'module_model','module_path'));
                                })
                          ->editColumn('invoice', function ($data) {
                            $tb = '<div class="text-xs font-semibold">
                            ' . $data->no_barang_dp . '
                           </div>';
                         $tb .= '<div class="text-xs text-left">
                            ' . tanggal($data->date) . '
                           </div>'; 
                           return $tb;
                            })
                            ->editColumn('konsumen', function ($data) {
                                $tb = '<div class="">
                                       <h3 class="text-xs font-medium text-gray-800">Nama : 
                                        ' .$data->owner_name . '</h3>
                                        <p class="text-xs font-medium text-gray-800">Kontak : 
                                        ' .$data->contact_number . '</p>
                                        <p class="text-xs font-medium text-gray-800">Alamat : 
                                        ' .$data->address . '</p>
                                       </div>';
                                   return $tb;
                               })
                            ->editColumn('cabang', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <h3 class="text-xs font-medium text-gray-800">
                                    ' .$data->cabang->name . '</h3>
                                    </div>';
                                return $tb;
                            })
                            ->editColumn('barang', function ($data) {
                                $tb = '<div>
                                        <h3 class="text-xs font-medium text-gray-800">Karat : 
                                        ' .$data->product->karat?->label . '</h3>
                                        <p class="text-xs font-medium text-gray-800">Berat : 
                                        ' .$data->product->berat_emas . ' gr</p>
                                        </div>';
                                    return $tb;
                            })
                            ->editColumn('nominal', function ($data) {
                                $tb = '<div>
                                        <h3 class="text-xs font-medium text-gray-800">Nominal :
                                        ' .format_uang($data->nominal) . '</h3>
                                        <h3 class="text-xs font-medium text-gray-800">Biaya Box :
                                        ' .format_uang($data->box_fee) . '</h3>
                                        </div>';
                                    return $tb;
                            })
                            ->editColumn('pembayaran', function ($data) {
                                if ($data->payment->type == 1) 
                     {
                         $info =  'Jatuh Tempo';
                         $pembayaran =  tanggal(@$data->payment->detail->first()->due_date);
                         
                     }else if ($data->payment->type == 2) 
                     {
                         $info =  'Cicilan';
                         $pembayaran =  @$data->payment->cicil .' kali';
                     }
                        $tb ='<div class="items-left text-left">
                              <div class="small text-gray-800">'.$info.'</div>
                              <div class="text-xs text-gray-800 font-bold">' .$pembayaran. '</div>
                              </div>';
                             return $tb;
                             
                            })
                           
                        ->rawColumns(['updated_at', 'action', 'invoice','konsumen','kadar','cabang','barang','nominal','pembayaran'])
                        ->make(true);
                     }

    public function index_data_payment(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::query()
                    ->whereRelation('payment','is_lunas', false)
                    ->whereHas('payment.detail', function(Builder $query){
                        $query->whereNull('paid_date')
                                ->whereDate('due_date','<=',now());
                    })
                    ->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                        $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view($module_name.'::'.$module_path.'.includes.action',
                            compact('module_name', 'data', 'module_model','module_path'));
                                })
                        ->editColumn('invoice', function ($data) {
                            $tb = '<div class="text-xs font-semibold">
                            ' . $data->no_barang_dp . '
                        </div>';
                        $tb .= '<div class="text-xs text-left">
                            ' . tanggal($data->date) . '
                        </div>'; 
                        return $tb;
                            })
                            ->editColumn('konsumen', function ($data) {
                                $tb = '<div class="">
                                    <h3 class="text-xs font-medium text-gray-800">Nama : 
                                        ' .$data->owner_name . '</h3>
                                        <p class="text-xs font-medium text-gray-800">Kontak : 
                                        ' .$data->contact_number . '</p>
                                        <p class="text-xs font-medium text-gray-800">Alamat : 
                                        ' .$data->address . '</p>
                                    </div>';
                                return $tb;
                            })
                            ->editColumn('cabang', function ($data) {
                            $tb = '<div class="items-center text-center">
                                    <h3 class="text-xs font-medium text-gray-800">
                                    ' .$data->cabang->name . '</h3>
                                    </div>';
                                return $tb;
                            })
                            ->editColumn('barang', function ($data) {
                                $tb = '<div>
                                        <h3 class="text-xs font-medium text-gray-800">Karat : 
                                        ' .$data->product->karat?->label . '</h3>
                                        <p class="text-xs font-medium text-gray-800">Berat : 
                                        ' .$data->product->berat_emas . ' gr</p>
                                        </div>';
                                    return $tb;
                            })
                            ->editColumn('nominal', function ($data) {
                                $tb = '<div>
                                        <h3 class="text-xs font-medium text-gray-800">Nominal :
                                        ' .format_uang($data->nominal) . '</h3>
                                        <h3 class="text-xs font-medium text-gray-800">Biaya Box :
                                        ' .format_uang($data->box_fee) . '</h3>
                                        </div>';
                                    return $tb;
                            })
                            ->editColumn('pembayaran', function ($data) {
                                if ($data->payment->type == 1) 
                    {
                        $info =  'Jatuh Tempo';
                        $pembayaran =  tanggal(@$data->payment->detail->first()->due_date);
                        
                    }else if ($data->payment->type == 2) 
                    {
                        $next_payment = $data->payment->detail()->whereNull('paid_date')->orderBy('order_number','asc')->first();
                        $info =  '';
                        $pembayaran =  '(Cicilan ke - '. $next_payment->order_number .')';
                        if(!empty($next_payment)){
                            $info = '
                            <p>Jatuh tempo'. tanggal($next_payment->due_date) .'</p>
                            
                            ';
                        }
                    }
                        $tb ='<div class="items-left text-left">
                            <div class="text-xs">'.$info.'</div>
                            <div class="text-xs font-bold">' .$pembayaran. '</div>
                            </div>';
                            return $tb;
                            
                            })
                        
                        ->rawColumns(['updated_at', 'action', 'invoice','konsumen','kadar','cabang','barang','nominal','pembayaran'])
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
            $no_barang_dp = $this->generateInvoice();
            abort_if(Gate::denies('create_'.$module_name.'s'), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
               compact('module_name',
                'module_action',
                'module_title',
                'no_barang_dp',
                'module_icon', 'module_model'));
        }

        private function generateInvoice(){
            $lastString = $this->module_model::orderBy('id', 'desc')->value('no_barang_dp');
            $numericPart = (int) substr($lastString, 3);
            $incrementedNumericPart = $numericPart + 1;
            $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
            $nextString = "DP-" . $nextNumericPart;
            return $nextString;
        }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_default(Request $request)
    {
         abort_if(Gate::denies('create_penerimaanbarangdp'), 403);
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
        $module_action = 'Store';

       $request->validate([
         'no_barang_dp' => 'required|max:255|unique:'.$module_model.',no_barang_dp',
         'cabang_id' => 'required|exists:cabangs,id',
         'date' => 'required',
         'nama_pemilik' => 'required',
         'no_hp' => 'required',
         'alamat' => 'required',
         'kadar' => 'required',
         'berat' => 'required',
         'nominal_dp' => 'required',
         'tipe_pembayaran' => 'required',
         'cicil' => 'required_if:tipe_pembayaran,cicil',
         'tgl_jatuh_tempo' => 'required_if:tipe_pembayaran,jatuh_tempo'
          ]);
        $input = $request->all();
        $input = $request->except(['document']);
       
        DB::beginTransaction();
        try{
            $$module_name_singular = $module_model::create([
                'no_barang_dp' => $input['no_barang_dp'],
                'cabang_id' => $input['cabang_id'],
                'date' => $input['date'],
                'owner_name'=> $input['nama_pemilik'],
                'contact_number' => $input['no_hp'],
                'address' => $input['alamat'],
                'karat_id' => $input['kadar'],
                'weight' => $input['berat'],
                'nominal' => $input['nominal_dp'],
                'note' => $input['keterangan']??null
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
                    $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))->toMediaCollection('images');
                        //$params['image'] = "$newFilename";
                    }
    
    
                  if ($request->has('document')) {
                        foreach ($request->input('document', []) as $file) {
                            $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                        }
                    }
                    $$module_name_singular->payment()->create([
                        'tipe_pembayaran' => $input['tipe_pembayaran'],
                        'jatuh_tempo'     => $input['tgl_jatuh_tempo'] ?? null,
                        'cicil'           => $input['cicil'] ?? 0,
                        'lunas'           => $input['tipe_pembayaran'] == 'lunas' ? 'lunas': null,
                    ]);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
                 toast('Penerimaan Barang DP Berhasil dibuat!', 'success');

             return redirect()->route($this->module_name .'.index');
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
        abort_if(Gate::denies('access_'.$module_name.'s'), 403);
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

    public function print(PenerimaanBarangDP $item){
        $datetime = Carbon::parse($item->created_at);
        $filename = "Penerimaan Barang DP " . ucwords($item->invoice) . " " . $item->cabang->name . " " . ucwords($item->owner_name);
        $pdf = PDF::loadView('penerimaanbarangdp::penerimaanbarangdps.includes.print',compact('item','filename','datetime'));
        return $pdf->stream($filename.'.pdf');
    }

    public function payment(){
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.'s'), 403);
         return view(''.$module_name.'::'.$module_path.'.payment',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }

    public function edit_payment($id)
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
        $module_action = 'Update Status';
        abort_if(Gate::denies('edit_'.$module_name.'s'), 403);
        $dp = PenerimaanBarangDP::find($id);
        $dp->load('payment.detail');
        $payment = $dp->payment;
        $remainder = $dp->nominal - $payment->detail->sum('nominal');
        $type = $payment->type;
        $datas = $payment->detail()->whereNull('paid_date')->orderBy('order_number','asc');
        $is_last = count($datas->get()) === 1;
        $data = $datas->first();
        return view(''.$module_name.'::'.$module_path.'.modal.edit_payment',
            compact('module_name',
            'module_action',
            'data',
            'module_title',
            'remainder',
            'type',
            'is_last',
            'module_icon', 'module_model'));
    }

    public function update_payment (Request $request){
        $payment_id = $request->post('payment_id');
        $remainder = $request->post('remainder');
        $is_last = $request->post('is_last');
        $nominal = $request->post('nominal');
        $box_fee = $request->post('box_fee');
        try {
                $validator = \Validator::make($request->all(),[
                    'nominal' => [
                        'required',
                        'numeric',
                        function ($attribute, $value, $fail) use ($is_last,$remainder) {
                            if($is_last){
                                if($value != $remainder){
                                    $fail("Nominal lebih kecil dari sisa yang harus dibayarkan");
                                }
                            }else{
                                if($value < 0){
                                    $fail("Nominal harus lebih besar dari 0");
                                }
                            }
                            if ($value > $remainder) {
                                $fail("Nominal lebih besar dari sisa yang harus dibayarkan");
                            }
                        },
                    ],
                    'box_fee' => [
                        'required',
                        'numeric',
                        function ($attribute, $value, $fail) {
                            if($value < 0){
                                $fail("Biaya box tidak boleh bernilai negatif"); 
                            }
                        },
                    ],
                ]);
                
                if (!$validator->passes()) {
                    return response()->json(['error'=>$validator->errors()]);
                }
                        
                DB::beginTransaction();
                $detail = PaymentDetail::findOrFail($payment_id);
                $detail->paid_date = now();
                $detail->nominal = $nominal;
                $detail->pic_id = auth()->id();
                $detail->box_fee = $box_fee;
                $detail->save();
                DB::commit();
        
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['failed'=> $e->getMessage()]);
        }
    
        return response()->json(['success'=>' Sukses update pembayaran.']);
    }

    public function payment_detail_print(PaymentDetail $detail){
        $date = Carbon::parse($detail->paid_date);
        $filename = "Struk Pembayaran Barang DP #" . ucwords($detail->payment->penerimaan_barang_dp->no_barang_dp) . " ke - " . $detail->order_number;
        $dp = $detail->payment->penerimaan_barang_dp;
        $pdf = PDF::loadView('penerimaanbarangdp::penerimaanbarangdps.includes.payment_detail_print',compact('detail','filename','date','dp'));
        return $pdf->stream($filename.'.pdf');
    }
}
