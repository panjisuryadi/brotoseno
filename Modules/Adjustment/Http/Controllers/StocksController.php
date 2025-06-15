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

class StocksController extends Controller
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
        foreach ($asets as $asets) {
            $aset = $aset + ($asets->stock * ($asets->product_cost/100));
        }
        return view('adjustment::stock.index',compact('stock','category','aset','locations','product','categories','location'));
    }

    public function getdata(Request $request){
        $get_data = ProductLocation::join('products','product_locations.product_id','products.id');
        if(isset($request->category_id)){
            $get_data = $get_data->where('category_id',$request->category_id);
        }
        if(isset($request->location_id)){
            $get_data = $get_data->where('location_id',$request->location_id);
        }
        $get_data = $get_data->select('product_locations.*')->get();

        return Datatables::of($get_data)
            ->addColumn('action', function ($row) {
                return '<button onclick="showone('.$row->id.')"  class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></button>';
            })
            ->addColumn('name', function ($row) {
                return $row->product->product_name.' | '.$row->product->product_code.' | '.$row->product->meter;
            })
            ->addColumn('category', function ($row) {
                return $row->product->category->category_name;
            })
            ->addColumn('price', function ($row) {
                return $row->product->category->category_name;
            })
            ->addColumn('stock', function ($row) {
                return $row->stock .' '.$row->product->product_unit;
            })
            ->editColumn('location', function ($data) {
                return $data->location->parent->name.'>>'.$data->location->name;
            })
            ->rawColumns(['action'])
            ->make(true);
   }

   public function getsummary(Request $request){
        $stocks = ProductLocation::join('products','product_locations.product_id','products.id');
        $product = ProductLocation::join('products','product_locations.product_id','products.id');
        $asets  = ProductLocation::join('products','product_locations.product_id','products.id');
        $categories = ProductLocation::join('products','product_locations.product_id','products.id');

        if(isset($request->location_id)){
            $stocks = $stocks->where('location_id',$request->location_id);
            $product = $product->where('location_id',$request->location_id);
            $asets = $asets->where('location_id',$request->location_id);
            $categories = $categories->where('location_id',$request->location_id);
        }
        
        if(isset($request->category_id)){
            $stocks = $stocks->where('category_id',$request->category_id);
            $product = $product->where('category_id',$request->category_id);
            $asets = $asets->where('category_id',$request->category_id);
            $categories = $categories->where('category_id',$request->category_id);
        }

        $stock = $stocks->sum('stock');
        $product = $product->distinct()->count('product_id');
        $aset = 0;
        $asets = $asets->get();
        // return $asets;
        foreach ($asets as $asets) {
            $aset = $aset + (($asets->product_cost/100) * $asets->stock); 
        }
        $category = $categories->distinct()->count('category_id');
        return response()->json([
            'stock' => number_format($stock),
            'product' => number_format($product),
            'aset' => number_format($aset),
            'category' => number_format($category)
        ]);
   }

   public function getone($id){
        $stock = ProductLocation::find($id);
        return response()->json([
            'name' => $stock->product->product_name . ' | ' . $stock->product->product_code .' | '.$stock->product->meter,
            'location' => $stock->location->name,
            'location_id' => $stock->location_id,
            'type' => $stock->product->category->category_name,
            'stock' => $stock->stock,
            'id' => $stock->id,
            'product_id' => $stock->product_id,
        ]);
   }
}
