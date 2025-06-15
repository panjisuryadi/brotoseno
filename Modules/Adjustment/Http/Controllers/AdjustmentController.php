<?php

namespace Modules\Adjustment\Http\Controllers;

use Modules\Adjustment\DataTables\AdjustmentsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\AdjustedProduct;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Locations\Entities\AdjustedLocations;
use Modules\Locations\Entities\Locations;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ProductLocation;
use Modules\Product\Notifications\NotifyQuantityAlert;
use Carbon\Carbon;
use Modules\Adjustment\Entities\AdjustmentLocation;
use Yajra\DataTables\DataTables;
use PDF;

class AdjustmentController extends Controller
{

    public function index() {
        //abort_if(Gate::denies('access_adjustments'), 403);
        $setting = AdjustmentSetting::first();
        $location = '';
        if(empty($setting)){
            $status = 0;
        }else{
            $status = $setting->status;
        }
        
        if($status == 1){
            $id = json_decode($setting->location);
            // $total = ProductLocation::count();
            // $success = ProductLocation::where('last_opname','>',$setting->period)->count();
            // $pending = ProductLocation::where('last_opname','<',$setting->period)->whereIn('location_id',$id)->count();
            // $location = ProductLocation::select('location_id', DB::raw('count(*) as count'))
            // ->groupBy('location_id')
            // ->get();;
            $location = AdjustmentSetting::LOCATION[$id[0]];
        }else{
            $total = 0;
            $success = 0;
            $pending = 0;
            $location = "Lokasi Belum di pilih";
        }
        $latest_location = AdjustmentLocation::latest('created_at')->first()?->descriptive_location_type;
        return view('adjustment::index',compact('status','location','latest_location'));
    }

    public function continue(){
        $setting = AdjustmentSetting::first();
        $id = json_decode($setting->location);
        $route = $this->getAppropriateRoute($id[0]);
        return redirect()->route($route);
    }


    public function create() {
        abort_if(Gate::denies('create_adjustments'), 403);
        $number = Adjustment::max('id') + 1;
        $reference = make_reference_id('ADJ', $number);
        $status = 0;
        $setting = AdjustmentSetting::first();
        $active_location = [
            'id' => json_decode($setting->location)[0],
            'label' => AdjustmentSetting::LOCATION[json_decode($setting->location)[0]],
        ];
        if(isset($setting)){
            $status = $setting->status;
        }
        
        if($status == 1){
            $product = ProductLocation::where('last_opname', '<', $setting->period)
            ->select('location_id', DB::raw('count(*) as count'))
            ->groupBy('location_id')
            ->get();


        }else{
            $product = ProductLocation::select('location_id', DB::raw('count(*) as count'))
            ->groupBy('location_id')
            ->get();
        }
        return view('adjustment::create',compact('reference','product','active_location'));
    }

    public function create2() {
        abort_if(Gate::denies('create_adjustments'), 403);
        $number = Adjustment::max('id') + 1;
        $reference = make_reference_id('ADJ', $number);
        $status = 0;
        $setting = AdjustmentSetting::first();
        if(isset($setting)){
            $status = $setting->status;
        }
        
        if($status == 1){
            $product = ProductLocation::where('last_opname', '<', $setting->period)->whereIn('location_id',json_decode($setting->location))
            ->select('location_id', DB::raw('count(*) as count'))
            ->groupBy('location_id')
            ->get();
        }else{
            $product = ProductLocation::select('location_id', DB::raw('count(*) as count'))
            ->groupBy('location_id')
            ->get();;
        }
        return view('adjustment::create2',compact('reference','product'));
    }


