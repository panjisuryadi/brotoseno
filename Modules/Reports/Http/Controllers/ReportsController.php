<?php

namespace Modules\Reports\Http\Controllers;

use App\Models\Harga;
use App\Models\SalesGold;
use App\Models\SalesItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Karat\Models\Karat;
use Modules\People\Entities\Customer;
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

    ///// REPORT STOK
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
    /// END REPORT STOK

    ///// PENJUALAN UNIT
    public function salesUnitReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::sales-unit.index');
    }

    public function salesUnitReportExcel(Request $request){
        $product = Product::join('karats', 'products.karat_id', '=', 'karats.id')
            ->join('sales_items', 'products.id', '=', 'sales_items.product')
            ->select('products.berat_emas', 'products.karat_id', 'karats.name as karat_name', 'sales_items.total')
            ->where(function ($query) {
                $query->where('products.status', 2)
                    ->orWhere('products.status_id', 2);
            });

        if ($request->startDate && $request->endDate) {
            $startDate = Carbon::parse($request->startDate)->startOfDay();
            $endDate = Carbon::parse($request->endDate)->endOfDay();
            $product->whereBetween('sales_items.created_at', [$startDate, $endDate]);
        }
        $product = $product->get();
        $karatSummary = [];

        foreach($product as $p){
            $karatId    = $p->karat_id;
            $karatName    = $p->karat_name;
            $berat      = $p->berat_emas;
            $total      = $p->total;
            $karatSummary[$karatId]['karat_id'] = $karatId;
            $karatSummary[$karatId]['karat_name'] = $karatName;
            if(isset($karatSummary[$karatId]['total_produk'])){
                $karatSummary[$karatId]['total_produk'] += 1;
            }else{
                $karatSummary[$karatId]['total_produk'] = 1;
            }
            if(isset($karatSummary[$karatId]['total_berat'])){
                $karatSummary[$karatId]['total_berat'] += $berat;
            }else{
                $karatSummary[$karatId]['total_berat'] = $berat;
            }
            if(isset($karatSummary[$karatId]['total_penjualan'])){
                $karatSummary[$karatId]['total_penjualan'] += $total;
            }else{
                $karatSummary[$karatId]['total_penjualan'] = $total;
            }
        }

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Penjualan_Unit.xls");

        echo '<table border="1">';
        echo '<thead>
            <tr>
                <th>Nama Karat</th>
                <th>Total Berat</th>
                <th>Total Product</th>
                <th>Sales </th>
            </tr>
        </thead>
        <tbody>';

        $total_berat    = 0;
        $total_qty      = 0;
        $total_rupiah   = 0;

        foreach ($karatSummary as $row) {
            echo '<td>' . htmlspecialchars($row['karat_name']) . '</td>';
            echo '<td align="right">' . number_format($row['total_berat'], 2) . '</td>';
            echo '<td align="right">' . number_format($row['total_produk']) . '</td>';
            echo '<td align="right">Rp ' . number_format($row['total_penjualan'], 0, ',', '.') . '</td>';
            echo '</tr>';

            $total_berat    = $total_berat+$row['total_berat'];
            $total_qty      = $total_qty+$row['total_produk'];
            $total_rupiah   = $total_rupiah+$row['total_penjualan'];
        }

        echo '
        <tfoot>
        <tr>
        <td colspan="1">Total</td>
        <td align="right">'.number_format($total_berat, 2).'</td>
        <td align="right">'.number_format($total_qty).'</td>
        <td align="right">Rp '.number_format($total_rupiah, 0, ',', '.').'</td>
        <tr>
        </tfoot>
        ';

        echo '</tbody></table>';
        exit;
    }

    public function salesUnitReportData(Request $request){
        $product = Product::join('karats', 'products.karat_id', '=', 'karats.id')
            ->join('sales_items', 'products.id', '=', 'sales_items.product')
            ->select('products.berat_emas', 'products.karat_id', 'karats.name as karat_name', 'sales_items.total')
            ->where(function ($query) {
                $query->where('products.status', 2)
                    ->orWhere('products.status_id', 2);
            });

        if ($request->startDate && $request->endDate) {
            $startDate = Carbon::parse($request->startDate)->startOfDay();
            $endDate = Carbon::parse($request->endDate)->endOfDay();
            $product->whereBetween('sales_items.created_at', [$startDate, $endDate]);
        }
        $product = $product->get();
        $karatSummary = [];

        foreach($product as $p){
            $karatId    = $p->karat_id;
            $karatName    = $p->karat_name;
            $berat      = $p->berat_emas;
            $total      = $p->total;
            $karatSummary[$karatId]['karat_id'] = $karatId;
            $karatSummary[$karatId]['karat_name'] = $karatName;
            if(isset($karatSummary[$karatId]['total_produk'])){
                $karatSummary[$karatId]['total_produk'] += 1;
            }else{
                $karatSummary[$karatId]['total_produk'] = 1;
            }
            if(isset($karatSummary[$karatId]['total_berat'])){
                $karatSummary[$karatId]['total_berat'] += $berat;
            }else{
                $karatSummary[$karatId]['total_berat'] = $berat;
            }
            if(isset($karatSummary[$karatId]['total_penjualan'])){
                $karatSummary[$karatId]['total_penjualan'] += $total;
            }else{
                $karatSummary[$karatId]['total_penjualan'] = $total;
            }
        }

        return DataTables::of(collect($karatSummary))
        ->addIndexColumn()
        ->editColumn('total_berat', function ($data) { // mengedit kolom 'total_berat' dengan mengedit data yang ditampilkan
            return number_format($data['total_berat'], 2, ',', '.') . ' gram';
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

    public function salesUnitReportData_()
    {
        $salesGold = SalesGold::select('id', 'products', 'total')->get(); // ambil kolom products dan total dari salesGold
        echo json_encode($salesGold);
        exit();
        $karatSummary = []; // siapkan array kosong untuk data karats

        // loop data salesGold
        foreach ($salesGold as $sale) {
            $productIds = json_decode($sale->products, true); // ubah products pada salesGold menjadi array

            // memastikan bahwa productIds berupa array
            if (is_array($productIds)) {
                $products = Product::whereIn('id', $productIds) // ambil semua product berdasarkan id product yang didapat dari salesGold
                    ->where('status', 2)
                    ->where('status_id', 2)
                    ->select('id', 'karat_id', 'berat_emas')
                    ->get();

                // loop semua products nya
                $number = 1;
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
                    // $karatSummary[$karatId]['total_penjualan'] += $sale->total;  // diisi dengan total, akan ditambahkan seiring data masuk
                    $karatSummary[$karatId]['total_penjualan'] += $sale->id;  // diisi dengan total, akan ditambahkan seiring data masuk
                    // $karatSummary[$karatId]['total_penjualan'] += $sale->total;  // diisi dengan total, akan ditambahkan seiring data masuk
                    if($number == 0){
                    }
                    // $number++;
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
                return number_format($data['total_berat'], 2, ',', '.') . ' gram';
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
    /// END PENJUALAN UNIT

    ///// PENJUALAN PER PELANGGAN
    public function salesCustomersReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        return view('reports::sales-customers.index');
    }

    public function salesCustomersReportData()
    {
        $sales = SalesGold::with('pelanggan')->get();

        // inisialisasi array results
        $results = [];

        // mengloop data sales_gold dengan mengambil customer_idnya dan juga datanya menjadi $salesGroup
        foreach ($sales->groupBy('pelanggan.id') as $customerId => $salesGroup) {
            // mengambil customer_name dan jika tidak ada maka "-"
            $customerName = optional($salesGroup->first()->pelanggan)->customer_name ?? '-';
            // mengambil customer_phone dan jika tidak ada maka "-"
            $customerPhone = optional($salesGroup->first()->pelanggan)->customer_phone ?? '-';
            // mengakumulasikan semua total
            $totalPembelian = $salesGroup->sum('total');
            // inisialisasi totalBerat dan totalKuantitas
            $totalBerat = 0;
            $totalKuantitas = 0;

            foreach ($salesGroup as $sale) {
                // mengubah data dari products menjadi array
                $productIds = json_decode($sale->products, true) ?? [];

                // mengecek apakah data beneran array
                if (is_array($productIds)) {
                    // mengambil semua berat emas dari setiap product
                    $products = Product::whereIn('id', $productIds)
                        ->select('berat_emas')
                        ->get();

                    // mengloop dan mengakumulasikan semua berat emas
                    foreach ($products as $product) {
                        $totalBerat += $product->berat_emas;
                    }
                }

                // menghitung banyak produk
                $hitungProduct = Product::whereIn('id', $productIds)
                    ->count();
                // mengakumulasikan semua produk
                $totalKuantitas += $hitungProduct;
            }

            // menyimpan semua data di dalam array
            $results[] = [
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'total_pembelian' => $totalPembelian,
                'total_berat' => $totalBerat,
                'total_kuantitas' => $totalKuantitas,
            ];
        };

        // sort array berdasarkan customer_name
        $sortedResult = collect($results)->sortByDesc('customer_name')->values();

        return DataTables::of($sortedResult)
            ->addIndexColumn()
            ->editColumn('customer_name', function ($data) {
                return $data['customer_name'];
            })
            ->editColumn('total_pembelian', function ($data) {
                return 'Rp. ' . number_format($data['total_pembelian'], 0, ',', '.');
            })
            ->editColumn('total_berat', function ($data) {
                return number_format($data['total_berat'], 2, ',', '.') . ' gram';
            })
            ->addColumn('action', function ($data) {
                return view('reports::sales-customers.action', compact('data'));
            })
            ->make(true);
    }

    public function salesCustomersReportDetail($customer_id)
    {
        $customer_id = decode_id($customer_id);
        abort_if(Gate::denies('access_reports'), 403);

        $customer_name = Customer::where('id', $customer_id)->first()->customer_name;

        return view('reports::sales-customers.detail', compact('customer_id', 'customer_name'));
    }

    public function salesCustomersReportDetailData(Request $request, $customer_id)
    {
        $query = SalesGold::with('pelanggan');

        if (!empty($request->startDate) && !empty($request->endDate)) {
            $start = Carbon::parse($request->startDate)->startOfDay();
            $end = Carbon::parse($request->endDate)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $sales = $query->where('customer', $customer_id)->latest()->get();

        $hargaEmas = Harga::latest()->first()->harga;

        $results = [];

        foreach ($sales as $sale) {
            $productIds = json_decode($sale->products, true);

            if (!is_array($productIds)) continue;

            $products = Product::whereIn('id', $productIds)
                ->with('category')
                ->with('karats')
                ->get();

            foreach ($products as $product) {

                // KOMPONEN UNTUK HARGA JUAL:
                $coef = $product->karats->coef;
                $persenMargin = $product->karats->persen;
                $beratEmas = $product->berat_emas;

                // MEMBUAT HARGA JUAL PRODUK
                $hargaCoef = $coef * $hargaEmas;
                $hargaJual = $hargaCoef + ($hargaCoef * ($persenMargin / 100));
                $hargaTotalProduk = ceil($hargaJual * $beratEmas / 1000) * 1000;

                // format angka rupiah
                $formattedCash = 'Rp. ' . number_format($sale->cash, 0, ',', '.');
                $formattedTransfer = 'Rp. ' . number_format($sale->transfer, 0, ',', '.');
                $formattedEdc = 'Rp. ' . number_format($sale->edc, 0, ',', '.');
                $formattedQr = 'Rp. ' . number_format($sale->qr, 0, ',', '.');
                $formattedTotal = 'Rp. ' . number_format($sale->total, 0, ',', '.');
                $formattedHargaTotalProduk = 'Rp. ' . number_format($hargaTotalProduk, 0, ',', '.');
                $formattedRata2 = 'Rp. ' . number_format($hargaTotalProduk / $beratEmas, 0, ',', '.');

                // format berat emas
                $formattedBeratEmas = number_format($product->berat_emas, 2, ',', '.');
                $tanggal = Carbon::parse($sale->created_at)->translatedFormat('d F Y');
                $jam = $sale->created_at->format('H:i');

                $results[] = [
                    'id' => $sale->id,
                    'nomor_transaksi' => $sale->nomor,
                    'waktu' => $tanggal . " | " . $jam,
                    'sales' => '-',
                    'customer_name' => $sale->pelanggan->customer_name ?? '-',
                    'category_code' => $product->category->category_code ?? '-',
                    'product_name' => $product->product_name,
                    'berat_emas' => $formattedBeratEmas,
                    'karat' => $product->karats->name,
                    'h_jual' => $formattedHargaTotalProduk,
                    'ongkos' => '-',
                    'total' => $formattedTotal,
                    'cash' => $sale->cash ? $formattedCash : '-',
                    'transfer' => $sale->transfer ? $formattedTransfer : '-',
                    'edc' => $sale->edc ? $formattedEdc : '-',
                    'qr' => $sale->qr ? $formattedQr : '-',
                    'rata_rata' => $formattedRata2,
                    'keterangan' => '-',
                ];
            }
        }

        return Datatables::of($results)
            ->addColumn('action', function ($data) {
                $module_name = 'sales';
                $module_model = "Modules\Sale\Entities\Sale";
                return view(
                    'sale.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /// END PENJUALAN PER PELANGGAN
}
