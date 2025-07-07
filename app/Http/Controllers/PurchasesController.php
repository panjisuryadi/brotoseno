<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LookUp;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
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
// use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\Stok\Models\StockKroom;
use Gloudemans\Shoppingcart\Facades\Cart;
use Modules\Group\Models\Group;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\People\Entities\Customer;
use App\Models\SalesGold;
use Modules\GoodsReceipt\Models\GoodsReceipt;


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
        $this->module_title = 'Pembelian';
        $this->module_name = 'pembelian';
        $this->module_path = 'pembelian';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";
        $this->module_categories = "Modules\Product\Entities\Category";
        $this->module_products = "Modules\Product\Entities\Product";
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

        $query = GoodsReceiptItem::with([
            'goodsReceipt.supplier',   // relasi ke header GR dan supplier
            'karat'                    // relasi ke karat
        ])->get();

        // dd($query);

        $dataTable = Datatables::of($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view('purchase.aksi', compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('code', fn($data) =>
                $data->goodsReceipt->code ?? '-'
            )

            ->editColumn('invoice', fn($data) =>
                $data->goodsReceipt->no_invoice ?? '-'
            )

            ->editColumn('jam', fn($data) =>
                $data->goodsReceipt->created_at?->format('H:i') ?? '-'
            )

            ->editColumn('supplier', fn($data) =>
                $data->goodsReceipt->supplier->supplier_name ?? '-'
            )

            ->editColumn('karat', fn($data) =>
                $data->karat->name ?? '-'
            )

            ->editColumn('berat', fn($data) =>
                $data->berat_kotor ?? '-'
            )

            ->editColumn('berat_timbangan', fn($data) =>
                $data->berat_real ?? '-'
            )


            ->editColumn('type_payment', fn($data) =>
                $data->goodsReceipt->tipe_pembayaran ?? '-'
            )

            ->editColumn('qty', function ($data) {
                return $data->qty ?? 1; // misalnya default 1 kalau tidak ada
            })

            ->rawColumns([
                'action', 'qty', 'code','jam' , 'kode_sales' , 'berat_timbangan' , 'no_faktur', 'created_at', 'nama_customer', 'nama_barang', 'berat', 'type_payment'
            ])
            ->make(true);

        // dd($dataTable);

        return $dataTable;
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



    public function data_recap(Request $request)
{
    /* 1. Tarik header + relasi item */
    $receipts = GoodsReceipt::with('goodsReceiptItems')
        ->when($request->filled(['bulan', 'tahun']), function ($q) use ($request) {
            $q->whereMonth('created_at', $request->bulan)
              ->whereYear('created_at',  $request->tahun);
        })
        ->latest()
        ->get();

        $detailRows = collect();

        foreach ($sales as $row) {
            $items = json_decode($row->products, true) ?? [];

            foreach ($items as $item) {
                //   ── Ambil id & qty ───────────────────────────────
                $idProduk = is_array($item) ? $item['id'] : $item;
                $itemQty  = is_array($item) && isset($item['qty']) ? $item['qty'] : 1;

                $product = Product::find($idProduk);
                if (!$product) continue;              // stop kalau id tak valid

                $detailRows->push([
                    'tanggal'     => $row->created_at->format('Y-m-d'),
                    'product'     => $product->product_name,      // ← cuma string
                    'berat_emas'  => $product->berat_emas * $itemQty,
                    'qty'         => $itemQty,
                    // contoh pembobotan total per‑item (sesuaikan skema Anda)
                    'total'       => ($row->total / max($row->grand_qty,1)) * $itemQty
                ]);
            }
        }

    /* 3. Kirim ke DataTables */
    return DataTables::of($rekap)
        ->editColumn('tanggal',    fn($r) => $r['tanggal']->format('d/m/Y'))
        ->editColumn('berat_kotor',fn($r) => number_format($r['berat_kotor'],2).' gr')
        ->editColumn('berat_real', fn($r) => number_format($r['berat_real'], 2).' gr')
        ->editColumn('qty',        fn($r) => number_format($r['qty']))
        ->make(true);
}



    public function recap(Request $request)
        {
            if (AdjustmentSetting::exists()) {
                toast('Stock Opname sedang Aktif!', 'error');
                return redirect()->back();
            }

            Cart::instance('sale')->destroy();

            $karat = Karat::latest()->get();
            $category = Category::latest()->get();
            $group = Group::latest()->get();
            $models = ProdukModel::latest()->get();
            $customers = Customer::all();
            $product_categories = Category::all();

            // Ambil filter dari request
            $bulan = $request->input('bulan', now()->month);
            $tahun = $request->input('tahun', now()->year);

            // Ambil data SalesGold berdasarkan filter (jika ada)
            $salesGold = SalesGold::when($bulan, function ($query) use ($bulan) {
                    return $query->whereMonth('created_at', $bulan);
                })
                ->when($tahun, function ($query) use ($tahun) {
                    return $query->whereYear('created_at', $tahun);
                })
                ->get();

            // Total nilai penjualan
            $totalGoldSales = $salesGold->sum('total');

            // Hitung berat dan jumlah produk
            $totalGoldWeight = 0;
            $allProducts = [];

            foreach ($salesGold as $data) {
                $arrayProducts = json_decode($data->products, true);
                foreach ($arrayProducts as $product_id) {
                    $allProducts[] = $product_id;
                    $berat = Product::find($product_id)?->berat_emas ?? 0;
                    $totalGoldWeight += $berat;
                }
            }

            $totalGoldQuantity = count($allProducts);
            $totalCustomer = $salesGold->count();

            $module_title = $this->module_title;

            return view('purchase.recap', compact(
                'module_title',
                'karat',
                'category',
                'group',
                'models',
                'customers',
                'product_categories',
                'totalGoldSales',
                'totalGoldWeight',
                'totalGoldQuantity',
                'totalCustomer',
                'bulan',
                'tahun'
            ));
        }


}
