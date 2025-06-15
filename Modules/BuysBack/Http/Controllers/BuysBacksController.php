<?php

namespace Modules\BuysBack\Http\Controllers;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\BuysBack\Events\BuysBackCreated;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\BuysBack\Models\BuysBack;
use Modules\BuysBack\Models\BuysBackDetails;
use Modules\People\Entities\Supplier;
use Modules\People\Entities\Customer;
use Modules\Cabang\Models\Cabang;
use Modules\BuysBack\Http\Requests\StoreBuyBackRequest;
use Lang;
use Auth;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\BuysBack\Models\BuyBackNota;
use Modules\Status\Models\ProsesStatus;

class BuysBacksController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Buy Back';
        $this->module_name =  'buysback';
        $this->module_path =  'buysbacks';
        $this->module_icon =  'fas fa-sitemap';
        $this->module_model = "Modules\BuysBack\Models\BuysBack";

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

  public function index() {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_buybacktoko'), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
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
                            return view(''.$module_name.'::'.$module_path.'.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                           ->editColumn('no_buy_back', function ($data) {


                            $is_non_member = is_null($data->customer_id);
                            $customer_name = '';
                            if($is_non_member){
                                $customer_name = $data->customer_name;
                            }else{
                                $customer_name = $data->customer->customer_name;
                            }
                             $tb = '<div class="justify items-left text-left">'; 
                             $tb .= '<div class="text-blue-400">
                                     Nomor :<strong>' . $data->no_buy_back . '
                                    </strong></div>';
                             $tb .= '<div class="text-gray-800">
                                     Cabang :<strong>' . $data->cabang->name . '
                                    </strong></div>'; 
                             $tb .= '<div class="text-gray-800">
                                     Customer :<strong>' . $customer_name . '
                                    </strong></div>';               
                             $tb .= '</div>'; 
                                return $tb;
                              })

                      
                             ->editColumn('nama_produk', function ($data) {
                             $tb = '<div class="justify items-left text-left">'; 
                           
                             $tb .= '<div class="text-gray-800">
                                     Prduk :<strong>' . $data->product_name . '
                                    </strong></div>'; 
                             $tb .= '<div class="text-gray-800">
                                     Karat :<strong>' . $data->karat->label . '
                                    </strong></div>';   

                             $tb .= '<div class="text-gray-800">
                                     Berat :<strong>' . $data->weight . '
                                    </strong></div>';               
                             $tb .= '</div>'; 
                                return $tb;
                              })


                          ->editColumn('kadar', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->karat->label . '
                                       </div>';
                                   return $tb;
                               })
                            ->editColumn('berat', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . $data->weight . '
                                     gram </div>';
                                return $tb;
                            })
                            ->editColumn('nominal_beli', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . format_uang($data->nominal) . '
                                    </div>';
                                return $tb;
                            })

                         ->addColumn('status', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.status',
                            compact('module_name', 'data', 'module_model'));
                                })


                            ->editColumn('cabang', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->cabang->name . '
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
                        ->rawColumns(['action','nama_customer',
                               'no_buy_back',
                               'nama_produk',
                               'kadar',
                               'berat',
                               'status',
                               'nominal_beli',
                               'updated_at','keterangan','cabang'])
                        ->make(true);
                     }

    
                     public function index_buyback_item_data(Request $request)

                     {
                         $module_title = $this->module_title;
                         $module_name = $this->module_name;
                         $module_path = $this->module_path;
                         $module_icon = $this->module_icon;
                         $module_model = $this->module_model;
                         $module_name_singular = Str::singular($module_name);
                 
                         $module_action = 'List';
                         $$module_name = BuyBackItem::pending()->get();
                         return Datatables::of($$module_name)
                                         ->addColumn('action', function ($data) {
                                             $module_name = $this->module_name;
                                             $module_model = $this->module_model;
                                             $module_path = $this->module_path;
                                             return view(''.$module_name.'::'.$module_path.'.aksi',
                                             compact('module_name', 'data', 'module_model'));
                                                 })
                 
                                              ->editColumn('barang', function ($data) {
                                              $tb = '<div class="justify items-left text-left">'; 
                                            
                                              $tb .= '<div class="text-gray-800">
                                                      Nama Produk : <strong>' . $data->product->product_name . '
                                                     </strong></div>'; 
                                              $tb .= '<div class="text-gray-800">
                                                      Karat : <strong>' . $data->karat->label . '
                                                     </strong></div>';   
                 
                                              $tb .= '<div class="text-gray-800">
                                                      Berat : <strong>' . $data->weight . '
                                                      gr</strong></div>';               
                                              $tb .= '</div>'; 
                                                 return $tb;
                                               })
                 
                 
                                           ->editColumn('customer', function ($data) {
                                                 $tb = '<div class="font-semibold items-center text-center">
                                                         ' . $data->customer->customer_name . '
                                                        </div>';
                                                    return $tb;
                                                })
                                             ->editColumn('status', function ($data) {
                                             $tb = '<button class="btn bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">'. $data->status->name .'</button>';
                                                 return $tb;
                                             })
                                             ->editColumn('nominal', function ($data) {
                                             $tb = '<div class="font-semibold items-center text-center">
                                                     ' . format_uang($data->nominal) . '
                                                     </div>';
                                                 return $tb;
                                             })
        
                 
                                            ->editColumn('date', function ($data) {
                                                $tb = '<div class="font-semibold items-center text-center">
                                                ' . $data->date . '
                                                </div>';
                                            return $tb;
                                            })
                                            ->rawColumns(['action','barang',
                                                    'customer',
                                                    'status',
                                                    'nominal',
                                                    'date',
                                                    ])
                                            ->make(true);
                    }

                    public function index_buyback_nota_data(Request $request)

                     {
                         $module_title = $this->module_title;
                         $module_name = $this->module_name;
                         $module_path = $this->module_path;
                         $module_icon = $this->module_icon;
                         $module_model = $this->module_model;
                         $module_name_singular = Str::singular($module_name);
                 
                         $module_action = 'List';
                         $$module_name = BuyBackNota::get();
                         return Datatables::of($$module_name)
                                         ->addColumn('action', function ($data) {
                                             $module_name = $this->module_name;
                                             $module_model = $this->module_model;
                                             $module_path = $this->module_path;
                                             return view(''.$module_name.'::'.$module_path.'.aksi',
                                             compact('module_name', 'data', 'module_model'));
                                                 })
                 
                                           ->editColumn('total_item', function ($data) {
                                                 $tb = '<div class="font-semibold items-center text-center">
                                                         ' . $data->items->count() . '
                                                        </div>';
                                                    return $tb;
                                                })
                                             ->editColumn('status', function ($data) {
                                             $tb = '<button class="btn bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">'. $data->current_status->name .'</button>';
                                                 return $tb;
                                             })
                                             ->editColumn('nota', function ($data) {
                                             $tb = '<div class="font-semibold items-center text-center">
                                                     ' . $data->invoice . '
                                                     </div>';
                                                 return $tb;
                                             })
        
                 
                                            ->editColumn('date', function ($data) {
                                                $tb = '<div class="font-semibold items-center text-center">
                                                ' . $data->date . '
                                                </div>';
                                            return $tb;
                                            })
                                            ->rawColumns(['action','barang',
                                                    'total_item',
                                                    'status',
                                                    'nota',
                                                    'date',
                                                    ])
                                            ->make(true);
                    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
        public function create()
        {
            if(AdjustmentSetting::exists()){
                toast('Stock Opname sedang Aktif!', 'error');
                return redirect()->back();
            }
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            $cabang = null;
            if(auth()->user()->isUserCabang()){
                $cabang = Cabang::where('id',Auth::user()->namacabang()->id)->get();
            }else{
                $cabang = Cabang::all();
            }
            abort_if(Gate::denies('create_buybacktoko'), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
               compact('module_name',
                'module_action',
                'module_title',
                'cabang',
                'module_icon', 'module_model'));
            }



       public function buysback_nota()
        {
            if(AdjustmentSetting::exists()){
                toast('Stock Opname sedang Aktif!', 'error');
                return redirect()->back();
            }
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            $cabang = null;
            if(auth()->user()->isUserCabang()){
                $cabang = Cabang::where('id',Auth::user()->namacabang()->id)->get();
            }else{
                $cabang = Cabang::all();
            }
            // abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.buysback_nota',
               compact('module_name',
                'module_action',
                'module_title',
                'cabang',
                'module_icon',
                'module_model'));
            }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

      public function type(Request $request) {

                $type = $request->type;
                $module_title = $this->module_title;
                $module_name = $this->module_name;
                $module_path = $this->module_path;
                $module_icon = $this->module_icon;
                $module_model = $this->module_model;

                    Cart::instance('purchase')->destroy();
                    if ($type == 'NonMember') {
                     return view(''.$module_name.'::'.$module_path.'.type.member');
                    }
                    elseif ($type == 'toko') {
                    return view(''.$module_name.'::'.$module_path.'.type.toko');
                    }
                    else {
                       return view(''.$module_name.'::'.$module_path.'.create');
                    }

            }




   public function saveTypeCustomer(StoreBuyBackRequest $request) {

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

        $purchase = BuysBack::create([
                'date' => $request->date,
                'supplier_id' => null,
                'supplier_name' => 'none',
                'customer_id' => $customer_name,
                'customer_name' => Customer::findOrFail($customer_name)->customer_name,
                'jenis_buyback_id' => $request->jenis_buyback_id,
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
                'status' => 'Completed',
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {
                //dd($params);
                BuysBackDetails::create([
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

            }
            Cart::instance('purchase')->destroy();
        });

        toast('BuyBacks Created!', 'success');

        return redirect()->route('buysback.index');
    }






 public function store(Request $request) {
    if(AdjustmentSetting::exists()){
        toast('Stock Opname sedang Aktif!', 'error');
        return redirect()->back();
    }
        $validated = $request->validate([
            'no_buy_back' => 'required',
            'date' => 'required',
            'customer_id' => 'required_if:customer,1',
            'none_customer' => 'required_if:customer,2',
            'nama_products' => 'required',
            'kadar' => 'required',
            'berat' => 'required',
            'nominal' => 'required',
            'cabang_id' => 'required|exists:cabangs,id'
        ]);
        // $input = $request->all();
         $nominal = preg_replace("/[^0-9]/", "",  $request->input('nominal'));
         //dd($nominal);
         $newBuyBack = BuysBack::create([
            'date' => $request->input('date'),
            'customer_id' => $request->input('customer') == 1?$request->input('customer_id'):null,
            'customer_name' => $request->input('customer') == 2?$request->input('none_customer'):null,
            'note' => $request->input('note')??null,
            'no_buy_back' => $request->input('no_buy_back'),
            'product_name' => $request->input('nama_products'),
            'karat_id' => $request->input('kadar'),
            'status' => 'PENDING',
            'weight' => $request->input('berat'),
            'nominal' => $nominal,
            'cabang_id' => $request->input('cabang_id')
        ]);

        event(new BuysBackCreated($newBuyBack));
        toast('Buys Back Created!', 'success');
        return redirect()->route('buysback.index');
    }


//store ajax version

public function store_ajax(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(),[
             'code' => 'required|max:191|unique:'.$module_model.',code',
             'name' => 'required|max:191',

        ]);


        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        //$input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $input['code'] = $input['code'];
        $input['name'] = $input['name'];
        $$module_name_singular = $module_model::create($input);

        return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
    }










    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
   public function show($id)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_buybacktoko'), 403);
        $buyback_nota = BuyBackNota::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'buyback_nota',
            'module_title',
            'module_icon', 'module_model'));

    }


 public function show_buysback_nota($id)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_buybacktoko'), 403);
        $buyback_nota = BuyBackNota::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'buyback_nota',
            'module_title',
            'module_icon', 'module_model'));

    }








  public function show_distribusi()
    {
        dd('dsdsdsd');
   
      

    }








    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
       $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.edit',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));
        }


     public function status($id)
    {
       $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Status';
        abort_if(Gate::denies('edit_buybacktoko'), 403);
        $detail = $module_model::findOrFail($id);
        $proses_statuses = ProsesStatus::all();
          return view(''.$module_name.'::'.$module_path.'.modal.status',
           compact('module_name',
            'module_action',
            'detail',
            'proses_statuses',
            'module_title',
            'module_icon', 'module_model'));
         }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */



//update ajax version
public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make($request->all(),
            [
            'code' => [
                'required',
                'unique:'.$module_model.',code,'.$id
            ],
            'name' => 'required|max:191',


        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $params['code'] = $params['code'];
        $params['name'] = $params['name'];
        $$module_name_singular->update($params);
        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

 }

//update ajax version
public function update_status(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make($request->all(),
            [
                'status_id' => 'required|exists:proses_statuses,id',
        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        $$module_name_singular->update($params);
        $$module_name_singular->statuses()->attach($params['status_id']);
        
        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

 }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        try {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Delete';

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();
         toast(''. $module_title.' Deleted!', 'success');
         return redirect()->route(''.$module_name.'.index');

          } catch (\Exception $e) {
           // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

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
