<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Group\Models\Group;
use Modules\Product\Entities\Product;
use App\Models\SalesGold;
use App\Models\SalesItem;
use App\Models\Service;
use App\Models\Harga;
use App\Models\Config;
use App\Models\ProductHistories;
use App\Models\StockOpname;
use Modules\Product\Entities\ProductItem;
use Modules\Purchase\Entities\Purchase;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;
use Modules\Sale\Http\Requests\StorePosSaleRequest;
use PDF;
use Auth;
use Carbon\Carbon;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Product\Models\ProductStatus;
use Yajra\DataTables\DataTables;
use Modules\Karat\Models\Karat;
use Modules\ProdukModel\Models\ProdukModel;

class PurchasesController extends Controller
{

    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_detail;
    private $module_payment;
    private $module_product;

    public function __construct()
    {
        // $opname = StockOpname::check_opname();
        // if($opname == 'A'){
        //     abort(403, 'Access denied during active stock opname.');
        // }
        $this->module_title = 'Purchases';

        $this->module_name = 'purchases';

        $this->module_path = 'purchase';

        $this->module_icon = 'fas fa-sitemap';

        $this->module_model = "Modules\Purchase\Entities\Purchase";
        $this->module_detail = "Modules\Purchase\Entities\PurchaseDetail";
        $this->module_payment = "Modules\Purchase\Entities\PurchasePayment";
        $this->module_product = "Modules\Product\Entities\Product";
    }


    public function data_report_pembelian(Request $request)
    {

        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $query = Purchase::with(['purchaseDetails.product.karat']);
        // $query = Purchase::all();

        $data = $query->latest()->get();

        // $karat = Product::where('id', $query)
        // dd($data);



        return Datatables::of($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'purchase.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('no_faktur', function ($data) {
                return 'no faktur';
            })

            ->editColumn('jam', function ($data) {
                $tb = $data->created_at->format('H:i');

                return $tb;
                // return 'jam';
            })

            ->editColumn('kode_barcode', function ($data) {
                // return number_format($data->total);
                $tb = optional($data->purchaseDetails->first())->product_code ?? '-';
                return $tb;
            })

            ->editColumn('kode_intern', function ($data) {
                // return number_format($data->total);
                return 'kode intern';
            })

            ->editColumn('kode_sales', function ($data) {
                $tb = $data->kode_sales;

                return $tb;
            })

            ->editColumn('nama_customer', function ($data) {
                $tb = $data->supplier_name;
                return $tb;
            })

            ->editColumn('nama_barang', function ($data) {
                // return number_format($data->total);
                $tb = optional($data->purchaseDetails->first())->product_name ?? '-';
                return $tb;
            })

            ->editColumn('berat', function ($data) {
                // return number_format($data->total);
                return 'berat';
            })

            ->editColumn('kadar', function ($data) {
                $kadar = optional(optional($data->purchaseDetails->first())->product)->karat->name ?? '-';

                return $kadar;
            })

            ->editColumn('hrg_nota', function ($data) {
                // return number_format($data->total);
                return 'hrg_nota';
            })

            ->editColumn('hrg_beli', function ($data) {
                // return number_format($data->total);
                return 'hrg_beli';
            })

            ->editColumn('hrg_rata', function ($data) {
                // return number_format($data->total);
                return 'hrg_rata';
            })

            ->editColumn('type_payment', function ($data) {
                // return number_format($data->total);
                $tb = $data->payment_method;

                return $tb;
            })



