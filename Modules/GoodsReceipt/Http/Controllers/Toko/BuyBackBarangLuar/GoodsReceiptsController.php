<?php

namespace Modules\GoodsReceipt\Http\Controllers\Toko\BuyBackBarangLuar;

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
use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;

class GoodsReceiptsController extends Controller
{

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Goods Receipt';
        $this->module_name = 'goodsreceipt';
        $this->module_path = 'goodsreceipts/toko/buyback-barangluar';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\GoodsReceipt\Models\Toko\GoodsReceipt";
        $this->module_model_item = "Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar\GoodsReceiptItem";
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


    public function index_data_item(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $query = $this->module_model_item::query();

        if ($request->has('startDate') && $request->has('endDate') && $request->has('type')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $type = $request->input('type');

            if(!empty($type)){
                $query->where('type', $type);
            }

            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            }
        }
        $$module_name = $query->with(['product'])->where('cabang_id', auth()->user()->namacabang()->id)->orderBy('updated_at', 'DESC')->get();;

        // $$module_name = $this->module_model_item::with(['product'])->where('cabang_id', auth()->user()->namacabang()->id)->orderBy('updated_at', 'DESC')->get();
        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.datatable.item.action',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('barang', function ($data) {
                $tb = '<div class="justify items-left text-left">';

                $tb .= '<div class="text-gray-800">
                                                      Nama Produk : <strong>' . $data->product->product_name . '
                                                     </strong></div>';
                $tb .= '<div class="text-gray-800">
                                                      Karat : <strong>' . $data->product->karat->label . '
                                                     </strong></div>';

                $tb .= '<div class="text-gray-800">
                                                      Berat Emas : <strong>' . $data->product->berat_emas . '
                                                      gr</strong></div>';
                $tb .= '<div class="text-gray-800">
                                                      Kode : <strong>' . $data->product->product_code . '
                                                      </strong></div>';
                $tb .= '</div>';
                return $tb;
            })


            ->editColumn('customer', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                         ' . $data->customer_name . '
                                                        </div>';
                return $tb;
            })
            ->editColumn('status', function ($data) {
                $tb = '<button class="btn bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">' . $data->product->current_status->name . '</button>';
                return $tb;
            })
            // ->editColumn('nominal', function ($data) {
            //     $tb = '<div class="font-semibold items-center text-center">
            //                                          ' . format_uang($data->nominal) . '
            //                                          </div>';
            //     return $tb;
            // })


            ->editColumn('date', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                ' . $data->date . '
                                                </div>';
                return $tb;
            })
            ->editColumn('tipe', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                ' . $data->type_label . '
                                                </div>';
                return $tb;
            })
            ->rawColumns([
                'action', 'barang',
                'customer',
                'status',
                'nominal',
                'date',
                'tipe'
            ])
            ->make(true);
    }


    public function index_data_nota(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = BuyBackBarangLuar\GoodsReceiptNota::orderBy('id', 'DESC')->get();
        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.datatable.nota.action',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('total_item', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                        ' . $data->items->count() . '
                                                       </div>';
                return $tb;
            })
            ->editColumn('status', function ($data) {
                $tb = '<button class="btn bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">' . $data->current_status->name . '</button>';
                return $tb;
            })
            ->editColumn('nota', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                    ' . $data->invoice . '
                                                    </div>';
                return $tb;
            })


            ->editColumn('date', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                               ' . $data->date . '
                                               </div>';
                return $tb;
            })
            ->rawColumns([
                'action', 'barang',
                'total_item',
                'status',
                'nota',
                'date',
            ])
            ->make(true);
    }


    public function create_nota()
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
        $module_action = 'Create';
        return view(
            '' . $module_name . '::' . $module_path . '.datatable.nota.create',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function print_item(BuyBackBarangLuar\GoodsReceiptItem $item){
        $datetime = Carbon::parse($item->created_at);
        $filename = "Penerimaan " . ucwords($item->type_label) . " " . $item->cabang->name . " " . ucwords($item->customer_name);
        $pdf = PDF::loadView('goodsreceipt::goodsreceipts.toko.buyback-barangluar.datatable.item.print',compact('item','filename','datetime'));
        return $pdf->stream($filename.'.pdf');
    }


    public function index_data_nota_office(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $$module_name = BuyBackBarangLuar\GoodsReceiptNota::get();
        $query = BuyBackBarangLuar\GoodsReceiptNota::query();

        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            }
        }
        $$module_name = $query->get();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.datatable.nota.office-action',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('total_item', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                        ' . $data->items->count() . '
                                                       </div>';
                return $tb;
            })
            ->editColumn('status', function ($data) {
                $tb = '<div class="items-center text-center">
                    <button class="btn bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">' . $data->current_status->name . '</button>
                    </div>';
                return $tb;
            })
            ->editColumn('nota', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                                    ' . $data->invoice . '
                                                    </div>';
                return $tb;
            })


            ->editColumn('date', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                               ' . tanggal($data->date) . '
                                               </div>';
                return $tb;
            })
            ->editColumn('cabang', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                               ' . $data->cabang->name . '
                                               </div>';
                return $tb;
            })
            ->editColumn('nominal', function ($data) {
                $tb = '<div class="font-semibold items-center text-center">
                                               ' . format_uang($data->items->sum('nominal')) . '
                                               </div>';
                return $tb;
            })
            ->rawColumns([
                'action',
                'cabang',
                'nominal',
                'total_item',
                'status',
                'nota',
                'date',
            ])
            ->make(true);
    }


    public function nota_process(Request $request){
        try {
            if(!auth()->user()->isUserCabang()){
                $data = $request->input('data');
                if(empty($data) && isset($data)){
                    throw new \Exception('Data Kosong');
                }else{
                    $nota = BuyBackBarangLuar\GoodsReceiptNota::find($data['id']);
                    $nota->process();
                }
            }else{
                throw new \Exception('You are not authorized');
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Nota Berhasil diproses',
                'redirectRoute' => route('goodsreceipt.toko.buyback-barangluar.nota.show',$nota->id)
            ],200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function show_nota($id)
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
        abort_if(Gate::denies('access_buys_back_luar'), 403);
        $nota = BuyBackBarangLuar\GoodsReceiptNota::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.show_nota',
           compact('module_name',
            'module_action',
            'nota',
            'module_title',
            'module_icon', 'module_model'));

    }

    public function print_nota($id)
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
        $module_action = 'Print';
        abort_if(Gate::denies('access_buys_back_luar'), 403);
        $nota = BuyBackBarangLuar\GoodsReceiptNota::findOrFail($id);
        $datetime = Carbon::parse($nota->created_at);
        $filename = "Penerimaan Barang DP " . ucwords($nota->invoice) . " " . $nota->cabang->name . " " . ucwords($nota->owner_name);
        $pdf = PDF::loadView('' . $module_name . '::' . $module_path . '.print', compact('nota', 'filename', 'datetime'));
        return $pdf->stream($filename . '.pdf');
    }
}
