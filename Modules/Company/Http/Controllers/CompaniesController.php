<?php

namespace Modules\Company\Http\Controllers;
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
use App\Models\ActivityLog;
class CompaniesController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Company';
        $this->module_name = 'company';
        $this->module_path = 'companies';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Company\Models\Company";

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

        $$module_name = $module_model::with('user')->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })


                          ->editColumn('name', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->name . '</h3>
                                    </div>';
                                return $tb;
                            })

                              ->editColumn('user', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->user->name . '</h3>
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
                        ->rawColumns(['updated_at', 'action','user', 'name'])
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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(),[
             'user_id' => 'required|max:191|unique:'.$module_model.',user_id',
             'name' => 'required|max:191',

        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        $input['user_id'] = $input['user_id'];
        $input['name'] = $input['name'];
        $$module_name_singular = $module_model::create($input);
        activity()->log(' '.auth()->user()->name.' Menambahkan Company ');
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
            'user_id' => [
                'required',
                'unique:'.$module_model.',user_id,'.$id
            ],
            'name' => 'required|max:191',
                ],[
                'user_id.unique'=> 'User tidak boleh double',
               ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        $params['user_id'] = $params['user_id'];
        $params['name'] = $params['name'];
        $$module_name_singular->update($params);
         activity()->log(' '.auth()->user()->name.' Mengubah Company ');
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

        $$module_name_singular->delete();
         toast(''. $module_title.' Deleted!', 'success');
         return redirect()->route(''.$module_name.'.index');

          } catch (\Exception $e) {
           // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

    }

}