    public function store(Request $request) {
        abort_if(Gate::denies('create_adjustments'), 403);
        // return $request;
        $request->validate([
            'reference'   => 'required|string|max:255',
            'date'        => 'required|date',
            // 'note'        => 'nullable|string|max:1000',
            'product_id' => 'required',
            'quantities'  => 'required',
            // 'sub_location'  => 'required',
            // 'id_location'  => 'required',
            // 'types'       => 'required'
        ]);

        DB::transaction(function () use ($request) {
            $adjustments = Adjustment::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'note' => $request->notes
            ]);
            foreach ($request->product_id as $key => $id) {
                $adjustment = AdjustedProduct::create([
                    'adjustment_id' => $adjustments->id,
                    'product_id'    => $id,
                    'quantity'      => $request->quantities[$key],
                    'id_location'   => $request->location[$key],
                    'note'          => $request->note[$key],
                    'type'          => 'adjust',
                ]);

                //    AdjustedLocations::create([
                //     'adjustment_id' => $adjustment->id,
                //     'product_id'    => $id,
                //     'id_location'    =>$request->id_location,
                //     'sub_location'    =>$request->sub_location,
                //     'quantity'      => $request->quantities[$key]
                // ]);

                

                // $product = Product::findOrFail($id);
                // if ($request->types[$key] == 'add') {
                //     $product->update([
                //         'product_quantity' => $product->product_quantity + $request->quantities[$key]
                //     ]);
                // } elseif ($request->types[$key] == 'sub') {
                //     $product->update([
                //         'product_quantity' => $product->product_quantity - $request->quantities[$key]
                //     ]);
                // }
                
                $prodloc = ProductLocation::where('product_id',$id)->where('location_id',$request->location[$key])->first();
                if($prodloc->stock > $request->quantities[$key]){
                    $qty = $prodloc->stock - $adjustment->quantity;
                    $adjustment->update([
                        // 'note' => 'Barang hilang '.$qty,
                        'stock_data' => $prodloc->stock 
                    ]);
                    $prodloc->stock = $prodloc->stock-$qty;
                }else if($prodloc->stock < $request->quantities[$key]){
                    $qty = $adjustment->quantity -  $prodloc->stock;
                    $adjustment->update([
                        // 'note' => 'Barang lebih '.$qty,
                        'stock_data' => $prodloc->stock 
                    ]);
                    $prodloc->stock = $prodloc->stock+$qty;
                }else{
                    $adjustment->update([
                        // 'note' => 'Barang lebih '.$qty,
                        'stock_data' => $prodloc->stock 
                    ]);
                }
                $prodloc->last_opname = Carbon::now();
                $prodloc->save();
                $product = Product::find($id)->update([
                    'product_quantity' => ProductLocation::where('product_id',$id)->sum('stock')
                ]);
            }

            $status = AdjustmentSetting::first();
            $count = ProductLocation::where('last_opname','<',$status->period)->whereIn('location_id',json_decode($status->location))->count();
            if($count == 0){
                $status->status = 0;
                $status->save();
            }
        });

        toast('Adjustment Created!', 'success');

        return redirect()->route('adjustments.index');
    }


    public function show(Adjustment $adjustment) {
        abort_if(Gate::denies('show_adjustments'), 403);
        $adjustment->load('cabang', 'adjustedProducts.product');
        if(!empty($adjustment->cabang_id)){
            $view = 'adjustment::cabang.show';
        }else{
            $view = match($adjustment->location->location_type){
                "Modules\Stok\Models\StockOffice" => 'adjustment::gudang-office.show',
                "Modules\Stok\Models\StockSales" => 'adjustment::sales.show',
                "Modules\Stok\Models\StockPendingOffice" => 'adjustment::pending-office.show',
                "Modules\Stok\Models\StockKroom" => 'adjustment::kroom.show',
                "Modules\Stok\Models\StokDp" => 'adjustment::dp.show'
            };

        }
        return view($view, compact('adjustment'));
    }


    public function edit(Adjustment $adjustment) {
        abort_if(Gate::denies('edit_adjustments'), 403);

        return view('adjustment::edit', compact('adjustment'));
    }


    public function update(Request $request, Adjustment $adjustment) {
        abort_if(Gate::denies('edit_adjustments'), 403);

        $request->validate([
            'reference'   => 'required|string|max:255',
            'date'        => 'required|date',
            'note'        => 'nullable|string|max:1000',
            'product_ids' => 'required',
            'quantities'  => 'required',
            'types'       => 'required'
        ]);

        DB::transaction(function () use ($request, $adjustment) {
            $adjustment->update([
                'reference' => $request->reference,
                'date'      => $request->date,
                'note'      => $request->note
            ]);

            foreach ($adjustment->adjustedProducts as $adjustedProduct) {
                $product = Product::findOrFail($adjustedProduct->product->id);

                if ($adjustedProduct->type == 'add') {
                    $product->update([
                        'product_quantity' => $product->product_quantity - $adjustedProduct->quantity
                    ]);
                } elseif ($adjustedProduct->type == 'sub') {
                    $product->update([
                        'product_quantity' => $product->product_quantity + $adjustedProduct->quantity
                    ]);
                }

                $adjustedProduct->delete();
            }

            foreach ($request->product_ids as $key => $id) {
                AdjustedProduct::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id'    => $id,
                    'quantity'      => $request->quantities[$key],
                    'type'          => $request->types[$key]
                ]);

                $product = Product::findOrFail($id);

                if ($request->types[$key] == 'add') {
                    $product->update([
                        'product_quantity' => $product->product_quantity + $request->quantities[$key]
                    ]);
                } elseif ($request->types[$key] == 'sub') {
                    $product->update([
                        'product_quantity' => $product->product_quantity - $request->quantities[$key]
                    ]);
                }
            }
        });

        toast('Adjustment Updated!', 'info');

        return redirect()->route('adjustments.index');
    }


    public function destroy(Adjustment $adjustment) {
        abort_if(Gate::denies('delete_adjustments'), 403);

        $adjustment->delete();

        toast('Adjustment Deleted!', 'warning');

        return redirect()->route('adjustments.index');
    }

    public function getsetting(Request $request){
        $setting = AdjustmentSetting::first();
        $html = '';
        if(empty($setting)){
            $status = 0;
        }else{
            $status = $setting->status;
        }

        if($status == 0){
            $html = 'Tidak Ada Data';
        }else{
            if($request->status == 1){
                $data = ProductLocation::where('last_opname','>',$setting->period)->get();
                $html = '<h3><b>Stok Opname Selesai</b></h3> <br>';
            }else{
                $data = ProductLocation::where('last_opname','<',$setting->period)->get();
                $html = '<h3><b>Stok Opname Belum Selesai</b></h3> <br>';
            }
            $html .= '<table class="table" width="100%">';
            $html .= '<tr>';
            $html .= '<th>Nama Produk</th>';
            $html .= '<th>Jenis Kain</th>';
            $html .= '<th>Location</th>';
            $html .= '</tr>';
            foreach ($data as $data) {
                $html .= '<tr>';
                $html .= '<td>'.$data->product->product_name.' '.$data->product->product_code.'</td>';
                $html .= '<td>'.$data->product->category->category_name.'</td>';
                $html .= '<td>'.$data->location->name.'</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }
        return response()->json($html);
    }
    
    public function setsetting(Request $request){
        // $id = explode(',',$request->value);
        $active_adjustment = $request->value;
        // return response()->json($id);
        // $status = AdjustmentSetting::first();
        // if(empty($status)){
        //     $status = new AdjustmentSetting;
        // }
        // $status->location = json_encode([$active_adjustment]);
        // $status->status = 1;
        // $status->period = Carbon::now();
        // $status->save();

        $cabang = null;
        if(auth()->user()->isUserCabang()){
            $cabang = auth()->user()->namacabang()->id;
        }
        AdjustmentSetting::updateOrCreate(
            [
                'location' => json_encode([$active_adjustment]), 
                'cabang_id' => $cabang,
                'created_by' => auth()->user()->id
            ],
            [
                'status' => 1, 
                'period' => Carbon::now()
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Adjustment Dijalankan',
            'redirectRoute' => route($this->getAppropriateRoute($active_adjustment))
        ]);
    }

    private function getAppropriateRoute($active_adjustment) : string {
        return match($active_adjustment){
            '1' => 'adjustment.gudang.office.index',
            '2' => 'adjustment.sales.index',
            '3' => 'adjustment.pending.office.index',
            '4' => 'adjustment.kroom.index',
            '5' => 'adjustment.dp.index',
            '6' => 'adjustment.pending.cabang.index',
            '7' => 'adjustment.cabang.index',
        };
    }

    public function getdata(Request $request){
        $get_data = Adjustment::withCount('products', 'adjustedProducts')->with('cabang', 'adjustedProducts')->whereNotNull('id');

        $get_data = $get_data->orderBy('date','desc')->get();

        return Datatables::of($get_data)
            ->addColumn('action', function ($data) {
                return view('adjustment::partials.actions', compact('data'));
            })
            ->addColumn('locations', function ($data) {
                $location = $data->location?->descriptive_location_type;
                if(!empty($data->cabang->name)) {
                    $location = $data->cabang->name;
                }
                return $location;
            })
            ->addColumn('product', function ($data) {
                $product_count = $data->products_count;
                if(!empty($data->adjusted_products_count)) {
                    $product_count = $data->adjusted_products_count;
                }
                return $product_count.' Products';
            })
            ->addColumn('summary', function ($data) {
                $lebih = 0;
                $kurang = 0;
                $berhasil = 0;
                $products = $data->products;
                if(empty($data->adjustedProducts) && !empty($data->products)){
                    foreach ($data->products as $product) {
                        if($product->weight_before > $product->weight_after){
                            $kurang += ($product->weight_before - $product->weight_after);
                        }
                        if($product->weight_before < $product->weight_after){
                            $lebih += ($product->weight_after - $product->weight_before);
                        }
                    }
                    return '<span class="text-success">Barang Lebih '.$lebih.' gram </span><br><span class="text-danger">Barang Kurang '.$kurang.' gram</span>';
                }elseif(!empty($data->adjustedProducts)){
                    foreach ($data->adjustedProducts as $product) {
                        if($product->status == 2) {
                            $kurang += 1;
                        }else{
                            $berhasil += 1;
                        }
                    }
                    return '<span class="text-success">Barang berhasil distokopname ' . $berhasil . ' pcs  </span><br><span class="text-danger">Barang Kurang '.$kurang.' pcs</span>';
                }
            })
            ->rawColumns(['action','summary','product','locations'])
            ->make(true);
   }

    public function print($id){

        $adjustment = Adjustment::with('adjustedProducts.product', 'cabang')->find($id);
        $category = Category::all();
        $view = 'adjustment::print';
        if(!empty($adjustment->cabang_id)) {
            $view = 'adjustment::print-product';
        }
        $pdf = PDF::loadview($view,compact('adjustment','category'))
                ->setPaper('a4');
        return $pdf->stream();
   }

    public function getbyqr(Request $request){
            $code = explode('/', $request->code);
            $id = base64_decode($code[0]);
            // return $request;
            $product = Product::find($id);
            $setting = AdjustmentSetting::first();
            $stock = ProductLocation::where('product_id',$id)->where('location_id',$request->location_id)->first();
            if(empty($stock)){
                if(empty($product)){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data Tidak Ditemukan'
                    ]);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Produk '.$product->product_name.' tidak ditemukan pada lokasi '.Locations::find($request->location_id)->name
                    ]);
                }
            }
            if($stock->last_opname > $setting->period){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produk '.$product->product_name.' pada lokasi '.Locations::find($request->location_id)->name .' Sudah di stock opname'
                ]);
            }
            return response()->json([
                'status' => 'success',
                'name' => $stock->product->product_name . ' | ' . $stock->product->product_code .' | '.$stock->product->meter,
                'location' => $stock->location->name,
                'location_id' => $stock->location_id,
                'type' => $stock->product->category->category_name,
                'stock' => $stock->stock,
                'id' => $stock->id,
                'product_id' => $stock->product_id,
            ]);
    }

    public function getsetting2(){
        $status = 0;
        $setting = AdjustmentSetting::first();
        if($setting){
            $status = $setting->status;
        }

        return response()->json($status);
    }
}
