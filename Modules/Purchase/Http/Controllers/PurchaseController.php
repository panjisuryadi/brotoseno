<?php

namespace Modules\Purchase\Http\Controllers;
use Carbon\Carbon;
use Modules\Purchase\DataTables\PurchaseDataTable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Purchase\Models\HistoryPurchases;
use Modules\People\Entities\Supplier;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Entities\ProductLocation;
use Modules\Locations\Entities\Locations;
use Modules\Product\Entities\TrackingProduct;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchaseDetail;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\Purchase\Http\Requests\StorePurchaseRequest;
use Modules\Purchase\Http\Requests\UpdatePurchaseRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{

      public function __construct()
    {
        // Page Title
        $this->module_title = 'Data Purchase';
        $this->module_name = 'purchase';
        $this->module_path = 'purchase';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Purchase\Entities\Purchase";

    }




  public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
        return view(''.$module_path.'::index',
                                compact('module_name',
                                        'module_action',
                                        'module_title',
                                        'module_path',
                                        'module_icon', 'module_model'));



    }



    public function index_datatable(PurchaseDataTable $dataTable) {

        abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('purchase::index_datatable');
    }


    public function create() {
        abort_if(Gate::denies('create_purchases'), 403);

        $setting = AdjustmentSetting::first();
        if(isset($setting)){
            if($setting->status == 1){
                toast('Stock Opname Belum Selesai, selesaikan Stock Opname Terlebih Dahulu!', 'error');
                return redirect()->back();
            }
        }
        Cart::instance('purchase')->destroy();

        return view('purchase::create');
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
            $$module_name = $module_model::get();
            $data = $$module_name;

         return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_path.'::partials.aksi',
                                 compact('module_name', 'data', 'module_model'));
                                })
                         ->addColumn('status', function ($data) {
                           $module_name = $this->module_name;
                                    return view(''.$module_name.'::partials.status',
                                 compact('module_name', 'data'));
                                })


                          ->addColumn('payment_status', function ($data) {
                           $module_name = $this->module_name;
                                    return view(''.$module_name.'::partials.payment-status',
                                 compact('module_name', 'data'));
                                })

                        ->addColumn('buyer', function ($data) {
                           $module_name = $this->module_name;
                                    return view(''.$module_name.'::partials.buyer',
                                 compact('module_name', 'data'));
                                })


                          ->editColumn('reference', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-500">
                                     ' .@$data->purchaseDetails->first()->product_name . '</h3>
                                    </div>';
                                return $tb;
                            })
                             ->editColumn('total_amount', function ($data) {
                               $tb = '<div class="items-center text-center text-xs text-gray-800"> ' .format_currency($data->total_amount) . ' </div>';
                                return $tb;
                            })

                             ->editColumn('paid_amount', function ($data) {
                               $tb = '<div class="items-center text-center text-xs text-gray-800"> ' .format_currency($data->paid_amount) . ' </div>';
                                return $tb;
                            })
                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['status', 'action',
                            'buyer',
                            'total_amount',
                            'payment_status',
                            'paid_amount',
                             'reference'])
                        ->make(true);
                     }







public function History(Request $request)

    {
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'List';
            $$module_name = HistoryPurchases::latest()->get();
            $data = $$module_name;

            return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_path.'::partials.aksi_history',
                                 compact('module_name', 'data', 'module_model'));
                                })

                          ->editColumn('username', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <span class="text-xs font-medium text-gray-800">
                                     ' .$data->username . '</span>
                                    </div>';
                                return $tb;
                            })

                             ->editColumn('produk', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <span class="text-xs font-medium text-gray-800">
                                     ' .$data->product->product_name . '</span>
                                    </div>';
                                return $tb;
                            })

                              ->editColumn('qty', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->qty . '
                                    </div>';
                                return $tb;
                            })

                          ->editColumn('reference', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->purchase->reference . '
                                    </div>';
                                return $tb;
                            })

                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;
                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['status', 'action',
                            'username',
                            'created_at',
                            'reference',
                            'qty',
                            'updated_at',
                             'produk'])
                         ->make(true);
                     }









