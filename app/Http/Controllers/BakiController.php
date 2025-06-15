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
use Modules\Product\Entities\Product;
use Modules\Group\Models\Group;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Stok\Models\StockOffice;
use App\Models\Harga;
use App\Models\Baki;
use Yajra\DataTables\DataTables;

class BakiController extends Controller
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
        $this->module_title = 'Baki';
        $this->module_name = 'baki';
        $this->module_path = 'bakis';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "App\Models";
    }
    
    public function insert(Request $request)
    {
        $baki    = Baki::create([
            'code'      => $request->code,
            'posisi'    => $request->posisi,
            'name'      => $request->name,
            'capacity'  => $request->capacity,
        ]);

        return redirect()->action([BakiController::class, 'list']);
    }

    public function update(Request $request)
    {
        $baki = Baki::where('id', $request->id)->firstOrFail();
        $baki->posisi = $request->posisi;
        $baki->code = $request->code;
        $baki->name = $request->name;
        $baki->capacity = $request->capacity;
        $baki->save();

        return redirect()->action([BakiController::class, 'list']);
    }

    public function list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'bakis.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
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
        $$module_name = Baki::where('id', '!=', 3)->get();
        $$module_name = Baki::latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('bakis.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })

            ->editColumn('used', function ($data) {
                $count  = Product::where('baki_id', $data->id)->count();
                return ($count);
            })
                
            ->rawColumns(['code', 'posisi', 'name', 'capacity'])
            ->make(true);
    }
}
