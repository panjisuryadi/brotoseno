<?php

namespace Modules\PenjualanSale\Http\Controllers;

use App\Models\LookUp;
use Carbon\Carbon;
use DateTime;
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
use Modules\Karat\Models\Karat;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\PenjualanSale\Models\PenjualanSalesPayment;
use Modules\Stok\Models\PenjualanSalesPaymentDetail;
use Modules\Stok\Models\StockKroom;
use Modules\Stok\Models\StockRongsok;
use PDF;

class PenjualanSalesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Penjualan Sale';
        $this->module_name = 'penjualansale';
        $this->module_path = 'penjualansales';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\PenjualanSale\Models\PenjualanSale";

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
        abort_if(Gate::denies('access_penjualansales'), 403);
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
                          ->editColumn('sales', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->sales->name . '</h3>
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
                        ->editColumn('date', function ($data) {
                            $module_name = $this->module_name;
                            return \Carbon\Carbon::parse($data->updated_at)->format('j F Y');
                        })
                        ->editColumn('total_weight', function ($data) {
                            return $data->detail->sum('jumlah') . " gram";
                            })
                        ->editColumn('total_jumlah', function ($data) {

                            $isPersen = $data->harga_type == 'persen' ? true : false;
                            if($data->harga_type == 'persen' && !empty($data->total_nominal) && empty($data->total_jumlah)) {
                                $isPersen = false;
                            }
                            if($data->harga_type == 'persen' && empty($data->total_nominal) && !empty($data->total_jumlah)) {
                                $isPersen = true;
                            }

                            $result = '';
                            if($isPersen) {
                                $result = formatBerat($data->total_jumlah) ." gram";
                            }else{
                                $result = "Rp. " . rupiah($data->total_nominal);
                            }
                            return $result;

                        })
                        ->editColumn('total_harga', function ($data) {
                            return "Rp . " . number_format($data->detail->sum('nominal'));
                            })
                        ->addColumn('tanggal', function($data) {
                            return \Carbon\Carbon::parse($data->updated_at)->format('j F Y') . " / " . $data->invoice_no;
                        })
                        ->addColumn('konsumen', function($data) {
                            return $data->customer?->customer_name . '/' . $data->customer?->market;
                        })
                        ->addColumn('detail', function($data) {

                            $rows = !empty($data->payment?->detailCicilan) ? $data->payment->detailCicilan : [];
                            $status_bayar = !empty($data->payment?->lunas) ? label_case($data->payment?->lunas) : ($data->payment?->tipe_pembayaran =='lunas' ? 'Lunas' : 'Belum Lunas' );
                            $tb = '
                            <div class="text-xs">
                                <b>Status Pembayaran </b>: '. $status_bayar . '
                            </div>';
                            
                            foreach($rows as $row) {
                                $bayar = !empty($row->jumlah_cicilan) ? formatBerat($row->jumlah_cicilan) . ' gram' : 'Rp. ' .rupiah($row->nominal);
                                $tgl = \Carbon\Carbon::parse($row->created_at)->format('d M, Y H:i:s');
                                $tb .= '
                                    <div class="text-xs">
                                        <b>Tgl Bayar </b> :  ' .$tgl . ' (<b> ' . $bayar . ' </b>)
                                    </div>
                                        ';
                            }
                            return $tb;
                        })
                        ->rawColumns(['updated_at', 
                             'tanggal', 
                             'konsumen', 
                             'sales', 
                             'detail',
                             'action', 
                             'name'])
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
            abort_if(Gate::denies('create_penjualansales'), 403);
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
         abort_if(Gate::denies('create_penjualansale'), 403);
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

    public function cetak($id) {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $detail = $module_model::with('detail')->findOrFail($id);
        $title = 'Print Penjualan Sales';
        $pdf = PDF::loadView(''.$module_name.'::'.$module_path.'.includes.print', compact('detail','title'))
          ->setPaper('A4', 'portrait');
          return $pdf->stream('penjualan_sales-'. $detail->id .'.pdf');


         // return view(''.$module_name.'::'.$module_path.'.includes.print',
         //   compact('module_name',
         //    'detail',
         //    'module_title',
         //    'title',
         //    'module_icon', 'module_model'));


    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit_status($id)
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

        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $data = PenjualanSalesPayment::where('penjualan_sales_id',$id)
                ->with('detailCicilan', 'penjualanSales')
                ->withCount(['detailCicilan as sisa_cicilan' => function (Builder $query) {
                    $query->where(function($q){
                        $q->whereNull('jumlah_cicilan');
                        $q->orWhere('jumlah_cicilan', 0);
                    });
                    $query->where(function($q){
                        $q->WhereNull('nominal');
                        $q->orWhere('nominal', 0);
                    });
                }])
                ->first();
        $dataKarat = Karat::get()->all();

       $isPersen = $data->penjualanSales->harga_type == 'persen' ? true : false;
       if($data->PenjualanSales->harga_type == 'persen' && !empty($data->PenjualanSales->total_nominal) && empty($data->PenjualanSales->total_jumlah)) {
           $isPersen = false;
       }
       if($data->penjualanSales->harga_type == 'persen' && empty($data->penjualanSales->total_nominal) && !empty($data->penjualanSales->total_jumlah)) {
           $isPersen = true;
       } 
       $viewpath = '.modal.edit_status';
       if(!$isPersen) {
           $viewpath = '.modal.edit_status_nominal';
       }
        return view(''.$module_name.'::'.$module_path.$viewpath,
            compact('module_name',
            'module_action',
            'data',
            'dataKarat',
            'module_title',
            'module_icon', 'module_model'));
    }

    public function update_status_pembelian (Request $request){

        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');

        $is_cicilan = $request->post('is_cicilan', false);
        $pembelian_id = $request->post('pembelian_id');
        $tgl_jatuh_tempo = $request->post('tgl_jatuh_tempo',$hari_ini);
        $nominal = $request->post('nominal', 0);
        $jumlah_cicilan = $request->post('jumlah_cicilan',0);
        $sisa_cicilan = $request->post('sisa_cicilan');
        $tipe = $request->post('tipe');
        $total_harus_bayar = $request->post('total_harus_bayar');
        $karat_id = $request->post('karat_id',0);
        $harga = $request->post('harga',0);
        $berat = $request->post('berat',0);
        $gold_price = $request->post('gold_price',0);
        $harga_type = $request->post('harga_type', 'persen');
        // dd($total_harus_bayar);

        DB::beginTransaction();
        try {
            /** Kanggo ngabedakeun bayar setoran uang sareng bayar setoran emas
             * @param $harga_type diambil dari penjualan_sale
             * data lama dianggap harga type na persen
            */
            if ( $harga_type == 'nominal' ) {
                $validator = \Validator::make($request->all(),[
                    'karat_id' => 'required_if:tipe,==,rongsok', 
                    'berat' => 'required_if:tipe,==,rongsok|numeric|gt:-1', 
                    'harga' => 'required_if:tipe,==,rongsok|numeric|gt:-1|lte:100', 
                    'nominal' => [
                        'required',
                        'gt:0',
                        function($attribute, $value, $fail) use($total_harus_bayar) {
                            if ($value > $total_harus_bayar) {
                                $fail('Nominal yang dibayar tidak boleh lebih dari nominal yang harus dibayar (Rp . ' . rupiah($total_harus_bayar) . ')');
                            }
                            
                        }
                    ]
                ]);
                if (!$validator->passes()) {
                    return response()->json(['error'=>$validator->errors()]);
                }
                $sales = PenjualanSalesPayment::with('penjualanSales')->where('id', $pembelian_id)->first();
                $penjualan_sale_detail = PenjualanSalesPaymentDetail::create(
                    [
                        'payment_id' => $pembelian_id,
                        'tanggal_cicilan' => !empty($tgl_jatuh_tempo) ? $tgl_jatuh_tempo : $hari_ini,
                        'nomor_cicilan' => 1,
                        'nominal' => $nominal,
                        'jumlah_cicilan' => $jumlah_cicilan,
                        'karat_id' => $karat_id,
                        'berat' => $berat,
                        'harga' => $harga,
                        'gold_price' => $gold_price,
                        'tipe_emas' => $tipe,
                    ]
                );

                $tipe_pembelian = PenjualanSalesPayment::findOrFail($pembelian_id);
                if ($this->checkHutangNominal($pembelian_id) == $tipe_pembelian->penjualanSales->total_nominal) {
                    $tipe_pembelian->lunas = 'lunas';
                    $tipe_pembelian->save();
                }

                if($tipe == 'lantakan') {
                    $this->createLantakan($penjualan_sale_detail);
                }elseif ($tipe == 'rongsok') {
                    $this->createRongsok($penjualan_sale_detail, $sales);
                }

            } else {
                $validator = \Validator::make($request->all(),[
                    'nominal' => 'required_if:tipe,==,nominal|numeric|gt:-1', 
                    'karat_id' => 'required_if:tipe,==,rongsok', 
                    'berat' => 'required_if:tipe,==,rongsok|numeric|gt:-1', 
                    'harga' => 'required_if:tipe,==,rongsok|numeric|gt:-1|lte:100', 
                    'jumlah_cicilan' => [
                        'required',
                        'gt:0',
                        function($attribute, $value, $fail) use($total_harus_bayar) {
                            if ($value > $total_harus_bayar) {
                                $fail('Jumlah emas yang dibayar tidak boleh lebih dari emas yang harus dibayar (' . $total_harus_bayar . ' gr )');
                            }
                            
                        }
                    ]
                ]);
                if (!$validator->passes()) {
                    return response()->json(['error'=>$validator->errors()]);
                }
                $sales = PenjualanSalesPayment::with('penjualanSales')->where('id', $pembelian_id)->first();
                $penjualan_sale_detail = PenjualanSalesPaymentDetail::create(
                    [
                        'payment_id' => $pembelian_id,
                        'tanggal_cicilan' => !empty($tgl_jatuh_tempo) ? $tgl_jatuh_tempo : $hari_ini,
                        'nomor_cicilan' => 1,
                        'nominal' => $nominal,
                        'jumlah_cicilan' => $jumlah_cicilan,
                        'karat_id' => $karat_id,
                        'berat' => $berat,
                        'harga' => $harga,
                        'gold_price' => $gold_price,
                        'tipe_emas' => $tipe,
                    ]
                );

                $tipe_pembelian = PenjualanSalesPayment::findOrFail($pembelian_id);
                if ($this->checkHutangEmas($pembelian_id) == $tipe_pembelian->penjualanSales->total_jumlah) {
                    $tipe_pembelian->lunas = 'lunas';
                    $tipe_pembelian->save();
                }

                if($tipe == 'lantakan') {
                    $this->createLantakan($penjualan_sale_detail);
                }elseif ($tipe == 'rongsok') {
                    $this->createRongsok($penjualan_sale_detail, $sales);
                }
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['failed'=> $e->getMessage()]);
        }
        DB::commit();

        return response()->json(['success'=>' Sukses update pembelian.']);
    }

    /** Fungsi ini digunakan untuk mengecek apakah masih ada sisa yang harus dibayarkan atau tidak*/
    private function checkHutangEmas($payment_id) {
        return PenjualanSalesPaymentDetail::where('payment_id', $payment_id)->sum('jumlah_cicilan');
    }

    /** Fungsi ini digunakan untuk mengecek apakah masih ada sisa yang harus dibayarkan atau tidak*/
    private function checkHutangNominal($payment_id) {
        return PenjualanSalesPaymentDetail::where('payment_id', $payment_id)->sum('nominal');
    }

    private function createLantakan($penjualan_sale_detail) {
        $stok_lantakan = StockKroom::first();
        if($stok_lantakan) {
            $penjualan_sale_detail->stock_kroom()->attach($stok_lantakan->id,[
                'karat_id'=> $stok_lantakan->karat_id,
                'in' => true,
                'berat_real' => $penjualan_sale_detail->jumlah_cicilan,
                'berat_kotor' => $penjualan_sale_detail->jumlah_cicilan
            ]);

            $stok_lantakan->weight += $penjualan_sale_detail->jumlah_cicilan;
            $stok_lantakan->save();
        }
    }

    private function createRongsok($penjualan_sale_detail, $sales) {
        if(!empty($penjualan_sale_detail->karat_id)) {
            $stock_rongsok = StockRongsok::firstOrCreate(['karat_id' => $penjualan_sale_detail->karat_id]);
            $penjualan_sale_detail->stock_rongsok()->attach($stock_rongsok->id,[
                    'karat_id'=>$penjualan_sale_detail->karat_id,
                    'sales_id' => $sales->penjualanSales->sales_id,
                    'weight' => $penjualan_sale_detail->berat,
            ]);
            $stock_rongsok->weight += $penjualan_sale_detail->berat;
            $stock_rongsok->save();
        }
    }


}
