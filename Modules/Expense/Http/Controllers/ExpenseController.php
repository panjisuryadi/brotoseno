<?php

namespace Modules\Expense\Http\Controllers;

use App\Models\LookUp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Sale\Entities\Sale;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use App\Http\Livewire\Product\Sales;
use Illuminate\Support\Facades\Gate;
use Modules\Expense\Entities\Expense;
use Illuminate\Contracts\Support\Renderable;
use Modules\Expense\DataTables\ExpensesDataTable;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class ExpenseController extends Controller
{

    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Expenses';
        $this->module_name = 'expense';
        $this->module_path = 'expenses';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Expense\Entities\Expense";

    }

    public function index(ExpensesDataTable $dataTable) {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';

        $data = Expense::get();
        abort_if(Gate::denies('access_expenses'), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon',
            'module_model',
        'data'));
    }

    public function index_data(Request $request)
    {
        $query = Expense::query();

        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('date', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            }
        }
        $data = $query->get();

        return Datatables::of($data)
                            ->addColumn('action', function ($data) {
                                $module_name = $this->module_name;
                                $module_model = $this->module_model;
                                return view("$module_name::expenses.partials.actions",
                                compact('module_name', 'data', 'module_model'));
                            })
                            ->editColumn('date', function ($data) {
                                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm text-gray-800">
                                        ' . tanggal2($data->date) . '</h3>
                                        </div>';
                                    return $tb;
                                })
                            ->editColumn('reference', function ($data) {
                                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-blue-500">
                                        ' .$data->reference . '</h3>
                                        </div>';
                                    return $tb;
                                })
                            ->editColumn('kategori', function ($data) {
                                $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-gray-800">
                                        ' .$data->category->category_name . '</h3>
                                        </div>';
                                    return $tb;
                                })
                            ->editColumn('masuk', function ($data) {
                                $tb = '<h3 class="text-sm font-medium text-gray-800">
                                        ' .format_uang($data->amount) . '</h3>';
                                    return $tb;
                                })
                            ->editColumn('keluar', function ($data) {
                                $tb = '<h3 class="text-sm font-medium text-gray-800">
                                        ' . format_uang($data->amount_out) . '</h3>';
                                    return $tb;
                                })
                            ->editColumn('detail', function ($data) {
                                $tb = '
                                        <h3 class="text-xs text-gray-800">
                                        ' .$data->details . '</h3>
                                        ';
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
                        ->rawColumns(['updated_at', 'action', 'type', 'date', 'reference', 'kategori', 'masuk', 'keluar', 'detail'])
                        ->make(true);

    }


    public function create() {
        abort_if(Gate::denies('create_expenses'), 403);
        $data = [
            'id_kategori_dp' => LookUp::where('kode','id_kategori_dp')->value('value'),
        ];
        return view('expense::expenses.create', $data);
    }


    public function store(Request $request) {
        abort_if(Gate::denies('create_expenses'), 403);

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'category_id' => 'required',
            'amount' => 'required_without:amount_out',
            'amount_out' => 'required_without:amount',
            'details' => 'nullable|string|max:1000'
        ]);

        Expense::create([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'amount_out' => $request->amount_out,
            'sale_id' => $request->sale_id,
            'details' => $request->details
        ]);

        if(!empty($request->sale_id)) {
            $sale =  Sale::find($request->sale_id);
            $sale->status = Sale::S_COMPLETED;
            $sale->save();
        }

        toast('Expense Created!', 'success');

        return redirect()->route('expenses.index');
    }


    public function edit(Expense $expense) {
        abort_if(Gate::denies('edit_expenses'), 403);

        return view('expense::expenses.edit', compact('expense'));
    }


    public function update(Request $request, Expense $expense) {
        abort_if(Gate::denies('edit_expenses'), 403);

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'category_id' => 'required',
            'amount' => 'required|numeric|max:2147483647',
            'details' => 'nullable|string|max:1000'
        ]);

        $expense->update([
            'date' => $request->date,
            'reference' => $request->reference,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'sale_id' => $request->sale_id,
            'details' => $request->details
        ]);

        toast('Expense Updated!', 'info');

        return redirect()->route('expenses.index');
    }


    public function destroy(Expense $expense) {
        abort_if(Gate::denies('delete_expenses'), 403);

        $expense->delete();

        toast('Expense Deleted!', 'warning');

        return redirect()->route('expenses.index');
    }
}