public function index_data_type(Request $request)

    {

            $type = $request->type;
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'List';

            if ($type == 'customer') {
                $$module_name = $module_model::whereNull('supplier_id')->get();
            }else if ($type == 'supplier'){
                $$module_name = $module_model::whereNull('customer_id')->get();
            }else{
                 $$module_name = $module_model::get();
            }

            $data = $$module_name;

         return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_path.'::partials.aksi',
                                 compact('module_name', 'data', 'module_model'));
                                })
                         ->addColumn('status', function ($data) {
                           $module_name = $this->module_name;
                                    return view(''.$module_name.'::partials.status',
                                 compact('module_name', 'data'));
                                })
                          ->addColumn('payment_status', function ($data) {
                           $module_name = $this->module_name;
                                    return view(''.$module_name.'::partials.payment-status',
                                 compact('module_name', 'data'));
                                })

                        ->addColumn('buyer', function ($data) {
                           $module_name = $this->module_name;
                                    return view(''.$module_name.'::partials.buyer',
                                 compact('module_name', 'data'));
                                })


                          ->editColumn('name', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->reference . '</h3>
                                    </div>';
                                return $tb;
                            })
                             ->editColumn('total_amount', function ($data) {
                               $tb = '<div class="items-center text-center text-xs text-gray-800"> ' .format_currency($data->total_amount) . ' </div>';
                                return $tb;
                            })

                             ->editColumn('paid_amount', function ($data) {
                               $tb = '<div class="items-center text-center text-xs text-gray-800"> ' .format_currency($data->paid_amount) . ' </div>';
                                return $tb;
                            })
                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['status', 'action',
                            'buyer',
                            'total_amount',
                            'payment_status',
                            'paid_amount',
                             'reference'])
                        ->make(true);
                     }



        public function add()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_path.'::modal.create',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }



          public function type(Request $request) {
                $type = $request->type;
                //dd($type);
                abort_if(Gate::denies('create_purchases'), 403);
                Cart::instance('purchase')->destroy();
                    if ($type == 'NonMember') {
                     return view('purchase::type.member');
                    }
                     elseif ($type == 'toko') {
                     return view('purchase::type.toko');
                    }
                    else {
                        return view('purchase::create');
                    }

            }





    public function savetransferProduct(StorePurchaseRequest $request) {

        $params = $request->all();
        //dd($params);

        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

          if ($request->supplier == 1) {
              $supplier_name = $request->supplier_id;

              } else {
               $none_supplier  = $request->none_supplier;
               $supplier_email = randomEmail($none_supplier);
               $phone = $this->randomPhone();
               $supplier_new =  Supplier::create([
                            'supplier_name'  => $none_supplier,
                            'supplier_phone' => $phone,
                            'supplier_email' => $supplier_email,
                            'city'           => 'Jakarta',
                            'country'        => 'Indonesia',
                            'address'        => 'Jln. Jakarta no 123'
                        ]);
                $supplier_name = $supplier_new->id;
                // dd($supplier_name);

           }
         $sp = Supplier::findOrFail($supplier_name)->supplier_name;
        // dd($sp);
        $purchase = Purchase::create([
                'date' => $request->date,
                'kode_sales' => $request->kode_sales,
                'supplier_id' => $supplier_name,
                'supplier_name' => $sp,
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
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {

                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' =>  $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity'      => $cart_item->qty,
                    'price'         => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                    'location_id' => $request->location_id,
                ]);


                 $locationname = Locations::where('id',$request->location_id)->first();
                  //add history purchases
                 HistoryPurchases::create([
                                'purchase_id' => $purchase->id,
                                'product_id'  => $cart_item->id,
                                'qty'         =>   $cart_item->qty,
                                'username'    =>   auth()->user()->name,
                                'user_id'     =>   auth()->user()->id,
                                'status'      =>   2,
                            ]);
                   //Tracking Produk ke 2
                   TrackingProduct::create([
                    'location_id' =>  $request->location_id,
                    'product_id'  =>  $cart_item->id,
                    'username'    =>  auth()->user()->name,
                    'user_id'     =>  auth()->user()->id,
                    'status'      =>   2,
                    'note'  =>  'Memindahkan Barang Ke Lokasi '.$locationname->name.' dibuat oleh '.auth()->user()->name.' ',
                  ]);


                if ($purchase->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                    $product->update([
                        'product_quantity' => $product->product_quantity + $cart_item->qty,
                        'status' => 2
                    ]);

                  //Update lokasi Baki
                  $produkItem = ProductItem::where('product_id',$cart_item->id)->first();
                  $produkItem->update([
                        'baki_id' => $request->baki_id
                    ]);


                  //dd('purchase');
                  $prodloc = ProductLocation::where('product_id',$cart_item->id)->where('location_id',$request->location_id)->first();

                    if(empty($prodloc)){
                        $prodloc = new ProductLocation;
                        $prodloc->product_id = $cart_item->id;
                        $prodloc->location_id = $request->location_id;
                        $prodloc->stock = $cart_item->qty;
                        $prodloc->save();
                        //add TrackingProduct

                    }else{
                        $prodloc->stock = $prodloc->stock + $cart_item->qty;
                        $prodloc->save();
                    }

                }
            }

            Cart::instance('purchase')->destroy();
            if ($purchase->paid_amount > 0) {
                PurchasePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/'.$purchase->reference,
                    'amount' => $purchase->paid_amount,
                    'purchase_id' => $purchase->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Product Transfer Created!', 'success');
        //return redirect()->back();
        return redirect()->route('product-transfer.index');
    }



 public function savetransferCustomer(StorePurchaseRequest $request) {

        $params = $request->all();
      //  dd($params);
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

          if ($request->customer == 1) {
              $customer_name = $request->customer_id;
              } else {
               $none_customer  = $request->none_customer;
               $customer_email = randomEmail($none_customer);
               $phone = $this->randomPhone();
               $customer_new =  customer::create([
                            'customer_name'  => $none_customer,
                            'customer_phone' => $phone,
                            'customer_email' => $customer_email,
                            'city'           => 'Jakarta',
                            'country'        => 'Indonesia',
                            'address'        => 'Jln. Jakarta no 123'
                        ]);

                $customer_name = $customer_new->id;

           }

        $purchase = Purchase::create([
                'date' => $request->date,
                'kode_sales' => $request->kode_sales,
                'supplier_id' => null,
                'supplier_name' => 'none',
                'customer_id' => $customer_name,
                'customer_name' => Customer::findOrFail($customer_name)->customer_name,
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
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {
                 // dd('purchase');
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
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
                    'location_id' => $request->location_id,
                ]);


               $locationname = Locations::where('id',$request->location_id)->first();

                  //add history purchases
                 HistoryPurchases::create([
                                'purchase_id' => $purchase->id,
                                'product_id'  => $cart_item->id,
                                'qty'         =>   $cart_item->qty,
                                'username'    =>   auth()->user()->name,
                                'user_id'     =>   auth()->user()->id,
                                'status'      =>   1,
                            ]);
                   //Tracking Produk ke 2
                   TrackingProduct::create([
                    'location_id' =>  $request->location_id,
                    'product_id'  =>  $cart_item->id,
                    'username'    =>  auth()->user()->name,
                    'user_id'     =>  auth()->user()->id,
                    'status'      =>   1,
                    'note'  =>  'Memindahkan Barang Ke Lokasi '.$locationname->name.' dibuat oleh '.auth()->user()->name.' ',
                  ]);



                if ($purchase->status == 'Completed') {

                    $product = Product::findOrFail($cart_item->id);
                 //dd($purchase->status);
                    $product->update([
                        'product_quantity' => $product->product_quantity + $cart_item->qty
                    ]);


                   //Update lokasi Baki
                  $produkItem = ProductItem::where('product_id',$cart_item->id)->first();
                  $produkItem->update([
                        'baki_id' => $request->baki_id
                    ]);
                    $prodloc = ProductLocation::where('product_id',$cart_item->id)->where('location_id',$request->location_id)->first();
                    $customer_name = Customer::findOrFail($customer_name)->customer_name;

                    if(empty($prodloc)){

                        dd('product');
                        $prodloc = new ProductLocation;
                        $prodloc->product_id = $cart_item->id;
                        $prodloc->location_id = $request->location_id;
                        $prodloc->stock = $cart_item->qty;
                        $prodloc->save();

                    }else{
                        $prodloc->stock = $prodloc->stock + $cart_item->qty;
                        $prodloc->save();
                    }
                 //Tracking Produk
                   TrackingProduct::create([
                    'location_id' =>  $request->location_id,
                    'product_id'  =>  $cart_item->id,
                    'username'    =>  auth()->user()->name,
                    'user_id'     =>  auth()->user()->id,
                    'status'      =>   0,
                    'note'  =>  'Purchase Baru dari Customer '.$customer_name.' diterima oleh '.auth()->user()->name.' ',
                  ]);

                }
            }

            Cart::instance('purchase')->destroy();
            if ($purchase->paid_amount > 0) {
                PurchasePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/'.$purchase->reference,
                    'amount' => $purchase->paid_amount,
                    'purchase_id' => $purchase->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

  activity()->log(' '.auth()->user()
    ->name.' input pembelian INV/'.$purchase->reference.'   ');

        toast('Product Transfer Created!', 'success');
        return redirect()->route('product-transfer.index');
    }







    public function store(StorePurchaseRequest $request) {

        $params = $request->all();
        //dd($params);
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

          if ($request->supplier == 1) {
              $supplier_name = $request->supplier_id;
              } else {
               $none_supplier  = $request->none_supplier;
               $supplier_email = randomEmail($none_supplier);
               $phone = $this->randomPhone();
               $supplier_new =  Supplier::create([
                            'supplier_name'  => $none_supplier,
                            'supplier_phone' => $phone,
                            'supplier_email' => $supplier_email,
                            'city'           => 'Jakarta',
                            'country'        => 'Indonesia',
                            'address'        => 'Jln. Jakarta no 123'
                        ]);
                $supplier_name = $supplier_new->id;
                // dd($supplier_name);

           }

          $purchase = Purchase::create([
                'date' => $request->date,
                'kode_sales' => $request->kode_sales,
                'supplier_id' => $supplier_name,
                'supplier_name' => Supplier::findOrFail($supplier_name)->supplier_name,
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
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {
                 // dd('purchase');
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
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
                    'location_id' => $request->location_id,
                ]);
                 $nama_supplier = Supplier::findOrFail($supplier_name)->supplier_name;

                  //add history purchases
                 HistoryPurchases::create([
                                'purchase_id' => $purchase->id,
                                'product_id'  => $cart_item->id,
                                'qty'         =>   $cart_item->qty,
                                'username'    =>   auth()->user()->name,
                                'user_id'     =>   auth()->user()->id,
                                'status'      =>   1,
                            ]);
                   //Tracking Produk
                   TrackingProduct::create([
                    'location_id' =>  $request->location_id,
                    'product_id'  =>  $cart_item->id,
                    'username'    =>  auth()->user()->name,
                    'user_id'     =>  auth()->user()->id,
                    'status'      =>   0,
                    'note'  =>  'Purchase Baru dari Toko '.$nama_supplier.' diterima oleh '.auth()->user()->name.' ',
                  ]);



                if ($request->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                   // dd('product');
                    $product->update([
                        'product_quantity' => $product->product_quantity + $cart_item->qty
                    ]);

                    $prodloc = ProductLocation::where('product_id',$cart_item->id)->where('location_id',$request->location_id)->first();


                    if(empty($prodloc)){
                        $prodloc = new ProductLocation;
                        $prodloc->product_id = $cart_item->id;
                        $prodloc->location_id = $request->location_id;
                        $prodloc->stock = $cart_item->qty;
                        $prodloc->save();
                    }else{
                        $prodloc->stock = $prodloc->stock + $cart_item->qty;
                        $prodloc->save();
                    }

                }
            }

            Cart::instance('purchase')->destroy();
        if ($purchase->paid_amount > 0) {
                PurchasePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/'.$purchase->reference,
                    'amount' => $purchase->paid_amount,
                    'purchase_id' => $purchase->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Purchase Created!', 'success');
        return redirect()->route('purchases.index');
    }




    public function saveTypeCustomer(StorePurchaseRequest $request) {

        $params = $request->all();
      // dd($params);
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

          if ($request->customer == 1) {
              $customer_name = $request->customer_id;
              } else {
               $none_customer  = $request->none_customer;
               $customer_email = randomEmail($none_customer);
               $phone = $this->randomPhone();
               $customer_new =  customer::create([
                            'customer_name'  => $none_customer,
                            'customer_phone' => $phone,
                            'customer_email' => $customer_email,
                            'city'           => 'Jakarta',
                            'country'        => 'Indonesia',
                            'address'        => 'Jln. Jakarta no 123'
                        ]);

                $customer_name = $customer_new->id;
                //dd($customer_name);

           }

        $purchase = Purchase::create([
                'date' => $request->date,
                'supplier_id' => null,
                'supplier_name' => 'none',
                'customer_id' => $customer_name,
                'customer_name' => Customer::findOrFail($customer_name)->customer_name,
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
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {

                 // dd('purchase');
                //dd($params);
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
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
                    'location_id' => $request->location_id,
                ]);
                //add history purchases
                 HistoryPurchases::create([
                                'purchase_id' => $purchase->id,
                                'product_id'  => $cart_item->id,
                                'qty'         =>   $cart_item->qty,
                                'username'    =>   auth()->user()->name,
                                'user_id'     =>   auth()->user()->id,
                                'status'      =>   1,
                            ]);


                if ($request->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                    // dd('product');
                    $product->update([
                        'product_quantity' => $product->product_quantity + $cart_item->qty
                    ]);

                    $prodloc = ProductLocation::where('product_id',$cart_item->id)->where('location_id',$request->location_id)->first();

                    if(empty($prodloc)){
                        $prodloc = new ProductLocation;
                        $prodloc->product_id = $cart_item->id;
                        $prodloc->location_id = $request->location_id;
                        $prodloc->stock = $cart_item->qty;
                        $prodloc->save();
                    }else{
                        $prodloc->stock = $prodloc->stock + $cart_item->qty;
                        $prodloc->save();
                    }

                }
            }

            Cart::instance('purchase')->destroy();

            if ($purchase->paid_amount > 0) {
                PurchasePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/'.$purchase->reference,
                    'amount' => $purchase->paid_amount,
                    'purchase_id' => $purchase->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('Purchase Created!', 'success');

        return redirect()->route('purchases.index');
    }








    public function show(Purchase $purchase) {
        abort_if(Gate::denies('show_purchases'), 403);

        $supplier = Supplier::findOrFail($purchase->supplier_id);

        return view('purchase::show', compact('purchase', 'supplier'));
    }


    public function edit(Purchase $purchase) {
        abort_if(Gate::denies('edit_purchases'), 403);

        $purchase_details = $purchase->purchaseDetails;

        Cart::instance('purchase')->destroy();

        $cart = Cart::instance('purchase');

        foreach ($purchase_details as $purchase_detail) {
            $cart->add([
                'id'      => $purchase_detail->product_id,
                'name'    => $purchase_detail->product_name,
                'qty'     => $purchase_detail->quantity,
                'price'   => $purchase_detail->price,
                'weight'  => 1,
                'options' => [
                    'product_discount' => $purchase_detail->product_discount_amount,
                    'product_discount_type' => $purchase_detail->product_discount_type,
                    'sub_total'   => $purchase_detail->sub_total,
                    'code'        => $purchase_detail->product_code,
                    'stock'       => Product::findOrFail($purchase_detail->product_id)->product_quantity,
                    'product_tax' => $purchase_detail->product_tax_amount,
                    'unit_price'  => $purchase_detail->unit_price
                ]
            ]);
        }

        return view('purchase::edit', compact('purchase'));
    }


    public function update(UpdatePurchaseRequest $request, Purchase $purchase) {
        DB::transaction(function () use ($request, $purchase) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            foreach ($purchase->purchaseDetails as $purchase_detail) {
                if ($purchase->status == 'Completed') {
                    $product = Product::findOrFail($purchase_detail->product_id);
                    $product->update([
                        'product_quantity' => $product->product_quantity - $purchase_detail->quantity
                    ]);
                }
                $purchase_detail->delete();
            }

            $purchase->update([
                'date' => $request->date,
                'reference' => $request->reference,
                'supplier_id' => $request->supplier_id,
                'supplier_name' => Supplier::findOrFail($request->supplier_id)->supplier_name,
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
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
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

                if ($request->status == 'Completed') {
                    $product = Product::findOrFail($cart_item->id);
                    $product->update([
                        'product_quantity' => $product->product_quantity + $cart_item->qty
                    ]);
                }
            }

            Cart::instance('purchase')->destroy();
        });

        toast('Purchase Updated!', 'info');

        return redirect()->route('purchases.index');
    }


    public function destroy(Purchase $purchase) {
        abort_if(Gate::denies('delete_purchases'), 403);

        $detail = Purchase::where('id',$purchase->id)->first();
        $detail->delete();

        // $detail = PurchaseDetail::where('purchase_id',$purchase->id)->first();
        // $detail->delete();

        // if(count($detail)){
        //     foreach ($detail as $detail) {
        //         $product = Product::findOrFail($detail->product_id);
        //         $product->update([
        //             'product_quantity' => $product->product_quantity - $detail->quantity
        //         ]);
        //         $prodloc = ProductLocation::where('product_id',$product->id)->where('location_id',$detail->location_id)->first();
        //         dd($prodloc);
        //         $prodloc->stock = $prodloc->stock - $detail->quantity;
        //         $prodloc->save();
        //     }
        // }
        // $purchase->delete();
        toast('Purchase Deleted!', 'warning');

        return redirect()->route('purchases.index');
    }

    public function completepurchase(Request $request){
        $purchase = Purchase::find($request->purchase_id);

        $purchase->status = 'Completed';
        if($purchase->save()){
            $detail = PurchaseDetail::where('purchase_id',$purchase->id)->get();
             //dd($detail);
            if(count($detail)){
                foreach ($detail as $detail) {
                    $product = Product::findOrFail($detail->product_id);
                    $product->update([
                        'product_quantity' => $product->product_quantity + $detail->quantity
                    ]);

                    $prodloc = ProductLocation::where('product_id',$product->id)->where('location_id',$detail->location_id)->first();
                    if(empty($prodloc)){
                        $prodloc = new ProductLocation;
                        $prodloc->product_id = $product->id;
                        $prodloc->location_id = $detail->location_id;
                        $prodloc->stock = $detail->quantity;
                        $prodloc->save();
                    }else{
                        $prodloc->stock = $prodloc->stock + $detail->quantity;
                        $prodloc->save();
                    }
                }
            }
        }


        toast('Purchase '.$purchase->reference.' Completed!', 'info');

        return redirect()->route('purchases.index');
    }



private function randomPhone()
    {
        $countryCode = '+628'; // Change this to the desired country code
        $phone = $countryCode;
      // Generate random digits for the remaining 10 digits (excluding country code)
        for ($i = 0; $i < 10; $i++) {
            $phone .= rand(0, 9);
        }
        return $phone;
    }

















}
