<?php

namespace Modules\Adjustment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\DataTables\StocksDataTable;
use Modules\Product\Entities\ProductLocation;
use Modules\Locations\Entities\Locations;
use Modules\Product\Entities\Category;
use Yajra\DataTables\DataTables;

class RfidController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index() {
        abort_if(Gate::denies('access_adjustments'), 403);
        $stock = ProductLocation::sum('stock');
        $product = ProductLocation::distinct()->count('product_id');
        $asets  = ProductLocation::join('products','product_locations.product_id','products.id')->get();
        $category = ProductLocation::join('products','product_locations.product_id','products.id')->distinct()->count('category_id');

        $locations = Locations::whereNull('parent_id')->get();
        $categories = Category::all();
        $location = [];
        $aset = 0;

        return view('adjustment::rfid.index',compact('stock','category','aset','locations','product','categories','location'));
    }


}
