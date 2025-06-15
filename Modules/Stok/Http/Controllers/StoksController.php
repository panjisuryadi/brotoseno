<?php

namespace Modules\Stok\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Image;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Modules\Stok\Models\StockOffice;
use Modules\Karat\Models\Karat;
use App\Models\LookUp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Cabang\Models\Cabang;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Stok\Exports\StokPending;
use Modules\Stok\Models\PenerimaanLantakan;
use Maatwebsite\Excel\Facades\Excel;

class StoksController extends Controller
{
    public $model_lantakan;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Stok';
        $this->module_name = 'stok';
        $this->module_path = 'stoks';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Stok\Models\StockSales";
        $this->module_office = "Modules\Stok\Models\StockOffice";
        $this->module_pending = "Modules\Stok\Models\StockPending";
        $this->module_pending_office = "Modules\Stok\Models\StockPendingOffice";
        $this->module_sales = "Modules\Stok\Models\StockSales";
        $this->model_lantakan = "Modules\Stok\Models\StockKroom";
        $this->module_dp = "Modules\Stok\Models\StokDp";
        $this->model_rongsok = "Modules\Stok\Models\StockRongsok";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.index',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function office()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Gudang';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.index_office',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }



    public function pending()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $karat_ids = Product::pending()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $module_action = 'Pending';
        abort_if(Gate::denies('access_stok_pending'), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_pending',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'datakarat',
                'module_icon',
                'module_model'
            )
        );
    }

    public function pending_office()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $karat_ids = Product::pendingOffice()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $add_data = [
            'status_id_ready_office' => ProductStatus::READY_OFFICE,
        ];
        $product_status = ProductStatus::find([
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
            ProductStatus::READY_OFFICE
        ]);
        $module_action = 'Pending Gudang';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_pending_office',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'datakarat',
                'product_status',
                'add_data',
                'module_icon',
                'module_model'
            )
        );
    }

    public function ready_office()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $karat_ids = Product::readyOffice()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
        ]);
        $module_action = 'Ready Office';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_ready_office',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'datakarat',
                'product_status',
                'module_icon',
                'module_model'
            )
        );
    }



    public function export_excel(Request $request)
    {
        //   ob_end_clean();
        // ob_start();
        $tanggal = date('dmY');
        $status = $request->get('status') ?? '';
        if ($status == 'lantakan') {
            $judul   =  'lantakan';
            $data_stok = \Modules\Stok\Models\StockKroom::get();
        } elseif ($status == 'office') {
            $judul   = 'Pending';
            $data_stok = Product::pending()->get();
        } else {
            $judul   = 'Pending';
            $data_stok = Product::pending()->get();
        }


        return Excel::download(
            new StokPending($tanggal, $status, $judul),
            'export-stok-' . $judul . '_' . $tanggal . '.xlsx'
        );

        // return view('stok::stoks.export_excel',
        //                       compact('tanggal','judul','status','data_stok'));

    }













    public function index_data_ready_office(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pending = $this->module_pending;
        $module_pending_office = $this->module_pending_office;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $datas = Product::readyOffice();
        if (isset($request->karat)) {
            $datas = $datas->where('karat_id', $request->karat);
        }

        $datas = $datas->get();

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.ready-office.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-gray-800">
                                    ' . $data->karat->label  . '</h3>
                                        </div>';
                return $tb;
            })

            ->editColumn('product', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                            <div>
                            <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                                ' . $data->category->category_name . '</div>
                                <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3><h3 class="text-sm font-bold text-gray-800 dark:text-white "> ' . $data->product_code . '</h3>


                            </div>
                                </div>';
                return $tb;
            })

            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                    ' . formatBerat($data->berat_emas) . ' gr</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('image', function ($data) {
                $tb = '<div class="flex justify-center"><a href="' . $data->image_url_path . '" data-lightbox="{{ @$image }} " class="single_image">
                            <img src="' . $data->image_url_path . '" order="0" width="100" class="img-thumbnail"/>
                            </a></div>';
                return $tb;
            })

            ->rawColumns([
                'image',
                'karat',
                'action',
                'product',
                'weight'
            ])
            ->make(true);
    }


    public function sales()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Sales';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_sales',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function dp()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'DP';
        abort_if(Gate::denies('access_stok_dp'), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_dp',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function lantakan()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Lantakan';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_lantakan',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function index_data_lantakan(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $model_lantakan = $this->model_lantakan;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $model_lantakan::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'includes.action',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->karat->label  . '</h3>
                                    </div>';
                return $tb;
            })



            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' . formatBerat($data->weight) . '</h3>
                                    </div>';
                return $tb;
            })

            ->rawColumns(['updated_at', 'karat', 'action', 'weight'])
            ->make(true);
    }

    public function rongsok()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Rongsok';
        abort_if(Gate::denies('access_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_rongsok',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }


    public function index_data_rongsok(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $model_rongsok = $this->model_rongsok;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $model_rongsok::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'includes.action',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                    ' . $data->karat?->label  . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                        ' . formatBerat($data->weight) . '</h3>
                                    </div>';
                return $tb;
            })

            ->rawColumns(['updated_at', 'karat', 'action', 'weight'])
            ->make(true);
    }




    public function index_data_dp(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_dp = $this->module_dp;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_dp::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'includes.action',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->karat->label  . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->cabang->code  . ' | ' . $data->cabang->name  . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('customer', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->customer->name  . '</h3>
                                    </div>';
                return $tb;
            })


            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' . formatBerat($data->weight) . '</h3>
                                    </div>';
                return $tb;
            })

            ->rawColumns(['updated_at', 'karat', 'customer', 'cabang', 'action', 'weight'])
            ->make(true);
    }







    public function index_data_sales(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_sales = $this->module_sales;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_sales::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'includes.action',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->karat->label  . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('sales', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->sales->name . '</h3>
                                    </div>';
                return $tb;
            })


            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' . formatBerat($data->weight) . ' Gram</h3>
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
            ->rawColumns(['updated_at', 'sales', 'karat', 'berat_real', 'berat_kotor', 'action', 'weight'])
            ->make(true);
    }




    public function index_data_pending_office(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pending = $this->module_pending;
        $module_pending_office = $this->module_pending_office;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $datas = Product::pendingOffice();

        if (isset($request->karat)) {
            $datas = $datas->whereHas('karat', function ($query) use ($request) {
                $query->where('id', $request->karat);
            });
        }

        $datas = $datas->join('karats as k', 'products.karat_id', '=', 'k.id')
            ->join('categories as c', 'products.category_id', '=', 'c.id')
            ->selectRaw('c.category_name, k.name, COUNT(*) as kuantitas, SUM(products.berat_emas) as total_berat, GROUP_CONCAT(DISTINCT products.product_name SEPARATOR ", ") as products_name')
            ->groupBy('c.category_name', 'k.name')
            ->get();

        return Datatables::of($datas)
            ->addColumn('action',   function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.pending-office.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('name', function ($data) {
                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-gray-800">
                                    ' . $data->name  . '</h3>
                                        </div>';
                return $tb;
            })

            ->editColumn('product', function ($data) {
                $tb = '<div class="items-center text-center">
                            <div class="text-sm font-normal text-gray-800">
                                ' . $data->products_name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                    ' . formatBerat($data->total_berat) . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('kuantitas', function ($data) {
                $tb = '<div class="items-center text-center">
                                                    <h3 class="text-sm font-medium text-gray-800">
                                                    ' . $data->kuantitas . '</h3>
                                                    </div>';
                return $tb;
            })

            ->rawColumns([
                'name',
                'product',
                'weight',
                'kuantitas',
                'action'
            ])
            ->make(true);
    }



    public function show_pending_office($categoryName, $karatName)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $details = Product::join('karats as k', 'products.karat_id', '=', 'k.id')
            ->join('categories as c', 'products.category_id', '=', 'c.id')
            ->where('c.category_name', $categoryName)
            ->where('k.name', $karatName)
            ->where('products.status_id', 4)
            ->select('products.*')
            ->get();
        return view(
            '' . $module_name . '::' . $module_path . '.show',
            compact(
                'module_name',
                'module_action',
                'details',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }

    public function index_data_pending(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pending = $this->module_pending;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $datas = Product::pending();
        if (isset($request->karat)) {
            $datas = $datas->where('karat_id', $request->karat);
        }

        $datas = $datas->get();

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                ' . $data->karat->label  . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('product', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-white "> ' . $data->product_code . '</h3>

                        </div>
                            </div>';
                return $tb;
            })

            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                <h3 class="text-sm font-medium text-gray-800">
                                ' . formatBerat($data->berat_emas) . ' gr</h3>
                                </div>';
                return $tb;
            })

            ->editColumn('image', function ($data) {
                $tb = '<div class="flex justify-center"><a href="' . $data->image_url_path . '" data-lightbox="{{ @$image }} " class="single_image">
                        <img src="' . $data->image_url_path . '" order="0" width="100" class="img-thumbnail"/>
                        </a></div>';
                return $tb;
            })

            ->rawColumns([
                'image',
                'karat',
                'action',
                'product',
                'weight'
            ])
            ->make(true);
    }


    public function get_stock_pending(Request $request)
    {
        $data = Product::pending();
        if (isset($request->karat)) {
            $data = $data->where('karat_id', $request->karat);
        }

        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

    public function get_stock_pending_office(Request $request)
    {
        $data = Product::pendingOffice();
        if (isset($request->karat)) {
            $data = $data->where('karat_id', $request->karat);
        }

        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

    public function get_stock_ready_office(Request $request)
    {
        $data = Product::readyOffice();
        if (isset($request->karat)) {
            $data = $data->where('karat_id', $request->karat);
        }

        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

    public function index_data_office(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_office = $this->module_office;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_office::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view(
                    '' . $module_name . '::' . $module_path . '.gudang-office.aksi',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' . $data->karat->label . '</h3>
                                    </div>';
                return $tb;
            })

            ->editColumn('berat_real', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' . formatBerat($data->berat_real) . ' gram </h3>
                                    </div>';
                return $tb;
            })
            ->editColumn('berat_kotor', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' . formatBerat($data->berat_kotor) . ' gram </h3>
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
            ->rawColumns(['updated_at', 'karat', 'berat_real', 'berat_kotor', 'action'])
            ->make(true);
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
                return view(
                    'includes.action',
                    compact('module_name', 'data', 'module_model')
                );
            })
            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' . $data->weight . '</h3>
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
            ->rawColumns(['updated_at', 'action', 'weight'])
            ->make(true);
    }







    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Create';
        abort_if(Gate::denies('add_' . $module_name . ''), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.create',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'module_icon',
                'module_model'
            )
        );
    }






    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_stok'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $request->validate([
            'name' => 'required|min:3|max:191',
            'description' => 'required|min:3|max:191',
        ]);
        // $params = $request->all();
        //dd($params);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];
        //  if ($image = $request->file('image')) {
        //  $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
        //  $normal = Image::make($image)->resize(600, null, function ($constraint) {
        //             $constraint->aspectRatio();
        //             })->encode();
        //  $normalpath = 'uploads/' . $gambar;
        //  if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
        //  Storage::disk($storage)->put($normalpath, (string) $normal);
        //  $params['image'] = "$gambar";
        // }else{
        //    $params['image'] = 'no_foto.png';
        // }


        $$module_name_singular = $module_model::create($params);
        toast('' . $module_title . ' Created!', 'success');
        return redirect()->route('' . $module_name . '.index');
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
        $validator = \Validator::make($request->all(), [
            'code' => 'required|max:191|unique:' . $module_model . ',code',
            'name' => 'required|max:191',

        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $input['code'] = $input['code'];
        $input['name'] = $input['name'];
        $$module_name_singular = $module_model::create($input);

        return response()->json(['success' => '  ' . $module_title . ' Sukses disimpan.']);
    }










    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
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
        $detail = $module_model::findOrFail($id);
        //dd($detail);
        return view(
            '' . $module_name . '::' . $module_path . '.show',
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



    public function view_pending($id)
    {

        //dd($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_pending = $this->module_pending;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_stock_pending_office'), 403);
        $detail = $module_pending::with('karat', 'cabang')->findOrFail($id);
        //dd($detail);
        return view(
            '' . $module_name . '::' . $module_path . '.modal.view_pending',
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

    public function gudang_office_detail($office)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_office = $this->module_office;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_' . $module_name . ''), 403);
        $detail = $module_office::findOrFail($id);
        return view(
            '' . $module_name . '::' . $module_path . '.gudang-office.detail',
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



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_' . $module_name . ''), 403);
        $detail = $module_model::findOrFail($id);
        return view(
            '' . $module_name . '::' . $module_path . '.edit',
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

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
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
        $request->validate([
            'name' => 'required|min:3|max:191',
        ]);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];

        // if ($image = $request->file('image')) {
        //                if ($$module_name_singular->image !== 'no_foto.png') {
        //                    @unlink(imageUrl() . $$module_name_singular->image);
        //                  }
        //   $gambar = 'category_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
        //   $normal = Image::make($image)->resize(1000, null, function ($constraint) {
        //              $constraint->aspectRatio();
        //              })->encode();
        //   $normalpath = 'uploads/' . $gambar;
        //  if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
        //   Storage::disk($storage)->put($normalpath, (string) $normal);
        //   $params['image'] = "$gambar";
        //  }else{
        //      unset($params['image']);
        //  }
        $$module_name_singular->update($params);
        toast('' . $module_title . ' Updated!', 'success');
        return redirect()->route('' . $module_name . '.index');
    }




    //update ajax version
    public function update_ajax(Request $request, $id)
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
                'code' => [
                    'required',
                    'unique:' . $module_model . ',code,' . $id
                ],
                'name' => 'required|max:191',


            ]
        );

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $params['code'] = $params['code'];
        $params['name'] = $params['name'];
        $$module_name_singular->update($params);
        return response()->json(['success' => '  ' . $module_title . ' Sukses diupdate.']);
    }



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

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
            toast('' . $module_title . ' Deleted!', 'success');
            return redirect()->route('' . $module_name . '.index');
        } catch (\Exception $e) {
            // dd($e);
            toast('' . $module_title . ' error!', 'warning');
            return redirect()->back();
        }
    }

    public function lantakanApiStore(Request $request)
    {
        $data = $request->all();
        $response = [
            'status' => 200,
            'message' => 'success',
        ];
        try {
            DB::beginTransaction();
            if (!empty($data['weight'])) {
                $id_karat = LookUp::select('value')->where('kode', 'id_karat_emas_24k')->first();

                $data['karat_id'] =  !empty($id_karat['value']) ? $id_karat['value'] : 0;
                $additional_data = !empty($data['additional_data']) ? $data['additional_data'] : [];
                $data['additional_data'] = json_encode($additional_data);
                $penerimaan_lantakan = PenerimaanLantakan::create($data);
                $stok_lantakan = $this->model_lantakan::where('karat_id', $data['karat_id'])->first();
                if ($stok_lantakan) {
                    if (!empty($data['additional_data'])) {
                        $stok_lantakan->additional_data = $data['additional_data'];
                    }

                    $penerimaan_lantakan->stock_kroom()->attach($stok_lantakan->id, [
                        'karat_id' => $data['karat_id'],
                        'in' => true,
                        'berat_real' => $data['weight'],
                        'berat_kotor' => $data['weight']
                    ]);

                    // $berat_real = $stok_lantakan->history->sum('berat_real');
                    // $stok_lantakan->update(['weight'=> $berat_real]);

                    $stok_lantakan->weight += $data['weight'];
                    $stok_lantakan->save();
                } else {
                    $this->model_lantakan::create($data);
                }
            } else {
                $response = [
                    'status' => 402,
                    'message' => 'params weight is required',
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 500,
                'message' => "Something wrong " . $e->getMessage(),
            ];
        }
        DB::commit();
        return response()->json($response);
    }


    public function ready()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $karat_ids = Product::ready()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $dataCabang = Cabang::all();
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
        ]);
        $module_action = 'Ready Cabang';
        abort_if(Gate::denies('show_stock_ready_cabang'), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.index_ready',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'datakarat',
                'product_status',
                'dataCabang',
                'module_icon',
                'module_model'
            )
        );
    }

    public function berlian_ready()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $karat_ids = Product::ready()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $kategori_produk_berlian =  LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');
        $berlian_kategori = Category::select('id')->where('kategori_produk_id', $kategori_produk_berlian)->get()->groupBy('id')->keys()->toArray();
        $dataCabang = Cabang::all();
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
        ]);
        $module_action = 'Ready Cabang';
        abort_if(Gate::denies('show_stock_ready_cabang'), 403);
        return view(
            '' . $module_name . '::' . $module_path . '.page.berlian.index_ready',
            compact(
                'module_name',
                'module_action',
                'module_title',
                'datakarat',
                'berlian_kategori',
                'product_status',
                'dataCabang',
                'module_icon',
                'module_model'
            )
        );
    }



    public function index_data_ready(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pending = $this->module_pending;
        $module_pending_office = $this->module_pending_office;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        /** untuk keperluan nampilkan berlian */
        $categories = [];
        if (!empty(json_decode($request->get('catagories')))) {
            $categories = json_decode($request->get('catagories'));
        }

        $datas = Product::ready()
            ->when(!empty($request->karat), function (Builder $query) use ($request) {
                $query->where('karat_id', $request->karat);
            })
            ->when(!empty($request->cabang), function (Builder $query) use ($request) {
                if ($request->cabang !== 'undefined') {
                    $query->where('cabang_id', $request->cabang);
                }
            })
            ->when(!empty($categories), function (Builder $query) use ($categories) {
                $query->whereIn('category_id', $categories);
            });

        $datas = $datas->get();
        return Datatables::of($datas)
            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-gray-800">
                                    ' . $data->karat?->label  . '</h3>
                                        </div>';
                return $tb;
            })

            ->editColumn('product', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                            <div>
                            <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                                ' . $data->category?->category_name . '</div>
                                <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                                <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_code . '</h3>


                            </div>
                                </div>';
                return $tb;
            })

            ->editColumn('weight', function ($data) {
                $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                    ' . formatBerat($data->berat_emas) . ' gr</h3>
                                    </div>';
                return $tb;
            })
            ->editColumn('cabang', function ($data) {
                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-gray-800">
                                        ' . $data->cabang?->name . '</h3>
                                        </div>';
                return $tb;
            })

            ->editColumn('image', function ($data) {
                $tb = '<div class="flex justify-center"><a href="' . $data->image_url_path . '" data-lightbox="{{ @$image }} " class="single_image">
                            <img src="' . $data->image_url_path . '" order="0" width="100" class="img-thumbnail"/>
                            </a></div>';
                return $tb;
            })

            ->rawColumns([
                'image',
                'karat',
                'cabang',
                'product',
                'weight'
            ])
            ->make(true);
    }

    public function get_stock_ready(Request $request)
    {
        $data = Product::ready();
        if (isset($request->karat)) {
            $data = $data->where('karat_id', $request->karat);
        }
        if (isset($request->cabang) && $request->cabang !== 'undefined') {
            $data = $data->where('cabang_id', $request->cabang);
        }

        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => Karat::find($request->karat)->label,
        ]);
    }
}
