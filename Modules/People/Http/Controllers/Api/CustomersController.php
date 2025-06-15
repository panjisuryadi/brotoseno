<?php

namespace Modules\People\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\People\Entities\Customer;
class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
  
public function index(Request $request)
    {
        try {

            $data = Customer::paginate($request->paginator, ['*'], 'page', $request->page);
            if ($data) {
                return response([
                    'status' => 'success',
                    'code' => 1,
                    'data' => $data
                ], 200);
            } else {
                return response([
                    'status' => 'error',
                    'code' => 0,
                    'data' => "No record found"
                ], 404);
            }
         } catch (\Exception $exception) {
            return response([
                'status' => 'error',
                'code' => 0,
                'message' => "Failed to get brands, please try again. {$exception->getMessage()}"
            ], 500);
          }
      }




    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('people::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('people::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('people::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