            ->rawColumns([
                'action', 'no_faktur', 'created_at', 'kode_barcode', 'kode_intern', 'nama_customer', 'nama_barang', 'berat', 'kadar', 'hrg_nota', 'hrg_beli', 'hrg_rata', 'type_payment'
            ])
            ->make(true);
        }

    public function laporan_pembelian(Request $request){

        // dd($request->all());
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }

        if ($request->resetFilter) {
            $startDate = Carbon::today()->toDateString();
            $endDate = Carbon::today()->toDateString();
        } else {
            $startDate = $request->startDate ?? Carbon::today()->toDateString();
            $endDate = $request->endDate ?? Carbon::today()->toDateString();
        }

        if ($startDate > $endDate) {
            toast('Tanggal awal tidak boleh lebih besar dari tanggal akhir!', 'error');
            return redirect()->back();
        }


        Cart::instance('sale')->destroy();

        if ($request->startDate && $request->endDate && !$request->resetFilter) {
            $karat  = Karat::whereBetween('created_at', [$startDate, $endDate])->latest()->get();
            $category  = Category::whereBetween('created_at', [$startDate, $endDate])->latest()->get();
            $group  = Group::whereBetween('created_at', [$startDate, $endDate])->latest()->get();
            $models  = ProdukModel::whereBetween('created_at', [$startDate, $endDate])->latest()->get();
            $customers = Customer::whereBetween('created_at', [$startDate, $endDate])->get();
            $product_categories = Category::whereBetween('created_at', [$startDate, $endDate])->get();
        } else {
            $karat  = Karat::latest()->get();
            $category  = Category::latest()->get();
            $group  = Group::latest()->get();
            $models  = ProdukModel::latest()->get();
            $customers = Customer::all();
            $product_categories = Category::all();
        }


        // dd(Product::all());

        $module_title   = $this->module_title;

        // ///// start data pada card
        // $todayDate = Carbon::today(); // hari ini
        // $todaySalesGold = SalesGold::whereDate('created_at', $todayDate)->get(); // data penjualan hari ini


        // dd($karat);

        if($request->resetFilter) {
            $startDate = Carbon::today()->toDateString();
            $endDate = Carbon::today()->toDateString();
        }

        // if ($startDate !== Carbon::today()->toDateString()  && $endDate !== Carbon::today()->toDateString()) {
        //     dd($startDate, $endDate);
        // }

        // dd($startDate, $endDate);

        $todaySalesGold = SalesGold::whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->get();

        // 1. HASIL PENJUALAN HARI INI (card ungu)
        $totalGoldSales = 0;
        // loop data hari ini dan kalkulasikan semua total ke dalam $totalGoldSales
        foreach ($todaySalesGold as $data) {
            $totalGoldSales = $totalGoldSales + $data->total;
        }

        // 2. TOTAL BERAT PENJUALAN HARI INI (card kuning)
        // 3. TOTAL KUANTITAS PENJUALAN HARI INI (card hijau)
        $totalGoldWeight = 0;
        $totalGoldQuantity = 0;
        $allProducts = [];

        foreach ($todaySalesGold as $data) {
            $arrayProducts = json_decode($data->products, true); // mengambil products menjadi array product_id
            foreach ($arrayProducts as $product_id) {
                $allProducts[] =  $product_id; // mengambil semua product_id yang ada
                $goldWeight = Product::where('id', $product_id)->first()->berat_emas; // mengambil berat emas dari setiap product
                $totalGoldWeight = $totalGoldWeight + $goldWeight; // kalkulasi semua berat emas
            }
        }

        // dd(Product::where('id', $product_id)->first()->berat_emas);
        $totalGoldQuantity = count($allProducts); // menghitung total semua product / emas (berdasarkan product_id)
        // 4. JUMLAH PELANGGAN HARI INI (card biru)
        // $totalCustomer = SalesGold::whereDate('created_at', $todayDate)->count();
        // total sementara 17 juni 2025 = Rp. 11.252.326
        // total berat emas sementara = 8,44
        // total item sementara = 5
        // jumlah pelanggan sementara = 4
        /// end data pada card

        $totalCustomer = SalesGold::whereBetween('created_at', [$startDate, $endDate])
        ->distinct('id')
        ->count('id');

        // dd(1);
        return view(
            'purchase.report', compact(
                'module_title',
                'product_categories',
                'customers',
                'karat',
                'category',
                'group',
                'models',
                'totalGoldSales',
                'totalGoldWeight',
                'totalGoldQuantity',
                'totalCustomer',
                // 'todayDate',
            )
        );
    }


}
