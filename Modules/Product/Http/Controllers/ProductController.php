<?php



namespace Modules\Product\Http\Controllers;

use Carbon\Carbon;
use Modules\Product\DataTables\ProductDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Category;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Entities\ProductLocation;
use Modules\Product\Entities\TrackingProduct;
use Modules\Purchase\Entities\Purchase;
use Modules\Locations\Entities\Locations;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Stok\Models\StockOffice;
use Modules\Group\Models\Group;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\Upload\Entities\Upload;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Yajra\DataTables\DataTables;
use Image;
use App\Models\ActivityLog;
use Milon\Barcode\Facades\DNS1DFacade;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Auth;
use Illuminate\Support\Facades\DB;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Karat\Models\Karat;
use Modules\Product\Models\Penyusutan;
use Modules\Produksi\Models\DiamondCertificateAttribute;
use Modules\Produksi\Models\DiamondCertificateAttributes;
use Modules\Produksi\Models\DiamondCertifikatT;

class ProductController extends Controller
{


    public function __construct()
    {
        // Page Title
        $this->module_title = 'Products';

        // module name
        $this->module_name = 'products';

        // directory path of the module
        $this->module_path = 'product';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Product\Entities\Product";
        $this->module_item = "Modules\Product\Entities\ProductItem";
        $this->module_categories = "Modules\Product\Entities\Category";
        $this->module_pembelian = "Modules\GoodsReceipt\Models\GoodsReceipt";
    }


