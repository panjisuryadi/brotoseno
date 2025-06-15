<?php

namespace Modules\Karat\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Karat\Models\Karat;
use App\Models\Harga;
use Modules\PenentuanHarga\Models\PenentuanHarga;

class KaratsController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Karat';
        $this->module_name = 'karat';
        $this->harga = 913271;
        $this->module_path = 'karats';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Karat\Models\Karat";
      

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

        $$module_name = $module_model::latest()->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                    ->addColumn('action', function ($data) {
                       $module_name = $this->module_name;
                        $module_model = $this->module_model;
                        $module_path = $this->module_path;
                        return view($module_name.'::'.$module_path.'.includes.action',
                        compact('module_name', 'data', 'module_model'));
                            })
                         
                        ->editColumn('karat', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .$data->label . '</h3>
                                    </div>';
                             })  

                ->editColumn('type', function($data){
                            $output = '';
                            if(is_null($data->type)){
                 $output = ($data->parent?->type == 'LM')?'<span class="text-sm font-medium text-yellow-700">Logam Mulia</span>':'<span class="text-sm font-medium text-green-700">Perhiasan</span>';
                            }else{
                 $output = ($data->type == 'LM')?'<span class="text-sm font-medium text-yellow-700">Logam Mulia</span>':'<span class="text-sm font-medium text-green-700">Perhiasan</span>';
                            }
                       return '<div class="items-center text-center">' .$output . '</div>';
                        }) 
                      ->editColumn('coef', function($data){
                            $output = '';
                          
                        return '<div class="items-center text-center">
                                            <span class="text-sm font-medium text-gray-800"> ' .$data->coef . '</span>
                                    </div>';

                        })   
                      ->editColumn('ph', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->penentuanharga->harga_emas) . '
                             </div>';

                        })
                        ->rawColumns(['karat', 'action','coef','type','ph'])
                        ->make(true);
    }

