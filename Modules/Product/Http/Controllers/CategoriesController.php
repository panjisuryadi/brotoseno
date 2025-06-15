<?php

namespace Modules\Product\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\DataTables\ProductCategoriesDataTable;
use Modules\KategoriProduk\Models\KategoriProduk;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Image;
class CategoriesController extends Controller
{



public function __construct()
    {
        // Page Title
        $this->module_title = 'Product Category';

        // module name
        $this->module_name = 'categories';

        // directory path of the module
        $this->module_path = 'categories';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Product\Entities\Category";


    }
  public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_product_categories'), 403);
         return view('product::categories.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


    public function index_data_table(ProductCategoriesDataTable $dataTable) {
        abort_if(Gate::denies('access_product_categories'), 403);

        return $dataTable->render('product::categories.index');
    }



public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';


        $$module_name = $module_model::with('kategoriproduk')
        ->withCount('products')->latest()->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('product::categories.partials.actions',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->addColumn('image', function ($data) {
                               return view('product::categories.partials.image', compact('data'));
                            })
                             ->editColumn('products_count', function ($data) {
                                $tb = '<div class="items-center small text-center">
                                <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
                                ' . $data->products_count . '</span></div>';
                                return $tb;
                            })
                                 ->editColumn('category_name', function ($data) {
                                    $tb = '<div class="flex items-center gap-x-2">
                                            <div>
                                      <span class="px-2 rounded rounded-lg bg-green-200 small font-normal text-gray-600 dark:text-gray-400"> ' . $data->kategoriProduk->name . '</span>
                                   <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->category_name . '</h3>
                                    <div class="text-xs font-normal text-red-600 dark:text-gray-400"> ' . $data->category_code . '</div>

                                            </div>
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
                        ->rawColumns(['updated_at','image','category_name','products_count', 'action'])
                        ->make(true);
    }




    public function store(Request $request) {
        abort_if(Gate::denies('access_product_categories'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        $request->validate([
            'category_code' => 'required|unique:categories,category_code',
            'category_name' => 'required'
        ]);
        $params = $request->except('_token');
        $params['category_code'] = $params['category_code'];
        $params['category_name'] = $params['category_name'];
        $params['slug']          = Str::slug($params['category_name']);
        $params['kategori_produk_id'] = $params['kategori_produk_id'];

          if ($image = $request->file('image')) {
         $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
         $normal = Image::make($image)->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();
         $normalpath = 'uploads/' . $gambar;
         if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
         Storage::disk($storage)->put($normalpath, (string) $normal);
         $params['image'] = "$gambar";
        }else{
           $params['image'] = 'no_foto.png';
        }
         $$module_name_singular = $module_model::create($params);
         toast(''. $module_title.' Created!', 'success');

           return redirect()->back();
    }


    public function edit($id) {
        abort_if(Gate::denies('access_product_categories'), 403);

        $category = Category::findOrFail($id);

        return view('product::categories.edit', compact('category'));
    }



    public function update(Request $request, $id) {
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
            'category_code' => 'required|unique:categories,category_code,' . $id,
            'category_name' => 'required'
        ]);
        $params = $request->except('_token');
        $params['category_code'] = $params['category_code'];
        $params['category_name'] = $params['category_name'];
        $params['slug']          = Str::slug($params['category_name']);
        $params['kategori_produk_id'] = $params['kategori_produk_id'];
       if ($image = $request->file('image')) {
                      if ($$module_name_singular->image !== 'no_foto.png') {
                          @unlink(imageUrl() . $$module_name_singular->image);
                        }
         $gambar = 'category_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
         $normal = Image::make($image)->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();


         $normalpath = 'uploads/' . $gambar;
        if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
         Storage::disk($storage)->put($normalpath, (string) $normal);
         $params['image'] = "$gambar";
        }else{
            unset($params['image']);
        }
        // dd($params);
        $$module_name_singular->update($params);
          toast(''. $module_title.' Updated!', 'success');

        return redirect()->route('product-categories.index');
    }


    public function destroy($id) {
        abort_if(Gate::denies('access_product_categories'), 403);
        $category = Category::findOrFail($id);
        $produk = Product::where('category_id',$id)->get();

        if ($produk->isNotEmpty()) {
            return back()->withErrors('Can\'t delete beacuse there are products associated with this category.');
        }
              if ($category->image !== 'no_foto.png') {
                   @unlink(imageUrl() . $category->image);
                }
        $category->delete();

        toast('Product Category Deleted!', 'warning');
        return redirect()->route('product-categories.index');
    }










    
}
