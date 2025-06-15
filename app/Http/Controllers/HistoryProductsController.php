<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Supplier;
use DateTime;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Category;
use Modules\Group\Models\Group;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Stok\Models\StockOffice;
use App\Models\Harga;
use App\Models\ProductHistories;
use Yajra\DataTables\DataTables;

class HistoryProductsController extends Controller
{
    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_categories;
    private $module_products;
    private $code;

    public function __construct()
    {
        $this->module_title = 'Karat';
        $this->module_name = 'karat';
        $this->module_path = 'karats';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Karat\Models\Karat";
    }
    

    public function list(Request $request)
    {
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::latest()->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'product_histories.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'dataKarat',
                'harga',
            )
        );
    }

    public function history(Request $request)
    {
        $harga = Harga::latest()->first();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'Karats.history', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'dataKarat',
                'harga',
            )
        );
    }

    public function product_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // $harga = ProductHistories::where('tanggal', date('Y-m-d'))->first();  
        // if($harga == null){
        //     $harga  = 0;
        // }else{
        //     $harga = $harga->harga;
        // }     
        // $harga  = 1000000;
        $$module_name = ProductHistories::with('product')->latest()->get();
        // echo $$module_name;        
        $data = $$module_name;
        return Datatables::of($data)
                    // ->addColumn('action', function ($data) {
                    //    $module_name = $this->module_name;
                    //     $module_model = $this->module_model;
                    //     $module_path = $this->module_path;
                    //     return view($module_name.'::'.$module_path.'.includes.action',
                    //     compact('module_name', 'data', 'module_model'));
                    //         })

                    ->editColumn('status', function($data){
                        $status = '';
                        if($data->status == 'S'){
                            $status = 'Sold';
                        }
                        elseif($data->status == 'B'){
                            $status = 'Buyback';
                        }
                        elseif($data->status == 'P'){
                            $status = 'Pending';
                        }
                        elseif($data->status == 'L'){
                            $status = 'Buy Luar';
                        }
                        elseif($data->status == 'H'){
                            $status = 'Hancur/Lebur';
                        }
                        return $status;
                         }) 
                         
                        ->editColumn('harga', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->harga) . '</h3>
                                    </div>';
                             })  

                      ->editColumn('tanggal', function($data){
                        $output = '';
                            
                       return '<div class="items-center text-center">' .($data->tanggal) . '</div>';
                        }) 
                      ->editColumn('product', function($data){
                            $output = '';
                          
                        // return '<div class="items-center text-center">
                        //                      ' .($data->product->product_code ?? 'Admin').'
                        //             </div>';

                        return ($data->product->product_code ?? 'Admin');

                        })   
                      
                        ->rawColumns(['harga', 'tanggal','user'])
                        ->make(true);
    }
}
