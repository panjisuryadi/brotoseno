<?php

namespace Modules\User\Http\Controllers;
use Carbon\Carbon;
use Modules\User\DataTables\RolesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;
use Illuminate\Support\Str;



class RolesController extends Controller
{



  public function __construct()
    {
        // Page Title
        $this->module_title = 'Roles';
        $this->module_name = 'roles';
        $this->module_path = 'roles';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Spatie\Permission\Models\Role";

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
        $$module_name = $module_model::with('permissions')
        ->orderBy('id', 'ASC')
        ->paginate();
        return view(
            "user::roles.index",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_path',
             'module_name_singular', 'module_action')
        );
    }






    public function index_datatable(RolesDataTable $dataTable) {
        abort_if(Gate::denies('access_user_management'), 403);

        return $dataTable->render('user::roles.index');
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

        $$module_name = $module_model::with(['permissions' => function ($query) {
            $query->select('name')->take(15)->get();
        }])->where('name', '!=', 'Super Admin');

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('user::roles.partials.actions',
                            compact('module_name', 'data', 'module_model'));
                                })

                            ->addColumn('permissions', function ($data) {
                                $module_name = $this->module_name;
                                $module_model = $this->module_model;
                                  return view('user::roles.partials.permissions',
                                    compact('module_name', 'data', 'module_model'));
                                })

                              ->editColumn('name', function ($data) {
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
                        ->rawColumns(['updated_at', 'name','permissions', 'action'])
                        ->make(true);
    }




    public function create() {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::roles.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        $role->givePermissionTo($request->permissions);

        toast('Role Created With Selected Permissions!', 'success');

        return redirect()->route('roles.index');
    }


    public function edit(Role $role) {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::roles.edit', compact('role'));
    }


    public function update(Request $request, Role $role) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions($request->permissions);

        toast('Role Updated With Selected Permissions!', 'success');

        return redirect()->back();
    }


    public function destroy(Role $role) {
        abort_if(Gate::denies('access_user_management'), 403);

        $role->delete();

        toast('Role Deleted!', 'success');

        return redirect()->route('roles.index');
    }
}
