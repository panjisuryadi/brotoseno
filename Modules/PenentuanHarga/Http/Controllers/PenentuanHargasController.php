<?php

namespace Modules\PenentuanHarga\Http\Controllers;
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
use Modules\PenentuanHarga\Models\PenentuanHarga;
use Modules\PenentuanHarga\Models\HistoryPenentuanHarga;
use Lang;
use Image;

class PenentuanHargasController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Penentuan Harga';
        $this->module_name = 'penentuanharga';
        $this->module_path = 'penentuanhargas';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\PenentuanHarga\Models\PenentuanHarga";
        $this->karat_model = "Modules\Karat\Models\Karat";

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

        $$module_name = $module_model::whereRelation('karat','parent_id',null)->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })

                          ->editColumn('tgl_update', function ($data) {
                             $tb = '<div class="text-left">
                                     ' .tgl($data->updated_at) . '
                                    </div>';
                                return $tb;
                            })
                           ->editColumn('user', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->user->name . '
                                    </div>';
                                return $tb;
                            })

          ->editColumn('karat', function ($data) {
             $tb = '<div class="items-center text-center font-semibold">
                     ' .$data->karat->label . '
                    </div>';
                return $tb;
            })

            ->editColumn('harga_emas', function ($data) {
                    $tb = '<div class="items-center text-center">
                    Harga Emas : ' .rupiah($data->harga_emas) . '
                            </div>';
                    $tb .= '<div class="items-center text-center">
                    Harga Modal :' .rupiah($data->harga_modal) . '
                        </div>';


                                return $tb;
                            })

                             ->editColumn('harga_modal', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .rupiah($data->harga_modal) . '
                                    </div>';
                                return $tb;
                            })
                             ->editColumn('margin', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .rupiah($data->margin) . '
                                    </div>';
                                return $tb;
                            })

                             ->editColumn('harga_jual', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .rupiah($data->harga_jual) . '
                                    </div>';
                                return $tb;
                            })


                           ->addColumn('lock', function ($data) {
                            $module_path = $this->module_path;
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view(''.$module_name.'::'.$module_path.'.status',
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


                        ->rawColumns(['tgl_update',
                                        'action',
                                        'harga_emas',
                                        'margin',
                                        'harga_modal',
                                        'karat',
                                        'lock',
                                        'harga_jual',

                                        'user'])
                        ->make(true);
                     }





public function index_setting(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
       // $$module_name = $module_model::get();
       // $data = $$module_name;
        $list_karat = Karat::with('list_harga')->where('parent_id', null)
                  ->get();

        return Datatables::of($list_karat)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('tgl_update', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->list_harga . '
                                    </div>';
                                return $tb;
                            })
                          //  ->editColumn('user', function ($data) {
                          //    $tb = '<div class="items-center text-center">
                          //            ' .$data->user->name . '
                          //           </div>';
                          //       return $tb;
                          //   })

                          ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->list_harga . '
                                    </div>';
                                return $tb;
                            })

                          //    ->editColumn('harga_emas', function ($data) {
                          //    $tb = '<div class="items-center text-center">
                          //            ' .rupiah($data->harga_emas) . '
                          //           </div>';
                          //       return $tb;
                          //   })

                          //    ->editColumn('harga_modal', function ($data) {
                          //    $tb = '<div class="items-center text-center">
                          //            ' .rupiah($data->harga_modal) . '
                          //           </div>';
                          //       return $tb;
                          //   })
                          //    ->editColumn('margin', function ($data) {
                          //    $tb = '<div class="items-center text-center">
                          //            ' .rupiah($data->margin) . '
                          //           </div>';
                          //       return $tb;
                          //   })

                          //    ->editColumn('harga_jual', function ($data) {
                          //    $tb = '<div class="items-center text-center">
                          //            ' .rupiah($data->harga_jual) . '
                          //           </div>';
                          //       return $tb;
                          //   })

                          ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->kode . '
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
                        ->rawColumns(['tgl_update',
                                        'action',
                                        'harga_emas',
                                        'margin',
                                        'harga_modal',
                                        'karat',
                                        'harga_jual',
                                        'karat',
                                        'user'])
                        ->make(true);
                     }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
        public function setting()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Setting';
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.setting',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
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
         abort_if(Gate::denies('create_penentuanharga'), 403);
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
         toast(''. $module_title.' Created!', 'success');
         return redirect()->route(''.$module_name.'.index');
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
        $validator = \Validator::make($request->all(),[
             'code' => 'required|max:191|unique:'.$module_model.',code',
             'name' => 'required|max:191',

        ]);
        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $input['code'] = $input['code'];
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
        $detail = $module_model::with('karat','history')->findOrFail($id);
        $history = HistoryPenentuanHarga::where('penentuan_harga_id',$id)->first();

          return view(''.$module_name.'::'.$module_path.'.modal.edit',
           compact('module_name',
            'module_action',
            'detail',
            'history',
            'module_title',
            'module_icon', 'module_model'));

          }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */




    public function update_old(Request $request, $id)
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
            'harga_emas' => 'required',
                 ]);
        $params = $request->except('_token');
        $price = $params['harga_emas'] / $$module_name_singular->karat->coef;
        $params['harga_modal'] = $params['harga_modal'];
        $params['margin'] = $params['margin'];
        $params['harga_emas'] = $price;

      //  dd($params);

        $$module_name_singular->update($params);
         toast(''. $module_title.' Updated!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }




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

            'harga_emas' => 'required|max:191',


        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $params = $request->except('_token');
        $params['harga_emas'] = preg_replace("/[^0-9]/", "", $params['harga_emas']);
        $params['margin'] = preg_replace("/[^0-9]/", "", $params['margin']);
        $price = $params['harga_emas']*$$module_name_singular->karat->coef;
        $params['harga_modal'] =$price;
        $params['margin'] = $params['margin'];
        $params['harga_emas'] = $params['harga_emas'];
        $params['harga_jual'] = $params['harga_modal']+$params['margin'];

        if ($params['margin']) {
            $params['harga_jual'] = $params['harga_modal']+$params['margin'];
        } else {
           $params['harga_jual'] = $params['harga_modal'];
        }

        $$module_name_singular->update($params);
        $idph       = $$module_name_singular->id;
        $karat   = $$module_name_singular->karat_id;
        $this->_saveHistoryPenentuanHarga($params ,$idph,$karat);

        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

        }




    private function _saveHistoryPenentuanHarga($params ,$idph,$karat)
    {

        HistoryPenentuanHarga::where('penentuan_harga_id', $idph)->update(['updated' => '0']);
       $insert =  HistoryPenentuanHarga::create([
            'penentuan_harga_id' => $idph,
            'karat_id'           => $karat,
            'tanggal'            => date('Y-m-d H:i:s'),
            'harga_emas'         => $params['harga_emas'],
            'harga_modal'        => $params['harga_modal'],
            'harga_jual'         => $params['harga_jual'],
            'margin'             => $params['margin'],
            'updated'            => 1,
            'user_id'            => auth()->user()->id,
            'created_by'         => auth()->user()->name
         ]);
        // dd($input);
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
