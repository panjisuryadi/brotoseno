@extends('layouts.app')

@section('title', 'Create Supplier')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                  
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                    <div class="flex flex-row grid grid-cols-2 gap-2">
                        <div class="p-1">
                            <div class="form-group">
                                <label class="mb-1" for="supplier_name">{{__('Supplier Name')}}  <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{__('Supplier Name')}}" class="form-control" name="supplier_name" required>
                            </div>

                               <div class="form-group">
                                        <label class="mb-1"  for="toko">{{__('Store')}}  <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{__('Store')}}" class="form-control" name="toko" required>
                                    </div>
                             <div class="form-group">
                                <label class="mb-1" for="supplier_email">Email
                                    <span class="small text-danger">(Boleh dikosongkan)</span></label>
                                <input type="email" placeholder="{{__('Email')}}" class="form-control" name="supplier_email" >
                            </div>

                              <div class="form-group">
                                        <label class="mb-1"  for="city">{{__('City')}}  <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{__('City')}}" class="form-control" name="city" required>
                                    </div>  

                                    
                        </div>


                        <div class="p-1">
                           

                                 <div class="form-group">
                                        <label class="mb-1" for="supplier_phone">{{__('Phone')}} <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control" name="supplier_phone" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="mb-1" for="address">{{__('Address')}} <span class="text-danger">*</span></label>
                                        
                                        <textarea rows="5" name="address" class="form-control"></textarea>
                                    </div>


                        </div>


                    </div>


<div class="flex justify-between px-3 pb-2 py-2 border-top">
    <div></div>
    <div class="form-group">
        <button class="btn btn-primary">Create Supplier <i class="bi bi-check"></i></button>
    </div>
</div>
                    
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

