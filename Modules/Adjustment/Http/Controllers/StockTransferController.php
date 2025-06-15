<?php

namespace Modules\Adjustment\Http\Controllers;

use Modules\Adjustment\DataTables\StockTransferDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\StockTransfer;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Adjustment\Entities\StockTransferDetail;
use Modules\Product\Entities\ProductLocation;
use Yajra\DataTables\DataTables;

class StockTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index() {
        abort_if(Gate::denies('access_adjustments'), 403);
        return view('adjustment::transfer.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $setting = AdjustmentSetting::first();
        if(isset($setting)){
            if($setting->status == 1){
                toast('Stock Opname Belum Selesai, selesaikan Stock Opname Terlebih Dahulu!', 'error');
                return redirect()->back();
            }
        }
        $number = StockTransfer::max('id') + 1;
        $reference = make_reference_id('STF', $number);
        $product = ProductLocation::where('stock','>',0)->get();
        return view('adjustment::transfer.create2',compact('reference','product'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // return $request;
        $rules = [
            'stock_sent' => ['required'],
            'stock_value' => ['required'],
            'product_ids' => ['required'],
            'origin' => ['required'],
            'destination' => ['required'],
        ];
        $validate = $request->validate($rules);
        
        $stock_sent = array_sum($request->stock_sent);
        if($stock_sent > $request->stock_value){
            return response()->json([
                'status' => 'error',
                'message' => 'Stok Yang Dikirim Melebihi Stok Tersedia<br>Stok Tersedia :'.$request->stock_value.' Dikirim :'.$stock_sent
            ]);
        }
        try {
            $transfer = new StockTransfer;
            $transfer->date = $request->date;
            $transfer->reference = $request->reference;
            $transfer->note = $request->note;
            if($transfer->save()){
                foreach ($request->product_ids as $key => $id) {
                    $detail = StockTransferDetail::create([
                        'stock_transfer_id' => $transfer->id,
                        'product_id'        => $id,
                        'origin'            => $request->origin,
                        'destination'       => $request->destination[$key],
                        'stock_sent'         => $request->stock_sent[$key],
                        'note'              => $transfer->note,
                    ]);

                    $origin = ProductLocation::where('product_id',$detail->product_id)->where('location_id',$detail->origin)->first();
                    if(isset($origin)){
                        $origin->stock = $origin->stock-$detail->stock_sent;
                        $origin->save();
                    }
                    
                    $destination = ProductLocation::where('product_id',$detail->product_id)->where('location_id',$detail->destination)->first();
                    if(isset($destination)){
                        $destination->stock = $destination->stock+$detail->stock_sent;
                        $destination->save();
                    }else{
                        ProductLocation::create([
                            'product_id' => $detail->product_id,
                            'location_id' => $detail->destination,
                            'stock' => $detail->stock_sent
                        ]);
                    }   
                }
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Stock Transfer Berhasil Ditambahkan'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $transfer = StockTransfer::find($id);
        return view('adjustment::transfer.show',compact('transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('adjustment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function getdata(){
        $get_data = StockTransfer::orderBy('id','desc')->get();
    
        return Datatables::of($get_data)
            ->addColumn('action', function ($data) {
                return '<a class="btn btn-primary btn-sm" href="stocktransfer/show/'.$data->id.'"><i class="bi bi-eye text-white"></i></a>';
            })
            ->addColumn('transferdetail', function ($data) {
                return $data->transferdetail->count().' Item | '.$data->transferdetail->sum('stock_sent').' (Pcs) Ditransfer';
            })
            ->make(true);
    }

    public function getlocation($location_id){
        $view = view('partial.location',compact('location_id'))->render();
        return response()->json($view);
    }
}
