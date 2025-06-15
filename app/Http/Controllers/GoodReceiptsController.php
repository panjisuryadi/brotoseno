<?php

namespace Modules\GoodsReceipt\Http\Controllers;

use App\Models\LookUp;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Image;
use Modules\GoodsReceipt\Events\GoodsReceiptItemCreated;
use Modules\GoodsReceipt\Models\GoodsReceiptInstallment;
use PDF;
use Modules\Upload\Entities\Upload;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\ParameterKadar\Models\ParameterKadar;
use Modules\Karat\Models\Karat;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Modules\Stok\Models\StockOffice;
use Illuminate\Support\Facades\DB;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\Stok\Models\StockKroom;

class GoodReceiptsController extends Controller
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
        $this->module_title = 'Goods Receipt';
        $this->module_name = 'goodsreceipt';
        $this->module_path = 'goodsreceipts';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";
        $this->module_categories = "Modules\Product\Entities\Category";
        $this->module_products = "Modules\Product\Entities\Product";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        if (AdjustmentSetting::exists()) {
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
        return view(
            '' . $module_name . '::' . $module_path . '.index',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function penerimaans()
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $code = $module_model::generateCode();
        $module_action = 'Create';
        abort_if(Gate::denies('create_goodsreceipts'), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.create',
            compact(
                'module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function riwayat_penerimaan()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.riwayat',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }




    public function index_data_product(Request $request, $kode_pembelian)

    {
        // $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        //$$module_name = $module_model::get();

        $$module_name = $module_model::select(
            'goodsreceipts.*',
            'products.id AS id_produk',
            'karats.name AS krt',
            'products.product_name',
            'products.product_code',
            'products.product_cost',
            'products.product_price',
            'product_items.berat_total'
        )
            ->leftJoin('products', 'goodsreceipts.code', '=', 'products.kode_pembelian')
            ->leftJoin('product_items', 'products.id', '=', 'product_items.product_id')
            ->leftJoin('karats', 'product_items.karat_id', '=', 'karats.id')
            ->where('products.kode_pembelian', $kode_pembelian)
            ->get();


        $data = $$module_name;



        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                $module_products = $this->module_products;
                return view(
                    '' . $module_name . '::' . $module_path . '.actiondetail',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('date', function ($data) {
                $tb = '<div class="text-xs items-left text-left">
                                     ' . tgl1($data->date) . '
                                    </div>';
                return $tb;
            })

            ->editColumn('checkbox', function ($data) {
                $tb = '<div class="checkbox mt-3">
                                          <input type="checkbox" id="tr-checkbox1">
                                          <label for="tr-checkbox1"></label>
                                        </div>';
                return $tb;
            })
            ->editColumn('name', function ($data) {
                $tb = '<div class="text-xs items-left text-left">

                                     <div class="text-gray-500">' . $data->product_code . '</div>
                                     <div class="text-blue-600">' . $data->product_name . '</div>
                                     <div class="text-gray-500">' . $data->berat_total . ' / ' . $data->krt . '</div>
                                    </div>';
                return $tb;
            })
            ->editColumn('qty', function ($data) {
                $tb = '<div class="text-xs text-gray-500 items-center text-center">
                                     Beli ;' . number_format($data->product_cost) . '

                                    </div>';
                $tb .= '<div class="text-xs text-gray-500  items-center text-center">
                                     Jual :' . number_format($data->product_price) . '

                                    </div>';
                return $tb;
            })
            ->editColumn('image', function ($data) {
                $module_products = $this->module_products;
                $produk = $module_products::findOrFail($data->id_produk);
                $images = '<div class="content-center items-center">
                               <img class="w-10 h-10 rounded" src="' . $produk->getFirstMediaUrl('images') . '"
                               style="height:50px; width:50px;">';
                return $images;
            })


            ->rawColumns([
                'updated_at',
                'date',
                'action',
                'checkbox',
                'code',
                'berat',
                'image',
                'qty',
                'detail',
                'name'
            ])
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

        // $$module_name = $module_model::active()->latest()->get();
        $$module_name = $module_model::with('pembelian')->whereNull('kategoriproduk_id')->orWhere('kategoriproduk_id', 1)->latest()->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.action',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('image', function ($data) {
                if ($data->images) {
                    $url = asset(imageUrl() . @$data->images);
                } else {
                    $url = $data->getFirstMediaUrl('pembelian', 'thumb');
                }
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->editColumn('date', function ($data) {
                $tb = '<div class="text-xs font-semibold">
                                     ' . $data->code . '
                                    </div>';
                $tb .= '<div class="text-xs text-left">
                                     ' . tanggal($data->date) . '
                                    </div>';


                return $tb;
            })
            ->editColumn('code', function ($data) {
                $tb = '<div class="text-xs text-blue-500 font-semibold items-center text-center">
                                     ' . $data->code . '
                                    </div>';
                return $tb;
            })

            ->editColumn('berat', function ($data) {
                $tb = '<div class="text-xs">
                                     Berat Kotor :' . $data->total_berat_kotor . '
                                    </div>';
                $tb .= '<div class="text-xs text-left">
                                    Total Emas :' . $data->total_emas . '
                                    </div>';
                $tb .= '<div class="text-xs text-left">
                                    Karat :' . $data->goodsreceiptitem->pluck('karat.label')->implode(', ') . '
                                    </div>';
                return $tb;
            })


            ->editColumn('harga', function ($data) {
                $tb = '<div class="text-xs">
                                    Gram : <span class="font-semibold">' . $data->selisih . '</span>
                                    </div>';
                $tb .= '<div class="text-xs text-left">
                                      Nominal :<span class="font-semibold">' . number_format($data->selisih) . '</span>
                                    </div>';
                return $tb;
            })

            ->editColumn('pembayaran', function ($data) {
                if ($data->pembelian->tipe_pembayaran == 'jatuh_tempo') {
                    $info =  'Jatuh Tempo';
                    $pembayaran =  tgljam(@$data->pembelian->jatuh_tempo);
                    if (!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $info .= ' (Lunas) ';
                    }
                } else if ($data->pembelian->tipe_pembayaran == 'cicil') {
                    $info =  'Cicilan';
                    $pembayaran =  @$data->pembelian->cicil . ' kali';
                    if (!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $pembayaran .= ' (Lunas) ';
                    }
                } else {
                    $info =  '';
                    $pembayaran =  'Lunas';
                }
                $tb = '<div class="items-left text-left">
                              <div class="small text-gray-800">' . $info . '</div>
                              <div class="text-gray-800">' . $pembayaran . '</div>
                              </div>';
                return $tb;
            })

            ->editColumn('supplier', function ($data) {
                $tb = '<div class="items-left text-left">
                                    <div>' . $data->supplier->supplier_name . '</div>
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
            ->rawColumns([
                'updated_at',
                'date',
                'action',
                'code',
                'berat',
                'harga',
                'image',
                'pembayaran',
                'supplier',
                'detail',
                'name'
            ])
            ->make(true);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit_status($id)
    {
        if (AdjustmentSetting::exists()) {
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
        $kategoriproduk_id = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');

        abort_if(Gate::denies('edit_' . $module_name . ''), 403);
        $data = TipePembelian::where('goodsreceipt_id', $id)->with('detailCicilan', 'goodreceipt')
            ->withCount(['detailCicilan as sisa_cicilan' => function (Builder $query) {
                $query->where(function ($q) {
                    $q->whereNull('jumlah_cicilan');
                    $q->orWhere('jumlah_cicilan', 0);
                });
                $query->where(function ($q) {
                    $q->WhereNull('nominal');
                    $q->orWhere('nominal', 0);
                });
            }])->first();
        return view(
            '' . $module_name . '::' . $module_path . '.modal.edit_status',
            compact(
                'module_name',
                'module_action',
                'data',
                'module_title',
                'kategoriproduk_id',
                'module_icon',
                'module_model'
            )
        );
    }

    public function update_status_pembelian(Request $request)
    {
        $is_cicilan = $request->post('is_cicilan', false);
        $pembelian_id = $request->post('pembelian_id');
        $tgl_jatuh_tempo = $request->post('tgl_jatuh_tempo');
        $nominal = $request->post('nominal');
        $sisa_cicilan = $request->post('sisa_cicilan');
        $total_harus_bayar_nominal = $request->post('total_harus_bayar_nominal');
        $is_berlian = $request->post('is_berlian');
        $tipe = $request->post('tipe', '');
        $stok_lantakan = '';
        $stok_lantakan_weight = 0;
        $jumlah_cicilan = $request->post('jumlah_cicilan');
        DB::beginTransaction();

        try {
            if ($tipe == 'emas') {
                $stok_lantakan = StockKroom::first();
                $stok_lantakan_weight = $stok_lantakan->weight;
            }
            if ($is_cicilan) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'cicilan_id' => 'required',
                        'jumlah_cicilan' => [
                            'required_if:is_berlian, true',
                            // 'lte:' . floatval($request->post('total_harus_bayar')),
                            function ($attribute, $value, $fail) use ($request, $sisa_cicilan, $tipe, $stok_lantakan_weight) {
                                if ($sisa_cicilan == 1 && $value != floatval($request->post('total_harus_bayar'))) {
                                    $fail('Berat untuk cicilan terakhir harus sama dengan sisa cicilan.');
                                }
                                if ($tipe == 'emas' && $stok_lantakan_weight < $value) {
                                    $fail('Stok lantakan tidak cukup');
                                }
                            },
                        ],
                        'nominal' => [
                            'required_if:tipe,=,tipe_nominal',
                            // 'numeric',
                            // 'gt:-1',
                            function ($attribute, $value, $fail) use ($request, $is_berlian, $sisa_cicilan, $tipe) {
                                if ($tipe != 'emas') {
                                    if (!is_numeric($value)) {
                                        $fail('Nominal harus berupa numeric');
                                    }
                                    if ($value < 0) {
                                        $fail('Nominal harus lebih dari 0');
                                    }
                                }
                                if ($is_berlian && $sisa_cicilan == 1 && $value != $request->post('total_harus_bayar_nominal')) {
                                    $fail('Nominal untuk cicilan terakhir harus sama dengan sisa cicilan.');
                                }
                            }
                        ],
                    ],
                    [
                        'jumlah_cicilan.lte' => 'Jumlah cicilan tidak boleh lebih besar dari harus dibayar',
                    ]
                );

                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->errors()]);
                }

                $penerimaan_barang_cicilan_id = $request->post('cicilan_id');
                $nominal = $request->post('nominal');

                $penerimaan_barang_cicilan = GoodsReceiptInstallment::find($penerimaan_barang_cicilan_id);
                $penerimaan_barang_cicilan->jumlah_cicilan = $jumlah_cicilan;
                $penerimaan_barang_cicilan->nominal = $nominal;
                $penerimaan_barang_cicilan->save();

                $tipe_pembelian = TipePembelian::with('goodreceipt')->findOrFail($pembelian_id);
                if (!$is_berlian && $this->cicilanExist($pembelian_id) == $tipe_pembelian->goodreceipt->total_emas) {
                    $tipe_pembelian->lunas = 'lunas';
                    $tipe_pembelian->save();
                    $goodsreceipt = GoodsReceipt::find($tipe_pembelian->goodsreceipt_id);
                    $goodsreceipt->harga_beli = GoodsReceiptInstallment::where('payment_id', $pembelian_id)->sum('nominal');
                    $goodsreceipt->save();
                }
                if ($is_berlian && $this->cicilanBerlianExist($pembelian_id) == $tipe_pembelian->goodreceipt->harga_beli) {
                    $tipe_pembelian->lunas = 'lunas';
                    $tipe_pembelian->save();
                    $goodsreceipt = GoodsReceipt::find($tipe_pembelian->goodsreceipt_id);
                    $goodsreceipt->harga_beli = GoodsReceiptInstallment::where('payment_id', $pembelian_id)->sum('nominal');
                    $goodsreceipt->save();
                }
            } else {
                $validator = \Validator::make($request->all(), [
                    'nominal' => [
                        'required_if:tipe,=,tipe_nominal',
                        // 'numeric',
                        // 'gt:-1',
                        function ($attribute, $value, $fail) use ($tipe) {
                            if ($tipe != 'emas') {
                                if (!is_numeric($value)) {
                                    $fail('Nominal harus berupa numeric');
                                }
                                if ($value < 0) {
                                    $fail('Nominal harus lebih dari 0');
                                }
                            }
                        }
                    ],
                    'jumlah_cicilan' => [
                        'required_if:tipe,=,emas',
                        function ($attribute, $value, $fail) use ($request, $tipe, $stok_lantakan_weight) {
                            if ($value != floatval($request->post('total_harus_bayar'))) {
                                $fail('Berat tidak sama dengan yang harus dibayarkan.');
                            }
                            if ($tipe == 'emas' && $stok_lantakan_weight < $value) {
                                $fail('Stok lantakan tidak cukup');
                            }
                        },
                    ],
                ]);

                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->errors()]);
                }
                $tipe_pembelian = TipePembelian::findOrFail($pembelian_id);
                $tipe_pembelian->lunas = 'lunas';
                $tipe_pembelian->save();
                $penerimaan_barang_cicilan = GoodsReceiptInstallment::updateOrCreate(
                    [
                        'payment_id' => $pembelian_id,
                        'tanggal_cicilan' => $tgl_jatuh_tempo,
                        'nomor_cicilan' => 1
                    ],
                    [
                        'nominal' => $nominal,
                        'jumlah_cicilan' => $jumlah_cicilan,
                    ]
                );

                $goodsreceipt = GoodsReceipt::find($tipe_pembelian->goodsreceipt_id);
                $goodsreceipt->harga_beli = $nominal;
                $goodsreceipt->save();
            }

            if ($tipe == 'emas') {
                if ($penerimaan_barang_cicilan && $stok_lantakan) {
                    $penerimaan_barang_cicilan->stock_kroom()->attach($stok_lantakan->id, [
                        'karat_id' => $stok_lantakan->karat_id,
                        'in' => false,
                        'berat_real' => -1 * $penerimaan_barang_cicilan->jumlah_cicilan,
                        'berat_kotor' => -1 * $penerimaan_barang_cicilan->jumlah_cicilan
                    ]);

                    $berat_real = $stok_lantakan->history->sum('berat_real');
                    $berat_real = $stok_lantakan->weight - $penerimaan_barang_cicilan->jumlah_cicilan;
                    $stok_lantakan->update(['weight' => $berat_real]);
                }
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['failed' => $e->getMessage()]);
        }
        DB::commit();

        return response()->json(['success' => ' Sukses update pembelian.']);
    }

    /** Fungsi ini digunakan untuk mengecek apakah masih ada cicilan atau tidak */
    private function cicilanExist($payment_id)
    {
        return GoodsReceiptInstallment::where('payment_id', $payment_id)->sum('jumlah_cicilan');
    }

    /** Fungsi ini digunakan untuk mengecek apakah masih ada cicilan atau tidak */
    private function cicilanBerlianExist($payment_id)
    {
        return GoodsReceiptInstallment::where('payment_id', $payment_id)->sum('nominal');
    }


    public function index_data_completed(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::history()->latest()->get();

        $data = $$module_name;
        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.acthistory',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('image', function ($data) {
                if ($data->images) {
                    $url = asset(imageUrl() . @$data->images);
                } else {
                    $url = $data->getFirstMediaUrl('pembelian', 'thumb');
                }
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })
            ->editColumn('date', function ($data) {
                $tb = '<div class="text-xs items-center text-center">
                                     ' . tanggal($data->date) . '
                                    </div>';
                return $tb;
            })
            ->editColumn('code', function ($data) {
                $tb = '<div class="text-xs text-blue-500 font-semibold items-center text-center">
                                     ' . $data->code . '
                                    </div>';
                return $tb;
            })

            ->editColumn('berat', function ($data) {
                $tb = '<div class="items-center text-center">
                                     ' . $data->berat_barang . ' Gram
                                    </div>';
                return $tb;
            })

            ->editColumn('detail', function ($data) {
                if ($data->count == 0) {
                    $qty = $data->qty_diterima;
                } else {
                    $qty = $data->count;
                }
                $tb = '<div class="font-semibold items-center text-center">
                                    <div class="bg-green-400 px-1 items-center text-center rounded-lg">
                                        ' . $data->count . '  / ' . $data->qty_diterima . '
                                    </div>
                                </div>';
                return $tb;
            })

            ->editColumn('status', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                             
                                    ' . statusPo($data->status) . '
                                      
                                    </div>';
                return $tb;
            })

            ->editColumn('qty', function ($data) {
                $tb = '<div class="items-left text-left">
                                    <div>Diterima : ' . $data->qty_diterima . '</div>
                                    <div>Nota :' . $data->qty . '</div>
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
            ->rawColumns([
                'updated_at',
                'date',
                'action',
                'code',
                'berat',
                'status',
                'image',
                'qty',
                'detail',
                'name'
            ])
            ->make(true);
    }






    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $code = $module_model::generateCode();
        $module_action = 'Create';
        abort_if(Gate::denies('create_goodsreceipts'), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.create',
            compact(
                'module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */





    public function store(Request $request)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $input = $request->except('_token', 'document');
        $kategori_produk_id = KategoriProduk::whereSlug('gold')->value('id');
        $goodsreceipt = $module_model::create([
            'code'                       => $input['code'],
            'no_invoice'                 => $input['no_invoice'],
            'date'                       => $input['tanggal'],
            'status'                     => 0,
            'karat_id'                   => null,
            'tipe_pembayaran'            => $input['tipe_pembayaran'],
            'supplier_id'                => $input['supplier_id'],
            'user_id'                    => $input['pic_id'],
            'total_berat_kotor'          => $input['total_berat_kotor'],
            'berat_timbangan'            => $input['berat_timbangan'],
            'selisih'                    => $input['selisih'] ?? null,
            'total_emas'                 => $input['total_berat_real'],
            'note'                       => $input['catatan'],
            'harga_beli'                 => !empty($input['harga_beli']) ? $input['harga_beli'] : 0,
            'count'                      => 0,
            'qty'                        => '8',
            'kategoriproduk_id'          => $kategori_produk_id,
            'pengirim'                   => $input['pengirim'],
            'images' => $this->getUploadedImage($input['image'], $input['uploaded_image'])
        ]);
        $goodsreceipt_id = $goodsreceipt->id;
        $this->_saveTipePembelian($input, $goodsreceipt_id);
        $this->_saveGoodsReceiptItem($input['items'], $goodsreceipt, $kategori_produk_id);
        // $this->_saveStockOffice($input['items']);

        toast('' . $module_title . ' Berhasil dibuat!', 'success');
        return redirect()->route('' . $module_name . '.index');
    }


    private function getUploadedImage($image, $uploaded_image)
    {
        $folderPath = "uploads/";
        if (!empty($uploaded_image)) {
            Storage::disk('public')->move("temp/dropzone/{$uploaded_image}", "{$folderPath}{$uploaded_image}");
            return $uploaded_image;
        } elseif (!empty($image)) {
            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'webcam_' . uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('public')->put($file, $image_base64);
            return $fileName;
        }
    }






    private function _saveTipePembelian($input, $goodsreceipt)
    {
        $tipe_pembayaran = TipePembelian::create([
            'goodsreceipt_id'             => $goodsreceipt,
            'tipe_pembayaran'             => $input['tipe_pembayaran'] ?? null,
            'jatuh_tempo'                 => $input['tgl_jatuh_tempo'] ?? null,
            'cicil'                       => $input['cicil'] ?? 0,
            'lunas'                       => $input['lunas'] ?? null,
        ]);

        if ($tipe_pembayaran->isCicil()) {
            foreach ($input['detail_cicilan'] as $key => $value) {
                GoodsReceiptInstallment::create([
                    'payment_id' => $tipe_pembayaran->id,
                    'nomor_cicilan' => $key,
                    'tanggal_cicilan' => $input['detail_cicilan'][$key]
                ]);
            }
        }
    }


    private function _saveGoodsReceiptItem($items, $goodsreceipt, $kategori_produk_id)
    {
        foreach ($items as $key => $value) {
            $item = GoodsReceiptItem::create([
                'goodsreceipt_id' => $goodsreceipt->id,
                'karat_id' => $items[$key]['karat_id'],
                'kategoriproduk_id' => $kategori_produk_id,
                'berat_real' => $items[$key]['berat_real'],
                'berat_kotor' => $items[$key]['berat_kotor']
            ]);
            $stock_office = StockOffice::where('karat_id', $item['karat_id'])->first();
            if (is_null($stock_office)) {
                $stock_office = StockOffice::create(['karat_id' => $item['karat_id']]);
            }
            $item->stock_office()->attach($stock_office->id, [
                'karat_id' => $item['karat_id'],
                'in' => true,
                'berat_real' => $items[$key]['berat_real'],
                'berat_kotor' => $items[$key]['berat_kotor']
            ]);
            $berat_real = $stock_office->history->sum('berat_real');
            $berat_kotor = $stock_office->history->sum('berat_kotor');
            $stock_office->update(['berat_real' => $berat_real, 'berat_kotor' => $berat_kotor]);
        }
    }



    private function _saveStockOffice($items)
    {

        foreach ($items as $key => $value) {
            $stockOffice = StockOffice::where('karat_id', $items[$key]['karat_id']);
            $existingBeratBersih = $stockOffice->value('berat_real');
            $existingBeratKotor = $stockOffice->value('berat_kotor');
            StockOffice::updateOrCreate(
                ['karat_id' => $items[$key]['karat_id']],
                [
                    'berat_real' => $items[$key]['berat_real'] + $existingBeratBersih,
                    'berat_kotor' => $items[$key]['berat_kotor'] + $existingBeratKotor
                ]
            );
        }
    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderables
     */
    public function edit($id)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_' . $module_name . ''), 403);
        $detail = $module_model::findOrFail($id);
        $kasir = User::role('Kasir')->orderBy('name')->get();
        return view(
            '' . $module_name . '::' . $module_path . '.edit',
            compact(
                'module_name',
                'module_action',
                'detail',
                'kasir',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function update(Request $request, $id)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $request->validate([
            'no_invoice' => 'required|min:3|max:191',
        ]);
        $params = $request->except('_token', 'upload', 'image', 'document');
        $params['no_invoice'] = $params['no_invoice'];
        $params['count'] = 0;
        $params['date'] = $params['date'];


        if ($request->filled('image')) {

            $img = $request->image;
            $folderPath = "uploads/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'webcam_' . uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            $storage = Storage::disk('public')->put($file, $image_base64);

            // $path = \Storage::cloud()->put($file,$image_base64);
            // $url=\Storage::cloud()->temporaryUrl($path, \Carbon\Carbon::now()->addMinutes(1));
            // $jResponse['data'] = array(
            //     "url"=>$url,
            //     "path"=>$path
            // );

            //  dd($jResponse);

            //dd($storage);
            $params['images'] =  "$fileName";
        } else {
            unset($params['images']);
        }


        $$module_name_singular->update($params);

        if ($request->has('document')) {

            $produkItem =  $module_model::findOrFail($id);
            $produkItem->update([
                'images' => null
            ]);

            if (count($$module_name_singular->getMedia('pembelian')) > 0) {
                foreach ($$module_name_singular->getMedia('pembelian') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $$module_name_singular->getMedia('pembelian')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('pembelian');
                }
            }
        }
        activity()->log(' ' . auth()->user()->name . ' Edit Data pembelian');
        toast('' . $module_title . ' Updated!', 'success');
        return redirect()->route('' . $module_name . '.index');
    }


    public function update_status(Request $request, $id)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $id = decode_id($id);
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $module_title = $this->module_title;
        $penerimaan = $module_model::findOrFail($id);
        $penerimaan->status = 2;
        $penerimaan->save();
        toast('' . $module_title . ' Updated!', 'success');
        activity()->log(' ' . auth()->user()->name . ' Update  pembelian');
        return redirect()->route('' . $module_name . '.riwayat_penerimaan');
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
        $validator = \Validator::make($request->all(), [
            'code' => 'required|max:191|unique:' . $module_model . ',code',
            'name' => 'required|max:191',

        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $input['code'] = $input['code'];
        $input['name'] = $input['name'];
        $$module_name_singular = $module_model::create($input);

        return response()->json(['success' => '  ' . $module_title . ' Sukses disimpan.']);
    }




    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $id_kategoriproduk_berlian = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');
        $module_action = 'Show';
        abort_if(Gate::denies('show_goodsreceipts'), 403);
        $detail = $module_model::findOrFail($id);
        // $list = $module_products::where('kode_pembelian',$detail->code)->get();
        //  dd($detail->code);
        return view(
            '' . $module_name . '::' . $module_path . '.show',
            compact(
                'module_name',
                'module_action',
                'detail',
                'id_kategoriproduk_berlian',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function print($id)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_goodsreceipts'), 403);
        $detail = $module_model::findOrFail($id);
        // $list = $module_products::where('kode_pembelian',$detail->code)->get();
        //  dd($detail->code);
        return view(
            '' . $module_name . '::' . $module_path . '.print_detail',
            compact(
                'module_name',
                'module_action',
                'detail',

                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }






    public function view_produk($id)
    {

        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $detail = $module_products::select(
            'products.*',
            'products.id AS id_produk',
            'goodsreceipts.code AS code',
            'goodsreceipts.berat_kotor'
        )
            ->where('products.id', $id)
            ->leftJoin('goodsreceipts', 'products.kode_pembelian', '=', 'goodsreceipts.code')
            ->first();


        $produk = $module_products::findOrFail($detail->id_produk);
        $list = $module_products::where('kode_pembelian', $detail->code)->get();
        //  dd($detail->code);
        return view(
            '' . $module_name . '::' . $module_path . '.view_produk',
            compact(
                'module_name',
                'module_action',
                'detail',
                'produk',
                'list',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }







    public function print_produk($kode_pembelian)
    {

        //$kode_pembelian = decode_id($kode_pembelian);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $detail = $module_products::select(
            'products.*',
            'goodsreceipts.code AS code',
            'goodsreceipts.qty'
        )
            ->where('products.kode_pembelian', $kode_pembelian)
            ->leftJoin('goodsreceipts', 'products.kode_pembelian', '=', 'goodsreceipts.code')
            ->get();

        //  dd($detail->code);
        return view(
            '' . $module_name . '::' . $module_path . '.print_produk',
            compact(
                'module_name',
                'module_action',
                'detail',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }













    //add produk detail modal
    public function add_produk_modal($id)
    {

        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $listcategories = KategoriProduk::with('category')->get();
        $pembelian = $module_model::findOrFail($id);
        //dd($detail);
        return view(
            '' . $module_name . '::' . $module_path . '.modal.catlist',
            compact(
                'module_name',
                'module_action',
                'pembelian',
                'listcategories',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function add_products_by_categories(Request $request, $id)
    {
        $id = decode_id($id);
        $no_pembelian = $request->get('po') ?? '0';
        //dd($no_pembelian);
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_categories = $this->module_categories;
        $module_name_singular = Str::singular($module_name);
        $main = KategoriProduk::where('id', $id)->first();
        $produkkategori = Category::where('kategori_produk_id', $id)->get();
        $categories = Category::where('kategori_produk_id', $id)->get();
        $pembelian = $module_model::where('code', $no_pembelian)->first();
        $code = Product::generateCode();
        $module_action = 'List';
        return view(
            '' . $module_name . '::' . $module_path . '.form.create',
            compact(
                'module_name',
                'module_title',
                'produkkategori',
                'categories',
                'main',
                'no_pembelian',
                'pembelian',
                'code',
                'module_icon',
                'module_model'
            )
        );
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
        $validator = \Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    'unique:' . $module_model . ',code,' . $id
                ],
                'name' => 'required|max:191',


            ]
        );

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $params['code'] = $params['code'];
        $params['name'] = $params['name'];
        $$module_name_singular->update($params);
        return response()->json(['success' => '  ' . $module_title . ' Sukses diupdate.']);
    }





    public function cetak($id)
    {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $detail = $module_model::findOrFail($id);
        $title = 'Print Penerimaan Barang';
        $pdf = PDF::loadView('' . $module_name . '::' . $module_path . '.includes.print', compact('detail', 'title'))
            ->setPaper('A4', 'portrait');
        return $pdf->stream('penerimaan-' . $detail->id . '.pdf');
        // return view(''.$module_name.'::'.$module_path.'.includes.print',
        //   compact('module_name',
        //    'detail',
        //    'module_title',
        //    'title',
        //    'module_icon', 'module_model'));




    }












    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);

            $module_action = 'Delete';

            $$module_name_singular = $module_model::find($id);

            $gr_item = GoodsReceiptItem::where('goodsreceipt_id', $id)->get();
            foreach ($gr_item as $item) {
                $stock_office = StockOffice::where('karat_id', $item->karat_id)->first();
                $item->stock_office()->attach($stock_office->id, [
                    'karat_id' => $item['karat_id'],
                    'in' => false,
                    'berat_real' => -1 * $item->berat_real,
                    'berat_kotor' => -1 * $item->berat_kotor
                ]);
                $berat_real = $stock_office->berat_real - $item->berat_real;
                $berat_kotor = $stock_office->berat_kotor - $item->berat_kotor;
                $stock_office->update(['berat_real' => $berat_real, 'berat_kotor' => $berat_kotor]);
                $item->delete();
            }
            $$module_name_singular->delete();
            DB::commit();
            toast('' . $module_title . ' Deleted!', 'success');
            return redirect()->route('' . $module_name . '.index');
        } catch (\Exception $e) {
            dd($e);
            toast('' . $module_title . ' error! ' . $e->getMessage(), 'warning');
            return redirect()->back();
        }
    }


    /** DEBTS */

    public function debts()
    {
        if (AdjustmentSetting::exists()) {
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
        return view(
            '' . $module_name . '::' . $module_path . '.debts.index',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function debts_data(Request $request)
    {
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $kategoriproduk_id = LookUp::where('kode', 'id_kategori_produk_emas')->value('value');

        $data = $module_model::debts()
            ->where('tipe_pembayaran', '!=', 'lunas')
            ->where(function ($query) use ($kategoriproduk_id) {
                $query->whereNull('kategoriproduk_id');
                $query->orWhere('kategoriproduk_id', $kategoriproduk_id);
            })
            ->latest()->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.debts.action',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('image', function ($data) {
                if ($data->images) {
                    $url = asset(imageUrl() . @$data->images);
                } else {
                    $url = $data->getFirstMediaUrl('pembelian', 'thumb');
                }
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->editColumn('date', function ($data) {
                $tb = '<div class="text-xs font-semibold">
                    ' . $data->code . '
                    </div>';
                $tb .= '<div class="text-xs text-left">
                    ' . tanggal($data->date) . '
                    </div>';

                return $tb;
            })
            ->editColumn('code', function ($data) {
                $tb = '<div class="text-xs text-blue-500 font-semibold items-center text-center">
                        ' . $data->code . '
                    </div>';
                return $tb;
            })

            ->editColumn('berat', function ($data) {
                $tb = '<div class="text-xs">
                        Berat Kotor :' . $data->total_berat_kotor . '
                    </div>';
                $tb .= '<div class="text-xs text-left">
                    Total Emas :' . $data->total_emas . '
                    </div>';
                $tb .= '<div class="text-xs text-left">
                    Karat :' . $data->goodsreceiptitem->pluck('karat.label')->implode(', ') . '
                    </div>';
                return $tb;
            })

            ->editColumn('harga', function ($data) {
                $tb = '<div class="text-xs">
                    Gram : <span class="font-semibold">' . $data->selisih . '</span>
                    </div>';
                $tb .= '<div class="text-xs text-left">
                        Nominal :<span class="font-semibold">' . number_format($data->selisih) . '</span>
                    </div>';
                return $tb;
            })

            ->editColumn('pembayaran', function ($data) {
                if ($data->pembelian->tipe_pembayaran == 'jatuh_tempo') {
                    $info =  'Jatuh Tempo';
                    $pembayaran =  tgljam(@$data->pembelian->jatuh_tempo);
                    if (!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $info .= ' (Lunas) ';
                    }
                } else if ($data->pembelian->tipe_pembayaran == 'cicil') {
                    $info =  'Cicilan';
                    $pembayaran =  @$data->pembelian->cicil . ' kali';
                    if (!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $pembayaran .= ' (Lunas) ';
                    }
                } else {
                    $info =  '';
                    $pembayaran =  'Lunas';
                }
                $tb = '<div class="items-left text-left">
                    <div class="small text-gray-800">' . $info . '</div>
                    <div class="text-gray-800">' . $pembayaran . '</div>
                    </div>';
                return $tb;
            })

            ->editColumn('supplier', function ($data) {
                $tb = '<div class="items-left text-left">
                    <div>' . $data->supplier->supplier_name . '</div>
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
            ->rawColumns([
                'updated_at',
                'date',
                'action',
                'code',
                'berat',
                'harga',
                'image',
                'pembayaran',
                'supplier',
                'detail',
                'name'
            ])
            ->make(true);
    }
}