    public function index()
    {
        if (AdjustmentSetting::exists()) {
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
        // abort_if(Gate::denies('access_products'), 403);
        return view(
            'product::products.index',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }




    public function listReparasi()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_products'), 403);
        return view(
            'product::products.reparasi',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function listRfid()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_products'), 403);
        return view(
            'product::products.rfid',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function sortir()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_products'), 403);
        return view(
            'product::products.sortir',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function index_gudang_utama()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_products'), 403);
        return view(
            'product::products.gudangutama',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }






    public function codeGenerate(Request $request)
    {
        $group = $request->group;
        $karat = $request->karat;
        if (!$group) {
            return response()->json(['code' => '0']);
        }
        $namagroup = Group::where('id', $group)->first()->code;
        $cb = Auth::user()->namacabang()->code;
        $existingCode = true;
        $codeNumber = '';
        $cabang = $cb ?? 'JSR';
        while ($existingCode) {
            $date = now()->format('dmY');
            $randomNumber = mt_rand(100, 999);
            $codeNumber = $cabang . '-' . $namagroup . '-' . $randomNumber . '-' . $date;
            $existingCode = Product::where('product_code', $codeNumber)->exists();
        }
        return response()->json(['code' => $codeNumber]);
    }





    public function getsalesProduct(Request $request)
    {
        $product = Product::where('product_price', '>', 0);
        if (isset($request->cariproduk)) {
            $product = $product->where('product_name', 'LIKE', '%' . $request->cariproduk . '%')->orwhere('product_code', 'LIKE', '%' . $request->cariproduk . '%');
        }
        $product = $product->get();
        $data = '';
        if (count($product) > 0) {
            foreach ($product as $product) {
                $stock = ProductLocation::join('locations', 'locations.id', 'product_locations.location_id')
                    ->where('product_id', $product->id)->first();
                if (empty($stock)) {
                    $stock = 0;
                } else {
                    $stock = $stock->stock;
                }

                if ($stock) {
                    $data .= '<a class="pb-0" onclick="selectproduct(' . $product->id . ',' . $stock . ')" style="cursor:pointer;">
                   <div
                    class="relative overflow-hidden rounded-xl shadow-xl cursor-pointer m-0 dark:bg-gray-600 duration-300 ease-in-out transition-transform transform hover:-translate-y-2">
                    <img class="object-cover w-full h-48"
                      src="' . $product->getFirstMediaUrl('images') . '"
                      alt="Flower and sky" />
                    <span
                      class="absolute top-0 left-0 flex flex-col items-center mt-1 ml-1 px-1 py-1 rounded-lg z-10 bg-yellow-500 text-sm font-medium">
                           <span class="small text-xs text-gray-200">' . $product->product_code . '</span>
                    </span>
                    <span
                      class="absolute top-0 right-0 items-center inline-flex mt-1 mr-1 px-1 py-1 rounded-lg z-10 bg-white text-sm font-medium text-white select-none">
                          <span class="small text-xs text-gray-500">Stock: ' . $stock . '</span>
                    </span>
                    <div class="bg-gray-900 opacity-60 w-full absolute bottom-0 left-0 items-left py-2">
                      <div class="px-2 text-md font-bold text-white">' . $product->product_name . '</div>
                      <div class="px-2 text-xs text-white">' . format_currency($product->product_price) . '</div>
                    </div>


                  </div>
                  </a>';
                }
            }
        } else {
            $data .= '<div class="col-span-5 py-1 px-1">
                <div class="text-left text-gray-800">Produk Tidak Ditemukan</div>
            </div>
            ';
        }

        return response()->json($data);
    }


    public function index_data_table(ProductDataTable $dataTable)
    {
        abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('product::products.index');
    }






    public function add_products_categories_single(Request $request, $id)
    {
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();

        $module_action = 'List';
        return view(
            'product::products.add_product',
            compact(
                'module_name',
                'category',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }





    public function add_products_categories(Request $request, $id)
    {
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();
        $locations = Locations::where('name', 'LIKE', '%Pusat%')->first();
        $code = Product::generateCode();
        $module_action = 'List';
        return view(
            '' . $module_path . '::' . $module_name . '.popup.create',
            compact(
                'module_name',
                'module_title',
                'category',
                'locations',
                'code',
                'module_icon',
                'module_model'
            )
        );
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
        $$module_name = $module_model::with('category', 'product_item');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        $$module_name = $$module_name->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }




    public function index_data_by_kategori(Request $request, $id)
    {
        if (AdjustmentSetting::exists()) {
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


        $$module_name = $module_model::with('category', 'product_item')
            ->whereHas('category', function ($q) use ($id) {
                $q->where('kategori_produk_id', $id);
            })->get();
        $data = $$module_name;
        //dd($data);

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.aksi_kategori',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>


                        </div>
                    </div>';
                return $tb;
            })
            ->addColumn('product_image', function ($data) {
                $url = $data->getFirstMediaUrl('images', 'thumb');
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                    <h3 class="text-sm text-center text-gray-800">
                     ' . $data->cabang->code . ' |  ' . $data->cabang->name . '</h3>
                        </div>';
                return $tb;
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                    <h3 class="text-sm font-semibold text-center text-gray-800">
                     ' . $data->product_item[0]->karat?->label . ' </h3>
                        </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('status', function ($data) {
                $status = statusProduk($data->status);
                return $status;
            })

            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }





    //data sortir

    public function index_data_rfid(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item')
            ->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.rfid_aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div style="font-size:0.7rem; line-heght:1 !important;" class="leading-0 text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                             <div style="font-size:0.7rem !important;" class="text-xs font-normal text-gray-800 dark:text-gray-400">
                            ' . $data->rfid . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            ->addColumn('product_image', function ($data) {
                $url = $data->getFirstMediaUrl('images', 'thumb');
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->addColumn('product_price', function ($data) {
                return format_currency($data->product_price);
            })
            ->addColumn('product_quantity', function ($data) {
                return $data->product_quantity . ' ' . $data->product_unit;
            })

            ->editColumn('product_quantity', function ($data) {
                $tb = '<div class="items-center small text-center">
            <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' . $data->product_quantity . ' ' . $data->product_unit . '</span></div>';
                return $tb;
            })
            ->editColumn('weight', function ($data) {
                $berat = @$data->product_item[0]->berat_emas;
                if ($berat) {
                    $weight = @$data->product_item[0]->berat_emas;
                } else {
                    $weight = '0';
                }

                $tb = '<div class="items-center small text-center">
            <span class="bg-yellow-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' .  $weight . '</span></div>';
                return $tb;
            })

            ->editColumn('status', function ($data) {
                $status = statusProduk($data->status);
                return $status;
            })

            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);
                if ($diff < 25) {
                    return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                } else {
                    return tgljam($data->created_at);
                }
            })
            ->rawColumns([
                'updated_at', 'product_image', 'weight', 'status',
                'product_name', 'product_quantity', 'product_price', 'action'
            ])
            ->make(true);
    }




    //data sortir

    public function index_data_sortir(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item')
            ->whereHas('product_location', function ($query) {
                $sortir = Locations::where('name', 'LIKE', '%Sortir%')->first();
                $query->where('location_id', $sortir->id);
            })
            ->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.sortir_aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div style="font-size:0.7rem; line-heght:1 !important;" class="leading-0 text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                             <div style="font-size:0.7rem !important;" class="text-xs font-normal text-blue-600 dark:text-gray-400">
                            ' . $data->rfid . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            ->addColumn('product_image', function ($data) {
                $url = $data->getFirstMediaUrl('images', 'thumb');
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->addColumn('product_price', function ($data) {
                return format_currency($data->product_price);
            })
            ->addColumn('product_quantity', function ($data) {
                return $data->product_quantity . ' ' . $data->product_unit;
            })

            ->editColumn('product_quantity', function ($data) {
                $tb = '<div class="items-center small text-center">
            <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' . $data->product_quantity . ' ' . $data->product_unit . '</span></div>';
                return $tb;
            })
            ->editColumn('weight', function ($data) {
                $berat = @$data->product_item[0]->berat_emas;
                if ($berat) {
                    $weight = @$data->product_item[0]->berat_emas;
                } else {
                    $weight = '0';
                }

                $tb = '<div class="items-center small text-center">
            <span class="bg-yellow-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' .  $weight . '</span></div>';
                return $tb;
            })

            ->addColumn('status', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.status',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('lokasi', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.lokasi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);
                if ($diff < 25) {
                    return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                } else {
                    return tgljam($data->created_at);
                }
            })
            ->rawColumns([
                'updated_at', 'product_image', 'weight', 'status', 'lokasi',
                'product_name', 'product_quantity', 'product_price', 'action'
            ])
            ->make(true);
    }




    //data Gudang Utama

    public function index_data_gudang_utama(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item')
            ->whereHas('product_location', function ($query) {
                $sortir = Locations::where('name', 'LIKE', '%Utama%')->first();
                $query->where('location_id', $sortir->id);
            })
            ->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div style="font-size:0.7rem; line-heght:1 !important;" class="leading-0 text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                             <div style="font-size:0.7rem !important;" class="text-xs font-normal text-blue-600 dark:text-gray-400">
                            ' . $data->rfid . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            ->addColumn('product_image', function ($data) {
                $url = $data->getFirstMediaUrl('images', 'thumb');
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->addColumn('product_price', function ($data) {
                return format_currency($data->product_price);
            })
            ->addColumn('product_quantity', function ($data) {
                return $data->product_quantity . ' ' . $data->product_unit;
            })

            ->editColumn('product_quantity', function ($data) {
                $tb = '<div class="items-center small text-center">
            <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' . $data->product_quantity . ' ' . $data->product_unit . '</span></div>';
                return $tb;
            })
            ->editColumn('weight', function ($data) {
                $berat = @$data->product_item[0]->berat_emas;
                if ($berat) {
                    $weight = @$data->product_item[0]->berat_emas;
                } else {
                    $weight = '0';
                }

                $tb = '<div class="items-center small text-center">
            <span class="bg-yellow-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' .  $weight . '</span></div>';
                return $tb;
            })

            ->addColumn('status', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.status',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('lokasi', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.lokasi',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.transfer.tracking_button',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);
                if ($diff < 25) {
                    return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                } else {
                    return tgljam($data->created_at);
                }
            })
            ->rawColumns([
                'updated_at', 'product_image', 'weight', 'status', 'lokasi', 'tracking',
                'product_name', 'product_quantity', 'product_price', 'action'
            ])
            ->make(true);
    }










    //data sortir

    public function index_data_reparasi(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item')
            ->whereHas('product_location', function ($query) {
                $sortir = Locations::where('name', 'LIKE', '%Reparasi%')->first();
                $query->where('location_id', $sortir->id);
            })
            ->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.show_hapus',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div style="font-size:0.7rem; line-heght:1 !important;" class="leading-0 text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                             <div style="font-size:0.7rem !important;" class="text-xs font-normal text-blue-600 dark:text-gray-400">
                            ' . $data->rfid . '</div>
                        </div>
                    </div>';
                return $tb;
            })
            ->addColumn('product_image', function ($data) {
                $url = $data->getFirstMediaUrl('images', 'thumb');
                return '<img src="' . $url . '" border="0" width="50" class="img-thumbnail" align="center"/>';
            })

            ->addColumn('product_price', function ($data) {
                return format_currency($data->product_price);
            })
            ->addColumn('product_quantity', function ($data) {
                return $data->product_quantity . ' ' . $data->product_unit;
            })

            ->editColumn('product_quantity', function ($data) {
                $tb = '<div class="items-center small text-center">
            <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' . $data->product_quantity . ' ' . $data->product_unit . '</span></div>';
                return $tb;
            })
            ->editColumn('weight', function ($data) {
                $berat = @$data->product_item[0]->berat_emas;
                if ($berat) {
                    $weight = @$data->product_item[0]->berat_emas;
                } else {
                    $weight = '0';
                }

                $tb = '<div class="items-center small text-center">
            <span class="bg-yellow-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' .  $weight . '</span></div>';
                return $tb;
            })

            ->addColumn('status', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.status',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('lokasi', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.lokasi',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.transfer.tracking_button',
                    compact('module_name', 'data', 'module_model')
                );
            })

            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;
                $diff = Carbon::now()->diffInHours($data->updated_at);
                if ($diff < 25) {
                    return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                } else {
                    return tgljam($data->created_at);
                }
            })
            ->rawColumns([
                'updated_at', 'product_image', 'weight', 'status', 'lokasi', 'tracking',
                'product_name', 'product_quantity', 'product_price', 'action'
            ])
            ->make(true);
    }















    public function create()
    {
        abort_if(Gate::denies('create_products'), 403);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_action = 'Create';
        $category = Category::get();
        return view(
            'product::categories.page.add',
            compact(
                'module_name',
                'module_action',
                'category',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function addProdukBuyBack($id)
    {
        $id = decode_id($id);
        abort_if(Gate::denies('create_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_action = 'Create';
        $category = Category::get();
        $pembelian = $module_pembelian::where('id', $id)->first();
        //dd($pembelian->code);
        return view(
            'product::categories.page.add',
            compact(
                'module_name',
                'module_action',
                'category',
                'pembelian',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }




    public function view_qrcode($id)
    {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_action = 'Qrcode';
        $category = Category::get();
        $detail = $module_model::where('id', $id)->first();
        //dd($pembelian->code);
        return view(
            'product::products.modal.qrcode',
            compact(
                'module_name',
                'module_action',
                'category',
                'detail',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }




    public function getPdf($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $product = $module_model::where('id', $id)->first();
        // $customPaper = 'A4';
        $customPaper = array(0, 0, 120, 420);
        $barcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($product->product_code));
        $pdf = PDF::loadView('product::barcode.cetak', compact('product', 'barcode'))
            ->setPaper($customPaper, 'landscape');
        return $pdf->stream('barcodes-' . $product->product_code . '.pdf');
    }









    public function create2()
    {
        // $id = decode_id($id);
        $id = 2;
        //dd($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_categories = $this->module_categories;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $main = $module_model::findOrFail($id);
        $category = Category::get();
        // dd($category);
        return view(
            'product::categories.page.add',
            compact(
                'module_name',
                'module_action',
                'main',
                'category',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function createModal()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $listcategories = KategoriProduk::with('category')->get();
        abort_if(Gate::denies('create_products'), 403);
        return view(
            '' . $module_path . '::' . $module_name . '.modal.index',
            compact(
                'module_name',
                'module_title',
                'listcategories',
                'module_icon',
                'module_model'
            )
        );
    }


    public function add_produk_modal_from_pembelian($id)
    {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);
        $listcategories = KategoriProduk::with('category')->get();
        $pembelian = $module_pembelian::where('id', $id)->first();
        abort_if(Gate::denies('create_products'), 403);
        return view(
            '' . $module_path . '::' . $module_name . '.modal.catlist',
            compact(
                'module_name',
                'module_title',
                'listcategories',
                'pembelian',
                'module_icon',
                'module_model'
            )
        );
    }




    public function add_products_modal_categories(Request $request, $id)
    {
        abort_if(Gate::denies('access_products'), 403);
        $type = $request->type;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();
        $locations = Locations::where('name', 'LIKE', '%Pusat%')->first();
        $code = Product::generateCode();
        $module_action = 'List';
        return view(
            '' . $module_path . '::' . $module_name . '.modal.create',
            compact(
                'module_name',
                'module_title',
                'category',
                'locations',
                'code',
                'type',
                'module_icon',
                'module_model'
            )
        );
    }

    //start tambah produk tanpa Modal

    //tambah produk by kategori ID
    public function add_products_by_categories(Request $request, $id)
    {
        $id = decode_id($id);
        $no_pembelian = $request->get('po') ?? '0';
        //dd($no_pembelian);
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_categories = $this->module_categories;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);
        $main = KategoriProduk::where('id', $id)->first();
        $category = Category::where('kategori_produk_id', $id)->get();
        $locations = Locations::where('name', 'LIKE', '%Pusat%')->first();
        $pembelian = $module_pembelian::where('code', $no_pembelian)->first();
        $code = Product::generateCode();
        $module_action = 'List';
        return view(
            '' . $module_path . '::categories.page.create',
            compact(
                'module_name',
                'module_title',
                'category',
                'locations',
                'main',
                'category',
                'no_pembelian',
                'pembelian',
                'code',
                'module_icon',
                'module_model'
            )
        );
    }





    //view main kategori modal

    public function view_by_kategori(Request $request, $slug)
    {
        if (AdjustmentSetting::exists()) {
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        abort_if(Gate::denies('access_products'), 403);
        $type = $request->type;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $mainkategori = KategoriProduk::where('slug', $slug)->first();
        $module_action = 'List';
        return view(
            '' . $module_path . '::' . $module_name . '.page.by_kategori',
            compact(
                'module_name',
                'module_title',
                'type',
                'mainkategori',
                'module_icon',
                'module_model'
            )
        );
    }


    //=============================end tambah produk tanpa modal

    //view main kategori modal

    public function view_group_kategori_pages(Request $request, $id)
    {
        abort_if(Gate::denies('access_products'), 403);
        $type = $request->type;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $groupkategori = Category::where('kategori_produk_id', $id)->get();
        $locations = Locations::where('name', 'LIKE', '%Pusat%')->first();
        $code = Product::generateCode();
        $module_action = 'List';
        return view(
            '' . $module_path . '::' . $module_name . '.page.group_kategori',
            compact(
                'module_name',
                'module_title',
                'type',
                'groupkategori',
                'locations',
                'code',
                'module_icon',
                'module_model'
            )
        );
    }


    //=============================end tambah produk tanpa modal


    //view main kategori modal
    public function view_main_kategori_modal(Request $request, $id)
    {
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $groupkategori = Category::where('kategori_produk_id', $id)->get();
        $locations = Locations::where('name', 'LIKE', '%Pusat%')->first();
        $code = Product::generateCode();
        $module_action = 'List';
        return view(
            '' . $module_path . '::' . $module_name . '.modal.group_kategori',
            compact(
                'module_name',
                'module_title',
                'groupkategori',
                'locations',
                'code',
                'module_icon',
                'module_model'
            )
        );
    }






    public function webcam()
    {
        abort_if(Gate::denies('create_products'), 403);

        return view('product::products.webcam');
    }






    //store ajax version

    public function saveAjax(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pembelian = $this->module_pembelian;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(), [
            //'product_code' => 'required|max:255|unique:'.$module_model.',product_code',
            'category' => 'required',
            'produk_model' => 'required',
            'group_id' => 'required',


        ]);

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->except('_token');
        $input = $request->all();
        $input['product_price'] = preg_replace("/[^0-9]/", "", $input['product_price']);
        $input['product_cost'] = preg_replace("/[^0-9]/", "", $input['product_cost']);
        $model = ProdukModel::where('id', $input['produk_model'])->first();
        $group = Group::where('id', $input['group_id'])->first();
        $totalberat = $input['berat_total'] ?? $input['berat_emas'];
        $berat = number_format((float)($totalberat), 5);
        $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
        $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
        $$module_name_singular = $module_model::create([
            'category_id'                       => $input['category'],
            'cabang_id'                         => $input['cabang_id'],
            'goodsreceipt_id'                   => $input['goodsreceipt_id'],
            'kode_pembelian'                    => $input['kode_pembelian'],
            'product_stock_alert'               => $input['product_stock_alert'],
            'product_name'                      => $group->name . ' ' . $model->name ?? 'unknown',
            'product_code'                      => $input['product_code'],
            'product_price'                     => $product_price,
            'product_quantity'                  => $input['product_quantity'],
            'product_barcode_symbology'         => $input['product_barcode_symbology'],
            'product_unit'                      => $input['product_unit'],
            'status'                            => 0, //status Purchase
            'product_cost'                      => $product_cost
        ]);

        if ($request->filled('image')) {
            $img = $request->image;
            $folderPath = "uploads/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'webcam_' . uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('local')->put($file, $image_base64);
            $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))
                ->toMediaCollection('images');
        }

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $$module_name_singular->addMediaFromRequest('document')
                ->toMediaCollection('images');
        }

        $produk = $$module_name_singular->id;
        $module_pembelian::countProduk($$module_name_singular->kode_pembelian);
        $this->_saveProductsItem($input, $produk);

        activity()->log(' ' . auth()->user()->name . ' Input data pembelian');
        return response()->json([
            'produk' => $produk,
            'success' => '  ' . $module_title . ' Sukses disimpan.'

        ]);
    }



    private function _saveHistoryDistribusiToko($input)
    {

        $logam_mulia = \Modules\Karat\Models\Karat::where('type', 'LM')->first();
        DistribusiToko::create([
            'cabang_id'                   => $input['cabang_id'] ?? null,
            'karat_id'                    => $input['karat_id'] ?? $logam_mulia->id,
            'date'                        => date('Y-m-d'),
            'weight'                      => $input['berat_emas'],
            'created_by'                  => auth()->user()->name
        ]);


        // dd($input);
    }


    private function _saveProductsItem($input, $produk)
    {

        $logam_mulia = \Modules\Karat\Models\Karat::where('type', 'LM')->first();
        //dd($logam_mulia->id);
        ProductItem::create([
            'product_id'                  => $produk,
            'parameter_berlian_id'        => $input['parameter_berlian_id'] ?? null,
            'jenis_perhiasan_id'          => $input['jenis_perhiasan_id'] ?? null,
            'customer_id'                 => $input['customer_id'] ?? null,
            'karat_id'                    => $input['karat_id'] ?? $logam_mulia->id,
            'gold_kategori_id'            => $input['gold_kategori_id'] ?? null,
            'certificate_id'              => $input['certificate_id'] ?? null,
            //'tag_label'                   => $input['berat_tag'] ?? null,
            'berat_emas'                  => $input['berat_emas'],
            'berat_label'                 => $input['berat_label'] ?? 0,
            'supplier_id'                 => $input['supplier_id'] ?? null,
            'produk_model_id'             => $input['produk_model'] ?? null,
            'berat_total'                 => $input['berat_total']
        ]);
        $lm = $input['karat_id'] ?? $logam_mulia->id;
        $stock = StockOffice::where('karat_id', $lm)->first();
        if (isset($stock)) {
            $stock->update(
                [
                    'berat_real' => $stock->berat_real - $input['berat_emas'],
                    'berat_kotor' => $stock->berat_kotor - $input['berat_total'] - $input['berat_emas']
                ]
            );
        } else {
            toast('Gagal Insert Produk!', 'error');
            return redirect()->back();
        }
    }






    public function save(StoreProductRequest $request)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_item = $this->module_item;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        $input = $request->all();
        $input = $request->except(['document']);
        $input['product_price'] = preg_replace("/[^0-9]/", "", $input['product_price']);
        $input['product_cost'] = preg_replace("/[^0-9]/", "", $input['product_cost']);
        dd($input);
        $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
        $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
        $$module_name_singular = $module_model::create([
            'category_id'                       => $input['category_id'],
            'product_stock_alert'               => $input['product_stock_alert'],
            'product_name'                      => $input['nama_produk'],
            'product_code'                      => $input['product_code'],
            'product_price'                     => $product_price,
            'product_quantity'                  => $input['product_quantity'],
            'product_barcode_symbology'         => $input['product_barcode_symbology'],
            'product_unit'                      => $input['product_unit'],
            'product_cost'                      =>  $product_cost
        ]);

        if ($request->filled('image')) {
            $img = $request->image;
            $folderPath = "uploads/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'webcam_' . uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('local')->put($file, $image_base64);
            $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))->toMediaCollection('images');
            //$params['image'] = "$newFilename";
        }


        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        $produk = $$module_name_singular->id;
        $this->_saveProductsItem($input, $produk);
        toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }







    public function store(Request $request)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_item = $this->module_item;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';

        $request->validate([
            'product_code' => 'required|max:255|unique:' . $module_model . ',product_code',
            'category' => 'required',
            'produk_model' => 'required',
            'group_id' => 'required',
            'cabang_id' => 'required',
            'berat_accessories' => 'required_if:category,!4',
        ]);
        $input = $request->all();
        $input = $request->except(['document']);
        // dd($input);

        $model = ProdukModel::where('id', $input['produk_model'])->first();
        $group = Group::where('id', $input['group_id'])->first();
        $group = Group::where('id', $input['group_id'])->first();

        $$module_name_singular = $module_model::create([
            'category_id'                => $input['category'],
            'cabang_id'                  => $input['cabang_id'],
            'product_stock_alert'        => $input['product_stock_alert'],
            'product_name'              => $group->name . ' ' . $model->name ?? 'unknown',
            'product_code'               => $input['product_code'],



            'product_barcode_symbology'  => $input['product_barcode_symbology'],
            'product_unit'               => $input['product_unit']
        ]);

        if ($request->filled('image')) {
            $img = $request->image;
            $folderPath = "uploads/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'webcam_' . uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('local')->put($file, $image_base64);
            $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))->toMediaCollection('images');
            //$params['image'] = "$newFilename";
        }


        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        $produk = $$module_name_singular->id;
        $this->_saveProductsItem($input, $produk);
        $this->_saveHistoryDistribusiToko($input);
        toast('Product Created!', 'success');

        return redirect()->route('distribusitoko.index');
    }









    public function show($id)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $product = $module_model::akses()->with('product_item.karat.penentuanHarga')->where('id', $id)->first();

        //dd($detail);
        return view(
            'product::products.modal.show',
            compact(
                'module_name',
                'module_action',
                'product',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function showSertifikat($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $product = $module_model::akses()->with('product_item.karat.penentuanHarga')->where('id', $id)->first();
        $diamondCertifikatT = DiamondCertifikatT::where('id', $product->diamond_certificate_id)->first();

        $diamondCertifikatAttribute = DB::table('diamond_certificate_attributes_t')
            ->join('diamond_certificate_attributes_m', 'diamond_certificate_attributes_t.diamond_certificate_attributes_id', '=', 'diamond_certificate_attributes_m.id')
            ->where('diamond_certificate_attributes_t.diamond_certificate_id', $diamondCertifikatT->id)
            ->select('diamond_certificate_attributes_t.*', 'diamond_certificate_attributes_m.name as name')
            ->get();
        $detail = $module_model::where('id', $id)->first();

        //dd($detail);
        return view(
            'product::products.modal.show_sertifikat',
            compact(
                'module_name',
                'module_action',
                'product',
                'detail',
                'diamondCertifikatAttribute',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function printSertifikat($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $product = $module_model::akses()->with('product_item.karat.penentuanHarga')->where('id', $id)->first();
        $diamondCertifikatT = DiamondCertifikatT::where('id', $product->diamond_certificate_id)->first();
        // $diamondCertifikatAttribute = DiamondCertificateAttribute::where('diamond_certificate_id', $diamondCertifikatT->id)->get();
        $diamondCertifikatAttribute = DB::table('diamond_certificate_attributes_t')
            ->join('diamond_certificate_attributes_m', 'diamond_certificate_attributes_t.diamond_certificate_attributes_id', '=', 'diamond_certificate_attributes_m.id')
            ->where('diamond_certificate_attributes_t.diamond_certificate_id', $diamondCertifikatT->id)
            ->select('diamond_certificate_attributes_t.*', 'diamond_certificate_attributes_m.name as name')
            ->take(6)
            ->get();
        $image = $product->images;
        if (empty($image)) {
            $imagePath = public_path('images/fallback_product_image.png');
        } else {
            $imagePath = public_path('storage/uploads/' . $image . '');
        }
        $detail = $module_model::where('id', $id)->first();

        // $customPaper = 'A4';
        $customPaper = array(0, 0, 120, 420);
        $barcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($product->product_code));

        $pdf = PDF::loadView('product::barcode.print_sertifikat', compact('product', 'barcode', 'diamondCertifikatAttribute', 'imagePath'))
            ->setPaper($customPaper, 'landscape');
        return $pdf->stream('barcodes-' . $product->product_code . '.pdf');
    }

    public function show_distribusi($id)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('approve_distribusi'), 403);
        $product = $module_model::akses()->with('product_item.karat.penentuanHarga')->where('id', $id)->first();

        //dd($detail);
        return view(
            'product::products.modal.show_distribusi',
            compact(
                'module_name',
                'module_action',
                'product',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }




    public function update_status_distribusi(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make(
            $request->all(),
            [
                'status' => 'required',
            ]
        );

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->all();
        dd($input);
        $params = $request->except('_token');
        $params['status'] = $params['status'];
        $$module_name_singular->update($params);
        return response()->json(['success' => '  ' . $module_title . ' Sukses di update.']);
    }



    public function show_sortir(Product $product)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_item = $this->module_item;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        abort_if(Gate::denies('access_sortir'), 403);
        return view(
            'product::products.popup.show_sortir',
            compact(
                'product',
                'module_title',
                'module_path',
                'module_name',
                'module_icon',
                'module_model',
                'module_item',
                'module_name'
            )
        );
    }


    public function show_rfid(Product $product)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_item = $this->module_item;
        $code = mt_rand(10000000, 99999999);
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        abort_if(Gate::denies('show_products'), 403);
        return view(
            'product::products.popup.show_rfid',
            compact(
                'product',
                'module_title',
                'module_path',
                'module_name',
                'module_icon',
                'module_model',
                'module_item',
                'code',
                'module_name'
            )
        );
    }



    public function rfidUpdate(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make(
            $request->all(),
            [
                'rfid' => [
                    'required',
                    'unique:' . $module_model . ',rfid,' . $id
                ],

            ]
        );

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        $params['rfid'] = $params['rfid'];
        $$module_name_singular->update($params);
        return response()->json(['success' => '  ' . $module_title . ' Sukses di update.']);
    }






    public function sortirUpdate(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Sortir Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make(
            $request->all(),
            [
                'location_id' => 'required',

            ]
        );

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // $params = $request->all();
        //dd($params);
        $params = $request->except('_token');

        $destination = ProductLocation::where('product_id', $id)->first();
        if (isset($destination)) {
            $destination->location_id = $params['location_id'];
            $destination->save();
        } else {
            ProductLocation::create([
                'product_id' => $id,
                'location_id' => $params['location_id']
            ]);
        }

        $lok = Locations::where('id', $params['location_id'])->first();
        TrackingProduct::create([
            'location_id' =>  $params['location_id'],
            'product_id'  =>  $id,
            'username'    =>  auth()->user()->name,
            'user_id'     =>  auth()->user()->id,
            'status'      =>   $$module_name_singular->status,
            'note'  =>   'Barang sudah di Sortir dan di pindahkan ke <strong>' . $lok->name . '</strong>  oleh ' . auth()->user()->name . '</br>Catatan || ' . $params['note'] . ' ',
        ]);


        $produkItem = Product::where('id', $id)->first();
        $produkItem->update([
            'status' => 1
        ]);

        return response()->json(['success' => '  ' . $module_title . ' Sukses diupdate.']);
    }



    public function edit(Product $product)
    {
        abort_if(Gate::denies('edit_products'), 403);

        return view('product::products.edit', compact('product'));
    }


    public function update_oso(UpdateProductRequest $request, Product $product)
    {
        //dd($product);
        $product->update($request->except('document'));


        //dd($request);
        if ($request->has('document')) {
            if (count($product->getMedia('images')) > 0) {
                foreach ($product->getMedia('images') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $product->getMedia('images')->pluck('file_name')->toArray();
            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                }
            }
        }

        toast('Product Updated!', 'info');

        return redirect()->route('products.index');
    }


    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('access_product_categories'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';

        $$module_name_singular = $module_model::findOrFail($id);
        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
            'product_name' => 'required'
        ]);
        $params = $request->except('_token');
        $params['product_code'] = $params['product_code'];

        if ($image = $request->file('images')) {
            if ($$module_name_singular->image !== 'no_foto.png') {
                @unlink(imageUrl() . $$module_name_singular->image);
            }
            $gambar = 'produks_' . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $normal = Image::make($image)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode();


            $normalpath = 'uploads/' . $gambar;
            if (config('app.env') === 'production') {
                $storage = 'public';
            } else {
                $storage = 'public';
            }
            Storage::disk($storage)->put($normalpath, (string) $normal);
            $params['images'] = "$gambar";
        } else {
            unset($params['images']);
        }
        // dd($params);
        $$module_name_singular->update($params);
        toast('' . $module_title . ' Updated!', 'success');

        return redirect()->route('products.index');
    }









    public function index_distribusi(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item')
            ->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.aksi_distribusi',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>


                        </div>
                    </div>';
                return $tb;
            })
            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                    <h3 class="text-sm text-center text-gray-800">
                     ' . @$data->cabang->code . ' |  ' . @$data->cabang->name . '</h3>
                        </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                    <h3 class="text-sm font-semibold text-center text-gray-800">
                     ' . @$data->product_item[0]->karat?->label . ' </h3>
                        </div>';
                return $tb;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }



















    public function getone($id)
    {
        $product = Product::find($id);
        $stock = ProductLocation::join('locations', 'locations.id', 'product_locations.location_id')
            ->where('product_id', $id)->first();
        return response()->json([
            'product' => $product,
            'stock' => $stock
        ]);
    }


    public function destroy(Product $product)
    {
        abort_if(Gate::denies('delete_products'), 403);
        // $purchase = Purchase::whereHas('detail', function($q){
        //     $q->where('product_id',168);
        // })->first();
        // dd($purchase);

        //$purchase->delete();
        $product->delete();
        // $tracking = TrackingProduct::where('product_id',$product)->first();
        // $items = ProductItem::where('product_id',$product)->first();
        // $items->delete();
        // if ($tracking) {
        //  $tracking->delete();
        // }
        toast('Product Deleted!', 'warning');
        return redirect()->route('products.index');
    }



    public function update_status(Request $request)
    {
        $karat = Karat::where('name', $request->data_name)->first();
        if (!$karat) {
            return response()->json(['status' => 'error', 'message' => 'Karat tidak ditemukan']);
        }

        $category = Category::where('category_name', $request->data_category)->first();
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Kategori tidak ditemukan']);
        }

        DB::beginTransaction();
        try {
            $model = $this->module_model::find($request->data_id);

            if (!$model) {
                throw new \Exception('Model tidak ditemukan');
            }

            $model->updateTracking($request->status_id);

            if (!empty($request->post('berat_total'))) {
                $history_penyusutan = Penyusutan::create([
                    'product_id' => $request->data_id,
                    'berat_asal' => $request->post('berat_asal'),
                    'berat_asli' => $request->post('berat_total'),
                    'berat_susut' => $request->post('berat_susut'),
                    'created_by' => auth()->user()->id,
                ]);

                $model->berat_emas = $request->post('berat_total');
                $product_item = ProductItem::where('product_id', $request->data_id)->first();
            }

            $model->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Status Berhasil Diupdate'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

}
