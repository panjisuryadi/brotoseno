<?php


namespace Modules\Adjustment\Http\Controllers\Kroom;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Yajra\DataTables\DataTables;

class AdjustmentController extends Controller {
    

    public function index(){
        abort_if(Gate::denies('access_adjustments'), 403);
        $location = AdjustmentSetting::LOCATION['4'];
        return view('adjustment::kroom.index',compact('location'));
    }

    public function create(){
        abort_if(Gate::denies('create_adjustments'), 403);
        $number = Adjustment::max('id') + 1;
        $reference = make_reference_id('ADJ', $number);
        $setting = AdjustmentSetting::first();
        $active_location = [
            'id' => json_decode($setting->location)[0],
            'label' => AdjustmentSetting::LOCATION[json_decode($setting->location)[0]],
        ];
        return view('adjustment::kroom.create',compact('reference','active_location'));
    }

    public function getdata(){
        $get_data = Adjustment::has('stockKroom')->withCount('products');

        $get_data = $get_data->orderBy('created_at','desc')->get();

        return DataTables::of($get_data)
            ->addColumn('action', function ($data) {
                return view('adjustment::partials.actions', compact('data'));
            })
            ->addColumn('product', function ($data) {
                return $data->products_count.' Product';
            })
            ->addColumn('summary', function ($data) {
                $lebih = 0;
                $kurang = 0;
                $products = $data->products;
                foreach ($products as $product) {
                    if($product->weight_before > $product->weight_after){
                        $kurang += ($product->weight_before - $product->weight_after);
                    }
                    if($product->weight_before < $product->weight_after){
                        $lebih += ($product->weight_after - $product->weight_before);
                    }
                }
                return '<span class="text-success">Barang Lebih '.$lebih.' gram </span><br><span class="text-danger">Barang Kurang '.$kurang.' gram</span>';
            })
            ->rawColumns(['action','summary','product'])
            ->make(true);
    }
}