<?php

namespace Modules\DataSale\Http\Controllers;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\DataSale\Models\Insentif;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Lang;
use Image;
use Modules\DataSale\Models\DataSale;

class DataSalesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Data Sales';
        $this->module_name = 'datasale';
        $this->module_path = 'datasales';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\DataSale\Models\DataSale";

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
                            return view(''.$module_name.'::'.$module_path.
                            '.includes.action',
                            compact('module_name', 'data', 'module_model'));
                        })
                          ->editColumn('name', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data['name'] . '</h3>
                                    </div>';
                                return $tb;
                            })
                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data['updated_at']);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data['updated_at'])->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data['updated_at'])->isoFormat('L');
                            }
                        })
                        ->rawColumns(['name','updated_at'])
                        ->make(true);
                     }

protected function fetch(){
        $token = config($this->module_name . '.sales_api.token');
        $baseUrl = config($this->module_name . '.sales_api.base_url');
    
        $response = Http::withHeaders(['token' => $token])->get($baseUrl);
    
        if($response->successful()) {
            $sales_list = $response->json();
    
            if(isset($sales_list['data']) && is_array($sales_list['data'])) {
                foreach($sales_list['data'] as $sales){
                    $this->module_model::updateOrCreate(
                        ['id' => $sales['id']], 
                        [
                            'name' => $sales['first_name'] . ' ' . $sales['last_name'], 
                            'address' => $sales['address'], 
                            'phone' => $sales['contact_no'], 
                            'created_at' => $sales['created_at'], 
                            'updated_at' => $sales['updated_at']
                        ]
                    );
                }
            } 
        } 
    
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




//store ajax version

public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(),[
             'phone' => 'required|max:191|unique:'.$module_model.',phone',
             'name' => 'required|max:191',

        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        $input['address'] = $input['address'];
        $input['phone'] = $input['phone'];
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


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
       // abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }

    public function show_data(DataSale $detail){
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $$module_name = $detail->penjualanSale;

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.
                            '.includes.action',
                            compact('module_name', 'data', 'module_model'));
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
                        ->editColumn('date', function ($data) {
                            $module_name = $this->module_name;
                            return \Carbon\Carbon::parse($data->updated_at)->format('j F Y');
                        })
                        ->editColumn('total_weight', function ($data) {
                            return $data->detail->sum('weight') . " gram";
                            })
                        ->editColumn('total_nominal', function ($data) {
                            return "Rp.".$data->detail->sum('nominal');
                            })
                        ->rawColumns(['updated_at', 
                             'action', 
                             'name',
                             'date',
                             'total_weight',
                             'total_nominal'
                        ])
                        ->make(true);
    }


    public function show_stock(DataSale $detail){
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $$module_name = $detail->stockSales;

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.
                            '.includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          
                        ->editColumn('berat', function ($data) {
                            return $data->weight . " gram";
                            })
                        ->editColumn('karat', function ($data) {
                            return $data->karat?->label;
                            })
                        ->rawColumns([ 
                             'action', 
                             'karat',
                             'berat'
                        ])
                        ->make(true);
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
          return view(''.$module_name.'::'.$module_path.'.edit',
           compact('module_name',
            'module_action',
            'module_path',
            'detail',
            'module_title',
            'module_icon', 'module_model'));
    }


    public function edit_insentif($id)
    {

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit Insentif';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        return view(''.$module_name.'::'.$module_path.'.modal.insentif',
               compact('module_name',
                'detail',
                'module_action',
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
        
        $validated = $request->validate([
            'target' => 'gt:0',
            'insentif' => 'gt:0'
        ]);

        if(isset($validated['target'])){
            $$module_name_singular->update([
                'target' => $validated['target']
            ]);
        }

        if(isset($validated['insentif'])){
            Insentif::updateOrCreate([
                'sales_id' => $$module_name_singular->id
            ],[
                'nominal' => $validated['insentif'],
                'date' => now()
            ]);
        }
        toast(''. $module_title.' Data Berhasil di update!', 'success');
         return redirect()->route(''.$module_name.'.index');
 }


 public function update_json(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make($request->all(),[
            'target' => 'gt:0',
            'insentif' => 'gt:0'

        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        if(isset($validator['target'])){
            $$module_name_singular->update([
                'target' => $validator['target']
            ]);
        }

        if(isset($validator['insentif'])){
            Insentif::updateOrCreate([
                'sales_id' => $$module_name_singular->id
            ],[
                'nominal' => $validator['insentif'],
                'date' => now()
            ]);
        }
        

        return response()->json(['success'=>'  '.$module_title.' Sukses diUpdate.']);
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

    public function updateincentive(Request $request){
        $date = Date('Y-m-d',strtotime($request->date.'-01'));
        $model = Insentif::where('date',$date)->where('sales_id',$request->sale_id)->first();
        if(empty($model)){
            $model = new Insentif;
        }
        try {
            $model->sales_id = $request->sale_id;
            $model->date = $date;
            $model->nominal = $request->nominal;
            if($model->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Insentif Berhasil Disimpan'
                ]);
            }   
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updatetarget(Request $request){
        $model = DataSale::find($request->sale_id);
        if(empty($model)){
            return response()->json([
                'status' => 'error',
                'message' => 'Sales Not Found'
            ]);
        }
        try {
            $model->target = $request->target;
            if($model->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Target Berhasil Disimpan'
                ]);
            }   
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

}
