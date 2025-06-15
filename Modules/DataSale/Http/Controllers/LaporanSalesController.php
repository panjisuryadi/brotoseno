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

class LaporanSalesController extends Controller
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


   public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
         return view(''.$module_name.'::'.$module_path.'.laporan.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }

}
