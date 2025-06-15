<?php



namespace Modules\Product\Http\Controllers\Proses;
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
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Karat\Models\Karat;
use Modules\Product\Models\ProductStatus;

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

    public function cuci(){
        $karat_ids = Product::cuci()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
            ProductStatus::READY_OFFICE
        ]);
        $add_data = [
            'status_id_ready_office' => ProductStatus::READY_OFFICE,
        ];
        abort_if(Gate::denies('show_proses_cuci'), 403);
            return view('product::products.page.process.cuci',
            compact(
            'datakarat',
            'add_data',
            'product_status'));
    }

    public function get_cuci(Request $request)
    {
        $data = Product::cuci();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        $data = $data->get();
        return Datatables::of($data)
                        ->addColumn('action', function ($data) {
                            return view('product::products.process.action',
                            compact('data'));
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
                                ' .$data->berat_emas . ' gr</h3>
                                </div>';
                            return $tb;
                        }) 
                        ->editColumn('image', function ($data) {
                        $tb = '<div class="flex justify-center"><a href="'.$data->image_url_path.'" data-lightbox="{{ @$image }} " class="single_image">
                        <img src="'.$data->image_url_path.'" order="0" width="100" class="img-thumbnail"/>
                        </a></div>';
                            return $tb;
                        })
                        ->rawColumns([
                                'image', 
                                'karat',
                                'action', 
                                'product', 
                                'weight'])
                        ->make(true);
    }

    public function masak(){
        $karat_ids = Product::masak()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
            ProductStatus::READY_OFFICE
        ]);
        $add_data = [
            'status_id_ready_office' => ProductStatus::READY_OFFICE,
        ];
        abort_if(Gate::denies('show_proses_masak'), 403);
            return view('product::products.page.process.masak',
            compact(
            'datakarat',
            'add_data',
            'product_status'));
    }

    public function get_masak(Request $request)
    {
        $data = Product::masak();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        $data = $data->get();
        return Datatables::of($data)
                        ->addColumn('action', function ($data) {
                            return view('product::products.process.action',
                            compact('data'));
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
                                ' .$data->berat_emas . ' gr</h3>
                                </div>';
                            return $tb;
                        }) 
                        ->editColumn('image', function ($data) {
                        $tb = '<div class="flex justify-center"><a href="'.$data->image_url_path.'" data-lightbox="{{ @$image }} " class="single_image">
                        <img src="'.$data->image_url_path.'" order="0" width="100" class="img-thumbnail"/>
                        </a></div>';
                            return $tb;
                        })
                        ->rawColumns([
                                'image', 
                                'karat',
                                'action', 
                                'product', 
                                'weight'])
                        ->make(true);
    }

    public function rongsok(){
        $karat_ids = Product::rongsok()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
            ProductStatus::READY_OFFICE
        ]);
        $add_data = [
            'status_id_ready_office' => ProductStatus::READY_OFFICE,
        ];
        abort_if(Gate::denies('show_proses_rongsok'), 403);
            return view('product::products.page.process.rongsok',
            compact(
            'datakarat',
            'add_data',
            'product_status'));
    }

    public function get_rongsok(Request $request)
    {
        $data = Product::rongsok();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        $data = $data->get();
        return Datatables::of($data)
                        ->addColumn('action', function ($data) {
                            return view('product::products.process.action',
                            compact('data'));
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
                                ' .$data->berat_emas . ' gr</h3>
                                </div>';
                            return $tb;
                        }) 
                        ->editColumn('image', function ($data) {
                        $tb = '<div class="flex justify-center"><a href="'.$data->image_url_path.'" data-lightbox="{{ @$image }} " class="single_image">
                        <img src="'.$data->image_url_path.'" order="0" width="100" class="img-thumbnail"/>
                        </a></div>';
                            return $tb;
                        })
                        ->rawColumns([
                                'image', 
                                'karat',
                                'action', 
                                'product', 
                                'weight'])
                        ->make(true);
    }

    public function reparasi(){
        $karat_ids = Product::reparasi()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::SECOND,
            ProductStatus::READY_OFFICE
        ]);
        $add_data = [
            'status_id_ready_office' => ProductStatus::READY_OFFICE,
        ];
        abort_if(Gate::denies('show_proses_reparasi'), 403);
            return view('product::products.page.process.reparasi',
            compact(
            'datakarat',
            'add_data',
            'product_status'));
    }

    public function get_reparasi(Request $request)
    {
        $data = Product::reparasi();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        $data = $data->get();
        return Datatables::of($data)
                        ->addColumn('action', function ($data) {
                            return view('product::products.process.action',
                            compact('data'));
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
                                ' .$data->berat_emas . ' gr</h3>
                                </div>';
                            return $tb;
                        }) 
                        ->editColumn('image', function ($data) {
                        $tb = '<div class="flex justify-center"><a href="'.$data->image_url_path.'" data-lightbox="{{ @$image }} " class="single_image">
                        <img src="'.$data->image_url_path.'" order="0" width="100" class="img-thumbnail"/>
                        </a></div>';
                            return $tb;
                        })
                        ->rawColumns([
                                'image', 
                                'karat',
                                'action', 
                                'product', 
                                'weight'])
                        ->make(true);
    }

    public function second(){
        $karat_ids = Product::second()->get()->groupBy('karat_id')->keys()->toArray();
        $datakarat = Karat::find($karat_ids);
        $product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::READY_OFFICE
        ]);
        $add_data = [
            'status_id_ready_office' => ProductStatus::READY_OFFICE,
        ];
        abort_if(Gate::denies('show_proses_second'), 403);
            return view('product::products.page.process.second',
            compact(
            'datakarat',
            'add_data',
            'product_status'));
    }

    public function get_second(Request $request)
    {
        $data = Product::second();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        $data = $data->get();
        return Datatables::of($data)
                        ->addColumn('action', function ($data) {
                            return view('product::products.process.action',
                            compact('data'));
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
                                ' .$data->berat_emas . ' gr</h3>
                                </div>';
                            return $tb;
                        }) 
                        ->editColumn('image', function ($data) {
                        $tb = '<div class="flex justify-center"><a href="'.$data->image_url_path.'" data-lightbox="{{ @$image }} " class="single_image">
                        <img src="'.$data->image_url_path.'" order="0" width="100" class="img-thumbnail"/>
                        </a></div>';
                            return $tb;
                        })
                        ->rawColumns([
                                'image', 
                                'karat',
                                'action', 
                                'product', 
                                'weight'])
                        ->make(true);
    }



    public function update_status(Request $request)
    {
        $model = Product::findOrFail($request->data_id);
        try {
            $model->updateTracking($request->status_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Status Berhasil Diupdate'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }

    }

    public function get_stock_cuci(Request $request){
        $data = Product::cuci();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        
        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

    public function get_stock_masak(Request $request){
        $data = Product::masak();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        
        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

    public function get_stock_reparasi(Request $request){
        $data = Product::reparasi();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        
        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

    public function get_stock_second(Request $request){
        $data = Product::second();
        if(isset($request->karat)){
            $data = $data->where('karat_id',$request->karat);
        }
        
        $data = $data->get();
        return response()->json([
            'sisa_stok' => $data->sum('berat_emas'),
            'karat' => $data->first()->karat->label,
        ]);
    }

}
