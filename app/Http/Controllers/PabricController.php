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
use App\Models\Pabric;
use Yajra\DataTables\DataTables;

class PabricController extends Controller
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
        $this->module_title = 'pabric';
        $this->module_name = 'pabric';
        $this->module_path = 'pabrics';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "App\Models";
    }
    
    public function insert(Request $request)
    {
        $check  = Pabric::where('name', $request->name)->where('status', 'A')->first();
        if($check){
            toast('Nama Pabrik Sudah ada', 'error');
            return redirect()->back();
        }
        $pabric    = pabric::create([
            'name'      => $request->name,
        ]);

        return redirect()->action([PabricController::class, 'list']);
    }

    public function update(Request $request)
    {
        $check  = Pabric::where('id', '!=', $request->id)->where('name', $request->name)->where('status', 'A')->first();
        if($check){
            toast('Nama Pabrik Sudah ada', 'error');
            return redirect()->back();
        }
        $pabric = pabric::where('id', $request->id)->firstOrFail();
        $pabric->name = $request->name;
        $pabric->save();

        return redirect()->action([PabricController::class, 'list']);
    }

    public function delete(Request $request)
    {
        $pabric = pabric::where('id', $request->id)->firstOrFail();
        $pabric->status = 'B';
        $pabric->save();

        return redirect()->action([PabricController::class, 'list']);
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
            'pabrics.list', // Path to your create view file
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
        $$module_name = pabric::where('status', 'A')->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('pabrics.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })

            ->rawColumns(['code', 'posisi', 'name', 'capacity'])
            ->make(true);
    }
}
