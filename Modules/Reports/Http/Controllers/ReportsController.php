<?php

namespace Modules\Reports\Http\Controllers;

use App\Models\Baki;
use App\Models\SalesGold;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Karat\Models\Karat;
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

        return view('reports::stock.index');
    }

    // data untuk table Laporan Stok pada halaman stock/report
    public function stockReportStock(Request $request)
    {
        $stockData = Karat::leftJoin('products', 'karats.id', '=', 'products.karat_id')
            ->select('karats.id', 'karats.name', DB::raw('SUM(products.berat_emas) as total_berat'), DB::raw('COUNT(products.id) as total_produk'))
            ->groupBy('karats.id', 'karats.name')
            ->orderBy('total_produk', 'desc');
            // jika ingin mengecek $stockData, lakukan di stockReport() di atas dengan cara mengcopy semua kodingan yang berhubungan

        return DataTables::of($stockData)
            ->addIndexColumn() // menambahkan penomoran pada kolom pertama table
            ->editColumn('total_berat', function ($data) { // mengedit kolom 'total_berat' dengan mengedit data yang ditampilkan
                return number_format($data->total_berat, 0, ',', '.') . ' gram';
            })
            // KAYANYA BELUM PERLU ACTION
            // ->addColumn('action', function($row){
            //     return '<a class="btn btn-sm btn-primary">Edit</a>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }

    // data untuk table Laporan Sales pada halaman stock/report
    public function stockReportSales()
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
        // jika ingin mengecek $karatSummary, lakukan di stockReport() di atas dengan cara mengcopy semua kodingan yang berhubungan

        return DataTables::of(collect($karatSummary))
            ->addIndexColumn()
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
