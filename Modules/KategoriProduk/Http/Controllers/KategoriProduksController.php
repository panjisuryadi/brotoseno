<?php

namespace Modules\KategoriProduk\Http\Controllers;
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
use Modules\Product\Entities\Category;
class KategoriProduksController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Main Kategori';
        $this->module_name = 'kategoriproduk';
        $this->module_path = 'kategoriproduks';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\KategoriProduk\Models\KategoriProduk";
        $this->module_categories = "Modules\Product\Entities\Category";

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

  public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
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

        $$module_name = $module_model::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })

                            ->addColumn('image', function ($data) {
                                $module_path = $this->module_path;
                                 $module_name = $this->module_name;
                  
                               return view(''.$module_name.'::'.$module_path.'.image',
                                compact('module_name', 'data'));
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
                        ->rawColumns(['updated_at', 'action'])
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
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.modal.create',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }




    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
         abort_if(Gate::denies('create_kategoriproduk'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        // $request->validate([
        //      'name' => 'required|min:3|max:191|unique:kategoriproduks,name',
        //      'description' => 'required|min:3|max:191',
        //  ], ['name.unique' => 'Nama kategori sudah ada.',]
        // );
        $validator = \Validator::make($request->all(),[
            'name' => 'required|min:3|max:191|unique:kategoriproduks,name',
            'description' => 'required|min:3|max:191',
        ]);

           
        if (!$validator->passes()) {
           return response()->json(['error'=>$validator->errors()]);
       }

       // $params = $request->all();
        //dd($params);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['slug']  = Str::slug($params['name']);
        $params['description'] = $params['description'];
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
        //  toast(''. $module_title.' Created!', 'success');
         return response()->json(['success'=>'  '.$module_title.' Berhasil ditambahkan.']);

         return redirect()->route(''.$module_name.'.index');
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
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

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
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.modal.edit',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));
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
        $params['slug']  = Str::slug($params['name']);
        $params['description'] = $params['description'];



      if ($image = $request->file('image')) {
                      if ($$module_name_singular->image !== 'no_foto.png') {
                          @unlink(imageUrl() . $$module_name_singular->image);
                        }
         $gambar = 'category_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
         $normal = Image::make($image)->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();
         $normalpath = 'uploads/' . $gambar;
         Storage::disk('public')->put($normalpath, (string) $normal);
         $params['image'] = "$gambar";
        }else{
            unset($params['image']);
        }
           //dd($params);
        $$module_name_singular->update($params);
         return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);


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
        $Category = Category::where('kategori_produk_id',$id)->get();

        if ($Category->isNotEmpty()) {
           toast('Can\'t delete  category !', 'error');
            return back();
        }
          if ($$module_name_singular->image !== 'no_foto.png') {
               @unlink(imageUrl() . $$module_name_singular->image);
            }

         $$module_name_singular->delete();
         toast(''. $module_title.' Deleted!', 'success');
         return redirect()->route(''.$module_name.'.index');

          } catch (\Exception $e) {
           // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

    }


   public function view_kategori($id)
    {
        $id = decode_id($id);
        //dd($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_categories = $this->module_categories;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $main = $module_model::findOrFail($id);
        $category = $module_categories::where('kategori_produk_id',$main->id)->get();
       // dd($category);
          return view('product::categories.page.create',
           compact('module_name',
            'module_action',
            'main',
            'category',
            'module_title',
            'module_icon', 'module_model'));

           }




}
