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
use App\Models\Config;
use App\Models\Harga;
use App\Models\ProductHistories;
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

class ConfigController extends Controller
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
        $this->module_title = 'Sale';

        $this->module_name = 'sales';

        $this->module_path = 'sale';

        $this->module_icon = 'fas fa-sitemap';

        $this->module_model = "Modules\Sale\Entities\Sale";
        $this->module_detail = "Modules\Sale\Entities\SaleDetails";
        $this->module_payment = "Modules\Sale\Entities\SalePayment";
        $this->module_product = "Modules\Product\Entities\Product";
    }

    public function test_nota(){
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'config.nota', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                // 'dataKarat',
                // 'harga',
            )
        );
    }


    public function list() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }

        $config = Config::where('name', 'nota')->first();
        $value   = $config->value;
        $val    = json_decode($value, true);
        $toko = $val['toko'] ?? '';
        $alamat = $val['alamat'];
        $telp = $val['telp'];
        $info = $val['info'];
        return view(
            'config.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'toko',
                'alamat',
                'telp',
                'info',
            )
        );
    }

    public function cc() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $cc = Config::where('name', 'cc')->first();
        return view(
            'config.cc', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'cc',
            )
        );
    }

    public function buyback() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $buyback = Config::where('name', 'buyback')->first();
        $dec    = json_decode($buyback->value, true);
        $potongan   = $dec['potongan'];
        $tambahan   = $dec['tambahan'];
        return view(
            'config.buyback', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'potongan',
                'tambahan',
            )
        );
    }

    public function insert(Request $request){
        $value['toko'] = $request->toko;
        $value['alamat'] = $request->alamat;
        $value['telp'] = $request->telp;
        $value['info'] = $request->info;
        $val    = json_encode($value);
        $config = Config::create([
            'name'    => 'nota',
            'value'        => $val,
        ]);
        return redirect()->action([ConfigController::class, 'list']);
    }

    public function update(Request $request){
        $value['toko'] = $request->toko;
        $value['alamat'] = $request->alamat;
        $value['telp'] = $request->telp;
        $value['info'] = $request->info;
        $val    = json_encode($value);
        $config = Config::where('name', 'nota')->firstOrFail();
        $config->value = $val;
        $config->save();
        
        return redirect()->action([ConfigController::class, 'list']);
    }

    public function update_cc(Request $request){
        $config = Config::where('name', 'cc')->firstOrFail();
        $config->value = $request->cc;
        $config->save();
        
        return redirect()->action([ConfigController::class, 'cc']);
    }

    public function update_buyback(Request $request){
        $value['potongan'] = $request->potongan;
        $value['tambahan'] = $request->tambahan;
        $config = Config::where('name', 'buyback')->firstOrFail();
        $config->value = json_encode($value);
        $config->save();
        
        return redirect()->action([ConfigController::class, 'buyback']);
    }

}
