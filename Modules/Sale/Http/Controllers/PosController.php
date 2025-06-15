<?php

namespace Modules\Sale\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;
use Modules\Sale\Http\Requests\StorePosSaleRequest;
use Auth;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Product\Models\ProductStatus;

class PosController extends Controller
{


    public function index() {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        Cart::instance('sale')->destroy();

        $customers = Customer::all();
        $product_categories = Category::all();

        return view('sale::pos.index', compact('product_categories', 'customers'));
    }



 

 public function store(Request $request) {
    if(AdjustmentSetting::exists()){
        toast('Stock Opname sedang Aktif!', 'error');
        return redirect()->back();
    }

      $input = $request->all();
      $input = $request->except('_token');

        if ($input['tipebayar'] == 'cicil') {
            $tipebayar = 'cicilan';
            $payment_status = 'partial';
            //$bayar = preg_replace("/[^0-9]/", "", $input['cicilan']);
            $bayar = $input['harga_awal'];
            $jatuh_tempo =  $input['tgl_jatuh_tempo'];
            $total_amount = $input['harga_awal'];

        } else {
        $tipebayar = 'tunai';
        $bayar = preg_replace("/[^0-9]/", "", $input['tunai'] ?? $input['harga_awal']);
        $payment_status = 'Paid';
        $jatuh_tempo = null;
        $total_amount = $input['final_unmask'];
        }

         // dd($input);
          //$input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
         $sale = Sale::create([
                'date' => date('Y-m-d'),
                'reference' => 'jsr',
                'customer_id' =>$input['customer_id'],
                'customer_name' => Customer::find($request->customer_id)?->customer_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $bayar ?? '0',
                'total_amount' => $total_amount,
                'due_amount' => '0',
                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' =>$input['payment_method'] ?? $tipebayar,
                'tipe_bayar' =>$tipebayar ?? null,
                'cicilan' =>$cicilan ?? null,
                'tgl_jatuh_tempo' =>$jatuh_tempo,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' =>  $input['diskon2'] ?? '0',
                'user_id' => Auth::user()->id,
                'cabang_id' =>$input['cabang_id'] ?? null,
                ]);

  
             foreach (Cart::instance('sale')->content() as $cart_item) {
                $detail = SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->options->harga_jual,
                    'unit_price' => 1,
                    'product_discount_amount' => 0,
                    'product_tax_amount' => 0,
                
                ]);
                $detail->product->updateTracking(ProductStatus::SOLD, $sale->cabang_id);
            }

          Cart::instance('sale')->destroy();
           if ($request->manual > 0) {
                SaleManual::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$sale->reference,
                    'nominal' => $request->manual_price,
                    'sale_id' => $sale->id,
                    'note' => $request->manual_item
                ]);
            }
             session()->forget('keterangan_manual');
             session()->forget('nominal_manual');
             session()->forget('manual');
             toast('POS Sale Created!', 'success');
             return redirect()->route('sales.index');



}


    public function store_old(StorePosSaleRequest $request) {
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale = Sale::create([
                'date' => now()->format('Y-m-d'),
                'reference' => 'PSL',
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::find($request->customer_id)?->customer_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,
                'user_id' => Auth::user()->id,
                'cabang_id' => Auth::user()->namacabang()->id,
            ]);

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'karat_id' => $cart_item->options->karat_id,
                    'price' => $cart_item->options->harga_karat * 100,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);
                $product = Product::findOrFail($cart_item->id);
                // $product->update([
                //     'product_quantity' => $product->product_quantity - $cart_item->qty
                // ]); 

                $product->update([
                    'status' => 1 ?? 0
                ]);
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {
                SalePayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$sale->reference,
                    'amount' => $sale->paid_amount,
                    'sale_id' => $sale->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('POS Sale Created!', 'success');

        return redirect()->route('sales.index');
    }









}
