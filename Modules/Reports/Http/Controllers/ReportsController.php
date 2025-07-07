<?php

namespace Modules\Reports\Http\Controllers;

use App\Models\Harga;
use App\Models\SalesGold;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Yajra\DataTables\DataTables;

class ReportsController extends Controller
{

    public function profitLossReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::profit-loss.index');
    }

    public function paymentsReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::payments.index');
    }


    public function piutangsReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::piutang.index');
    }

    public function hutangReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::hutang.index');
    }





    public function salesReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::sales.index');
    }

    public function purchasesReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::purchases.index');
    }

    public function salesReturnReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::sales-return.index');
    }

    public function purchasesReturnReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::purchases-return.index');
    }

    // menampilkan laporan stok yang masih ada dan stok yang sudah terjual
    public function stockReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        // SUMBER DATA
        // berat dari products
        // coef dari karats
        // harga emas dari hargas
        // harga jual dari: 
        // - harga emas * coef karat = harga coef, 
        // - harga coef * (persen margin karat / 100) = harga margin
        // - harga coef + harga margin = harga jual, SELESAI.

        // harga emas sekarang
        $hargaEmas = Harga::latest()->first()->harga;

        // semua products yang ada di stok
        $products = Product::leftJoin('karats', 'products.karat_id', '=', 'karats.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.status_id', 1);

        // berisi coef dan berat emas
        $coefWeightAndMargin = $products->select('karats.coef', 'products.berat_emas', 'karats.persen')
            ->get();

        // inisialisasi nilaiAset
        $nilaiAset = 0;

        // inisialisasi potensiAset
        $potensiAset = 0;

        foreach ($coefWeightAndMargin as $cwm) {

            // KOMPONEN UNTUK HARGA JUAL:
            $coef = $cwm->coef; // mengambil coef dari tiap karat
            $persenMargin = $cwm->persen; // mengambil persen margin dari tiap karat
            $weight = $cwm->berat_emas; // mengambil berat emas dari tiap produk

            // nilaiAset = coef * berat * harga (IDR tanpa margin karat)
            $nilaiAset += ($coef * $weight * $hargaEmas);

            // perhitungan harga jual
            $hargaCoef = $coef * $hargaEmas;
            $hargaJual = $hargaCoef + ($hargaCoef * ($persenMargin / 100));
            $hargaAkhirProduk = ceil($hargaJual * $weight / 1000) * 1000;

            // potensiAset = harga jual * berat dari setiap produk (IDR dengan margin karat)
            $potensiAset += $hargaAkhirProduk;
        }

        // format nilaiAset yang didapat agar lebih indah
        $formattedNilaiAset = 'Rp. ' . number_format($nilaiAset, 0, ',', '.');

        // format potensiAset yang didapat agar lebih indah
        $formattedPotensiAset = 'Rp. ' . number_format($potensiAset, 0, ',', '.');

        // total berat produk
        $stockWeight = Product::leftJoin('karats', 'products.karat_id', '=', 'karats.id')
            ->where('products.status_id', 1)
            ->sum('products.berat_emas');

        // total kuantitas produk
        $stockQuantity = Product::leftJoin('karats', 'products.karat_id', '=', 'karats.id')
            ->where('products.status_id', 1)
            ->count('products.id');

        // format stockWeight
        $formattedStockWeight = number_format($stockWeight, 2, ',', '.') . ' Gram';

        // data categories yang ada di stok
        $categories = $products->select('categories.id', 'categories.category_code')->distinct()->get();

        // data categories yang ada di stok
        $karats = $products->select('karats.id', 'karats.name')->distinct()->orderBy('karats.name', 'asc')->get();

        return view('reports::stock.index', compact(
            'formattedStockWeight',
            'stockQuantity',
            'formattedNilaiAset',
            'formattedPotensiAset',
            'categories',
            'karats',
        ));
    }

    // data untuk table Laporan Stok pada halaman stock/report
    public function stockReportData(Request $request)
    {
        $query = Product::leftJoin('karats', 'products.karat_id', '=', 'karats.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.status_id', 1);

        if (!empty($request->categories)) {
            $query->whereIn('products.category_id', $request->categories);
        }

        if (!empty($request->karats)) {
            $query->whereIn('products.karat_id', $request->karats);
        }

        $stockData = $query->select('categories.category_code', 'karats.name', DB::raw('SUM(products.berat_emas) as total_berat'), DB::raw('COUNT(products.id) as total_produk'))
            ->groupBy(
                'categories.category_code',
                'karats.name',
                'products.category_id',
                'products.karat_id'
            )
            ->orderBy('total_produk', 'desc'); // diurutakan berdasarkan stock dari yang paling tinggi

        return DataTables::of($stockData)
            ->addIndexColumn() // menambahkan penomoran pada kolom pertama table
            ->editColumn('total_berat', function ($data) { // mengedit kolom 'total_berat' dengan mengedit data yang ditampilkan
                return number_format($data->total_berat, 2, ',', '.') . ' gram';
            })
            // KAYANYA BELUM PERLU ACTION
            // ->addColumn('action', function($row){
            //     return '<a class="btn btn-sm btn-primary">Edit</a>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }

    // menampilkan laporan stok yang masih ada dan stok yang sudah terjual
    public function salesUnitReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::sales-unit.index');
    }

    // data untuk table Laporan Sales pada halaman stock/report
    public function salesUnitReportData()
    {
        $salesGold = SalesGold::select('products', 'total')->get(); // ambil kolom products dan total dari salesGold

        $karatSummary = []; // siapkan array kosong untuk data karats

        // loop data salesGold
        foreach ($salesGold as $sale) {
            $productIds = json_decode($sale->products, true); // ubah products pada salesGold menjadi array

            // memastikan bahwa productIds berupa array
            if (is_array($productIds)) {
                $products = Product::whereIn('id', $productIds) // ambil semua product berdasarkan id product yang didapat dari salesGold
                    ->select('id', 'karat_id', 'berat_emas')
                    ->get();

                // loop semua products nya
                foreach ($products as $product) {
                    $karatId = $product->karat_id; // ambil karat_id nya dari tiap 1 product

                    // cek apakah $karatSummary dengan key $karatId tersebut ada isinya
                    if (!isset($karatSummary[$karatId])) {
                        $karatSummary[$karatId] = [ // inisialisasi struktur data nya
                            'karat_id' => $karatId,
                            'total_berat' => 0,
                            'total_produk' => 0,
                            'total_penjualan' => 0
                        ];
                    }

                    $karatSummary[$karatId]['total_berat'] += $product->berat_emas; // diisi dengan berat emas, akan ditambahkan seiring data masuk
                    $karatSummary[$karatId]['total_produk'] += 1;  // menghitung banyak produk yang, bertambah seiring waktu
                    $karatSummary[$karatId]['total_penjualan'] += $sale->total;  // diisi dengan total, akan ditambahkan seiring data masuk
                }
            }
        }

        $karatIds = array_keys($karatSummary); // mengambil key nya saja dari $karatSummary sebagai array
        $karatNames = Karat::whereIn('id', $karatIds)->pluck('name', 'id'); // mengambil name dari karats dan memasang id nya sebagai key

        // loop $karatSummary
        foreach ($karatSummary as $id => &$row) {
            $row['karat_name'] = $karatNames[$id] ?? '-'; // memasukan name(nama karat) ke dalam $karatSummary jika ditemukan, jika tidak maka '-'
        }

        return DataTables::of(collect($karatSummary))
            ->addIndexColumn()
            ->editColumn('total_berat', function ($data) { // mengedit kolom 'total_berat' dengan mengedit data yang ditampilkan
                return number_format($data['total_berat'], 0, ',', '.') . ' gram';
            })
            ->editColumn('total_penjualan', function ($data) {
                return 'Rp. ' . number_format($data['total_penjualan'], 0, ',', '.');
            })
            // KAYANYA BELUM PERLU ACTION
            // ->addColumn('action', function($row){
            //     return '<a class="btn btn-sm btn-primary">Edit</a>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }
}
