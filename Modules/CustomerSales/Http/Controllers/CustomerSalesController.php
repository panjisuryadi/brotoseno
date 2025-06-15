<?php

namespace Modules\CustomerSales\Http\Controllers;

use Modules\CustomerSales\DataTables\CustomerSalesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\CustomerSales\Entities\CustomerSales;

class CustomerSalesController extends Controller
{

    public function index(CustomerSalesDataTable $dataTable) {
        abort_if(Gate::denies('access_customersales'), 403);

        return $dataTable->render('customersales::customersales.index');
    }


    public function create() {
        abort_if(Gate::denies('create_customersales'), 403);

        return view('customersales::customersales.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('create_customersales'), 403);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'market'           => 'required|string|max:255',
        ]);

        CustomerSales::create([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'market'           => $request->market,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        toast('CustomerSales Created!', 'success');

        return redirect()->route('customersales.index');
    }


    public function show(CustomerSales $customersale) {
        abort_if(Gate::denies('show_customersales'), 403);

        return view('customersales::customersales.show', compact('customersale'));
    }


    public function edit(CustomerSales $customersale) {
        abort_if(Gate::denies('edit_customersales'), 403);

        return view('customersales::customersales.edit', compact('customersale'));
    }


    public function update(Request $request, CustomerSales $customersale) {
        abort_if(Gate::denies('update_customersales'), 403);

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'market'           => 'required|string|max:255',
     
        ]);

        $customersale->update([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'market'           => $request->market,
            'country'        => $request->country,
            'address'        => $request->address
        ]);

        toast('CustomerSales Updated!', 'info');

        return redirect()->route('customersales.index');
    }


    public function destroy(CustomerSales $customersale) {
        abort_if(Gate::denies('delete_customersales'), 403);

        $customersale->delete();

        toast('CustomerSales Deleted!', 'warning');

        return redirect()->route('customersales.index');
    }
}
