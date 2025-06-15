<?php


namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Webcam;
use PDF;
use Auth;
use Yajra\DataTables\DataTables;

class WebcamController extends Controller
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

    public function list() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $webcam  = Webcam::latest()->first();

        return view(
            'webcam.list', // Path to your create view file
            compact(
                'webcam',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function update(Request $request){
        $value = $request->value;
        
        $webcam          = Webcam::where('id', 1)->firstOrFail();
        $webcam->value   = $value;
        $webcam->save();
        
        return redirect()->action([WebcamController::class, 'list']);
    }
}
