<?php


namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;
use Modules\Sale\Http\Requests\StorePosSaleRequest;
use PDF;
use Auth;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Product\Models\ProductStatus;
use Yajra\DataTables\DataTables;
use Modules\Karat\Models\Karat;
use Modules\ProdukModel\Models\ProdukModel;

class JualController extends Controller
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
        $this->module_title = 'Sale';

        $this->module_name = 'sales';

        $this->module_path = 'sale';

        $this->module_icon = 'fas fa-sitemap';

        $this->module_model = "Modules\Sale\Entities\Sale";
        $this->module_detail = "Modules\Sale\Entities\SaleDetails";
        $this->module_payment = "Modules\Sale\Entities\SalePayment";
        $this->module_product = "Modules\Product\Entities\Product";
    }


    public function list() {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        Cart::instance('sale')->destroy();
        $karat  = Karat::latest()->get();
        $category  = Category::latest()->get();
        $group  = Group::latest()->get();
        $models  = ProdukModel::latest()->get();
        $customers = Customer::all();
        $product_categories = Category::all();

        return view('sale.list', compact('product_categories', 'customers', 'karat', 'category', 'group', 'models'));
    }

    public function data_report(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = SalesGold::with('pelanggan')->latest()->get();
        // $$module_name = SalesGold::latest()->get();
        
        $data = $$module_name;
        // echo $data;
        // exit();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'sale.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })

            // ->editColumn('product_name', function ($data) {
            //     $tb = '<div class="flex items-center gap-x-2">
            //             <div>
            //                <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
            //                 ' . $data->category?->category_name . '</div>

            //                 <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
            //                  <div class="text-xs font-normal text-blue-500 font-semibold">
            //                 ' . @$data->cabang->name . '</div>


            //             </div>
            //         </div>';
            //     return $tb;
            // })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })

            ->editColumn('customer', function ($data) {
                return $data->pelanggan->customer_name ?? '-';
            })

            ->editColumn('created_at', function ($data) {
                return tgljam($data->created_at);
            })

            ->editColumn('total', function ($data) {
                return number_format($data->total);
            })
            
            ->rawColumns([
                'created_at', 'product_image', 'keterangan', 'code', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'berat_emas', 'cabang', 'action'
            ])
            ->make(true);
        }

    public function laporan() {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        Cart::instance('sale')->destroy();
        $karat  = Karat::latest()->get();
        $category  = Category::latest()->get();
        $group  = Group::latest()->get();
        $models  = ProdukModel::latest()->get();
        $customers = Customer::all();
        $product_categories = Category::all();
        $module_title   = $this->module_title;
        return view(
            'sale.report', compact(
                'module_title', 'product_categories', 'customers', 'karat', 'category', 'group', 'models'
            )
        );
    }

    public function test_pdf(){
        $data = [
            'title' => 'Nota Emas',
            'date' => date('d/m/Y H:i:s'),
            'products' => [
                ['name' => 'Produk A', 'code' => 'CEmas 17K160125435', 'gram' => 1, 'price' => 10000],
                ['name' => 'Produk B', 'code' => 'GEMAS 375140225232', 'gram' => 2, 'price' => 15000],
                ['name' => 'Produk B', 'code' => 'GEMAS 375140225232', 'gram' => 2, 'price' => 15000],
            ]
        ];

        $pdf = PDF::loadView('sale.invoice', $data)->setPaper('a5', 'landscape');
        return $pdf->stream('invoice.pdf');
        // return $pdf->download('invoice.pdf');
    }

    public function print(Request $request){
        $id         = $request->id;
        $password   = $request->password;
        $print      = '';
        if($password !== 'password'){
            $print  = '';
            toast('Password Salah!', 'error');
            return redirect()->back();
        }
        $nama_cus   = '';
        $address    = '';        
        $array      = array();

        $config = Config::where('name', 'nota')->first();
        $value  = $config->value;
        $val    = json_decode($value, true);
        $alamat = $val['alamat'];
        $telp   = $val['telp'];
        $info   = $val['info'];

        $salesGold  = SalesGold::where('id', $id)->first();
        if(!$salesGold){
            toast('Data Sales not found!', 'error');
            return redirect()->back();
        }
        $customer   = $salesGold->customer;
        if($customer != '0'){
            $customer   = Customer::where('id', $customer)->first();
            $nama_cus   = $customer->customer_name;
            $address    = $customer->address;
        }
        $salesItem  = SalesItem::where('sales_gold_id', $id)->get();
        $number     = 0;

        foreach($salesItem as $s){
            $product      = $s->product;
            // echo $product;
            // exit();
            $images = 'non';
            $title  = 'Faktur';
            $gram   = 0;
            if($product !== 0){
                $title  = 'Nota Emas';
                $image  = Product::where('id', $product)->first();
                // exit();
                // echo $image;
                $gram   = $image->berat_emas;
                $images = $image->images;
            }
            $name       = $s->desc;
            $desc       = $s->name;
            $ongkos     = $s->ongkos;
            $diskon     = $s->diskon;
            $harga      = $s->total;
            $salesNomor = $s->nomor;
            
            $array['products'][$number]['title'] = $title;
            $array['products'][$number]['img'] = $images;
            $array['products'][$number]['name'] = $name;
            $array['products'][$number]['desc'] = $desc;
            $array['products'][$number]['gram'] = $gram;
            $array['products'][$number]['ongkos'] = $ongkos;
            $array['products'][$number]['diskon'] = $diskon;
            $array['products'][$number]['harga'] = $harga;
            $array['products'][$number]['nomor'] = $salesNomor;
            $array['products'][$number]['sales_id'] = $salesNomor;
            // $array['products'][$number]['sales_id'] = $sales_id;
            $array['products'][$number]['alamat'] = $alamat;
            $array['products'][$number]['telp'] = $telp;
            $array['products'][$number]['info'] = $info;
            $array['products'][$number]['print'] = $print;
            $array['products'][$number]['customer'] =$nama_cus;
            $array['products'][$number]['address'] =$address;


            // $array['products'][$number]['title'] = $title;
            // $array['products'][$number]['img'] = $images;
            // $array['products'][$number]['name'] = $name;
            // $array['products'][$number]['desc'] = $desc;
            // $array['products'][$number]['gram'] = $gram;
            // $array['products'][$number]['ongkos'] = $request->ongkos[$number];
            // $array['products'][$number]['diskon'] = $request->diskon[$number];
            // $array['products'][$number]['harga'] = $harga;
            // $array['products'][$number]['nomor'] = $salesNomor;
            // $array['products'][$number]['sales_id'] = $salesNomor;
            // // $array['products'][$number]['sales_id'] = $sales_id;
            // $array['products'][$number]['alamat'] = $alamat;
            // $array['products'][$number]['telp'] = $telp;
            // $array['products'][$number]['info'] = $info;
            // $array['products'][$number]['customer'] =$nama_cus;
            // $array['products'][$number]['address'] =$address;
            
            $number++;
        }
        
        

        
        // exit();
        
        
        

        // echo json_encode($array);
        // exit();

        $pdf = PDF::loadView('sale.invoice', $array)
              ->setPaper('a5', 'landscape')  // A5 paper size, landscape orientation
              ->setOptions([
                  'isHtml5ParserEnabled' => true,  // Enable HTML5
                  'isPhpEnabled' => true  // Enable PHP if necessary for advanced functionality
              ]);

        // $pdf = PDF::loadView('sale.invoice', $array)
        //       ->setPaper('a5', 'landscape')  // Set paper size to A5 and orientation to landscape
        //       ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);  // Enable HTML5 and PHP if needed
    
        return $pdf->stream('invoice.pdf');


        // $pdf = PDF::loadView('sale.invoice', $array)->setPaper('a5', 'landscape');
        // return $pdf->stream('invoice.pdf');
    }

    public function insert(Request $request){
        // echo json_encode($_POST);
        // exit();
        $config = Config::where('name', 'nota')->first();
        $value   = $config->value;
        $val    = json_decode($value, true);
        $alamat = $val['alamat'];
        $telp = $val['telp'];
        $info = $val['info'];
        $lanjut = true;
        $print  = '';
        $products   = array();        
        $services   = array();        
        $total      = 0;
        $number     = 0;
        $nama_cus   = '';
        $address    = '';
        if($request->customer != '0'){
            $customer   = Customer::where('id', $request->customer)->first();
            $nama_cus   = $customer->customer_name;
            $address    = $customer->address;
            //         $nama_cus   = '
            // <p style="text-align: right; font-size:13px">Kepada Yth : '.$nama_cus.'</p>
            //         ';
        }
        foreach ($request->product as $p) {
            if($p == 0){ // SERVICE NON PRODUCT
                $services[] = $p;
            }else{
                if(in_array($p, $products)){
                    return redirect()->action([JualController::class, 'list']);
                }
                $sold = Product::where('id', $p)
                ->where('status_id', 2)
                ->get();

                if ($sold->isNotEmpty()) {
                    $print      = '';
                    $lanjut = false;
                    // return redirect()->action([JualController::class, 'list']);
                }

                $products[] = $p;
            }
            $harga  = $request->harga[$number];

            $total  = $total+$harga;
            $number++;
        }
        // INSERT SALES
        // $nomor  = '0000000001';
        $nomor  = SalesGold::latest()->first();
        // echo json_encode($nomor);
        // exit();
        $nomor  = $nomor->nomor;
        $nomor  = (int)$nomor+1;
        for ($i=0; $i < 8; $i++) { 
            if(strlen($nomor) !== $i){
                $nomor  = '0'.$nomor;
            }
        }

        if($lanjut){
            $salesGold  = SalesGold::create([
                'nomor' => $nomor,
                'customer' => $request->customer,
                'products' => json_encode($products),
                'services' => json_encode($services),
                'total' => $total,
            ]);
            $id = $salesGold->id;
        }

        // UPDATE STATUS PRODUCT
        $data   = array();
        $number     = 0;
        $jumlah_data    = count($request->product);
        foreach ($request->product as $p) {
            if($p == 0){ // SERVICE NON PRODUCT
                $title  = 'Faktur';
                $name   = $request->product_name[$number];
                $desc   = $request->product_desc[$number];
                $gram   = '-';
                $images = 'non';
                $harga  = $request->harga[$number];
                if($lanjut){
                    $serv   = Service::create([
                        'sales' => $id,
                        'name'  => $name,
                        'desc'  => $desc,
                        'total' => $harga
                    ]);
    
                    $product_history = ProductHistories::create([
                        'product_id'    => $p,
                        'status'        => 'S',
                        'keterangan'    => $id,
                        'harga'         => $request->harga[$number],
                        'tanggal'       => date('Y-m-d'),
                    ]);
                }
            }else{
                $title  = 'Nota Emas';
                $product= Product::where('id', $p)->firstOrFail();
                $name   = $product->product_name;
                $images = $product->images;
                $desc   = $product->product_code;
                $gram   = $product->berat_emas;
                $harga  = $request->harga[$number];
                $product->status_id = 2;
                $product->status = 2;
                $product->baki_id = 0;
                $product->save();

                // INSERT KE PRODUCT HISTORY
                if($lanjut){
                    $product_history = ProductHistories::create([
                        'product_id'    => $p,
                        'status'        => 'S',
                        'keterangan'    => 'terjual',
                        'harga'         => $request->harga[$number],
                        'tanggal'       => date('Y-m-d'),
                    ]);
                }
            }

            // INSERT SALES ITEMS
            $kurangi = $number-$jumlah_data;
            if($lanjut){
                $kurangi    = 0;
            }
            // $salesNomor = SalesItem::latest()->first();
            $salesNomor = SalesItem::orderBy('id', 'desc')->first();
            $salesNomor = $salesNomor->nomor != null ? $salesNomor->nomor : '0000000001';
            // $salesNomor  = (int)$salesNomor+1+$jumlah_data+$kurangi;
            // echo $salesNomor;
            $salesNomor = (int)$salesNomor+1+$kurangi;
            // echo $salesNomor;
            // exit();
            for ($i=0; $i < 9; $i++) { 
                if(strlen($salesNomor) !== $i){
                    $salesNomor  = '0'.$salesNomor;
                }
            }
            if($lanjut){
                $salesItem  = SalesItem::create([
                    'sales_gold_id'     => $id,
                    'nomor'     => $salesNomor,
                    'product'   => $p,
                    'name'      => $name,
                    'desc'      => $desc,
                    'diskon'      => $request->diskon[$number],
                    'ongkos'      => $request->ongkos[$number],
                    'total'     => $harga,
                ]);
                $sales_id   = $salesItem->id;
            }

            // for ($i=0; $i < 8; $i++) { 
            //     if(strlen($sales_id) !== $i){
            //         $sales_id  = '0'.$sales_id;
            //     }
            // }

            $array['products'][$number]['title'] = $title;
            $array['products'][$number]['img'] = $images;
            $array['products'][$number]['name'] = $name;
            $array['products'][$number]['desc'] = $desc;
            $array['products'][$number]['gram'] = $gram;
            $array['products'][$number]['ongkos'] = $request->ongkos[$number];
            $array['products'][$number]['diskon'] = $request->diskon[$number];
            $array['products'][$number]['harga'] = $harga;
            $array['products'][$number]['nomor'] = $salesNomor;
            $array['products'][$number]['sales_id'] = $salesNomor;
            // $array['products'][$number]['sales_id'] = $sales_id;
            $array['products'][$number]['alamat'] = $alamat;
            $array['products'][$number]['telp'] = $telp;
            $array['products'][$number]['info'] = $info;
            $array['products'][$number]['print'] = $print;
            $array['products'][$number]['customer'] =$nama_cus;
            $array['products'][$number]['address'] =$address;

            $number++;
        }

        // echo json_encode($array);
        // exit();

        $pdf = PDF::loadView('sale.invoice', $array)
              ->setPaper('a5', 'landscape')  // A5 paper size, landscape orientation
              ->setOptions([
                  'isHtml5ParserEnabled' => true,  // Enable HTML5
                  'isPhpEnabled' => true  // Enable PHP if necessary for advanced functionality
              ]);
        return $pdf->stream('invoice.pdf');






        // $pdf = PDF::loadView('sale.invoice', $array)
        //       ->setPaper('a5', 'landscape')  // Set paper size to A5 and orientation to landscape
        //       ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);  // Enable HTML5 and PHP if needed
    


        // $pdf = PDF::loadView('sale.invoice', $array)->setPaper('a5', 'landscape');
        // return $pdf->stream('invoice.pdf');
    }

    public function index_data(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = Product::with('category', 'product_item', 'karats', 'baki');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        // if($id == 1){ // with nota
        //     $$module_name->where('is_nota', true)->get();
        // }
        // if($id == 2){ // without nota
        //     $$module_name->where('is_nota', false)->get();
        // }
        $$module_name = $$module_name->whereHas('baki', function ($query) {
            $query->where('status', 'A');
        });
        $$module_name->where('status_id', 1)->get();

        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                // return view(
                //     'product::products.partials.actions',
                //     compact('module_name', 'data', 'module_model')
                // );
                return view('sale.action', compact('module_name', 'data', 'module_model'));

            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('product_code', function ($data) {
                return $data->product_code;
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('rekomendasi', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah((($data->karat->coef*$data->harga)+($data->karat->coef*$data->harga*$data->karat->persen/100))*$data->berat_emas) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                // $tb = '<div class="items-center gap-x-2">
                //                 <div class="text-sm text-center text-gray-500">
                //                 Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                //                 </div>
                //                 </div>';
                // $karatnya   = $data->karat->name.' | '.$data->karat->kode;
                $karat  = $data->karat->name ?? '-';
                $berat  = $data->berat_emas ?? 0;
                $akhir  = $karat.' | '.$berat.'gr';
                // return $data->karat->name ?? '-';
                return $akhir;
                // return $data->karat->coef;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'rekomendasi', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function index_data_baki(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $module_name = Product::with('category', 'karats', 'baki');
        // $module_name = Product::query();
        // $$module_name = Product::with('category', 'karats');
        // $$module_name = Product::with('karats');
        $module_name->whereIn('status_id', [1, 3, 4]);
        // $$module_name->where('baki_id', '!=', $id);
        $module_name->whereRaw('baki_id != ?', [$id]);
        // $final_sql  = $$module_name->toSql();
        // dd($final_sql);
        $module_name = $module_name->latest()->get();
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        $module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                // return view(
                //     'product::products.partials.actions',
                //     compact('module_name', 'data', 'module_model')
                // );
                return view('sale.action', compact('module_name', 'data', 'module_model'));

            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('product_code', function ($data) {
                return $data->product_code;
            })

            ->addColumn('baki', function ($data) {
                return $data->baki->name;
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('rekomendasi', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)*$data->berat_emas) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                // $tb = '<div class="items-center gap-x-2">
                //                 <div class="text-sm text-center text-gray-500">
                //                 Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                //                 </div>
                //                 </div>';
                // $karatnya   = $data->karat->name.' | '.$data->karat->kode;
                return $data->karat->name ?? '-';
                // return $data->karat->coef;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'rekomendasi', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function index_data_custom(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = Product::with('category', 'karats', 'baki');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        
        $$module_name = $$module_name->where('status_id', '!=', 2);
        $$module_name->where('baki_id', $id)->get();
        // $$module_name->where('status_id', 1)->get();

        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                // return view(
                //     'product::products.partials.actions',
                //     compact('module_name', 'data', 'module_model')
                // );
                return view('sale.action', compact('module_name', 'data', 'module_model'));

            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('product_code', function ($data) {
                return $data->product_code;
            })

            ->addColumn('baki', function ($data) {
                return $data->baki->name;
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('rekomendasi', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)*$data->berat_emas) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                // $tb = '<div class="items-center gap-x-2">
                //                 <div class="text-sm text-center text-gray-500">
                //                 Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                //                 </div>
                //                 </div>';
                // $karatnya   = $data->karat->name.' | '.$data->karat->kode;
                return $data->karat->name ?? '-';
                // return $data->karat->coef;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'rekomendasi', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }
}