public function index_data_2()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = $module_model::latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        
        $data = $$module_name;
        return Datatables::of($$module_name)
                    ->addColumn('action', function ($data) {
                       $module_name = $this->module_name;
                        $module_model = $this->module_model;
                        $module_path = $this->module_path;
                        $harga = 1000000;
                        return view($module_name.'::'.$module_path.'.includes.action',
                        compact('module_name', 'data', 'module_model'));
                            })
                         
                        ->editColumn('karat', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .$data->label . '</h3>
                                    </div>';
                             })  

                ->editColumn('type', function($data){
                            $output = '';
                            if(is_null($data->type)){
                 $output = ($data->parent?->type == 'LM')?'<span class="text-sm font-medium text-yellow-700">Logam Mulia</span>':'<span class="text-sm font-medium text-green-700">Perhiasan</span>';
                            }else{
                 $output = ($data->type == 'LM')?'<span class="text-sm font-medium text-yellow-700">Logam Mulia</span>':'<span class="text-sm font-medium text-green-700">Perhiasan</span>';
                            }
                       return '<div class="items-center text-center">' .$output . '</div>';
                        }) 
                      ->editColumn('coef', function($data){
                            $output = '';
                          
                        return '<div class="items-center text-center">
                                            <span class="text-sm font-medium text-gray-800"> ' .$data->coef . '</span>
                                    </div>';

                        })   
                      ->editColumn('ph', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->penentuanharga->harga_emas) . '
                             </div>';

                        })
                        ->editColumn('harga', function($data){
                            $output = '';
                          
                            return '<div class="items-center font-semibold text-center">
                             ' .rupiah(@$data->coef*@$data->harga) . '
                             </div>';

                        })
                        ->rawColumns(['karat', 'action','coef','type','ph', 'harga'])
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
              return view(''.$module_name.'::'.$module_path.'.create',
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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(),[
            
             'name' => 'required|max:191',
             'kode' => 'required',
             'coef' => 'required',
             'type' => 'required'

        ]);
        // if (!$validator->passes()) {
        //   return response()->json(['error'=>$validator->errors()]);
        // }

        $input = $request->all();
        $input = $request->except('_token');
        $$module_name_singular = $module_model::create($input);

        // return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
        activity()->log(' '.auth()->user()->name.' input data pembelian');
         
        toast(''. $module_title.' Created!', 'success');
        // return redirect()->route(''.$module_name.'.index');
        return redirect()->route('karats.list');
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

    public function edit_diskon($id)
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
          return view(''.$module_name.'::'.$module_path.'.modal.diskon',
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
           
            'name' => 'required|max:191',


        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
       // dd($input);
        $params = $request->except('_token');
        $params['kode'] = $params['kode'];
        $params['name'] = $params['name'];
        $params['type'] = $params['type'];
        $params['coef'] = $params['coef'];
        $$module_name_singular->update($params);

         $pharga = PenentuanHarga::updateOrCreate([
            'karat_id'   => $$module_name_singular->id,
         ],[
            'user_id'      => auth()->user()->id,
            'margin'       => '0',
            'tgl_update'   => date('Y-m-d'),
            'harga_modal'  => '0',
            'harga_emas'   => '0',
            'harga_jual'   => '0',
            'lock'         => '0',
             ]);

        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

 }

 public function update_coef(Request $request, Karat $data)
    {
        $validator = \Validator::make($request->all(),[
            'coef' => 'required|numeric',
        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }
        $coef = $request->input('coef');
        $margin = $request->input('margin');
        $name = $request->input('name');
        $kode = $request->input('kode');
        $data->coef = $coef;
        $data->persen = $margin;
        $data->name = $name;
        $data->kode = $kode;
        $data->save();
        if(empty($data->parent_id)){
            // $dataKarat = [
            //     'karat_id' => $data->parent_id,
            //     'user_id' => auth()->id(),
            //     'tgl_update' => now(),
            //     'harga_emas' => 0,
            //     'harga_modal' => 0,
            //     'margin' => 0,
            //     'harga_jual' => 0
            // ];
            
            // $penentuan_harga = PenentuanHarga::where('karat_id', $data->id)->first();
            // if(!$penentuan_harga){
            //     $penentuan_harga = $data->penentuanHarga()->create($dataKarat);
            //     $dataKarat['karat_id'] = $data->id;
            //     $dataKarat['updated'] = 1;
            //     $dataKarat['created_by'] = auth()->user()->name;
            //     unset($dataKarat['tgl_update']);
            //     $dataKarat['tanggal'] = now();
            //     $penentuan_harga->history()->create($dataKarat);
            // }
        }
        return response()->json(['success'=>'Karat Sukses diupdate.']);
 }

 public function update_diskon(Request $request, Karat $data)
    {
        $validator = \Validator::make($request->all(),[
            'coef' => 'required|numeric',
        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }
        $diskon = $request->input('diskon');
        $data->diskon = $diskon;
        $data->save();
        if(empty($data->parent_id)){
            $dataKarat = [
                'karat_id' => $data->parent_id,
                'user_id' => auth()->id(),
                'tgl_update' => now(),
                'harga_emas' => 0,
                'harga_modal' => 0,
                'margin' => 0,
                'harga_jual' => 0
            ];
            
            $penentuan_harga = PenentuanHarga::where('karat_id', $data->id)->first();
            if(!$penentuan_harga){
                $penentuan_harga = $data->penentuanHarga()->create($dataKarat);
                $dataKarat['karat_id'] = $data->id;
                $dataKarat['updated'] = 1;
                $dataKarat['created_by'] = auth()->user()->name;
                unset($dataKarat['tgl_update']);
                $dataKarat['tanggal'] = now();
                $penentuan_harga->history()->create($dataKarat);
            }
        }
        return response()->json(['success'=>'Diskon Sukses diupdate.']);
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
         toast(''. $module_title.' Deleted!', 'success');
         return redirect()->route(''.$module_name.'.index');

          } catch (\Exception $e) {
           // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

         }


   public function getNumberVal($value) {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }




}
