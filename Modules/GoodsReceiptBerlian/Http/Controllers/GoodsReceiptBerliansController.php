<?php

namespace Modules\GoodsReceiptBerlian\Http\Controllers;

use App\Models\LookUp;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Adjustment\Entities\AdjustmentSetting;
use App\Models\User;
use DateTime;
use Modules\GoodsReceiptBerlian\Models\QcAttribute;
use Modules\People\Entities\Supplier;
use Lang;
use Image;
use Illuminate\Support\Facades\DB;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\GoodsReceipt\Models\GoodsReceiptInstallment;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\Produksi\Models\Accessories;
use Modules\Produksi\Models\AccessoriesBerlianDetail;
use Modules\Produksi\Models\DiamondCertificateAttribute;
use Modules\Produksi\Models\DiamondCertifikatT;
use Modules\Produksi\Models\ProduksiItems;

class GoodsReceiptBerliansController extends Controller
{
    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_categories;
    private $module_products;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Good Receipt Berlian';
        $this->module_name = 'goodsreceiptberlian';
        $this->module_path = 'goodsreceiptberlians';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_name_singular = Str::singular($this->module_name);
        $module_action = 'List';
        $data = [
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_action' => $module_action,
            'module_icon' => $this->module_icon,
            'module_model' => $this->module_model,
        ];
        abort_if(Gate::denies('access_'.$this->module_name.''), 403);
        return view(''.$this->module_name.'::' . $this->module_path .'.index',$data);
    }
    
    public function indexqc()
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_name_singular = Str::singular($this->module_name);
        $module_action = 'List';
        $data = [
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_action' => $module_action,
            'module_icon' => $this->module_icon,
            'module_model' => $this->module_model,
        ];
        abort_if(Gate::denies('access_'.$this->module_name.''), 403);
        return view(''.$this->module_name.'::' . $this->module_path .'.qc.index',$data);
    }

    public function index_data(Request $request)
    {
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        // $module_name = \Modules\GoodsReceipt\Models\GoodsReceipt::with('pembelian');
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;

        $$module_name = $module_model::with('pembelian')->where('kategoriproduk_id', $id_kategoriproduk_berlian)->latest()->get();;
        if($request->has('is_qc')){
            $$module_name->where('is_qc', $request->input('is_qc'));
        }
        // $module_name->latest()->get();
        
        return Datatables::of($$module_name)

            ->addColumn('action', function ($data) {
                $module_name = 'goodsreceipt';
                $module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";
                $is_berlian = true;
                return view('goodsreceipt::goodsreceipts.action',
                    compact('module_name', 'data', 'is_berlian', 'module_model'));
                })

            ->editColumn('image', function ($data) {
                    if ($data->images) {
                        $url = asset(imageUrl(). @$data->images);
                    } else {
                        $url = $data->getFirstMediaUrl('pembelian', 'thumb');
                    }
                    return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
                })

            ->editColumn('date', function ($data) {
                    $tb = '<div class="text-xs font-semibold">
                        ' .$data->code . '
                    </div>';
                    $tb .= '<div class="text-xs text-left">
                        ' .tanggal($data->date) . '
                    </div>';   
                    return $tb;
                }) 
            ->editColumn('code', function ($data) {
                    $tb = '<div class="text-xs text-blue-500 font-semibold items-center text-center">
                            ' .$data->code . '
                        </div>';
                    return $tb;
                }) 

            ->editColumn('berat', function ($data) {
                    $tb = '<div class="text-xs">
                            Berat Kotor :' .$data->total_berat_kotor . '
                        </div>';
                        $tb .= '<div class="text-xs text-left">
                        Total Emas :' .$data->total_emas . '
                        </div>';   
                    return $tb;
                }) 

            ->editColumn('harga', function ($data) {
                    $tb = '<div class="text-xs">
                        Gram : <span class="font-semibold">' .$data->selisih . '</span>
                        </div>';
                        $tb .= '<div class="text-xs text-left">
                            Nominal :<span class="font-semibold">' .number_format($data->selisih) . '</span>
                        </div>';   
                    return $tb;
                })
            ->editColumn('pembayaran', function ($data) {
                if(!empty($data->pembelian->tipe_pembayaran)){
                    if ($data->pembelian->tipe_pembayaran == 'jatuh_tempo') {
                        $info =  'Jatuh Tempo';
                        $pembayaran =  tgljam(@$data->pembelian->jatuh_tempo);
                        if(!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $info .=' (Lunas) ';
                        }
                    }else if ($data->pembelian->tipe_pembayaran == 'cicil') {
                        $info =  'Cicilan';
                        $pembayaran =  @$data->pembelian->cicil .' kali';
                        if(!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $pembayaran .=' (Lunas) ';
                        }
                    } else {
                        $info =  '';
                        $pembayaran =  'Lunas';
                    }
                    $tb ='<div class="items-left text-left">
                            <div class="small text-gray-800">'.$info.'</div>
                            <div class="text-gray-800">' .$pembayaran. '</div>
                            </div>';
                    return $tb;
                }
                })

            ->editColumn('supplier', function ($data) {
                    $tb = '<div class="items-left text-left">
                        <div>'.$data->supplier->supplier_name . '</div>
                        </div>';
                    return $tb;
                })
            ->editColumn('updated_at', function ($data) {
                    $diff = Carbon::now()->diffInHours($data->updated_at);
                    if ($diff < 25) {
                        return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                    } else {
                        return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                    }
                })
                
            ->editColumn('keterangan', function ($data) {
                return $data->getBerlianShortLabelAttribute();
            })
                
            ->editColumn('note', function ($data) {
                return '';
            })
            ->rawColumns(['updated_at',
                'date',
                'action',
                'code',
                'berat',
                'harga',
                'image', 
                'pembayaran', 
                'supplier', 
                'nama_produk'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create_qc()
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_name_singular = Str::singular($this->module_name);
        $code = $this->module_model::generateCode();
        $kasir = User::role('Kasir')->orderBy('name')->get();
        $module_action = 'Create';
        $dataSupplier = Supplier::all();
        $qcattribute = QcAttribute::all();
        
        $data = [
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_action' => $module_action,
            'module_icon' => $this->module_icon,
            'module_model' => $this->module_model,
            'code' => $code,
            'kasir' => $kasir,
            'dataSupplier' => $dataSupplier,
            'qcAttribute' => $qcattribute,
        ];
        abort_if(Gate::denies('add_'.$this->module_name.''), 403);
        return view(''.$this->module_name.'::'.$this->module_path.'.qc.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_qc(Request $request)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        
        try {
            $module_name_singular = Str::singular($this->module_name);
            $input = $request->except('_token','document');
            $input['images'] = '';
            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $input['images'] = "$fileName";
            }

            DB::beginTransaction();

            // if(!empty($input['sertifikat']) || !empty($input['sertifikat']['code'])) {
            //     $sertifikat = $input['sertifikat'];
            //     if(isset($sertifikat['attribute'])) {
            //         unset($sertifikat['attribute']);
            //     }
            //     $diamond_certificate = DiamondCertifikatT::create($sertifikat);
            // }

            $goodsreceipt = $this->module_model::create([
                'code'                  => $input['code'],
                'date'                  => $input['tanggal'],
                'no_invoice'            => $input['code'],
                'total_berat_kotor'     => !empty($input['total_berat_kotor']) ? $input['total_berat_kotor'] :  0,
                'total_emas'            => !empty($input['total_emas']) ? $input['total_emas'] :  0,
                'berat_timbangan'       => !empty($input['berat_timbangan']) ? $input['berat_timbangan'] :  0,
                'total_karat'           => !empty($input['total_karat']) ? $input['total_karat'] :  0,
                'pengirim'              => !empty($input['pengirim']) ? $input['pengirim'] :  0,
                'harga_beli'            => !empty($input['harga_beli']) ? $input['harga_beli'] :  0,
                'tipe_penerimaan_barang'=> !empty($input['tipe_penerimaan_barang']) ? $input['tipe_penerimaan_barang'] :  null,
                'currency_id'           => !empty($input['currency_id']) ? $input['currency_id'] :  1,
                'supplier_id'           => $input['supplier_id'],
                'karat_id'              => $input['karat_id'],
                'user_id'               => $input['pic_id'],
                'nama_produk'           => $input['nama_produk'],
                'kategoriproduk_id'     => $input['kategoriproduk_id'],
                'images'                => $input['images'],
                'tipe_pembayaran'       => $input['tipe_pembayaran'],
                // 'diamond_certificate_id'=> isset($diamond_certificate->id) ? $diamond_certificate->id : null,
                'is_qc'                 => 1,
            ]);
            $goodsreceipt_id = $goodsreceipt->id;
            $tipe_penerimaan_barang = !empty($input['tipe_penerimaan_barang']) ? $input['tipe_penerimaan_barang'] :  null;

            $goodsreceipt_id = $goodsreceipt->id;
            $this->_saveTipePembelian($input ,$goodsreceipt_id);

            $product_items = [];
            if(!empty($input['items'])){
                foreach($input['items'] as $val) {
                    $val['goodsreceipt_id'] = $goodsreceipt->id;
                    $val['shapeberlian_id'] = !empty($val['shapeberlian_id']) ? $val['shapeberlian_id'] : null;
                    $val['kategoriproduk_id'] = !empty($input['kategoriproduk_id']) ? $input['kategoriproduk_id'] : null;

                    $val['model_id'] = !empty($val['model_id']) ? $val['model_id'] : $goodsreceipt->model_id;
                    $val['karat_id'] = !empty($val['karat_id']) ? $val['karat_id'] : $goodsreceipt->karat_id;
                    
                    $val['berat_real'] = !empty($val['berat_real']) ? $val['berat_real'] : 0;
                    $val['berat_kotor'] = !empty($val['berat_kotor']) ? $val['berat_kotor'] : 0;
                    $val['diamond_certificate_id'] = null;

                    if(!empty($val['karatberlians']) || (!empty($val['model_id'])) && !empty($val['berat']) ) {
                        $product_items[] = $val;
                    }
                }
            }

            if(!empty($product_items)) {
                $arraySertifikatAttributes = [];
                $hari_ini = new DateTime();
                $hari_ini = $hari_ini->format('Y-m-d');
                $arrayProdukItems = $arrayGoodsreceiptItems = [];
                foreach($product_items as $k => $val) {
                    $sertifikat = !empty($val['sertifikat']) ? $val['sertifikat'] : [];

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
                    
                    $arrayGoodsreceiptItems[$k] = $val;
                    if(!empty($goodsreceipt->tipe_penerimaan_barang) && $goodsreceipt->tipe_penerimaan_barang == 1 && !empty($goodsreceipt->karat_id)) {
                        $arrayGoodsreceiptItems[$k]['status'] = 2;
                    }


                }
                $total_harga_beli = 0;
                foreach($arrayGoodsreceiptItems as $key => $item) {
                    $type = $tipe_penerimaan_barang;
                    $karatberlians = !empty($item['karatberlians']) ? $item['karatberlians'] : 0;
                    $harga_beli = !empty($item['harga_beli']) ? $item['harga_beli'] : 0;
                    $total_harga_beli += $harga_beli;
                    $accessories = Accessories::create([
                        'code' => Accessories::generateCodeBerlian(),
                        'name' => 'Berlian ' . ($type == 2 ? 'Mata Tabur' : ''),
                        'amount' => $karatberlians,
                        'type' => 1, // tipe 1 berlian 2 non berlian default value = 2
                        'satuan_id' => 2, //satuan Carat (ct) =>table satuans_m
                    ]);
                    $accessories_berlian_detail = AccessoriesBerlianDetail::create([
                        'accessories_id' => $accessories->id,
                        'type' => $tipe_penerimaan_barang,
                        'shapeberlian_id' => !empty($item['karatberlians']) ? $item['karatberlians'] : null,
                        'colour' => !empty($item['colour']) ? $item['colour'] : null,
                        'clarity' => !empty($item['clarity']) ? $item['clarity'] : null,
                        'klasifikasi_berlian' => !empty($item['klasifikasi_berlian']) ? $item['klasifikasi_berlian'] : null,
                        'diamond_certificate_id' => null,
                    ]);
                    $arrayGoodsreceiptItems[$key]['accessories_id'] = $accessories->id;
                }

                GoodsReceiptItem::insert($arrayGoodsreceiptItems);
                GoodsReceipt::find($goodsreceipt->id)
                                ->where('harga_beli', '!=', null)
                                ->where('harga_beli', '=', 0)
                                ->update(['harga_beli' => $total_harga_beli]);

                if(!empty($goodsreceipt->tipe_penerimaan_barang) && $goodsreceipt->tipe_penerimaan_barang == 1 && !empty($goodsreceipt->karat_id)) {
                    $produksi_items = ProduksiItems::create([
                        'goodsreceipt_id' => $goodsreceipt_id,
                        'model_id' => !empty($input['model_id']) ? $input['model_id'] : null,
                        'karat_id' => !empty($input['karat_id']) ? $input['karat_id'] : null,
                        'berat' => !empty($input['total_berat_real']) ? $input['total_berat_real'] :  0,
                        'kategoriproduk_id' => !empty($input['kategoriproduk_id']) ? $input['kategoriproduk_id'] : null,
                    ]);
                }
                
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

            // $qcattribute_data = [];
            // if(!empty($input['items'])){
            //     foreach($input['items'] as $val) {
            //         $val['goodsreceipt_id'] = $goodsreceipt_id;
            //         $val['kategoriproduk_id'] = $goodsreceipt->kategoriproduk_id;
            //         $val['berat_real'] = !empty($val['berat_real']) ? $val['berat_real'] : 0;
            //         $val['berat_kotor'] = !empty($val['berat_kotor']) ? $val['berat_kotor'] : 0;
            //         $val['shapeberlian_id'] = !empty($val['shapeberlian_id']) ? $val['shapeberlian_id'] : null;
            //         if(!empty($val['karatberlians'])) {
            //             $qcattribute_data[] = $val;
            //         }
            //     }
            // }

            // if(!empty($qcattribute_data)) {
            //     GoodsReceiptItem::insert($qcattribute_data);
            // }

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        DB::commit();
        activity()->log(' '.auth()->user()->name.' input data penerimaan QC');
        toast(''. $this->module_title.' QC Created!', 'success');
        return redirect()->route(''.$this->module_name.'.qc.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show_qc($id)
    {
        $id = decode_id($id);
        $module_name_singular = Str::singular($this->module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$this->module_name.''), 403);
        $detail = $this->module_model::with('goodsReceiptQcAttribute.qcAttribute','supplier')->findOrFail($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(''.$this->module_name.'::'.$this->module_path.'.qc.show',
        compact('module_name',
        'module_action',
        'detail',
        'module_title',
        'module_icon', 'module_model'));

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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit_qc($id)
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
        $dataSupplier = Supplier::all();
          return view(''.$module_name.'::'.$module_path.'.qc.edit',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'dataSupplier',
            'module_icon', 'module_model'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update_qc(Request $request)
    {
        try {
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_model = $this->module_model;
            $id = $request->input('id');

            DB::beginTransaction();
            
            $data = $module_model::findOrFail($id);
            $params = $request->except('_token', 'code');
            $keterangan = isset($params['keterangan']) && is_array($params['keterangan']) ? $params['keterangan'] : [];
            $notes = isset($params['note']) && is_array($params['note']) ? $params['note'] : [];
            $ids = isset($params['attributesqc_id']) && is_array($params['attributesqc_id']) ? $params['attributesqc_id'] : [];

            $params['images'] =  "";
            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $params['images'] = "$fileName";
            }

            $update_data = [
                'date'                  => $params['tanggal'],
                'total_berat_kotor'     => 0,
                'berat_timbangan'       => 0,
                'supplier_id'           => $params['supplier_id'],
                'nama_produk'           => $params['nama_produk'],
                'kategoriproduk_id'     => $params['kategoriproduk_id'],
                'images'                => isset($params['images']) ? $params['images'] : '',
                'is_qc'                 => 1,
            ];
            $data->update($update_data);
            
            $goodsreceipt_id = $id;
            
            $qcattribute_data = [];
            foreach ($keterangan as $key => $value) {
                $qcattribute_data[] = [
                    'id' => $key,
                    'goodsreceipt_id' => $goodsreceipt_id,
                    'attributesqc_id' => isset($ids[$key]) ? $ids[$key] :'',
                    'keterangan' => $value,
                    'note' => isset($notes[$key]) ? $notes[$key] :'',
                ];
            }
            GoodsReceiptQcAttribute::upsert($qcattribute_data, ['id']);
            DB::commit();
        } catch (\Throwable $th) {
            return $th->getMessage();
            DB::rollBack();
            toast($th->getMessage() .' '. $module_title.' QC Not Updated!', 'failed');
            return redirect()->back();
        }
        activity()->log(' '.auth()->user()->name.' update goodreceipts berlian qc');
        toast(''. $module_title.' QC Updated!', 'success');
        return redirect()->route(''.$module_name.'.qc.index');
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


    private function _saveTipePembelian($input ,$goodsreceipt)
    {
        $tipe_pembayaran = TipePembelian::create([
        'goodsreceipt_id'             => $goodsreceipt,
        'tipe_pembayaran'             => $input['tipe_pembayaran'] ?? null,
        'jatuh_tempo'                 => $input['tgl_jatuh_tempo'] ?? null,
        'cicil'                       => $input['cicil'] ?? 0,
        'lunas'                       => $input['lunas'] ?? null,
        ]);

        if($tipe_pembayaran->isCicil()){
            foreach($input['detail_cicilan'] as $key => $value){
                GoodsReceiptInstallment::create([
                    'payment_id' => $tipe_pembayaran->id,
                    'nomor_cicilan' => $key,
                    'tanggal_cicilan' => $input['detail_cicilan'][$key]
                ]);
            }
        }

    }


    /** DEBTS */

    public function debts()
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
        abort_if(Gate::denies('access_goodsreceipts'), 403);
        return view(''.$module_name.'::'.$module_path.'.debts.index',
        compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 
            'module_model'));
    }

    public function debts_data(Request $request) 
    {
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $kategoriproduk_id = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');
        $data = $module_model::debts()
                        ->where('tipe_pembayaran', '!=', 'lunas')
                        ->where(function($query) use ($kategoriproduk_id) {
                            $query->orWhere('kategoriproduk_id', $kategoriproduk_id);
                        })
                        ->latest()->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                
                $module_name = 'goodsreceipt';
                $module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";
                $is_berlian = true;
                return view('goodsreceipt::goodsreceipts.debts.action',
                compact('module_name', 'data', 'is_berlian', 'module_model'));
            })

            ->editColumn('image', function ($data) {
                if ($data->images) {
                    $url = asset(imageUrl(). @$data->images);
                } else {
                    $url = $data->getFirstMediaUrl('pembelian', 'thumb');
                }
                return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->editColumn('date', function ($data) {
                $tb = '<div class="text-xs font-semibold">
                    ' .$data->code . '
                    </div>';
                $tb .= '<div class="text-xs text-left">
                    ' .tanggal($data->date) . '
                    </div>';   
                
                return $tb;
            }) 
            ->editColumn('code', function ($data) {
                $tb = '<div class="text-xs text-blue-500 font-semibold items-center text-center">
                        ' .$data->code . '
                    </div>';
                return $tb;
            }) 

            ->editColumn('berat', function ($data) {
                $tb = '<div class="text-xs">
                        Berat Kotor :' .$data->total_berat_kotor . '
                    </div>';
                $tb .= '<div class="text-xs text-left">
                    Total Emas :' .$data->total_emas . '
                    </div>'; 
                $tb .= '<div class="text-xs text-left">
                    Karat :' .$data->goodsreceiptitem->pluck('karat.label')->implode(', ') . '
                    </div>';   
                return $tb;
            }) 

            ->editColumn('harga', function ($data) {
                $tb = '<div class="text-xs">
                    Gram : <span class="font-semibold">' .$data->selisih . '</span>
                    </div>';
                    $tb .= '<div class="text-xs text-left">
                        Nominal :<span class="font-semibold">' .number_format($data->selisih) . '</span>
                    </div>';   
                return $tb;
            }) 

            ->editColumn('pembayaran', function ($data) {
                if ($data->pembelian->tipe_pembayaran == 'jatuh_tempo') 
                    {
                        $info =  'Jatuh Tempo';
                        $pembayaran =  tgljam(@$data->pembelian->jatuh_tempo);
                        if(!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                            $info .=' (Lunas) ';
                        }
                    }else if ($data->pembelian->tipe_pembayaran == 'cicil') 
                    {
                        $info =  'Cicilan';
                        $pembayaran =  @$data->pembelian->cicil .' kali';
                        if(!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                            $pembayaran .=' (Lunas) ';
                        }
                    }else{
                        $info =  '';
                        $pembayaran =  'Lunas';
                }
                $tb ='<div class="items-left text-left">
                    <div class="small text-gray-800">'.$info.'</div>
                    <div class="text-gray-800">' .$pembayaran. '</div>
                    </div>';
                return $tb;
            })

            ->editColumn('supplier', function ($data) {
                $tb = '<div class="items-left text-left">
                    <div>'.$data->supplier->supplier_name . '</div>
                    </div>';
                return $tb;
            })
        
            ->editColumn('updated_at', function ($data) {

                $diff = Carbon::now()->diffInHours($data->updated_at);
                if ($diff < 25) {
                    return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                } else {
                    return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                }
            })
            ->rawColumns(['updated_at',
                'date',
                'action',
                'code',
                'berat',
                'harga',
                'image', 
                'pembayaran', 
                'supplier', 
                'detail', 
                'name'])
            ->make(true);
    }
}
