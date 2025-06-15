<?php


namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Sale\DataTables\SalesDataTable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;
use Modules\Sale\Http\Requests\StoreSaleRequest;
use Modules\Sale\Http\Requests\UpdateSaleRequest;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Modules\Cabang\Models\Cabang;
use Modules\Product\Models\ProductStatus;
use PDF;
use Modules\Sale\Exports\ExportSale;
use Maatwebsite\Excel\Facades\Excel;



class SaleController extends Controller
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
        // Page Title
        $this->module_title = 'Sale';

        // module name
        $this->module_name = 'sales';

        // directory path of the module
        $this->module_path = 'sale';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Sale\Entities\Sale";
        $this->module_detail = "Modules\Sale\Entities\SaleDetails";
        $this->module_payment = "Modules\Sale\Entities\SalePayment";
        $this->module_product = "Modules\Product\Entities\Product";
    }


    public function index(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $type = $request->type ?? '';

        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        $cabangs = Cabang::get();
        abort_if(Gate::denies('access_sales'), 403);
        return view(
            'sale::index',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'type',
                'cabangs',
                'module_icon',
                'module_model'
            )
        );
    }

    public function index_table(SalesDataTable $dataTable)
    {
        abort_if(Gate::denies('access_sales'), 403);
        return $dataTable->render('sale::index');
    }





    public function show_cicilan($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $detail = $module_model::findOrFail($id);
        //dd($detail);
        return view(
            '' . $module_path . '::.modal.show_cicilan',
            compact(
                'module_name',
                'module_action',
                'detail',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }





    public function index_data(Request $request)

    {
        $type = $request->type;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
 
        $$module_name = $module_model::akses();
        if($type) {
            $$module_name->where('payment_method',$type);
            $$module_name->orderBy('created_at', 'desc');
        }else{
            $$module_name->orderBy('created_at', 'desc');
        }
        $$module_name->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_path . '::.partials.actions',
                    compact( 'data')
                );
            })

            ->editColumn('date', function ($data) {
                $tb = '<div class="text-center text-gray-800"> 
                                     ' . shortdate($data->date) . '</div>';
                return $tb;
            })
            ->editColumn('reference', function ($data) {
                $tb = '<div class="text-center text-blue-800"> 
                                     ' . $data->reference . '</div>';
                return $tb;
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center text-blue-800"> 
                                     ' . @$data->cabang->name . '</div>';
                return $tb;
            })

            ->editColumn('customer', function ($data) {
                $tb = '<div class="text-center text-green-800"> 
                                     ' . @$data->customer_name . '</div>';
                return $tb;
            })
            ->editColumn('grand_total_amount', function ($data) {
                $nominal = empty($data->dp_payment) || empty($data->remain_amount) ? $data->grand_total_amount : $data->dp_nominal;
                $tb = '<div class="text-center font-bold"> 
                                        ' . format_uang($nominal) . '</div>';
                return $tb;
            })

            ->addColumn('status', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_path . '::.partials.status',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('cara_bayar', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_path . '::.partials.cara-bayar',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->addColumn('total_amount', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_path . '::.partials.nominal',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->rawColumns([
                'customer',
                'reference',
                'date',
                'sales',
                'cabang',
                'status',
                'grand_total_amount',
                'action',
                'name'
            ])
            ->make(true);
    }




public function export_sale_excel(Request $request)
      {

        $tanggal = date('dmY');
        $type = $request->type;
        $status = $request->get('status') ?? '';
       // $data_sale =  Sale::akses();

        //dd($type);
         if($type == null) {
             $data_sale =  Sale::akses()->orderBy('created_at', 'desc')
             ->get();            
                }else{
                       $data_sale =  Sale::akses()->where('payment_method',$type)
                    ->orderBy('created_at', 'desc')->get();
                   
                }
        $data = $data_sale;
        //dd($data_sale);
        ob_end_clean();
        ob_start();
        $judul = 'Sale';
         return Excel::download(new ExportSale($tanggal,$status,$type,$judul),
            'export-penjualan-'.$judul.'_'.$tanggal.'.xlsx');
          // return view('sale::export_excel',
          //                       compact('tanggal','judul','status','data'));

          }








    public function create()
    {
        abort_if(Gate::denies('create_sales'), 403);

        Cart::instance('sale')->destroy();

        return view('sale::create');
    }




    public function store(StoreSaleRequest $request)
    {
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
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,

            ]);

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);

                if ($request->status == 'Shipped' || $request->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                    $product->update([
                        'product_quantity' => $product->product_quantity - $cart_item->qty
                    ]);
                }
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {
                SalePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/' . $sale->reference,
                    'amount' => $sale->paid_amount,
                    'sale_id' => $sale->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Sale Created!', 'success');

        return redirect()->route('sales.index');
    }




    public function store_ajax(StoreSaleRequest $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        // $validator = \Validator::make($request->all(),[
        //      'name' => 'required|max:191|unique:'.$module_model.',name',
        //      'value' => 'required|max:191',

        // ]);
        // if (!$validator->passes()) {
        //   return response()->json(['error'=>$validator->errors()]);
        // }

        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $input = $request->all();
            $input = $request->except(['document']);
            //dd($input);
            $sale = Sale::create([
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,
            ]);

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);

                if ($request->status == 'Shipped' || $request->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                    $product->update([
                        'product_quantity' => $product->product_quantity - $cart_item->qty
                    ]);
                }
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {
                SalePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/' . $sale->reference,
                    'amount' => $sale->paid_amount,
                    'sale_id' => $sale->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        return response()->json(['success' => 'Sales Sukses disimpan.']);
    }




    public function show(Sale $sale)
    {
        abort_if(Gate::denies('show_sales'), 403);

        $customer = Customer::find($sale->customer_id);

        return view('sale::show', compact('sale', 'customer'));
    }



    public function cetak($id)
    {
        $sale = Sale::findOrFail($id);
        $pdf = PDF::loadView('sale::nota', [
            'sale' => $sale,
        ])->setPaper([20, 10, 300, 400], 'mm');




        return $pdf->stream('sale-' . $sale->reference . '.pdf');
    }


    public function pdf($id)
    {
        $sale = Sale::findOrFail($id);
        $customer = Customer::find($sale->customer_id);
        $pdf = PDF::loadView('sale::print', [
            'sale' => $sale,
            'customer' => $customer,
        ])->setPaper('a4');

        return $pdf->stream('sale-' . $sale->reference . '.pdf');
    }



    public function generateInvoice($id)
    {
        // 210 x 297
        $sale = Sale::findOrFail($id);
        $pdf = PDF::loadView('sale::print_v2', [
            'sale' => $sale,
        ])->setPaper('a4', 'l');

        return $pdf->stream('sale-' . $sale->reference . '.pdf');
    }





    public function edit(Sale $sale)
    {
        abort_if(Gate::denies('edit_sales'), 403);

        $sale_details = $sale->saleDetails;

        Cart::instance('sale')->destroy();

        $cart = Cart::instance('sale');

        foreach ($sale_details as $sale_detail) {
            $cart->add([
                'id'      => $sale_detail->product_id,
                'name'    => $sale_detail->product_name,
                'qty'     => $sale_detail->quantity,
                'price'   => $sale_detail->price,
                'weight'  => 1,
                'options' => [
                    'product_discount' => $sale_detail->product_discount_amount,
                    'product_discount_type' => $sale_detail->product_discount_type,
                    'sub_total'   => $sale_detail->sub_total,
                    'code'        => $sale_detail->product_code,
                    'stock'       => Product::findOrFail($sale_detail->product_id)->product_quantity,
                    'product_tax' => $sale_detail->product_tax_amount,
                    'unit_price'  => $sale_detail->unit_price
                ]
            ]);
        }

        return view('sale::edit', compact('sale'));
    }


    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        DB::transaction(function () use ($request, $sale) {

            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            foreach ($sale->saleDetails as $sale_detail) {
                if ($sale->status == 'Shipped' || $sale->status == 'Completed') {
                    $product = Product::findOrFail($sale_detail->product_id);
                    $product->update([
                        'product_quantity' => $product->product_quantity + $sale_detail->quantity
                    ]);
                }
                $sale_detail->delete();
            }

            $sale->update([
                'date' => $request->date,
                'reference' => $request->reference,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,
            ]);

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);

                if ($request->status == 'Shipped' || $request->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                    $product->update([
                        'product_quantity' => $product->product_quantity - $cart_item->qty
                    ]);
                }
            }

            Cart::instance('sale')->destroy();
        });

        toast('Sale Updated!', 'info');

        return redirect()->route('sales.index');
    }


    public function destroy(Sale $sale)
    {
        abort_if(Gate::denies('delete_sales'), 403);

        $sale->delete();

        toast('Sale Deleted!', 'warning');

        return redirect()->route('sales.index');
    }




    public function generateInvoice_0ljg($id)
    {

        $sale = \Modules\Sale\Entities\Sale::findOrFail($id);

        // $pdf = \PDF::loadView('sale::print', [
        //           'sale' => $sale,

        //       ]);

        //       return $pdf->stream('sale-'. $sale->reference .'.pdf');
        return view('sale::print', compact('sale'));
    }

    public function failed($id)
    {
        try {
            DB::beginTransaction();
            $sale = Sale::with('saleDetails')->find($id);

            if (!empty($sale->saleDetails)) {
                foreach ($sale->saleDetails as $detail) {
                    $detail->product->updateTracking(ProductStatus::READY, $sale->cabang_id);
                }

                $sale->status = 'failed';
                $sale->save();
            }

            toast('Sale Updated!', 'info');
            DB::commit();
            return redirect()->route('sales.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
