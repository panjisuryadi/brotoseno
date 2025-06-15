<?php
namespace Modules\User\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\User\DataTables\RolesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Models\Permissions;
class PermissionController extends Controller
{

      public function __construct()
    {
        // Page Title
        $this->module_title = 'Data Permission';
        $this->module_name = 'Permissions';
        $this->module_path = 'permissions';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "App\Models\Permissions";

    }




   public function index()
    {
        abort_if(Gate::denies('access_user_management'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        //  $default_perm =  ['admin telkomsel'];
        // if ($company == '2') {
        //   $default_perm =  ['admin telkom','admin telkomsel'];
        // }

        $$module_name = $module_model::with('permissions')
       //->whereNotIn('name',$default_perm)
        ->orderBy('id', 'ASC')
        ->paginate();
        return view(
            "user::permissions.index",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_path',
             'module_name_singular', 'module_action')
        );
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
                            return view('user::permissions.partials.actions',
                            compact('module_name', 'data', 'module_model'));
                                })

                           ->editColumn('name', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">' . Label_case($data->name) . '</div>';
                                return $tb;
                            })

                               ->editColumn('value', function ($data) {
                                $tb = '<div class="items-center text-center">' . $data->name. '</div>';
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
                        ->rawColumns(['updated_at', 'name', 'value', 'action'])
                        ->make(true);
    }







 public function create()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            abort_if(Gate::denies('access_user_management'), 403);
              return view('user::permissions.modal.create',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }



 public function addSingle()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            abort_if(Gate::denies('access_user_management'), 403);
              return view('user::permissions.modal.single',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }





public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        abort_if(Gate::denies('access_user_management'), 403);
         $validator = \Validator::make($request->all(),[
             'name' => 'required|string|max:100|unique:permissions,name',

        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input['name'] = $input['name'];
        $input = $request->except('_token');
        $name  = strip_tags($input['name']);
        Permissions::firstOrCreate(['name' => 'access_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'create_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'show_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'edit_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'delete_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'print_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'reject_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'approve_'.$name.'']);
        Permissions::firstOrCreate(['name' => 'dashboard_'.$name.'']);


        return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
    }


public function single(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        abort_if(Gate::denies('access_user_management'), 403);
         $validator = \Validator::make($request->all(),[
             'name' => 'required|string|max:100|unique:permissions,name',

        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $pname = $input['type'].$input['name'];
        //dd($name);
        
        $input = $request->except('_token');
        $permissionsname  = strip_tags($pname);
        Permissions::firstOrCreate(['name' => $permissionsname]);
            return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
    }













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
          return view('user::'.$module_path.'.modal.edit',
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
        $validator = \Validator::make($request->all(),[
             'name' => 'required|max:191',
        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        $namep = $input['type'].$input['name'];
        //dd($name);
        $input['name'] = strip_tags($namep);
       // dd($input);
        $$module_name_singular->update($input);
        return response()->json(['success'=>'  '.$module_title.'  Sukses diupdate.']);

           }


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
